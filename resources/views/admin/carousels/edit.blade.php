@extends('admin-master')
@section('content')
<div class="content-wrapper">
	<section class="content-header">
		<h1>{{ $carousel->renderName() }} <small>(Update slider information and details)</small></h1>
		<ol class="breadcrumb">
			<li>
				<a href="{{ route('carousel.index') }}"><i class="fas fa-images"></i> Sliders</a>
			</li>
			<li class="active">
				{{ $carousel->renderName() }}
			</li>
		</ol>
	</section>
	<section class="content">
		<div class="row mb-4">
			<div class="col-md-12">
				
				{{-- <std-button
				:size="'btn-sm pull-right'"
				:label="'Delete'"
		        :action="'{{ $carousel->trashed() ? 'restore' : 'delete' }}'"
		        :message="'{{ 'carousel ' . $carousel->renderName() }}'"
		        :restoreurl="'{{ $carousel->renderRestore() }}'"
		        :deleteurl="'{{ $carousel->renderDelete() }}'"
		        ></std-button>
 --}}
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<!-- /.box-header -->
					<form @submit.prevent="formSubmit" 
						data-action="{{ route('carousel.update', $carousel->id) }}" 
						data-ref="carousel-details"
						action="#" method="GET">

						<carousel-details ref="carousel-details"
						:fetchurl="'{{ route('carousel.fetch', $carousel->id) }}'"
						>
						</carousel-details>

						<div class="row">
							<div class="col col-xs-12">
								<button type="submit" class="btn btn-primary pull-right">Save Changes</button>
							</div>
						</div>
					</form>
				<!-- /.box-body -->
			</div>
		</div>
	</section>
</div>
@endsection