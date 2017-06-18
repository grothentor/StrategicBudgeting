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
            <strong>Дата начала:</strong> {{ $experiment->date }}<br>
            <strong>Налог:</strong> {{ $experiment->tax * 100 }}%<br>
            <strong>Личные средства:</strong> {{ $experiment->budget }}<br>
            <strong>Необходимо обновить:</strong> {{ $experiment->calculated ? 'Нет' : 'Да' }}<br>
        </p>
    </div>
    @if (!isset($pdf) || !$pdf)
        <div class="row text-center">
            <a class="btn btn-small btn-default print-link" href="{{ url("experiments/$experiment->id/print/" ) }}">
                Сохранить
            </a>
            <a class="btn btn-small btn-default" href="{{ url("experiments/$experiment->id/calculate/" ) }}">
                Поиск СБ
            </a>
            <a class="btn btn-small btn-default" href="{{ url("experiments/$experiment->id/compares/" ) }}">
                Сравнения
            </a>
            <a class="btn btn-small btn-info" href="{{ url("experiments/$experiment->id/edit/" ) }}">
                Редактировать
            </a>
            <a class="btn btn-small btn-info" href="{{ url("experiments/$experiment->id/duplicate/" ) }}">
                Копировать
            </a>
            {{ Form::open(['url' => 'experiments/' . $experiment->id, 'method' => 'delete', 'class' => 'delete-form']) }}
            {{ Form::submit('Удалить', array('class' => 'btn btn-danger')) }}
            {{ Form::close() }}
        </div>
    @endif
    @include('experiments.budgets', ['edit' => false])
    @include('experiments.kpis', ['edit' => false])

    @foreach($kpiCharts as $chart)
        <div class="row">
            {!! $chart->render() !!}
        </div>
    @endforeach

@endsection