@extends('layouts.app')

@section('title', "Редактирование $budgetIndicator->name")

@section('content')  

    @include('budget-indicators.navigation')
    
    {{ Form::open(['url' => 'budget-indicators/' . $budgetIndicator->id, 'method' => 'patch']) }}

        <div class="form-group">
            {{ Form::label('name', 'Название') }}
            {{ Form::text('name', $budgetIndicator->name, array('class' => 'form-control')) }}
        </div>

        <div class="form-group">
            {{ Form::label('type', 'Тип') }}
            {{ Form::select('type',
                ['income' => 'Доход', 'expense' => 'Расход'],
                $budgetIndicator->type,
                ['class' => 'form-control']
            ) }}
        </div>
        {{ Form::submit('Обновить', array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}

    {{ Form::open(['url' => 'budget-indicators/' . $budgetIndicator->id, 'method' => 'delete']) }}
    	{{ Form::submit('Удалить', array('class' => 'btn btn-danger')) }}
	{{ Form::close() }}

@endsection