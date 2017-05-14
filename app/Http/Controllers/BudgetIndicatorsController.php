<?php

namespace App\Http\Controllers;

use App\BudgetIndicator;
use Illuminate\Http\Request;

class BudgetIndicatorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('budget-indicators.index', ['budgetIndicators' => BudgetIndicator::query()->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('budget-indicators.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, BudgetIndicator::$validateRules);
        $budgetIndicator = BudgetIndicator::query()->create($request->all());

        session()->flash('flash_message', "Показатель бюджета \"$budgetIndicator->name\" был создан");

        return redirect('/budget-indicators');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BudgetIndicator  $budgetIndicator
     * @return \Illuminate\Http\Response
     */
    public function show(BudgetIndicator $budgetIndicator)
    {
        return view('budget-indicators.show', ['budgetIndicator' => $budgetIndicator]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BudgetIndicator  $budgetIndicator
     * @return \Illuminate\Http\Response
     */
    public function edit(BudgetIndicator $budgetIndicator)
    {
        return view('budget-indicators.edit', ['budgetIndicator' => $budgetIndicator]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BudgetIndicator  $budgetIndicator
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BudgetIndicator $budgetIndicator)
    {
        $this->validate($request, BudgetIndicator::$validateRules);
        $budgetIndicator->fill($request->all())->save();

        session()->flash('flash_message', "Показатель бюджета \"$budgetIndicator->name\" был обновлен");

        return redirect('/budget-indicators');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BudgetIndicator  $budgetIndicator
     * @return \Illuminate\Http\Response
     */
    public function destroy(BudgetIndicator $budgetIndicator)
    {
        try {
            $name = $budgetIndicator->name;
            $budgetIndicator->delete();
            session()->flash('flash_message', "Показатель бюджета $name удален");
        } catch (\Exception $e){
            session()->flash('flash_message', "Показатель бюджета $budgetIndicator->name не может быть удален");
            return back();
        }
        return redirect('/budget-indicators');
    }
}
