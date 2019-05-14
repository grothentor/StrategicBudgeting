@extends('layouts.app')

@section('title', __('budget_title', ['subdivision' => $subdivision->name, 'budget' => $budget->name]))

@section('content')

    @include('budgets.navigation')

    <h1>@yield('title')</h1>

    @include('budget-values.table', ['budgetValues' => $budget->budgetValues])

@endsection