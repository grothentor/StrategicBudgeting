@extends('layouts.app')

@section('title', $kpi->name)

@section('content')

    @include('kpis.navigation')

    <h1>{{ $kpi->name }}</h1>

    <div class="jumbotron text-center">
        <p>
            <strong>Целевое значение холдинга:</strong> {{ $kpi->holding_target_value }}<br>
            <strong>Целевое значение предприятия:</strong> {{ $kpi->companyTargetValue }}
        </p>
    </div>

@endsection