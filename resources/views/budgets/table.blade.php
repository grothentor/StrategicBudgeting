<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <td>Id</td>
        <td>Название</td>
        <td class="actions-col">Действия</td>
    </tr>
    </thead>
    <tbody>
    @foreach($budgets as $key => $value)
        <tr>
            <td>{{ $value->id }}</td>
            <td><a class="" href="{{ url("subdivisions/$subdivision->id/budgets/$value->id") }}">{{ $value->name }}</a></td>
            <td>
                <a class="btn btn-small btn-info pull-left" href="{{ url("subdivisions/$subdivision->id/budgets/$value->id/edit/' ) }}">
                    Редактировать
                </a>
                {{ Form::open(['url' => 'budgets/' . $value->id, 'method' => 'delete', 'class' => 'pull-left']) }}
                {{ Form::submit('Удалить', array('class' => 'btn btn-danger')) }}
                {{ Form::close() }}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>