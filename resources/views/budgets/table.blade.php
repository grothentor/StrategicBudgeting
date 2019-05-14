<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <td>@lang('id')</td>
        <td>@lang('title')</td>
        <td class="actions-col">@lang('actions')</td>
    </tr>
    </thead>
    <tbody>
    @foreach($budgets as $key => $value)
        <tr>
            <td>{{ $value->id }}</td>
            <td><a class="" href="{{ url("subdivisions/$subdivision->id/budgets/$value->id") }}">{{ $value->name }}</a></td>
            <td>
                <a class="btn btn-small btn-info pull-left" href="{{ url("subdivisions/$subdivision->id/budgets/$value->id/edit/" ) }}">
                    @lang('edit')
                </a>
                {{ Form::open(['url' => "subdivisions/$subdivision->id/budgets/$value->id", 'method' => 'delete', 'class' => 'pull-left']) }}
                {{ Form::submit(__('delete'), array('class' => 'btn btn-danger')) }}
                {{ Form::close() }}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>