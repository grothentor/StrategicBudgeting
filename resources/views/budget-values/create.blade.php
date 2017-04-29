@extends('layouts.app')

@section('title', "Новое значение бюджета для {$budget->subdivision->name} -> $budget->name")

@section('content')  

    @include('budget-values.navigation')
    
    {{ Form::open(array('url' => "budgets/$budget->id/budgets-values")) }}

        <div class="form-group">
            {{ Form::label('budget_indicator_id', 'Показатель бюджета') }}
            {{ Form::select('budget_indicator_id', $budgetIndicators, Request::input('budget_indicator_id'), array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('periodicity', 'Переодичность') }}
            {{ Form::select('periodicity',
                [
                    'once' => __('once'),
                    'daily'=> __('daily'),
                    'monthly' => __('monthly'),
                    'quarterly' => __('quarterly'),
                    'annually' => __('annually'),
                ],
                Request::input('periodicity') ?? 'monthly',
                ['class' => 'form-control']
            ) }}
        </div>
        <div class="form-group">
            {{ Form::label('offset', 'Задержка перед бюджетом') }}
            {{ Form::number('offset', Request::input('offset'), ['class' => 'form-control']) }}
        </div>
        <div class="form-group">
            {{ Form::label('value', 'Значение') }}
            {{ Form::text('value', Request::input('value'), ['class' => 'form-control']) }}
        </div>

        {{ Form::submit('Создать', array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}

@endsection