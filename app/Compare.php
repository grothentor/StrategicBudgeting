<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Compare extends Model
{
    protected $dates = ['created_at', 'updated_at'];
    protected $guarded = ['id'];

    public function company() {
        $this->belongsTo(Company::class);
    }

    public function leftKpi() {
        $this->belongsTo(Kpi::class);
    }

    public function rightKpi() {
        $this->belongsTo(Kpi::class);
    }
}
