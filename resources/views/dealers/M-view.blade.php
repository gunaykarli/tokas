@extends ('partials.master')

@section ('content')

    <!-- BEGIN: Main Content "stays right before 'Subheader' section and rigth after 'END: Left Aside' section of the original html files'"-->
    <div class="m-grid__item m-grid__item--fluid m-wrapper">

        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title m-subheader__title--separator">Dealers</h3>
                    <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                        <li class="m-nav__item m-nav__item--home">
                            <a href="/home" class="m-nav__link m-nav__link--icon">
                                <i class="m-nav__link-icon la la-home"></i>
                            </a>
                        </li>
                        <li class="m-nav__separator">-</li>
                        <li class="m-nav__item">
                            <a href="" class="m-nav__link">
                                <span class="m-nav__link-text">Metronic Wizard</span>
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
                                Show Dealer
                                <small>Dealer</small>
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

                <!--begin::Section-->
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
                                <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_form_confirm_3" role="tab">3. Main Office Address</a>
                            </li>
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_form_confirm_4" role="tab">4. Member Codes</a>
                            </li>
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_form_confirm_5" role="tab">5. Bank Account</a>
                            </li>
                        </ul>
                        <div class="tab-content m--margin-top-40">
                            <div class="tab-pane active" id="m_form_confirm_1" role="tabpanel">
                                <div class="m-form__section m-form__section--first">
                                    <div class="form-group m-form__group m-form__group--sm row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">Name:</label>
                                        <div class="col-xl-9 col-lg-9">
                                            <span class="m-form__control-static">{{$dealer->name}}</span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group m-form__group--sm row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">Owner:</label>
                                        <div class="col-xl-9 col-lg-9">
                                            <span class="m-form__control-static">{{strtoupper($dealer->owner_surname)}} {{' '}}{{$dealer->owner_name}}</span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group m-form__group--sm row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">Type:</label>
                                        <div class="col-xl-9 col-lg-9">
                                            <span class="m-form__control-static">{{$dealer->type}}</span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group m-form__group--sm row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">Status</label>
                                        <div class="col-xl-9 col-lg-9">
                                            <span class="m-form__control-static">{{$dealer->status}}</span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group m-form__group--sm row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">Category:</label>
                                        <div class="col-xl-9 col-lg-9">
                                            <span class="m-form__control-static">{{$dealer->category_id}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-separator m-separator--dashed m-separator--lg"></div>
                            </div>
                            <div class="tab-pane" id="m_form_confirm_2" role="tabpanel">
                                <div class="m-form__section m-form__section--first">
                                    <div class="form-group m-form__group m-form__group--sm row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">Main Office Name:</label>
                                        <div class="col-xl-9 col-lg-9">
                                            <span class="m-form__control-static">{{$mainOffice->name}}</span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group m-form__group--sm row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">Contact Person:</label>
                                        <div class="col-xl-9 col-lg-9">
                                            <span class="m-form__control-static">{{strtoupper($mainOffice->contact_person_surname)}} {{' '}} {{$mainOffice->contact_person_name}}</span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group m-form__group--sm row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">Email:</label>
                                        <div class="col-xl-9 col-lg-9">
                                            <span class="m-form__control-static">{{$mainOffice->email}}</span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group m-form__group--sm row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">Phone:</label>
                                        <div class="col-xl-9 col-lg-9">
                                            <span class="m-form__control-static">{{$mainOffice->phone}}</span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group m-form__group--sm row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">Mobile:</label>
                                        <div class="col-xl-9 col-lg-9">
                                            <span class="m-form__control-static">{{$mainOffice->mobile}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-separator m-separator--dashed m-separator--lg"></div>
                            </div>
                            <div class="tab-pane" id="m_form_confirm_3" role="tabpanel">
                                <div class="m-form__section m-form__section--first">
                                    <div class="form-group m-form__group m-form__group--sm row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">Street:</label>
                                        <div class="col-xl-9 col-lg-9">
                                            <span class="m-form__control-static">{{$mainOfficeAddress->street_address}}</span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group m-form__group--sm row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">P.O. Box:</label>
                                        <div class="col-xl-9 col-lg-9">
                                            <span class="m-form__control-static">{{$mainOfficeAddress->PO_box}}</span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group m-form__group--sm row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">City:</label>
                                        <div class="col-xl-9 col-lg-9">
                                            <span class="m-form__control-static">{{$mainOfficeAddress->city}}</span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group m-form__group--sm row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">State:</label>
                                        <div class="col-xl-9 col-lg-9">
                                            <span class="m-form__control-static">{{$mainOfficeAddress->state}}</span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group m-form__group--sm row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">Country:</label>
                                        <div class="col-xl-9 col-lg-9">
                                            <span class="m-form__control-static">{{$mainOfficeAddress->country}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-separator m-separator--dashed m-separator--lg"></div>
                            </div>
                            <div class="tab-pane" id="m_form_confirm_4" role="tabpanel">
                                <div class="m-form__section m-form__section--first">
                                    <div class="m-form__section">
                                        <div class="form-group m-form__group m-form__group--sm row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">Vodafone UVP:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <span class="m-form__control-static">{{$memberCodes->vodafone_UVP}}</span>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group m-form__group--sm row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">Vodafone GVO:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <span class="m-form__control-static">{{$memberCodes->vodafone_GVO}}</span>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group m-form__group--sm row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">Vodafone DSL UVP:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <span class="m-form__control-static">{{$memberCodes->vodafone_DSL_UVP}}</span>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group m-form__group--sm row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">Mobilcom Debitel UVP:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <span class="m-form__control-static">{{$memberCodes->mobilcom_debitel_UVP}}</span>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group m-form__group--sm row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">Energie User:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <span class="m-form__control-static">{{$memberCodes->energie_user}}</span>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group m-form__group--sm row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">Yourfone UVP:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <span class="m-form__control-static">{{$memberCodes->yourfone_UVP}}</span>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group m-form__group--sm row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">Ay Yıldız UVP:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <span class="m-form__control-static">{{$memberCodes->ayyildiz_UVP}}</span>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group m-form__group--sm row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">Blau UVP:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <span class="m-form__control-static">{{$memberCodes->blau_UVP}}</span>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group m-form__group--sm row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">Otelo Neu:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <span class="m-form__control-static">{{$memberCodes->otelo_neu}}</span>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group m-form__group--sm row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">Otelo Alt:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <span class="m-form__control-static">{{$memberCodes->otelo_alt}}</span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="m_form_confirm_5" role="tabpanel">
                                <div class="m-form__section m-form__section--first">
                                    <div class="m-form__section">
                                        <div class="form-group m-form__group m-form__group--sm row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">Bank Account:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <span class="m-form__control-static">{{$bankAccount->IBAN}}</span>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group m-form__group--sm row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">Cash Deposit:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <span class="m-form__control-static">{{$bankAccount->cash_deposit}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!--end::Section-->


                    </div>
                </div>
                <!--end::Section-->

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
    <script src="{{ asset('metronic/assets/app/js/dashboard.js')}}" type="text/javascript"></script>
    <script src="{{ asset('metronic/assets/demo/default/custom/crud/wizard/createDealerFormWizard.js')}}" type="text/javascript"></script>
    <script src="{{ asset('metronic/assets/demo/default/custom/crud/forms/widgets/bootstrap-datepicker.js')}}" type="text/javascript"></script>
    <!--end::Page Scripts -->
@endsection