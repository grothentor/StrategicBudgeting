@extends('layouts.app')

@section('title', __('new_subdivision'))

@section('content')  

    @include('subdivisions.navigation')
    
    {{ Form::open(array('url' => 'subdivisions/')) }}

        <div class="form-group">
            {{ Form::label('name', __('title')) }}
            {{ Form::text('name', request('name'), array('class' => 'form-control')) }}
        </div>

        {{ Form::submit(__('create'), array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}

@endsection