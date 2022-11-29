@extends('admin-master')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-wrapper">
<section class="content-header">
	<h1>{{ $about->id }} <small>Update content</small></h1>
	<ol class="breadcrumb">
        <li class=""><a href="{{ route('page-items.index') }}"><i class="fas fa-file-alt"></i> About Us Content</a></li>
        <li class="active"><a href="#">{{ $about->id }}</a></li>
    </ol>
</section>

<section class="content">

	<std-alert></std-alert>

	<div class="row mb-4">
		<div class="col-md-12">

		</div>
	</div>

	<div class="row">
		<div class="col-md-12">

			<form @submit.prevent="formSubmit" 
			data-action="{{ route('about.update', $about->id) }}" 
			data-ref="about-details"
			action="#" method="GET">

				<about-content-details ref="about-details" 
				:fetchurl="'{{ route('about.fetch', $about->id) }}'">
				</about-content-details>

				<div class="row">
					<div class="col col-xs-12">
						<button type="submit" class="btn btn-primary pull-right">Save Changes</button>
					</div>
				</div>
			</form>

		</div>
	</div>

</section>
</div>

@stop
