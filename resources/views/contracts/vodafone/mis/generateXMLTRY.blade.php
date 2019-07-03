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

            <!--begin::Portlet-->
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
												<span class="m-portlet__head-icon">
													<i class="flaticon-multimedia"></i>
												</span>
                            <h3 class="m-portlet__head-text">
                                {{__('contracts/vodafone/finalize.finalizeContract')}}
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">

                    <!--BEGIN: Datatable -->
                    <table class="table table-striped- table-bordered table-hover table-checkable" >
                        <thead>
                        <tr>
                            <th> {{__('contracts/vodafone/finalize.network')}}</th>
                            <th> {{__('contracts/vodafone/finalize.tariffName')}}</th>
                            <th> {{__('contracts/vodafone/finalize.basePrice')}}</th>
                            <th> {{__('contracts/vodafone/finalize.provision')}}</th>

                        </tr>
                        </thead>
                        <tbody id="">
                        <tr>
                            <th> VF </th>
                            <th> VF-Tarif 1 </th>
                            <th> 50</th>
                            <th> 500</th>

                        </tr>
                        </tbody>
                    </table>

                    <!--END: Datatable -->

                </div>
                <div class="m-portlet__foot">

                    <div class="form-group m-form__group row m--margin-top-5">

                        <div class="col-xl-2 col-lg-2 m--align-right">
                            <a href="#" class="btn btn-brand" ><span>{{__('contracts/vodafone/finalize.print')}}</span>&nbsp;&nbsp;</a>
                        </div>
                        <label class="col-xl-6 col-lg-6 col-form-label">{{__('contracts/vodafone/finalize.warningForPrint')}}</label>

                    </div>

                    <div class="m-separator m-separator--dashed m-separator--lg"></div>
                    <div class="form-group m-form__group row m--margin-top-5">

                        <div class="col-xl-2 col-lg-2 m--align-right">
                            <span class="m-switch m-switch--outline m-switch--icon m-switch--success">
                                <label>
                                    <input type="checkbox"  name="isContractReadyToFinalize" id="isContractReadyToFinalize">
                                    <span></span>
                                </label>
                            </span>
                        </div>
                        <label class="col-xl-6 col-lg-6 col-form-label">{{__('contracts/vodafone/finalize.warningForActivation')}}</label>

                    </div>

                    <div class="form-group m-form__group row m--margin-top-5" id="finalizeContractDiv">
                        <div class="m-separator m-separator--dashed m-separator--lg"></div>
                        <div class="col-xl-2 col-lg-2 m--align-right" id="finalizeButtonDiv">
                            <form method="POST" action="/contract/forward-to-generateXML" class="m-form m-form--label-align-left- m-form--state-" >
                                @csrf
                                <input type="hidden" name="contractID" value=129>
                                <button type="submit" class="btn btn-brand">{{__('contracts/vodafone/finalize.activate')}}</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>

            <!--end::Portlet-->
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
        <!-- END: Content -->
    </div>
    <!-- END: Main Content -->

@endsection


@section ('pageVendorsAndScripts')
    <!--begin::Page Vendors -->
    <script src="{{ asset('js/contractsVodafoneFinalize.js')}}" type="text/javascript"></script>
    <!--end::Page Vendors -->

    <!--begin::Page Scripts-->
    <script src="{{ asset('js/tariffListWithFilter.js')}}" type="text/javascript"></script>
    <!--end::Page Scripts-->
@endsection
