@section('extra-links')
    <li><a href="{{ url("subdivisions/$subdivision->id/budgets/create") }}">@lang('new_budget_btn')</a></li>
@endsection