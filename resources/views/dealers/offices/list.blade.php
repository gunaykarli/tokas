@extends('ralewayLayouts.master')

<!-- Page Header is yielded in the header.blade.php-->
@section('pageHeader')
    <!-- Begin Page Header -->
    <div class="header">
        <div class="container">
            <div class="row">
                <!-- Page Title -->
                <div class="col-sm-6 col-xs-12">
                    <h1> {{__('dealers/offices/list.offices')}} - {{$offices[0]->dealer->name}}</h1>
                </div>

                <!-- Breadcrumbs -->
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li><span class="ion-home breadcrumb-home"></span><a href="/home">{{__('home.homePage')}}</a></li>
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

            <div class="row">
                <div class="col-md-12">
                    <p class="lead text-center flipInY-animated"> {{__('dealers/offices/list.officeList')}}</p>
                    <hr style="width:600px">
                </div>
            </div>

            <!-- Begin: Message after creating a new office -->
            <!-- forwarded from store@OfficeController -->
            <!-- session()->get('newDealer') returns 'created' -->
            @if(session()->has('newOffice'))
                <div class="form-group row">
                    <div class="alert alert-success">
                        {{__('dealers/offices/list.'.session()->get('newOffice'))}}
                    </div>
                </div>
            @endif
        <!-- End: Message after creating a new office -->

            <!-- Begin: Message after updating a office -->
            <!-- forwarded from update@OfficeController -->
            <!-- session()->get('updateDealer') returns 'updated' -->
            @if(session()->has('updateOffice'))
                <div class="form-group row">
                    <div class="alert alert-success">
                        {{__('dealers\list.'.session()->get('updateOffice'))}}
                    </div>
                </div>
            @endif
            <!-- End: Message after updating a office -->

            @can('create', \App\Office::class)
                <div class="mb30 text-right">
                    <a href="/office/create/{{$offices[0]->dealer_id}}" class="btn btn-primary btn-sm"> {{__('dealers/offices/list.newOffice')}}</a>
                </div>
            @endcan

            <div class="table-responsive">
                <table class="table table-striped- table-bordered table-hover table-checkable" id="example">
                    <thead>
                    <tr>
                        <th>{{__('dealers/offices/list.officeName')}}</th>
                        <th>{{__('dealers/offices/list.contactPerson')}}</th>
                        <th>{{__('dealers/offices/list.contactPersonEmail')}}</th>
                        <th>{{__('dealers/offices/list.contactPersonMobile')}}</th>
                        <th>{{__('dealers/offices/list.officePhone')}}</th>
                        <th>{{__('dealers/offices/list.officeType')}}</th>
                        <th>{{__('dealers/offices/list.status')}}</th>
                        <th>{{__('dealers/offices/list.address')}}</th>
                        <th>{{__('dealers/offices/list.aktionen')}}</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($offices as $office)
                        <tr>
                            <td>{{$office->name}}</td>

                            @foreach($office->dealer->user as $employee)
                                @if($office->contact_person_id == $employee->id)
                                    <td>{{$employee->name}} {{' '}} {{$employee->surname}}</td>
                                    <td>{{$employee->email}}</td>
                                    <td>{{$employee->mobile}}</td>
                                @endif
                            @endforeach

                            <td>{{$office->phone}}</td>

                            <td>
                                @if ($office->office_type == 1)
                                    {{'Main Office'}}
                                @else
                                    {{'Sub-Office'}}
                                @endif
                            </td>

                            <td>{{$office->status}}</td>

                            <td>{{$office->address->street_address}} {{' '}} {{$office->address->PO_box}} {{' '}} {{$office->address->postal_code}} {{' '}} {{$office->address->city}}</td>

                            <td>
                                @can('update', \App\Office::class)
                                    <a href="/office/edit/{{$office->id}}"><i class="fa-lg fa fa-edit tooltip-active" data-toggle="tooltip" data-placement="top" title="{{__('dealers/offices/list.update')}}"></i></a>
                                @endcan

                                @can('list', \App\User::class)
                                    <a   href="/employee/office/list/{{$office->id}}"><i class="fa-lg fa fa-users tooltip-active" data-toggle="tooltip" data-placement="top" title="{{__('dealers/offices/list.employees')}}"></i></a>
                                @endcan
                            </td>

                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div><!-- /container -->
    </section><!-- /section -->
    <!-- End: Dealers -->
@endsection

@section ('pageVendorsAndScripts')
    <script src="{{ asset('js/dataTable.js')}}" type="text/javascript"></script>
@endsection
