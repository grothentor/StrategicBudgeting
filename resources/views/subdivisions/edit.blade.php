@extends('layouts.app')

@section('title', __('editing', ['name' => $subdivision->name]))

@section('content')  

    @include('subdivisions.navigation')
    
    {{ Form::open(['url' => 'subdivisions/' . $subdivision->id, 'method' => 'patch']) }}

        <div class="form-group">
            {{ Form::label('name', __('title')) }}
            {{ Form::text('name', $subdivision->name, array('class' => 'form-control')) }}
        </div>
        {{ Form::submit(__('update'), array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}

    {{ Form::open(['url' => 'subdivisions/' . $subdivision->id, 'method' => 'delete']) }}
    	{{ Form::submit(__('delete'), array('class' => 'btn btn-danger')) }}
	{{ Form::close() }}

@endsection