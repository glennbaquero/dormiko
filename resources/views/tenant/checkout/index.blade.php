@extends('admin-master')
@section('content')
<div class="content-wrapper">

	<div class="box box-default">
      	<div class="box-header with-border">
        	<h1 class="box-title"><b>Checkout</b></h1>
	        <section class="content-header">
	      		<ol class="breadcrumb">
	      			<li class="">
						<a href=""><i class="fas fa-images"></i> Home</a>
					</li>
					<li class="active">
						<a href=""><i class="fas fa-images"></i> Checkout</a>
					</li>
				</ol>
	      	</section>
      	</div>
    </div>

	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<checkout
                	:fetchurl="'{{ route('billing.rent.fetch', $invoice->id) }}'"
                	:checkouturl="'{{ route('checkout.payment') }}'">
                </checkout>
    	    </div>
		</div>
	</section>
</div>
@endsection