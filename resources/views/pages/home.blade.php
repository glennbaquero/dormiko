@extends('master')
@section('pageTitle','Home')
@section('content')
	<div id="homepage">
		<div class="frame frame1">
			<div class="banner__slider">

				@foreach($carousels as $carousel)
					@foreach($carousel->images as $image)
						<div class="banner lozad" data-background-image="{{ url($image->renderFilePath()) }}">
							<div class="banner__text">
								<h1 class="white js-fadeIn-onload">{!! $carousel->content !!}</h1>
							</div>
						</div>
					@endforeach
				@endforeach
			</div>
		</div>
		<div class="frame frame2">
			<div class="frame__inner">
				<div class="m-auto center-align">
					<h5 class="font-domine js-fadeIn-onload">ABOUT US</h5>
					<div class="s-margin-tb">
						<h1 class="font-didact font--big js-fadeIn-onload">{!! $item->frame2_home !!}</h1>
					</div>
					<a href="{{ route('aboutpage') }}">
						<button class="btn btn--dark-blue js-fadeIn-onload">Get to know your dorm</button>
					</a>
				</div>
			</div>
		</div>
		<div class="frame frame3">
			<div class="frame__inner">
				<div class="m-auto">
					<h5 class="font-domine center-align js-fadeIn-onload">BUILDINGS</h5>
					<div class="building__tabs m-margin-t">
						<div class="tab__header">
							@foreach($all_buildings as $building)<div class="tab__header_item" data-tab-id="{{ $building->id }}">
								<div class="vertical-parent">
									<h5 class="vertical-align js-fadeIn-onload">{{ $building->name }}</h5>
								</div>
							</div
							>@endforeach
						</div>
						<div class="tab__content">
							{{-- <i class="ion ion-chevron-left arrow-prev" style="z-index: 9999;"></i>
							<i class="ion ion-chevron-right arrow-next" style="z-index: 9999;"></i> --}}
							@foreach($all_buildings as $building)
							<div class="tab__content_item" data-tabcontent-id="{{ $building->id }}">
								<div class="tab__content_slider">
									{{-- @foreach($building->rooms as $room) --}}
									{{-- @if($room->where('room_type', $room->room_type)->count() > 1) --}}
									<div class="tab__content_slider_inner inlineBlock-parent by-2" data-tabcontent-id="{{ $building->id }}">
										<div class="tab__content_img_col">
											<div class="building_img_slider">
												{{-- @foreach($building->rooms as $room) --}}
												<div class="building_img lozad {{ $building->isAvailableReturnCSSClass() }}" data-background-image="{{ $building->images ? $building->images->renderImage() : '' }}">
													
												</div>
												{{-- @endforeach --}}
											</div>
										</div
										><div class="tab__content_description">
											<div class="tab__content_description_inner s-padding">
												<div class="s-margin-b js-fadeIn-onload">
													<p class="gray font-xs">Building Name</p>
													<h5 class="dark-blue">{{ $building->name }}</h5>
													<h5 class="font-xs dark-blue">{{ $building->locationpage }}</h5>
												</div>
												<div class="s-margin-b js-fadeIn-onload">
													<p class="gray font-xs">Unit Type</p>
													@foreach($building->rooms->unique('room_type') as $room)
														@if($room->where('room_type', $room->room_type)->count() > 1)
															<h5 class="dark-blue">
																{{ $room->renderType() }} 
																<small>
																	(&#8369; {{ $building->rooms->where('room_type', $room->room_type)->min('price_range_from') }} - &#8369; {{ $building->rooms->where('room_type', $room->room_type)->max('price_range_from') }}) 
																</small>
															</h5>
															<h5 class="dark-blue"></h5> 
														@endif
													@endforeach
												</div>
												{{-- <div class="s-margin-b inlineBlock-parent by-2">
													<div class="js-fadeIn-onload">
														<p class="gray font-xs">Price</p>

													</div
													><div class="center-align desktop_display js-fadeIn-onload">
													</div>
												</div> --}}
												<div class="">
													<div style="width: 40%" class="desktop_display">
														<h5 class="font-xs xs-padding-b">Get Directions</h5>
														<a href="https://maps.google.com/maps?q={{ $building->latitude }},{{ $building->longitude }}" target="_blank" style="pointer-events: visible;"> 
															<img class="img_map_link lozad" data-src="{{ asset('images/google_map.svg') }}" alt="Google map">
														</a>
														<a href="{{ $building->waze_link }}" target="_blank" style="pointer-events: visible;">
															<img class="img_map_link lozad" data-src="{{ asset('images/waze.svg') }}" alt="Waze">	
														</a>
													</div
													><div style="width: 60%">
														{{-- <a href="{{ route('location.reservation', [$building, $room]) }}" class="{{ $building->isAvailableReturnCSSClass() }}">
															<button class="btn btn--orange js-fadeIn-onload {{ $building->isAvailableReturnCSSClass() }}">Reserve Now</button>
														</a> --}}
													</div>
												</div>
												
												<div class="center-align s-margin-t mbl_display js-fadeIn-onload">
													<h5 class="font-xs s-padding-b">Get Directions</h5>
													<a href="https://maps.google.com/maps?q={{ $building->latitude }},{{ $building->longitude }}" target="_blank">
														<img class="img_map_link lozad" data-src="{{ asset('images/google_map.svg') }}" alt="Google map">
													</a>
													<a href="{{ $building->waze_link }}" target="_blank">
														<img class="img_map_link lozad" data-src="{{ asset('images/waze.svg') }}" alt="Waze">
													</a>

												</div>
											</div>
										</div>
									</div>
									{{-- @endif --}}
									{{-- @endforeach --}}
								</div>
								{{-- @include('includes.slider-arrows') --}}
							</div>
							@endforeach
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="frame frame4">
			<div class="frame4__right">
				<div class="frame4__right_inner">
					<h6 class="font-domine js-fadeIn-onload" style="text-align: center">AMENITIES</h6>
					<div class="s-margin-tb">
						<h1 class="font-didact font-xl js-fadeIn-onload" style="text-align: center">Things you'll love at dormiko</h1>
					</div>
					<div class="amenities__icons m-margin-t">
						<div class="amenities__icons_slider">
							@foreach($amenities->unique('name') as $amenity)@if($amenity->image)<div class="amenities__icon_content inlineBlock-parent">
								<div>
									<img class="lozad" data-src="{{ asset('storage/'.$amenity->image) }}">
								</div
								><div class="s-padding-l">
									<h6 class="font-xs">{{ $amenity->name }}</h6>
								</div>
							</div
							>@endif @endforeach
						</div>
						@include('includes.slider-arrows')
					</div>
				</div>
			</div>
		</div>
		<div class="frame frame5">
			<div class="vertical-parent">
				<div class="vertical-align">
					<div class="frame__inner center-align">
						<h6 class="font-domine font-m js-fadeIn-onload">MONTHLY COST</h6>
						<div class="s-margin-tb">
							<h1 class="font-didact font-xl js-fadeIn-onload">Pocket-Friendly Rates</h1>
						</div>
						<div class="monthly__cost m-margin-t">
							<div class="inlineBlock-parent by-3">
								<div class="monthly__cost_item js-fadeIn-onload">
									<div>
										<img class="lozad" data-src="{{ url($item->frame5_pocket_friendly_rent_image) }}" style="width: 15vh" alt="Icon">
										<div class="xs-margin-tb">
											<h5 class="font-m dark-blue">Rental Fee</h5>
										</div>
										<p class="font-xs dark-blue">{{ $item->frame5_pocket_friendly_rent_body }}</p>
									</div>	
								</div
								><div class="monthly__cost_item js-fadeIn-onload"> 
									<div>
										<img class="lozad" data-src="{{ url($item->frame5_pocket_friendly_utilities_image) }}" style="width: 15vh" alt="Icon">
										<div class="xs-margin-tb">
											<h5 class="font-m dark-blue">Utilities</h5>
										</div>
										<p class="font-xs dark-blue">{{ $item->frame5_pocket_friendly_utilities_body }}</p>
									</div>
								</div
								><div class="monthly__cost_item js-fadeIn-onload">
									<div>
										<img class="lozad" data-src="{{ url($item->frame5_pocket_friendly_payment_image) }}" style="width: 15vh" alt="Icon">
										<div class="xs-margin-tb">
											<h5 class="font-m dark-blue">Payment</h5>
										</div>
										<p class="font-xs dark-blue">{{ $item->frame5_pocket_friendly_payment_body }}</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="frame frame6">
			<div class="frame__inner">
				<div class="center-align m-margin-b">
					<h6 class="font-domine font-m js-fadeIn-onload">PHOTO GALLERY</h6>
					<div class="s-margin-tb">
						<h1 class="font-didact font-xl js-fadeIn-onload">Catch a first glimpse of your home</h1>
					</div>
				</div>
				<div class="photo__gallery">
					<div class="photo__gallery_top">
						<div class="photo__gallery_top_left">
							<div class="photo__gallery_img lozad img__grayscale" data-background-image="{{ url($item->home_last_frame_pg_main_picture) }}">
								<div class="vertical-parent bottom__title_top_overlay">
									<div class="vertical-align center-align js-fadeIn-onload">
										<h3 class="dark-blue">{!! !empty($item->home_last_frame_pg_main_picture_title) == 1 ? $item->home_last_frame_pg_main_picture_title : '' !!}</h3>
										<p class="dark-blue font-xs xs-padding-t">{!! !empty($item->home_last_frame_pg_main_picture_description) == 1 ? $item->home_last_frame_pg_main_picture_description : '' !!}</p>
									</div>
								</div>

								@if(!empty($item->home_last_frame_pg_main_picture_model_description))
									<div class="bottom__title_overlay bg-red-dim js-fadeIn-onload">
										<div class="vertical-parent">
											<div class="vertical-align s-padding-l">
												<h6 class="white font-s">{!! !empty($item->home_last_frame_pg_main_picture_model_unit) == 1 ? $item->home_last_frame_pg_main_picture_model_unit : '' !!}</h6>
												<h6 class="white font-xs xs-padding-t">{!! $item->home_last_frame_pg_main_picture_model_description	 !!} </h6>
											</div>
										</div>
									</div>
								@endif
							</div>
						</div
						><div class="photo__gallery_top_right">
							<div class="photo__gallery_top_right_top">
								<div class="photo__gallery_img lozad img__grayscale" data-background-image="{{ url($item->home_last_frame_pg_right_first_picture) }}">
									<div class="vertical-parent bottom__title_top_overlay">
	                                    <div class="vertical-align center-align js-fadeIn-onload">
	                                        <h3 class="dark-blue">{!! !empty($item->home_last_frame_pg_right_first_picture_title) == 1 ? 
	                                        $item->home_last_frame_pg_right_first_picture_title : '' !!}</h3>
	                                        <p class="dark-blue font-xs xs-padding-t">{!! !empty($item->home_last_frame_pg_right_first_picture_description) == 1 ? $item->home_last_frame_pg_right_first_picture_description : ''  !!}</p>
	                                    </div>
	                                </div>
	                                @if(!empty($item->home_last_frame_pg_right_first_picture_model_description))
		                                <div class="bottom__title_overlay bg-red-dim js-fadeIn-onload">
		                                    <div class="vertical-parent">
		                                        <div class="vertical-align s-padding-l">
		                                            <h6 class="white font-s">{!! !empty($item->home_last_frame_pg_right_first_picture_model_unit) == 1 ? $item->home_last_frame_pg_right_first_picture_model_unit : '' !!}</h6>
		                                            <h6 class="white font-xs xs-padding-t">{!! $item->home_last_frame_pg_right_first_picture_model_description !!} </h6>
		                                        </div>
		                                    </div>
		                                </div>
	                                @endif
								</div>	
								
							</div>
							<div class="photo__gallery_top_right_bottom inlineBlock-parent">
								<div class="photo__gallery_top_right_bottom_left">
									<div class="photo__gallery_img lozad img__grayscale" data-background-image="{{ url($item->home_last_frame_pg_right_second_picture) }}">
										<div class="vertical-parent bottom__title_top_overlay">
		                                    <div class="vertical-align center-align js-fadeIn-onload">
		                                        <h3 class="dark-blue">{!! !empty($item->home_last_frame_pg_right_second_picture_title) == 1 ? $item->home_last_frame_pg_right_second_picture_title : '' !!}</h3>
		                                        <p class="dark-blue font-xs xs-padding-t">{!! !empty($item->home_last_frame_pg_right_second_picture_description) == 1 ? $item->home_last_frame_pg_right_second_picture_description : '' !!}</p>
		                                    </div>
		                                </div>
		                                @if(!empty($item->home_last_frame_pg_right_second_picture_model_description))
			                                <div class="bottom__title_overlay bg-red-dim js-fadeIn-onload">
			                                    <div class="vertical-parent">
			                                        <div class="vertical-align s-padding-l">
			                                            <h6 class="white font-s">{!! !empty($item->home_last_frame_pg_right_second_picture_model_unit) == 1? $item->home_last_frame_pg_right_second_picture_model_unit : '' !!}</h6>
			                                            <h6 class="white font-xs xs-padding-t">{!! !empty($item->home_last_frame_pg_right_second_picture_model_description) == 1 ? $item->home_last_frame_pg_right_second_picture_model_description : '' !!} </h6>
			                                        </div>
			                                    </div>
			                                </div>
		                                @endif
									</div>
									
								</div
								><div class="photo__gallery_top_right_bottom_right">
									<div class="photo__gallery_img lozad img__grayscale" data-background-image="{{ url($item->home_last_frame_pg_right_third_picture) }}">
										<div class="vertical-parent bottom__title_top_overlay">
		                                    <div class="vertical-align center-align js-fadeIn-onload">
		                                        <h3 class="dark-blue">{!! !empty($item->home_last_frame_pg_right_third_picture_title) == 1 ? $item->home_last_frame_pg_right_third_picture_title : ''!!}</h3>
		                                        <p class="dark-blue font-xs xs-padding-t">{!! !empty($item->home_last_frame_pg_right_third_picture_description) == 1 ? $item->home_last_frame_pg_right_third_picture_description : '' !!}</p>
		                                    </div>
		                                </div>
		                                @if(!empty($item->home_last_frame_pg_right_third_picture_model_description))
			                                <div class="bottom__title_overlay bg-red-dim js-fadeIn-onload">
			                                    <div class="vertical-parent">
			                                        <div class="vertical-align s-padding-l">
			                                            <h6 class="white font-s">{!! !empty($item->home_last_frame_pg_right_third_picture_model_unit) == 1 ? $item->home_last_frame_pg_right_third_picture_model_unit : '' !!}</h6>
			                                            <h6 class="white font-xs xs-padding-t">{!! $item->home_last_frame_pg_right_third_picture_model_description !!} </h6>
			                                        </div>
			                                    </div>
			                                </div>
		                                @endif
									</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="photo__gallery_bottom s-margin-t">
						<div class="photo__gallery_img lozad img__grayscale" data-background-image="{{ url($item->home_last_frame_pg_bottom_first_picture) }}">
							<div class="vertical-parent bottom__title_top_overlay">
                                <div class="vertical-align center-align js-fadeIn-onload">
                                    <h3 class="dark-blue">{!! !empty($item->home_last_frame_pg_bottom_first_picture_title) == 1 ? $item->home_last_frame_pg_bottom_first_picture_title : '' !!}</h3>
                                    <p class="dark-blue font-xs xs-padding-t">{!! !empty($item->home_last_frame_pg_bottom_first_picture_description) == 1 ? $item->home_last_frame_pg_bottom_first_picture_description : '' !!}</p>
                                </div>
                            </div>

                            @if(!empty($item->home_last_frame_pg_bottom_first_picture_model_description))
	                            <div class="bottom__title_overlay bg-red-dim js-fadeIn-onload">
	                                <div class="vertical-parent">
	                                    <div class="vertical-align s-padding-l">
	                                        <h6 class="white font-s">{!! !empty($item->home_last_frame_pg_bottom_first_picture_model_unit) == 1 ? $item->home_last_frame_pg_bottom_first_picture_model_unit : '' !!}</h6>
	                                        <h6 class="white font-xs xs-padding-t">{!! $item->home_last_frame_pg_bottom_first_picture_model_description !!} </h6>
	                                    </div>
	                                </div>
	                            </div>
                            @endif
						</div
						><div class="photo__gallery_img lozad img__grayscale" data-background-image="{{ url($item->home_last_frame_pg_bottom_second_picture) }}">
							<div class="vertical-parent bottom__title_top_overlay">
                                <div class="vertical-align center-align js-fadeIn-onload">
                                    <h3 class="dark-blue">{!! !empty($item->home_last_frame_pg_bottom_second_picture_title) == 1 ? $item->home_last_frame_pg_bottom_second_picture_title : '' !!}</h3>
                                    <p class="dark-blue font-xs xs-padding-t">{!! !empty($item->home_last_frame_pg_bottom_second_picture_description) == 1 ? $item->home_last_frame_pg_bottom_second_picture_description : '' !!}</p>
                                </div>
                            </div>
                            @if(!empty($item->home_last_frame_pg_bottom_second_picture_model_description))
	                            <div class="bottom__title_overlay bg-red-dim js-fadeIn-onload">
	                                <div class="vertical-parent">
	                                    <div class="vertical-align s-padding-l">
	                                        <h6 class="white font-s">{!! !empty($item->home_last_frame_pg_bottom_second_picture_model_unit) == 1 ? $item->home_last_frame_pg_bottom_second_picture_model_unit : '' !!}</h6>
	                                        <h6 class="white font-xs xs-padding-t">{!! $item->home_last_frame_pg_bottom_second_picture_model_description !!} </h6>
	                                    </div>
	                                </div>
	                            </div>
                            @endif
						</div
						><div class="photo__gallery_img lozad img__grayscale" data-background-image="{{ url($item->home_last_frame_pg_bottom_third_picture) }}">
							<div class="vertical-parent bottom__title_top_overlay">
                                <div class="vertical-align center-align js-fadeIn-onload">
                                    <h3 class="dark-blue">{!! !empty($item->home_last_frame_pg_bottom_third_picture_title) == 1 ? $item->home_last_frame_pg_bottom_third_picture_title : '' !!}</h3>
                                    <p class="dark-blue font-xs xs-padding-t">{!! !empty($item->home_last_frame_pg_bottom_third_picture_description) == 1 ? $item->home_last_frame_pg_bottom_third_picture_description : '' !!}</p>
                                </div>
                            </div>
                            @if(!empty($item->home_last_frame_pg_bottom_third_picture_model_description))
	                            <div class="bottom__title_overlay bg-red-dim js-fadeIn-onload">
	                                <div class="vertical-parent">
	                                    <div class="vertical-align s-padding-l">
	                                        <h6 class="white font-s">{!! !empty($item->home_last_frame_pg_bottom_third_picture_model_unit) == 1 ? $item->home_last_frame_pg_bottom_third_picture_model_unit : '' !!}</h6>
	                                        <h6 class="white font-xs xs-padding-t">{!! $item->home_last_frame_pg_bottom_third_picture_model_description !!} </h6>
	                                    </div>
	                                </div>
	                            </div>
                            @endif
						</div>
					</div>
				</div>
				<div class="center-align m-margin-t mbl_display">
					<a href="{{ route('gallerypage') }}" class="show-all font-s">< Show All ></a>
				</div>
			</div>
		</div>
@endsection