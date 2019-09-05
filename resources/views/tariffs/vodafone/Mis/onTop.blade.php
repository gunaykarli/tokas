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
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                {{__('tariffs\vodafone\create.createTariff')}}
                                <small> {{__('tariffs\vodafone\create.createTariff')}}</small>
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
                                            {{__('tariffs\vodafone\create.tariff')}}
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
                                            {{__('tariffs\vodafone\create.properties')}}
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
                                            {{__('tariffs\vodafone\create.highlight')}}
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
                                            {{__('tariffs\vodafone\create.plausibility')}}
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
                                            {{__('tariffs\vodafone\create.service')}}
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
                        <form method="POST" action="/tariff/vodafone/on-top/store/"  class="m-form m-form--label-align-left- m-form--state-" id="m_form">
                        @csrf

                            <!--begin: on-top -->
                                <!--tariff and dealer dependencies, menu -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="m-form__section m-form__section--first">
                                            <div class="m-form__section m-form__section--first">
                                                <div class="m-form__heading">
                                                    <h3 class="m-form__heading-title">{{__('tariffs\vodafone\onTop.tariffDependency')}}</h3>
                                                </div>

                                                <div class="on-top-tariff-dependency">
                                                    <div class="m-radio-list">
                                                        <label class="m-radio m-radio--success">
                                                            <input type="radio" name="ontopTariffDependency"  value="1"> {{__('tariffs\vodafone\onTop.forAllTariffs')}}
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <div class="m-radio-list">
                                                        <label class="m-radio m-radio--success">
                                                            <input type="radio" name="ontopTariffDependency" value="2"> {{__('tariffs\vodafone\onTop.forParticularGroup')}}
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <div class="m-radio-list">
                                                        <label class="m-radio m-radio--success">
                                                            <input type="radio" name="ontopTariffDependency" value="3"> {{__('tariffs\vodafone\onTop.forCertainTariffs')}}
                                                            <span></span>
                                                        </label>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="m-form__section m-form__section--first">
                                            <div class="m-form__heading">
                                                <h3 class="m-form__heading-title">{{__('tariffs\vodafone\create.dealerDependency')}}</h3>
                                            </div>

                                            <div class="on-top-dealer-dependency">
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

                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <!--amount and submit button -->
                                <div class="m-separator m-separator--dashed m-separator--lg"></div>
                                <div class="on-top-amount">
                                    <div class="m-form__group form-group row">
                                        <label class="col-md-2" align="right">{{__('tariffs\vodafone\onTop.onTop')}}: </label>
                                        <div class="col-md-4">
                                            <input type="text" name="ontopAmount" id="ontopAmount" class="form-control m-input">
                                        </div>
                                        <div class="col-md-4">
                                            <button type="submit" class="btn btn-brand">{{__('tariffs\vodafone\onTop.submit')}}</button>
                                        </div>
                                    </div>
                                    <div class="m-separator m-separator--dashed m-separator--lg"></div>
                                </div>

                                <!--tariff and dealer dependencies, details -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="m-form__section m-form__section--first">
                                            <div class="m-form__section m-form__section--first">

                                                <div class="on-top-groups">
                                                    <label>{{__('tariffs\vodafone\onTop.groups')}}</label>
                                                    <div class="m-form__group form-group">
                                                        <div class="m-checkbox-list">
                                                            @foreach($provider->tariffsGroups as $group)
                                                                <label class="m-checkbox m-checkbox--solid m-checkbox--success">
                                                                    <input type="checkbox" name="ontopCheckboxOfGroups[{{$group->id}}]"> {{$group->name}}
                                                                    <span></span>
                                                                </label>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <div class="m-separator m-separator--dashed m-separator--lg"></div>
                                                </div>

                                                <div class="on-top-tariffs">
                                                    <label>{{__('tariffs\vodafone\onTop.tariffs')}}</label>
                                                    <div class="m-form__group form-group">
                                                        <div class="m-accordion m-accordion--default" id="m_accordion_1" role="tablist">
                                                            @foreach($provider->tariffsGroups as $group)
                                                                <div class="m-accordion__item">
                                                                    <div class="m-accordion__item-head collapsed" role="tab" id="m_accordion_1_item_{{$group->id}}_head" data-toggle="collapse" href="#m_accordion_1_item_{{$group->id}}_body" aria-expanded="false">
                                                                        <span class="m-accordion__item-icon"><i class="fa  flaticon-placeholder"></i></span>
                                                                        <span class="m-accordion__item-title">{{$group->name}}</span>
                                                                        <span class="m-accordion__item-mode"></span>
                                                                    </div>
                                                                    <div class="m-accordion__item-body collapse" id="m_accordion_1_item_{{$group->id}}_body" class=" " role="tabpanel" aria-labelledby="m_accordion_1_item_{{$group->id}}_head" data-parent="#m_accordion_1">
                                                                        <div class="m-accordion__item-content">

                                                                            <div class="m-form__group form-group">
                                                                                <div class="m-checkbox-list">
                                                                                    @foreach($vodafoneTariffs as $vodafoneTariff)
                                                                                        @if($group->name == "Aktionstarife")
                                                                                            @if($vodafoneTariff->action_tariff == 1)
                                                                                                <label class="m-checkbox m-checkbox--success">
                                                                                                    <input type="checkbox" name="tariffsWithOnTop[]" value="{{$vodafoneTariff->code}}"> {{$vodafoneTariff->name}}
                                                                                                    <span></span>
                                                                                                </label>
                                                                                            @endif
                                                                                        @elseif($vodafoneTariff->group_id == $group->id)
                                                                                            <label class="m-checkbox m-checkbox--success">
                                                                                                <input type="checkbox" name="tariffsWithOnTop[]" value="{{$vodafoneTariff->code}}"> {{$vodafoneTariff->name}}
                                                                                                <span></span>
                                                                                            </label>
                                                                                        @endif
                                                                                    @endforeach
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <div class="m-separator m-separator--dashed m-separator--lg"></div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="m-form__section m-form__section--first">

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

                                        </div>
                                    </div>
                                </div>
                                <!--end: on-top -->


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
    <script src="{{ asset('js/isLimited1.js')}}" type="text/javascript"></script>
    <script src="{{ asset('js/ontop.js')}}" type="text/javascript"></script>
    <script src="{{ asset('js/tariffVodafoneCreate.js')}}" type="text/javascript"></script>

    <script src="{{ asset('metronic/assets/app/js/dashboard.js')}}" type="text/javascript"></script>
    <script src="{{ asset('metronic/assets/demo/default/custom/crud/wizard/createDealerFormWizard.js')}}" type="text/javascript"></script>
    <script src="{{ asset('metronic/assets/demo/default/custom/crud/forms/widgets/bootstrap-datepicker.js')}}" type="text/javascript"></script>
    <!--end::Page Scripts -->
@endsection