<div class="row">
    <h2>@lang('using_kpis')</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>@lang('kpi')</th>
                <th>@lang('using')</th>
                <th>@lang('target_value')</th>
                @if(!$edit)
                    <th>@lang('found_value')</th>
                    <th>@lang('importance')</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($experiment->kpis as $kpi)
                <tr>
                    <td>{{ $kpi->name }}</td>
                    @if(!$edit)
                        <td>{{ $kpi->pivot->use ? __('yes') : __('no') }}</td>
                        <td>{{ round($kpi->pivot->target_value, 2) }}</td>
                        <td>{{ round($kpi->pivot->result_value, 2) }}</td>
                        <td>{{ round($kpi->pivot->importance, 2) }}</td>
                    @else
                        <td>
                            {{ Form::checkbox("kpis[$kpi->id][use]", 1, old("kpis[$kpi->id][use]") ?? $kpi->pivot->use,
                                ['class' => 'form-control', 'type' => 'checkbox']) }}
                        </td>
                        <td>{{ Form::text("kpis[$kpi->id][target_value]",
                            old("kpis[$kpi->id][target_value]") ?? $kpi->pivot->target_value,
                            ['class' => 'form-control']) }}</td>
                        <td class="hidden">
                            {{ Form::hidden("kpis[$kpi->id][result_value]", 0 )}}
                        </td>
                        <td class="hidden">
                            {{ Form::hidden("kpis[$kpi->id][importance]", old("kpis[$kpi->id][importance]") ?? $kpi->pivot->importance) }}
                        </td>
                    @endif
                </tr>
            @endforeach
            @foreach($kpis as $kpi)
                <tr>
                    <td>{{ $kpi->name }}</td>
                    @if(!$edit)
                        <td>@lang('no')</td>
                        <td>{{ $kpi->companies[0]->pivot->target_value }}</td>
                        <td>{{ $kpi->companies[0]->pivot->result_value }}</td>
                        <td>0</td>
                    @else
                        <td>
                            {{ Form::hidden("kpis[$kpi->id][importance]", old("kpis[$kpi->id][importance]") ?? $kpi->companies[0]->pivot->importance) }}
                            {{ Form::checkbox("kpis[$kpi->id][use]", 1, old("kpis[$kpi->id][use]") ?? false,
                                ['class' => 'form-control', 'type' => 'checkbox']) }}
                        </td>
                        <td>{{ Form::text("kpis[$kpi->id][target_value]",
                            old("kpis[$kpi->id][target_value]") ?? $kpi->companies[0]->pivot->target_value,
                            ['class' => 'form-control']) }}</td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>