{{ Form::open(['url' => "/budgets/$budget->id/budget-values",
    'ng-app' => 'App',
    'ng-controller' => 'createBudgetValuesCtrl',
    'ng-init' => "init('" . json_encode(request()->old('new') ?? []) . "')"
]) }}
<table class="table table-striped table-bordered budgets-values-table">
    <thead>
    <tr>
        <th rowspan="2">Id</th>
        <th rowspan="2">Показатель бюджета</th>
        <th colspan="2">Значение</th>
        <th rowspan="2">Переодичность</th>
        <th rowspan="2" title="Сколько периодов от начала формирования не будет использоваться показатель">Задержка</th>
        <th rowspan="2" title="Количество использований показателя">Количество</th>
        <th rowspan="2" title="Использование в конце периода">В конце</th>
        <th rowspan="2" class="actions-col">
            {{ Form::label("checkAll", 'Удалить', ['title' => 'Отметить все']) }}
            {{ Form::checkbox("checkAll", 'Отметить все', false, ['ng-click' => 'deleteAll($event)']) }}
        </th>
    </tr>
    <tr>
        <th title="Значение на единицу" class="singular-value-col">За ед.</th>
        <th title="Количество используемых единиц" class="count-col">Кол-во</th>
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
            @php(dump($value->value))
            <td colspan="2" class="value-holder"
                ng-class="'' === '{{ $value->value }}' ? 'hidden' : '' ">
                <span class="change-value-type glyphicon glyphicon-transfer" ng-click="changeValueType($event)"></span>
                {{ Form::text("old[$value->id][value]",
                    $value->value,
                    ['class' => 'form-control value']
                ) }}
            </td>
            <td class="by-count-holder"
                ng-class="'' === '{{ $value->value }}' ? '' : 'hidden' ">
                <span class="change-value-type glyphicon glyphicon-transfer" ng-click="changeValueType($event)"></span>
                {{ Form::text("old[$value->id][singular_value]",
                    $value->singular_value,
                    ['class' => 'form-control singular-value']
                ) }}
            </td>
            <td class="by-count-holder"
                ng-class="'' === '{{ $value->value }}' ? '' : 'hidden' ">
                {{ Form::text("old[$value->id][count]",
                    $value->count,
                    ['class' => 'form-control count']
                ) }}
            </td>
            <td>
                {{ Form::select("old[$value->id][periodicity]",
                    [
                        'once' => __('once'),
                        'monthly' => __('monthly'),
                        'quarterly' => __('quarterly'),
                        'annually' => __('annually'),
                    ],
                    $value->periodicity,
                    [
                        'class' => 'form-control periodicity',
                        'ng-model' => "old[$value->id].periodicity",
                        'ng-init' => "old[$value->id].periodicity='$value->periodicity'; periodicityChange($value->id)",
                        'ng-change' => "periodicityChange($value->id)"
                    ]
                ) }}
            </td>
            <td>
                {{ Form::number("old[$value->id][offset]",
                    $value->offset,
                    ['class' => 'form-control offset']
                ) }}
            </td>
            <td>
                {{ Form::number("old[$value->id][use_length]",
                    $value->use_length,
                    [
                        'class' => 'form-control use-length',
                        'ng-show' => "old[$value->id].showUseLength"
                    ]
                ) }}
            </td>
            <td>
            {{ Form::checkbox("old[$value->id][pay_at_end]", 1, $value->pay_at_end, [
                    'ng-show' => "old[$value->id].showPayAtEnd"
                ]
            ) }}
            </td>
            <td>
                {{ Form::checkbox("old[$value->id][deleted]", 1, false) }}
                {{ Form::hidden("old[$value->id][edited]", false) }}
            </td>
        </tr>
    @endforeach
        <tr ng-repeat="newBudget in budgetValues" data-new-id="@{{ $index }}">
            <td>Новый</td>
            <td>
                {!! Form::select('new[@{{ $index }}][budget_indicator_id]',
                    $budgetIndicators,
                    null,
                    ['class' => 'form-control', 'ng-model' => 'newBudget.budget_indicator_id']
                ) !!}
            </td>
            <td colspan="2" class="value-holder">
                <span class="change-value-type glyphicon glyphicon-transfer" ng-click="changeValueType($event)"></span>
                {!! Form::text(
                    'new[@{{ $index }}][value]',
                    0,
                    ['class' => 'form-control value', 'ng-model' => 'newBudget.value']
                ) !!}
            </td>
            <td class="by-count-holder hidden">
                <span class="change-value-type  glyphicon glyphicon-transfer" ng-click="changeValueType($event)"></span>
                {!! Form::text('new[@{{ $index }}][singular_value]',
                    '',
                    ['class' => 'form-control singular-value', 'ng-model' => 'newBudget.singular_value']
                ) !!}
            </td>
            <td class="by-count-holder hidden">
                {!! Form::text('new[@{{ $index }}][count]',
                    '',
                    ['class' => 'form-control count']
                ) !!}
            </td>
            <td>{!! Form::select('new[@{{ $index }}][periodicity]',
                [
                    'once' => __('once'),
                    'monthly' => __('monthly'),
                    'quarterly' => __('quarterly'),
                    'annually' => __('annually'),
                ],
                'monthly',
                [
                    'class' => 'form-control periodicity',
                    'ng-model' => 'newBudget.periodicity',
                    'ng-change' => 'periodicityChange($index, \'new\')',
                    'ng-init' => 'periodicityChange($index, \'new\')'
                ]
            ) !!}
            </td>
            <td>
                {!! Form::text('new[@{{ $index }}][offset]',
                    0,
                    ['class' => 'form-control offset', 'ng-model' => 'newBudget.offset']
                ) !!}
            </td>
            <td>
                {!! Form::text('new[@{{ $index }}][use_length]',
                    null,
                    [
                        'class' => 'form-control use-length',
                        'ng-model' => 'newBudget.use_length',
                        'ng-show' => 'newBudget.showUseLength'
                    ]
                ) !!}
            </td>
            <td>
                {!! Form::radio('new[@{{ $index}}][pay_at_end]', 1, false, [
                        'ng-show' => 'newBudget.showPayAtEnd'
                    ]
                ) !!}
                {!! Form::radio('new[@{{ $index}}][pay_at_end]', 0, '@{{ !newBudget.showPayAtEnd }}', [
                        'ng-show' => 'false'
                    ]
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