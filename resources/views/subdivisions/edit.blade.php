@extends('layouts.app')

@section('title', "Редактирование $subdivision->name")

@section('content')  

    @include('subdivisions.navigation')
    
    {{ Form::open(['url' => 'subdivisions/' . $subdivision->id, 'method' => 'patch']) }}

        <div class="form-group">
            {{ Form::label('name', 'Название') }}
            {{ Form::text('name', $subdivision->name, array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('tax', 'Налог (какой части лишается подразделение)') }}
            {{ Form::text('tax', $subdivision->tax, array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('budget', 'Личные средства подразделения') }}
            {{ Form::text('budget', $subdivision->budget, array('class' => 'form-control')) }}
        </div>
        {{ Form::submit('Обновить', array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}

    {{ Form::open(['url' => 'subdivisions/' . $subdivision->id, 'method' => 'delete']) }}
    	{{ Form::submit('Удалить', array('class' => 'btn btn-danger')) }}
	{{ Form::close() }}

@endsection