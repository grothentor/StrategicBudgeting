{{ Form::open(['url' => "/budgets/$budget->id/budget-values",
    'ng-app' => 'App',
    'ng-controller' => 'createBudgetValuesCtrl',
    'ng-init' => "init('" . json_encode(request()->old('new') ?? []) . "')"
]) }}
<table class="table table-striped table-bordered budgets-values-table">
    <thead>
    <tr>
        <td>Id</td>
        <td>Показатель бюджета</td>
        <td>Значение</td>
        <td>Переодичность</td>
        <td>Задержка</td>
        <td>Длительность использования</td>
        <td class="actions-col">
            Удалить
            {{ Form::label("checkAll", 'Отметить все') }}
            {{ Form::checkbox("checkAll", 'Отметить все', false, ['ng-click' => 'deleteAll()']) }}
        </td>
    </tr>
    </thead>
    <tbody>
    @foreach($budgetValues as $key => $value)
        <tr>
            <td>
                {{ $value->id }}
                {{ Form::hidden("old[$value->id][id]", $value->id) }}</td>
            <td>
                {{ Form::select("old[$value->id][budget_indicator_id]",
                    $budgetIndicators,
                    $value->budget_indicator_id,
                    ['class' => 'form-control']
                ) }}
            </td>
            <td>
                {{ Form::text("old[$value->id][value]",
                    $value->value,
                    ['class' => 'form-control']
                ) }}
            </td>
            <td>
                {{ Form::select("old[$value->id][periodicity]",
                    [
                        'once' => __('once'),
                        'daily'=> __('daily'),
                        'monthly' => __('monthly'),
                        'quarterly' => __('quarterly'),
                        'annually' => __('annually'),
                    ],
                    $value->periodicity,
                    ['class' => 'form-control']
                ) }}
            </td>
            <td>
                {{ Form::number("old[$value->id][offset]",
                    $value->offset,
                    ['class' => 'form-control']
                ) }}
            </td>
            <td>
                {{ Form::number("old[$value->id][use_length]",
                    $value->use_length,
                    ['class' => 'form-control']
                ) }}
            </td>
            <td>
                {{ Form::label("old[$value->id][deleted]", 'Удалить') }}
                {{ Form::checkbox("old[$value->id][deleted]", 1, false) }}
                {{ Form::hidden("old[$value->id][edited]", false) }}
            </td>
        </tr>
    @endforeach
        <tr ng-repeat="newBudget in budgetValues">
            <td>Новый</td>
            <td>
                {!! Form::select('new[@{{ $index }}][budget_indicator_id]',
                    $budgetIndicators,
                    null,
                    ['class' => 'form-control', 'ng-model' => 'newBudget.budget_indicator_id']
                ) !!}
            </td>
            <td>{!! Form::text(
                'new[@{{ $index }}][value]',
                0,
                ['class' => 'form-control', 'ng-model' => 'newBudget.value']
            ) !!}</td>
            <td>{!! Form::select('new[@{{ $index }}][periodicity]',
                [
                    'once' => __('once'),
                    'daily'=> __('daily'),
                    'monthly' => __('monthly'),
                    'quarterly' => __('quarterly'),
                    'annually' => __('annually'),
                ],
                'monthly',
                ['class' => 'form-control', 'ng-model' => 'newBudget.periodicity']
            ) !!}
            </td>
            <td>
                {!! Form::text('new[@{{ $index }}][offset]',
                    0,
                    ['class' => 'form-control', 'ng-model' => 'newBudget.offset']
                ) !!}
            </td>
            <td>
                {!! Form::text('new[@{{ $index }}][use_length]',
                    null,
                    ['class' => 'form-control', 'ng-model' => 'newBudget.use_length']
                ) !!}
            </td>
            <td>
                <button class="btn btn-default" ng-click="deleteBudgetValue($index)">Удалить</button>
            </td>
        </tr>
    </tbody>
</table>
<div class="text-center row">
    <button class="btn btn-default" ng-click="addNewBudgetValue($event)">Добавить значение</button>
    {{ Form::submit('Сохранить', array('class' => 'btn btn-primary')) }}
</div>
{{ Form::close() }}

@push('scripts')
{{ Html::script('js/app/controllers/createBudgetValuesCtrl.js') }}
@endpush