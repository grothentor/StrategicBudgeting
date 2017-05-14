<?php

namespace App\Http\Controllers\Api;

use App\Company;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Kpi;

class KpiController extends Controller
{
    public function calculate(Request $request, $companyId = null, $budgetValue = null) {
        $budgets = [];
        if (null == $companyId) $budgets = $request->all();
        elseif (null !== $budgetValue) $budgets = [$companyId => $budgetValue];
        if (!count($budgets)) return ['error' => 'you don\'t send data'];
        $companiesIds = array_keys($budgets);
        $companies = Company::query()->whereIn('id', $companiesIds)->pluck('id')->toArray();
        if (count($budgets) !== count($companies)) {
            $diff = array_diff($companiesIds, $companies);
            return ['error' => 'Companies [' . implode(', ', $diff) . '] doe\'s not exist'];
        }

        $companiesKpi = [];
        $kpis = Kpi::query()->pluck('holding_target_value', 'id');
        foreach ($budgets as $companyId => $budgetValue) {
            if (!is_int($companyId)) return ['error' => "$companyId is not integer value"];
            if (!is_numeric($budgetValue)) return ['error' => "$budgetValue is not number"];
            $companiesKpi[$companyId] = [];
            foreach ($kpis as $kpiId => $holdingTarget) {
                $companiesKpi[$companyId][$kpiId] = $holdingTarget * 0.5 +
                    $holdingTarget / ($holdingTarget - 0.01) * log($budgetValue, $holdingTarget / ($kpiId - 0.000001));
            }
        }
        return $companiesKpi;
    }
}