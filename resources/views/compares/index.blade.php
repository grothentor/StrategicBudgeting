@extends('layouts.app')

@section('title', 'Сравнение КПД')

@push('styles')
{{ Html::style('js/lib/bootstrap-slider/slider.css') }}
@endpush
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
                        <input name="compares[{{ $value->id }}][{{ $kpis[$index]->id }}]" type="text"
                               data-slider-min="-5"
                               data-slider-value="{{ $compares[$kpis[$index]->id] ?? 0 }}"
                               data-slider-max="5"
                               data-slider-step="1">
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

@push('scripts')
{{ Html::script('js/lib/bootstrap-slider/bootstrap-slider.js') }}
<script>
    $('[name*="compares"]').slider({
        formatter: (value) => { Math.abs(value) },
        ticks_tooltip: true
    });
</script>
@endpush