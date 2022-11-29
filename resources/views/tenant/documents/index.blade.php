@extends('admin-master')
@section('content')
<div class="content-wrapper">
	<div class="box box-default">
      	<div class="box-header with-border">
        	<h1 class="box-title"><b>Documents</b></h1>
	        <section class="content-header">
	      		<ol class="breadcrumb">
					<li class="active">
						<a href=""><i class="fas fa-images"></i> Home</a>
					</li>

					<li class="active">
						<a href=""><i class="fas fa-images"></i> Documents</a>
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
	        			<form @submit.prevent="formSubmit" 
							data-action="{{ route('document.store') }}" 
							data-ref="document-details"
							action="#" method="GET">
		              		<document ref="document-details" 
		              			:fetchurl="'{{ route('document.fetch') }}'"
		              		></document>
		              	</form>
				    </div>
			    </div>
		    </div>
		</div>
	</section>
</div>
@endsection