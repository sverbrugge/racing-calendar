@extends('layouts.app')

@section('title', __('Admin') . ' - ' . __('Race') . ' - ' . __('Add race'))

@section('nav-title', __('Admin'))

@section('content')
<div class="container">
	<div class="row">
		<form class="form-horizontal" action="{{ route('admin.race.update', [ 'race' => $race->id ]) }}" method="post">
			{{ csrf_field() }}
			{{ method_field('PUT') }}
			
			<h1 class="text-center">@lang('Edit race')</h1>
			
			<input type="hidden" name="season_id" value="{{ $race->season->id }}">
		
			@component('input.text')
				@slot('field', 'year')
				@slot('label', __('Year'))
				@slot('value', $race->season->year)
				
				disabled
			@endcomponent
			
			@component('input.datetime')
				@slot('field', 'start_time')
				@slot('label', __('Race time'))
				@slot('value', $race->start_time);
				
				required
			@endcomponent
			
			@component('input.text')
				@slot('field', 'name')
				@slot('label', __('Name'))
				@slot('value', $race->name);
				
				required
			@endcomponent
			
			@component('input.select')
				@slot('field', 'circuit_id')
				@slot('label', __('Circuit'))
				@slot('value', $race->circuit);
				
				@slot('options', $circuits)
				@slot('option_label', 'fullName')
			@endcomponent
			
			@component('input.submit')
				@slot('label', __('Edit race'))
				@slot('cancel', route('admin.race.index', [ 'season' => $race->season->id ]))
			@endcomponent
		</form>
	</div>
</div>
@endsection
