@extends('layouts.app')

@section('title', 'Новый Експеримент')

@section('content')  

    @include('experiments.navigation')
    
    {{ Form::open(array('url' => 'experiments/')) }}

        <div class="form-group">
            {{ Form::label('name', 'Название') }}
            {{ Form::text('name', request('name'), array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('date', 'Дата начала експеримента') }}
            {{ Form::text('date', request('date'), array('class' => 'form-control')) }}
        </div>

        {{ Form::submit('Создать', array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}

@endsection