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
     * @param bool $byYear
     * @return array
     */
    public function calculateBudget($groupByPeriod = false, $byYear = false) {
        $budgetIndicators = budgetIndicator::getAllForValues();
        $budgetMonths = Budget::getMonthsArray(
            BudgetIndicator::query()->pluck('id', 'id')->map(function () { return 0; })->toArray(),
            $byYear ? 3 : 36
        );
        foreach ($this->budgetValues as $budgetValue) {
            $paysByMonths = $budgetValue->getPaysByMonths();
            foreach ($budgetIndicators[$budgetValue->budget_indicator_id]['values'] as $month => &$oldValue) {
                $period = $byYear ? (int)(($month - 1) / 12 ) + 1 : $month;
                $budgetMonths[$period][$budgetValue->budget_indicator_id] +=  $paysByMonths[$month];
                $oldValue += $paysByMonths[$month];
            }
        }
        if ($groupByPeriod) return $budgetMonths;
        return $budgetIndicators;
    }

    public static function getMonthsArray($value = 0, $monthCount = 36) {
        $budgetTemplate = array_fill(1, $monthCount, $value);
        return $budgetTemplate;
    }

    public function getIsCurrentAttribute() {
        return 'current' === $this->type;
    }
}
