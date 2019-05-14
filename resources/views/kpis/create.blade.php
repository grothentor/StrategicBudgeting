@extends('layouts.app')

@section('title', __('new_kpi'))

@section('content')  

    @include('kpis.navigation')
    
    {{ Form::open(array('url' => 'kpis/')) }}

        <div class="form-group">
            {{ Form::label('name', __('')) }}
            {{ Form::text('name', request('name'), array('class' => 'form-control')) }}
        </div>
        {{--<div class="form-group">--}}
            {{--{{ Form::label('holding_target_value', 'Целевое значение для холдинга') }}--}}
            {{--{{ Form::text('holding_target_value', request('holding_target_value'), array('class' => 'form-control')) }}--}}
        {{--</div>--}}
        <div class="form-group">
            {{ Form::label('companyTargetValue', __('target_value')) }}
            {{ Form::text('companyTargetValue', request('companyTargetValue'), array('class' => 'form-control')) }}
        </div>

        {{ Form::submit(__('create'), array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}

@endsection