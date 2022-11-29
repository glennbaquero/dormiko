@extends('admin-master')
@section('content')
<div class="content-wrapper">

	<div class="box box-default">
      	<div class="box-header with-border">
        	<h1 class="box-title"><b>Billing</b></h1>
	        <section class="content-header">
	      		<ol class="breadcrumb">
	      			<li class="">
						<a href=""><i class="fas fa-images"></i> Home</a>
					</li>
					<li class="active">
						<a href=""><i class="fas fa-images"></i> Billing</a>
					</li>
				</ol>
	      	</section>
      	</div>
    </div>

	<section class="content">
		<div class="row">
	            <tab
	            	:billingrentexport="'{{ route('export.billing.rent') }}'"
	            	:billingutilityexport="'{{ route('export.billing.utility') }}'"
					:posturlutility="'{{ route('utility.store') }}'"
					:posturlutilityfee="'{{ route('utility.fee.store') }}'"
					:fetchcontracts="{{ $contracts }}"
					:fetchutilities="{{ $utilities }}"
					:filterstatus="{{ $filter }}"
				></tab>       
			<div class="col-xs-12">
                <div class="box box-widget nav-tabs-custom table-responsive">
	                <div class="tab-content">
	                    <div class="tab-pane active" id="pages">
	                    <billings-table ref="pages"
		                    :show="0"
							:autofetch="true"
							:filterstatus="{{ $filter }}"
							:fetchurl="'{{ route('rents.fetch') }}'"
							:filteryear="{{ $years }}"
							:filtermonth="{{ $months }}"
							:filterselect="{{ $selects }}"
						></billings-table>

	                    </div>
	                    <div class="tab-pane" id="page-utils">
	                        
						<billing-utilities-table
							:autofetch="true"
							:filterstatus="{{ $filterUtility }}"
							:type="{{ $utilities }}"
							:fetchurl="'{{ route('utilities.fetch') }}'"
							:filteryear="{{ $years }}"
							:filtermonth="{{ $months }}"
							:filterselect="{{ $selects }}"
						></billing-utilities-table>

	                    </div>  
	                    <div class="tab-pane" id="page-history">
	                    	<billings-history
	                    		:show="1"
								:fetchurl="'{{ route('histories.fetch') }}'"
								:filteryear="{{ $years }}"
								:filtermonth="{{ $months }}"
								:filterselect="{{ $selects }}"
							></billings-history>
	                    </div>                
	                </div>
        	    </div>
    	    </div>
		</div>
	</section>
</div>
@endsection