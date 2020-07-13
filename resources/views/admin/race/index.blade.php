@extends('layouts.app')

@section('title', __('Admin') . ' - ' . __('Race'))

@section('nav-title', __('Admin'))

@section('content')
<div class="container">
	<div class="row">
		<div class="col">
			@if( session('success') )
				<div class="alert alert-success">
					{{ session('success') }}
				</div>
			@endif

			<form action="{{ route('admin.race.index') }}" method="get">
				<select name="season" onchange="return this.form.submit();">
					@forelse( $seasons as $season )
						<option{{ $season->is( $currentSeason ) ? ' selected' : '' }} value="{{ $season->id }}">{{ $season->year }}</option>
					@empty
						<option value="0">@lang('No seasons have been found')</option>
					@endforelse
				</select>
				<noscript>
					<button type="submit" class="btn btn-primary">
						@lang('Send')
					</button>
				</noscript>
			</form>

			{{ $races->links() }}

			<table class="table table-striped table-hover mt-3">
				<thead>
				<tr>
					<th class="col-sm-2">@lang('Race time')</th>
					<th class="col-sm-2">@lang('Status')</th>
					<th>@lang('Name')</th>
					<th class="col-sm-3">@lang('Circuit')</th>
					<th class="col-sm-2 text-center">
						<a href="{{ route('admin.race.create', [ 'season' => $currentSeason->id ]) }}" title="@lang('Add race')">
							<span class="fa fa-plus"></span>
						</a>
					</th>
				</tr>
				</thead>
				<tbody>
				@forelse( $races as $race )
					<tr>
						<td>
							{{ $race->start_time }}
						</td>
						<td>
							@switch($race->status)
								@case('scheduled')
								<span class="text-info">@lang('Scheduled')</span>
								@break
								@case('postponed')
								<span class="text-warning">@lang('Postponed')</span>
								@break
								@case('cancelled')
								<span class="text-danger">@lang('Cancelled')</span>
								@break
							@endswitch
						</td>
						<td>
							<a href="{{ route('admin.race.edit', [ 'race' => $race->id ]) }}" title="@lang('Edit race')">
								{{ $race->name }}
							</a>
						</td>
						<td>
							{{ $race->circuit->name }}
						</td>
						<td class="text-center">
							<a href="{{ route('admin.race.edit', [ 'race' => $race->id ]) }}" title="@lang('Edit race')">
								<span class="fa fa-edit"></span>
							</a>
							&nbsp;
							<a href="{{ route('admin.race.session.index', [ 'race' => $race->id ]) }}" title="@lang('To race sessions')">
								<span class="fa fa-th-list"></span>
							</a>
						</td>
					</tr>
				@empty
					<tr>
						<td colspan="4" class="text-center">
							<p>
								@lang('No races have been found')
							</p>
							@if($previousSeasons)
								<p>
									@lang('Copy races from season:')
								</p>
								<form action="{{ route('admin.race.copy-season') }}" method="post">
									{{ csrf_field() }}
									<input type="hidden" name="season" value="{{ $currentSeason->id }}"/>
									<select name="copyFromSeason">
										@foreach($previousSeasons as $previousSeason)
											<option value="{{ $previousSeason->id }}">{{ $previousSeason->year }}</option>
										@endforeach
									</select>
									<button type="submit" class="btn btn-primary">
										@lang('Send')
									</button>
								</form>
							@endif
						</td>
					</tr>
				@endforelse
				</tbody>
			</table>

			{{ $races->links() }}
		</div>
	</div>
</div>
@endsection
