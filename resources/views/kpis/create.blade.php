@extends('layouts.app')

@section('title', 'Новый КПД')

@section('content')  

    @include('kpis.navigation')
    
    {{ Form::open(array('url' => 'kpis/')) }}

        <div class="form-group">
            {{ Form::label('name', 'Название') }}
            {{ Form::text('name', request('name'), array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('holding_target_value', 'Целевое значение для холдинга') }}
            {{ Form::text('holding_target_value', request('holding_target_value'), array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('companyTargetValue', 'Целевое значение для предприятия') }}
            {{ Form::text('companyTargetValue', request('companyTargetValue'), array('class' => 'form-control')) }}
        </div>

        {{ Form::submit('Создать', array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}

@endsection