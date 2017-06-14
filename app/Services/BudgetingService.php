<?php

namespace App\Services;

use App\BudgetIndicator;
use App\Experiment;
use Illuminate\Support\Collection;

class BudgetingService
{
    private $kpis = null;
    private $subdivisions = null;
    private $experiment = null;
    private $currentBudget = null;
    private $incomeValues = null;

public function calculate(Experiment $experiment) {
    $this->experiment = $experiment;
    $this->subdivisions = $this->getSubdivisionsBudgets();
    $this->kpis = $this->getKpis();
    $budgetsVariants = $this->subdivisionVariants();

    $result = collect([]);
    for ($budgetIndex = 0; $budgetIndex < $budgetsVariants->count(); $budgetIndex++) {
        if (false === $targetValue = $this->calculateTargetValue($budgetsVariants[$budgetIndex])) {
            $level = $this->isFirstBudget($budgetsVariants, $budgetIndex);
            while (++$budgetIndex < $budgetsVariants->count() &&
                $this->isFirstBudget($budgetsVariants, $budgetIndex) !== $level) {}
            $budgetIndex--;
        } else {
            if (!isset($result['targetValue']) || $result['targetValue'] > $targetValue['result']) {
                $result = collect([
                    'variant' => $budgetsVariants[$budgetIndex],
                    'targetValue' => $targetValue['result'],
                    'kpisValues' => $targetValue['kpisValues'],
                ]);
            }
        }
    }

    if (!$result->count()) return back()->withErrors('Задача не имеет решения. На использование заданных бюджетов не хватает средств. Добавьте реальные бюджеты');
    $experiment->answerBudgets($result['variant']);
    $experiment->resultKpis($result['kpisValues']);
    $experiment->calculated(true);
}

    public function calculateKpis($experiment, $subdivisions) {
        $budgets = collect();
        $currentBudget = $subdivisions->reduce(function ($result, $subdivision) {
            $currentBudget = $subdivision->budgets->first(function ($budget) { return 'current' === $budget->type; })
                ->calculateBudget(true, true)[1];
            if (!count($result)) $result = $currentBudget;
            else $this->sumArrays($result, $currentBudget);
            return $result;
        }, []);
        $budgetTemplate = collect([
            'values' => $currentBudget,
            'penultValue' => $currentBudget,
            'money' => $this->calculateMoney($currentBudget) + $experiment->budget,
            'penultMoney' => $this->calculateMoney($currentBudget) + $experiment->budget,
            'tax' => $experiment->tax
        ]);
        for ($year = 0; $year <= 3; $year++) {//TODO:: use global years count here
            $budgets[$year] = clone $budgetTemplate;
            if (0 === $year) {
                $budgets[$year]['penultValue'] = array_fill_keys(array_keys($currentBudget), 0);
                $budgets[$year]['penultMoney'] *= 0.7;
            }
        }

        foreach ($experiment->budgets as $budget) {
            if (!$budget->pivot->answer) continue;
            $byYear = $budget->calculateBudget(true, true);

            foreach ($byYear as $year => $yearValues) {
                $money = $this->calculateMoney($yearValues);
                for ($localYear = $year; $localYear <= count($byYear); $localYear++) {
                    $subdivisionBudget = $budgets[$localYear]['values'];
                    $this->sumArrays($subdivisionBudget, $yearValues);
                    $budgets[$localYear]['values'] = $subdivisionBudget;
                    $budgets[$localYear]['money'] += $money;
                    if ($localYear < count($byYear)) {
                        $budgets[$localYear + 1]['penultValue'] = $budgets[$localYear]['values'];
                        $budgets[$localYear + 1]['penultMoney'] = $budgets[$localYear]['money'];
                    }
                }
            }
        }
        $kpis = collect();

        foreach ($experiment->kpis as $kpi) {
            if (!$kpi->pivot->use || null === $kpi->pivot->result_value) continue;
            $kpis[$kpi->id] = collect([
                'name' => $kpi->name,
                'targetValue' => $kpi->pivot->target_value,
                'values' => collect(),
            ]);
            foreach ($budgets as $year => $budget) {
                $kpiValue = $kpi->calculateValue($budget->all());
                $kpis[$kpi->id]['values']->push($kpiValue);
            }
        }
        return $kpis;
    }

