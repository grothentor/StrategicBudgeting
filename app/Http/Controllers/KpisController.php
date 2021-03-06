<?php

namespace App\Http\Controllers;

use App\CompaniesKpi;
use App\Kpi;
use Illuminate\Http\Request;

class KpisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('kpis.index', ['kpis' => Kpi::query()->default()->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('kpis.create');
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
        $this->validate($request, Kpi::$validateRules);
        $fields = $request->all();
        $companyTargetValue = $fields['companyTargetValue'];
        unset($fields['companyTargetValue']);

        $kpi = Kpi::query()->create($fields);
        CompaniesKpi::query()->create([
            'company_id' => $company->id,
            'kpi_id' => $kpi->id,
            'target_value' => $companyTargetValue
        ]);

        session()->flash('flash_message', __('messages.kpi.created', ['name' => $kpi->name]));

        return redirect('/kpis');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Kpi  $kpi
     * @return \Illuminate\Http\Response
     */
    public function show(Kpi $kpi)
    {
        return view('kpis.show', ['kpi' => $kpi]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Kpi  $kpi
     * @return \Illuminate\Http\Response
     */
    public function edit(Kpi $kpi)
    {
        return view('kpis.edit', ['kpi' => $kpi]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Kpi  $kpi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kpi $kpi)
    {
        $company = auth()->user();
        $this->validate($request, Kpi::$validateRules);
        $fields = $request->all();
        $companyTargetValue = $fields['companyTargetValue'];
        unset($fields['companyTargetValue']);
        $kpi->fill($fields)->save();

        $companyKpi = CompaniesKpi::query()
            ->where('company_id', $company->id)
            ->where('kpi_id', $kpi->id)
            ->first();
        if ($companyKpi) {
            $companyKpi->target_value = $companyTargetValue;
            $companyKpi->save();
        } else {
            CompaniesKpi::query()->create([
                'company_id' => $company->id,
                'kpi_id' => $kpi->id,
                'target_value' => $companyTargetValue
            ]);
        }

        session()->flash('flash_message', __('messages.kpi.updated', ['name' => $kpi->name]));

        return redirect('/kpis');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Kpi  $kpi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kpi $kpi)
    {
        try {
            $name = $kpi->name;
            $kpi->delete();
            session()->flash('flash_message', __('messages.kpi.deleted', ['name' => $kpi->name]));
        } catch (\Exception $e){
            session()->flash('flash_message', __('messages.kpi.cant_delete', ['name' => $kpi->name]));
            return back();
        }
        return redirect('kpis');
    }
}
