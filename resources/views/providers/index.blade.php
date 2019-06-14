@extends('ralewayLayouts.master')

<!-- Page Header is yielded in the header.blade.php-->
@section('pageHeader')
    <!-- Begin Page Header -->
    <div class="header">
        <div class="container">
            <div class="row">
                <!-- Page Title -->
                <div class="col-sm-6 col-xs-12">
                    <h1>Providers</h1>
                </div>

                <!-- Breadcrumbs -->
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li><span class="ion-home breadcrumb-home"></span><a href="index.html">Home</a></li>
                        <li>Pages</li>
                        <li>Services</li>
                    </ol>
                </div><!-- /column -->
            </div><!-- /row -->
        </div><!-- /container -->
    </div><!-- /page header -->
    <!-- End Page Header -->
@endsection

@section ('content')
    <!-- Begin Clients -->
    <section class="border-top pt40 mb40">
        <div class="container">

            <div class="heading mb30 text-center"><h4><span class="ion-android-social-user mr15"></span>Providers List</h4></div>

            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title pull-left" style="padding-top: 7.5px;">Panel header</h4>
                    <div class="btn-group pull-right">
                        <a href="#" class="btn btn-primary btn-sm">Add New Provider</a>
                    </div>
                </div>
                <div class = "panel-body">
                    <!--begin: Datatable -->
                    <div class="table-responsive">
                        <table class="table table-striped- table-bordered table-hover table-checkable" id="example">
                            <thead>
                            <tr>
                                <th>Provider ID</th>
                                <th>Name</th>
                                <th>Actions</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($providers as $provider)
                                <tr>
                                    <td>{{$provider->id}}</td>
                                    <td>{{$provider->name}}</td>
                                    <td>
                                        <span class="dropdown">
                                            <a href="#" class="btn  btn  btn--hover-brand  btn--icon  btn--icon-only  btn--pill" data-toggle="dropdown" aria-expanded="true">
                                                <i class="la la-ellipsis-h"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item"  href="/provider/create" ><i class="la la-edit"></i>Create</a>
                                                <a class="dropdown-item" href="/provider/edit/{{$provider->id}}"><i class="la la-leaf"></i>Update </a>
                                                <a class="dropdown-item" href="/provider/delete/{{$provider->id}}"><i class="la la-print"></i>Delete</a>
                                            </div>
                                        </span>
                                        <a href="#" class=" portlet__nav-link btn  btn  btn--hover-brand  btn--icon  btn--icon-only  btn--pill" title="View">
                                            <i class="la la-edit"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <span class="dropdown">
                                            <a href="#" class="btn  btn  btn--hover-brand  btn--icon  btn--icon-only  btn--pill" data-toggle="dropdown" aria-expanded="true">
                                                <i class="la la-ellipsis-h"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item"  href="/provider/create" ><i class="la la-edit"></i>Create</a>
                                                <a class="dropdown-item" href="/provider/edit/{{$provider->id}}"><i class="la la-leaf"></i>Update </a>
                                                <a class="dropdown-item" href="/provider/delete/{{$provider->id}}"><i class="la la-print"></i>Delete</a>
                                            </div>
                                        </span>
                                        <a href="#" class=" portlet__nav-link btn  btn  btn--hover-brand  btn--icon  btn--icon-only  btn--pill" title="View">
                                            <i class="la la-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
            <!-- End We Are Dedicated -->

        </div><!-- /container -->
    </section><!-- /section -->
    <!-- End Clients -->
@endsection

@section ('pageVendorsAndScripts')
    <script src="{{ asset('js/dataTable.js')}}" type="text/javascript"></script>
@endsection
