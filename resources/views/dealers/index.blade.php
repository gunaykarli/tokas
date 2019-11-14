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
        <div id="portfolio" class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <p class="lead text-center flipInY-animated"> {{__('dealers\list.dealerList')}} </p>
                    <hr style="width:600px">
                </div>
            </div>

            <!-- Begin: Message after creating a new dealer -->
            <!-- forwarded from store@DealerController -->
            <!-- session()->get('newDealer') returns 'created' -->
            @if(session()->has('newDealer'))
                <div class="form-group row">
                    <div class="alert alert-success">
                        {{__('dealers\list.'.session()->get('newDealer'))}}
                    </div>
                </div>
            @endif
            <!-- End: Message after creating a new dealer -->

            <!-- Begin: Message after updating a dealer -->
            <!-- forwarded from update@DealerController -->
            <!-- session()->get('updateDealer') returns 'updated' -->
            @if(session()->has('updateDealer'))
                <div class="form-group row">
                    <div class="alert alert-success">
                        {{__('dealers\list.'.session()->get('updateDealer'))}}
                    </div>
                </div>
            @endif
            <!-- End: Message after updating a dealer -->

            @can('create', \App\Dealer::class)
                <div class="mb30 text-right">
                    <a href="/dealer/create" class="btn btn-primary btn-sm">{{__('dealers\list.newDealer')}}</a>
                </div>
            @endcan

            <div class="table-responsive">
                <table class="table table-striped- table-bordered table-hover table-checkable" id="example">
                    <thead>
                    <tr>
                        <th>{{__('dealers\list.actions')}}</th>
                        <th>{{__('dealers\list.dealerID')}}</th>
                        <th>{{__('dealers\list.name')}}</th>
                        <th>{{__('dealers\list.owner')}}</th>
                        <th>{{__('dealers\list.type')}}</th>
                        <th>{{__('dealers\list.status')}}</th>
                        <th>{{__('dealers\list.category')}}</th>
                        <th>UVP VF</th>
                        <th>GVO VF</th>
                        <th>UVP VF-DSL</th>
                        <th>UVP MD</th>
                        <th>Energie</th>
                        <th>UVP YF</th>
                        <th>UVP AY</th>
                        <th>UVP Blau</th>
                        <th>UVP Otelo</th>
                        <th>UVP Otelo(alt)</th>
                        <th>{{__('dealers\list.regionVF')}}</th>
                        <th>{{__('dealers\list.regionToker')}}</th>
                        <th>{{__('dealers\list.VFVodafone')}}</th>
                        <th>{{__('dealers\list.VFToker')}}</th>

                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($dealers as $dealer)
                        <tr>
                            <td>
                                <a  href="/dealer/view/{{$dealer->id}}"><i class="fa-lg fa fa-binoculars  tooltip-active" data-toggle="tooltip" data-placement="top" title="{{__('dealers\list.view')}}"></i></a>

                                @can('update', $dealer)
                                    <a  href="/dealer/edit/{{$dealer->id}}"><i class="fa-lg fa fa-edit tooltip-active" data-toggle="tooltip" data-placement="top" title="{{__('dealers\list.update')}}"></i></a>
                                @endcan

                                @can('list', \App\Office::class)
                                    <a   href="/office/list/{{$dealer->id}}"><i class="fa-lg fa fa-building tooltip-active" data-toggle="tooltip" data-placement="top" title="{{__('dealers\list.offices')}}"></i></a>
                                @endcan

                                @can('list', \App\User::class)
                                    <a   href="/employee/dealer/list/{{$dealer->id}}"><i class="fa-lg fa fa-users tooltip-active" data-toggle="tooltip" data-placement="top" title="{{__('dealers\list.employees')}}"></i></a>
                                @endcan
                            </td>
                            <td>{{$dealer->user->where('dealer_id', $dealer->id)->where('role_id', 4)->first()->user_name}}</td>
                            <td>{{$dealer->name}}</td>
                            <td>{{$dealer->owner_name}} {{" "}} {{strtoupper($dealer->owner_surname)}}  </td>
                            <td>{{$dealer->type}}</td>
                            <td>{{$dealer->status}}</td>
                            <td>{{$dealer->category_id}}</td>
                            <td>{{$dealer->dealersMemberCode->vodafone_UVP}}</td>
                            <td>{{$dealer->dealersMemberCode->vodafone_GVO}}</td>
                            <td>{{$dealer->dealersMemberCode->vodafone_DSL_UVP}}</td>
                            <td>{{$dealer->dealersMemberCode->mobilcom_debitel_UVP}}</td>
                            <td>{{$dealer->dealersMemberCode->energie_user}}</td>
                            <td>{{$dealer->dealersMemberCode->yourfone_UVP}}</td>
                            <td>{{$dealer->dealersMemberCode->ayyildiz_UVP}}</td>
                            <td>{{$dealer->dealersMemberCode->blau_UVP}}</td>
                            <td>{{$dealer->dealersMemberCode->otelo_neu}}</td>
                            <td>{{$dealer->dealersMemberCode->otelo_alt}}</td>

                            <td>{{ \App\Region::find($dealer->offices->where('office_type', 1)->first()->dealerRegionsVBs->where('provider_id', 1)->first()->region_id)->name }}</td>
                            <td>{{ \App\Region::find($dealer->offices->where('office_type', 1)->first()->dealerRegionsVBs->where('provider_id', 0)->first()->region_id)->name }}</td>
                            <td>{{ \App\Representative::find($dealer->offices->where('office_type', 1)->first()->dealerRegionsVBs->where('provider_id', 1)->first()->primary_VB_id)->name }}</td>
                            <td>{{ \App\Representative::find($dealer->offices->where('office_type', 1)->first()->dealerRegionsVBs->where('provider_id', 0)->first()->primary_VB_id)->name }}</td>
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
