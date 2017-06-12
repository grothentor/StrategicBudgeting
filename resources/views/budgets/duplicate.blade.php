@extends('layouts.app')

@section('title', "Дублирование бюджета $subdivision->name->$budget->name")

@section('content')

    @include('budgets.navigation')

    {{ Form::open(array('url' => "/budgets/$budget->id/duplicate")) }}

    <div class="form-group">
        {{ Form::label('name', 'Название') }}
        {{ Form::text('name', request('name'), array('class' => 'form-control')) }}
    </div>

    <div class="form-group">
        {{ Form::label('subdivision_id', 'Подразделение') }}
        {{ Form::select('subdivision_id', $subdivisions, request('subdivision_id'), array('class' => 'form-control')) }}
    </div>

    {{ Form::submit('Создать', array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}

@endsection