@extends('layouts.app')

@section('title', "Значения бюджета $budget->name -> {$budget->subdivision->name}")

@section('content')  

	@include('budget-values.navigation')

	@include('budget-values.table')

@endsection