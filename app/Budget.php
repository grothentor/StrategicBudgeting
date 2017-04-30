<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    protected $dates = ['created_at', 'updated_at'];
    protected $guarded = ['id'];
    public static $validateRules = [
        'name' => 'required',
    ];

    public function subdivision() {
        return $this->belongsTo(Subdivision::class);
    }

    public function budgetValues() {
        return $this->hasMany(BudgetValue::class);
    }

    public function scopeDefault($query, $subdivision) {
        return $query->where('subdivision_id', $subdivision->id);
    }
}
