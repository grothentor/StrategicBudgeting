@extends('layouts.app')

@section('title', "Редактирование $experiment->name")

@section('content')  

    @include('experiments.navigation')
    
    {{ Form::open(['url' => 'experiments/' . $experiment->id, 'method' => 'patch']) }}

        <div class="form-group">
            {{ Form::label('name', 'Название') }}
            {{ Form::text('name', $experiment->name, array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('date', 'Дата начала експеримента') }}
            {{ Form::text('date', $experiment->date, array('class' => 'form-control')) }}
        </div>

        @include('experiments.budgets', ['edit' => true])
        @include('experiments.kpis', ['edit' => true])
    
        {{ Form::submit('Обновить', array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}

    {{ Form::open(['url' => 'experiments/' . $experiment->id, 'method' => 'delete']) }}
    	{{ Form::submit('Удалить', array('class' => 'btn btn-danger')) }}
	{{ Form::close() }}

@endsection