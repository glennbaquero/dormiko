@extends('admin-master')
@section('content')
<div class="content-wrapper">
	<div class="box box-default">
      	<div class="box-header with-border">
        	<h1 class="box-title"><b>Utility</b></h1>
	        <section class="content-header">
	      		<ol class="breadcrumb">
					<li class="active">
						<a href=""><i class="fas fa-images"></i> Home</a>
					</li>

					<li class="">
						<a href=""><i class="fas fa-images"></i> Billing</a>
					</li>

					<li class="active">
						<a href=""><i class="fas fa-images"></i> Utility</a>
					</li>
				</ol>
	      	</section>
      	</div>
    </div>
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				{{-- <form @submit.prevent="formSubmit" 
					data-action="{{ route('utility.update', $billing->id) }}" 
					data-ref="rent-details"
					action="#" method="GET"> --}}
					<div class="row">
						<div class="col-md-12">
					        <div class="box">
					        	<div class="box-header" style="padding: 7px">
					                <i class="fa fa-info-circle"></i>
					                <h6 class="box-title">Utility</h6>
					            </div>

					            <!-- Start Box Body -->
					        	<div class="box-body">

					                <!-- Start Row -->
					        		{{-- <div class="row"> --}}
					            		<billing-utility-details ref="rent-details"
					            		:fetchurl="'{{ route('utility.fetch', $billing->id) }}'"
					            		updateurl="{{ route('utility.update', $billing->id) }}"
					            		></billing-utility-details>
						        	{{-- </div> --}}
									{{-- <button type="submit" class="btn btn-primary pull-left" style="margin-right: 5px">Saved</button> --}}
									<a href="{{route('billing')}}" class="btn btn-default pull-left">Cancel</a>
							    </div>
					        </div>
					    </div>
					</div>
				{{-- </form> --}}
			</div>
		</div>
	</section>
</div>
@endsection