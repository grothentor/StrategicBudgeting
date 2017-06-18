@extends('layouts.app')

@section('title', 'Новый вариант СБ')

@section('content')  

    @include('experiments.navigation')
    
    {{ Form::open(array('url' => 'experiments/')) }}

        <div class="form-group">
            {{ Form::label('name', 'Название') }}
            {{ Form::text('name', request('name'), array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('date', 'Дата начала Варианта СБ') }}
            {{ Form::text('date', request('date'), array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('tax', 'Налог (какой части лишается компания)') }}
            {{ Form::text('tax', request('tax'), array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('budget', 'Личные средства компании') }}
            {{ Form::text('budget', request('budget'), array('class' => 'form-control')) }}
        </div>

        {{ Form::submit('Создать', array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}

@endsection