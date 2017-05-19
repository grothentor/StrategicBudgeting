<?php

namespace App;

class Transformation extends CustomModel
{
    protected $dates = ['created_at', 'updated_at'];
    protected $guarded = ['id'];

    public function leftBudgetIndicator() {
        return $this->belongsTo(BudgetIndicator::class);
    }

    public function rightBudgetIndicator() {
        return $this->belongsTo(BudgetIndicator::class);
    }

    public function leftTransformation() {
        return $this->belongsTo(self::class);
    }

    public function rightTransformation() {
        return $this->belongsTo(self::class);
    }
}