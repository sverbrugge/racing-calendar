@extends('layouts.app')

@section('title', __('Admin') . ' - ' . __('Race session') . ' - ' . __('Add session'))

@section('nav-title', __('Admin'))

@section('content')
<div class="container">
	<div class="row">
		<form class="form-horizontal" action="{{ route('admin.race.session.store', [ 'race' => $race ]) }}" method="post">
			{{ csrf_field() }}

			<h1 class="text-center">@lang('Add session')</h1>

			@component('input.datetime')
				@slot('field', 'start_time')
				@slot('label', __('Start time'))

				required autofocus
			@endcomponent

			@component('input.datetime')
				@slot('field', 'end_time')
				@slot('label', __('End time'))

				required
			@endcomponent

			@component('input.text')
				@slot('field', 'name')
				@slot('label', __('Name'))

				required
			@endcomponent

			@component('input.submit')
				@slot('label', __('Add session'))
				@slot('cancel', route('admin.race.session.index', [ 'race' => $race->id ]))
			@endcomponent
		</form>
	</div>
</div>
@endsection