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
                    <!--BEGIN: Datatable -->
                    <table class="table table-striped- table-bordered table-hover table-checkable" >
                        <thead>
                        <tr>
                            <th> {{__('contracts/shoppingCart.delete')}}</th>
                            <th> {{__('contracts/shoppingCart.provider')}}</th>
                            <th> {{__('contracts/shoppingCart.tariff')}}</th>
                            <th> {{__('contracts/shoppingCart.SIMNumber')}}</th>
                            @if(session('providerID') == 1)
                            @if(\App\SystemVariable::where('name', 'isIMEIOnDemandFieldActive')->first()->value == 1)
                                <th> {{__('contracts/shoppingCart.captureIMEI')}}</th>
                            @endif
                            @endif
                            <th> {{__('contracts/shoppingCart.Customer')}}</th>

                        </tr>
                        </thead>
                        <tbody id="">
                            @foreach($contents as $content)

                                    @if($content->additional_tariff == 0)
                                        <!-- Set up the link according to the provider of the tariff.
                                        With the link, instead of "$content->producer_id", "$content->id" is sent since it will be more useful in the "/contracts/.../create". -->

                                        <!-- if product (product_type == 1) is "Tariff" and tariff (producer_id == 1) belongs to Vodafone -->
                                        @if($content->product_type == 1 and $content->producer_id == 1)
                                            <form method="POST" action="/contracts/vodafone/create/{{$content->id}}"  class="m-form m-form--label-align-left- m-form--state-" id="m_form">
                                            <!-- if product (product_type == 1) is "Tariff" and tariff (producer_id == 2) belongs to Ay Yıldız -->
                                        @elseif($content->product_type == 1 and $content->producer_id == 2)
                                            <form method="POST" action="/contracts/ayYildiz/create/{{$content->id}}"  class="m-form m-form--label-align-left- m-form--state-" id="m_form">
                                            <!-- if product (product_type == 1) is "Tariff" and tariff (producer_id == 3) belongs to O2 -->
                                        @elseif($content->product_type == 1 and $content->producer_id == 3)
                                            <form method="POST" action="/contracts/O2/create/{{$content->id}}"  class="m-form m-form--label-align-left- m-form--state-" id="m_form">
                                        @endif

                                            @csrf

                                        <tr>
                                            <td><a href="/contract/shopping-cart/delete-tariff/{{$content->product_id}}" class="btn btn-danger" ><span>{{__('contracts/shoppingCart.delete')}}</span>&nbsp;&nbsp;</a></td>
                                            <td></td>
                                            @if($content->product_type == 1) <!-- "1" indicates that the selected product is a tariff not a mobile phone. -->
                                                <td>{{(\App\Tariff::find($content->product_id))->name}}</td>
                                            @endif
                                                <td><input type="text" name="SIMNumber[{{$content->id}}]" class="form-control m-input" placeholder="" value=""></td>

                                            <!-- If the current provider is Vodafone -->
                                            @if($content->product_type == 1 and $content->producer_id == 1)
                                            <!-- If "IMEI On-Demand Pool Fields" is active -->
                                            @if(\App\SystemVariable::where('name', 'isIMEIOnDemandFieldActive')->first()->value == 1)
                                                <td>
                                                    <!-- if product (product_type == 1) is "Tariff" and tariff (producer_id == 1) belongs to Vodafone -->
                                                    @if($content->product_type == 1 and $content->producer_id == 1)
                                                        <div class="m-form__group form-group">
                                                            <div class="m-radio-list">
                                                                <label class="m-radio m-radio--bold">
                                                                    <input type="radio" name="IMEIOption[{{$content->id}}]" value="1"> {{__('contracts/shoppingCart.withoutDevice')}}
                                                                    <span></span>
                                                                </label>

                                                                <label class="m-radio m-radio--bold">
                                                                    <input type="radio" name="IMEIOption[{{$content->id}}]" value="2"> {{__('contracts/shoppingCart.IMEIOnDemand')}}
                                                                    <span></span>
                                                                </label>
                                                                <label class="m-radio m-radio--bold">
                                                                    <input type="radio" name="IMEIOption[{{$content->id}}]" value="3">
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control m-input" name="IMEINumber[{{$content->id}}]" placeholder="{{__('contracts/shoppingCart.enterIMEINumber')}}">
                                                                    </div>
                                                                    <span></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </td>
                                            @endif
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
                                        </tr>
                                        <tr>
                                            <td>
                                                <h4 class="m-portlet__head-text">
                                                    {{__('contracts/shoppingCart.additionalCard')}}
                                                </h4>
                                            </td>
                                            <td colspan="6" align="left">
                                                <a href="/tariff/index/{{session('providerID')}}/{{1}}" class="btn btn-warning m-btn m-btn--custom m-btn--icon m-btn--air">
                                                    <span>
                                                        <i class="la la-cart-plus"></i>
                                                        <span> {{__('contracts/shoppingCart.additionalTariffOrder')}}</span>
                                                    </span>
                                                </a>
                                            </td>
                                        </tr>
                                      

                                        </form>
                                    @elseif($content->additional_tariff == 1)
                                                <!-- Set up the link according to the provider of the tariff.
                                                With the link, instead of "$content->producer_id", "$content->id" is sent, since it will be more useful in the "/contracts/.../create". -->

                                                    <!-- if product (product_type == 1) is "Tariff" and tariff (producer_id == 1) belongs to Vodafone -->
                                                    @if($content->product_type == 1 and $content->producer_id == 1)
                                                        <form method="POST" action="/contracts/vodafone/create/{{$content->id}}"  class="m-form m-form--label-align-left- m-form--state-" id="m_form">
                                                            <!-- if product (product_type == 1) is "Tariff" and tariff (producer_id == 2) belongs to Ay Yıldız -->
                                                            @elseif($content->product_type == 1 and $content->producer_id == 2)
                                                                <form method="POST" action="/contracts/ayYildiz/create/{{$content->id}}"  class="m-form m-form--label-align-left- m-form--state-" id="m_form">
                                                                    <!-- if product (product_type == 1) is "Tariff" and tariff (producer_id == 3) belongs to O2 -->
                                                                    @elseif($content->product_type == 1 and $content->producer_id == 3)
                                                                        <form method="POST" action="/contracts/O2/create/{{$content->id}}"  class="m-form m-form--label-align-left- m-form--state-" id="m_form">
                                                                            @endif

                                                                            @csrf

                                                                            <tr>
                                                                                <td><a href="/contract/shopping-cart/delete-tariff/{{$content->product_id}}" class="btn btn-danger" ><span>{{__('contracts/shoppingCart.delete')}}</span>&nbsp;&nbsp;</a></td>
                                                                                <td></td>
                                                                            @if($content->product_type == 1) <!-- "1" indicates that the selected product is a tariff, not a mobile phone. -->
                                                                                <td>{{(\App\Tariff::find($content->product_id))->name}}</td>
                                                                                @endif
                                                                                <td><input type="text" name="SIMNumber[{{$content->id}}]" class="form-control m-input" placeholder="" value=""></td>

                                                                                <!-- If the current provider is Vodafone -->
                                                                                @if($content->product_type == 1 and $content->producer_id == 1)
                                                                                <!-- If "IMEI On-Demand Pool Fields" is active -->
                                                                                    @if(\App\SystemVariable::where('name', 'isIMEIOnDemandFieldActive')->first()->value == 1)
                                                                                        <td>
                                                                                            <!-- if product (product_type == 1) is "Tariff" and tariff (producer_id == 1) belongs to Vodafone -->
                                                                                            @if($content->product_type == 1 and $content->producer_id == 1)
                                                                                                <div class="m-form__group form-group">
                                                                                                    <div class="m-radio-list">
                                                                                                        <label class="m-radio m-radio--bold">
                                                                                                            <input type="radio" name="IMEIOption[{{$content->id}}]" value="1"> {{__('contracts/shoppingCart.withoutDevice')}}
                                                                                                            <span></span>
                                                                                                        </label>

                                                                                                        <label class="m-radio m-radio--bold">
                                                                                                            <input type="radio" name="IMEIOption[{{$content->id}}]" value="2"> {{__('contracts/shoppingCart.IMEIOnDemand')}}
                                                                                                            <span></span>
                                                                                                        </label>
                                                                                                        <label class="m-radio m-radio--bold">
                                                                                                            <input type="radio" name="IMEIOption[{{$content->id}}]" value="3">
                                                                                                            <div class="input-group">
                                                                                                                <input type="text" class="form-control m-input" name="IMEINumber[{{$content->id}}]" placeholder="{{__('contracts/shoppingCart.enterIMEINumber')}}">
                                                                                                            </div>
                                                                                                            <span></span>
                                                                                                        </label>
                                                                                                    </div>
                                                                                                </div>
                                                                                            @endif
                                                                                        </td>
                                                                                    @endif
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
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="6" align="center">
                                                                                    <button type="submit" class="btn btn-primary">{{__('contracts/shoppingCart.enterTariffRequest')}}</button>
                                                                                </td>
                                                                            </tr>
                                                                        </form>
                                    @endif
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
