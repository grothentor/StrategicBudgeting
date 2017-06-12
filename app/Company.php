<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Company extends Authenticatable
{
    protected $dates = ['created_at', 'updated_at'];
    protected $guarded = ['id'];

    public static $validateRules = [
        'email' => 'required|email',
        'password' => 'required',
        'name' => 'required',
        'tax' => 'required|numeric|min:0|max:1',
        'budget' => 'required|numeric|min:0',
    ];

    public static $kpiFields = [
        'tax' => 'Налог',
        'budget' => 'Личные средства предприятия'
    ];

    public function kpis() {
        return $this->belongsToMany(Kpi::class, 'companies_kpi')
            ->withPivot(['target_value', 'importance']);
    }

    public function subdivisions() {
        return $this->hasMany(Subdivision::class);
    }

    public function compares() {
        return $this->hasMany(Compare::class);
    }
}
