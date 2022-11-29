@extends('admin-master')
@section('content')
<div class="content-wrapper">

	<div class="box box-default">
      	<div class="box-header with-border">
        	<h1 class="box-title"><b>Applicants</b></h1>
	        <section class="content-header">
	      		<ol class="breadcrumb">
	      			<li class="">
						<a href=""><i class="fas fa-images"></i> Home</a>
					</li>
					<li class="active">
						<a href=""><i class="fas fa-images"></i> Applicants</a>
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
	                        <a href="#pages" data-toggle="tab"><h5><b>Pending</b></h5></a>
	                    </li>
	                    <li>
	                        <a href="#page-approved" data-toggle="tab"><h5><b>Approved</b></h5></a>
	                    </li>
	                      <li>
	                        <a href="#page-denied" data-toggle="tab"><h5><b>Denied</b></h5></a>
	                    </li>
	                      <li>
	                        <a href="#page-cancelled" data-toggle="tab"><h5><b>Cancelled</b></h5></a>
	                    </li>
	                    <li>
	                        {{-- <a @click="runDatatable('page-employees')" href="#page-employees" data-toggle="tab"><h5><b>Archive</b></h5></a> --}}
	                    </li>                                                   
	                </ul>       
	                </div>
	                <div class="box box-widget nav-tabs-custom table-responsive">
		                <div class="tab-content">
		                    <div class="tab-pane active" id="pages">
		                        
		                    <applicants-table ref="pages"
		                    	:status="0"
								:autofetch="true"
								:fetchurl="'{{ route('applicants.fetch') }}'"
								:auth="{{ auth('admin')->user()->type }}"
								:filterbuilding="{{ $buildings }}"
							></applicants-table>

		                    </div>
		                    <div class="tab-pane" id="page-approved">
		                        
							<applicants-table ref="pages"
								:status="1"
								:autofetch="true"
								:fetchurl="'{{ route('applicants.fetch') }}'"
								:filterbuilding="{{ $buildings }}"
							></applicants-table>

		                    </div> 
		                    <div class="tab-pane" id="page-denied">
		                        
							<applicants-table ref="pages"
								:status="3"
								:autofetch="true"
								:fetchurl="'{{ route('applicants.fetch') }}'"
								:filterbuilding="{{ $buildings }}"
							></applicants-table>

		                    </div>  

		                    <div class="tab-pane" id="page-cancelled">
		                        
							<applicants-table ref="pages"
								:status="2"
								:autofetch="true"
								:fetchurl="'{{ route('applicants.fetch') }}'"
								:filterbuilding="{{ $buildings }}"
							></applicants-table>

		                    </div>                 
		                </div>
	        	    </div>
        	    </div>
			</div>
		</div>
	</section>
</div>
@endsection