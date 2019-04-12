@extends ('partials.master')

@section ('content')

    <!-- BEGIN: Main Content "stays right before 'Subheader' section and rigth after 'END: Left Aside' section of the original html files'"-->
    <div class="m-grid__item m-grid__item--fluid m-wrapper">

        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title m-subheader__title--separator">{{__('tariffs/index.tariffs')}}</h3>
                    <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                        <li class="m-nav__item m-nav__item--home">
                            <a href="#" class="m-nav__link m-nav__link--icon">
                                <i class="m-nav__link-icon la la-home"></i>
                            </a>
                        </li>
                        <li class="m-nav__separator">-</li>
                        <li class="m-nav__item">
                            <a href="" class="m-nav__link">
                                <span class="m-nav__link-text">DataTables</span>
                            </a>
                        </li>
                        <li class="m-nav__separator">-</li>
                        <li class="m-nav__item">
                            <a href="" class="m-nav__link">
                                <span class="m-nav__link-text">Basic</span>
                            </a>
                        </li>
                        <li class="m-nav__separator">-</li>
                        <li class="m-nav__item">
                            <a href="" class="m-nav__link">
                                <span class="m-nav__link-text">Pagination Options</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- END: Subheader -->

        <!-- BEGIN: Content -->
        <div class="m-content">
            <div class="m-portlet m-portlet--mobile">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                {{__('tariffs/index.tariffs')}}
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
                            <li class="m-portlet__nav-item"></li>
                            <li class="m-portlet__nav-item">
                                <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover" aria-expanded="true">
                                    <a href="#" class="m-portlet__nav-link btn btn-lg btn-secondary  m-btn m-btn--icon m-btn--icon-only m-btn--pill  m-dropdown__toggle">
                                        <i class="la la-ellipsis-h m--font-brand"></i>
                                    </a>
                                    <div class="m-dropdown__wrapper">
                                        <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                        <div class="m-dropdown__inner">
                                            <div class="m-dropdown__body">
                                                <div class="m-dropdown__content">
                                                    <ul class="m-nav">
                                                        <li class="m-nav__section m-nav__section--first">
                                                            <span class="m-nav__section-text">Quick Actions</span>
                                                        </li>
                                                        <li class="m-nav__item">
                                                            <a href="" class="m-nav__link">
                                                                <i class="m-nav__link-icon flaticon-share"></i>
                                                                <span class="m-nav__link-text">Create Post</span>
                                                            </a>
                                                        </li>
                                                        <li class="m-nav__item">
                                                            <a href="" class="m-nav__link">
                                                                <i class="m-nav__link-icon flaticon-chat-1"></i>
                                                                <span class="m-nav__link-text">Send Messages</span>
                                                            </a>
                                                        </li>
                                                        <li class="m-nav__item">
                                                            <a href="" class="m-nav__link">
                                                                <i class="m-nav__link-icon flaticon-multimedia-2"></i>
                                                                <span class="m-nav__link-text">Upload File</span>
                                                            </a>
                                                        </li>
                                                        <li class="m-nav__section">
                                                            <span class="m-nav__section-text">Useful Links</span>
                                                        </li>
                                                        <li class="m-nav__item">
                                                            <a href="" class="m-nav__link">
                                                                <i class="m-nav__link-icon flaticon-info"></i>
                                                                <span class="m-nav__link-text">FAQ</span>
                                                            </a>
                                                        </li>
                                                        <li class="m-nav__item">
                                                            <a href="" class="m-nav__link">
                                                                <i class="m-nav__link-icon flaticon-lifebuoy"></i>
                                                                <span class="m-nav__link-text">Support</span>
                                                            </a>
                                                        </li>
                                                        <li class="m-nav__separator m-nav__separator--fit m--hide">
                                                        </li>
                                                        <li class="m-nav__item m--hide">
                                                            <a href="#" class="btn btn-outline-danger m-btn m-btn--pill m-btn--wide btn-sm">Submit</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="m-portlet__body" id="general">

                            @csrf
                            <!--BEGIN:List of the providers -->
                            <div class="m-form__group form-group">
                                <label>{{__('tariffs/index.providers')}}</label>

                                <div class="m-radio-inline" id="radioInLineProviders">
                                    <label class="m-radio">
                                        <input type="radio" name="provider" id="provider" value=0 checked> {{__('tariffs/index.all')}}
                                        <span></span>
                                    </label>
                                    @foreach($providers as $provider)
                                        <label class="m-radio">
                                            <input type="radio" name="provider" id="provider" value={{$provider->id}}> {{$provider->name}}
                                            <span></span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="m-separator m-separator--dashed m-separator--lg"></div>
                            <!--END:List of the providers -->

                            <!--BEGIN:List of the tariffs groups of the selected providers -->
                            <div class="m-form__group form-group">
                                <label>{{__('tariffs/index.groups')}}</label>

                                <div class="m-radio-inline" id="radioInLineGroups">
                                    <label class="m-radio">
                                        <input type="radio" name="tariffGroup" id="tariffGroup" value=0 checked> {{__('tariffs/index.all')}}
                                        <span></span>
                                    </label>
                                    <!-- Radio buttons will be added HERE by the "tariffList-Provider.js"
                                    once any radio button change in the div radio group with id named "radioInLineProviders"  -->
                                </div>
                            </div>
                            <div class="m-separator m-separator--dashed m-separator--lg"></div>
                            <!--END:List of the tariffs groups of the selected providers -->

                            <!--begin::Portlet-->
                            <div class="m-portlet m-portlet--head-sm" m-portlet="true" id="filterPortlet" >
                                    <div class="m-portlet__head">
                                        <div class="m-portlet__head-caption">
                                            <div class="m-portlet__head-title">
												<span class="m-portlet__head-icon">
													<i class="flaticon-placeholder-2"></i>
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
                                                    <div class="col-xl-9 col-lg-9">
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
                                                    <div class="col-xl-9 col-lg-9">
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
                                                    <div class="col-xl-9 col-lg-9">
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


                                    <!--end::Form parameters-->
                                </div>
                            <!--end::Portlet-->

                            <div class="m-separator m-separator--dashed m-separator--lg"></div>

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
                                    <td><a href="#" class="btn btn-primary" ><span>{{__('tariffs/index.order')}}</span>&nbsp;&nbsp;</a></td>
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
    <script src="{{ asset('js/tariffListWithFilter.js')}}" type="text/javascript"></script>
    <!--end::Page Scripts-->
@endsection
