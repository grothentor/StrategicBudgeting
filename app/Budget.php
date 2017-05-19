<?php

namespace App;

class Budget extends CustomModel
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
        return $query->where('subdivision_id', $subdivision->id)
            ->where('type', '<>', 'current');
    }

    /**
     * calculate Budget values by indicators and by months
     *
     * @return array
     */
    public function calculateBudget() {
        $budgetIndicators = budgetIndicator::getAllForValues();
        $budgetMonths = Budget::getMonthsArray(BudgetIndicator::query()->pluck('name', 'id')->toArray());
        foreach ($this->budgetValues as $budgetValue) {
            $paysByMonths = $budgetValue->getPaysByMonths();
            foreach ($budgetIndicators[$budgetValue->budget_indicator_id]['values'] as $month => &$oldValue) {
                $oldValue += $paysByMonths[$month];
                $budgetMonths[$month][$budgetValue->budget_indicator_id] = $oldValue;
            }
        }
        //dump($budgetMonths);
        return $budgetIndicators;
    }

    public static function getMonthsArray($value = 0) {
        $monthCount = 36; // TODO: calculate from modulation length
        $budgetTemplate = array_fill(1, $monthCount, $value);
        return $budgetTemplate;
    }
}
