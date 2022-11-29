<header>
	<div class="header__inner vertical-parent">
		<div class="vertical-align">
			<div class="logo">
				<div class="logo__inner">
					<a href="/">
						@if($checker->isLocationPage())
						<div class="location__route">
							@include('includes.svg_logo')
						</div>
						@else
						<div class="regular__route">
							@include('includes.svg_logo')
						</div>
						@endif
					</a>
				</div>
				<div id="nav-icon1" class="mbl_display">
				  <span class="{{ $checker->renderBGColor() }}"></span>
				  <span class="{{ $checker->renderBGColor() }}"></span>
				  <span class="{{ $checker->renderBGColor() }}"></span>
				</div>
			</div
			><div class="menu">
				<ul class="menu__links">
					<li>
						<a href="{{ route('home') }}" class="{{ $checker->areOnRoutes(['homepage']) }} {{ $checker->renderMenuColor() }}">Home</a>
					</li>
					<li>
						<a href="{{ route('aboutpage') }}" class="{{ $checker->areOnRoutes(['aboutpage']) }} {{ $checker->renderMenuColor() }}">About Us</a>
					</li>
					<li>
						<a href="{{ route('locationpage') }}" class="{{ $checker->areOnRoutes(['locationpage','location.show']) }} {{ $checker->renderMenuColor() }}">Location 
						</a>&nbsp;&nbsp;&nbsp;
						<i class="location__dropdown_icon ion-arrow-down-b {{ $checker->renderMenuColor() }}"></i>
						<div class="location__dropdown_content">
							<ul>
								@foreach($all_buildings as $item)
								<li>
									<a href="{{ route('location.show', $item) }}" class="white semi-bold font-xs">{{ $item->name }}</a>
								</li>
								@endforeach
							</ul>
						</div>
					</li>
					<li>
						<a href="{{ route('gallerypage') }}" class="{{ $checker->areOnRoutes(['gallerypage']) }} {{ $checker->renderMenuColor() }}">Gallery</a>
					</li>
					<li style="padding-right: 1em">
						<div>
							@if($checker->isLocationPage())
							<i class="fas fa-user-circle dark-blue font-l" style="width: 2vw"></i>
							@else
							<i class="fas fa-user-circle white font-l" style="width: 2vw"></i>
							@endif
							<li>
								@if(Auth::check())
								<a href="{{ route('tenant.profile') }}">Profile</a>
								@else
								<a href="{{ route('login') }}" class="{{ $checker->areOnRoutes(['login']) }} {{ $checker->renderMenuColor() }}">Community Login</a>
								@endif
							</li>

						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>
</header>
<div class="mobile__panel">
	<div class="mobile__panel_inner">
		<div class="menu">
			<ul class="menu__links">
				<li>
					<a href="/" class="font-l {{ $checker->areOnRoutes(['homepage']) }}">Home</a>
				</li>
				<li>
					<a href="{{ route('aboutpage') }}" class="font-l {{ $checker->areOnRoutes(['aboutpage']) }}">About Us</a>
				</li>
				<li>
					<a href="{{ route('locationpage') }}" class="font-l {{ $checker->areOnRoutes(['locationpage','location.show']) }}">Location</a>
				</li>
				<li>
					<a href="{{ route('gallerypage') }}" class="font-l {{ $checker->areOnRoutes(['gallerypage']) }}">Gallery</a>
				</li>
				<li>
					@if(Auth::check())
					<a href="{{ route('tenant.profile') }}">Profile</a>
					@else
					<a href="{{ route('login') }}" class="font-l {{ $checker->areOnRoutes(['login']) }} {{ $checker->renderMenuColor() }}">Community Login</a>
					@endif
				</li>
				{{-- <li>
					<a href="{{ route('login') }}" class="font-l {{ $checker->areOnRoutes(['login']) }}">Community Login</a>
				</li> --}}
			</ul>
		</div>
	</div>
</div>