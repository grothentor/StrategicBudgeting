<?php

namespace App\Http\Controllers;

use App\CompaniesKpi;
use Illuminate\Http\Request;
use App\Kpi;
use App\Compare;

class ComparesController extends Controller
{
    public function index() {
        return view('compares.index', ['kpis' => Kpi::query()->get()]);
    }

    public function store(Request $request) {
        Compare::saveFromArray($request->compares);
        CompaniesKpi::calculateImportance();
        return redirect('/kpis/compares');
    }
}
