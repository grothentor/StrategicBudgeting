<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BudgetIndicator extends Model
{
    protected $dates = ['created_at', 'updated_at'];
    protected $guarded = ['id'];
}
