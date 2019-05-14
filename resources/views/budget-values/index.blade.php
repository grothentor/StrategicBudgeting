@extends('layouts.app')

@section('title', __('budget_value_title', ['name' => $budget->name, 'subdivision' => $budget->subdivision->name]))

@section('content')

    @include('budget-values.table')

@endsection