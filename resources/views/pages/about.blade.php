@extends('master')
@section('pageTitle','About Us')
@section('content')
	<div id="aboutpage">
		<div class="frame frame1">
			<div class="banner lozad" data-background-image="{{ isset($item) ? url('storage/'.$item->content) : '' }}">
				<div class="vertical-parent">
					<div class="vertical-align">
						<h1 class="white center-align js-fadeIn-onload">About Us</h1>
					</div>
				</div>
			</div>
		</div>
		<div class="frame frame2">
			<div class="frame__inner">
				<div class="frame2__items">
					@isset($contents)
					@foreach($contents as $index => $content)
					@if($index%2 == 0)
					<div class="frame2__item m-margin-b s-padding-tb inlineBlock-parent by-2">
						<div class="center-align">
							<div class="lozad img__round js-fadeIn-onload" data-background-image="{{ url('storage/'.$content->image) }}">
									
							</div>
						</div
						><div class="center-align">
							<div class="img__desc ">
								<h5 class="js-fadeIn-onload">{{ $content->content }}</h5>
							</div>
							<div class="red__line_bottom js-fadeIn-onload"></div>
						</div>
					</div>
					@else
					<div class="frame2__item m-margin-b s-padding-tb inlineBlock-parent by-2">
						<div class="center-align">
							<div class="img__desc ">
								<h5 class="js-fadeIn-onload">{{ $content->content }}</h5>
							</div>
							<div class="red__line_bottom js-fadeIn-onload"></div>
						</div
						><div class="center-align">
							<div class="lozad img__round js-fadeIn-onload" data-background-image="{{ url('storage/'.$content->image) }}">
									
							</div>
						</div>
					</div>
					@endif
					@endforeach
					@endisset
				</div>
			</div>
		</div>
		<div class="frame frame3">
			@include('includes.building_location_map')
		</div>
	</div>
@endsection

