@extends('layouts.app')

@section('title', 'Сравнение КПД')

@section('content')

    @include('kpis.navigation')
    {{ Form::open(['url' => "/kpis/compares"]) }}
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <td>Левый КПД</td>
            <td>Предпочтение</td>
            <td>Правый КПД</td>
        </tr>
        </thead>
        <tbody>
        @foreach($kpis as $key => $value)
            @php($compares = $value->compares->pluck('value', 'right_kpi_id'))
            @for($index = $key + 1; $index < count($kpis); $index++)

                <tr>
                    <td>{{ $value->name }}</td>
                    <td>
                        <input name="compares[{{ $value->id }}][{{ $kpis[$index]->id }}]" type="range" min="0"
                               value="{{ $compares[$kpis[$index]->id] ?? config('app.importanceMax') / 2 }}"
                               max="{{ config('app.importanceMax') }}">
                    </td>
                    <td>{{ $kpis[$index]->name }}</td>
                </tr>
            @endfor
        @endforeach
        </tbody>
    </table>
    <div class="text-center row">
        {{ Form::submit('Сохранить', array('class' => 'btn btn-primary')) }}
    </div>
    {{ Form::close() }}
@endsection