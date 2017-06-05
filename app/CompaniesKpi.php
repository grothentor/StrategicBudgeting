<?php

namespace App;

class CompaniesKpi extends CustomModel
{
    protected $dates = ['created_at', 'updated_at'];
    protected $guarded = ['id'];

    public function scopeDefault($query) {
        return $query->where('company_id', auth()->user()->id);
    }

    public function kpi() {
        return $this->belongsTo(Kpi::class);
    }

    public static function calculateImportance($compares) {
        $allIndicators = [];
        foreach ($compares as $compare) {
            $value = isset($compare->pivot) ? $compare->pivot->value : $compare->value;
            if (null === $value) {
                if (!isset($allIndicators[$compare->left_kpi_id])) $allIndicators[$compare->left_kpi_id] = 0;
                continue;
            }
            $value = 0 > $value ? -$value : (0 < $value ? 1 / $value : 1);
            if (isset($allIndicators[$compare->left_kpi_id]))
                $allIndicators[$compare->left_kpi_id] *= $value;
            else $allIndicators[$compare->left_kpi_id] = $value;
            if (isset($allIndicators[$compare->right_kpi_id])) $allIndicators[$compare->right_kpi_id] *= 1 / $value;
            else $allIndicators[$compare->right_kpi_id] = 1 / $value;
        };
        $powExp = 1.0 / count($allIndicators);
        $allIndicators = array_map(function ($indicatorValue) use ($powExp) {
            return pow($indicatorValue, $powExp);
        }, $allIndicators);

        return $allIndicators;
    }
}
