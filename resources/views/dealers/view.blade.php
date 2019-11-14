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
                        <li><a href="/dealer/index">{{__('dealers\list.dealers')}}</a></li>
                    </ol>
                </div><!-- /column -->
            </div><!-- /row -->
        </div><!-- /container -->
    </div><!-- /page header -->
    <!-- End Page Header -->
@endsection

@section ('content')
    <!-- Begin: General info -->
    <section class="pt30 mb20">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p class="lead text-center flipInY-animated"> {{__('dealers\view.dealerInfo')}} </p>
                    <hr style="width:600px">
                </div>
            </div>

            <div class="heading mb30 text-left"><h4>{{__('dealers\view.generalInfo')}}</h4></div>

            <div class="row">
                <label class="col-md-4 text-right">{{__('dealers\view.status')}}:</label>
                <div class="col-md-4">{{$dealer->status}}</div>
            </div>
            <div class="row">
                <label class="col-md-4 text-right">{{__('dealers\view.name')}}:</label>
                <div class="col-md-4">{{$dealer->name}}</div>
            </div>
            <div class="row">
                <label class="col-md-4 text-right">{{__('dealers\view.owner')}}:</label>
                <div class="col-md-4">{{strtoupper($dealer->owner_surname)}} {{' '}}{{$dealer->owner_name}}</div>
            </div>
            <div class="row">
                <label class="col-md-4 text-right">{{__('dealers\view.type')}}:</label>
                <div class="col-md-4">{{$dealer->type}}</div>
            </div>
            <div class="row">
                <label class="col-md-4 text-right">{{__('dealers\view.category')}}:</label>
                <div class="col-md-4">{{$dealer->category_id}}</div>
            </div>
            <div class="row">
                <label class="col-md-4 text-right">{{__('dealers\view.limitedSales')}}:</label>
                <div class="col-md-4"> @if($dealer->is_limited_sales == 1) {{__('dealers\view.yes')}} @else {{__('dealers\view.no')}} @endif </div>
            </div>
            <div class="row">
                <label class="col-md-4 text-right">{{__('dealers\view.remainingSalesAmount')}}:</label>
                <div class="col-md-4">@if($dealer->is_limited_sales == 1) {{$dealer->remaining_sales_amount}} @else - @endif  </div>
            </div>


        </div><!-- /container -->
    </section><!-- /section -->
    <!-- End: General info -->

    <!-- Begin: Main office -->
    <section class=" mb20">
        <div class="container">
            <div class="heading mb30 text-left"><h4>{{__('dealers\view.mainOffice')}}</h4></div>
            <div class="row">
                <label class="col-md-4 text-right">{{__('dealers\view.name')}}:</label>
                <div class="col-md-4">{{$mainOffice->name}}</div>
            </div>
            <div class="row">
                <label class="col-md-4 text-right">{{__('dealers\view.contactPerson')}}:</label>
                <div class="col-md-4">{{strtoupper($mainOffice->contact_person_surname)}} {{' '}} {{$mainOffice->contact_person_name}}</div>
            </div>
            <div class="row">
                <label class="col-md-4 text-right">{{__('dealers\view.mobile')}}:</label>
                <div class="col-md-4">{{$mainOffice->mobile}}</div>
            </div>
            <div class="row">
                <label class="col-md-4 text-right">{{__('dealers\view.email')}}:</label>
                <div class="col-md-4">{{$mainOffice->email}}</div>
            </div>
            <div class="row">
                <label class="col-md-4 text-right">{{__('dealers\view.phone')}}:</label>
                <div class="col-md-4">{{$mainOffice->phone}}</div>
            </div>
            <div class="row">
                <label class="col-md-4 text-right">{{__('dealers\view.address')}}:</label>
                <div class="col-md-4">{{
                    $mainOfficeAddress->street_address. " ".
                    $mainOfficeAddress->PO_box . " " .
                    $mainOfficeAddress->city . " " .
                    $mainOfficeAddress->state . " " .
                    $mainOfficeAddress->country
                    }}
                </div>
            </div>
        </div><!-- /container -->
    </section><!-- /section -->
    <!-- End: Main office -->

    <!-- Begin: Member Codes -->
    <section class=" mb20">
        <div class="container">
            <div class="heading mb30 text-left"><h4>{{__('dealers\view.memberCodes')}}</h4></div>
            <div class="row">
                <label class="col-md-4 text-right">Vodafone UVP:</label>
                <div class="col-md-4">{{$memberCodes->vodafone_UVP}}</div>
            </div>
            <div class="row">
                <label class="col-md-4 text-right">Vodafone GVO:</label>
                <div class="col-md-4">{{$memberCodes->vodafone_GVO}}</div>
            </div>
            <div class="row">
                <label class="col-md-4 text-right">Vodafone DSL UVP:</label>
                <div class="col-md-4">{{$memberCodes->vodafone_DSL_UVP}}</div>
            </div>
            <div class="row">
                <label class="col-md-4 text-right">Mobilcom Debitel UVP:</label>
                <div class="col-md-4">{{$memberCodes->mobilcom_debitel_UVP}}</div>
            </div>
            <div class="row">
                <label class="col-md-4 text-right">Energie User:</label>
                <div class="col-md-4">{{$memberCodes->energie_user}}</div>
            </div>
            <div class="row">
                <label class="col-md-4 text-right">Yourfone UVP:</label>
                <div class="col-md-4">{{$memberCodes->yourfone_UVP}}</div>
            </div>
            <div class="row">
                <label class="col-md-4 text-right">Ay Yıldız UVP:</label>
                <div class="col-md-4">{{$memberCodes->ayyildiz_UVP}}</div>
            </div>
            <div class="row">
                <label class="col-md-4 text-right">Blau UVP:</label>
                <div class="col-md-4">{{$memberCodes->blau_UVP}}</div>
            </div>
            <div class="row">
                <label class="col-md-4 text-right">Otelo Neu:</label>
                <div class="col-md-4">{{$memberCodes->otelo_neu}}</div>
            </div>
            <div class="row">
                <label class="col-md-4 text-right">Otelo Alt:</label>
                <div class="col-md-4">{{$memberCodes->otelo_alt}}</div>
            </div>

        </div><!-- /container -->
    </section><!-- /section -->
    <!-- End: Main office -->

    <!-- Begin: Bank -->
    <section class=" mb20">
        <div class="container">
            <div class="heading mb30 text-left"><h4>{{__('dealers\view.bankInfo')}}</h4></div>
            <div class="row">
                <label class="col-md-4 text-right">IBAN:</label>
                <div class="col-md-4">{{$bankAccount->IBAN}}</div>
            </div>
            <div class="row">
                <label class="col-md-4 text-right">{{__('dealers\view.cashDeposit')}}:</label>
                <div class="col-md-4">
                    @if($bankAccount->cash_deposit == 'on')
                        {{__('dealers\view.yes')}}
                    @else
                        {{__('dealers\view.no')}}
                    @endif
                </div>
            </div>
        </div><!-- /container -->
    </section><!-- /section -->
    <!-- End: Bank -->
@endsection

@section ('pageVendorsAndScripts')
    <script src="{{ asset('js/dataTable.js')}}" type="text/javascript"></script>
@endsection
