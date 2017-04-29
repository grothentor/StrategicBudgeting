@extends('layouts.app')

@section('title', $budgetIndicator->name)

@section('content')

    @include('budget-indicators.navigation')

    <h1>{{ $budgetIndicator->name }}</h1>

    <div class="jumbotron text-center">
        <p>
            <strong>Тип:</strong> {{ __($budgetIndicator->type) }}
        </p>
    </div>

@endsection