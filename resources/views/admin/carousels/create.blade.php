@extends('admin-master')
@section('content')
<div class="content-wrapper">
	<section class="content-header">
		<h1>Add Slider <small>(Make new a slider)</small></h1>
		<ol class="breadcrumb">
			<li>
				<a href="{{ route('carousel.index') }}"><i class="fas fa-images"></i> Sliders</a>
			</li>
			<li class="active">
				New Slider
			</li>
		</ol>
</section>
<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<!-- /.box-header -->
					<form @submit.prevent="formSubmit" 
						data-action="{{ route('carousel.store') }}" 
						data-ref="carousel-details"
						action="#" method="GET">

						<carousel-details ref="carousel-details"
						:fetchurl="'{{ route('carousel.fetch') }}'">
						</carousel-details>

						<div class="row">
							<div class="col col-xs-12">
								<button type="submit" class="btn btn-primary pull-right">Save Changes</button>
							</div>
						</div>
					</form>
				<!-- /.box-body -->
			</div>
		</div>
	</section>
</div>
@endsection