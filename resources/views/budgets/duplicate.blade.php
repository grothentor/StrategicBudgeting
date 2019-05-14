@extends('layouts.app')

@section('title', __('duplicate_title', ['subdivision' => $subdivision->name, 'budget' => $budget->name]))

@section('content')

    @include('budgets.navigation')

    {{ Form::open(array('url' => "/budgets/$budget->id/duplicate")) }}

    <div class="form-group">
        {{ Form::label('name', __('title') }}
        {{ Form::text('name', request('name'), array('class' => 'form-control')) }}
    </div>

    <div class="form-group">
        {{ Form::label('subdivision_id', __('subdivision')) }}
        {{ Form::select('subdivision_id', $subdivisions, request('subdivision_id'), array('class' => 'form-control')) }}
    </div>

    {{ Form::submit(__('create'), array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}

@endsection