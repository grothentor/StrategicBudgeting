@section('extra-links')
    <li><a href="{{ url("budgets/$budget->id/budget-values/$subdivision->id/create") }}">Новое значение</a></li>
@endsection