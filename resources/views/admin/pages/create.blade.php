@extends('admin-master')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-wrapper">
<section class="content-header">
	<h1>Add Page <small>Make a new page</small></h1>
	<ol class="breadcrumb">
        <li class=""><a href="{{ route('pages.index') }}"><i class="fas fa-file"></i> Pages</a></li>
        <li class="active"><a href="#">Create</a></li>
    </ol>
</section>

<section class="content">

	<div class="row">
		<div class="col-md-12">
			
			<form @submit.prevent="formSubmit" 
			data-action="{{ route('pages.store') }}" 
			data-ref="page-details"
			action="#" method="GET">

				<page-details ref="page-details" 
				:fetchurl="'{{ route('page.fetch') }}'">
				</page-details>

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
