<?php

namespace App\Http\Controllers;

use App\Subdivision;
use Illuminate\Http\Request;

class SubdivisionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('subdivisions.index', ['subdivisions' => Subdivision::query()->default()->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('subdivisions.create');
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
        $this->validate($request, Subdivision::$validateRules);
        $fields = $request->all();
        $fields['company_id'] = $company->id;
        $subdivision = Subdivision::query()->create($fields);

        session()->flash('flash_message', "Подразделение \"$subdivision->name\" было создано");

        return redirect('/subdivisions');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Subdivision  $subdivision
     * @return \Illuminate\Http\Response
     */
    public function show(Subdivision $subdivision)
    {
        return view('subdivisions.show', ['subdivision' => $subdivision]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subdivision  $subdivision
     * @return \Illuminate\Http\Response
     */
    public function edit(Subdivision $subdivision)
    {
        return view('subdivisions.edit', ['subdivision' => $subdivision]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subdivision  $subdivision
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subdivision $subdivision)
    {
        $company = auth()->user();
        $this->validate($request, Subdivision::$validateRules);
        $fields = $request->all();
        $fields['company_id'] = $company->id;
        $subdivision->fill($fields)->save();

        session()->flash('flash_message', "Подразделение \"$subdivision->name\" было обновлено");

        return redirect('/subdivisions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subdivision  $subdivision
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subdivision $subdivision)
    {
        try {
            $name = $subdivision->name;
            $subdivision->delete();
            session()->flash('flash_message', "Подразделение $name удалено");
        } catch (\Exception $e){
            session()->flash('flash_message', "Подразделение $subdivision->name не может быть удалено");
            return back();
        }
        return redirect('/subdivisions');
    }
}