    public function subdivisionVariants($depth = 0, Collection $result = null) {
        if (null === $result) {
            $index = 0;
            $newResult = $this->subdivisions[$depth]['budgets']->mapWithKeys(function($budget) use(&$index) {
                return collect([$index++ => collect($budget['id'])]);
            });
            return $this->subdivisionVariants($depth + 1, $newResult);
        }
        $newResult = collect([]);
        foreach ($this->subdivisions[$depth]['budgets'] as $budget) {
            $newResult = $newResult->merge($result->map(function($resultArray) use($budget) {
                return $resultArray->merge($budget['id']);
            }));
        }
        if ($this->subdivisions->count() - 1 === $depth) return $newResult;
        return $this->subdivisionVariants($depth + 1, $newResult);
    }

    public function getLastValue(Experiment $experiment) {
        $lastValue = [];
        $penultValue = [];
        foreach ($experiment->budgets as $budget) {
            $byYear = $budget->calculateBudget(true, true);
            foreach ($byYear as $year => $yearValues) {
                if (1 === $year) {
                    $lastValue[$budget->id] = $yearValues;
                    $penultValue[$budget->id] = array_fill_keys(array_keys($yearValues), 0);
                    if ($budget->isCurrent) break;
                } else {
                    if (count($byYear) == $year) $penultValue[$budget->id] = $lastValue[$budget->id];
                    $this->sumArrays($lastValue[$budget->id], $yearValues);
                }
            }
        }

        return ['lastValue' => $lastValue, 'penultValue' => $penultValue];
    }

    private function getSubdivisionsBudgets() {
        $budgets = $this->getLastValue($this->experiment);
        $budgetIndicators = BudgetIndicator::query()->get();
        $incomeValues = $budgetIndicators->mapWithKeys(function ($budgetIndicator) {
            return [$budgetIndicator->id => 'income' === $budgetIndicator->type ? 1 :
                ('expense' === $budgetIndicator->type ? -1 : 0)];
        });
        $budgetMoney = array_fill_keys(array_keys($budgets['lastValue']), 0);
        $budgetMoney = [
            'lastMoney' => $budgetMoney,
            'penultMoney' => $budgetMoney,
        ];
        foreach ($budgets['lastValue'] as $budgetId => $yearValues) {
            $budgetMoney['lastMoney'][$budgetId] += $this->calculateMoney($yearValues);
            $budgetMoney['penultMoney'][$budgetId] += $this->calculateMoney($budgets['penultValue'][$budgetId]);
        }

        return $this->experiment->company->subdivisions->map(function ($subdivision) use ($budgetMoney, $budgets) {
            $currentBudgetId = $subdivision->budgets->first(function ($budget) { return 'current' === $budget->type; })->id;
            $subdivisionBudgets = $subdivision->budgets
                ->mapWithKeys(function ($budget) use($budgets, $budgetMoney) {
                    return collect([
                        $budget->id => [
                            'id' => $budget->id,
                            'name' => $budget->name,
                            'values' => $budgets['lastValue'][$budget->id],
                            'penultValue' => $budgets['penultValue'][$budget->id],
                            'money' => $budgetMoney['lastMoney'][$budget->id],
                            'penultMoney' => $budgetMoney['penultMoney'][$budget->id],
                        ]
                    ]);
                });
            return [
                'id' => $subdivision->id,
                'name' => $subdivision->name,
                'current' => $subdivisionBudgets[$currentBudgetId],
                'budgets' => $subdivisionBudgets->filter(function($budget) use($currentBudgetId) {
                    return $currentBudgetId !== $budget['id'];
                })
                    ->sortByDesc('money')
            ];
        });
    }

