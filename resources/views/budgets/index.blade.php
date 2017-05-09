@extends('layouts.app')

@section('title', "Бюджеты для $subdivision->name")

@section('content')
    @include('budgets.navigation')

    <h2>
        <a href="{{ url("/subdivisions/$currentBudget->subdivision_id/budgets/$currentBudget->id") }}">
            {{ $currentBudget->name }}
        </a>
    </h2>
    @include('budget-values.table', [
        'budget' => $currentBudget,
        'budgetValues' => $currentBudget->budgetValues
    ])

    <h2>Варианты бюджетов</h2>

	@include('budgets.table')
@endsection