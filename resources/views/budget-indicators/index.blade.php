@extends('layouts.app')

@section('title', 'Показатели бюджетов')

@section('content')  

	@include('budget-indicators.navigation')

	<table class="table table-striped table-bordered">
	    <thead>
	        <tr>
	            <td>Id</td>
	            <td>Название</td>
				<td>Тип</td>
	            <td class="actions-col">Действия</td>
	        </tr>
	    </thead>
	    <tbody>
	    @foreach($budgetIndicators as $key => $value)
	        <tr>
	            <td>{{ $value->id }}</td>
	            <td><a class="" href="{{ url('budget-indicators/' . $value->id) }}">{{ $value->name }}</a></td>
				<td>{{ __($value->type) }}</td>
	            <td>
	                <a class="btn btn-small btn-info pull-left" href="{{ url('budget-indicators/' . $value->id . '/edit/' ) }}">
						Редактировать
					</a>
	                {{ Form::open(['url' => 'budget-indicators/' . $value->id, 'method' => 'delete', 'class' => 'pull-left']) }}
				    	{{ Form::submit('Удалить', array('class' => 'btn btn-danger')) }}
					{{ Form::close() }}
	            </td>
	        </tr>
	    @endforeach
	    </tbody>
	</table>
@endsection