    private function getKpis() {
        $kpis = $this->experiment->kpis->filter(function ($kpi) {
            return $kpi->pivot->use;
        });
        $importance = $kpis->reduce(function ($result, &$kpi) {
            return $result + $kpi->pivot->importance;
        }, 0);
        if (abs($importance - 1) > config('app.currency')) return back()->withErrors('Обновите значения приоритетов KPI');
        $this->currentBudget = $this->subdivisions->reduce(function ($result, $subdivision) {
            if (!count($result['values'])) {
                $result['values'] = $subdivision['current']['values'];
                $result['penultValue'] = $subdivision['current']['penultValue'];
            } else {
                $this->sumArrays($result['values'], $subdivision['current']['values']);
                $this->sumArrays($result['penultValue'], $subdivision['current']['penultValue']);
            }
            $result['money'] += $subdivision['current']['money'];
            return $result;
        }, [
            'values' => [],
            'penultValue' => [],
            'money' => $this->experiment->budget,
            'penultMoney' => $this->experiment->budget,
            'tax' => $this->experiment->tax
        ]);

        $kpis->flatMap(function ($kpi) {
            $kpi->startValue = $kpi->calculateValue($this->currentBudget);
            $kpi->koef = $kpi->pivot->importance / pow($kpi->pivot->target_value - $kpi->startValue, 2);
            return $kpi;
        });
        return $kpis;
    }

    private function calculateTargetValue(Collection $variant) {
        $budget = $this->currentBudget;

        /* use same current budget */
        $budget['penultMoney'] = $budget['money'];
        $budget['penultValue'] = $budget['values'];

        foreach ($this->subdivisions as $key => $subdivision) {
            $this->sumArrays($budget['penultValue'], $subdivision['budgets'][$variant[$key]]['penultValue']);
            $this->sumArrays($budget['values'], $subdivision['budgets'][$variant[$key]]['values']);
            $budget['money'] += $subdivision['budgets'][$variant[$key]]['money'];
            $budget['penultMoney'] += $subdivision['budgets'][$variant[$key]]['penultMoney'];
        }
        if ($budget['money'] < 0) return false;
        $resultValue = 0;
        $kpisValues = collect();
        foreach ($this->kpis as $kpi) {
            $kpisValues->put($kpi->id,
                $kpi->calculateValue($budget));
            $resultValue += $kpi->koef * pow(
                    $kpi->pivot->target_value - $kpisValues[$kpi->id],
                    2);
        }

        return collect([
            'result' => $resultValue,
            'kpisValues' => $kpisValues
        ]);
    }

    private function calculateMoney(array $budgets) {
        $budgetIndicators = BudgetIndicator::query()->get();

        if (null === $this->incomeValues) {
            $this->incomeValues = $budgetIndicators->mapWithKeys(function ($budgetIndicator) {
                return [$budgetIndicator->id => 'income' === $budgetIndicator->type ? 1 :
                    ('expense' === $budgetIndicator->type ? -1 : 0)];
            });
        }

        $budgetMoney = 0;
        foreach ($budgets as $budgetIndicatorId => $money) {
            $budgetMoney += $this->incomeValues[$budgetIndicatorId] * $money;
        }

        return $budgetMoney;
    }

    private function isFirstBudget($budgetVariants, $budgetIndex) {
        foreach ($budgetVariants[$budgetIndex] as $level => $budgetVariant) {
            $firstBudgetId = $this->subdivisions[$level]['budgets']->first()['id'];
            if ($budgetVariant !== $firstBudgetId) return $level;
        }
        return $level + 1;
    }

    public function sumArrays(&$array1, array ...$array2) {
        foreach ($array2 as $adArray) {
            foreach ($adArray as $key => $value) {
                $array1[$key] += $value;
            }
        }
    }
}