@extends('admin-master')
@section('content')
<div class="content-wrapper">
	<div class="box box-default">
      	<div class="box-header with-border">
        	<h1 class="box-title"><b>Building</b><small> Add Building</small></h1>
	        <section class="content-header">
	      		<ol class="breadcrumb">
					<li class="active">
						<a href=""><i class="fas fa-images"></i> Home</a>
					</li>

					<li class="">
						<a href=""><i class="fas fa-images"></i> Buildings</a>
					</li>

					<li class="active">
						<a href=""><i class="fas fa-images"></i> Add Building</a>
					</li>
				</ol>
	      	</section>
      	</div>
    </div>
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<form @submit.prevent="formSubmit" 
					data-action="{{ route('building.store') }}" 
					data-ref="building-details"
					action="#" method="GET">
					<div class="row">
						<div class="col-md-12">
					        <div class="box">
					        	<div class="box-header" style="padding: 7px">
						            <i class="fa fa-info-circle"></i>
						            <h6 class="box-title">Add Building</h6>
						        </div>

						        <!-- Start Box Body -->
						        <div class="box-body">
						            <!-- Start Row -->
						            <div class="row">
							        	<building-details ref="building-details"
							        		:submiturl="'{{ route('building.store') }}'"
							        		:fetchurl="'{{ route('building.fetch') }}'"
							            	:fetchpositionurl="'{{ route('locations.fetch-positions') }}'">
											</building-details>
									</div>
							        <button type="submit" class="btn btn-primary pull-left">Submit</button>
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