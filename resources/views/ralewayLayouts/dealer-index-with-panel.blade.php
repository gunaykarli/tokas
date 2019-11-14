@extends('ralewayLayouts.master')

<!-- Page Header is yielded in the header.blade.php-->
@section('pageHeader')
    <!-- Begin Page Header -->
    <div class="header">
        <div class="container">
            <div class="row">
                <!-- Page Title -->
                <div class="col-sm-6 col-xs-12">
                    <h1> {{__('dealers\list.dealers')}}</h1>
                </div>

                <!-- Breadcrumbs -->
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li><span class="ion-home breadcrumb-home"></span><a href="/home">Home</a></li>
                    </ol>
                </div><!-- /column -->
            </div><!-- /row -->
        </div><!-- /container -->
    </div><!-- /page header -->
    <!-- End Page Header -->
@endsection

@section ('content')
    <!-- Begin: Dealers -->
    <section class="border-top pt40 mb40">
        <div class="container">

            <div class="heading mb30 text-center"><h4><span class="ion-android-social-user mr15"></span> {{__('dealers\list.dealerList')}}</h4></div>
            <div class="mb15 text-right">
                <a href="/dealer/create" class="btn btn-primary btn-sm">{{__('dealers\list.newDealer')}}</a>
            </div>
            <div class="table-responsive">
                <table class="table table-striped- table-bordered table-hover table-checkable" id="example">
                    <thead>
                    <tr>
                        <th>{{__('dealers\list.dealerID')}}</th>
                        <th>{{__('dealers\list.name')}}</th>
                        <th>{{__('dealers\list.owner')}}</th>
                        <th>{{__('dealers\list.type')}}</th>
                        <th>{{__('dealers\list.status')}}</th>
                        <th>{{__('dealers\list.category')}}</th>
                        <th>{{__('dealers\list.actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($dealers as $dealer)
                        <tr>
                            <td>{{$dealer->id}}</td>
                            <td>{{$dealer->name}}</td>
                            <td>{{$dealer->owner_name}} {{" "}} {{strtoupper($dealer->owner_surname)}}  </td>
                            <td>{{$dealer->type}}</td>
                            <td>{{$dealer->status}}</td>
                            <td>{{$dealer->category_id}}</td>
                            <td>
                                <a  href="/dealer/view/{{$dealer->id}}"><i class="fa-lg fa fa-binoculars  tooltip-active" data-toggle="tooltip" data-placement="top" title="{{__('dealers\list.view')}}"></i></a>

                                @can('update', $dealer)
                                    <a  href="/dealer/edit/{{$dealer->id}}"><i class="fa-lg fa fa-edit tooltip-active" data-toggle="tooltip" data-placement="top" title="{{__('dealers\list.update')}}"></i></a>
                                @endcan

                                @can('list', \App\Office::class)
                                    <a   href="/office/list/{{$dealer->id}}"><i class="fa-lg fa fa-building tooltip-active" data-toggle="tooltip" data-placement="top" title="{{__('dealers\list.offices')}}"></i></a>
                                @endcan

                                @can('list', \App\User::class)
                                    <a   href="/employee/list/{{$dealer->id}}"><i class="fa-lg fa fa-users tooltip-active" data-toggle="tooltip" data-placement="top" title="{{__('dealers\list.employees')}}"></i></a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>


            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title pull-left" style="padding-top: 7.5px;">{{__('dealers\list.dealerList')}}</h4>
                    <div class="btn-group pull-right">
                        <a href="/dealer/create" class="btn btn-primary btn-sm">{{__('dealers\list.newDealer')}}</a>
                    </div>
                </div>
                <div class = "panel-body">
                    <!--begin: Datatable -->
                    <div class="table-responsive">
                        <table class="table table-striped- table-bordered table-hover table-checkable" id="example">
                            <thead>
                            <tr>
                                <th>{{__('dealers\list.dealerID')}}</th>
                                <th>{{__('dealers\list.name')}}</th>
                                <th>{{__('dealers\list.owner')}}</th>
                                <th>{{__('dealers\list.type')}}</th>
                                <th>{{__('dealers\list.status')}}</th>
                                <th>{{__('dealers\list.category')}}</th>
                                <th>{{__('dealers\list.actions')}}</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach ($dealers as $dealer)
                                <tr>
                                    <td>{{$dealer->id}}</td>
                                    <td>{{$dealer->name}}</td>
                                    <td>{{$dealer->owner_name}} {{" "}} {{strtoupper($dealer->owner_surname)}}  </td>
                                    <td>{{$dealer->type}}</td>
                                    <td>{{$dealer->status}}</td>
                                    <td>{{$dealer->category_id}}</td>
                                    <td>
                                        <a  href="/dealer/view/{{$dealer->id}}"><i class="fa-lg fa fa-binoculars  tooltip-active" data-toggle="tooltip" data-placement="top" title="{{__('dealers\list.view')}}"></i></a>

                                        @can('update', $dealer)
                                        <a  href="/dealer/edit/{{$dealer->id}}"><i class="fa-lg fa fa-edit tooltip-active" data-toggle="tooltip" data-placement="top" title="{{__('dealers\list.update')}}"></i></a>
                                        @endcan

                                        @can('list', \App\Office::class)
                                            <a   href="/office/list/{{$dealer->id}}"><i class="fa-lg fa fa-building tooltip-active" data-toggle="tooltip" data-placement="top" title="{{__('dealers\list.offices')}}"></i></a>
                                        @endcan

                                        @can('list', \App\User::class)
                                            <a   href="/employee/list/{{$dealer->id}}"><i class="fa-lg fa fa-users tooltip-active" data-toggle="tooltip" data-placement="top" title="{{__('dealers\list.employees')}}"></i></a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                    <!--end: Datatable -->
                </div>
            </div>
        </div><!-- /container -->
    </section><!-- /section -->
    <!-- End: Dealers -->
@endsection

@section ('pageVendorsAndScripts')
    <script src="{{ asset('js/dataTable.js')}}" type="text/javascript"></script>
@endsection
