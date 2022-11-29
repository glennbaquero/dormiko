@extends('admin-master')
@section('content')
<div class="content-wrapper">

	<div class="box box-default">
      	<div class="box-header with-border">
        	<h1 class="box-title"><b>Rooms</b></h1>
	        <section class="content-header">
	      		<ol class="breadcrumb">
					<li class="active">
						<a href=""><i class="fas fa-images"></i> Home</a>
					</li>
					<li class="active">
						<a href=""><i class="fas fa-images"></i> Rooms</a>
					</li>
				</ol>
	      	</section>
      	</div>
    </div>

	<section class="content">
        <rooms-list
        :id="{{ $building->id }}"
        :building="{{ $building }}"
        :buildings="{{ $buildings }}"
        :createurl="'{{ route('room.create', $building->id) }}'"></rooms-list>
	</section>
</div>
@endsection