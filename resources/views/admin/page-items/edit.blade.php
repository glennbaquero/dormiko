@extends('admin-master')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-wrapper">
<section class="content-header">
	<h1>{{ $pageItem->renderName() }} <small>Update page item information and details</small></h1>
	<ol class="breadcrumb">
        <li class=""><a href="{{ route('page-items.index') }}"><i class="fas fa-file-alt"></i> Page Items</a></li>
        <li class="active"><a href="#">{{ $pageItem->renderName() }}</a></li>
    </ol>
</section>

<section class="content">

	<std-alert></std-alert>

	<div class="row mb-4">
		<div class="col-md-12">
			
		{{-- 	<std-button
			:size="'btn-sm pull-right'"
			:label="'Delete'"
	        :action="'{{ $pageItem->trashed() ? 'restore' : 'delete' }}'"
	        :message="'{{ 'page item ' . $pageItem->renderName() }}'"
	        :restoreurl="'{{ $pageItem->renderRestore() }}'"
	        :deleteurl="'{{ $pageItem->renderDelete() }}'"
	        ></std-button> --}}

		</div>
	</div>

	<div class="row">
		<div class="col-md-12">

			<form @submit.prevent="formSubmit" 
			data-action="{{ route('page-items.update', $pageItem->id) }}" 
			data-ref="pageItem-details"
			action="#" method="GET">

				<page-item-details ref="pageItem-details" 
				:fetchurl="'{{ route('page-item.fetch', $pageItem->id) }}'">
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
