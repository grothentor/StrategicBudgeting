@extends('layouts.app')

@section('title', $kpi->name)

@section('content')

    @include('kpis.navigation')
    @php(dump($kpi->calculateValue([
        1 => 1,
        2 => 2,
        3 => 3,
        4 => 4,
        5 => 5,
        6 => 6
    ])))
    <h1>{{ $kpi->name }}</h1>

    <div class="jumbotron text-center">
        <p>
            <strong>Целевое значение холдинга:</strong> {{ $kpi->holding_target_value }}<br>
            <strong>Целевое значение предприятия:</strong> {{ $kpi->companyTargetValue }}
        </p>
    </div>

@endsection