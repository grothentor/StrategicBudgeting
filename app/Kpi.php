<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kpi extends Model
{
    protected $dates = ['created_at', 'updated_at'];
    protected $guarded = ['id'];
    protected $appends = ['companyTargetValue'];

    private $transformationFunction = '';

    public static $validateRules = [
        'name' => 'required',
        'holding_target_value' => 'required|numeric',
        'companyTargetValue' => 'required|numeric',
    ];

    public function transformations() {
        return $this->hasMany(Transformation::class);
    }

    public function getCompanyTargetValueAttribute() {
        return CompaniesKpi::query()
            ->default()
            ->where('kpi_id', $this->id)
            ->where('company_id', auth()->user()->id)
            ->first()
            ->target_value;
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
