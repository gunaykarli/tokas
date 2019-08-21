@extends ('partials.master')

@section ('content')

    <!-- BEGIN: Main Content "stays right before 'Subheader' section and rigth after 'END: Left Aside' section of the original html files'"-->
    <div class="m-grid__item m-grid__item--fluid m-wrapper">

        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title m-subheader__title--separator">Pagination Options Examples</h3>
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

        <div class="m-content">
            <div class="m-portlet m-portlet--mobile">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                {{__('tariffs/onTop.onTop')}}
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">
                                <a href="#" class="btn btn-info m-btn m-btn--custom m-btn--icon m-btn--air">
                                    <span>
                                        <i class="la la-plus"></i>
                                        <span> {{__('tariffs/onTop.onTop')}}</span>
                                    </span>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item"></li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">

                    @if(session()->has('updateMessage'))
                        <div class="form-group m-form__group">
                            <div class="alert alert-success">
                                {{__('lawTexts/index.'.session()->get('updateMessage'))}}
                            </div>
                        </div>
                    @endif

                    <!--begin: on-top -->
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
                    <!--end: on-top -->
                </div>
            </div>

            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
    <!-- END: Main Content -->

@endsection

@section ('pageVendorsAndScripts')
    <!--begin::Page Vendors -->
    <script src="{{ asset('metronic/assets/vendors/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script>
    <!--end::Page Vendors -->

    <!--begin::Page Scripts-->
    <script src="{{ asset('js/ontop.js')}}" type="text/javascript"></script>
    <script src="{{ asset('metronic/assets/demo/default/custom/crud/datatables/basic/paginations2.js')}}" type="text/javascript"></script>
    <!--end::Page Scripts-->
@endsection