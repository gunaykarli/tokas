@extends ('partials.master')

@section ('content')

    <!-- BEGIN: Main Content "stays right before 'Subheader' section and rigth after 'END: Left Aside' section of the original html files'"-->
    <!--begin::Portlet-->
    <div class="m-portlet">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
												<span class="m-portlet__head-icon m--hide">
													<i class="la la-gear"></i>
												</span>
                    <h3 class="m-portlet__head-text" >
                        {{__('authorizations\authorizeUser.authorizeUser')}}
                    </h3>
                </div>
            </div>
        </div>

        <!--begin::Form-->
        <form method="post" action="/authorizeuser/store" class="m-form m-form--fit m-form--label-align-center">
            @csrf
            <div class="m-portlet__body">
                <div class="form-group m-form__group">
                    <select class="form-group m-form__group" name="employeeID" >
                        @foreach($employees as $employee)
                            <option value={{$employee->id}}>{{$employee->name}} {{' '}} {{$employee->surname}}</option>
                        @endforeach
                    </select>
                </div>

                <span class="m-section__sub" align="center">{{__('authorizations\authorizeUser.systemFeature')}}</span>
                <div class="m-section__content">
                    <div class="m-demo" data-code-preview="true" data-code-html="true" data-code-js="false">
                        <div class="m-demo__preview" align="center">

                            <!--begin::Form-->
                            @foreach($rolesAuthorizations as $rolesAuthorization)
                                <div class="m-form__group form-group row">
                                    <label class="col-6 col-form-label">{{__('authorizations\authorizeUser.'.$rolesAuthorization->systemFeature->lang_key_for_feature)}}</label>
                                    <div class="col-6">
                                        <span class="m-switch m-switch--outline m-switch--icon m-switch--warning">
                                            <label>
                                                <input type="checkbox"  name="action[{{$rolesAuthorization->systemFeature->id}}]">
                                                <span></span>
                                            </label>
                                        </span>
                                    </div>
                                </div>
                            @endforeach

                        <!--end::Form-->
                        </div>
                    </div>
                </div>


            </div>
            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions m-form__actions">
                    <div class="row">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-6" align="center">
                            <button type="submit" class="btn btn-success" >{{__('authorizations\authorizeUser.submit')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!--end::Form-->
    </div>

    <!--end::Portlet-->    <!-- END: Main Content -->

@endsection

@section ('pageVendorsAndScripts')
    <!--begin::Page Vendors -->
    <script src="{{ asset('metronic/assets/vendors/custom/fullcalendar/fullcalendar.bundle.js')}}" type="text/javascript"></script>
    <!--end::Page Vendors -->

    <!--begin::Page Scripts -->
    <script src="{{ asset('metronic/assets/app/js/dashboard.js')}}" type="text/javascript"></script>
    <!--end::Page Scripts -->
@endsection