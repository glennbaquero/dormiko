@extends('admin-master')
@section('content')
<div class="content-wrapper">
	<div class="box box-default">
      	<div class="box-header with-border">
        	<h1 class="box-title"><b>Applicant</b><small> Approve Tenant</small></h1>
	        <section class="content-header">
	      		<ol class="breadcrumb">
					<li class="active">
						<a href=""><i class="fas fa-images"></i> Home</a>
					</li>

					<li class="">
						<a href=""><i class="fas fa-images"></i> Applicants</a>
					</li>

					<li class="active">
						<a href=""><i class="fas fa-images"></i> Approve</a>
					</li>
				</ol>
	      	</section>
      	</div>
    </div>
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<form @submit.prevent="formSubmit" 
					data-action="{{ route('applicant.update', $applicant->id) }}" 
					data-ref="applicant-details"
					action="#" method="GET">
					<div class="row">
						<div class="col-md-12">
					        <div class="box">
					        	<div class="box-header" style="padding: 7px">
					                <i class="fa fa-info-circle"></i>
					                <h6 class="box-title">Approve Tenant</h6>
					            </div>

					            <!-- Start Box Body -->
					        	<div class="box-body">

					                <!-- Start Row -->
					        		
					            	<applicant-details ref="applicant-details"
					            	:disabled="true"
					            	:cancelurl="'{{ route('applicant.update', $applicant->id) }}'"
					            	:fetchurl="'{{ route('applicant.fetch', $applicant->id) }}'"
					            	></applicant-details>
									
							    </div>
					        </div>
					    </div>
					</div>
				</form>
			</div>
		</div>
	</section>
</div>
@endsection