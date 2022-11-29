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
						<a href=""><i class="fas fa-images"></i> Contracts</a>
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
			<div class="col-md-12">
	        	<div class="box-body">
	        		<div class="row">
	              		<profile
	              		:user="{{ auth()->user() }}"
	              		:details="{{ auth()->user()->userDetail }}"
	              		:contracts="{{ auth()->user()->contract }}"
	              		:updateurl="'{{ route('tenant.update.profile', auth()->user()->userDetail->id) }}'"
	              		:updatepasswordurl="'{{ route('tenant.update.password', auth()->user()->id) }}'"></profile>
				    </div>
			    </div>
		    </div>
		</div>
	</section>
</div>
@endsection