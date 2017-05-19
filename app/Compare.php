<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;

class Compare extends CustomModel
{
    protected $dates = ['created_at', 'updated_at'];
    protected $guarded = ['id'];
    protected $appends = ['kpiIds'];

    public function company() {
        $this->belongsTo(Company::class);
    }

    public function leftKpi() {
        $this->belongsTo(Kpi::class, 'left_kpi_id');
    }

    public function rightKpi() {
        $this->belongsTo(Kpi::class, 'right_kpi_id');
    }

    public function scopeDefault(Builder $query) {
        return $query->where('company_id', auth()->user()->id);
            //->with(['leftKpi', 'rightKpi']);
    }

    public function getKpiIdsAttribute() {
        return $this->left_kpi_id . $this->right_kpi_id;
    }

    public static function saveFromArray($comparesArray) {
        $compares = Compare::query()->default()->get();
        $oldValues = $compares->pluck('value');
        $oldIds = $compares->pluck('kpi_ids')->toArray();
        $newCompares = [];
        foreach ($comparesArray as $left_id => $compare) {
            foreach ($compare as $right_id => $value) {
                if (false === $key = array_search($left_id . $right_id, $oldIds)) {
                    $newCompares[] = [
                        'company_id' => auth()->user()->id,
                        'left_kpi_id' => $left_id,
                        'right_kpi_id' => $right_id,
                        'value' => $value
                    ];
                } elseif ($value === $oldValues[$key]) continue;
                else {
                    $compares[$key]->value = $value;
                    $compares[$key]->save();
                }
            }
        }
        Compare::insert($newCompares);
    }
}
