@extends('admin-master')
@section('content')
<div class="content-wrapper">
	<div class="box box-default">
      	<div class="box-header with-border">
        	<h1 class="box-title"><b>Add new tenant</b></h1>
	        <section class="content-header">
	      		<ol class="breadcrumb">
					<li class="active">
						<a href=""><i class="fas fa-images"></i> Home</a>
					</li>

					<li class="">
						<a href=""><i class="fas fa-images"></i> Contracts</a>
					</li>

					<li class="active">
						<a href=""><i class="fas fa-images"></i> Add</a>
					</li>
				</ol>
	      	</section>
      	</div>
    </div>
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				{{-- <form @submit.prevent="formSubmit" 
					data-action="{{ route('contract.store') }}" 
					data-ref="contract-create"
					action="#" method="GET"> --}}
					<div class="row">
						<div class="col-md-12">
							<div class="box">
					        	<div class="box-header" style="padding: 7px">
					                <i class="fa fa-info-circle"></i>
					                <h6 class="box-title">Tenant Info</h6>
					            </div>
					        	{{-- <div class="box-body">
					        		<div class="row">
					        			<div class="col-md-12"> --}}
					            			<contract-create ref="contract-create"
					            				fetchurl="{{ route('tenant.fetch') }}"
												:buildings="{{ $buildings }}"
												:rooms="{{ $rooms }}"
												url="{{ route('contract.store') }}"
												:update="false"
					            			></contract-create>
					            		{{-- </div>
						        	</div>
									<button type="submit" name="renew" class="btn btn-primary pull-left" style="margin-right: 5px">Submit</button>
							    </div> --}}
					    </div>
					</div>
				</form>
			</div>
		</div>
	</section>
</div>
@endsection