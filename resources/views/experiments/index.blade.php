@extends('layouts.app')

@section('title', 'Експерименты')

@section('content')  

	@include('experiments.navigation')

	<table class="table table-striped table-bordered">
	    <thead>
	        <tr>
	            <th>Id</th>
	            <th>Название</th>
				<th>Дата начала експеримента</th>
				<th>Налог</th>
				<th>Личные средства</th>
	            <th class="actions-col">Действия</th>
	        </tr>
	    </thead>
	    <tbody>
	    @foreach($experiments as $key => $value)
	        <tr>
	            <td>{{ $value->id }}</td>
	            <td><a class="" href="{{ url('experiments/' . $value->id) }}">{{ $value->name }}</a></td>
				<td>{{ $value->date }}</td>
				<td>{{ $value->tax * 100 }}%</td>
				<td>{{ $value->budget }}</td>
	            <td>
	                <a class="btn btn-small btn-default pull-left" href="{{ url('experiments/' . $value->id . '/compares/' ) }}">
						Сравнения
					</a>
					<a class="btn btn-small btn-info pull-left" href="{{ url('experiments/' . $value->id . '/edit/' ) }}">
						Редактировать
					</a>
	                {{ Form::open(['url' => 'experiments/' . $value->id, 'method' => 'delete', 'class' => 'pull-left']) }}
				    	{{ Form::submit('Удалить', array('class' => 'btn btn-danger')) }}
					{{ Form::close() }}
	            </td>
	        </tr>
	    @endforeach
	    </tbody>
	</table>
@endsection