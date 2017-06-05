<?php
/**
 * Created by PhpStorm.
 * User: Alexandr
 * Date: 04.06.2017
 * Time: 12:58
 */

namespace App\Http\Controllers;
use App\Budget;
use App\CompaniesKpi;
use App\Compare;
use App\Experiment;
use App\ExperimentKpi;
use App\Kpi;
use App\Subdivision;
use Illuminate\Http\Request;

class ExperimentsController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('experiments.index', ['experiments' => Experiment::query()->default()->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('experiments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $company = auth()->user();
        $this->validate($request, Experiment::$validateRules);
        $fields = $request->all();
        $fields['company_id'] = $company->id;

        $experiment = Experiment::query()->create($fields);

        $compares = Compare::query()->where('company_id', $company->id)->get();
        $attach = $compares->mapWithKeys(function ($compare) {
            return [$compare->id => ['value' => $compare->value]];
        });
        $experiment->compares()->sync($attach->all());


        $budgets = Budget::query()->whereHas('subdivision', function ($q) use($company) {
            $q->where('company_id', $company->id);
        })->get();
        $attach = $budgets->mapWithKeys(function ($budget) {
            return [$budget->id => ['use' => 1]];
        });
        $experiment->budgets()->sync($attach->all());

        $companiesKpis = CompaniesKpi::query()
            ->where('company_id', $company->id)
            ->get();
        $attach = $companiesKpis->mapWithKeys(function ($companyKpi) {
            return [$companyKpi->id => [
                'use' => 1,
                'target_value' => $companyKpi->target_value,
                'result_value' => null,
                'importance' => $companyKpi->importance
            ]];
        });
        $experiment->kpis()->sync($attach->all());

        session()->flash('flash_message', "Експеримент $experiment->name был создан");

        return redirect('/experiments');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Experiment  $experiment
     * @return \Illuminate\Http\Response
     */
    public function show(Experiment $experiment)
    {
        $experiment->load('budgets', 'kpis');
        $subdivisions = Subdivision::query()
            ->default()
            ->with('budgets')
            ->get();

        $kpis = Kpi::query()->withoutExperiment($experiment->id)->get();

        return view('experiments.show', [
            'experiment' => $experiment,
            'subdivisions' => $subdivisions,
            'kpis' => $kpis
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Experiment  $experiment
     * @return \Illuminate\Http\Response
     */
    public function edit(Experiment $experiment)
    {
        $experiment->load('budgets', 'kpis');
        $subdivisions = Subdivision::query()
            ->default()
            ->with('budgets')
            ->get();

        $kpis = Kpi::query()->withoutExperiment($experiment->id)->get();

        return view('experiments.edit', [
            'experiment' => $experiment,
            'subdivisions' => $subdivisions,
            'kpis' => $kpis
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Experiment  $experiment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Experiment $experiment)
    {
        $company = auth()->user();
        $this->validate($request, Experiment::$validateRules);
        $fields = $request->all();
        if (!isset($fields['budgets']) || count($fields['budgets']) !== Subdivision::query()->default()->get()->count())
            return back()
                ->withInput()
                ->withErrors(['Каждое подразделение должно иметь хотябы 1 бюджет']);
        $budgetValues = collect($fields['budgets'])->reduce(function($result, $budgets) {
            return $result->merge($budgets);
        }, collect([]));
        $kpis = collect($fields['kpis'])->map(function($kpi) {
            if (!isset($kpi['use'])) $kpi['use'] = 0;
            return $kpi;
        });

        unset($fields['budgets']);
        unset($fields['kpis']);

        $experiment->fill($fields)->save();
        $budgets = Budget::query()->whereHas('subdivision', function ($q) use($company) {
            $q->where('company_id', $company->id);
        })->get();
        $attach = $budgets->mapWithKeys(function ($budget) use ($budgetValues) {
            return [$budget->id => ['use' => false !== $budgetValues->search($budget->id)]];
        });
        $experiment->budgets()->sync($attach->all());

        $experiment->kpis()->sync($kpis->all());
        session()->flash('flash_message', "Експеримент $experiment->name был обновлен");

        return redirect('/experiments');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Experiment  $experiment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Experiment $experiment)
    {
        try {
            $name = $experiment->name;
            $experiment->delete();
            session()->flash('flash_message', "Експеремент $name удален");
        } catch (\Exception $e){
            session()->flash('flash_message', "Експеримент $experiment->name не может быть удален");
            return back();
        }
        return redirect('experiments');
    }

    public function compares(Experiment $experiment) {
        $experiment->load('compares', 'kpis');
        return view('experiments.compares', ['experiment' => $experiment]);
    }

    public function updateCompares(Experiment $experiment) {
        $newCompares = request()->compares;
        $compares = Compare::query()->where('company_id', $experiment->company_id)->get();
        $attach = $compares->mapWithKeys(function ($compare) use ($newCompares) {
            $value = $newCompares[$compare->left_kpi_id][$compare->right_kpi_id];
            return [$compare->id => ['value' => $value]];
        });
        $experiment->compares()->sync($attach->all());

        $compares = $experiment->compares;
        $allIndicators = CompaniesKpi::calculateImportance($compares);
        $allImportance = array_sum($allIndicators);

        foreach ($allIndicators as $kpi_id => $importance) {
            ExperimentKpi::query()->where('experiment_id', $experiment->id)
                ->where('kpi_id', $kpi_id)
                ->update(['importance' => $importance / $allImportance]);
        }
        return redirect("/experiments/$experiment->id/compares");
    }
}