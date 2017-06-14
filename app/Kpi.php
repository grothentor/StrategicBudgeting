<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;

class Kpi extends CustomModel
{
    protected $dates = ['created_at', 'updated_at'];
    protected $guarded = ['id'];
    protected $appends = ['companyTargetValue', 'companyImportance']; //TODO: pivot here

    private $transformationFunction = '';

    public static $validateRules = [
        'name' => 'required',
        'holding_target_value' => 'required|numeric',
        'companyTargetValue' => 'required|numeric',
    ];

    public function transformations() {
        return $this->hasMany(Transformation::class);
    }

    public function compares() {
        return $this->hasMany(Compare::class, 'left_kpi_id');
    }

    public function companies() {
        return $this->belongsToMany(Company::class, 'companies_kpis')
            ->withPivot('target_value', 'importance');
    }

    public function experiments() {
        return $this->belongsToMany(Experiment::class, 'experiment_kpi')
            ->withPivot('target_value', 'importance', 'use', 'result_value');
    }

    public function getCompanyTargetValueAttribute() {
        $company = CompaniesKpi::query()
            ->default()
            ->where('kpi_id', $this->id)
            ->where('company_id', auth()->user()->id)
            ->first();
        return $company ? $company->target_value : null;
    }

    public function getCompanyImportanceAttribute() {
        $company = CompaniesKpi::query()
            ->default()
            ->where('kpi_id', $this->id)
            ->where('company_id', auth()->user()->id)
            ->first();
        return $company ? $company->importance : null;
    }

    public function scopeDefault($query) {
        return $query;
    }

    public function calculateValue(array $budgetValues) {
        if (isset($budgetValues['penultValues'])) $startValues = $budgetValues['penultValues'];
        else $startValues = array_fill_keys(array_keys($budgetValues['values']), 0);
        $company = [];
        $company['tax'] = $company['startTax'] = $company['endTax'] = $budgetValues['tax'];
        $company['budget'] = $company['endBudget'] = $budgetValues['money'];
        if (isset($budgetValues['penultMoney'])) $company['startBudget'] = $budgetValues['penultMoney'];
        else $company['startBudget'] = 0;
        $budgetValues = $endValues = $budgetValues['values'];

        $transformationFunction = $this->getTransformationFunction();
        try {
            $kpi = eval($transformationFunction);
        } catch (\Exception $exception) {
            $kpi = 9999999999999999;
        }
        return $kpi;
    }

    private function generateTransactionsFunction($budgetVariable = 'budgetValues') {
        $transformations = [];
        foreach($this->transformations as $transformation) {
            $right = $this->getTransformationValue('right', $transformation, $transformations, $budgetVariable);
            $left = $this->getTransformationValue('left', $transformation, $transformations, $budgetVariable);
            if ($left === $right && '*' != $transformation->operation) { //delta function
                $left = str_replace($budgetVariable, 'endValues', $left);
                $right = str_replace($budgetVariable, 'startValues', $right);
                $left = str_replace("'budget'", '\'endBudget\'', $left);
                $right = str_replace("'budget'", '\'startBudget\'', $right);
            }
            $transformations[$transformation->id] = [
                'value' => "$left $transformation->operation $right",
                'operation' => $transformation->operation,
            ];
        }
        $this->transformationFunction = 'return ' . array_pop($transformations)['value'] . ';';
    }

    private function getTransformationValue(string $side, $transformation, $transformations, $budgetVariable) {
        $sideTransformation = $side . '_transformation_id';
        $sideBudget = $side . '_budget_indicator_id';
        $companyFields = array_keys(Experiment::$kpiFields);

        if ($transformation->$sideTransformation) {
            if (!isset($transformations[$transformation->$sideTransformation]))
                throw new \Exception("bad $side transaction id");
            $value = $transformations[$transformation->$sideTransformation]['value'];
            if (!empty($value)) {
                foreach ($companyFields as $companyField) {
                    $value = str_replace("%$companyField%", "\$company['$companyField']", $value);
                }
            }
            if (in_array($transformation->operation, ['*', '/']) &&
                in_array($transformations[$transformation->$sideTransformation]['operation'], ['+', '-', '/'])) {
                $value = "($value)";
            }
        } elseif ($transformation->$sideBudget) {
            $value = "\${$budgetVariable}[{$transformation->$sideBudget}]";
        } else $value = $transformation->value;

        return $value;
    }

    public function getTransformationFunction($withBudgetIndicators = false) {
        if (empty($this->transformationFunction)) $this->generateTransactionsFunction();
        if (!$withBudgetIndicators) return $this->transformationFunction;
        $budgetIndicators = BudgetIndicator::query()->get();
        $transformationFunction = substr($this->transformationFunction, 6, -1);
        foreach ($budgetIndicators as $budgetIndicator) {
            $budgetName = str_replace(' ', '  ', $budgetIndicator->name);
            $transformationFunction = str_replace(
                '$budgetValues[' . $budgetIndicator->id . ']',
                "\"$budgetName\"",
                $transformationFunction
            );
            $transformationFunction = str_replace(
                '$startValues[' . $budgetIndicator->id . ']',
                "\"$budgetName\"_\"на начало\"",
                $transformationFunction
            );
            $transformationFunction = str_replace(
                '$endValues[' . $budgetIndicator->id . ']',
                "\"$budgetName\"_\"на конец\"",
                $transformationFunction
            );
        }
        foreach (Experiment::$kpiFields as $key => $kpiField) {
            $transformationFunction = str_replace(
                '$company[\'start' . title_case($key) . "']",
                "\"$kpiField\"_\"на начало\"",
                $transformationFunction
            );
            $transformationFunction = str_replace(
                '$company[\'end' . title_case($key) . "']",
                "\"$kpiField\"_\"на конец\"",
                $transformationFunction
            );
            $transformationFunction = str_replace(
                "\$company['$key']",
                "\"$kpiField\"",
                $transformationFunction
            );
        }
        $transformationFunction = str_replace('$startValues',"\"Начало Периода\"", $transformationFunction);
        $transformationFunction = str_replace('$endValues',"'Конец Периода\"'", $transformationFunction);
        return $transformationFunction;
    }

    public function scopeWithoutExperiment(Builder $query, $experimentId) {
        return $query->whereDoesntHave('experiments', function ($q) use ($experimentId) {
                return $q->where('experiment_id', $experimentId);
            });
    }
}
