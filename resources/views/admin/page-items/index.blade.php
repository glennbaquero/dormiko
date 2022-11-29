@extends('admin-master')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Page Items
            <small>Manage Page Items</small>
        </h1>
        <ol class="breadcrumb">
            <li class="active"><a href="{{ route('page-items.index') }}"><i class="fas fa-file-alt"></i> Page Items</a></li>
        </ol>

    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row mb-4">
            <div class="col-md-12">
                {{-- @if ($checker->permission->can(['faqs.create'])) --}}
                    <a href="{{ route('page-items.create') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus mr-1"></i> Add Page Item
                    </a>
                {{-- @endif --}}
            </div>
            <!-- /.col -->
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="box box-widget nav-tabs-custom table-responsive">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#page-items" data-toggle="tab"><h5><b>Page Items</b></h5></a>
                        </li>
                     {{--    <li>
                            <a @click="runDatatable('page-items-archive')" href="#page-items-archive" data-toggle="tab"><h5><b>Archive</b></h5></a>
                        </li>          --}}                                          
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active" id="page-items">
                            
                            <page-item-table ref="page-items"
                            :filterpages="{{ $pages }}"
                            :filtertypes="{{ $types }}"
                            :autofetch="true"
                            :fetchurl="'{{ route('page-items.fetch') }}'"
                            ></page-item-table>

                        </div>
                        <div class="tab-pane" id="page-items-archive">
                            
                            <page-item-table ref="page-items-archive"
                            :filterpages="{{ $pages }}"
                            :filtertypes="{{ $types }}"
                            :autofetch="false"
                            :fetchurl="'{{ route('page-items.fetch.archive') }}'"
                            ></page-item-table>

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