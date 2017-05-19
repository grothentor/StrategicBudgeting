<?php

namespace App;

class CompaniesKpi extends CustomModel
{
    protected $dates = ['created_at', 'updated_at'];
    protected $guarded = ['id'];

    public function scopeDefault($query) {
        return $query->where('company_id', auth()->user()->id);
    }

    public static function calculateImportance() {
        $compares = Compare::query()->default()->get();
        $allIndicators = [];
        foreach ($compares as $compare) {
            $value = 0 > $compare->value ? -$compare->value : (0 < $compare->value ? 1 / $compare->value : 1);
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
        $allImportance = array_sum($allIndicators);

        foreach ($allIndicators as $kpi_id => $importance) {
            self::query()->where('company_id', auth()->user()->id)
                ->where('kpi_id', $kpi_id)
                ->update(['importance' => $importance / $allImportance]);
        }
    }
}
