@extends('admin-master')
@section('content')
<div class="content-wrapper">

	<div class="box box-default">
      	<div class="box-header with-border">
        	<h1 class="box-title"><b>Buildings</b></h1>
	        <section class="content-header">
	      		<ol class="breadcrumb">
					<li class="active">
						<a href=""><i class="fas fa-images"></i> Home</a>
					</li>
					<li class="active">
						<a href=""><i class="fas fa-images"></i> Buildings</a>
					</li>
				</ol>
	      	</section>
      	</div>
    </div>

	<section class="content">
        <buildings-list
        :usertype="{{ auth()->guard('admin')->user()->type }}"
        :buildings="{{ $buildings }}"
        :createurl="'{{ route('building.create') }}'"></buildings-list>
	</section>
</div>
@endsection