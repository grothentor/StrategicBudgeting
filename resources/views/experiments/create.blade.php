@extends('layouts.app')

@section('title', __('new_experiment'))

@section('content')  

    @include('experiments.navigation')
    
    {{ Form::open(array('url' => 'experiments/')) }}

        <div class="form-group">
            {{ Form::label('name', __('title')) }}
            {{ Form::text('name', request('name'), array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('date', __('experiment_start')) }}
            {{ Form::text('date', request('date'), array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('tax', __('tax')) }}
            {{ Form::text('tax', request('tax'), array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('budget', __('company_budget')) }}
            {{ Form::text('budget', request('budget'), array('class' => 'form-control')) }}
        </div>

        {{ Form::submit(__('create'), array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}

@endsection