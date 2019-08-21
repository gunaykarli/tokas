@extends ('partials.master')

@section ('content')

    <!-- BEGIN: Main Content "stays right before 'Subheader' section and rigth after 'END: Left Aside' section of the original html files'"-->
    <div class="m-grid__item m-grid__item--fluid m-wrapper">

        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title m-subheader__title--separator">{{__('contracts/shoppingCart.shoppingCard')}}</h3>
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
                                {{__('contracts/shoppingCart.shoppingCard')}}
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">

                            </li>
                        </ul>
                    </div>
                </div>

                <div class="m-portlet__body" id="general">

                    <!--BEGIN: main tariff -->
                    <table class="table table-striped- table-bordered table-hover table-checkable" >
                        <thead>
                            <tr>
                                <th> {{__('contracts/shoppingCart.provider')}}</th>
                                <th> {{__('contracts/shoppingCart.tariff')}}</th>
                                <th> {{__('contracts/shoppingCart.SIMImeiAndServices')}}</th>
                                <th> {{__('contracts/shoppingCart.delete')}}</th>
                                <th> {{__('contracts/shoppingCart.basePrice')}}</th>
                                @can('viewProvisionColumn', \App\ShoppingCart::class)
                                    <th> {{__('contracts/shoppingCart.provision')}}</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody id="">
                            @foreach($contents->where('additional_tariff', 0) as $content)
                                <tr>
                                    <td>{{(\App\Provider::where('id', $content->producer_id)->first()->name)}}</td>
                                    @if($content->product_type == 1) <!-- "1" indicates that the selected product is a tariff not a mobile phone. -->
                                        <td>{{(\App\Tariff::where('id', $content->product_id))->first()->name}}</td>
                                    @endif
                                    <td>
                                        <!-- href="/contracts/vodafone/shopping-cart/enter-SIM-IMEI-services/content->product_id/0- 0 means the SIM card is NOT additional tariff-->
                                        <a href="/contracts/vodafone/shopping-cart/enter-SIM-IMEI-services/{{$content->product_id}}/{{0}}" class="btn btn-warning m-btn m-btn--custom m-btn--icon m-btn--air">
                                            <span>
                                                <i class="la la-cart-plus"></i>
                                                <span> {{__('contracts/shoppingCart.services')}}</span>
                                            </span>
                                        </a>
                                    </td>
                                    <td><a href="/contracts/vodafone/shopping-cart/change-main-tariff/{{$content->product_id}}" class="btn btn-danger" ><span>{{__('contracts/shoppingCart.changeTariff')}}</span>&nbsp;&nbsp;</a></td>
                                    @if($content->product_type == 1) <!-- "1" indicates that the selected product is a tariff not a mobile phone. -->
                                    <td>{{(\App\Tariff::where('id', $content->product_id))->first()->base_price}}</td>
                                    @endif
                                    @can('viewProvisionColumn', \App\ShoppingCart::class)
                                        @if($content->product_type == 1) <!-- "1" indicates that the selected product is a tariff not a mobile phone. -->
                                        <td>{{(\App\Tariff::where('id', $content->product_id))->first()->provision}}</td>
                                        @endif
                                    @endcan
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!--END: main tariff -->

                    <!--BEGIN: additional tariffs button-->
                    <table class="table table-striped- table-bordered table-hover table-checkable" >
                        <tbody id="">
                        <tr>
                            <td colspan="7" align="left">
                                <a href="/tariff/index/{{session('providerID')}}/{{1}}" class="btn btn-outline-primary m-btn m-btn--custom m-btn--icon m-btn--air">
                                    <span>
                                        <i class="la la-cart-plus"></i>
                                        <span> {{__('contracts/shoppingCart.additionalTariffOrder')}}</span>
                                    </span>
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <!--END: additional tariffs button -->

                    <!--BEGIN: additional tariffs -->
                    @if($contents->where('additional_tariff', 1)->first())
                        <table class="table table-striped- table-bordered table-hover table-checkable" >
                        <thead>
                        <tr>
                            <th> {{__('contracts/shoppingCart.provider')}}</th>
                            <th> {{__('contracts/shoppingCart.tariff')}}</th>
                            <th> {{__('contracts/shoppingCart.SIMImeiAndServices')}}</th>
                            <th> {{__('contracts/shoppingCart.delete')}}</th>
                            <th> {{__('contracts/shoppingCart.basePrice')}}</th>
                            @can('viewProvisionColumn', \App\ShoppingCart::class)
                                <th> {{__('contracts/shoppingCart.provision')}}</th>
                            @endcan
                        </tr>
                        </thead>
                        <tbody id="">
                            @foreach($contents->where('additional_tariff', 1) as $content)
                                <tr>
                                    <td>{{(\App\Provider::where('id', $content->producer_id)->first()->name)}}</td>
                                    @if($content->product_type == 1) <!-- "1" indicates that the selected product is a tariff not a mobile phone. -->
                                        <td>{{(\App\Tariff::where('id', $content->product_id))->first()->name}}</td>
                                    @endif
                                    <td>
                                        <!-- href="/contracts/vodafone/shopping-cart/enter-SIM-IMEI-services/content->product_id/1- 1 means the SIM card is additional tariff-->
                                        <a href="/contracts/vodafone/shopping-cart/enter-SIM-IMEI-services/{{$content->product_id}}/{{1}}" class="btn btn-warning m-btn m-btn--custom m-btn--icon m-btn--air">
                                            <span>
                                                <i class="la la-cart-plus"></i>
                                                <span> {{__('contracts/shoppingCart.services')}}</span>
                                            </span>
                                        </a>
                                    </td>
                                    <td><a href="/contract/shopping-cart/delete-tariff/{{$content->product_id}}" class="btn btn-danger" ><span>{{__('contracts/shoppingCart.delete')}}</span>&nbsp;&nbsp;</a></td>
                                    @if($content->product_type == 1) <!-- "1" indicates that the selected product is a tariff not a mobile phone. -->
                                    <td>{{(\App\Tariff::where('id', $content->product_id))->first()->base_price}}</td>
                                    @endif
                                    @can('viewProvisionColumn', \App\ShoppingCart::class)
                                        @if($content->product_type == 1) <!-- "1" indicates that the selected product is a tariff not a mobile phone. -->
                                        <td>{{(\App\Tariff::where('id', $content->product_id))->first()->provision}}</td>
                                        @endif
                                    @endcan
                                </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @endif
                    <!--END: additional tariffs -->

                    <!--BEGIN: totals -->
                    <table class="table table-striped- table-bordered table-hover table-checkable" >
                        <tbody id="">
                        <tr>
                            <td colspan="4" align="right">{{__('contracts/shoppingCart.totalBasePrice')}}</td>
                            <td align="center">{{$totalBasePrice}}</td>
                            <td align="left"></td>
                        </tr>
                        @can('viewProvisionColumn', \App\ShoppingCart::class)
                            <tr>
                                <td colspan="4" align="right">{{__('contracts/shoppingCart.totalProvision')}}</td>
                                <td align="left"></td>
                                <td align="center">{{$totalProvision}}</td>
                            </tr>
                        @endcan
                        <tr>
                            <td colspan="6" align="center">
                                <!-- Set up the link according to the provider of the tariff.
                                With the link, instead of "$content->producer_id", "$content->id" is sent, since it will be more useful in the "/contracts/.../create". -->

                                <!-- if product (product_type == 1) is "Tariff" and tariff (producer_id == 1) belongs to Vodafone -->
                                @if(session()->get('providerID') == 1)
                                    <a href="/contracts/vodafone/create" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air">
                                        <span>
                                            <i class="la la-cart-plus"></i>
                                            <span>{{__('contracts/shoppingCart.enterTariffRequest')}}</span>
                                        </span>
                                    </a>
                                    <!-- if product (product_type == 1) is "Tariff" and tariff (producer_id == 2) belongs to Ay Yıldız -->
                                @elseif(session()->get('providerID') == 2)
                                    <a href="/contracts/ayYildiz/create" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air">
                                        <span>
                                            <i class="la la-cart-plus"></i>
                                            <span>{{__('contracts/shoppingCart.enterTariffRequest')}}</span>
                                        </span>
                                    </a>
                                    <!-- if product (product_type == 1) is "Tariff" and tariff (producer_id == 3) belongs to O2 -->
                                @elseif(session()->get('providerID') == 3)
                                    <a href="/contracts/O2/create" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air">
                                        <span>
                                            <i class="la la-cart-plus"></i>
                                            <span>{{__('contracts/shoppingCart.enterTariffRequest')}}</span>
                                        </span>
                                    </a>
                                @endif
                            </td>
                        </tr>

                        </tbody>
                    </table>
                    <!--END: totals -->

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
