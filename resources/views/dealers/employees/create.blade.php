@extends('ralewayLayouts.master')

<!-- Page Header is yielded in the header.blade.php-->
@section('pageHeader')
    <!-- Begin Page Header -->
    <div class="header">
        <div class="container">
            <div class="row">
                <!-- Page Title -->
                <div class="col-sm-6 col-xs-12">
                    <h1> {{__('dealers/employees/create.employees')}} -  {{$offices[0]->dealer->name}}</h1>
                </div>

                <!-- Breadcrumbs -->
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li><span class="ion-home breadcrumb-home"></span><a href="/home">{{__('home.homePage')}}</a></li>
                        <li><a href="/office/list/{{$offices[0]->dealer->id}}">{{__('dealers/employees/create.offices')}}</a></li>
                    </ol>
                </div><!-- /column -->
            </div><!-- /row -->
        </div><!-- /container -->
    </div><!-- /page header -->
    <!-- End Page Header -->
@endsection

@section ('content')
    <!--begin: Form -->
    <form method="POST" action="/employee/store" class="form-horizontal" role="form">
        @csrf


        <!--begin: Form Body -->
        <!-- Begin: General info - 1 -->
        <section class="pt30 mb20">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <p class="lead text-center flipInY-animated">{{__('dealers/employees/create.newEmployee')}}</p>
                        <hr style="width:600px">
                    </div>
                </div>

                <div class="heading mb30 text-left"><h4>{{__('dealers/employees/create.employeeInfo')}}</h4></div>

                <div class="form-group row">
                    <label class="col-md-4 control-label text-right">{{__('dealers/employees/create.name')}}</label>
                    <div class="col-md-4">
                        <input type="text" name="name" class="form-control">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-4 control-label text-right">{{__('dealers/employees/create.surname')}}</label>
                    <div class="col-md-4">
                        <input type="text" name="surname" class="form-control">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-4 control-label text-right">{{__('dealers/employees/create.email')}}</label>
                    <div class="col-md-4">
                        <input type="email" name="email" class="form-control">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-4 control-label text-right">{{__('dealers/employees/create.mobile')}}</label>
                    <div class="col-md-4">
                        <input type="text" name="mobile" class="form-control">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-4 control-label text-right">{{__('dealers/employees/create.office')}}</label>
                    <div class="col-md-4">
                        @if (auth()->check())
                            <select name="officeID" class="form-control">
                                <option>{{__('dealers/employees/create.selectEmployee')}} </option>
                                @foreach($offices as $office)
                                    <option value={{$office->id}}>{{$office->name}}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-rw btn-primary">{{__('dealers\create.save')}}</button>
                    </div>
                </div>
            </div>
        </section>
        <!-- End: General info -->



    </form>
    <!--end: Form -->
@endsection

@section ('pageVendorsAndScripts')
    <script src="{{ asset('js/dataTable.js')}}" type="text/javascript"></script>
@endsection
