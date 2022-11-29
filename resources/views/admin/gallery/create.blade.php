@extends('admin-master')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-wrapper">
<section class="content-header">
	<h1>Add About Us Content <small>Make a new content</small></h1>
	<ol class="breadcrumb">
        <li class=""><a href="{{ route('gallery.index') }}"><i class="fas fa-file"></i> About Us Content</a></li>
        <li class="active"><a href="#">Create</a></li>
    </ol>
</section>

<section class="content">

	<div class="row">
		<div class="col-md-12">
			
			<form @submit.prevent="formSubmit" 
			data-action="{{ route('gallery.store') }}" 
			data-ref="page-details"
			action="#" method="GET">

				<gallery-details ref="page-details" 
				:fetchurl="'{{ route('gallery.fetch') }}'">
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
