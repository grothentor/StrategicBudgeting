@extends('layouts.app')

@section('title', "Редактирование {$budgetvalue->budgetIndicator->name} для $budget->name")

@section('content')  

    @include('budget-values.navigation')
    
    {{ Form::open(['url' => "/budgets/$budget->id/budget-values/$budgetValue->id", 'method' => 'patch']) }}

        <div class="form-group">
            {{ Form::label('budget_indicator_id', 'Показатель бюджета') }}
            {{ Form::select('budget_indicator_id', $budgetIndicators, $budgetValue->budget_indicator_id, ['class' => 'form-control']) }}
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
                $budgetValue->periodicity,
                ['class' => 'form-control']
            ) }}
        </div>
        <div class="form-group">
            {{ Form::label('offset', 'Задержка перед бюджетом') }}
            {{ Form::number('offset', $budgetValue->offset, ['class' => 'form-control']) }}
        </div>
        <div class="form-group">
            {{ Form::label('value', 'Значение') }}
            {{ Form::text('value', $budgetValue->value, ['class' => 'form-control']) }}
        </div>
        {{ Form::submit('Обновить', array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}

    {{ Form::open(['url' => "budgets/$budget->id/budget-values/$budgetValue->id", 'method' => 'delete']) }}
    	{{ Form::submit('Удалить', array('class' => 'btn btn-danger')) }}
	{{ Form::close() }}

@endsection