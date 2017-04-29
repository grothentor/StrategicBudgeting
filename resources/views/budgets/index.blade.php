@extends('layouts.app')

@section('title', "Бюджеты для $subdivision->name)

@section('content')  

	@include('budgets.navigation')

	@include('budgets.table')
@endsection