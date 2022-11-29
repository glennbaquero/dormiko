@extends('admin-master')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-wrapper">
<section class="content-header">
	<h1>{{ $gallery->id }} <small>Update content</small></h1>
	<ol class="breadcrumb">
        <li class=""><a href="{{ route('gallery.index') }}"><i class="fas fa-file-alt"></i> Gallery</a></li>
        <li class="active"><a href="#">{{ $gallery->id }}</a></li>
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
			data-action="{{ route('gallery.update', $gallery->id) }}" 
			data-ref="gallery-details"
			action="#" method="GET" enctype='multipart/form-data'>

				<gallery-details ref="gallery-details" 
					:fetchurl="'{{ route('gallery.fetch', $gallery->id) }}'">
				</gallery-details>

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
