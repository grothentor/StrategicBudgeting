@extends('layouts.app')

@section('title', $experiment->name)

@section('content')

    @include('experiments.navigation')

    <h1>{{ $experiment->name }}</h1>

    <div class="jumbotron text-center">
        <p>
            <strong>Дата начала:</strong> {{ $experiment->date }}<br>
        </p>
    </div>
    @include('experiments.budgets', ['edit' => false])
    @include('experiments.kpis', ['edit' => false])
@endsection