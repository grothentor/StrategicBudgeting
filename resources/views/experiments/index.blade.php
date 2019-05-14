@extends('layouts.app')

@section('title', __('experiments'))

@section('content')  

	@include('experiments.navigation')

	<table class="table table-striped table-bordered">
	    <thead>
	        <tr>
	            <th>@lang('id')</th>
	            <th>@lang('title')</th>
				<th>@lang('experiment_start')</th>
				<th>@lang('tax_title')</th>
				<th>@lang('company_budget')</th>
	            <th class="actions-col">@lang('actions')</th>
	        </tr>
	    </thead>
	    <tbody>
	    @foreach($experiments as $key => $value)
	        <tr>
	            <td>{{ $value->id }}</td>
	            <td><a class="" href="{{ url('experiments/' . $value->id) }}">{{ $value->name }}</a></td>
				<td>{{ $value->date }}</td>
				<td>{{ $value->tax * 100 }}%</td>
				<td>{{ $value->budget }}</td>
	            <td>
	                <a class="btn btn-small btn-default pull-left" href="{{ url('experiments/' . $value->id . '/compares/' ) }}">
						@lang('compares')
					</a>
					<a class="btn btn-small btn-info pull-left" href="{{ url('experiments/' . $value->id . '/edit/' ) }}">
						@lang('edit')
					</a>
	                {{ Form::open(['url' => 'experiments/' . $value->id, 'method' => 'delete', 'class' => 'pull-left']) }}
				    	{{ Form::submit(__('delete'), array('class' => 'btn btn-danger')) }}
					{{ Form::close() }}
	            </td>
	        </tr>
	    @endforeach
	    </tbody>
	</table>
@endsection