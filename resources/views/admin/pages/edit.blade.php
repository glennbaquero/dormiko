@extends('admin-master')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-wrapper">
	<section class="content-header">
		<h1>{{ $page->renderName() }} <small>Update page information and details</small></h1>
		<ol class="breadcrumb">
	        <li class=""><a href="{{ route('pages.index') }}"><i class="fas fa-file"></i> Pages</a></li>
	        <li class="active"><a href="#">{{ $page->renderName() }}</a></li>
	    </ol>
	</section>

	<section class="content">

		<std-alert></std-alert>

		<div class="row mb-4">
			<div class="col-md-12">
				
		{{-- 		<std-button
				:size="'btn-sm pull-right'"
				:label="'Delete'"
		        :action="'{{ $page->trashed() ? 'restore' : 'delete' }}'"
		        :message="'{{ 'page ' . $page->renderName() }}'"
		        :restoreurl="'{{ $page->renderRestore() }}'"
		        :deleteurl="'{{ $page->renderDelete() }}'"
		        ></std-button> --}}

			</div>
		</div>

		<div class="row">
	        <div class="col-xs-12">
	            <div class="box box-widget nav-tabs-custom table-responsive">
	                <ul class="nav nav-tabs">
	                    <li class="active">
	                        <a href="#magnitude" data-toggle="tab"><h5><b>Page</b></h5></a>
	                    </li>
	                    <li>
	                        <a @click="runDatatable('page-items')" href="#page-items" data-toggle="tab"><h5><b>Page Items</b></h5></a>
	                    </li>                                                   
	                </ul>

	                <div class="tab-content">
	                    <div class="tab-pane active" id="magnitude">
	                        
	                        <form @submit.prevent="formSubmit" 
							data-action="{{ route('pages.update', $page->id) }}" 
							data-ref="page-details"
							action="#" method="GET">

								<page-details ref="page-details" 
								:fetchurl="'{{ route('page.fetch', $page->id) }}'">
								</page-details>

								<div class="row">
									<div class="col col-xs-12">
										<button type="submit" class="btn btn-primary pull-right">Save Changes</button>
									</div>
								</div>
							</form>

	                    </div>
	                    <div class="tab-pane" id="page-items">
	                        
	                        <page-item-table ref="page-items"
	                        :autofetch="false"
	                        :filtertypes="{{ $types }}"
	                        :fetchurl="'{{ route('page-items.fetch.page', $page->id) }}'"
	                        ></page-item-table>

	                    </div>                  
	                </div>
	            </div>
	        </div>
	        <!-- /.col -->
		</div>

	</section>
</div>

@stop
