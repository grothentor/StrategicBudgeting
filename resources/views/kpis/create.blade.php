@extends('layouts.app')

@section('title', 'Новый КПД')

@section('content')  

    @include('kpis.navigation')
    
    {{ Form::open(array('url' => 'kpis/')) }}

        <div class="form-group">
            {{ Form::label('name', 'Название') }}
            {{ Form::text('name', Request::input('name'), array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('holding_target_value', 'Целевое значение для холдинга') }}
            {{ Form::text('holding_target_value', Request::input('holding_target_value'), array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('company_target_value', 'Целевое значение для предприятия') }}
            {{ Form::text('company_target_value', Request::input('company_target_value'), array('class' => 'form-control')) }}
        </div>

        {{ Form::submit('Создать', array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}

@endsection