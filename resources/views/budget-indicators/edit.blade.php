@extends('layouts.app')

@section('title', __('editing', ['name' => $budgetIndicator->name]))

@section('content')  

    @include('budget-indicators.navigation')
    
    {{ Form::open(['url' => 'budget-indicators/' . $budgetIndicator->id, 'method' => 'patch']) }}

        <div class="form-group">
            {{ Form::label('name', __('title')) }}
            {{ Form::text('name', $budgetIndicator->name, array('class' => 'form-control')) }}
        </div>

        <div class="form-group">
            {{ Form::label('type', __('type')) }}
            {{ Form::select('type',
                ['income' => __('income'), 'expense' => __('expense'), 'other' => __('other')],
                $budgetIndicator->type,
                ['class' => 'form-control']
            ) }}
        </div>
        {{ Form::submit(__('update'), array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}

    {{ Form::open(['url' => 'budget-indicators/' . $budgetIndicator->id, 'method' => 'delete']) }}
    	{{ Form::submit(__('delete'), array('class' => 'btn btn-danger')) }}
	{{ Form::close() }}

@endsection