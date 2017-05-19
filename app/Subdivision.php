<?php

namespace App;

class Subdivision extends CustomModel
{
    protected $dates = ['created_at', 'updated_at'];
    protected $guarded = ['id'];
    public static $validateRules = [
        'name' => 'required'
    ];

    public function company() {
        return $this->belongsTo(Company::class);
    }

    public function budgets() {
        return $this->hasMany(Budget::class);
    }

    public function scopeDefault($query) {
        return $query->where('company_id', auth()->user()->id);
    }
}
