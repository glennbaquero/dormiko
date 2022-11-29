@extends('master')
@section('pageTitle', $building->name)
@section('content')
	<div id="selected_building_page">
		<div class="frame frame1">
			<div class="location__image_cols inlineBlock-parent by-3">
			<h5 class="breadcrumb white font-s no-padding js-fadeIn-onload">Location > {{ $building->name }}</h5>
				<div class="location__image_col1">
					<div class="inlineBlock-parent by-2">
						<div class="location__image_holder">
							<div class="location__image lozad" data-background-image="{{ count($building->banners) >= 1 ? asset('storage/'.$building->banners[0]->image) : url($galleries->home_last_frame_pg_right_first_picture) }}">
								<div class="dim"></div>
							</div>
						</div
						><div class="location__image_holder">
							<div class="location__image lozad" data-background-image="{{ count($building->banners) >= 2 ? asset('storage/'.$building->banners[1]->image) : url($galleries->home_last_frame_pg_right_second_picture) }}">
								<div class="dim"></div>
							</div>
						</div>
					</div>
					<div class="location__image_holder">
						<div class="location__image lozad" data-background-image="{{ count($building->banners) >= 3 ? asset('storage/'.$building->banners[2]->image) : url($galleries->home_last_frame_pg_right_third_picture	) }}">
							<div class="dim"></div>
						</div>
					</div>
				</div
				><div class="location__image_col2">
					<div class="location__image_holder">
						<div class="location__image lozad" data-background-image="{{ count($building->banners) >= 4 ? asset('storage/'.$building->banners[3]->image) : url($galleries->home_last_frame_pg_main_picture) }}">
							<div class="dim"></div>
						</div>
						
					</div>
				</div
				><div class="location__image_col3">
					<div class="location__image_holder">
						<div class="location__image lozad" data-background-image="{{ count($building->banners) >= 5 ? asset('storage/'.$building->banners[4]->image) : url($galleries->home_last_frame_pg_bottom_first_picture) }}">
							<div class="dim"></div>
						</div>
					</div>
					<div class="location__image_holder">
						<div class="location__image lozad" data-background-image="{{ count($building->banners) >= 6 ? asset('storage/'.$building->banners[5]->image) : url($galleries->home_last_frame_pg_bottom_second_picture) }}">
							<div class="dim"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="mbl_display center-align s-margin-t">
			<h5 class="dark-blue js-fadeIn-onload">< View Photos ></h5>
		</div>
		<div class="frame frame2">
			<div class="frame__inner">
				
				<div class="frame2__items inlineBlock-parent by-2">
					<div class="dorm__col">
						@if($dorm)
						<p class="font-m m-padding-b js-fadeIn-onload">DORM</p>
						<div class="dorm__item">
							<div class="dorm__img lozad" data-background-image="{{ url('storage/'.$building->dormitory_image) }}">
								
							</div>
							<div class="bottom__title_overlay bg-black-dim">
								<div class="vertical-parent">
									<div class="vertical-align s-padding-l inlineBlock-parent by-2">
										<h6 class="white font-s js-fadeIn-onload">P{{ $min_dorm }} - {{ $max_dorm }} <span class="per-bed font-xs">PER BED</span></h6>
										<button onclick="location.href='{{ route('location.reservation', [$dorm->building, $dorm]) }}'" class="btn btn--dark-blue btn--outline js-fadeIn-onload {{ $dorm->building->isAvailableReturnCSSClass() }}">Reservation</button>
									</div>
								</div>
							</div>
						</div>
						@endif
						@if($studio)
						<div class="l-margin-tb"></div>
						<p class="font-m m-padding-b js-fadeIn-onload">STUDIO</p>
						<div class="dorm__item">
							<div class="dorm__img lozad" data-background-image="{{ url('storage/'.$building->studio_image) }}">
								
							</div>
							<div class="bottom__title_overlay bg-black-dim">
								<div class="vertical-parent">
									<div class="vertical-align s-padding-l inlineBlock-parent by-2">
										<h6 class="white font-s js-fadeIn-onload">P{{ $min_studio }} - {{ $max_studio }}</h6>
										<button onclick="location.href='{{ route('location.reservation', [$studio->building, $studio]) }}'" class="btn btn--dark-blue btn--outline js-fadeIn-onload {{ $studio->building->isAvailableReturnCSSClass() }}">Reservation</button>
									</div>
								</div>
							</div>
						</div>
						@endif
						@if($apartment)
						<div class="l-margin-tb"></div>
						<p class="font-m m-padding-b js-fadeIn-onload">Apartment</p>
						<div class="dorm__item">
							<div class="dorm__img lozad" data-background-image="{{ url('storage/'.$apartment->image) }}">
								
							</div>
							<div class="bottom__title_overlay bg-black-dim">
								<div class="vertical-parent">
									<div class="vertical-align s-padding-l inlineBlock-parent by-2">
										<h6 class="white font-s js-fadeIn-onload">P{{ $min_apartment }} - {{ $max_apartment }}</h6>
										<button onclick="location.href='{{ route('location.reservation', [$apartment->building, $apartment]) }}'" class="btn btn--dark-blue btn--outline js-fadeIn-onload {{ $apartment->building->isAvailableReturnCSSClass() }}">Reservation</button>
									</div>
								</div>
							</div>
						</div>
						@endif
					</div
					><div class="building__amenities">
						<div class="amenities__icons m-margin-t">
							<h1 class="dark-blue js-fadeIn-onload">{{ $building->name }}</h1>
							<h6 class="dark-blue s-padding-t font-m js-fadeIn-onload"></h6>
							<p class="s-padding-tb dark-blue font-xs js-fadeIn-onload">{!! $building->description !!}</p>
							<h6 class="dark-blue font-m s-padding-b js-fadeIn-onload">Amenities</h6>
							<div class="amenities__icon_item s-margin-b inlineBlock-parent by-2 js-fadeIn-onload">
								@foreach($building->amenity->unique('name') as $amenity)<div class="amenities__icon_content inlineBlock-parent s-margin-b">
									<div>
										<img class="lozad" data-src="{{ asset('storage/'. $amenity->image) }}" style="width: 7vh" alt="Amenities">
									</div>
									<div class="s-padding-l">
										<h6 class="font-s">{{ $amenity->name }}</h6>
									</div>
								</div
								>@endforeach
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="frame frame3 m-margin-t">
			@include('includes.building_location_map')
		</div>
		
	</div>
@endsection

