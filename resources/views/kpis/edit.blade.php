@extends('layouts.app')

@section('title', "Редактирование $kpi->name")

@section('content')  

    @include('kpis.navigation')
    
    {{ Form::open(['url' => 'kpis/' . $kpi->id, 'method' => 'patch']) }}

        <div class="form-group">
            {{ Form::label('name', 'Название') }}
            {{ Form::text('name', $kpi->name, array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('holding_target_value', 'Целевое значение для холдинга') }}
            {{ Form::text('holding_target_value', $kpi->holding_target_value, array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('companyTargetValue', 'Целевое значение для предприятия') }}
            {{ Form::text('companyTargetValue', $kpi->companyTargetValue, array('class' => 'form-control')) }}
        </div>
    
        {{ Form::submit('Обновить', array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}

    {{ Form::open(['url' => 'kpis/' . $kpi->id, 'method' => 'delete']) }}
    	{{ Form::submit('Удалить', array('class' => 'btn btn-danger')) }}
	{{ Form::close() }}

@endsection