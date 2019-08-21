@extends ('partials.master')

@section ('content')

    <!-- BEGIN: Main Content "stays right before 'Subheader' section and rigth after 'END: Left Aside' section of the original html files'"-->
    <div class="m-grid__item m-grid__item--fluid m-wrapper">

        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title m-subheader__title--separator">{{__('contracts\vodafone\create.contractManagement')}}</h3>
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
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                {{__('contracts\vodafone\create.contract')}}
                                <small> </small>
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
                                            {{__('contracts\vodafone\create.main')}}
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
                                            {{__('contracts\vodafone\create.address')}}
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
                                            {{__('contracts\vodafone\create.paymentMethod')}}
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
                                            {{__('contracts\vodafone\create.contractOptions')}}
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

                    <!--begin: Form Wizard -FORM- -->
                    <div class="m-wizard__form">
                        <!--
                            1) Use m-form--label-align-left class to alight the form input labels to the right
                            2) Use m-form--state class to highlight input control borders on form validation
                        -->

                        <!--begin: Form -->
                        <form method="POST" action="/contract/forward-to-store" class="m-form m-form--label-align-left- m-form--state-" id="m_form">
                        @csrf
                            <!--
                                contract_type is also needed in "ContractController@forward". In this file it is directly selected by the user at the beginning.
                                No need to define as a hidden variable. But for other operation it may be needed as we operate on DSL.
                            -->

                            <div class="m-portlet__body">

                                <!--begin: Form Wizard Step 1 - Main - -->
                                <div class="m-wizard__form-step m-wizard__form-step--current" id="m_wizard_form_step_1">
                                    <div class="row">
                                        <div class="col-xl-8 offset-xl-2">
                                            <div class="m-form__section m-form__section--first">

                                                <div class="m-separator m-separator--dashed m-separator--lg"></div>
                                                <div class="m-form__heading">
                                                    <h3 class="m-form__heading-title">{{__('contracts\vodafone\create.main')}}</h3>
                                                </div>

                                                <div class="form-group m-form__group row">
                                                    <label class="col-sm-3 col-sm-3 col-form-label">{{__('contracts\vodafone\create.contractType')}}</label>
                                                    <div class="m-radio-inline" id="contractTypes" class="col-sm-9 col-lg-9">
                                                        <label class="m-radio">
                                                            <input type="radio" name="contractType" id="contractType" value=1 checked> {{__('contracts\vodafone\create.newContract')}}
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio">
                                                            <input type="radio" name="contractType" id="contractType" value=2> {{__('contracts\vodafone\create.porting')}}
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio">
                                                            <input type="radio" name="contractType" id="contractType" value=3> {{__('contracts\vodafone\create.DCChange')}}
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="m-separator m-separator--dashed m-separator--lg"></div>
                                                <div class="form-group m-form__group row">
                                                    <label class="col-sm-3 col-sm-3 col-form-label">{{__('contracts\vodafone\create.customerType')}}</label>
                                                    <div class="m-radio-inline" id="customerTypes" class="col-sm-9 col-lg-9">
                                                        <label class="m-radio">
                                                            <input type="radio" name="customerType" id="customerType" value=1 checked>{{__('contracts\vodafone\create.privateCustomer')}}
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio">
                                                            <input type="radio" name="customerType" id="customerType" value=2>{{__('contracts\vodafone\create.businessCustomer')}}
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio">
                                                            <input type="radio" name="customerType" id="customerType" value=3>{{__('contracts\vodafone\create.SOHoCustomer')}}
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="m-separator m-separator--dashed m-separator--lg"></div>
                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">{{__('contracts\vodafone\create.additionalContract')}}</label>
                                                    <div class="col-xl-1 col-lg-1">
                                                        <span class="m-switch m-switch--sm m-switch--icon">
                                                            <label>
                                                                <input type="checkbox"  name="additionalContract" id="additionalContract">
                                                                <span></span>
                                                            </label>
                                                        </span>
                                                    </div>
                                                    <label class="col-xl-3 col-lg-3 col-form-label" id="additionalContractCustomerNumberLabel">{{__('contracts\vodafone\create.customerNumber')}}</label>
                                                    <div class="col-xl-5 col-lg-5">
                                                        <input type="text" name="additionalContractCustomerNumber" id="additionalContractCustomerNumber" class="form-control m-input form-control-sm">
                                                    </div>
                                                </div>

                                                <!--begin- Section For DC Change -->
                                                <div class="sectionForDCChange">
                                                    <div class="m-separator m-separator--dashed m-separator--lg"></div>
                                                    <div class="m-form__heading">
                                                        <h3 class="m-form__heading-title">{{__('contracts\vodafone\create.DCChange')}}</h3>
                                                    </div>

                                                    <div class="form-group m-form__group row">
                                                        <label for="exampleSelect1" class="col-sm-3 col-sm-3 col-form-label">{{__('contracts\vodafone\create.prefix')}}* </label>
                                                        <div class="col-sm-6 col-lg-6">
                                                            <select name="DCWPrefix" class="form-control m-input form-control-sm" id="DCWPrefix">
                                                                <option value=0></option>
                                                                <option value=1>{{__('contracts\vodafone\create.sir')}}</option>
                                                                <option value=2>{{__('contracts\vodafone\create.madam')}}</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group m-form__group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('contracts\vodafone\create.telephoneNumber')}}*</label>
                                                        <div class="col-xl-6 col-lg-6">
                                                            <input type="text" name="DCWTelephoneNumber" id="DCWTelephoneNumber" class="form-control m-input form-control-sm">
                                                        </div>
                                                    </div>

                                                    <div class="form-group m-form__group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('contracts\vodafone\create.differentCustomerName')}}*</label>
                                                        <div class="col-xl-6 col-lg-6">
                                                            <input type="text" name="DCWDifferentCustomerName" id="DCWDifferentCustomerName" class="form-control m-input form-control-sm">
                                                        </div>
                                                    </div>

                                                    <div class="form-group m-form__group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('contracts\vodafone\create.differentCustomerBirthDate')}}:</label>
                                                        <div class="col-xl-6 col-lg-6">
                                                            <input name="DCWDifferentCustomerBirthDate" class="form-control m-input form-control-sm" type="date" value="2019-04-19" id="example-date-input">
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end- Section For DC Change -->

                                                <!--begin- Section For Porting -->
                                                <div class="sectionForPorting">
                                                    <div class="m-separator m-separator--dashed m-separator--lg"></div>
                                                    <div class="m-form__heading">
                                                        <h3 class="m-form__heading-title">{{__('contracts\vodafone\create.porting')}}</h3>
                                                    </div>

                                                    <div class="form-group m-form__group row">
                                                        <label for="exampleSelect1" class="col-sm-3 col-sm-3 col-form-label">{{__('contracts\vodafone\create.prefix')}}* </label>
                                                        <div class="col-sm-6 col-lg-6">
                                                            <select name="portingPrefix" class="form-control m-input form-control-sm" id="portingPrefix">
                                                                <option value=0></option>
                                                                <option value=1>0151</option>
                                                                <option value=2>0152</option>
                                                                <option value=2>0153</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group m-form__group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('contracts\vodafone\create.telephoneNumber')}}</label>
                                                        <div class="col-xl-6 col-lg-6">
                                                            <input type="text" name="portingTelephoneNumber" id="portingTelephoneNumber" class="form-control m-input form-control-sm">
                                                        </div>
                                                    </div>

                                                    <div class="form-group m-form__group row">
                                                        <label for="exampleSelect1" class="col-sm-3 col-sm-3 col-form-label">{{__('contracts\vodafone\create.oldProvider')}}</label>
                                                        <div class="col-sm-6 col-lg-6">
                                                            <select name="portingOldProvider" class="form-control m-input form-control-sm" id="portingOldProvider">
                                                                <option value=0>{{__('contracts\vodafone\create.provider')}}</option>
                                                                @foreach(\App\Provider::all() as $provider)
                                                                    <option value={{$provider->id}}>{{$provider->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group m-form__group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('contracts\vodafone\create.oldProviderTelephoneNumber')}}</label>
                                                        <div class="col-xl-6 col-lg-6">
                                                            <input type="text" name="oldProviderTelephoneNumber" id="oldProviderTelephoneNumber" class="form-control m-input form-control-sm">
                                                        </div>
                                                    </div>

                                                    <div class="form-group m-form__group row">
                                                        <label for="exampleSelect1" class="col-sm-3 col-sm-3 col-form-label">{{__('contracts\vodafone\create.portingType')}}</label>
                                                        <div class="col-sm-6 col-lg-6">
                                                            <select name="portingType" class="form-control m-input form-control-sm" id="portingType">
                                                                <option value=0></option>
                                                                <option value=1>0151</option>
                                                                <option value=2>0152</option>
                                                                <option value=2>0153</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group m-form__group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('contracts\vodafone\create.endOfTheContract')}}</label>
                                                        <div class="col-xl-6 col-lg-6">
                                                            <input name="portingEndOfTheContract" class="form-control m-input form-control-sm" type="date" value="2019-04-19" id="example-date-input">
                                                        </div>
                                                    </div>

                                                    <div class="form-group m-form__group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('contracts\vodafone\create.cancellationDateOfOldContract')}}</label>
                                                        <div class="col-xl-6 col-lg-6">
                                                            <input name="portingCancellationDateOfOldContract" class="form-control m-input form-control-sm" type="date" value="2019-04-19" id="example-date-input">
                                                        </div>
                                                    </div>

                                                </div>
                                                <!--end- Section For Porting -->

                                                <!--begin- Section For Private Customer -->
                                                <div class="sectionForPrivateCustomer">
                                                    <div class="m-separator m-separator--dashed m-separator--lg"></div>

                                                    <div class="form-group m-form__group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('contracts\vodafone\create.password')}}*</label>
                                                        <div class="col-xl-6 col-lg-6">
                                                            <input type="text" name="mainCustomerPassword" id="mainCustomerPassword" class="form-control m-input form-control-sm">
                                                        </div>
                                                    </div>

                                                    <div class="form-group m-form__group row">
                                                        <label for="exampleSelect1" class="col-sm-3 col-sm-3 col-form-label">{{__('contracts\vodafone\create.salutation')}}* </label>
                                                        <div class="col-sm-6 col-lg-6">
                                                            <select name="mainCustomerSalutation" class="form-control m-input form-control-sm" id="mainCustomerSalutation">
                                                                <option value=0>{{__('contracts\vodafone\create.pleaseSelect')}}</option>
                                                                <option value=1>{{__('contracts\vodafone\create.madam')}}</option>
                                                                <option value=2>{{__('contracts\vodafone\create.sir')}}</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group m-form__group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('contracts\vodafone\create.customerSurname')}}*</label>
                                                        <div class="col-xl-6 col-lg-6">
                                                            <input type="text" name="mainCustomerSurname" id="mainCustomerSurname" class="form-control m-input form-control-sm">
                                                        </div>
                                                    </div>

                                                    <div class="form-group m-form__group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('contracts\vodafone\create.customerName')}}*</label>
                                                        <div class="col-xl-6 col-lg-6">
                                                            <input type="text" name="mainCustomerName" id="mainCustomerName" class="form-control m-input form-control-sm">
                                                        </div>
                                                    </div>

                                                    <div class="form-group m-form__group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('contracts\vodafone\create.customerContactPerson')}}*</label>
                                                        <div class="col-xl-6 col-lg-6">
                                                            <input type="text" name="mainCustomerContactPerson" id="mainCustomerContactPerson" class="form-control m-input form-control-sm">
                                                        </div>
                                                    </div>

                                                    <div class="form-group m-form__group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('contracts\vodafone\create.birthData')}}</label>
                                                        <div class="col-xl-6 col-lg-6">
                                                            <input name="mainCustomerBirthDate" class="form-control m-input" type="date" value="" id="example-date-input">
                                                        </div>
                                                    </div>

                                                    <div class="form-group m-form__group row">
                                                        <label for="exampleSelect1" class="col-sm-3 col-sm-3 col-form-label">{{__('contracts\vodafone\create.customerIDType')}}* </label>
                                                        <div class="col-sm-6 col-lg-6">
                                                            <select name="mainCustomerIDCardType" class="form-control m-input form-control-sm" id="mainCustomerIDCardType">
                                                                <option value=0></option>
                                                                <option value=1>{{__('contracts\vodafone\create.personal')}}</option>
                                                                <option value=2>{{__('contracts\vodafone\create.foreign')}}</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group m-form__group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('contracts\vodafone\create.customerIDNumber')}}*</label>
                                                        <div class="col-xl-6 col-lg-6">
                                                            <input type="text" name="mainCustomerIDNumber" id="mainCustomerIDNumber" class="form-control m-input form-control-sm">
                                                        </div>
                                                    </div>

                                                </div>
                                                <!--end- Section For Private Customer -->

                                                <!--begin- Section For Business Customer -->
                                                <div class="sectionForBusinessCustomer">
                                                    <div class="m-separator m-separator--dashed m-separator--lg"></div>

                                                    <div class="form-group m-form__group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('contracts\vodafone\create.companyName')}}*</label>
                                                        <div class="col-xl-6 col-lg-6">
                                                            <input type="text" name="companyName" id="companyName" class="form-control m-input form-control-sm">
                                                        </div>
                                                    </div>

                                                    <div class="form-group m-form__group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('contracts\vodafone\create.companyContactPerson')}}*</label>
                                                        <div class="col-xl-6 col-lg-6">
                                                            <input type="text" name="companyContactPerson" id="companyContactPerson" class="form-control m-input form-control-sm">
                                                        </div>
                                                    </div>

                                                    <div class="form-group m-form__group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('contracts\vodafone\create.companyRegistrationNumber')}}*</label>
                                                        <div class="col-xl-6 col-lg-6">
                                                            <input type="text" name="companyRegistrationNumber" id="companyRegistrationNumber" class="form-control m-input form-control-sm">
                                                        </div>
                                                    </div>

                                                    <div class="form-group m-form__group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('contracts\vodafone\create.districtCourt')}}*</label>
                                                        <div class="col-xl-6 col-lg-6">
                                                            <input type="text" name="companyDistrictCourt" id="companyDistrictCourt" class="form-control m-input form-control-sm">
                                                        </div>
                                                    </div>

                                                    <div class="form-group m-form__group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('contracts\vodafone\create.executiveDirector')}}*</label>
                                                        <div class="col-xl-6 col-lg-6">
                                                            <input type="text" name="executiveDirector" id="executiveDirector" class="form-control m-input form-control-sm">
                                                        </div>
                                                    </div>

                                                    <div class="form-group m-form__group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('contracts\vodafone\create.foundingYear')}}*</label>
                                                        <div class="col-xl-6 col-lg-6">
                                                            <input type="text" name="foundingYear" id="foundingYear" class="form-control m-input form-control-sm">
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end- Section For Business Customer -->


                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end: Form Wizard Step 1-->

                                <!--begin: Form Wizard Step 2 - Address - -->
                                <div class="m-wizard__form-step" id="m_wizard_form_step_2">
                                    <div class="row">
                                        <div class="col-xl-8 offset-xl-2">
                                            <div class="m-form__section m-form__section--first">

                                                <div class="m-form__section m-form__section--first">
                                                    <div class="m-separator m-separator--dashed m-separator--lg"></div>

                                                    <div class="m-form__heading">
                                                        <h3 class="m-form__heading-title">{{__('contracts\vodafone\create.address')}}</h3>
                                                    </div>
                                                    <div class="form-group m-form__group row m--margin-top-10">
                                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('contracts\vodafone\create.streetAndNumber')}}*</label>
                                                        <div class="col-xl-4 col-lg-4">
                                                            <input type="text" name="mainCustomerStreet" id="mainCustomerStreet" class="form-control m-input form-control-sm">
                                                        </div>

                                                        <div class="col-xl-2 col-lg-2">
                                                            <input type="text" name="mainCustomerHouseNumber" id="mainCustomerHouseNumber" class="form-control m-input form-control-sm">
                                                        </div>
                                                    </div>

                                                    <div class="form-group m-form__group row ">
                                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('contracts\vodafone\create.cityAndPostalCode')}}*</label>
                                                        <div class="col-xl-4 col-lg-4">
                                                            <input type="text" name="mainCustomerCity" id="mainCustomerCity" class="form-control m-input form-control-sm">
                                                        </div>

                                                        <div class="col-xl-2 col-lg-2">
                                                            <input type="text" name="mainCustomerPostalCode" id="mainCustomerPostalCode" class="form-control m-input form-control-sm">
                                                        </div>
                                                    </div>

                                                    <div class="form-group m-form__group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('contracts\vodafone\create.email')}}*</label>
                                                        <div class="col-xl-6 col-lg-6">
                                                            <input type="text" name="mainCustomerEmail" id="mainCustomerEmail" class="form-control m-input form-control-sm">
                                                        </div>
                                                    </div>

                                                    <div class="form-group m-form__group row m--margin-top-5">
                                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('contracts\vodafone\create.emailConfirmation')}}*</label>
                                                        <div class="col-xl-6 col-lg-6">
                                                            <input type="text" name="mainCustomerEmailConfirmation" id="mainCustomerEmailConfirmation" class="form-control m-input form-control-sm">
                                                        </div>
                                                    </div>

                                                    <div class="form-group m-form__group row m--margin-top-5">
                                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('contracts\vodafone\create.telephone')}}*</label>
                                                        <div class="col-xl-6 col-lg-6">
                                                            <input type="text" name="mainCustomerTelephone" id="mainCustomerTelephone" class="form-control m-input form-control-sm">
                                                        </div>
                                                    </div>

                                                    <div class="form-group m-form__group row m--margin-top-5 ">
                                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('contracts\vodafone\create.fax')}}</label>
                                                        <div class="col-xl-6 col-lg-6">
                                                            <input type="text" name="mainCustomerFax" id="mainCustomerFax" class="form-control m-input form-control-sm">
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end: Form Wizard Step 2-->

                                <!--begin: Form Wizard Step 3 - Payment Methods - -->
                                <div class="m-wizard__form-step" id="m_wizard_form_step_3">
                                    <div class="row">
                                        <div class="col-xl-8 offset-xl-2">
                                            <div class="m-form__section m-form__section--first">

                                                <div class="m-form__heading">
                                                    <h3 class="m-form__heading-title">{{__('contracts\vodafone\create.bankDetails')}}</h3>
                                                </div>

                                                <div class="form-group m-form__group row m--margin-top-5">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">{{__('contracts\vodafone\create.differentAccountOwner')}}*</label>
                                                    <div class="col-xl-1 col-lg-1">
                                                        <span class="m-switch m-switch--sm m-switch--icon">
                                                            <label>
                                                                <input type="checkbox"  name="isAccountOwnerDifferent" id="isAccountOwnerDifferent">
                                                                <span></span>
                                                            </label>
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="form-group m-form__group row m--margin-top-5" id="accountOwnerDiv">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">{{__('contracts\vodafone\create.accountOwner')}}*</label>
                                                    <div class="col-xl-6 col-lg-6">
                                                        <input type="text" name="accountOwner" id="accountOwner" class="form-control m-input form-control-sm">
                                                    </div>
                                                </div>

                                                <div class="form-group m-form__group row m--margin-top-5">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">{{__('contracts\vodafone\create.IBAN')}}*</label>
                                                    <div class="col-xl-6 col-lg-6">
                                                        <input type="text" name="IBAN" id="IBAN" class="form-control m-input form-control-sm">
                                                    </div>
                                                </div>

                                                <div class="form-group m-form__group row m--margin-top-5 ">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">{{__('contracts\vodafone\create.BIC')}}</label>
                                                    <div class="col-xl-6 col-lg-6">
                                                        <input type="text" name="BIC" id="BIC" class="form-control m-input form-control-sm">
                                                    </div>
                                                </div>

                                                <div class="differentAccountOwnerAddressDiv">
                                                    <div class="form-group m-form__group row m--margin-top-5">
                                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('contracts\vodafone\create.differentAccountOwnerAddress')}}*</label>
                                                        <div class="col-xl-1 col-lg-1">
                                                        <span class="m-switch m-switch--sm m-switch--icon">
                                                            <label>
                                                                <input type="checkbox"  name="isAccountOwnerAddressDifferent" id="isAccountOwnerAddressDifferent" checked>
                                                                <span></span>
                                                            </label>
                                                        </span>
                                                        </div>
                                                    </div>
                                                    <div class="differentAccountOwnerAddress">
                                                        <div class="form-group m-form__group row m--margin-top-10">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">{{__('contracts\vodafone\create.streetAndNumber')}}*</label>
                                                            <div class="col-xl-4 col-lg-4">
                                                                <input type="text" name="differentAccountOwnerStreet" id="differentAccountOwnerStreet" class="form-control m-input form-control-sm">
                                                            </div>

                                                            <div class="col-xl-2 col-lg-2">
                                                                <input type="text" name="differentAccountOwnerHouseNumber" id="differentAccountOwnerHouseNumber" class="form-control m-input form-control-sm">
                                                            </div>
                                                        </div>

                                                        <div class="form-group m-form__group row ">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">{{__('contracts\vodafone\create.cityAndPostalCode')}}*</label>
                                                            <div class="col-xl-4 col-lg-4">
                                                                <input type="text" name="differentAccountOwnerCity" id="differentAccountOwnerCity" class="form-control m-input form-control-sm">
                                                            </div>

                                                            <div class="col-xl-2 col-lg-2">
                                                                <input type="text" name="differentAccountOwnerPostalCode" id="differentAccountOwnerPostalCode" class="form-control m-input form-control-sm">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>



                                                <div class="m-separator m-separator--dashed m-separator--lg"></div>

                                                <div class="m-form__heading">
                                                    <h3 class="m-form__heading-title">{{__('contracts\vodafone\create.bankCard')}}</h3>
                                                </div>
                                                <div class="form-group m-form__group row m--margin-top-10">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">{{__('contracts\vodafone\create.cardNumber')}}*</label>
                                                    <div class="col-xl-6 col-lg-6">
                                                        <input type="text" name="cardNumber" id="cardNumber" class="form-control m-input form-control-sm">
                                                    </div>

                                                </div>

                                                <div class="form-group m-form__group row ">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">{{__('contracts\vodafone\create.validToMonth')}}*</label>
                                                    <div class="col-xl-6 col-lg-6">
                                                        <input type="text" name="cardNumberValidToMonth" id="cardNumberValidToMonth" class="form-control m-input form-control-sm">
                                                    </div>

                                                </div>

                                                <div class="form-group m-form__group row ">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">{{__('contracts\vodafone\create.validToYear')}}*</label>
                                                    <div class="col-xl-6 col-lg-6">
                                                        <input type="text" name="cardNumberValidToYear" id="cardNumberValidToYear" class="form-control m-input form-control-sm">
                                                    </div>
                                                </div>

                                                <div class="form-group m-form__group row ">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">{{__('contracts\vodafone\create.creditInstitution')}}*</label>
                                                    <div class="col-xl-6 col-lg-6">
                                                        <input type="text" name="creditInstitution" id="creditInstitution" class="form-control m-input form-control-sm">
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end: Form Wizard Step 3-->

                                <!--begin: Form Wizard Step 4 - Contract Options - -->
                                <div class="m-wizard__form-step" id="m_wizard_form_step_4">
                                    <div class="row">
                                        <div class="col-xl-8 offset-xl-2">
                                            <div class="m-form__section m-form__section--first">

                                                <div class="m-form__heading">
                                                    <h3 class="m-form__heading-title">{{__('contracts\vodafone\create.contractOptions')}}</h3>
                                                </div>

                                                <!-- the below sections are transfered to "resources/views/contracts/vodafone/enterSimImeiServices.blade.php"
                                                <!--begin: Contract Start Date -->

                                                <!--end: Contract Start Date -->

                                                <!--begin: Connection fee -->

                                                <!--end: Connection fee -->

                                                <!--begin: Connection Overview -->

                                                <!--end: Connection Overview -->

                                                <!--begin: Destination number representation -->

                                                <!--end: Destination number representation -->



                                                <!--begin: invoiceType -->
                                                <div>
                                                    <div class="m-separator m-separator--dashed m-separator--lg"></div>
                                                    <div class="form-group m-form__group row">
                                                        <label class="col-sm-4 col-sm-4 col-form-label"><b>{{__('contracts\vodafone\create.invoiceType')}}</b></label>
                                                        <div class="col-sm-8 col-sm-8">
                                                            <div class="m-radio-list" id="invoiceTypes">
                                                                <label class="m-radio">
                                                                    <input type="radio" name="invoiceType" id="invoiceType" value=1 checked> {{__('contracts\vodafone\create.paperInvoice')}}
                                                                    <span></span>
                                                                </label>
                                                                <label class="m-radio">
                                                                    <input type="radio" name="invoiceType" id="invoiceType" value=2> {{__('contracts\vodafone\create.onlineInvoice')}}
                                                                    <span></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!--begin: invoiceType - Paper Invoice -->
                                                    <div class="paperInvoiceDiv">
                                                        <div class="col-xl-12 col-lg-12">
                                                            <label>
                                                            <span>
                                                                <small><b>{{__('contracts\vodafone\create.note')}}</b>: {{__('contracts\vodafone\create.contentOfNotePaperInvoice')}}</small>
                                                            </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <!--end: invoiceType - Paper Invoice -->

                                                    <!--begin: invoiceType - Online Invoice -->
                                                    <div class="onlineInvoiceDiv">
                                                        <div class="form-group m-form__group row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">{{__('contracts\vodafone\create.email')}}*</label>
                                                            <div class="col-xl-6 col-lg-6">
                                                                <input type="text" name="onlineInvoiceEmail" id="onlineInvoiceEmail" value="0@d2.de" class="form-control m-input form-control-sm">
                                                            </div>
                                                        </div>

                                                        <div class="form-group m-form__group row m--margin-top-5">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">{{__('contracts\vodafone\create.emailConfirmation')}}*</label>
                                                            <div class="col-xl-6 col-lg-6">
                                                                <input type="text" name="onlineInvoiceEmailConfirmation" id="onlineInvoiceEmailConfirmation" value="0@d2.de" class="form-control m-input form-control-sm">
                                                            </div>
                                                        </div>

                                                        <div class="form-group m-form__group row" id="notePaperInvoice">
                                                            <div class="col-xl-12 col-lg-12">
                                                                <label>
                                                            <span>
                                                                <small><b>{{__('contracts\vodafone\create.note')}}</b>: {{__('contracts\vodafone\create.contentOfNoteOnlineInvoice')}}</small>
                                                            </span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--end: invoiceType - Online Invoice -->
                                                </div>
                                                <!--end: invoiceType -->

                                                <!--begin: objection-advertising refusal (Widerspruch-Werbeverweigerung)-->
                                                <div>
                                                    <div class="m-separator m-separator--dashed m-separator--lg"></div>
                                                    <div class="form-group m-form__group row m--margin-top-5">

                                                        <div class="col-xl-1 col-lg-1">
                                                            <span class="m-switch m-switch--sm m-switch--icon">
                                                                <label>
                                                                    <input type="checkbox"  name="objection" id="objection">
                                                                    <span></span>
                                                                </label>
                                                            </span>
                                                        </div>
                                                        <label class="col-xl-6 col-lg-6 col-form-label">{{__('contracts\vodafone\create.objectionContent')}}</label>

                                                    </div>
                                                </div>
                                                <!--end: objection-advertising refusal (Widerspruch-Werbeverweigerung)-->

                                                <!--begin: home address -->
                                                <div class="m-separator m-separator--dashed m-separator--lg"></div>
                                                <div class="form-group m-form__group row m--margin-top-5">
                                                    <div class="col-xl-1 col-lg-1">
                                                            <span class="m-switch m-switch--sm m-switch--icon">
                                                                <label>
                                                                    <input type="checkbox"  name="homeAddress" id="homeAddress">
                                                                    <span></span>
                                                                </label>
                                                            </span>
                                                    </div>
                                                    <label class="col-xl-6 col-lg-6 col-form-label">{{__('contracts\vodafone\create.homeAddress')}}</label>
                                                </div>
                                                <div class="homeAddressDiv">
                                                    <div class="form-group m-form__group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('contracts\vodafone\create.streetAndNumber')}}*</label>
                                                        <div class="col-xl-4 col-lg-4">
                                                            <input type="text" name="homeAddressStreet" id="homeAddressStreet" class="form-control m-input form-control-sm">
                                                        </div>
                                                        <div class="col-xl-2 col-lg-2">
                                                            <input type="text" name="homeAddressHouseNumber" id="homeAddressHouseNumber" class="form-control m-input form-control-sm">
                                                        </div>
                                                    </div>

                                                    <div class="form-group m-form__group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('contracts\vodafone\create.cityAndPostalCode')}}*</label>
                                                        <div class="col-xl-4 col-lg-4">
                                                            <input type="text" name="homeAddressCity" id="homeAddressCity" class="form-control m-input form-control-sm">
                                                        </div>
                                                        <div class="col-xl-2 col-lg-2">
                                                            <input type="text" name="homeAddressPostalCode" id="homeAddressPostalCode" class="form-control m-input form-control-sm">
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end: home address -->

                                                <!--begin: different invoice address -->
                                                <div class="m-separator m-separator--dashed m-separator--lg"></div>
                                                <div class="form-group m-form__group row m--margin-top-5">
                                                    <div class="col-xl-1 col-lg-1">
                                                            <span class="m-switch m-switch--sm m-switch--icon">
                                                                <label>
                                                                    <input type="checkbox"  name="isInvoiceAddressDifferent" id="isInvoiceAddressDifferent">
                                                                    <span></span>
                                                                </label>
                                                            </span>
                                                    </div>
                                                    <label class="col-xl-6 col-lg-6 col-form-label">{{__('contracts\vodafone\create.differentInvoiceAddress')}}</label>
                                                </div>
                                                <div class="differentInvoiceAddress">
                                                    <div class="form-group m-form__group row">
                                                        <label for="exampleSelect1" class="col-sm-3 col-sm-3 col-form-label">{{__('contracts\vodafone\create.salutation')}}* </label>
                                                        <div class="col-sm-6 col-lg-6">
                                                            <select name="differentInvoiceAddressSalutation" class="form-control m-input form-control-sm" id="differentInvoiceAddressSalutation">
                                                                <option value=0>{{__('contracts\vodafone\create.pleaseSelect')}}</option>
                                                                <option value=1>{{__('contracts\vodafone\create.madam')}}</option>
                                                                <option value=2>{{__('contracts\vodafone\create.sir')}}</option>
                                                                <option value=3>{{__('contracts\vodafone\create.company')}}</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group m-form__group row" id="differentInvoiceAddressSurnameDiv">
                                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('contracts\vodafone\create.customerSurname')}}*</label>
                                                        <div class="col-xl-6 col-lg-6">
                                                            <input type="text" name="differentInvoiceAddressSurname" id="differentInvoiceAddressSurname" class="form-control m-input form-control-sm">
                                                        </div>
                                                    </div>

                                                    <div class="form-group m-form__group row" id="differentInvoiceAddressNameDiv">
                                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('contracts\vodafone\create.customerName')}}*</label>
                                                        <div class="col-xl-6 col-lg-6">
                                                            <input type="text" name="differentInvoiceAddressName" id="differentInvoiceAddressName" class="form-control m-input form-control-sm">
                                                        </div>
                                                    </div>

                                                    <div class="form-group m-form__group row" id="differentInvoiceAddressCompanyNameDiv">
                                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('contracts\vodafone\create.company')}}*</label>
                                                        <div class="col-xl-6 col-lg-6">
                                                            <input type="text" name="differentInvoiceAddressCompanyName" id="differentInvoiceAddressCompanyName" class="form-control m-input form-control-sm">
                                                        </div>
                                                    </div>

                                                    <div class="form-group m-form__group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('contracts\vodafone\create.customerContactPerson')}}*</label>
                                                        <div class="col-xl-6 col-lg-6">
                                                            <input type="text" name="differentInvoiceAddressContactPerson" id="differentInvoiceAddressContactPerson" class="form-control m-input form-control-sm">
                                                        </div>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('contracts\vodafone\create.streetAndNumber')}}*</label>
                                                        <div class="col-xl-4 col-lg-4">
                                                            <input type="text" name="differentInvoiceAddressStreet" id="differentInvoiceAddressStreet" class="form-control m-input form-control-sm">
                                                        </div>

                                                        <div class="col-xl-2 col-lg-2">
                                                            <input type="text" name="differentInvoiceAddressHouseNumber" id="differentInvoiceAddressHouseNumber" class="form-control m-input form-control-sm">
                                                        </div>
                                                    </div>

                                                    <div class="form-group m-form__group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('contracts\vodafone\create.cityAndPostalCode')}}*</label>
                                                        <div class="col-xl-4 col-lg-4">
                                                            <input type="text" name="differentInvoiceAddressCity" id="differentInvoiceAddressCity" class="form-control m-input form-control-sm">
                                                        </div>

                                                        <div class="col-xl-2 col-lg-2">
                                                            <input type="text" name="differentInvoiceAddressPostalCode" id="differentInvoiceAddressPostalCode" class="form-control m-input form-control-sm">
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end: different invoice address -->

                                                <!--begin: Disabled discount -->
                                                <div class="m-separator m-separator--dashed m-separator--lg"></div>
                                                <div class="form-group m-form__group row m--margin-top-5">
                                                    <div class="col-xl-1 col-lg-1">
                                                            <span class="m-switch m-switch--sm m-switch--icon">
                                                                <label>
                                                                    <input type="checkbox"  name="isDisabledDiscount" id="isDisabledDiscount">
                                                                    <span></span>
                                                                </label>
                                                            </span>
                                                    </div>
                                                    <label class="col-xl-6 col-lg-6 col-form-label">{{__('contracts\vodafone\create.disabledDiscount')}}</label>
                                                </div>
                                                <div class="disabledDiscount">
                                                    <div class="form-group m-form__group row" id="differentInvoiceAddressSurnameDiv">
                                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('contracts\vodafone\create.disabledPersonCardNumber')}}*</label>
                                                        <div class="col-xl-3 col-lg-3">
                                                            <input type="text" name="disabledPersonCardNumber" id="disabledPersonCardNumber" class="form-control m-input form-control-sm">
                                                        </div>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <label for="exampleSelect1" class="col-sm-3 col-sm-3 col-form-label">{{__('contracts\vodafone\create.disabilityDegree')}}* </label>
                                                        <div class="col-sm-3 col-lg-3">
                                                            <select name="disabilityDegree" class="form-control m-input form-control-sm" id="disabilityDegree">
                                                                <option value=50>50</option>
                                                                <option value=60>60</option>
                                                                <option value=70>70</option>
                                                                <option value=80>80</option>
                                                                <option value=90>90</option>
                                                                <option value=100>100</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end: Disabled discount -->

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end: Form Wizard Step 4-->

                                <!--begin: Form Wizard Step 5 - Tariff Options --->

                                <!--end: Form Wizard Step 5-->


                                <!--begin: Form Wizard Step X Confirmation-->
                                <div class="m-wizard__form-step" id="m_wizard_form_step_8">
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
                                                <div class="col-xl-8">
                                                    <div class="m-checkbox-inline">
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            <input type="checkbox" name="accept" value="1">
                                                            Click here to indicate that you have read and agree to the terms presented in the Terms and Conditions agreement
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 m--align-right">
                                                    <button type="submit" class="btn btn-brand">Submit</button>
                                                </div>
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
                    <!--end: Form Wizard -FORM- -->
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
    <script src="{{ asset('js/validations/contractVodafoneCreate.js')}}" type="text/javascript"></script>
    <script src="{{ asset('js/contractsVodafoneCreate-3.js')}}" type="text/javascript"></script>

    <script src="{{ asset('metronic/assets/app/js/dashboard.js')}}" type="text/javascript"></script>
    <script src="{{ asset('metronic/assets/demo/default/custom/crud/wizard/createDealerFormWizard.js')}}" type="text/javascript"></script>
    <script src="{{ asset('metronic/assets/demo/default/custom/crud/forms/widgets/bootstrap-datepicker.js')}}" type="text/javascript"></script>
    <script src="{{ asset('metronic/assets/demo/default/custom/components/portlets/tools.js')}}" type="text/javascript"></script>
    <!--end::Page Scripts -->
@endsection