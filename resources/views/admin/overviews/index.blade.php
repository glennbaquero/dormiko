@extends('admin-master')
@section('content')
<div class="content-wrapper">

	<div class="box box-default">
      	<div class="box-header with-border">
        	<h1 class="box-title"><b>Overview</b></h1>
	        <section class="content-header">
	      		<ol class="breadcrumb">
					<li class="active">
						<a href=""><i class="fas fa-images"></i> Home</a>
					</li>
					<li class="active">
						<a href=""><i class="fas fa-images"></i> Overview</a>
					</li>
				</ol>
	      	</section>
      	</div>
    </div>

	<section class="content">
		<div class="row">
			<div class="col-md-3 col-sm-6 col-xs-12">
				<a href="{{ route('buildings') }}" style="text-decoration: none; color: black">
		          	<div class="info-box">
			            <span class="info-box-icon" style="background: url('storage/splices/Icons/Web App/building.svg')"></span>
			            <div class="info-box-content">
			              Buildings
			              <span class="info-box-number">{{ $buildings }}</span>
			            </div>
		          	</div>
	          	</a>
				
				<a href="{{ route('contracts') }}" style="text-decoration: none; color: black">
		          	<div class="info-box">
			            <span class="info-box-icon" style="background: url('storage/splices/Icons/Web App/active.svg')"></span>
			            <div class="info-box-content">
			              Active Contracts
			              <span class="info-box-number">{{ $active_contracts }}</span>
			            </div>
		          	</div>
		        </a>
				
				<a href="{{ route('billing') }}" style="text-decoration: none; color: black">
		          	<div class="info-box">
			            <span class="info-box-icon" style="background: url('storage/splices/Icons/Web App/alerts.svg')"></span>
			            <div class="info-box-content">
			              Billing Alerts
			              <span class="info-box-number">{{ $billing }}</span>
			            </div>
		          	</div>
		        </a>
			
				<a href="{{ route('contracts') }}" style="text-decoration: none; color: black">
		          	<div class="info-box">
			            <span class="info-box-icon" style="background: url('storage/splices/Icons/Web App/Outstanding.svg')"></span>
			            <div class="info-box-content">
			              Tenants with Good Standing
			              <span class="info-box-number">{{ $good_standing }}</span>
			            </div>
		          	</div>
		        </a>
	        </div>
			
			<div class="col-md-3 col-sm-6 col-xs-12">
				<a href="{{ route('applicants') }}" style="text-decoration: none; color: black">
		          	<div class="info-box">
			            <span class="info-box-icon" style="background: url('storage/splices/Icons/Web App/applicant.svg')"></span>
			            <div class="info-box-content">
			              Applicants
			              <span class="info-box-number">{{ $reservations }}</span>
			            </div>
		          	</div>
	            </a>
				
				<a href="{{ route('contracts') }}" style="text-decoration: none; color: black">
		          	<div class="info-box">
			            <span class="info-box-icon" style="background: url('storage/splices/Icons/Web App/expiring.svg')"></span>
			            <div class="info-box-content">
			              Expiring Contracts
			              <span class="info-box-number">{{ $expiring_contracts }}</span>
			            </div>
		          	</div>
	            </a>

				<a href="{{ route('contracts') }}" style="text-decoration: none; color: black">
		          	<div class="info-box">
			            <span class="info-box-icon" style="background: url('storage/splices/Icons/Web App/tenants.svg')"></span>
			            <div class="info-box-content">
			              Tenants
			              <span class="info-box-number">{{ $tenants }}</span>
			            </div>
		          	</div>
	            </a>
				
				<a href="{{ route('billing') }}" style="text-decoration: none; color: black">
		          	<div class="info-box">
			            <span class="info-box-icon" style="background: url('storage/splices/Icons/Web App/overdue.svg')"></span>
			            <div class="info-box-content">
			              Tenants with Overdue Payment
			              <span class="info-box-number">{{ $overdue }}</span>
			            </div>
		          	</div>
		        </a>
	        </div>

	        <div class="col-md-6">
	          	<div class="box box-default" style="overflow-y: scroll;max-height: 66vh;">
		            <div class="box-header with-border" style="padding: 8px; border-bottom: 1px solid">
		              	<h3 class="box-title" style="font-size: 18px"><b>Recent Activities</b></h3>
		            </div>

					@foreach($activities as $activity)
			            <div class="box-body chat bg-light" style="border-bottom: 1px solid">
			              	<div class="item">
			              		<img src="{{ asset('storage/admin.png') }}" width="50px" class="rounded-circle">
								
			                	<p class="message">{!! $activity->message !!}</p>
							
			              	</div>
			            </div>
		            @endforeach

		            {{-- <div class="box-body chat bg-light" style="border-bottom: 1px solid">
		              	<div class="item">
		              		<img src="{{ asset('storage/admin.png') }}" width="50px" class="rounded-circle">

		                	<p class="message">There is a problem that we need to fix. A wonderful serenity has taken possession of my entire soul,
		                  like these sweet mornings of spring which I enjoy with my whole heart.</p>
		              	</div>
		            </div> --}}
	          	</div>
	        </div>
		
		</div>
	</section>
</div>
@endsection