@extends('admin-master')
@section('content')
	<div class="content-wrapper">

		<div class="box box-default">
	      	<div class="box-header with-border">
	        	<h1 class="box-title"><b>Tenants</b></h1>
		        <section class="content-header">
		      		<ol class="breadcrumb">
		      			<li class="">
							<a href=""><i class="fas fa-images"></i> Home</a>
						</li>
						<li class="active">
							<a href=""><i class="fas fa-images"></i> Tenants</a>
						</li>
					</ol>
		      	</section>
	      	</div>
	    </div>

			<section class="content">
		        <contracts-table ref="pages"
		        	:addcontracturl="'{{ route('contract.create') }}'"
					:autofetch="true"
					:filterstatus="{{ $filter }}"
					:filterbuilding="{{ $buildings }}"
					:filterroom="{{ $rooms }}"
					:filteryear="{{ $years }}"
					:filtermonth="{{ $months }}"
					:filterselect="{{ $selects }}"
					:fetchurl="'{{ route('tenants.fetch') }}'"
					:exporturl="'{{ route('export.contract') }}'"
					:auth="{{ auth('admin')->user()->type }}"
				></contracts-table>
			</section>
		</div>
	</div>
</div>
@endsection