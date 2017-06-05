@extends('layouts.app')

@section('title', 'Сравнения')

@section('content')

    @include('experiments.navigation')
    <h2>Предпочтения КПЕ для '{{ $experiment->name }}'</h2>
    {{ Form::open(['url' => "/experiments/$experiment->id/compares"]) }}
    @include('compares.table', ['kpis' => $experiment->kpis])
    <div class="text-center row">
        {{ Form::submit('Сохранить', array('class' => 'btn btn-primary')) }}
    </div>
    {{ Form::close() }}
@endsection