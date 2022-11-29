@extends('master')
@section('pageTitle','Location')
@section('content')
	<div id="locationpage">
		<div class="frame frame1">
			@include('includes.building_location_map')
		</div>
		<div class="frame frame2">
			<div class="frame__inner">
				<p class="font-m mbl_location_padding js-fadeIn-onload">Buildings</p>
				<div class="building__items m-margin-t center-align">
					@foreach($buildings as $building)
					<div class="building__item l-margin-b left-align">
						@if($building->images)
							<div class="building__img {{ $building->isAvailableReturnCSSClass() }} lozad js-fadeIn-onload" data-src="{{ url('storage/'.$building->images->path) }}" data-background-image="{{ url('storage/'.$building->images->path) }}">						
							</div>
						@endif
						<div class="mbl_location_padding xs-padding-t">
							<h1 class="dark-blue js-fadeIn-onload">{{ $building->name }}
								<span class="font-xs dark-blue">{{ $building->availability === 1 ? 'Available' : 'Coming Soon' }}</span>
							</h1>
							<p class="dark-blue xs-padding-t js-fadeIn-onload" style="white-space: nowrap; width: 300px; overflow: hidden; text-overflow: ellipsis;">{!! $building->description !!}</p>
							<a href="{{ route('location.show', $building) }}">
								<button class="btn btn--dark-blue s-margin-t js-fadeIn-onload">View</button>
							</a>
						</div>
					</div>
					@endforeach
				</div>
			</div>
		</div>
	</div>
@endsection

