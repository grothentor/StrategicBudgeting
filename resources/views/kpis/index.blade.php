@extends('layouts.app')

@section('title', 'Ключевые показатели деятельности')

@section('content')  

	@include('kpis.navigation')

	<table class="table table-striped table-bordered">
	    <thead>
	        <tr>
	            <td rowspan="2">Id</td>
	            <td rowspan="2">Название</td>
				<td colspan="2">Целевое значение</td>
	            <td rowspan="2" class="actions-col">Действия</td>
	        </tr>
			<tr>
				<td>Холдинга</td>
				<td>Предприятия</td>
			</tr>
	    </thead>
	    <tbody>
	    @foreach($kpis as $key => $value)
	        <tr>
	            <td>{{ $value->id }}</td>
	            <td><a class="" href="{{ url('kpis/' . $value->id) }}">{{ $value->name }}</a></td>
				<td>{{ $value->holding_target_value }}</td>
				<td>{{ $value->companyTargetValue }}</td>
	            <td>
	                <a class="btn btn-small btn-info pull-left" href="{{ url('kpis/' . $value->id . '/edit/' ) }}">
						Редактировать
					</a>
	                {{ Form::open(['url' => 'kpis/' . $value->id, 'method' => 'delete', 'class' => 'pull-left']) }}
				    	{{ Form::submit('Удалить', array('class' => 'btn btn-danger')) }}
					{{ Form::close() }}
	            </td>
	        </tr>
	    @endforeach
	    </tbody>
	</table>
@endsection