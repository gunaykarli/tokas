@extends ('partials.master')

@section ('content')

    <!-- BEGIN: Main Content "stays right before 'Subheader' section and rigth after 'END: Left Aside' section of the original html files'"-->
    <div class="m-grid__item m-grid__item--fluid m-wrapper">

        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title m-subheader__title--separator">Tariff Management</h3>
                    <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                        <li class="m-nav__item m-nav__item--home">
                            <a href="/home" class="m-nav__link m-nav__link--icon">
                                <i class="m-nav__link-icon la la-home"></i>
                            </a>
                        </li>
                        <li class="m-nav__separator">-</li>
                        <li class="m-nav__item">
                            <a href="" class="m-nav__link">
                                <span class="m-nav__link-text"> Wizard</span>
                            </a>
                        </li>
                        <li class="m-nav__separator">-</li>
                        <li class="m-nav__item">
                            <a href="" class="m-nav__link">
                                <span class="m-nav__link-text">Form Wizard 2</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div>
                    <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover" aria-expanded="true">
                        <a href="#" class="m-portlet__nav-link btn btn-lg btn-secondary  m-btn m-btn--outline-2x m-btn--air m-btn--icon m-btn--icon-only m-btn--pill  m-dropdown__toggle">
                            <i class="la la-plus m--hide"></i>
                            <i class="la la-ellipsis-h"></i>
                        </a>
                        <div class="m-dropdown__wrapper">
                            <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                            <div class="m-dropdown__inner">
                                <div class="m-dropdown__body">
                                    <div class="m-dropdown__content">
                                        <ul class="m-nav">
                                            <li class="m-nav__section m-nav__section--first m--hide">
                                                <span class="m-nav__section-text">Quick Actions</span>
                                            </li>
                                            <li class="m-nav__item">
                                                <a href="" class="m-nav__link">
                                                    <i class="m-nav__link-icon flaticon-share"></i>
                                                    <span class="m-nav__link-text">Activity</span>
                                                </a>
                                            </li>
                                            <li class="m-nav__item">
                                                <a href="" class="m-nav__link">
                                                    <i class="m-nav__link-icon flaticon-chat-1"></i>
                                                    <span class="m-nav__link-text">Messages</span>
                                                </a>
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
                                            <li class="m-nav__separator m-nav__separator--fit">
                                            </li>
                                            <li class="m-nav__item">
                                                <a href="#" class="btn btn-outline-danger m-btn m-btn--pill m-btn--wide btn-sm">Submit</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Subheader -->

        <!-- BEGIN: Content -->
        <div class="m-content">

            <!--Begin::Main Portlet-->
            <div class="m-portlet m-portlet--full-height">

                <!--begin: Portlet Head-->
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">ta
                            <h3 class="m-portlet__head-text">
                                {{__('tariffs\vodafone\edit.editTariff')}}
                                <small> {{__('tariffs\vodafone\edit.editTariff')}}</small>
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">
                                <a href="#" data-toggle="m-tooltip" class="m-portlet__nav-link m-portlet__nav-link--icon" data-direction="left" data-width="auto" title="Get help with filling up this form">
                                    <i class="flaticon-info m--icon-font-size-lg3"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!--end: Portlet Head-->

                <!--begin: Form Wizard-->
                <div class="m-wizard m-wizard--2 m-wizard--success" id="m_wizard">

                    <!--begin: Message container -->
                    <div class="m-portlet__padding-x">

                        <!-- Here you can put a message or alert -->
                    </div>

                    <!--end: Message container -->

                    <!--begin: Form Wizard Head -->
                    <div class="m-wizard__head m-portlet__padding-x">

                        <!--begin: Form Wizard Progress -->
                        <div class="m-wizard__progress">
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <!--end: Form Wizard Progress -->

                        <!--begin: Form Wizard Nav -->
                        <div class="m-wizard__nav">
                            <div class="m-wizard__steps">
                                <div class="m-wizard__step m-wizard__step--current" m-wizard-target="m_wizard_form_step_1">
                                    <a href="#" class="m-wizard__step-number">
                                        <span><i class="fa  flaticon-placeholder"></i></span>
                                    </a>
                                    <div class="m-wizard__step-info">
                                        <div class="m-wizard__step-title">
                                            {{__('tariffs\vodafone\edit.tariff')}}
                                        </div>
                                        <div class="m-wizard__step-desc">

                                        </div>
                                    </div>
                                </div>

                                <div class="m-wizard__step" m-wizard-target="m_wizard_form_step_2">
                                    <a href="#" class="m-wizard__step-number">
                                        <span><i class="fa  flaticon-layers"></i></span>
                                    </a>
                                    <div class="m-wizard__step-info">
                                        <div class="m-wizard__step-title">
                                            {{__('tariffs\vodafone\create.regions')}}
                                        </div>
                                        <div class="m-wizard__step-desc">

                                        </div>
                                    </div>
                                </div>

                                <div class="m-wizard__step" m-wizard-target="m_wizard_form_step_3">
                                    <a href="#" class="m-wizard__step-number">
                                        <span><i class="fa  flaticon-layers"></i></span>
                                    </a>
                                    <div class="m-wizard__step-info">
                                        <div class="m-wizard__step-title">
                                            {{__('tariffs\vodafone\create.provision')}}
                                        </div>
                                        <div class="m-wizard__step-desc">

                                        </div>
                                    </div>
                                </div>

                                <div class="m-wizard__step" m-wizard-target="m_wizard_form_step_4">
                                    <a href="#" class="m-wizard__step-number">
                                        <span><i class="fa  flaticon-layers"></i></span>
                                    </a>
                                    <div class="m-wizard__step-info">
                                        <div class="m-wizard__step-title">
                                            {{__('tariffs\vodafone\create.ontop')}}
                                        </div>
                                        <div class="m-wizard__step-desc">

                                        </div>
                                    </div>
                                </div>

                                <div class="m-wizard__step" m-wizard-target="m_wizard_form_step_5">
                                    <a href="#" class="m-wizard__step-number">
                                        <span><i class="fa  flaticon-layers"></i></span>
                                    </a>
                                    <div class="m-wizard__step-info">
                                        <div class="m-wizard__step-title">
                                            {{__('tariffs\vodafone\create.tariffLimit')}}
                                        </div>
                                        <div class="m-wizard__step-desc">

                                        </div>
                                    </div>
                                </div>

                                <div class="m-wizard__step" m-wizard-target="m_wizard_form_step_6">
                                    <a href="#" class="m-wizard__step-number">
                                        <span><i class="fa  flaticon-layers"></i></span>
                                    </a>
                                    <div class="m-wizard__step-info">
                                        <div class="m-wizard__step-title">
                                            {{__('tariffs\vodafone\create.properties')}}
                                        </div>
                                        <div class="m-wizard__step-desc">

                                        </div>
                                    </div>
                                </div>

                                <div class="m-wizard__step" m-wizard-target="m_wizard_form_step_7">
                                    <a href="#" class="m-wizard__step-number">
                                        <span><i class="fa  flaticon-layers"></i></span>
                                    </a>
                                    <div class="m-wizard__step-info">
                                        <div class="m-wizard__step-title">
                                            {{__('tariffs\vodafone\create.highlight')}}
                                        </div>
                                        <div class="m-wizard__step-desc">

                                        </div>
                                    </div>
                                </div>

                                <div class="m-wizard__step" m-wizard-target="m_wizard_form_step_8">
                                    <a href="#" class="m-wizard__step-number">
                                        <span><i class="fa  flaticon-layers"></i></span>
                                    </a>
                                    <div class="m-wizard__step-info">
                                        <div class="m-wizard__step-title">
                                            {{__('tariffs\vodafone\create.plausibility')}}
                                        </div>
                                        <div class="m-wizard__step-desc">

                                        </div>
                                    </div>
                                </div>

                                <div class="m-wizard__step" m-wizard-target="m_wizard_form_step_9">
                                    <a href="#" class="m-wizard__step-number">
                                        <span><i class="fa  flaticon-layers"></i></span>
                                    </a>
                                    <div class="m-wizard__step-info">
                                        <div class="m-wizard__step-title">
                                            {{__('tariffs\vodafone\create.service')}}
                                        </div>
                                        <div class="m-wizard__step-desc">

                                        </div>
                                    </div>
                                </div>

                                <div class="m-wizard__step" m-wizard-target="m_wizard_form_step_10">
                                    <a href="#" class="m-wizard__step-number">
                                        <span><i class="fa  flaticon-layers"></i></span>
                                    </a>
                                    <div class="m-wizard__step-info">
                                        <div class="m-wizard__step-title">
                                            {{__('tariffs\vodafone\create.lawTexts')}}
                                        </div>
                                        <div class="m-wizard__step-desc">

                                        </div>
                                    </div>
                                </div>

                                <div class="m-wizard__step" m-wizard-target="m_wizard_form_step_11">
                                    <a href="#" class="m-wizard__step-number">
                                        <span><i class="fa  flaticon-layers"></i></span>
                                    </a>
                                    <div class="m-wizard__step-info">
                                        <div class="m-wizard__step-title">
                                            {{__('tariffs\vodafone\create.confirmation')}}
                                        </div>
                                        <div class="m-wizard__step-desc">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end: Form Wizard Nav -->

                    </div>
                    <!--end: Form Wizard Head -->

                    <!--begin: Form Wizard Form-->
                    <div class="m-wizard__form">

                        <!--
                            1) Use m-form--label-align-left class to alight the form input labels to the right
                            2) Use m-form--state class to highlight input control borders on form validation
                        -->

                        <!--begin: Form -->
                        <form method="POST" action="/tariff/vodafone/update/{{$tariff->id}}"  class="m-form m-form--label-align-left- m-form--state-" id="m_form">
                        @csrf
                        <!--begin: Form Body -->
                            <div class="m-portlet__body">

                                <!--begin: Form Wizard Step 1 Tariff Basics-->
                                <div class="m-wizard__form-step m-wizard__form-step--current" id="m_wizard_form_step_1">
                                    <div class="row" id="tariffBasicsDIV">
                                        <div class="col-xl-8 offset-xl-2">
                                            <div class="m-form__section m-form__section--first">
                                                <div class="m-form__heading">
                                                    <h3 class="m-form__heading-title">{{__('tariffs\vodafone\create.tariffDetails')}}</h3>
                                                </div>

                                                <input  name="providerID" type="hidden" value={{$provider->id}}>

                                                <div class="m-separator m-separator--dashed m-separator--lg"></div>

                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">{{__('tariffs\vodafone\create.tariffName')}}:</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <input type="text" name="tariffName" id="tariffName" class="form-control m-input" placeholder="" value="{{$tariff->name}}">
                                                    </div>
                                                </div>

                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">{{__('tariffs\vodafone\create.tariffCode')}}:</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <input type="text" name="tariffCode" class="form-control m-input" placeholder="" value="{{$tariff->tariff_code}}">
                                                    </div>
                                                </div>

                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">{{__('tariffs\vodafone\create.tariffStatus')}}:</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <span class="m-switch m-switch--sm m-switch--icon">
                                                            <label>
                                                                <input type="checkbox" name="tariffStatus" id="tariffStatus"  @if($tariff->status == 1) checked="checked" @endif>
                                                                <span></span>
                                                            </label>
                                                        </span>
                                                    </div>
                                                </div>

                                                <div  class="tariffValidationDateDIV">
                                                    <div class="form-group m-form__group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('tariffs\vodafone\create.validFrom')}}:</label>
                                                        <div class="col-xl-9 col-lg-9">
                                                            <input name="tariffValidFrom" class="form-control m-input" type="date" value="{{$tariff->valid_from}}" id="example-datetime-local-input">
                                                        </div>
                                                    </div>

                                                    <div class="form-group m-form__group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('tariffs\vodafone\create.validTo')}}:</label>
                                                        <div class="col-xl-6 col-lg-6">
                                                            <input name="tariffValidTo" class="form-control m-input" type="date" value="{{$tariff->valid_to}}" id="tariffValidTo">
                                                        </div>
                                                        <label class="col-xl-2 col-lg-2 col-form-label">{{__('tariffs\vodafone\create.inDefinite')}}</label>
                                                        <div class="col-xl-1 col-lg-1">
                                                        <span class="m-switch m-switch--sm m-switch--icon">
                                                            <label>
                                                                <input type="checkbox"  name="tariffValidToIndefinite" id="tariffValidToIndefinite" @if($tariff->valid_to == null) checked="checked" @endif>
                                                                <span></span>
                                                            </label>
                                                        </span>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="form-group m-form__group row">
                                                    <label for="exampleSelect1" class="col-xl-3 col-lg-3 col-form-label">{{__('tariffs\vodafone\create.network')}}:</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <select name="networkID" class="form-control m-input" id="networkID">
                                                            @foreach($networks as $network)
                                                                @if($network->id == $tariff->network_id)
                                                                    <option value={{$network->id}} selected="selected">{{$network->name}}</option>
                                                                @else
                                                                    <option value={{$network->id}}>{{$network->name}}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group m-form__group row">
                                                    <label for="exampleSelect1" class="col-xl-3 col-lg-3 col-form-label">{{__('tariffs\vodafone\create.group')}}:</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <select name="groupID" class="form-control m-input" id="exampleSelect1">
                                                            @foreach($provider->tariffsGroups as $tariffsGroup)
                                                                @if($tariffsGroup->name != "Aktionstarife") <!-- Aktionstarife group is not listed -->
                                                                    @if($tariffsGroup->id == $tariff->group_id)
                                                                        <option value={{$tariffsGroup->id}} selected="selected">{{$tariffsGroup->name}}</option>
                                                                    @else
                                                                        <option value={{$tariffsGroup->id}}>{{$tariffsGroup->name}}</option>
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">{{__('tariffs\vodafone\create.actionTariff')}}:</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <span class="m-switch m-switch--sm m-switch--icon">
                                                            <label>
                                                                @if($tariff->action_tariff == 1)
                                                                    <input type="checkbox" name="actionTariff" checked="checked">
                                                                @else
                                                                    <input type="checkbox" name="actionTariff">
                                                                @endif
                                                                <span></span>
                                                            </label>
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">{{__('tariffs\vodafone\create.madeByToker')}}:</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <span class="m-switch m-switch--sm m-switch--icon">
                                                            <label>
                                                                @if($tariff->made_by_toker == 1)
                                                                    <input type="checkbox" name="madeByToker" checked="checked">
                                                                @else
                                                                    <input type="checkbox" name="madeByToker">
                                                                @endif
                                                                <span></span>
                                                            </label>
                                                        </span>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end: Form Wizard Step 1 Tariff Basics-->

                                <!--begin: Form Wizard Step 2 Regions -->
                                <div class="m-wizard__form-step" id="m_wizard_form_step_2">

                                    <div class="row" id="regionsDIV">
                                        <div class="col-xl-8 offset-xl-2">
                                            <div class="m-form__section m-form__section--first">

                                                <div class="m-form__section m-form__section--first">
                                                    <div class="m-form__heading">
                                                        <h3 class="m-form__heading-title">{{__('tariffs\vodafone\create.regions')}}</h3>
                                                    </div>

                                                    <div class="form-group m-form__group row">
                                                        <label class="col-xl-2 col-lg-2 col-form-label">{{__('tariffs\vodafone\create.allRegions')}}?</label>
                                                        <div class="col-xl-1 col-lg-1">
                                                            <span class="m-switch m-switch--sm m-switch--icon">
                                                                <label>
                                                                    <input type="checkbox"  name="allRegions" id="allRegions">
                                                                    <span></span>
                                                                </label>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="m-separator m-separator--dashed m-separator--lg"></div>

                                                    <div class="all-regions">
                                                        <div class="m-form__group form-group">
                                                            <div class="m-checkbox-list">
                                                                @foreach($provider->regions as $region)
                                                                    <label class="m-checkbox m-checkbox--solid m-checkbox--success">
                                                                        <input type="checkbox" name="checkboxOfRegions[{{$region->id}}]"
                                                                            @foreach($tariff->regions as $regionOfTariff)
                                                                                @if($region->id == $regionOfTariff->pivot->region_id)
                                                                                     checked="checked"
                                                                                @endif
                                                                            @endforeach
                                                                        > {{$region->abbreviation}}
                                                                        <span></span>
                                                                    </label>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end: Form Wizard Step 2 Regions-->

                                <!--begin: Form Wizard Step 3 - WILL BE DELETED since WE HAVE SEPECIAL PART FOR THIS-->
                                <div class="m-wizard__form-step" id="m_wizard_form_step_3">
                                    <div class="row">
                                        <div class="col-xl-8 offset-xl-2">
                                            <div class="m-form__section m-form__section--first">
                                                <div class="m-form__heading">
                                                    <h3 class="m-form__heading-title">{{__('tariffs\vodafone\create.provision')}}</h3>
                                                </div>

                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">{{__('tariffs\vodafone\create.basePrice')}}:</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">€</span>
                                                                <span class="input-group-text">0.00</span>
                                                            </div>
                                                            <input type="text" class="form-control m-input" name="basePrice">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">{{__('tariffs\vodafone\create.provision')}}:</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">€</span>
                                                                <span class="input-group-text">0.00</span>
                                                            </div>
                                                            <input type="text" class="form-control m-input" name="provision">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">{{__('tariffs\vodafone\create.validFrom')}}:</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <input name="provisionValidFrom" class="form-control m-input" type="datetime-local" value="2011-08-19T13:45:00" id="example-datetime-local-input">
                                                    </div>
                                                </div>

                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">{{__('tariffs\vodafone\create.validTo')}}:</label>
                                                    <div class="col-xl-6 col-lg-6">
                                                        <input name="provisionValidTo" class="form-control m-input" type="datetime-local" value="2011-08-19T13:45:00" id="provisionValidTo">
                                                    </div>
                                                    <label class="col-xl-2 col-lg-2 col-form-label">{{__('tariffs\vodafone\create.inDefinite')}}</label>
                                                    <div class="col-xl-1 col-lg-1">
                                                        <span class="m-switch m-switch--sm m-switch--icon">
                                                            <label>
                                                                <input type="checkbox"  name="provisionValidToIndefinite" id="provisionValidToIndefinite">
                                                                <span></span>
                                                            </label>
                                                        </span>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end: Form Wizard Step 3-->

                                <!--begin: Form Wizard Step 4 on-top WILL BE DELETED since WE HAVE SEPECIAL PART FOR THIS-->
                                <div class="m-wizard__form-step" id="m_wizard_form_step_4">
                                    <div class="row">
                                        <div class="col-xl-8 offset-xl-2">
                                            <div class="m-form__section m-form__section--first">
                                                <div class="m-form__section m-form__section--first">
                                                    <div class="m-form__heading">
                                                        <h3 class="m-form__heading-title">{{__('tariffs\vodafone\create.ontop')}}</h3>
                                                    </div>

                                                    <div class="form-group m-form__group row">
                                                        <label class="col-xl-2 col-lg-2 col-form-label">{{__('tariffs\vodafone\create.ontop')}}?</label>
                                                        <div class="col-xl-1 col-lg-1">
                                                            <span class="m-switch m-switch--sm m-switch--icon">
                                                                <label>
                                                                    <input type="checkbox"  name="ontop" id="ontop">
                                                                    <span></span>
                                                                </label>
                                                            </span>
                                                        </div>
                                                        <div class="m-separator m-separator--dashed m-separator--lg"></div>
                                                    </div>

                                                    <div class="on-top-dealer-dependency">
                                                        <label>{{__('tariffs\vodafone\create.dealerDependency')}}</label>
                                                        <div class="m-radio-list">
                                                            <label class="m-radio m-radio--success">
                                                                <input type="radio" name="ontopDealerDependency"  value="1"> {{__('tariffs\vodafone\create.forAllDealer')}}
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                        <div class="m-radio-list">
                                                            <label class="m-radio m-radio--success">
                                                                <input type="radio" name="ontopDealerDependency" value="2"> {{__('tariffs\vodafone\create.forCertainDealer')}}
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                        <div class="m-radio-list">
                                                            <label class="m-radio m-radio--success">
                                                                <input type="radio" name="ontopDealerDependency" value="3"> {{__('tariffs\vodafone\create.forCertainCategory')}}
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                        <div class="m-radio-list">
                                                            <label class="m-radio m-radio--success">
                                                                <input type="radio" name="ontopDealerDependency" value="4"> {{__('tariffs\vodafone\create.forCertainRegions')}}
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                        <div class="m-separator m-separator--dashed m-separator--lg"></div>
                                                    </div>

                                                    <div class="on-top-dealers">
                                                        <label>{{__('tariffs\vodafone\create.dealers')}}</label>
                                                        <div class="m-form__group form-group">
                                                            <div class="m-checkbox-list">
                                                                @foreach($dealers as $dealer)
                                                                    <label class="m-checkbox m-checkbox--solid m-checkbox--success">
                                                                        <input type="checkbox" name="ontopCheckboxOfDealers[{{$dealer->id}}]"> {{$dealer->name}}
                                                                        <span></span>
                                                                    </label>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                        <div class="m-separator m-separator--dashed m-separator--lg"></div>
                                                    </div>

                                                    <div class="on-top-categories">
                                                        <label>{{__('tariffs\vodafone\create.categories')}}</label>
                                                        <div class="m-form__group form-group">
                                                            <div class="m-checkbox-list">
                                                                <label class="m-checkbox m-checkbox--solid m-checkbox--success">
                                                                    <input type="checkbox" name="ontopCheckboxOfCategories[1]"> {{__('tariffs\vodafone\create.category')}}-1
                                                                    <span></span>
                                                                </label>
                                                                <label class="m-checkbox m-checkbox--solid m-checkbox--success">
                                                                    <input type="checkbox" name="ontopCheckboxOfCategories[2]"> {{__('tariffs\vodafone\create.category')}}-2
                                                                    <span></span>
                                                                </label>
                                                                <label class="m-checkbox m-checkbox--solid m-checkbox--success">
                                                                    <input type="checkbox" name="ontopCheckboxOfCategories[3]"> {{__('tariffs\vodafone\create.category')}}-3
                                                                    <span></span>
                                                                </label>
                                                                <label class="m-checkbox m-checkbox--solid m-checkbox--success">
                                                                    <input type="checkbox" name="ontopCheckboxOfCategories[4]"> {{__('tariffs\vodafone\create.category')}}-4
                                                                    <span></span>
                                                                </label>
                                                                <label class="m-checkbox m-checkbox--solid m-checkbox--success">
                                                                    <input type="checkbox" name="ontopCheckboxOfCategories[5]"> {{__('tariffs\vodafone\create.category')}}-5
                                                                    <span></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="m-separator m-separator--dashed m-separator--lg"></div>
                                                    </div>

                                                    <div class="on-top-regions">
                                                        <label>{{__('tariffs\vodafone\create.regions')}}</label>
                                                        <div class="m-form__group form-group">
                                                            <div class="m-checkbox-list">
                                                                @foreach($provider->regions as $region)
                                                                    <label class="m-checkbox m-checkbox--solid m-checkbox--success">
                                                                        <input type="checkbox" name="ontopCheckboxOfRegions[{{$region->id}}]"> {{$region->abbreviation}}
                                                                        <span></span>
                                                                    </label>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                        <div class="m-separator m-separator--dashed m-separator--lg"></div>
                                                    </div>

                                                    <div class="on-top-amount">
                                                        <div class="form-group m-form__group row">
                                                            <label class="col-xl-2 col-lg-2 col-form-label">{{__('tariffs\vodafone\create.ontop')}}:</label>
                                                            <div class="col-xl-3 col-lg-3">
                                                                <input type="text" name="ontopAmount" id="ontopAmount" class="form-control m-input" placeholder="" value="">
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end: Form Wizard Step 4-->

                                <!--begin: Form Wizard Step 5 Limit -->
                                <div class="m-wizard__form-step" id="m_wizard_form_step_5">

                                    <div class="row" id="limitDIV">
                                        <div class="col-xl-8 offset-xl-2">
                                            <div class="m-form__section m-form__section--first">
                                                <div class="m-form__heading">
                                                    <h3 class="m-form__heading-title">{{__('tariffs\vodafone\create.tariffLimit')}}</h3>
                                                </div>

                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">{{__('tariffs\vodafone\create.isLimited')}}:</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <span class="m-switch m-switch--sm m-switch--icon">
                                                            <label>
                                                                <input type="checkbox"  name="isLimited" id="isLimited" @if($tariff->is_limited == 1) checked="checked" value="on" @else value="off" @endif>
                                                                <span></span>
                                                            </label>
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="is-limited">
                                                    <div class="form-group m-form__group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('tariffs\vodafone\create.limit')}}:</label>
                                                        <div class="col-xl-9 col-lg-9">
                                                            <input type="text" name="limit" class="form-control m-input" placeholder="" @if($tariff->is_limited == 1) value="{{$tariff->tariffsLimit->limit}}" @endif >
                                                        </div>
                                                    </div>

                                                    <div class="form-group m-form__group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('tariffs\vodafone\create.validFrom')}}:</label>
                                                        <div class="col-xl-9 col-lg-9">
                                                            <input name="limitValidFrom" class="form-control m-input" type="date" @if($tariff->is_limited == 1) value="{{$tariff->tariffsLimit->valid_from}}" @endif  id="limitValidFrom">
                                                        </div>
                                                    </div>

                                                    <div class="form-group m-form__group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('tariffs\vodafone\create.validTo')}}:</label>
                                                        <div class="col-xl-9 col-lg-9">
                                                            <input name="limitValidTo" class="form-control m-input" type="date"  @if($tariff->is_limited == 1) value="{{$tariff->tariffsLimit->valid_to}}" @endif id="limitValidTo">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end: Form Wizard Step 5-->

                                <!--begin: Form Wizard Step 6 Properties -->
                                <div class="m-wizard__form-step" id="m_wizard_form_step_6">

                                    <div class="row" id="propertiesDIV">
                                        <div class="col-xl-8 offset-xl-2">
                                            <div class="m-form__section m-form__section--first">

                                                <div class="m-form__heading">
                                                    <h3 class="m-form__heading-title">{{__('tariffs\vodafone\create.properties')}}</h3>
                                                </div>

                                                <div class="form-group m-form__group">
                                                    @foreach($properties->unique('category') as $category)
                                                        <label>{{$category->category}}</label>
                                                        @foreach($properties as $property)
                                                            @if($category->category == $property->category)
                                                                <div class="form-group m-form__group row">
                                                                    <label class="col-xl-3 col-lg-3 col-form-label">{{$property->name}}</label>
                                                                    <div class="col-xl-3 col-lg-3">
                                                                        @if($property->data_type == 'boolean')
                                                                            <span class="m-switch m-switch--sm m-switch--icon">
                                                                            <label>
                                                                                <input type="checkbox"  name="booleanInputOfProperties[{{$property->id}}]"
                                                                                        @foreach($tariff->properties as $propertyOfTariff)
                                                                                            @if($propertyOfTariff->id == $property->id)
                                                                                                @if($propertyOfTariff->pivot->value == 1)
                                                                                                    checked="checked"
                                                                                                    value="on"
                                                                                                @else
                                                                                                    value="off"
                                                                                                @endif
                                                                                            @endif
                                                                                        @endforeach
                                                                                >
                                                                                <span></span>
                                                                            </label>
                                                                        </span>
                                                                        @else
                                                                            @if($property->name == 'Provider')<!-- Provider name is written automatically -->
                                                                                <input type="text" name="textInputOfProperties[{{$property->id}}]" id="{{$property->name}}" class="form-control m-input" value="{{$provider->name}}"  aria-describedby="basic-addon1">
                                                                            @else
                                                                                <input type="text" name="textInputOfProperties[{{$property->id}}]" id="{{$property->name}}" class="form-control m-input"
                                                                                       @foreach($tariff->properties as $propertyOfTariff)
                                                                                            @if($propertyOfTariff->id == $property->id)
                                                                                                value="{{$propertyOfTariff->pivot->value}}"
                                                                                            @endif
                                                                                       @endforeach
                                                                                       aria-describedby="basic-addon1">
                                                                            @endif
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                        <div class="m-separator m-separator--dashed m-separator--lg"></div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end: Form Wizard Step 6-->

                                <!--begin: Form Wizard Step 7 Highligths-->
                                <div class="m-wizard__form-step" id="m_wizard_form_step_7">
                                    <div class="row">
                                        <div class="col-xl-8 offset-xl-2">
                                            <div class="m-form__section m-form__section--first">

                                                <div class="m-form__heading">
                                                    <h3 class="m-form__heading-title">{{__('tariffs\vodafone\create.highlight')}}</h3>
                                                </div>

                                                <!-- 3 Property 2 Text Highlight Template -->
                                                @for($i = 0; $i<1; $i++)
                                                    <div class="form-group m-form__group row">

                                                        <div class="col-sm-3 col-sm-3">
                                                            <select name="propertyIDs3P2T1[{{$i}}]" class="form-control m-input" id="exampleSelect1">
                                                                @foreach($properties as $property)
                                                                    <option value={{$property->id}} >{{$property->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="col-sm-2 col-sm-2">
                                                            <input type="text" name="texts3P2T1[{{$i}}]" class="form-control m-input" placeholder="" value="">
                                                        </div>

                                                        <div class="col-sm-3 col-sm-3">
                                                            <select name="propertyIDs3P2T2[{{$i}}]" class="form-control m-input" id="exampleSelect1">
                                                                @foreach($properties as $property)
                                                                    <option value={{$property->id}} >{{$property->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="col-sm-2 col-sm-2">
                                                            <input type="text" name="texts3P2T2[{{$i}}]" class="form-control m-input" placeholder="" value="">
                                                        </div>

                                                        <div class="col-sm-2 col-sm-2">
                                                            <select name="propertyIDs3P2T3[{{$i}}]" class="form-control m-input" id="exampleSelect1">
                                                                @foreach($properties as $property)
                                                                    <option value={{$property->id}} >{{$property->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                @endfor

                                                <!-- 3 Property 2 Text (with combo) Highlight Template -->
                                                @for($i = 0; $i<1; $i++)
                                                    <div class="form-group m-form__group row">

                                                        <div class="col-sm-3 col-sm-3">
                                                            <select name="propertyIDs3P2T1WC[{{$i}}]" class="form-control m-input" id="exampleSelect1">
                                                                @foreach($properties as $property)
                                                                    <option value={{$property->id}} >{{$property->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="col-sm-2 col-sm-2">
                                                            <select name="texts3P2T1WC[{{$i}}]" class="form-control m-input" id="exampleSelect1">
                                                                <option value=1 >-</option>
                                                                <option value=2 >bis zu</option>
                                                                <option value=3 >in alle dt. Netze</option>
                                                                <option value=4 >in alle dt. Mobilfunknetze</option>
                                                                <option value=5 >ins dt. Vodafone (O2) Netz</option>
                                                                <option value=6 >ins dt. Festnetz</option>
                                                                <option value=7 >türkische Festnetz</option>
                                                                <option value=8 >türkische Vodafone Netz</option>
                                                            </select>
                                                        </div>

                                                        <div class="col-sm-3 col-sm-3">
                                                            <select name="propertyIDs3P2T2WC[{{$i}}]" class="form-control m-input" id="exampleSelect1">
                                                                @foreach($properties as $property)
                                                                    <option value={{$property->id}} >{{$property->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                            <div class="col-sm-2 col-sm-2">
                                                                <select name="texts3P2T1WC[{{$i}}]" class="form-control m-input" id="exampleSelect1">
                                                                    <option value=1 >-</option>
                                                                    <option value=2 >bis zu</option>
                                                                    <option value=3 >in alle dt. Netze</option>
                                                                    <option value=4 >in alle dt. Mobilfunknetze</option>
                                                                    <option value=5 >ins dt. Vodafone (O2) Netz</option>
                                                                    <option value=6 >ins dt. Festnetz</option>
                                                                    <option value=7 >türkische Festnetz</option>
                                                                    <option value=8 >türkische Vodafone Netz</option>
                                                                </select>
                                                            </div>
                                                        <div class="col-sm-2 col-sm-2">
                                                            <select name="propertyIDs3P2T3WC[{{$i}}]" class="form-control m-input" id="exampleSelect1">
                                                                @foreach($properties as $property)
                                                                    <option value={{$property->id}} >{{$property->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                @endfor
                                                <div class="m-separator m-separator--dashed m-separator--lg"></div>

                                                <!-- 1 Property 1 Text Highlight Template -->
                                                @for($i = 0; $i<1; $i++)
                                                    <div class="form-group m-form__group row">

                                                        <div class="col-sm-4 col-sm-4">
                                                            <select name="propertyIDs1P1T[{{$i}}]" class="form-control m-input" id="exampleSelect1">
                                                                @foreach($properties as $property)
                                                                    <option value={{$property->id}} >{{$property->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="col-sm-4 col-sm-4">
                                                            <input type="text" name="texts1P1T[{{$i}}]" class="form-control m-input" placeholder="" value="">
                                                        </div>

                                                    </div>
                                                @endfor

                                                <!-- 1 Property 1 Text (with combo) Highlight Template -->
                                                @for($i = 0; $i<1; $i++)
                                                    <div class="form-group m-form__group row">

                                                        <div class="col-sm-4 col-sm-4">
                                                            <select name="propertyIDs1P1TWC[{{$i}}]" class="form-control m-input" id="exampleSelect1">
                                                                @foreach($properties as $property)
                                                                    <option value={{$property->id}} >{{$property->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="col-sm-4 col-sm-4">
                                                            <select name="text1P1TWC[{{$i}}]" class="form-control m-input" id="exampleSelect1">
                                                                <option value=1 >-</option>
                                                                <option value=2 >bis zu</option>
                                                                <option value=3 >in alle dt. Netze</option>
                                                                <option value=4 >in alle dt. Mobilfunknetze</option>
                                                                <option value=5 >ins dt. Vodafone (O2) Netz</option>
                                                                <option value=6 >ins dt. Festnetz</option>
                                                                <option value=7 >türkische Festnetz</option>
                                                                <option value=8 >türkische Vodafone Netz</option>
                                                            </select>
                                                        </div>

                                                    </div>
                                                @endfor
                                                <div class="m-separator m-separator--dashed m-separator--lg"></div>

                                                <!-- 1 Property  Highlight Template -->
                                                @for($i = 0; $i<1; $i++)
                                                    <div class="form-group m-form__group row">

                                                        <div class="col-sm-4 col-sm-4">
                                                            <select name="propertyIDs1P[{{$i}}]" class="form-control m-input" id="exampleSelect1">
                                                                @foreach($properties as $property)
                                                                    <option value={{$property->id}} >{{$property->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                    </div>
                                                @endfor
                                                <div class="m-separator m-separator--dashed m-separator--lg"></div>

                                                <!-- 1 Text Highlight Template -->
                                                @for($i = 0; $i<1; $i++)
                                                    <div class="form-group m-form__group row">

                                                        <div class="col-sm-4 col-sm-4">
                                                            <input type="text" name="texts1T[{{$i}}]" class="form-control m-input" placeholder="" value="">
                                                        </div>

                                                    </div>
                                                @endfor

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end: Form Wizard Step 7-->

                                <!--begin: Form Wizard Step 8 Plausibility-->
                                <div class="m-wizard__form-step" id="m_wizard_form_step_8">

                                    <div class="row" id="plausibilityDIV">
                                        <div class="col-xl-8 offset-xl-2">
                                            <div class="m-form__section m-form__section--first">
                                                <div class="m-form__heading">
                                                    <h3 class="m-form__heading-title">{{__('tariffs\vodafone\create.plausibility')}}</h3>
                                                </div>

                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">{{__('tariffs\vodafone\create.minPeriodOfValidity')}}:</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <input type="text" name="minPeriodOfValidity" class="form-control m-input" value="{{$tariff->vodafoneTariff->plausibility->min_period_of_validity}}">
                                                    </div>
                                                </div>

                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">{{__('tariffs\vodafone\create.debitAuthorization')}}:</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <select name="debitAuthorization" class="form-control m-input">
                                                            <option value=1 {{ ( $tariff->vodafoneTariff->plausibility->debit_authorization == 1) ? 'selected' : '' }} >OK => Zulässig</option>
                                                            <option value=2 {{ ( $tariff->vodafoneTariff->plausibility->debit_authorization == 2) ? 'selected' : '' }} >X = Unzulässig</option>
                                                            <option value=3 {{ ( $tariff->vodafoneTariff->plausibility->debit_authorization == 3) ? 'selected' : '' }} >! => Pflichtfeld</option>
                                                            <option value=4 {{ ( $tariff->vodafoneTariff->plausibility->debit_authorization == 4) ? 'selected' : '' }} >H => Wie Hauptkarte</option>
                                                            <option value=5 {{ ( $tariff->vodafoneTariff->plausibility->debit_authorization == 5) ? 'selected' : '' }} >O => Gruppenbesitzer</option>
                                                            <option value=6 {{ ( $tariff->vodafoneTariff->plausibility->debit_authorization == 6) ? 'selected' : '' }} >M => Gruppenmitglied</option>
                                                            <option value=7 {{ ( $tariff->vodafoneTariff->plausibility->debit_authorization == 7) ? 'selected' : '' }} >Y => Ja</option>
                                                            <option value=8 {{ ( $tariff->vodafoneTariff->plausibility->debit_authorization == 8) ? 'selected' : '' }} >N => Nein</option>
                                                            <option value=9 {{ ( $tariff->vodafoneTariff->plausibility->debit_authorization == 9) ? 'selected' : '' }} >V => Sprachtarif</option>
                                                            <option value=10 {{ ( $tariff->vodafoneTariff->plausibility->debit_authorization == 10) ? 'selected' : '' }} >D => Datentarif</option>
                                                            <option value=11 {{ ( $tariff->vodafoneTariff->plausibility->debit_authorization == 11) ? 'selected' : '' }} >n.a. => nicht verfügbar</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">{{__('tariffs\vodafone\create.subsidyAuthorization')}}:</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <select name="subsidyAuthorization" class="form-control m-input">
                                                            <option value=1 {{ ( $tariff->vodafoneTariff->plausibility->subsidy_authorization == 1) ? 'selected' : '' }} >OK => Zulässig</option>
                                                            <option value=2 {{ ( $tariff->vodafoneTariff->plausibility->subsidy_authorization == 2) ? 'selected' : '' }} >X = Unzulässig</option>
                                                            <option value=3 {{ ( $tariff->vodafoneTariff->plausibility->subsidy_authorization == 3) ? 'selected' : '' }} >! => Pflichtfeld</option>
                                                            <option value=4 {{ ( $tariff->vodafoneTariff->plausibility->subsidy_authorization == 4) ? 'selected' : '' }} >H => Wie Hauptkarte</option>
                                                            <option value=5 {{ ( $tariff->vodafoneTariff->plausibility->subsidy_authorization == 5) ? 'selected' : '' }} >O => Gruppenbesitzer</option>
                                                            <option value=6 {{ ( $tariff->vodafoneTariff->plausibility->subsidy_authorization == 6) ? 'selected' : '' }} >M => Gruppenmitglied</option>
                                                            <option value=7 {{ ( $tariff->vodafoneTariff->plausibility->subsidy_authorization == 7) ? 'selected' : '' }} >Y => Ja</option>
                                                            <option value=8 {{ ( $tariff->vodafoneTariff->plausibility->subsidy_authorization == 8) ? 'selected' : '' }} >N => Nein</option>
                                                            <option value=9 {{ ( $tariff->vodafoneTariff->plausibility->subsidy_authorization == 9) ? 'selected' : '' }} >V => Sprachtarif</option>
                                                            <option value=10 {{ ( $tariff->vodafoneTariff->plausibility->subsidy_authorization == 10) ? 'selected' : '' }} >D => Datentarif</option>
                                                            <option value=11 {{ ( $tariff->vodafoneTariff->plausibility->subsidy_authorization == 11) ? 'selected' : '' }} >n.a. => nicht verfügbar</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">{{__('tariffs\vodafone\create.IMEIAcquisition')}}:</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <select name="IMEIAcquisition" class="form-control m-input">
                                                            <option value=1 {{ ( $tariff->vodafoneTariff->plausibility->IMEI_acquisition == 1) ? 'selected' : '' }} >OK => Zulässig</option>
                                                            <option value=2 {{ ( $tariff->vodafoneTariff->plausibility->IMEI_acquisition == 2) ? 'selected' : '' }} >X = Unzulässig</option>
                                                            <option value=3 {{ ( $tariff->vodafoneTariff->plausibility->IMEI_acquisition == 3) ? 'selected' : '' }} >! => Pflichtfeld</option>
                                                            <option value=4 {{ ( $tariff->vodafoneTariff->plausibility->IMEI_acquisition == 4) ? 'selected' : '' }} >H => Wie Hauptkarte</option>
                                                            <option value=5 {{ ( $tariff->vodafoneTariff->plausibility->IMEI_acquisition == 5) ? 'selected' : '' }} >O => Gruppenbesitzer</option>
                                                            <option value=6 {{ ( $tariff->vodafoneTariff->plausibility->IMEI_acquisition == 6) ? 'selected' : '' }} >M => Gruppenmitglied</option>
                                                            <option value=7 {{ ( $tariff->vodafoneTariff->plausibility->IMEI_acquisition == 7) ? 'selected' : '' }} >Y => Ja</option>
                                                            <option value=8 {{ ( $tariff->vodafoneTariff->plausibility->IMEI_acquisition == 8) ? 'selected' : '' }} >N => Nein</option>
                                                            <option value=9 {{ ( $tariff->vodafoneTariff->plausibility->IMEI_acquisition == 9) ? 'selected' : '' }} >V => Sprachtarif</option>
                                                            <option value=10 {{ ( $tariff->vodafoneTariff->plausibility->IMEI_acquisition == 10) ? 'selected' : '' }} >D => Datentarif</option>
                                                            <option value=11 {{ ( $tariff->vodafoneTariff->plausibility->IMEI_acquisition == 11) ? 'selected' : '' }} >n.a. => nicht verfügbar</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">{{__('tariffs\vodafone\create.telephoneBookEntry')}}:</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <select name="telephoneBookEntry" class="form-control m-input">
                                                            <option value=1 {{ ( $tariff->vodafoneTariff->plausibility->telephone_book_entry == 1) ? 'selected' : '' }} >OK => Zulässig</option>
                                                            <option value=2 {{ ( $tariff->vodafoneTariff->plausibility->telephone_book_entry == 2) ? 'selected' : '' }} >X = Unzulässig</option>
                                                            <option value=3 {{ ( $tariff->vodafoneTariff->plausibility->telephone_book_entry == 3) ? 'selected' : '' }} >! => Pflichtfeld</option>
                                                            <option value=4 {{ ( $tariff->vodafoneTariff->plausibility->telephone_book_entry == 4) ? 'selected' : '' }} >H => Wie Hauptkarte</option>
                                                            <option value=5 {{ ( $tariff->vodafoneTariff->plausibility->telephone_book_entry == 5) ? 'selected' : '' }} >O => Gruppenbesitzer</option>
                                                            <option value=6 {{ ( $tariff->vodafoneTariff->plausibility->telephone_book_entry == 6) ? 'selected' : '' }} >M => Gruppenmitglied</option>
                                                            <option value=7 {{ ( $tariff->vodafoneTariff->plausibility->telephone_book_entry == 7) ? 'selected' : '' }} >Y => Ja</option>
                                                            <option value=8 {{ ( $tariff->vodafoneTariff->plausibility->telephone_book_entry == 8) ? 'selected' : '' }} >N => Nein</option>
                                                            <option value=9 {{ ( $tariff->vodafoneTariff->plausibility->telephone_book_entry == 9) ? 'selected' : '' }} >V => Sprachtarif</option>
                                                            <option value=10 {{ ( $tariff->vodafoneTariff->plausibility->telephone_book_entry == 10) ? 'selected' : '' }} >D => Datentarif</option>
                                                            <option value=11 {{ ( $tariff->vodafoneTariff->plausibility->telephone_book_entry == 11) ? 'selected' : '' }} >n.a. => nicht verfügbar</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">{{__('tariffs\vodafone\create.faxBookEntry')}}:</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <select name="faxBookEntry" class="form-control m-input">
                                                            <option value=1 {{ ( $tariff->vodafoneTariff->plausibility->fax_book_entry == 1) ? 'selected' : '' }} >OK => Zulässig</option>
                                                            <option value=2 {{ ( $tariff->vodafoneTariff->plausibility->fax_book_entry == 2) ? 'selected' : '' }} >X = Unzulässig</option>
                                                            <option value=3 {{ ( $tariff->vodafoneTariff->plausibility->fax_book_entry == 3) ? 'selected' : '' }} >! => Pflichtfeld</option>
                                                            <option value=4 {{ ( $tariff->vodafoneTariff->plausibility->fax_book_entry == 4) ? 'selected' : '' }} >H => Wie Hauptkarte</option>
                                                            <option value=5 {{ ( $tariff->vodafoneTariff->plausibility->fax_book_entry == 5) ? 'selected' : '' }} >O => Gruppenbesitzer</option>
                                                            <option value=6 {{ ( $tariff->vodafoneTariff->plausibility->fax_book_entry == 6) ? 'selected' : '' }} >M => Gruppenmitglied</option>
                                                            <option value=7 {{ ( $tariff->vodafoneTariff->plausibility->fax_book_entry == 7) ? 'selected' : '' }} >Y => Ja</option>
                                                            <option value=8 {{ ( $tariff->vodafoneTariff->plausibility->fax_book_entry == 8) ? 'selected' : '' }} >N => Nein</option>
                                                            <option value=9 {{ ( $tariff->vodafoneTariff->plausibility->fax_book_entry == 9) ? 'selected' : '' }} >V => Sprachtarif</option>
                                                            <option value=10 {{ ( $tariff->vodafoneTariff->plausibility->fax_book_entry == 10) ? 'selected' : '' }} >D => Datentarif</option>
                                                            <option value=11 {{ ( $tariff->vodafoneTariff->plausibility->fax_book_entry == 11) ? 'selected' : '' }} >n.a. => nicht verfügbar</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">{{__('tariffs\vodafone\create.generalAgreement')}}:</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <select name="generalAgreement" class="form-control m-input">
                                                            <option value=1 {{ ( $tariff->vodafoneTariff->plausibility->general_agreement == 1) ? 'selected' : '' }} >OK => Zulässig</option>
                                                            <option value=2 {{ ( $tariff->vodafoneTariff->plausibility->general_agreement == 2) ? 'selected' : '' }} >X = Unzulässig</option>
                                                            <option value=3 {{ ( $tariff->vodafoneTariff->plausibility->general_agreement == 3) ? 'selected' : '' }} >! => Pflichtfeld</option>
                                                            <option value=4 {{ ( $tariff->vodafoneTariff->plausibility->general_agreement == 4) ? 'selected' : '' }} >H => Wie Hauptkarte</option>
                                                            <option value=5 {{ ( $tariff->vodafoneTariff->plausibility->general_agreement == 5) ? 'selected' : '' }} >O => Gruppenbesitzer</option>
                                                            <option value=6 {{ ( $tariff->vodafoneTariff->plausibility->general_agreement == 6) ? 'selected' : '' }} >M => Gruppenmitglied</option>
                                                            <option value=7 {{ ( $tariff->vodafoneTariff->plausibility->general_agreement == 7) ? 'selected' : '' }} >Y => Ja</option>
                                                            <option value=8 {{ ( $tariff->vodafoneTariff->plausibility->general_agreement == 8) ? 'selected' : '' }} >N => Nein</option>
                                                            <option value=9 {{ ( $tariff->vodafoneTariff->plausibility->general_agreement == 9) ? 'selected' : '' }} >V => Sprachtarif</option>
                                                            <option value=10 {{ ( $tariff->vodafoneTariff->plausibility->general_agreement == 10) ? 'selected' : '' }} >D => Datentarif</option>
                                                            <option value=11 {{ ( $tariff->vodafoneTariff->plausibility->general_agreement == 11) ? 'selected' : '' }} >n.a. => nicht verfügbar</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">{{__('tariffs\vodafone\create.VFHomeAddress')}}:</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <select name="VFHomeAddress" class="form-control m-input">
                                                            <option value=1 {{ ( $tariff->vodafoneTariff->plausibility->VF_home_address == 1) ? 'selected' : '' }} >OK => Zulässig</option>
                                                            <option value=2 {{ ( $tariff->vodafoneTariff->plausibility->VF_home_address == 2) ? 'selected' : '' }} >X = Unzulässig</option>
                                                            <option value=3 {{ ( $tariff->vodafoneTariff->plausibility->VF_home_address == 3) ? 'selected' : '' }} >! => Pflichtfeld</option>
                                                            <option value=4 {{ ( $tariff->vodafoneTariff->plausibility->VF_home_address == 4) ? 'selected' : '' }} >H => Wie Hauptkarte</option>
                                                            <option value=5 {{ ( $tariff->vodafoneTariff->plausibility->VF_home_address == 5) ? 'selected' : '' }} >O => Gruppenbesitzer</option>
                                                            <option value=6 {{ ( $tariff->vodafoneTariff->plausibility->VF_home_address == 6) ? 'selected' : '' }} >M => Gruppenmitglied</option>
                                                            <option value=7 {{ ( $tariff->vodafoneTariff->plausibility->VF_home_address == 7) ? 'selected' : '' }} >Y => Ja</option>
                                                            <option value=8 {{ ( $tariff->vodafoneTariff->plausibility->VF_home_address == 8) ? 'selected' : '' }} >N => Nein</option>
                                                            <option value=9 {{ ( $tariff->vodafoneTariff->plausibility->VF_home_address == 9) ? 'selected' : '' }} >V => Sprachtarif</option>
                                                            <option value=10 {{ ( $tariff->vodafoneTariff->plausibility->VF_home_address == 10) ? 'selected' : '' }} >D => Datentarif</option>
                                                            <option value=11 {{ ( $tariff->vodafoneTariff->plausibility->VF_home_address == 11) ? 'selected' : '' }} >n.a. => nicht verfügbar</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">{{__('tariffs\vodafone\create.ultraCard')}}:</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <select name="ultraCard" class="form-control m-input">
                                                            <option value=1 {{ ( $tariff->vodafoneTariff->plausibility->ultra_card == 1) ? 'selected' : '' }} >OK => Zulässig</option>
                                                            <option value=2 {{ ( $tariff->vodafoneTariff->plausibility->ultra_card == 2) ? 'selected' : '' }} >X = Unzulässig</option>
                                                            <option value=3 {{ ( $tariff->vodafoneTariff->plausibility->ultra_card == 3) ? 'selected' : '' }} >! => Pflichtfeld</option>
                                                            <option value=4 {{ ( $tariff->vodafoneTariff->plausibility->ultra_card == 4) ? 'selected' : '' }} >H => Wie Hauptkarte</option>
                                                            <option value=5 {{ ( $tariff->vodafoneTariff->plausibility->ultra_card == 5) ? 'selected' : '' }} >O => Gruppenbesitzer</option>
                                                            <option value=6 {{ ( $tariff->vodafoneTariff->plausibility->ultra_card == 6) ? 'selected' : '' }} >M => Gruppenmitglied</option>
                                                            <option value=7 {{ ( $tariff->vodafoneTariff->plausibility->ultra_card == 7) ? 'selected' : '' }} >Y => Ja</option>
                                                            <option value=8 {{ ( $tariff->vodafoneTariff->plausibility->ultra_card == 8) ? 'selected' : '' }} >N => Nein</option>
                                                            <option value=9 {{ ( $tariff->vodafoneTariff->plausibility->ultra_card == 9) ? 'selected' : '' }} >V => Sprachtarif</option>
                                                            <option value=10 {{ ( $tariff->vodafoneTariff->plausibility->ultra_card == 10) ? 'selected' : '' }} >D => Datentarif</option>
                                                            <option value=11 {{ ( $tariff->vodafoneTariff->plausibility->ultra_card == 11) ? 'selected' : '' }} >n.a. => nicht verfügbar</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">{{__('tariffs\vodafone\create.FNPorting')}}:</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <select name="FNPorting" class="form-control m-input">
                                                            <option value=1 {{ ( $tariff->vodafoneTariff->plausibility->FN_porting == 1) ? 'selected' : '' }} >OK => Zulässig</option>
                                                            <option value=2 {{ ( $tariff->vodafoneTariff->plausibility->FN_porting == 2) ? 'selected' : '' }} >X = Unzulässig</option>
                                                            <option value=3 {{ ( $tariff->vodafoneTariff->plausibility->FN_porting == 3) ? 'selected' : '' }} >! => Pflichtfeld</option>
                                                            <option value=4 {{ ( $tariff->vodafoneTariff->plausibility->FN_porting == 4) ? 'selected' : '' }} >H => Wie Hauptkarte</option>
                                                            <option value=5 {{ ( $tariff->vodafoneTariff->plausibility->FN_porting == 5) ? 'selected' : '' }} >O => Gruppenbesitzer</option>
                                                            <option value=6 {{ ( $tariff->vodafoneTariff->plausibility->FN_porting == 6) ? 'selected' : '' }} >M => Gruppenmitglied</option>
                                                            <option value=7 {{ ( $tariff->vodafoneTariff->plausibility->FN_porting == 7) ? 'selected' : '' }} >Y => Ja</option>
                                                            <option value=8 {{ ( $tariff->vodafoneTariff->plausibility->FN_porting == 8) ? 'selected' : '' }} >N => Nein</option>
                                                            <option value=9 {{ ( $tariff->vodafoneTariff->plausibility->FN_porting == 9) ? 'selected' : '' }} >V => Sprachtarif</option>
                                                            <option value=10 {{ ( $tariff->vodafoneTariff->plausibility->FN_porting == 10) ? 'selected' : '' }} >D => Datentarif</option>
                                                            <option value=11 {{ ( $tariff->vodafoneTariff->plausibility->FN_porting == 11) ? 'selected' : '' }} >n.a. => nicht verfügbar</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">{{__('tariffs\vodafone\create.AOBundle')}}:</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <select name="AOBundle" class="form-control m-input">
                                                            <option value=1 {{ ( $tariff->vodafoneTariff->plausibility->AO_bundle == 1) ? 'selected' : '' }} >OK => Zulässig</option>
                                                            <option value=2 {{ ( $tariff->vodafoneTariff->plausibility->AO_bundle == 2) ? 'selected' : '' }} >X = Unzulässig</option>
                                                            <option value=3 {{ ( $tariff->vodafoneTariff->plausibility->AO_bundle == 3) ? 'selected' : '' }} >! => Pflichtfeld</option>
                                                            <option value=4 {{ ( $tariff->vodafoneTariff->plausibility->AO_bundle == 4) ? 'selected' : '' }} >H => Wie Hauptkarte</option>
                                                            <option value=5 {{ ( $tariff->vodafoneTariff->plausibility->AO_bundle == 5) ? 'selected' : '' }} >O => Gruppenbesitzer</option>
                                                            <option value=6 {{ ( $tariff->vodafoneTariff->plausibility->AO_bundle == 6) ? 'selected' : '' }} >M => Gruppenmitglied</option>
                                                            <option value=7 {{ ( $tariff->vodafoneTariff->plausibility->AO_bundle == 7) ? 'selected' : '' }} >Y => Ja</option>
                                                            <option value=8 {{ ( $tariff->vodafoneTariff->plausibility->AO_bundle == 8) ? 'selected' : '' }} >N => Nein</option>
                                                            <option value=9 {{ ( $tariff->vodafoneTariff->plausibility->AO_bundle == 9) ? 'selected' : '' }} >V => Sprachtarif</option>
                                                            <option value=10 {{ ( $tariff->vodafoneTariff->plausibility->AO_bundle == 10) ? 'selected' : '' }} >D => Datentarif</option>
                                                            <option value=11 {{ ( $tariff->vodafoneTariff->plausibility->AO_bundle == 11) ? 'selected' : '' }} >n.a. => nicht verfügbar</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">{{__('tariffs\vodafone\create.memberType')}}:</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <select name="memberType" class="form-control m-input">
                                                            <option value=1 {{ ( $tariff->vodafoneTariff->plausibility->member_type == 1) ? 'selected' : '' }} >OK => Zulässig</option>
                                                            <option value=2 {{ ( $tariff->vodafoneTariff->plausibility->member_type == 2) ? 'selected' : '' }} >X = Unzulässig</option>
                                                            <option value=3 {{ ( $tariff->vodafoneTariff->plausibility->member_type == 3) ? 'selected' : '' }} >! => Pflichtfeld</option>
                                                            <option value=4 {{ ( $tariff->vodafoneTariff->plausibility->member_type == 4) ? 'selected' : '' }} >H => Wie Hauptkarte</option>
                                                            <option value=5 {{ ( $tariff->vodafoneTariff->plausibility->member_type == 5) ? 'selected' : '' }} >O => Gruppenbesitzer</option>
                                                            <option value=6 {{ ( $tariff->vodafoneTariff->plausibility->member_type == 6) ? 'selected' : '' }} >M => Gruppenmitglied</option>
                                                            <option value=7 {{ ( $tariff->vodafoneTariff->plausibility->member_type == 7) ? 'selected' : '' }} >Y => Ja</option>
                                                            <option value=8 {{ ( $tariff->vodafoneTariff->plausibility->member_type == 8) ? 'selected' : '' }} >N => Nein</option>
                                                            <option value=9 {{ ( $tariff->vodafoneTariff->plausibility->member_type == 9) ? 'selected' : '' }} >V => Sprachtarif</option>
                                                            <option value=10 {{ ( $tariff->vodafoneTariff->plausibility->member_type == 10) ? 'selected' : '' }} >D => Datentarif</option>
                                                            <option value=11 {{ ( $tariff->vodafoneTariff->plausibility->member_type == 11) ? 'selected' : '' }} >n.a. => nicht verfügbar</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">{{__('tariffs\vodafone\create.groupMust')}}:</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <select name="groupMust" class="form-control m-input">
                                                            <option value=1 {{ ( $tariff->vodafoneTariff->plausibility->group_must == 1) ? 'selected' : '' }} >OK => Zulässig</option>
                                                            <option value=2 {{ ( $tariff->vodafoneTariff->plausibility->group_must == 2) ? 'selected' : '' }} >X = Unzulässig</option>
                                                            <option value=3 {{ ( $tariff->vodafoneTariff->plausibility->group_must == 3) ? 'selected' : '' }} >! => Pflichtfeld</option>
                                                            <option value=4 {{ ( $tariff->vodafoneTariff->plausibility->group_must == 4) ? 'selected' : '' }} >H => Wie Hauptkarte</option>
                                                            <option value=5 {{ ( $tariff->vodafoneTariff->plausibility->group_must == 5) ? 'selected' : '' }} >O => Gruppenbesitzer</option>
                                                            <option value=6 {{ ( $tariff->vodafoneTariff->plausibility->group_must == 6) ? 'selected' : '' }} >M => Gruppenmitglied</option>
                                                            <option value=7 {{ ( $tariff->vodafoneTariff->plausibility->group_must == 7) ? 'selected' : '' }} >Y => Ja</option>
                                                            <option value=8 {{ ( $tariff->vodafoneTariff->plausibility->group_must == 8) ? 'selected' : '' }} >N => Nein</option>
                                                            <option value=9 {{ ( $tariff->vodafoneTariff->plausibility->group_must == 9) ? 'selected' : '' }} >V => Sprachtarif</option>
                                                            <option value=10 {{ ( $tariff->vodafoneTariff->plausibility->group_must == 10) ? 'selected' : '' }} >D => Datentarif</option>
                                                            <option value=11 {{ ( $tariff->vodafoneTariff->plausibility->group_must == 11) ? 'selected' : '' }} >n.a. => nicht verfügbar</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">{{__('tariffs\vodafone\create.tariffType')}}:</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <select name="tariffType" class="form-control m-input">
                                                            <option value=1 {{ ( $tariff->vodafoneTariff->plausibility->tariff_type == 1) ? 'selected' : '' }} >OK => Zulässig</option>
                                                            <option value=2 {{ ( $tariff->vodafoneTariff->plausibility->tariff_type == 2) ? 'selected' : '' }} >X = Unzulässig</option>
                                                            <option value=3 {{ ( $tariff->vodafoneTariff->plausibility->tariff_type == 3) ? 'selected' : '' }} >! => Pflichtfeld</option>
                                                            <option value=4 {{ ( $tariff->vodafoneTariff->plausibility->tariff_type == 4) ? 'selected' : '' }} >H => Wie Hauptkarte</option>
                                                            <option value=5 {{ ( $tariff->vodafoneTariff->plausibility->tariff_type == 5) ? 'selected' : '' }} >O => Gruppenbesitzer</option>
                                                            <option value=6 {{ ( $tariff->vodafoneTariff->plausibility->tariff_type == 6) ? 'selected' : '' }} >M => Gruppenmitglied</option>
                                                            <option value=7 {{ ( $tariff->vodafoneTariff->plausibility->tariff_type == 7) ? 'selected' : '' }} >Y => Ja</option>
                                                            <option value=8 {{ ( $tariff->vodafoneTariff->plausibility->tariff_type == 8) ? 'selected' : '' }} >N => Nein</option>
                                                            <option value=9 {{ ( $tariff->vodafoneTariff->plausibility->tariff_type == 9) ? 'selected' : '' }} >V => Sprachtarif</option>
                                                            <option value=10 {{ ( $tariff->vodafoneTariff->plausibility->tariff_type == 10) ? 'selected' : '' }} >D => Datentarif</option>
                                                            <option value=11 {{ ( $tariff->vodafoneTariff->plausibility->tariff_type == 11) ? 'selected' : '' }} >n.a. => nicht verfügbar</option>
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end: Form Wizard Step 8-->

                                <!--begin: Form Wizard Step 9 Services-->
                                <div class="m-wizard__form-step" id="m_wizard_form_step_9">

                                    <div class="row" id="serviceDIV">
                                        <div class="col-xl-8 offset-xl-2">
                                            <div class="m-form__section m-form__section--first">
                                                <div class="m-form__heading">
                                                    <h3 class="m-form__heading-title">{{__('tariffs\vodafone\create.service')}}</h3>
                                                </div>

                                                <div class="form-group m-form__group">
                                                    <input type="file" name="vodafoneTariffServiceProperty" />
                                                </div>
                                                <div class="m-separator m-separator--dashed m-separator--lg"></div>
                                                <!--begin: Services -->
                                                <div class="row" align="left">
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
                                                                                        @foreach($tariff->vodafoneTariff->services as $service)
                                                                                            @if($service->type == 1)
                                                                                                <label class="m-checkbox m-checkbox--success">
                                                                                                    <input type="checkbox" name="dataServices[]" value="{{$service->code}}" @if($service->pivot->property == 1) checked @endif disabled> {{$service->name}}
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
                                                                                        @foreach($tariff->vodafoneTariff->services as $service)
                                                                                            @if($service->type == 2)
                                                                                                <label class="m-checkbox m-checkbox--success">
                                                                                                    <input type="checkbox" name="additionalServices[]" value={{$service->code}} @if($service->pivot->property == 1) checked @endif disabled> {{$service->name}}
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
                                                                                                    <input type="checkbox" name="additionalServices[]" value={{$service->code}} @if($service->pivot->property == 1) checked @endif disabled> {{$service->name}}
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
                                                <!--end: Services -->
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!--end: Form Wizard Step 9 Services-->

                                <!--begin: Form Wizard Step 10 Law Text-->
                                <div class="m-wizard__form-step" id="m_wizard_form_step_10">

                                    <div class="row" id="lawTextDIV">
                                        <div class="col-xl-8 offset-xl-2">
                                            <div class="m-form__section m-form__section--first">

                                                <!--begin: Law Text Setup -->
                                                <div class="form-group m-form__group row" >
                                                    <label class="col-sm-3 col-sm-3 col-form-label"><b>{{__('tariffs\vodafone\create.lawTextOftariffs')}}</b></label>
                                                    <div class="col-sm-6 col-sm-6">
                                                        <div class="m-radio-list" id="lawTextOptionDiv">
                                                            <label class="m-radio m-radio--bold">
                                                                <input type="radio" name="lawTextOption" id="lawTextOption" value="1">{{__('tariffs\vodafone\create.copyFromOtherTariff')}}
                                                                <span></span>
                                                            </label>
                                                            <label class="m-radio m-radio--bold">
                                                                <input type="radio" name="lawTextOption" id="lawTextOption" value="2" checked="checked">{{__('tariffs\vodafone\create.selectFromTheList')}}
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="m-separator m-separator--dashed m-separator--lg"></div>

                                                <!--begin: list of the tariff -->
                                                <div class="form-group m-form__group row" id="tariffListDiv">
                                                    <label for="exampleSelect1" class="col-xl-3 col-lg-3 col-form-label">{{__('tariffs\vodafone\create.tariffs')}}</label>
                                                    <div class="col-xl-6 col-lg-6">
                                                        <select name="tariffSelect" class="form-control m-input" id="tariffSelect">
                                                            @foreach($provider->tariffs as $tariffOfProvider)
                                                                <option value={{$tariffOfProvider->id}}
                                                                @if($tariff->id == $tariffOfProvider->id)
                                                                        selected
                                                                        @endif
                                                                >{{$tariffOfProvider->name}} </option>

                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <!--end: list of the tariff -->

                                                <!--begin: list of the law text -->
                                                <div class="form-group m-form__group row" id="lawTextListDiv">
                                                    <table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
                                                        <thead>
                                                        <tr>
                                                            <th>{{__('lawTexts/index.lawTextID')}}</th>
                                                            <th>{{__('lawTexts/index.code')}}</th>
                                                            <th>{{__('lawTexts/index.content')}}</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach (\App\LawText::all() as $lawText)
                                                            <tr>
                                                                <td valign="center">{{$lawText->id}}</td>
                                                                <td valign="center">
                                                                    <label class="m-checkbox m-checkbox--success">
                                                                        <input type="checkbox" name="lawTextCheckbox[]" value="{{$lawText->id}}"
                                                                               @foreach($tariff->vodafoneTariff->lawtexts as $lawtextOfTariff)
                                                                               @if($lawtextOfTariff->id == $lawText->id)
                                                                               checked="checked"
                                                                                @endif
                                                                                @endforeach
                                                                        > {{$lawText->code}}
                                                                        <span></span>
                                                                    </label>
                                                                </td>
                                                                <td>{{$lawText->content}}</td>
                                                            </tr>
                                                        @endforeach

                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!--end: list of the law text -->

                                                <!--end: Law Text Setup -->
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!--end: Form Wizard Step 10 Law Text-->

                                <!--begin: Form Wizard Step X Confirmation-->
                                <div class="m-wizard__form-step" id="m_wizard_form_step_11">
                                    <div class="row">
                                        <div class="col-xl-8 offset-xl-2">

                                            <!--begin::Section-->
                                            <ul class="nav nav-tabs m-tabs-line--2x m-tabs-line m-tabs-line--danger" role="tablist">
                                                <li class="nav-item m-tabs__item">
                                                    <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_form_confirm_1" role="tab">1. General Info</a>
                                                </li>
                                                <li class="nav-item m-tabs__item">
                                                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_form_confirm_2" role="tab">2. Main Office</a>
                                                </li>

                                                <li class="nav-item m-tabs__item">
                                                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_form_confirm_3" role="tab">3. Member Codes</a>
                                                </li>
                                                <li class="nav-item m-tabs__item">
                                                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_form_confirm_4" role="tab">4. Bank Account</a>
                                                </li>
                                                <li class="nav-item m-tabs__item">
                                                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_form_confirm_5" role="tab">5. Admin Account</a>
                                                </li>
                                            </ul>
                                            <div class="tab-content m--margin-top-40">
                                                <div class="tab-pane active" id="m_form_confirm_1" role="tabpanel">
                                                    <div class="m-form__section m-form__section--first">
                                                        <div class="m-form__heading">
                                                            <h4 class="m-form__heading-title">Dealer Details</h4>
                                                        </div>
                                                        <div class="form-group m-form__group m-form__group--sm row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">Name:</label>
                                                            <div class="col-xl-9 col-lg-9">
                                                                <span class="m-form__control-static">Nick Stone</span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group m-form__group m-form__group--sm row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">Email:</label>
                                                            <div class="col-xl-9 col-lg-9">
                                                                <span class="m-form__control-static">nick.stone@gmail.com</span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group m-form__group m-form__group--sm row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">Phone</label>
                                                            <div class="col-xl-9 col-lg-9">
                                                                <span class="m-form__control-static">+206-78-55034890</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="m-separator m-separator--dashed m-separator--lg"></div>
                                                    <div class="m-form__section">
                                                        <div class="m-form__heading">
                                                            <h4 class="m-form__heading-title">Corresponding Address <i data-toggle="m-tooltip" data-width="auto" class="m-form__heading-help-icon flaticon-info" title="Some help text goes here"></i></h4>
                                                        </div>
                                                        <div class="form-group m-form__group m-form__group--sm row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">Address Line 1:</label>
                                                            <div class="col-xl-9 col-lg-9">
                                                                <span class="m-form__control-static">Headquarters 1120 N Street Sacramento 916-654-5266</span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group m-form__group m-form__group--sm row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">Address Line 2:</label>
                                                            <div class="col-xl-9 col-lg-9">
                                                                <span class="m-form__control-static">P.O. Box 942873 Sacramento, CA 94273-0001</span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group m-form__group m-form__group--sm row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">City:</label>
                                                            <div class="col-xl-9 col-lg-9">
                                                                <span class="m-form__control-static">Polo Alto</span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group m-form__group m-form__group--sm row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">State:</label>
                                                            <div class="col-xl-9 col-lg-9">
                                                                <span class="m-form__control-static">California</span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group m-form__group m-form__group--sm row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">Country:</label>
                                                            <div class="col-xl-9 col-lg-9">
                                                                <span class="m-form__control-static">USA</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="m_form_confirm_2" role="tabpanel">
                                                    <div class="m-form__section m-form__section--first">
                                                        <div class="m-form__heading">
                                                            <h4 class="m-form__heading-title">Main Office Details</h4>
                                                        </div>
                                                        <div class="form-group m-form__group m-form__group--sm row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">URL:</label>
                                                            <div class="col-xl-9 col-lg-9">
                                                                <span class="m-form__control-static">sinortech.vertoffice.com</span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group m-form__group m-form__group--sm row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">Username:</label>
                                                            <div class="col-xl-9 col-lg-9">
                                                                <span class="m-form__control-static">sinortech.admin</span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group m-form__group m-form__group--sm row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">Password:</label>
                                                            <div class="col-xl-9 col-lg-9">
                                                                <span class="m-form__control-static">*********</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="m-separator m-separator--dashed m-separator--lg"></div>
                                                    <div class="m-form__section">
                                                        <div class="m-form__heading">
                                                            <h4 class="m-form__heading-title">Account Details</h4>
                                                        </div>
                                                        <div class="form-group m-form__group m-form__group--sm row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">URL:</label>
                                                            <div class="col-xl-9 col-lg-9">
                                                                <span class="m-form__control-static">sinortech.vertoffice.com</span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group m-form__group m-form__group--sm row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">Username:</label>
                                                            <div class="col-xl-9 col-lg-9">
                                                                <span class="m-form__control-static">sinortech.admin</span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group m-form__group m-form__group--sm row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">Password:</label>
                                                            <div class="col-xl-9 col-lg-9">
                                                                <span class="m-form__control-static">*********</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="m_form_confirm_3" role="tabpanel">
                                                    <div class="m-form__section m-form__section--first">
                                                        <div class="m-form__section">
                                                            <div class="m-form__heading">
                                                                <h4 class="m-form__heading-title">Client Settings</h4>
                                                            </div>
                                                            <div class="form-group m-form__group m-form__group--sm row">
                                                                <label class="col-xl-3 col-lg-3 col-form-label">User Group:</label>
                                                                <div class="col-xl-9 col-lg-9">
                                                                    <span class="m-form__control-static">Customer</span>
                                                                </div>
                                                            </div>
                                                            <div class="form-group m-form__group m-form__group--sm row">
                                                                <label class="col-xl-3 col-lg-3 col-form-label">Communications:</label>
                                                                <div class="col-xl-9 col-lg-9">
                                                                    <span class="m-form__control-static">Phone, Email</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="m_form_confirm_4" role="tabpanel">
                                                    <div class="m-form__section m-form__section--first">
                                                        <div class="m-form__section">
                                                            <div class="m-form__heading">
                                                                <h4 class="m-form__heading-title">Client Settings</h4>
                                                            </div>
                                                            <div class="form-group m-form__group m-form__group--sm row">
                                                                <label class="col-xl-3 col-lg-3 col-form-label">User Group:</label>
                                                                <div class="col-xl-9 col-lg-9">
                                                                    <span class="m-form__control-static">Customer</span>
                                                                </div>
                                                            </div>
                                                            <div class="form-group m-form__group m-form__group--sm row">
                                                                <label class="col-xl-3 col-lg-3 col-form-label">Communications:</label>
                                                                <div class="col-xl-9 col-lg-9">
                                                                    <span class="m-form__control-static">Phone, Email</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="m_form_confirm_5" role="tabpanel">
                                                    <div class="m-form__section m-form__section--first">
                                                        <div class="m-form__section">
                                                            <div class="m-form__heading">
                                                                <h4 class="m-form__heading-title">Client Settings</h4>
                                                            </div>
                                                            <div class="form-group m-form__group m-form__group--sm row">
                                                                <label class="col-xl-3 col-lg-3 col-form-label">User Group:</label>
                                                                <div class="col-xl-9 col-lg-9">
                                                                    <span class="m-form__control-static">Customer</span>
                                                                </div>
                                                            </div>
                                                            <div class="form-group m-form__group m-form__group--sm row">
                                                                <label class="col-xl-3 col-lg-3 col-form-label">Communications:</label>
                                                                <div class="col-xl-9 col-lg-9">
                                                                    <span class="m-form__control-static">Phone, Email</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Section-->

                                            <div class="m-separator m-separator--dashed m-separator--lg"></div>
                                            <div class="form-group m-form__group m-form__group--sm row">
                                                <div class="col-xl-12">
                                                    <div class="m-checkbox-inline">
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            <input type="checkbox" name="accept" value="1">
                                                            Click here to indicate that you have read and agree to the terms presented in the Terms and Conditions agreement
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 m--align-right">
                                                <button type="submit" class="btn btn-brand">Submit</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!--end: Form Wizard Step X-->

                            </div>
                            <!--end: Form Body -->

                            <!--begin: Form Actions -->
                            <div class="m-portlet__foot m-portlet__foot--fit m--margin-top-40">
                                <div class="m-form__actions">
                                    <div class="row">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-4 m--align-left">
                                            <a href="#" class="btn btn-secondary m-btn m-btn--custom m-btn--icon" data-wizard-action="prev">
															<span>
																<i class="la la-arrow-left"></i>&nbsp;&nbsp;
																<span>Back</span>
															</span>
                                            </a>
                                        </div>
                                        <div class="col-lg-4 m--align-right">
                                            <a href="#" class="btn btn-primary m-btn m-btn--custom m-btn--icon" data-wizard-action="submit">
															<span>
																<i class="la la-check"></i>&nbsp;&nbsp;
																<span>Submit</span>
															</span>
                                            </a>
                                            <a href="#" class="btn btn-warning m-btn m-btn--custom m-btn--icon" data-wizard-action="next">
															<span>
																<span>Save & Continue</span>&nbsp;&nbsp;
																<i class="la la-arrow-right"></i>
															</span>
                                            </a>
                                        </div>
                                        <div class="col-lg-2"></div>
                                    </div>
                                </div>
                            </div>
                            <!--end: Form Actions -->

                        </form>
                        <!--end: Form -->
                    </div>
                    <!--end: Form Wizard Form-->

                </div>
                <!--end: Form Wizard-->

            </div>
            <!--End::Main Portlet-->

        </div>
        <!-- END: Content -->

    </div>
    <!-- END: Main Content -->

@endsection

@section('pageVendorsAndScripts')
    <!--begin::Page Vendors -->
    <script src="{{ asset('metronic/assets/vendors/custom/fullcalendar/fullcalendar.bundle.js')}}" type="text/javascript"></script>
    <!--end::Page Vendors -->

    <!--begin::Page Scripts -->
    <script src="{{ asset('js/isLimited.js')}}" type="text/javascript"></script>
    <script src="{{ asset('js/ontop.js')}}" type="text/javascript"></script>
    <script src="{{ asset('js/tariffVodafoneEdit8.js')}}" type="text/javascript"></script>

    <script src="{{ asset('metronic/assets/app/js/dashboard.js')}}" type="text/javascript"></script>
    <script src="{{ asset('metronic/assets/demo/default/custom/crud/wizard/createDealerFormWizard.js')}}" type="text/javascript"></script>
    <script src="{{ asset('metronic/assets/demo/default/custom/crud/forms/widgets/bootstrap-datepicker.js')}}" type="text/javascript"></script>
    <!--end::Page Scripts -->
@endsection