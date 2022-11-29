@extends('admin-master')
@section('content')
<div class="content-wrapper">

	<div class="box box-default">
      	<div class="box-header with-border">
        	<h1 class="box-title"><b>Admin Permission</b></h1>
	        <section class="content-header">
	      		<ol class="breadcrumb">
					<li class="active">
						<a href=""><i class="fas fa-images"></i> Home</a>
					</li>
					<li class="active">
						<a href=""><i class="fas fa-images"></i> Admin Permission</a>
					</li>
				</ol>
	      	</section>
      	</div>
    </div>

	<section class="content">
        <div class="row">
	        <div class="col-sm-12 col-md-12">
	            <div style="background: transparent;">
	                <div class="box-body">
	                    <div class="media">
	                        <div class="media-body">
	                            <div class="clearfix">
	                                <p class="pull-right" style="margin: 0 0 0">
	                                    <a href="{{ route('permission.create') }}" class="btn-default bg-transparent btn-sm border-0 " style="font-size: 35px;">
	                                        <span class="glyphicon glyphicon-plus-sign"></span>
	                                    </a>
	                                </p>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	    <div class="row">
			<div class="col-xs-12">
				<div class="box box-widget nav-tabs-custom">
	                <ul class="nav nav-tabs">
	                    <li>
	                        <a href="#admin" data-toggle="tab"><h5><b>Admin</b></h5></a>
	                    </li>
	                    <li class="active">
	                        <a href="#officer" data-toggle="tab"><h5><b>Permissions</b></h5></a>
	                    </li>                                                   
	                </ul>
	            </div>
	        </div>
	    </div>

	    <div class="row">
	    	<div class="tab-content">
                <div class="tab-pane" id="admin">
                    <admin-list
                    	:admins="{{ $admins }}"
                    	:auth="{{ Auth::guard('admin')->user() }}"
                    ></admin-list>
                </div>
                <div class="tab-pane active" id="officer">
                    <billing-officer-list
						:billingofficer="{{ $officers }}"
                    ></billing-officer-list>
                </div>                  
            </div>
		</div>
	</section>
</div>
@endsection