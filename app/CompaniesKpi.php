<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompaniesKpi extends Model
{
    protected $dates = ['created_at', 'updated_at'];
    protected $guarded = ['id'];

    public function scopeDefault($query) {
        return $query->where('company_id', auth()->user()->id);
    }
}
