@extends('layouts.app')

@section('title', "Значение {$budgetValue->budgetIndicator->name} для $budget->name"")

@section('content')

    @include('budget-values.navigation')

    <h1>@yield('title')</h1>

    <div class="jumbotron text-center">
        <p>
            <strong>Значение:</strong> {{ $budgetValue->value }} <br>
            <strong>Переодичность:</strong> {{ __($budgetValue->pereodicity) }} <br>
            <strong>Задержка:</strong> {{ $budgetValue->offset }} дней<br>
        </p>
    </div>

@endsection