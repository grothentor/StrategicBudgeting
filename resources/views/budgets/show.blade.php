@extends('layouts.app')

@section('title', "$subdivision->name -> $budget->name")

@section('content')

    @include('budgets.navigation')

    <h1>@yield('title')</h1>

    <h3><a href="{{ url("budgets/$budget->id/budget-values") }}">Значения бюджета</a></h3>
    <a class="btn btn-default" href="{{ url("игвпуеы/$subdivision->id/budget-values/create") }}">
        Новое значение бюджета
    </a>
    @include('budget-values.table', ['budgetValues' => $subdivision->budgetValues])

@endsection