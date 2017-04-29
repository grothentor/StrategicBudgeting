@extends('layouts.app')

@section('title', "Редактирование $budget->name для $subdivision->name")

@section('content')  

    @include('budgets.navigation')
    
    {{ Form::open(['url' => "/subdivisions/$subdivision->id/budgets/$budget->id", 'method' => 'patch']) }}

        <div class="form-group">
            {{ Form::label('name', 'Название') }}
            {{ Form::text('name', $budget->name, array('class' => 'form-control')) }}
        </div>
        {{ Form::submit('Обновить', array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}

    {{ Form::open(['url' => "subdivisions/$subdivision->id/budgets/$budget->id", 'method' => 'delete']) }}
    	{{ Form::submit('Удалить', array('class' => 'btn btn-danger')) }}
	{{ Form::close() }}

@endsection