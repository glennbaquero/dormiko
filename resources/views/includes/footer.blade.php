<footer>
	<div class="footer__top bg-blue">
		{{-- <div class="vertical-parent"> --}}
			{{-- <div class="vertical-align"> --}}
				<div class="footer__top_cols transform-vertical-align">
					<div class="footer__top_col1">
						{{-- <img class="footer__logo" src="{{ asset('images/Dormiko_White.svg') }}" alt="Footer logo"> --}}
						<a href="{{ route('home') }}">
							@include('includes.svg_logo')
						</a>
					</div
					><div class="footer__top_col2">
						<a href="https://www.google.com/maps/@14.557389882036876,121.03960471484757,17z">
							<h6 class="font-xs white">{!! $main_address !!}</h6>
						</a>
						<a class="font-xs white" href="tel:+44 345 678 903">{!! $phone_number_one !!}</a><br>
						<a class="font-xs white" href="tel:(02) 123 4123">{!! $phone_number_two !!}</a><br>
						<a class="font-xs white" href="mailto:{!! $email !!}">{!! $email !!}</a>
					</div
					><div class="footer__top_col3">
						<ul>
							<li>
								<a class="white" href="{{ route('home') }}">Home</a>
							</li>
							<li>
								<a class="white" href="{{ route('aboutpage') }}">About Us</a>
							</li>
							<li>
								<a class="white" href="{{ route('locationpage') }}">Location</a>
							</li>
							<li>
								<a class="white" href="{{ route('gallerypage') }}">Gallery</a>
							</li>
						</ul>
					</div
					><!-- <div class="footer__top_col4">
						<ul>
							<li>
								<a class="white" href="">Terms & Conditions</a>
							</li>
							<li>
								<a class="white" href="">Privacy Policy</a>
							</li>
						</ul>
					</div
					> --><div class="footer__top_col5">
						<i class="ion-social-facebook white"></i>&nbsp;&nbsp;&nbsp;&nbsp;
						<a class="font-xs white" href="{!! $fb_link !!}">Facebook</a><br>
						
						<i class="ion-social-instagram white"></i>&nbsp;&nbsp;
						<a class="font-xs white" href="{!! $instagram_link !!}">Instagram</a><br>
					</div
					><div class="footer__top_col6">
						<h6 class="font-xs white xs-margin-b">Subscribe to our newsletter</h6>
						<subscription
						:storeurl="'{{ route('subscribe') }}'"></subscription>
					</div>
				</div>
			{{-- </div> --}}
		{{-- </div> --}}
	</div>
	<div class="footer__bottom bg-dark-blue">
		<div class="vertical-parent">
			<div class="vertical-align">
				<h6 class="font-xs white center-align">&copy; Dormiko 2018</h6>
			</div>
		</div>
	</div>
</footer>