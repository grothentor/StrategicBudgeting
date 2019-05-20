@extends('layouts.app')

@section('title', $experiment->name)

@push('styles')
    {!! Charts::assets() !!}
    @if(isset($pdf) && $pdf)
    <style>
        body {
            font-family: "dejavu sans";
        }
        h1, h2, h3, h4 {
            font-family: "dejavu sans";
        }
    </style>
    @endif
@endpush

@section('content')

    @include('experiments.navigation')

    <h1>{{ $experiment->name }}</h1>

    <div class="jumbotron text-center">
        <p>
            <strong>@lang('start_date'):</strong> {{ $experiment->date }}<br>
            {{--<strong>@lang('tax'):</strong> {{ $experiment->tax * 100 }}%<br>--}}
            <strong>@lang('company_budget'):</strong> {{ $experiment->budget }}<br>
            <strong>@lang('needs_refresh'):</strong> {{ $experiment->calculated ? __('no') : __('yes') }}<br>
        </p>
    </div>
    @if (!isset($pdf) || !$pdf)
        <div class="row text-center">
            <a class="btn btn-small btn-default print-link" href="{{ url("experiments/$experiment->id/print/" ) }}">
                @lang('save')
            </a>
            <a class="btn btn-small btn-default" href="{{ url("experiments/$experiment->id/calculate/" ) }}">
                @lang('calculate_experiment')
            </a>
            <a class="btn btn-small btn-default" href="{{ url("experiments/$experiment->id/compares/" ) }}">
                @lang('compares')
            </a>
            <a class="btn btn-small btn-info" href="{{ url("experiments/$experiment->id/edit/" ) }}">
                @lang('edit')
            </a>
            <a class="btn btn-small btn-info" href="{{ url("experiments/$experiment->id/duplicate/" ) }}">
                @lang('copy')
            </a>
            {{ Form::open(['url' => 'experiments/' . $experiment->id, 'method' => 'delete', 'class' => 'delete-form']) }}
            {{ Form::submit(__('delete'), array('class' => 'btn btn-danger')) }}
            {{ Form::close() }}
        </div>
    @endif
    @include('experiments.kpis', ['edit' => false])
    @include('experiments.budgets', ['edit' => false])

    @foreach($kpiCharts as $chart)
        <div class="row">
            {!! $chart->render() !!}
        </div>
    @endforeach

@endsection