@php
$experimentBudgets = $experiment->budgets->mapWithKeys(function($budget) {
    return [$budget->id => [
        'use' => $budget->pivot->use,
        'answer' => $budget->pivot->answer,
    ]];
});
@endphp

<div class="row">
    <h2>Используемые бюджеты</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Подразделение</th>
                <th>Бюджеты (жирным отмечен найденный ответ)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($subdivisions as $subdivision)
                <tr>
                    <td>{{ $subdivision->name }}</td>
                    <td>
                        @if($edit)
                            <select name="budgets[{{ $subdivision->id }}][]" multiple="multiple">
                                @foreach($subdivision->budgets as $budget)
                                    @continue('current' === $budget->type)
                                    <option value="{{ $budget->id }}"
                                            @if((count(old()) && old('budgets') && isset(old("budgets")[$subdivision->id]) && in_array($budget->id, old("budgets")[$subdivision->id]))||
                                            (!count(old()) && isset($experimentBudgets[$budget->id]) && $experimentBudgets[$budget->id]['use']))
                                                selected="selected"
                                            @endif>
                                        {{ $budget->name }}
                                    </option>
                                @endforeach
                            </select>
                        @else
                            @foreach($subdivision->budgets as $key => $budget)
                                @continue(!isset($experimentBudgets[$budget->id]) || !$experimentBudgets[$budget->id]['use'])
                                @if($experimentBudgets[$budget->id]['answer'])<b>@endif
                                {{ $budget->name  }}@if ($loop->last). @else, @endif
                                @if($experimentBudgets[$budget->id]['answer'])</b>@endif
                            @endforeach
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>