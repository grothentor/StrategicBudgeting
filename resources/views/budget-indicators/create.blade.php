@extends('layouts.app')

@section('title', __('new_budget_indicator'))

@section('content')  

    @include('budget-indicators.navigation')
    
    {{ Form::open(array('url' => 'budget-indicators/')) }}

        <div class="form-group">
            {{ Form::label('name', __('title')) }}
            {{ Form::text('name', request('name'), array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('type', __('type')) }}
            {{ Form::select('type',
                ['income' => __('income'), 'expense' => __('expense'), 'other' => __('other')],
                request('type') ?? 'income',
                ['class' => 'form-control']
            ) }}
        </div>

        {{ Form::submit(__('create'), array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}

@endsection