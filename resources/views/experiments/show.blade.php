@extends('layouts.app')

@section('title', $experiment->name)

@section('content')

    @include('experiments.navigation')

    <h1>{{ $experiment->name }}</h1>

    <div class="jumbotron text-center">
        <p>
            <strong>Дата начала:</strong> {{ $experiment->date }}<br>
            <strong>Необходимо обновить:</strong> {{ $experiment->calculated ? 'Нет' : 'Да' }}<br>
        </p>
    </div>
    <div class="row text-center">
        <a class="btn btn-small btn-default" href="{{ url("experiments/$experiment->id/calculate/" ) }}">
            Смоделировать
        </a>
        <a class="btn btn-small btn-default" href="{{ url("experiments/$experiment->id/compares/" ) }}">
            Сравнения
        </a>
        <a class="btn btn-small btn-info" href="{{ url("experiments/$experiment->id/edit/" ) }}">
            Редактировать
        </a>
        {{ Form::open(['url' => 'experiments/' . $experiment->id, 'method' => 'delete', 'class' => 'delete-form']) }}
        {{ Form::submit('Удалить', array('class' => 'btn btn-danger')) }}
        {{ Form::close() }}
    </div>
    @include('experiments.budgets', ['edit' => false])
    @include('experiments.kpis', ['edit' => false])

@endsection