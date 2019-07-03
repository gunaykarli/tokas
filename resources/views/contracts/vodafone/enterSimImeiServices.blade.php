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

                            <li class="m-portlet__nav-item"></li>

                        </ul>
                    </div>
                </div>

                <div class="m-portlet__body" id="">
                    <!--begin: Form -->
                    <form method="POST" action="/contract/vodafone/shopping-cart/SIM-IMEI-services/{{$tariff->id}}/{{$isAdditionalTariff}}" class="m-form m-form--label-align-left- m-form--state-" id="m_form">
                    @csrf
                        <!--begin: Form Wizard Step 4 - Contract Options - -->
                        <div class="row">
                            <div class="col-xl-8 offset-xl-2">

                                    <!--begin: SIM number -->
                                    <div class="form-group m-form__group row">
                                        <label class="col-xl-4 col-lg-4 col-form-label"><b>{{__('contracts\vodafone\enterSimImeiServices.SIMNumber')}}</b></label>
                                        <div class="col-xl-4 col-lg-4">
                                            <input type="text" name="SIMNumber" id="SIMNumber" class="form-control m-input form-control-sm">
                                        </div>
                                    </div>
                                    <!--end: SIM number -->

                                    <!--begin: IMEI options -->
                                    <!-- If "IMEI On-Demand Pool Fields" is active -->
                                    @if(\App\SystemVariable::where('name', 'isIMEIOnDemandFieldActive')->first()->value == 1)
                                    <div class="m-separator m-separator--dashed m-separator--lg"></div>
                                    <div class="form-group m-form__group row">
                                        <label class="col-sm-4 col-sm-4 col-form-label"><b>{{__('contracts\vodafone\enterSimImeiServices.captureIMEI')}}</b></label>
                                        <div class="col-sm-8 col-sm-8">
                                                            <div class="m-radio-list">
                                                                <label class="m-radio m-radio--bold">
                                                                    <input type="radio" name="IMEIOption" value="1"> {{__('contracts\vodafone\enterSimImeiServices.withoutDevice')}}
                                                                    <span></span>
                                                                </label>

                                                                <label class="m-radio m-radio--bold">
                                                                    <input type="radio" name="IMEIOption" value="2"> {{__('contracts\vodafone\enterSimImeiServices.IMEIOnDemand')}}
                                                                    <span></span>
                                                                </label>
                                                                <label class="m-radio m-radio--bold">
                                                                    <input type="radio" name="IMEIOption" value="3">
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control m-input" name="IMEINumber" placeholder="{{__('contracts\vodafone\enterSimImeiServices.enterIMEINumber')}}">
                                                                    </div>
                                                                    <span></span>
                                                                </label>
                                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    <!--end: IMEI options -->

                                    <!--begin: Contract Start Date -->
                                    <div class="m-separator m-separator--dashed m-separator--lg"></div>
                                    <div class="form-group m-form__group row">
                                        <label class="col-sm-4 col-sm-4 col-form-label"><b>{{__('contracts\vodafone\create.contractStartDate')}}</b></label>
                                        <div class="col-sm-4 col-sm-4">
                                            <input name="contractStartDate" class="form-control m-input" type="date" value="" id="example-date-input">
                                        </div>
                                    </div>
                                    <!--begin: Contract Start Date -->

                                    <!--begin: Connection fee -->
                                    <div class="m-separator m-separator--dashed m-separator--lg"></div>
                                    <div class="form-group m-form__group row">
                                        <label class="col-sm-4 col-sm-4 col-form-label"><b>{{__('contracts\vodafone\create.connectionFee')}}</b></label>
                                        <div class="col-sm-8 col-sm-8">
                                            <div class="m-radio-list" id="connectionFees">
                                                <label class="m-radio">
                                                    <input type="radio" name="connectionFee" id="connectionFee" value=1>{{__('contracts\vodafone\create.connectionFee1')}}
                                                    <span></span>
                                                </label>
                                                <label class="m-radio">
                                                    <input type="radio" name="connectionFee" id="connectionFee" value=2>{{__('contracts\vodafone\create.connectionFee2')}}
                                                    <span></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end: Connection fee -->

                                    <!--begin: Connection Overview -->
                                    <div class="m-separator m-separator--dashed m-separator--lg"></div>
                                    <div class="form-group m-form__group row">
                                        <label class="col-sm-4 col-sm-4 col-form-label"><b>{{__('contracts\vodafone\create.connectionOverview')}}</b></label>
                                        <div class="col-sm-8 col-sm-8">
                                            <div class="m-radio-list" id="connectionOverviews">
                                                <label class="m-radio">
                                                    <input type="radio" name="connectionOverview" id="connectionOverview" value=1 checked>{{__('contracts\vodafone\create.connectionOverview1')}}
                                                    <span></span>
                                                </label>
                                                <label class="m-radio">
                                                    <input type="radio" name="connectionOverview" id="connectionOverview" value=2>{{__('contracts\vodafone\create.connectionOverview2')}}
                                                    <span></span>
                                                </label>
                                                <label class="m-radio">
                                                    <input type="radio" name="connectionOverview" id="connectionOverview" value=3>{{__('contracts\vodafone\create.connectionOverview3')}}
                                                    <span></span>
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                    <!--end: Connection Overview -->

                                    <!--begin: Destination number representation -->
                                    <div class="m-separator m-separator--dashed m-separator--lg"></div>
                                    <div class="form-group m-form__group row">
                                        <label class="col-sm-4 col-sm-4 col-form-label"><b>{{__('contracts\vodafone\create.destinationNumberRepresentation')}}</b></label>
                                        <div class="col-sm-8 col-sm-8">
                                            <div class="m-radio-list" id="destinationNumberRepresentations">
                                                <label class="m-radio">
                                                    <input type="radio" name="destinationNumberRepresentation" id="destinationNumberRepresentation" value=1 checked>{{__('contracts\vodafone\create.completed')}}
                                                    <span></span>
                                                </label>
                                                <label class="m-radio">
                                                    <input type="radio" name="destinationNumberRepresentation" id="destinationNumberRepresentation" value=2>{{__('contracts\vodafone\create.shortened')}}
                                                    <span></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end: Destination number representation -->

                                    <div class="m-separator m-separator--dashed m-separator--lg"></div>

                                    <!--begin: Call barring -->
                                    <div class="form-group m-form__group row">
                                        <label class="col-sm-4 col-sm-4 col-form-label"><b>{{__('contracts\vodafone\create.callBarring')}}</b></label>
                                        <div class="col-sm-7 col-sm-7">
                                            <div class="m-radio-list" id="callBarrings">
                                                <label class="m-radio">
                                                    <input type="radio" name="callBarring" id="callBarring" value=1 checked>{{__('contracts\vodafone\create.callBarring1')}}
                                                    <span></span>
                                                </label>
                                                <label class="m-radio">
                                                    <input type="radio" name="callBarring" id="callBarring" value=2>{{__('contracts\vodafone\create.callBarring2')}}
                                                    <span></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end: Call barring -->

                                    <!--begin: Mailbox -->
                                    <div class="m-separator m-separator--dashed m-separator--lg"></div>
                                    <div class="form-group m-form__group row">
                                        <label class="col-sm-4 col-sm-4 col-form-label"><b>{{__('contracts\vodafone\create.mailbox')}}</b></label>
                                        <div class="col-sm-7 col-sm-7">
                                            <div class="m-radio-list" id="mailboxes">
                                                <label class="m-radio">
                                                    <input type="radio" name="mailbox" id="mailbox" value=1 checked>{{__('contracts\vodafone\create.mailbox1')}}
                                                    <span></span>
                                                </label>
                                                <label class="m-radio">
                                                    <input type="radio" name="mailbox" id="mailbox" value=2>{{__('contracts\vodafone\create.mailbox2')}}
                                                    <span></span>
                                                </label>
                                                <label class="m-radio">
                                                    <input type="radio" name="mailbox" id="mailbox" value=3>{{__('contracts\vodafone\create.mailbox3')}}
                                                    <span></span>
                                                </label>
                                                <label class="m-radio">
                                                    <input type="radio" name="mailbox" id="mailbox" value=4>{{__('contracts\vodafone\create.mailbox4')}}
                                                    <span></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end: Mailbox -->

                                    <!--begin: Telephone number transmission -->
                                    <div class="m-separator m-separator--dashed m-separator--lg"></div>
                                    <div class="form-group m-form__group row">
                                        <label class="col-sm-4 col-sm-4 col-form-label"><b>{{__('contracts\vodafone\create.telephoneNumberTransmission')}}</b></label>
                                        <div class="col-sm-7 col-sm-7">
                                            <div class="m-radio-list" id="telephoneNumberTransmissions" class="col-sm-9 col-lg-9">
                                                <label class="m-radio">
                                                    <input type="radio" name="telephoneNumberTransmission" id="telephoneNumberTransmission" value=1 checked>{{__('contracts\vodafone\create.telephoneNumberTransmission1')}}
                                                    <span></span>
                                                </label>
                                                <label class="m-radio">
                                                    <input type="radio" name="telephoneNumberTransmission" id="telephoneNumberTransmission" value=2>{{__('contracts\vodafone\create.telephoneNumberTransmission2')}}
                                                    <span></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end: Telephone number transmission -->
                                    <div class="m-separator m-separator--dashed m-separator--lg"></div>


                            </div>
                        </div>
                        <!--end: Form Wizard Step 4-->

                        <!--begin: Form Wizard Step 5 - Tariff Options --->
                        <div class="row">
                            <div class="col-xl-8 offset-xl-2">
                                    <!--begin::Portlet-->
                                    <div class="m-portlet m-portlet--full-height">
                                        <div class="m-portlet__head">
                                            <div class="m-portlet__head-caption">
                                                <div class="m-portlet__head-title">
                                                    <h3 class="m-portlet__head-text">
                                                        {{__('contracts\vodafone\create.serviceOptions')}}
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-portlet__body">

                                            <!--begin::Section-->
                                            <div class="m-accordion m-accordion--default" id="m_accordion_1" role="tablist">

                                                <!--begin::Item - dataServices-->
                                                <div class="m-accordion__item">
                                                    <div class="m-accordion__item-head collapsed" role="tab" id="m_accordion_1_item_2_head" data-toggle="collapse" href="#m_accordion_1_item_2_body" aria-expanded="    false">
                                                        <span class="m-accordion__item-icon"><i class="fa  flaticon-placeholder"></i></span>
                                                        <span class="m-accordion__item-title">{{__('contracts\vodafone\create.dataServices')}}</span>
                                                        <span class="m-accordion__item-mode"></span>
                                                    </div>
                                                    <div class="m-accordion__item-body collapse" id="m_accordion_1_item_2_body" class=" " role="tabpanel" aria-labelledby="m_accordion_1_item_2_head" data-parent="#m_accordion_1">
                                                        <div class="m-accordion__item-content">

                                                            <div class="m-form__group form-group">
                                                                <div class="m-checkbox-list">
                                                                    @foreach(\App\VodafoneTariff::where('tariff_id', $tariff->id)->first()->services as $service)
                                                                        @if($service->type == 1)
                                                                            <label class="m-checkbox m-checkbox--success">
                                                                                <input type="checkbox" name="dataServices[]" value="{{$service->code}}" @if($service->pivot->property == 1) checked @endif > {{$service->name}}
                                                                                <span></span>
                                                                            </label>
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end::Item - dataServices-->

                                                <!--begin::Item - additional Services-->
                                                <div class="m-accordion__item">
                                                    <div class="m-accordion__item-head collapsed" role="tab" id="m_accordion_1_item_3_head" data-toggle="collapse" href="#m_accordion_1_item_3_body" aria-expanded="    false">
                                                        <span class="m-accordion__item-icon"><i class="fa  flaticon-alert-2"></i></span>
                                                        <span class="m-accordion__item-title">{{__('contracts\vodafone\create.additionalServices')}}</span>
                                                        <span class="m-accordion__item-mode"></span>
                                                    </div>
                                                    <div class="m-accordion__item-body collapse" id="m_accordion_1_item_3_body" class=" " role="tabpanel" aria-labelledby="m_accordion_1_item_3_head" data-parent="#m_accordion_1">
                                                        <div class="m-accordion__item-content">

                                                            <div class="m-form__group form-group">

                                                                <div class="m-checkbox-list">
                                                                    @foreach(\App\VodafoneTariff::where('tariff_id', $tariff->id)->first()->services as $service)
                                                                        @if($service->type == 2)
                                                                            <label class="m-checkbox m-checkbox--success">
                                                                                <input type="checkbox" name="additionalServices[]" value={{$service->code}} @if($service->pivot->property == 1) checked @endif > {{$service->name}}
                                                                                <span></span>
                                                                            </label>
                                                                        @endif
                                                                    @endforeach
                                                                </div>

                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end::Item additional Services-->

                                                <!--begin::Item - Promotion Services-->
                                                <div class="m-accordion__item">
                                                    <div class="m-accordion__item-head collapsed" role="tab" id="m_accordion_1_item_4_head" data-toggle="collapse" href="#m_accordion_1_item_4_body" aria-expanded="    false">
                                                        <span class="m-accordion__item-icon"><i class="fa  flaticon-alert-2"></i></span>
                                                        <span class="m-accordion__item-title">{{__('contracts\vodafone\create.promotionServices')}}</span>
                                                        <span class="m-accordion__item-mode"></span>
                                                    </div>
                                                    <div class="m-accordion__item-body collapse" id="m_accordion_1_item_4_body" class=" " role="tabpanel" aria-labelledby="m_accordion_1_item_4_head" data-parent="#m_accordion_1">
                                                        <div class="m-accordion__item-content">

                                                            <div class="m-form__group form-group">
                                                                <div class="m-checkbox-list">
                                                                    @foreach(\App\VodafoneTariff::where('tariff_id', $tariff->id)->first()->services as $service)
                                                                        @if($service->type == 3)
                                                                            <label class="m-checkbox m-checkbox--success">
                                                                                <input type="checkbox" name="additionalServices[]" value={{$service->code}} @if($service->pivot->property == 1) checked @endif > {{$service->name}}
                                                                                <span></span>
                                                                            </label>
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end::Item Promotion Services-->
                                            </div>
                                            <!--end::Section-->

                                        </div>
                                    </div>
                                    <!--end::Portlet-->
                            </div>
                        </div>
                        <!--end: Form Wizard Step 5-->

                        <div class="row" align="center">
                            <div class="col-xl-8 offset-xl-2">
                                <button type="submit" class="btn btn-primary">{{__('contracts/shoppingCart.save')}}</button>
                            </div>
                        </div>
                    </form>
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
