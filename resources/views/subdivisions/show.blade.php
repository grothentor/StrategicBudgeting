@extends('layouts.app')

@section('title', $subdivision->name)

@section('content')

    @include('subdivisions.navigation')

    <h1>{{ $subdivision->name }}</h1>

    <h3><a href="{{ url("subdivisions/$subdivision->id/budgets") }}">Бюджеты</a></h3>
    <a class="btn btn-default" href="{{ url("subdivisions/$subdivision->id/budgets/create") }}">Новый бюджет</a>
    @include('budgets.table', ['budgets' => $subdivision->budgets])

@endsection