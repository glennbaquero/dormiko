@extends('admin-master')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            About Us
            <small>Manage About Us</small>
        </h1>
        <ol class="breadcrumb">
            <li class="active"><a href="{{ route('about.index') }}"><i class="fas fa-file"></i> About</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row mb-4">
            <div class="col-md-12">

                {{-- @if ($checker->permission->can(['pages.create'])) --}}
                    <a href="{{ route('about.create') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus mr-1"></i> Add Content
                    </a>
                {{-- @endif --}}
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="box box-widget nav-tabs-custom table-responsive">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#pages" data-toggle="tab"><h5><b>Contents</b></h5></a>
                        </li>                                              
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active" id="pages">
                            
                            <about-contents-table ref="pages"
                            :autofetch="true"
                            :fetchurl="'{{ route('abouts.fetch') }}'"
                            ></about-contents-table>

                        </div>
                
                    </div>
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->    
    </section>
</div>
<!-- /.content -->
@stop