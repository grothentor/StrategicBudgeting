@extends('layouts.app')

@section('title', 'Новое подразделение')

@section('content')  

    @include('subdivisions.navigation')
    
    {{ Form::open(array('url' => 'subdivisions/')) }}

        <div class="form-group">
            {{ Form::label('name', 'Название') }}
            {{ Form::text('name', Request::input('name'), array('class' => 'form-control')) }}
        </div>

        {{ Form::submit('Создать', array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}

@endsection