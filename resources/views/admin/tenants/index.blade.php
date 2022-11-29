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
					<li class="">
						<a href=""><i class="fas fa-images"></i> Buildings</a>
					</li>
					<li class="">
						<a href=""><i class="fas fa-images"></i> Rooms</a>
					</li>
					<li class="active">
						<a href=""><i class="fas fa-images"></i> Tenants</a>
					</li>
				</ol>
	      	</section>
      	</div>
    </div>

	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				
	                <div class="box box-widget nav-tabs-custom table-responsive">
		                <div class="tab-content">
		                    <div class="tab-pane active" id="pages">
		                        
		                    <tenants-table ref="pages"
		                    	:room="{{ $_GET['room'] }}"
								:autofetch="true"
								:fetchurl="'{{ route('tenants.fetch') }}'"
							></tenants-table>

		                    </div>               
		                </div>
	        	    </div>
        	    </div>
			</div>
		</div>
	</section>
</div>
@endsection