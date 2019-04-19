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
                            <li class="m-portlet__nav-item">
                                <a href="/tariff/index" class="btn btn-warning m-btn m-btn--custom m-btn--icon m-btn--air">
												<span>
													<i class="la la-cart-plus"></i>
													<span> {{__('contracts/shoppingCart.addNewOrder')}}</span>
												</span>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item"></li>

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
                            <th> {{__('contracts/shoppingCart.captureIMEI')}}</th>

                            <th> {{__('contracts/shoppingCart.Customer')}}</th>

                        </tr>
                        </thead>
                        <tbody id="">
                            @foreach($contents as $content)
                                <tr>
                                    <td><a href="/contract/shopping-cart/delete-tariff/{{$content->product_id}}" class="btn btn-danger" ><span>{{__('contracts/shoppingCart.delete')}}</span>&nbsp;&nbsp;</a></td>
                                    <td></td>
                                    @if($content->product_type == 1) <!-- "1" indicates that the selected product is a tariff not a mobile phone. -->
                                        <td>{{(\App\Tariff::find($content->product_id))->name}}</td>
                                    @endif
                                        <td><input type="text" name="SIMNumber" class="form-control m-input" placeholder="" value=""></td>
                                    <td>
                                        <!-- If IMEI Pool is active -->
                                        @if(\App\SystemVariable::where('name', 'isIMEIPoolActive')->first()->value == 1)
                                            <!-- if product (product_type == 1) is "Tariff" and tariff (producer_id == 1) belongs to Vodafone -->
                                            @if($content->product_type == 1 and $content->producer_id == 1)
                                                <div class="m-form__group form-group">
                                                    <div class="m-radio-list">
                                                        <label class="m-radio m-radio--bold">
                                                            <input type="radio" name="EMEIOption" value="1"> {{__('contracts/shoppingCart.withoutDevice')}}
                                                            <span></span>
                                                        </label>

                                                        <label class="m-radio m-radio--bold">
                                                            <input type="radio" name="EMEIOption" value="2"> {{__('contracts/shoppingCart.IMEIOnDemand')}}
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio m-radio--bold">
                                                            <input type="radio" name="EMEIOption" value="3">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control m-input" name="EMEINumber" placeholder="{{__('contracts/shoppingCart.enterIMEINumber')}}">
                                                            </div>
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif

                                    </td>

                                    <td>
                                        <!-- Set up the link according to the provider of the tariff.
                                        With the link, instead of "$content->producer_id", "$content->id" is sent since it will be more useful in the "/contracts/.../create". -->

                                        <!-- if product (product_type == 1) is "Tariff" and tariff (producer_id == 1) belongs to Vodafone -->
                                        @if($content->product_type == 1 and $content->producer_id == 1)
                                                    <a href="/contracts/vodafone/create/{{$content->id}}" class="btn btn-primary" >
                                        <!-- if product (product_type == 1) is "Tariff" and tariff (producer_id == 2) belongs to Ay Yıldız -->
                                        @elseif($content->product_type == 1 and $content->producer_id == 2)
                                                    <a href="/contracts/ayYildiz/create/{{$content->id}}" class="btn btn-primary" >
                                        <!-- if product (product_type == 1) is "Tariff" and tariff (producer_id == 3) belongs to O2 -->
                                        @elseif($content->product_type == 1 and $content->producer_id == 3)
                                                    <a href="/contracts/O2/create/{{$content->id}}" class="btn btn-primary" >
                                        @endif
                                                    <span>{{__('contracts/shoppingCart.enterTariffRequest')}}</span>&nbsp;&nbsp;
                                                    </a>
                                    </td>
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
