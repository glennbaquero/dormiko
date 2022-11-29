@extends('admin-master')
@section('content')
<div class="content-wrapper">
	<div class="box box-default">
      	<div class="box-header with-border">
        	<h1 class="box-title"><b>Tenant</b></h1>
	        <section class="content-header">
	      		<ol class="breadcrumb">
					<li class="active">
						<a href=""><i class="fas fa-images"></i> Home</a>
					</li>

					<li class="">
						<a href=""><i class="fas fa-images"></i> Tenant</a>
					</li>

					<li class="active">
						<a href=""><i class="fas fa-images"></i> Tenant</a>
					</li>
				</ol>
	      	</section>
      	</div>
    </div>
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<form @submit.prevent="formSubmit" 
					data-action="{{ route('contract.update', $contract->id) }}" 
					data-ref="contract-details"
					action="#" method="GET">
					<div class="row">
						<div class="col-md-12">
				        	<div class="box-body">
				        		<div class="row">
				        			<div class="col-md-12">
				            			<contract-details ref="contract-details"
				            			:fetchurl="'{{ route('tenant.fetch', $contract->id) }}'"
				            			:printcontract="'{{ route('contract.print', $contract->id) }}'"
				            			>
				            			</contract-details>
				            		</div>
					        	</div>
								<button type="submit" name="renew" class="btn btn-primary pull-left" style="margin-right: 5px">Renew</button>
								<button type="submit" class="btn btn-default pull-left">Back</button>
						    </div>
					    </div>
					</div>
				</form>
			</div>
		</div>
	</section>
</div>
@endsection