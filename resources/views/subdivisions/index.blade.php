@extends('layouts.app')

@section('title', 'Подразделения')

@section('content')  

	@include('subdivisions.navigation')

	<table class="table table-striped table-bordered">
	    <thead>
	        <tr>
	            <td>Id</td>
	            <td>Название</td>
	            <td class="actions-col">Действия</td>
	        </tr>
	    </thead>
	    <tbody>
	    @foreach($subdivisions as $key => $value)
	        <tr>
	            <td>{{ $value->id }}</td>
	            <td><a class="" href="{{ url('subdivisions/' . $value->id) }}">{{ $value->name }}</a></td>
	            <td>
	                <a class="btn btn-small btn-info pull-left" href="{{ url('subdivisions/' . $value->id . '/edit/' ) }}">
						Редактировать
					</a>
	                {{ Form::open(['url' => 'subdivisions/' . $value->id, 'method' => 'delete', 'class' => 'pull-left']) }}
				    	{{ Form::submit('Удалить', array('class' => 'btn btn-danger')) }}
					{{ Form::close() }}
	            </td>
	        </tr>
	    @endforeach
	    </tbody>
	</table>
@endsection