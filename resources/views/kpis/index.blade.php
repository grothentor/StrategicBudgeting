@extends('layouts.app')

@section('title', __('kpi_title'))

@section('content')  

	@include('kpis.navigation')

	<table class="table table-striped table-bordered">
	    <thead>
	        <tr>
	            <td rowspan="2">@lang('id')</td>
	            <td rowspan="2">@lang('title')</td>
				<td rowspan="2">@lang('target_value')</td>
				<td rowspan="2">@lang('importance')</td>
	            <td rowspan="2" class="actions-col">@lang('actions')</td>
	        </tr>
			{{--<tr>--}}
				{{--<td>Холдинга</td>--}}
				{{--<td>@lang('company')</td>--}}
			{{--</tr>--}}
	    </thead>
	    <tbody>
	    @foreach($kpis as $key => $value)
	        <tr>
	            <td>{{ $value->id }}</td>
	            <td><a class="" href="{{ url('kpis/' . $value->id) }}">{{ $value->name }}</a></td>
				{{--<td>{{ $value->holding_target_value }}</td>--}}
				<td>{{ $value->companyTargetValue }}</td>
				<td>{{ $value->companyImportance }}</td>
	            <td>
	                <a class="btn btn-small btn-info pull-left" href="{{ url('kpis/' . $value->id . '/edit/' ) }}">
						@lang('edit')
					</a>
	                {{ Form::open(['url' => 'kpis/' . $value->id, 'method' => 'delete', 'class' => 'pull-left']) }}
				    	{{ Form::submit(__('delete'), array('class' => 'btn btn-danger')) }}
					{{ Form::close() }}
	            </td>
	        </tr>
	    @endforeach
	    </tbody>
	</table>
@endsection