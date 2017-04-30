@extends('layouts.app')

@section('title', "Новый бюджет для $subdivision->name")

@section('content')  

    @include('budgets.navigation')
    
    {{ Form::open(array('url' => "subdivisions/$subdivision->id/budgets")) }}

        <div class="form-group">
            {{ Form::label('name', 'Название') }}
            {{ Form::text('name', request('name'), array('class' => 'form-control')) }}
        </div>

        {{ Form::submit('Создать', array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}

@endsection