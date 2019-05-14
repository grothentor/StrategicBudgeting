@extends('layouts.app')

@section('title', __('compares_title'))

@section('content')

    @include('kpis.navigation')
    {{ Form::open(['url' => "/kpis/compares"]) }}
        @include('compares.table')
        <div class="text-center row">
            {{ Form::submit(__('save'), array('class' => 'btn btn-primary')) }}
        </div>
    {{ Form::close() }}
@endsection