@extends('admin-master')
@section('content')
<div class="content-wrapper">
	<div class="box box-default">
      	<div class="box-header with-border">
        	<h1 class="box-title"><b>Room</b><small> Edit Room</small></h1>
	        <section class="content-header">
	      		<ol class="breadcrumb">
					<li class="active">
						<a href=""><i class="fas fa-images"></i> Home</a>
					</li>

					<li class="">
						<a href=""><i class="fas fa-images"></i> Rooms</a>
					</li>

					<li class="active">
						<a href=""><i class="fas fa-images"></i> Edit Room</a>
					</li>
				</ol>
	      	</section>
      	</div>
    </div>
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<form @submit.prevent="formSubmit" 
					data-action="{{ route('room.update', $room->id) }}" 
					data-ref="room-details"
					action="#" method="GET">
					<div class="row">
						<div class="col-md-12">
					        <div class="box">
					        	<div class="box-header" style="padding: 7px">
					                <i class="fa fa-info-circle"></i>
					                <h6 class="box-title">Edit Room</h6>
					            </div>

					            <!-- Start Box Body -->
					        	<div class="box-body">

					                <!-- Start Row -->
					        		<div class="row">
					            	<room-details ref="room-details"
					            	:room="{{ $room }}"
					            	:floor="{{ $floor }}"
					            	></room-details>
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