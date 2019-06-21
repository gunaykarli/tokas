@extends ('partials.master')

@section ('content')

    <!-- BEGIN: Main Content "stays right before 'Subheader' section and rigth after 'END: Left Aside' section of the original html files'"-->
    <div class="m-grid__item m-grid__item--fluid m-wrapper">


        <!-- BEGIN: Content -->
        <div class="m-content">
            <div class="m-portlet m-portlet--mobile">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                <!-- define hidden field for provider id which is used in js/tariffListWithFilter.js -->

                                <input type="radio" name="providerID" id="providerID" value={{$provider->id}} checked>{{$provider->name}} {{__('tariffs/index.tariffs')}}
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">
                                <!-- Only authorized users who are "Admin and power user in Toker" can generate new dealer...-->
                                @can('create', \App\Dealer::class)
                                    <a  href="/dealer/create"  class="btn btn-info m-btn m-btn--custom m-btn--icon m-btn--air">
                                                    <span>
                                                        <i class="la la-plus"></i>
                                                        <span>{{__('dealers\list.newDealer')}}</span>
                                                    </span>
                                    </a>
                                @endcan
                            </li>

                        </ul>
                    </div>
                </div>

                <div class="m-portlet__body" id="general">

                    @csrf


                    <!--BEGIN:List of the tariffs groups of the selected providers -->
                    <div class="m-form__group form-group">
                        <label>{{__('tariffs/index.groups')}}</label>

                        <div class="m-radio-inline" id="radioInLineGroups">
                            <label class="m-radio">
                                <input type="radio" name="tariffGroup" id="tariffGroup" value=0 checked> {{__('tariffs/index.all')}}
                                <span></span>
                            </label>
                            @foreach($tariffGroups as $tariffGroup)
                                <label class="m-radio">
                                    <input type="radio" name="tariffGroup" id="tariffGroup" value={{$tariffGroup->id}}> {{$tariffGroup->name}}
                                    <span></span>
                                </label>
                            @endforeach

                        </div>
                    </div>
                    <div class="m-separator m-separator--dashed m-separator--lg"></div>
                    <!--END:List of the tariffs groups of the selected providers -->

                    <!--begin::Filter Portlet-->
                    <div class="m-portlet m-portlet--head-sm" m-portlet="true" id="filterPortlet" >
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
												<span class="m-portlet__head-icon">
													<i class="fa fa-filter"></i>
												</span>
                                    <h3 class="m-portlet__head-text">
                                        {{__('tariffs/index.filterParameters')}}
                                    </h3>
                                </div>
                            </div>
                            <div class="m-portlet__head-tools">
                                <ul class="m-portlet__nav">
                                    <li class="m-portlet__nav-item">
                                        <a href="" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon"><i class="la la-angle-down"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!--begin::Filter parameters-->
                        <form class="m-form m-form--fit m-form--label-align-right">
                            <div class="m-portlet__body">
                                <div class="m-form__group form-group" id="filterPortlet">
                                    <div class="form-group m-form__group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('tariffs/index.maxBasePrice')}}:</label>
                                        <div class="col-xl-3 col-lg-3">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">€</span>
                                                </div>
                                                <input type="text" class="form-control m-input" name="maxBasePrice" id="maxBasePrice">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('tariffs/index.maxSpeed')}}:</label>
                                        <div class="col-xl-3 col-lg-3">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Mbit/s</span>
                                                </div>
                                                <input type="text" class="form-control m-input" name="maxSpeed" id="maxSpeed">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('tariffs/index.maxBandWidth')}}:</label>
                                        <div class="col-xl-3 col-lg-3">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">GB</span>
                                                </div>
                                                <input type="text" class="form-control m-input" name="maxBandWidth" id="maxBandWidth">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="m-portlet__foot m-portlet__foot--fit">
                                <div class="col-md-2">
                                    <div class="m-demo-icon" id="reset">
                                        <div class="m-demo-icon__preview">
                                            <i class="la la-toggle-left"></i>
                                        </div>
                                        <div class="m-demo-icon__class">
                                            {{__('tariffs/index.resetFilter')}} </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!--end::Filter parameters-->
                    </div>
                    <!--end::Filter Portlet-->

                    <!--BEGIN: Datatable -->
                    <table class="table table-striped- table-bordered table-hover table-checkable" >
                        <thead>
                        <tr>
                            <th> {{__('tariffs/index.network')}}</th>
                            <th> {{__('tariffs/index.name')}}</th>
                            <th> {{__('tariffs/index.info')}}</th>
                            <th> {{__('tariffs/index.basePrice')}}</th>
                            <th> {{__('tariffs/index.provision')}}</th>
                            <th> {{__('tariffs/index.onTop')}}</th>
                            <th>{{__('tariffs/index.order')}}</th>
                        </tr>
                        </thead>
                        <tbody id="tableBody">

                        @foreach ($tariffs as $tariff)
                            <tr>
                                <td>{{$tariff->network->name}}</td>
                                <td>{{$tariff->name}}</td>
                                <td><button type="button" class="btn btn-danger" data-toggle="m-popover" title="{{$tariff->name}}" data-content="{{$tariff->network->name}} {{$tariff->base_price}}">Info</button></td>
                                <td>{{$tariff->base_price}}</td>
                                <td>{{$tariff->provision}}</td>
                                <td>
                                    @foreach($tariffsWithOnTopForTheDealer as $tariffWithOnTopForTheDealer)
                                        @if($tariffWithOnTopForTheDealer->id == $tariff->id)
                                            {{$tariffWithOnTopForTheDealer->pivot->ontop}}
                                        @endif
                                    @endforeach
                                </td>
                                <td><a href="/contract/shopping-cart/add-tariff/{{$tariff->id}}/{{$isAdditionalTariff}}" class="btn btn-primary" ><span>{{__('tariffs/index.order')}}</span>&nbsp;&nbsp;</a></td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                    <!--END: Datatable -->
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
        <!-- END: Content -->
    </div>
    <!-- END: Main Content -->

@endsection


@section ('pageVendorsAndScripts')
    <!--begin::Page Vendors -->

    <!--end::Page Vendors -->

    <!--begin::Page Scripts-->
    <script src="{{ asset('js/tariffListWithFilter1.js')}}" type="text/javascript"></script>
    <!--end::Page Scripts-->
@endsection
