<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Kpi extends Model
{
    protected $dates = ['created_at', 'updated_at'];
    protected $guarded = ['id'];
    protected $appends = ['companyTargetValue', 'companyImportance']; //TODO: pivot here

    private $transformationFunction = '';

    public static $validateRules = [
        'name' => 'required',
        'holding_target_value' => 'required|numeric',
        'companyTargetValue' => 'required|numeric',
    ];

    public function transformations() {
        return $this->hasMany(Transformation::class);
    }

    public function compares() {
        return $this->hasMany(Compare::class, 'left_kpi_id');
    }

    public function getCompanyTargetValueAttribute() {
        return CompaniesKpi::query()
            ->default()
            ->where('kpi_id', $this->id)
            ->where('company_id', auth()->user()->id)
            ->first()
            ->target_value;
    }

    public function getCompanyImportanceAttribute() {
        return CompaniesKpi::query()
            ->default()
            ->where('kpi_id', $this->id)
            ->where('company_id', auth()->user()->id)
            ->first()
            ->importance;
    }

    public function scopeDefault($query) {
        return $query;
    }

    public function calculateValue(array $budgetValues) {
        if (empty($this->transformationFunction)) $this->generateTransactionsFunction();
        $kpi = eval($this->transformationFunction);
        return $kpi;
    }

    private function generateTransactionsFunction($budgetVariable = 'budgetValues') {
        $transformations = [];
        foreach($this->transformations as $transformation) {
            $right = $this->getTransformationValue('right', $transformation, $transformations, $budgetVariable);
            $left = $this->getTransformationValue('left', $transformation, $transformations, $budgetVariable);

            $transformations[$transformation->id] = [
                'value' => "$left $transformation->operation $right",
                'operation' => $transformation->operation,
            ];
        }
        $this->transformationFunction = 'return ' . array_pop($transformations)['value'] . ';';
    }

    private function getTransformationValue(string $side, $transformation, $transformations, $budgetVariable) {
        $sideTransformation = $side . '_transformation_id';
        $sideBudget = $side . '_budget_indicator_id';

        if ($transformation->$sideTransformation) {
            if (!isset($transformations[$transformation->$sideTransformation]))
                throw new \Exception("bad $side transaction id");
            $value = $transformations[$transformation->$sideTransformation]['value'];

            if (in_array($transformation->operation, ['*', '/']) &&
                in_array($transformations[$transformation->$sideTransformation]['operation'], ['+', '-'])) {
                $value = "($value)";
            }
        } elseif ($transformation->$sideBudget) {
            $value = "\${$budgetVariable}[{$transformation->$sideBudget}]";
        } else $value = $transformation->value;

        return $value;
    }
}
