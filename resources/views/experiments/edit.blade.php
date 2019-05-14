@extends('layouts.app')

@section('title', __('editing', ['name' => $experiment->name]))

@section('content')  

    @include('experiments.navigation')
    
    {{ Form::open(['url' => 'experiments/' . $experiment->id, 'method' => 'patch']) }}

        <div class="form-group">
            {{ Form::label('name', __('title')) }}
            {{ Form::text('name', $experiment->name, array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('date', __('experiment_start')) }}
            {{ Form::text('date', $experiment->date, array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('tax', __('tax')) }}
            {{ Form::text('tax', $experiment->tax, array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('budget', __('company_budget')) }}
            {{ Form::text('budget', $experiment->budget, array('class' => 'form-control')) }}
        </div>
        @include('experiments.budgets', ['edit' => true])
        @include('experiments.kpis', ['edit' => true])
    
        {{ Form::submit(__('update'), array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}

    {{ Form::open(['url' => 'experiments/' . $experiment->id, 'method' => 'delete']) }}
    	{{ Form::submit(__('delete'), array('class' => 'btn btn-danger')) }}
	{{ Form::close() }}

@endsection