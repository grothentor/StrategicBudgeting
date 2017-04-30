@extends('layouts.app')

@section('title', 'Новый показатель бюджета')

@section('content')  

    @include('budget-indicators.navigation')
    
    {{ Form::open(array('url' => 'budget-indicators/')) }}

        <div class="form-group">
            {{ Form::label('name', 'Название') }}
            {{ Form::text('name', request('name'), array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('type', 'Тип') }}
            {{ Form::select('type',
                ['income' => 'Доход', 'expense' => 'Расход'],
                request('type') ?? 'income',
                ['class' => 'form-control']
            ) }}
        </div>

        {{ Form::submit('Создать', array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}

@endsection