<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <td>Id</td>
        <td>Показатель бюджета</td>
        <td>Значение</td>
        <td>Переодичность</td>
        <td>Задержка</td>
        <td class="actions-col">Действия</td>
    </tr>
    </thead>
    <tbody>
    @foreach($budgetValues as $key => $value)
        <tr>
            <td>{{ $value->id }}</td>
            <td>
                <a class="" href="{{ url("budgets/$budget->id/budget-values/$value->id") }}">
                    {{ $value->budgetIndicator->name }}
                </a>
            </td>
            <td>{{ $value->value }}</td>
            <td>{{ __($value->periodicity) }}</td>
            <td>{{ $value->offset }}</td>
            <td>
                <a class="btn btn-small btn-info pull-left" href="{{ url("budgets/$budget->id/budget-values/$value->id/edit/' ) }}">
                    Редактировать
                </a>
                {{ Form::open(['url' => "budgets/$budget->id/budget-values/$value->id", 'method' => 'delete', 'class' => 'pull-left']) }}
                {{ Form::submit('Удалить', array('class' => 'btn btn-danger')) }}
                {{ Form::close() }}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>