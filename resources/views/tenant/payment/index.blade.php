@extends('admin-master')
@section('content')
<div class="content-wrapper">

	<div class="box box-default">
      	<div class="box-header with-border">
        	<h1 class="box-title"><b>Payment</b></h1>
	        <section class="content-header">
	      		<ol class="breadcrumb">
	      			<li class="">
						<a href=""><i class="fas fa-images"></i> Home</a>
					</li>
					<li class="active">
						<a href=""><i class="fas fa-images"></i> Payment</a>
					</li>
				</ol>
	      	</section>
      	</div>
    </div>

	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box box-widget nav-tabs-custom">
	                <ul class="nav nav-tabs">
	                    <li class="active">
	                        <a href="#pages" data-toggle="tab"><h5><b>Payment</b></h5></a>
	                    </li>
	                    <li>
	                        <a href="#page-history" data-toggle="tab"><h5><b>History</b></h5></a>
	                    </li>
	                    <li>
	                        {{-- <a @click="runDatatable('page-employees')" href="#page-employees" data-toggle="tab"><h5><b>Archive</b></h5></a> --}}
	                    </li>                                                   
	                </ul>       
	                </div>

	                <div class="box box-widget nav-tabs-custom table-responsive">
		                <div class="tab-content">
		                   
		                    <div class="tab-pane active" id="pages">
	                    	 <h3><label>Rent</label></h3>
		                    <rent-payments-table ref="pages"
								:autofetch="true"
								:fetchurl="'{{ route('tenant.rent.fetch') }}'"
							></rent-payments-table>

		                    <h3><label>Utilities</label></h3>

							<utility-payments-table
								:autofetch="true"
								{{-- :viewurl="'{{ route('billing.edit') }}'" --}}
								:fetchurl="'{{ route('tenant.util.fetch') }}'"
							></utility-payments-table>

		                    </div>
		                    <div class="tab-pane" id="page-history">
		                        {{-- <p>Payment Date</p>
								<select class="tenant-selection-box">
									<option>Year</option>
								</select>
								<select style="border:solid 1px gray; width: 15%; padding: 8px 8px 8px 14px">
									<option>2018</option>
								</select> --}}

								<payment-history-table
									:fetchurl="'{{ route('history.bill.fetch') }}'"
								></payment-history-table>
		                    </div>               
		                </div>

	        	    </div>
        	    </div>
			</div>
		</div>
	</section>
</div>
@endsection