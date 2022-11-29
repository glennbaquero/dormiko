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
				        <div class="col-md-6">
				          	<div class="box box-solid">
				            	<div class="box-header with-border">
				            		<div class="row">
				            			<div class="col-md-4">
						                	<img src="storage/admin.png" class="img-responsive img-circle">
						                </div>
						                <div class="col-md-6">
						                	<h3><label>{{ auth()->user()->userDetail->firstname }} {{ auth()->user()->userDetail->lastname }}</label></h3>
						                	<p>{{ auth()->user()->email }}</p>
						                	<p>{{ auth()->user()->userDetail->contact }}</p>
						                	@if(auth()->user()->userDetail->birthdate)
						                	<p>{{ auth()->user()->userDetail->birthdate->format('M d, Y') }}</p>
						                	@endif
						                	<p>{{ auth()->user()->userDetail->address }}</p>
						                	<p>{{ auth()->user()->userDetail->tenant_id }}</p>
						                </div>
				            		</div>
				            	</div>
				          	</div>
				        </div>
				        <div class="col-md-6">
				          	<div class="box box-solid">
				            	<div class="box-header with-border" style="padding:11px">
				              		<b style="padding-left: 12px">Unpaid Bills</b>
					            </div>
				         	</div>
				        </div>
				        <div class="col-md-6">
				          	<div class="box box-solid">
				            	<div class="box-header with-border" style="padding:11px">
				              		<unpaid-bills-table ref="pages"
										:autofetch="true"
										:fetchurl="'{{ route('unpaid.bills.fetch') }}'"
									></unpaid-bills-table>
					            </div>
				         	</div>
				        </div>
				        <div class="col-md-12">
				          	<div class="box box-solid">
				          		@foreach( auth()->user()->contract as $contract)
				            	<div class="box-header with-border">
				            		<div class="row">
				            			<div class="col-xs-3">
						            		<h4>Building</h4>
						              		<h2><label>{{ $contract->room ? $contract->room->building->name : 'No room assigned.' }}</label></h2>	
				            			</div>
				            			<div class="col-xs-2">
						            		<h4>Unit No.</h4>
						              		<h2><label>{{ $contract->room ? $contract->room->unit_name : 'No unit assigned' }}</label></h2>	
				            			</div>
				            			{{-- <div class="col-xs-2">
						            		<h4>Rental Agreement</h4>
						            		<a class="btn btn-primary btn-flat btn-lg w-50">View</a>
						              		<h2><label>{{ $contract->room->unit_name }}</label></h2>	
				            			</div> --}}
				            			<div class="col-xs-3">
						            		<h4>Statement of Account</h4>
						            		<a href="{{ route('payments') }}" class="btn btn-primary btn-flat btn-lg w-50">View</a>
						              		{{-- <h2><label>{{ $contract->room->unit_name }}</label></h2>	 --}}
				            			</div>
				            			<div class="col-xs-2">
						            		<h4>Status</h4>
						              		<h4><label class="text-success">Outstanding</label></h4>	
				            			</div>
				            		</div>
					            </div>
					            @endforeach
				         	</div>
				        </div>
				    </div>
			    </div>
		    </div>
		</div>
	</section>
</div>
@endsection