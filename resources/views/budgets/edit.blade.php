@extends('layouts.app')

@section('title', __('budget_editing', ['budget' => $budget->name, 'subdivision' => $subdivision->name]))

@section('content')  

    @include('budgets.navigation')
    
    {{ Form::open(['url' => "/subdivisions/$subdivision->id/budgets/$budget->id", 'method' => 'patch']) }}

        <div class="form-group">
            {{ Form::label('name', __('title')) }}
            {{ Form::text('name', $budget->name, array('class' => 'form-control')) }}
        </div>
        {{ Form::submit(__('update'), array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}

    {{ Form::open(['url' => "subdivisions/$subdivision->id/budgets/$budget->id", 'method' => 'delete']) }}
    	{{ Form::submit(__('delete'), array('class' => 'btn btn-danger')) }}
	{{ Form::close() }}

@endsection