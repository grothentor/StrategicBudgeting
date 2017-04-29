<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kpi extends Model
{
    protected $dates = ['created_at', 'updated_at'];
    protected $guarded = ['id'];
}
