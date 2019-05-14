@extends('layouts.app')

@section('title', __('compares'))

@section('content')

    @include('experiments.navigation')
    <h2>@lang('preferences', ['experiment' => $experiment->name])</h2>
    {{ Form::open(['url' => "/experiments/$experiment->id/compares"]) }}
    @include('compares.table', ['kpis' => $experiment->kpis])
    <div class="text-center row">
        {{ Form::submit(__('save'), array('class' => 'btn btn-primary')) }}
    </div>
    {{ Form::close() }}
@endsection