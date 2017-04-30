<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BudgetValue extends Model
{
    protected $dates = ['created_at', 'updated_at'];
    protected $guarded = ['id'];
    public static $validateRules = [
        'value' => 'numeric|required',
        'budget_indicator_id' => 'integer|required',
        'offset' => 'required|integer',
        'periodicity' => 'required',
        'use_length' => 'integer',
    ];

    public function budget() {
        return $this->belongsTo(Budget::class);
    }

    public function budgetIndicator() {
        return $this->belongsTo(BudgetIndicator::class);
    }

    public function scopeDefault($query, $budget) {
        return $query->where('budget_id', $budget->id);
    }
}
