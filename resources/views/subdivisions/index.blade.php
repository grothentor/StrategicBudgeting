@extends('layouts.app')

@section('title', __('subdivisions'))

@section('content')  

	@include('subdivisions.navigation')

	<table class="table table-striped table-bordered">
	    <thead>
	        <tr>
	            <th>@lang('id')</th>
	            <th>@lang('title')</th>
	            <th class="actions-col">@lang('actions')</th>
	        </tr>
	    </thead>
	    <tbody>
	    @foreach($subdivisions as $key => $value)
	        <tr>
	            <td>{{ $value->id }}</td>
	            <td><a class="" href="{{ url('subdivisions/' . $value->id) }}">{{ $value->name }}</a></td>
	            <td>
	                <a class="btn btn-small btn-info pull-left" href="{{ url('subdivisions/' . $value->id . '/edit/' ) }}">
						@lang('edit')
					</a>
	                {{ Form::open(['url' => 'subdivisions/' . $value->id, 'method' => 'delete', 'class' => 'pull-left']) }}
				    	{{ Form::submit(__('delete'), array('class' => 'btn btn-danger')) }}
					{{ Form::close() }}
	            </td>
	        </tr>
	    @endforeach
	    </tbody>
	</table>
@endsection