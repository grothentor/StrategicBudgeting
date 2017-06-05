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

        $compares = Compare::query()->default()->get();
        $allIndicators = CompaniesKpi::calculateImportance($compares);
        $allImportance = array_sum($allIndicators);
        foreach ($allIndicators as $kpi_id => $importance) {
            CompaniesKpi::query()->where('company_id', auth()->user()->id)
                ->where('kpi_id', $kpi_id)
                ->update(['importance' => $importance / $allImportance]);
        }
        return redirect('/kpis/compares');
    }
}
