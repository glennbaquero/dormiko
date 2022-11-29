@extends('admin-master')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-wrapper">
<section class="content-header">
	<h1>Create Page Item <small>Make a new page item</small></h1>
	<ol class="breadcrumb">
        <li class=""><a href="{{ route('page-items.index') }}"><i class="fas fa-file-alt"></i> Page Items</a></li>
        <li class="active"><a href="#">Create</a></li>
    </ol>
</section>

<section class="content">

	<div class="row">
		<div class="col-md-12">

			{{-- <std-alert></std-alert> --}}
			
			<form @submit.prevent="formSubmit" 
			data-action="{{ route('page-items.store') }}" 
			data-ref="page-item-details"
			action="#" method="GET">

				<page-item-details ref="page-item-details" 
				:fetchurl="'{{ route('page-item.fetch') }}'">
				</page-item-details>

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
