<?php

namespace App\Http\Controllers;

use App\BudgetIndicator;
use App\BudgetValue;
use App\Budget;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;

class BudgetValuesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Budget $budget
     * @return \Illuminate\Http\Response
     */
    public function index(Budget $budget)
    {
        $this->checkAccess($budget);
        return view('budget-values.index', [
            'budgetValues' => BudgetValue::query()->default($budget)->get(),
            'budgetIndicators' => BudgetIndicator::query()->pluck('name', 'id'),
            'budget' => $budget
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Budget $budget
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Budget $budget, Request $request)
    {
        $this->checkAccess($budget);
        $newBudgetValues = $request['new'];
        $deletedBudgetValuesIds = [];

        if (isset($request['old'])) {
            foreach ($request['old'] as $budgetValue) {
                if (isset($budgetValue['deleted'])) {
                    $deletedBudgetValuesIds[] = $budgetValue['id'];
                } elseif ($budgetValue['edited']) {
                    unset ($budgetValue['edited']);
                    $budgetValue['budget_id'] = $budget->id;
                    $validator = Validator::make($budgetValue, BudgetValue::$validateRules);

                    if ($validator->fails()) {
                        return redirect("/budgets/$budget->id/budget-values")
                            ->withErrors($validator)
                            ->withInput();
                    }

                    BudgetValue::query()
                        ->where('id', $budgetValue['id'])
                        ->update($budgetValue);
                }
            }
        }
        if (count($newBudgetValues)) {
            $newBudgetValues = array_map(function ($budgetValue) use ($budget) {
                $budgetValue['budget_id'] = $budget->id;
                $budgetValue['created_at'] = $budgetValue['updated_at'] = Carbon::now();

                return $budgetValue;
            }, $newBudgetValues);
            foreach ($newBudgetValues as $budgetValue) {
                $validator = Validator::make($budgetValue, BudgetValue::$validateRules);

                if ($validator->fails()) {
                    return redirect("/budgets/$budget->id/budget-values")
                        ->withErrors($validator)
                        ->withInput();
                }
            }
            BudgetValue::query()->insert($newBudgetValues);
        }

        if (count($deletedBudgetValuesIds)) {
            BudgetValue::query()->whereIn('id', $deletedBudgetValuesIds)->delete();
        }

        session()->flash('flash_message', 'Изменения сохранены');
        return redirect("/budgets/$budget->id/budget-values");
    }


    /**
     * Check access for operations with budget values
     *
     * @param Budget $budget
     * @param BudgetValue|null $budgetValue
     */
    public function checkAccess(Budget $budget, BudgetValue $budgetValue = null) {
        if ($budget->subdivision->company_id != auth()->user()->id ||
            ($budgetValue && $budgetValue->budget_id != $budget->id)
        ) abort(403);
    }
}
