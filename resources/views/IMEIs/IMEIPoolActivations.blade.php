@extends ('partials.master')

@section ('content')

    <!-- BEGIN: Main Content "stays right before 'Subheader' section and rigth after 'END: Left Aside' section of the original html files'"-->
    <div class="m-grid__item m-grid__item--fluid m-wrapper">

        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title m-subheader__title--separator">{{__('IMEIs/IMEIPoolActivations.IMEIPool')}}</h3>
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
                                {{__('IMEIs/IMEIPoolActivations.IMEIPoolActivations')}}
                            </h3>
                        </div>
                    </div>
                </div>

                    <!--BEGIN: IMEI Setup Form -->

                    <form method="Post" action="/IMEIs/IMEI-pool-status-change" class="m-form m-form--fit m-form--label-align-right">
                        @csrf
                        <div class="m-portlet__body">
                            <div class="row">
                                <div class="col-xl-8 offset-xl-2">
                                    <div class="m-form__section m-form__section--first">

                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">{{__('IMEIs/IMEIPoolActivations.status')}}</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <span class="m-switch m-switch--outline m-switch--icon m-switch--warning">
                                                    <label>
                                                        <input type="checkbox"
                                                               @if($systemVariablesIMEI->where('name', 'isIMEIPoolActive')->where('value', 1)->first())
                                                                    checked="checked"
                                                               @endif
                                                               name="isIMEIPoolActive"
                                                        >
                                                        <span></span>
                                                    </label>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">{{__('IMEIs/IMEIPoolActivations.validFrom')}}</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <input name="validFrom" class="form-control m-input" type="date"
                                                       value="{{$systemVariablesIMEI->where('name', 'IMEIPoolActiveFrom')->first()->value}}"
                                                       id="example-date-input"
                                                >
                                            </div>
                                        </div>

                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">{{__('IMEIs/IMEIPoolActivations.validTo')}}</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <input name="validTo" class="form-control m-input" type="date"
                                                       value="{{$systemVariablesIMEI->where('name', 'IMEIPoolActiveTo')->first()->value}}"
                                                       id="example-date-input"
                                                >
                                            </div>
                                        </div>

                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">{{__('IMEIs/IMEIPoolActivations.fieldsActivationInGUI')}}</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <span class="m-switch m-switch--outline m-switch--icon m-switch--warning">
                                                    <label>
                                                        <input type="checkbox"
                                                               @if($systemVariablesIMEI->where('name', 'isIMEIFieldActive')->where('value', 1)->first())
                                                                    checked="checked"
                                                               @endif
                                                               name="isIMEIFieldActive"
                                                        >
                                                        <span></span>
                                                    </label>
                                                </span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__foot m-portlet__foot--fit">
                            <div class="m-form__actions">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                    <!--END: IMEI Setup Form -->
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
