@extends('admin-master')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Pages
            <small>Manage Pages</small>
        </h1>
        <ol class="breadcrumb">
            <li class="active"><a href="{{ route('pages.index') }}"><i class="fas fa-file"></i> Pages</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row mb-4">
            <div class="col-md-12">

                {{-- @if ($checker->permission->can(['pages.create'])) --}}
                    <a href="{{ route('pages.create') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus mr-1"></i> Add Page
                    </a>
                {{-- @endif --}}
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="box box-widget nav-tabs-custom table-responsive">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#pages" data-toggle="tab"><h5><b>Pages</b></h5></a>
                        </li>
                        {{-- <li>
                            <a @click="runDatatable('pages-archive')" href="#pages-archive" data-toggle="tab"><h5><b>Archive</b></h5></a>
                        </li>   --}}                                                 
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active" id="pages">
                            
                            <page-table ref="pages"
                            :autofetch="true"
                            :fetchurl="'{{ route('pages.fetch') }}'"
                            ></page-table>

                        </div>
                        <div class="tab-pane" id="pages-archive">
                            
                            <page-table ref="pages-archive"
                            :autofetch="false"
                            :fetchurl="'{{ route('pages.fetch.archive') }}'"
                            ></page-table>

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