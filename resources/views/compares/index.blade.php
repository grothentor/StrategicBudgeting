@extends('layouts.app')

@section('title', 'Сравнение КПЭ')

@section('content')

    @include('kpis.navigation')
    {{ Form::open(['url' => "/kpis/compares"]) }}
        @include('compares.table')
    <div class="text-center row">
        {{ Form::submit('Сохранить', array('class' => 'btn btn-primary')) }}
    </div>
    {{ Form::close() }}
@endsection