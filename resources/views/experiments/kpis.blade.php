<div class="row">
    <h2>Используемые Kpi</h2>
    <table class="table">
        <tr>
            <th>КПИ</th>
            <th>Используется</th>
            <th>Целевое значение</th>
            @if(!$edit)
                <th>Важность</th>
            @endif
        </tr>
        @foreach($experiment->kpis as $kpi)
            <tr>
                <td>{{ $kpi->name }}</td>
                @if(!$edit)
                    <td>{{ $kpi->pivot->use ? 'Да' : 'Нет' }}</td>
                    <td>{{ $kpi->pivot->target_value }}</td>
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
                        {{ Form::hidden("kpis[$kpi->id][importance]", old("kpis[$kpi->id][importance]") ?? $kpi->pivot->importance) }}
                    </td>
                @endif
            </tr>
        @endforeach
        @foreach($kpis as $kpi)
            <tr>
                <td>{{ $kpi->name }}</td>
                @if(!$edit)
                    <td>Нет</td>
                    <td>{{ $kpi->companies[0]->pivot->target_value }}</td>
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
    </table>
</div>