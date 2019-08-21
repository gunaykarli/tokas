@extends ('partials.master')

@section ('content')

    <!-- BEGIN: Main Content "stays right before 'Subheader' section and rigth after 'END: Left Aside' section of the original html files'"-->
    <div class="m-grid__item m-grid__item--fluid m-wrapper">


        <!-- BEGIN: Content -->
        <div class="m-content">
            <div class="m-portlet m-portlet--mobile">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                <!-- define hidden field for provider id which is used in js/tariffListWithFilter.js -->

                                <input type="radio" name="providerID" id="providerID" value={{$provider->id}} checked>{{$provider->name}} {{__('tariffs/index.tariffs')}}
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">
                                <!-- Only authorized users who are "Admin and power user in Toker" can generate new dealer...-->
                                @can('create', \App\Dealer::class)
                                    <a  href="/dealer/create"  class="btn btn-success m-btn m-btn--custom m-btn--icon m-btn--air">
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

                    @if(session()->has('message'))
                        <div class="form-group m-form__group">
                            <div class="alert alert-success">
                                {{__('lawTexts/create.'.session()->get('message'))}}
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="/tariff/vodafone/base-price-setup/store-for-tariffs" class="m-form m-form--label-align-left- m-form--state-" id="m_form">
                    {{csrf_field()}}

                        <!--BEGIN:List of the tariffs groups of the selected providers -->
                        <div class="m-form__group form-group">
                            <label>{{__('tariffs/index.groups')}}</label>

                            <div class="m-radio-inline" id="radioInLineGroups">
                                <label class="m-radio">
                                    <input type="radio" name="tariffGroup" id="tariffGroup" value=0 checked> {{__('tariffs/index.all')}}
                                    <span></span>
                                </label>
                                @foreach($tariffGroups as $tariffGroup)
                                    <label class="m-radio">
                                        <input type="radio" name="tariffGroup" id="tariffGroup" value={{$tariffGroup->id}}> {{$tariffGroup->name}}
                                        <span></span>
                                    </label>
                                @endforeach

                            </div>
                        </div>
                        <div class="m-separator m-separator--dashed m-separator--lg"></div>
                        <!--END:List of the tariffs groups of the selected providers -->

                        <!--BEGIN: Datatable -->
                        <table class="table table-striped- table-bordered table-hover table-checkable" >
                            <thead>
                            <tr>
                                <th> {{__('tariffs/vodafone/basePriceSetup.name')}}</th>
                                <th> {{__('tariffs/vodafone/basePriceSetup.basePrice')}}</th>
                                <th> {{__('tariffs/vodafone/basePriceSetup.basePriceInput')}}</th>

                            </tr>
                            </thead>
                            <tbody id="tableBody">

                            @foreach ($tariffs as $tariff)
                                <tr>
                                    <td>{{$tariff->name}}</td>
                                    <td>{{$tariff->base_price}}</td>
                                    <td> <input type="text" name="newBasePrices[{{$tariff->id}}]"> </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                        <!--END: Datatable -->


                        <div class="form-group m-form__group row"  >
                            <div class="m-form__actions col-xl-12 col-lg-12" align="center">
                                <button type="submit" class="btn btn-primary">{{__('tariffs/vodafone/basePriceSetup.save')}}</button>
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
    <script src="{{ asset('js/basePriceSetup.js')}}" type="text/javascript"></script>
    <!--end::Page Scripts-->
@endsection
