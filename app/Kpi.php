<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kpi extends Model
{
    protected $dates = ['created_at', 'updated_at'];
    protected $guarded = ['id'];
    protected $appends = ['companyTargetValue'];

    public static $validateRules = [
        'name' => 'required',
        'holding_target_value' => 'required|numeric',
        'companyTargetValue' => 'required|numeric',
    ];

    public function transformations() {
        return $this->hasMany(Transformation::class);
    }

    public function getCompanyTargetValueAttribute() {
        return CompaniesKpi::query()
            ->default()
            ->where('kpi_id', $this->id)
            ->where('company_id', auth()->user()->id)
            ->first()
            ->target_value;
    }

    public function scopeDefault($query) {
        return $query;
    }
}
