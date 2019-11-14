@extends('ralewayLayouts.master')

<!-- Page Header is yielded in the header.blade.php-->
@section('pageHeader')
    <!-- Begin Page Header -->
    <div class="header">
        <div class="container">
            <div class="row">
                <!-- Page Title -->
                <div class="col-sm-6 col-xs-12">
                    <h1>{{__('dealers/offices/list.employees')}} -  {{$dealer->name}}</h1>
                </div>

                <!-- Breadcrumbs -->
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li><span class="ion-home breadcrumb-home"></span><a href="/home">{{__('home.homePage')}}</a></li>
                        <li><a href="/office/list/{{$dealer->id}}">{{__('dealers/employees/list.offices')}}</a></li>
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
                    <p class="lead text-center flipInY-animated">{{__('dealers/employees/list.employees')}}</p>
                    <hr style="width:600px">
                </div>
            </div>

            <!-- Begin: Message after creating a new employee -->
                <!-- forwarded from store@ -->
                <!-- session()->get('newEmployee') returns 'created' -->
                @if(session()->has('newEmployee'))
                    <div class="form-group row">
                        <div class="alert alert-success">
                            {{__('dealers/employees/list.'.session()->get('newEmployee'))}}
                        </div>
                    </div>
                @endif
            <!-- End: Message after creating a new employee -->

            <!-- Begin: Message after updating a employee -->
                <!-- forwarded from update@ -->
                <!-- session()->get('updateEmployee') returns 'updated' -->
                @if(session()->has('updateEmployee'))
                    <div class="form-group row">
                        <div class="alert alert-success">
                            {{__('dealers/employees/list.'.session()->get('updateEmployee'))}}
                        </div>
                    </div>
                @endif
            <!-- End: Message after updating a employee -->

            @can('create', \App\Office::class)
                <div class="mb30 text-right">
                    <a href="/employee/create/{{$dealer->id}}" class="btn btn-primary btn-sm">{{__('dealers/employees/list.newEmployee')}}</a>
                </div>
            @endcan

            <div class="table-responsive">
                <table class="table table-striped- table-bordered table-hover table-checkable" id="example">
                    <thead>
                    <tr>
                        <th>{{__('dealers\employees\list.userName')}}</th>
                        <th>{{__('dealers\employees\list.name')}}</th>
                        <th>{{__('dealers\employees\list.office')}}</th>
                        <th>{{__('dealers\employees\list.email')}}</th>
                        <th>{{__('dealers\employees\list.mobile')}}</th>
                        <th>{{__('dealers\employees\list.roleID')}}</th>
                        <th>{{__('dealers\employees\list.status')}}</th>
                        <th>{{__('dealers\employees\list.actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($employees as $employee)
                        <tr>
                            <td>{{$employee->user_name}}</td>
                            <td>{{$employee->name}} {{" "}} {{strtoupper($employee->surname)}}</td>
                            <td>{{$employee->office->name}}</td>
                            <td>{{$employee->email}}</td>
                            <td>{{$employee->mobile}}</td>
                            <td>{{$employee->role_id}}</td>
                            <td>{{$employee->status}}</td>

                            <td>
                                @can('update', \App\User::class)
                                    <a href="/employee/edit/{{$employee->id}}"><i class="fa-lg fa fa-edit tooltip-active" data-toggle="tooltip" data-placement="top" title="{{__('dealers\employees\list.update')}}"></i></a>
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
