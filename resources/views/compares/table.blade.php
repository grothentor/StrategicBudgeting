<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <td>@lang('left_kpi')</td>
        <td>@lang('preference')</td>
        <td>@lang('right_kpi')</td>
    </tr>
    </thead>
    <tbody>
    @foreach($kpis as $key => $value)
        @php($experimentCompares = isset($experiment) ? $experiment->compares->mapWithKeys(function ($compare) use($value) {
            return $compare->left_kpi_id === $value->id ? [$compare->right_kpi_id => $compare->pivot->value] : [];
        }) : [])
        @php($compares = $value->compares->pluck('value', 'right_kpi_id'))
        @for($index = $key + 1; $index < count($kpis); $index++)
            @php($use = isset($experiment) ? $value->pivot->use && $kpis[$index]->pivot->use : true)
            @php($inputValue = $use ? $experimentCompares[$kpis[$index]->id] ?? ($compares[$kpis[$index]->id] ?? 0) : '')
            <tr {{ $use ? '' : 'class=hidden' }}>
                <td>{{ $value->name }}</td>
                <td>
                    <input name="compares[{{ $value->id }}][{{ $kpis[$index]->id }}]" type="text"
                           data-slider-min="-5"
                           data-slider-value="{{ $inputValue  }}"
                           data-slider-max="5"
                           data-slider-step="1"
                           value="{{ $inputValue }}">
                </td>
                <td>{{ $kpis[$index]->name }}</td>
            </tr>
        @endfor
    @endforeach
    </tbody>
</table>

@push('styles')
{{ Html::style('js/lib/bootstrap-slider/slider.css') }}
@endpush

@push('scripts')
{{ Html::script('js/lib/bootstrap-slider/bootstrap-slider.js') }}
<script>
    $('[name*="compares"]').slider({
        //formatter: (value) => { Math.abs(value) },
        ticks_tooltip: true
    });
</script>
@endpush