<?php

namespace App\Http\Controllers;

use App\Budget;
use App\BudgetIndicator;
use App\Subdivision;
use Illuminate\Http\Request;

class BudgetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Subdivision $subdivision
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Subdivision $subdivision)
    {
        $this->checkAccess($subdivision);
        return view('budgets.index', [
            'budgets' => Budget::query()->default($subdivision)->get(),
            'currentBudget' => Budget::query()
                ->where('subdivision_id', $subdivision->id)
                ->where('type', 'current')
                ->with('budgetValues')
                ->first(),
            'budgetIndicators' => BudgetIndicator::query()->pluck('name', 'id'),
            'subdivision' => $subdivision
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Subdivision $subdivision
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Subdivision $subdivision)
    {
        $this->checkAccess($subdivision);
        return view('budgets.create', ['subdivision' => $subdivision]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Subdivision $subdivision
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Subdivision $subdivision, Request $request)
    {
        $this->checkAccess($subdivision);
        $this->validate($request, Budget::$validateRules);
        $fields = $request->all();
        $fields['subdivision_id'] = $subdivision->id;
        $budget = Budget::query()->create($fields);

        session()->flash('flash_message', "Бюджет $budget->name подразделения \"$subdivision->name\" создан");

        return redirect("/budgets/$budget->id/budget-values");
    }

    /**
     * Display the specified resource.
     *
     * @param Subdivision $subdivision
     * @param Budget $budget
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Subdivision $subdivision, Budget $budget)
    {
        $this->checkAccess($subdivision, $budget);
        return view('budgets.show', [
            'subdivision' => $subdivision,
            'budgetIndicators' => BudgetIndicator::query()->pluck('name', 'id'),
            'budget' => $budget
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Subdivision $subdivision
     * @param Budget $budget
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Subdivision $subdivision, Budget $budget)
    {
        $this->checkAccess($subdivision, $budget);
        return view('budgets.edit', [
            'subdivisions' => $subdivision,
            'budget' => $budget
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Subdivision $subdivision
     * @param Request $request
     * @param Budget $budget
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Subdivision $subdivision, Request $request, Budget $budget)
    {
        $this->checkAccess($subdivision, $budget);
        $this->validate($request, Budget::$validateRules);
        $fields = $request->all();
        $fields['subdivision_id'] = $subdivision->id;
        $budget->fill($fields)->save();

        session()->flash('flash_message', "Бюджет $budget->name подразделения \"$subdivision->name\" обновлен");

        return redirect("/subdivisions/$subdivision->id/budgets");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Subdivision $subdivision
     * @param Budget $budget
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Subdivision $subdivision, Budget $budget)
    {
        $this->checkAccess($subdivision, $budget);
        try {
            $name = $budget->name;
            $budget->delete();
            session()->flash('flash_message', "Бюджет $name подразделения \"$subdivision->name\" удален");
        } catch (\Exception $e){
            session()->flash('flash_message', "Бюджет $name подразделения \"$subdivision->name\" не может быть удален");
            return back();
        }
        return redirect("/subdivisions/$subdivision->id/budgets");
    }

    /**
     * Check access for operations with budgets
     *
     * @param Subdivision $subdivision
     * @param Budget|null $budget
     */
    public function checkAccess(Subdivision $subdivision, Budget $budget = null) {
        if ($subdivision->company_id != auth()->user()->id ||
            ($budget && $budget->subdivision_id != $subdivision->id)
        ) abort(403);
    }
}
