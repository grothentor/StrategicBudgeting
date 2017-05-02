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
        'use_length' => 'nullable|integer',
        'pay_at_end' => 'boolean',
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

    public function getPaysByMonths() {
        $budgetTemplate = Budget::getMonthsArray();
        switch($this->periodicity) {
            case 'once':
                $budgetTemplate[1 + $this->offset] = $this->value;
                return $budgetTemplate;
            case 'monthly':
                $periodLength = 1;
                break;
            case 'quarterly':
                $periodLength = 3;
                break;
            case 'annually':
                $periodLength = 12;
                break;
            default:
                throw(new \Exception('Unrecognized budget value Periodicity'));
                break;
        }

        $period = 0;
        $offset = $this->offset * $periodLength + ($this->pay_at_end ? $periodLength - 1 : 0) + 1;
        $use_length = $this->use_length ?? count($budgetTemplate) - $offset + 1;
        do {
            $budgetTemplate[$offset + $period * $periodLength] = $this->value;
            $period++;
        } while ($period < $use_length && $offset + $period * $periodLength <= count($budgetTemplate));
        return $budgetTemplate;
    }
}
