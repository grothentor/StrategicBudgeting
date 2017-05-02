<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BudgetIndicator extends Model
{
    protected $dates = ['created_at', 'updated_at'];
    protected $guarded = ['id'];

    public static $validateRules = [
        'name' => 'required',
        'type' => 'required'
    ];

    public static function getAllForValues() {
        $budgetIndicators = self::query()->pluck('name', 'id')->toArray();
        $budgetTemplate = Budget::getMonthsArray();

        foreach ($budgetIndicators as $key => &$budgetIndicator) {
            $budgetIndicators[$key] = [
                'name' => $budgetIndicator,
                'values' => $budgetTemplate,
            ];
        }
        return $budgetIndicators;
    }
}
