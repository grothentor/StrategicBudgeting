<?php
/**
 * Created by PhpStorm.
 * User: Alexandr
 * Date: 04.06.2017
 * Time: 12:50
 */

namespace App;


class Experiment extends CustomModel
{
    protected $guarded = ['id'];

    public static $validateRules = [
        'name' => 'required|max:150',
        'date' => 'date'
    ];

    public function company() {
        return $this->belongsTo(Kpi::class);
    }

    public function budgets() {
        return $this->belongsToMany(Budget::class,'experiment_budget')->withPivot('use');
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
}