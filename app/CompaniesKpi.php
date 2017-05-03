<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompaniesKpi extends Model
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
            if (isset($allIndicators[$compare->left_kpi_id]))
                $allIndicators[$compare->left_kpi_id] += config('app.importanceMax') - $compare->value;
            else $allIndicators[$compare->left_kpi_id] = config('app.importanceMax') * 1.5 - $compare->value;
            if (isset($allIndicators[$compare->right_kpi_id])) $allIndicators[$compare->right_kpi_id] += $compare->value;
            else $allIndicators[$compare->right_kpi_id] = config('app.importanceMax') / 2 + $compare->value;
        };
        $allImportance = array_sum($allIndicators);

        foreach ($allIndicators as $kpi_id => $importance) {
            self::query()->where('company_id', auth()->user()->id)
                ->where('kpi_id', $kpi_id)
                ->update(['importance' => $importance / $allImportance]);
        }
    }
}
