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
                                {{__('tariffs/index.tariffs')}}
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

                        </ul>
                    </div>
                </div>

                <div class="m-portlet__body" id="general">
                    <!-- When new contract and XML are created successfully...
                    forwarded from ContractController@forwardToFinalize-->
                    @if(session()->has('messageContractFinalised'))
                        <div class="form-group m-form__group">
                            <div class="alert alert-success">
                                {{__('tariffs/providers.'. session()->get('messageContractFinalised'))}}
                            </div>
                        </div>
                    @endif
                    <table width="100%" border="0" valign="top" align="left">
                        <tr>
                            <!-- /tariff/index/{{1}}/{{0}} : 1 stand for providerID, 0 is the value of $isAdditionalTariff -->
                            <td align="center" valign="top"><a href="/tariff/index/{{1}}/{{0}}"><img src="{{ asset('media/images/vfAus.png')}}" style="width: 89px;" border="0" /></a></td>

                            <td align="center" valign="top"><a href="/tariff/index/2"><img src="{{ asset('media/images/ayYildizAus.png')}}" style="width: 89px;" border="0" /></a></td>

                            <td align="center" valign="top"><a href="/tariff/index/3"><img src="{{ asset('media/images/oteloAus.png')}}" style="width: 89px;" border="0" /></a></td>
                        </tr>
                    </table>

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
