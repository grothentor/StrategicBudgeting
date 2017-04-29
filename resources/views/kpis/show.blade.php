@extends('layouts.app')

@section('title', $kpi->name)

@section('content')

    @include('kpis.navigation')

    <h1>{{ $kpi->name }}</h1>

    <div class="jumbotron text-center">
        <p>
            <strong>Целевое значение холдинга:</strong> {{ $kpi->company_target_value }}<br>
            <strong>Целевое значение предприятия:</strong> {{ $kpi->company_target_value }}
        </p>
    </div>

@endsection