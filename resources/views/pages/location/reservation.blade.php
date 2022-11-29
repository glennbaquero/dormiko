@extends('master')
@section('pageTitle','Reservation')
@section('content')
	<div id="reservationpage">
		<div class="frame frame1">
			<div class="banner lozad" data-background-image="{{ url($location->reservation_banner_image) }}">
				<h5 class="breadcrumb header__margin white font-s js-fadeIn-onload">Location > {{ $building->name }} > Reservation</h5>
				<div class="vertical-parent">
					<div class="vertical-align">
						<h1 class="white center-align js-fadeIn-onload">Reservation</h1>
					</div>
				</div>
			</div>
		</div>
		<div class="frame frame2">
			<div class="frame__inner">
				<div class="inlineBlock-parent by-2">
					<div class="reservation__form_col">
						<div class="reservation__form">
							<h5 class="dark-blue s-padding-b js-fadeIn-onload">Reservation</h5>
							<reservation
								:roomtype="{{ $room->room_type }}"
								:building="{{ $building->id }}"
								:reservationurl="'{{ route('reservation.store') }}'"
								:date_today="'{{ date('Y-m-d') }}'">
							</reservation>
						</div>
					</div
					><div class="reservation__summary_col">
						<div class="reservation__summary">
							<h5 class="white js-fadeIn-onload">Summary</h5>
							<div class="summary__item s-margin-t inlineBlock-parent by-2">
								<div class="summary__item_img lozad" data-background-image="{{ $room->renderImage() }}">
									
								</div
								><div class="summary__item_desc js-fadeIn-onload">
									<h6 class="dark-blue font-s">{{ $room->min('beds') }} - {{ $room->max('beds') }} BED</h6>
									<p class="dark-blue font-xxs xs-padding-tb">{{ $room->description }}</p>
									<h6 class="font-s dark-blue xs-padding-b">{{ $room->where('room_type', $room->room_type)->min('price_range_from') }} - {{ $room->where('room_type', $room->room_type)->max('price_range_from') }}</h6>
									<h6 class="dark-blue font-xxs">PERSON</h6>
									<h6 class="dark-blue font-xxs">PER MONTH</h6>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="frame frame3">
			@include('includes.building_location_map')
		</div>
	</div>
@endsection

