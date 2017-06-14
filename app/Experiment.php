<?php
/**
 * Created by PhpStorm.
 * User: Alexandr
 * Date: 04.06.2017
 * Time: 12:50
 */

namespace App;


use Illuminate\Support\Collection;

class Experiment extends CustomModel
{
    protected $guarded = ['id'];

    public static $validateRules = [
        'name' => 'required|max:150',
        'date' => 'date',
        'tax' => 'required|numeric|min:0|max:1',
        'budget' => 'required|numeric|min:0',
    ];

    public static $kpiFields = [
        'tax' => 'Налог',
        'budget' => 'Собственные средства предприятия'
    ];

    public function company() {
        return $this->belongsTo(Company::class);
    }

    public function budgets() {
        return $this->belongsToMany(Budget::class,'experiment_budget')->withPivot('use', 'answer');
    }

    public function compares() {
        return $this->belongsToMany(Compare::class,'experiment_compare')->withPivot('value');
    }

    public function kpis() {
        return $this->belongsToMany(Kpi::class,'experiment_kpi')
            ->withPivot('target_value', 'result_value', 'use', 'importance');
    }

    public function scopeDefault($query) {
        return $query->where('company_id', auth()->user()->id);
    }

    public function calculated(bool $value) {
        $this->calculated = $value;
        $this->save();
    }

    public function answerBudgets(Collection $budgets) {
        $this->budgets->map(function ($budget) use ($budgets) {
            if ($budgets->contains($budget->id)) $budget->pivot->answer = true;
            else $budget->pivot->answer = false;
            $budget->pivot->save();
        });
    }

    public function resultKpis(Collection $kpis) {
        foreach ($kpis as $kpiId => $resultValue) {
            $kpi = $this->kpis->first(function($kpi) use($kpiId) { return $kpiId === $kpi->id; });
            $kpi->pivot->result_value = $resultValue;
            if (isset($kpi->startValue)) unset($kpi->startValue);
            if (isset($kpi->koef)) unset($kpi->koef);
            $kpi->pivot->save();
        }
    }
}