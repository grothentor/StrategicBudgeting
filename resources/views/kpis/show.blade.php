@extends('layouts.app')

@section('title', $kpi->name)

@section('content')

    @include('kpis.navigation')

    <h1>{{ $kpi->name }}</h1>

    <div class="jumbotron text-center">
        <p>
            {{--<strong>Целевое значение холдинга:</strong> {{ $kpi->holding_target_value }}<br>--}}
            <strong>@lang('target_value'):</strong> {{ $kpi->companyTargetValue }}<br>
            <strong>@lang('transform_function'):</strong>:
            <div class="formula">
                `{{ $kpi->getTransformationFunction(true) }}`
            </div>
        </p>
    </div>

@endsection

@push('scripts')
<script type="text/javascript" async
        src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/MathJax.js?config=AM_CHTML&locale=ru">
</script>
@endpush