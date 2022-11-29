@extends('master')
@section('pageTitle', 'Gallery')
@section('content')
	<div id="gallerypage">
		<div class="frame frame1">
			<div class="banner lozad" data-background-image="{{ $item->gallery_banner_image }}">
				<div class="vertical-parent">
					<div class="vertical-align">
						<h1 class="white center-align js-fadeIn-onload">Gallery</h1>
					</div>
				</div>
			</div>
		</div>
		<div class="frame2">
			<div class="frame__inner center-align">
				<h1 class="dark-blue js-fadeIn-onload">{{ $item->gallery_frame_2_header }}</h2>
				<h6 class="font-s js-fadeIn-onload">{{ $item->gallery_frame_2_sub_header }}</h6>
				<div class="building__items m-margin-t">
					
					@foreach($galleries as $gallery)
					<div class="building__item l-margin-b">
						@foreach($gallery->images as $image)
						<div class="building__img lozad js-fadeIn-onload" data-src="{{ url('storage/'.$image->image) }}" data-background-image="{{ url('storage/'.$image->image) }}">						
						</div>
						@endforeach
						<div class="building__desc left-align">
							<h6 class="dark-blue js-fadeIn-onload">{{ $gallery->header }}</h6>
							<p class="dark-blue xs-padding-t js-fadeIn-onload">{{ $gallery->description }}</p>
							
						</div>
					</div>
					@endforeach
				</div>
			</div>
		</div>
	</div>
@endsection
