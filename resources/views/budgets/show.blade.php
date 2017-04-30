@extends('layouts.app')

@section('title', "$subdivision->name -> $budget->name")

@section('content')

    @include('budgets.navigation')

    <h1>@yield('title')</h1>

    <h3><a href="{{ url("budgets/$budget->id/budget-values") }}">Значения бюджета</a></h3>

    @include('budget-values.table', ['budgetValues' => $budget->budgetValues])

@endsection