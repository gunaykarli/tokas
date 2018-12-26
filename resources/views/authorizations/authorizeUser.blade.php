@extends ('partials.master')

@section ('content')

    <!-- BEGIN: Main Content "stays right before 'Subheader' section and rigth after 'END: Left Aside' section of the original html files'"-->
    <!--begin::Section-->
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <div class="m-content">
            <div class="m-portlet m-portlet--mobile">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                {{__('authorizations\edit-roles-permissions.rolesAndPermissions')}}
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">
                                @can('create', \App\Office::class)
                                    <a  href="/systemfeatureandauthorization/create"  class="btn btn-info m-btn m-btn--custom m-btn--icon m-btn--air">
                                             <span>
                                                <i class="la la-plus"></i><span>{{__('authorizations\edit-roles-permissions.newSystemFeatureAndPermissions')}}</span>
                                             </span>

                                    </a>
                                @endcan
                            </li>
                            <li class="m-portlet__nav-item"></li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">

                    <!--BEGIN: Datatable -->
                    <table class="table table-striped- table-bordered table-hover table-checkable" id="">
                        <thead>
                        <tr>
                            <th>{{__('authorizations\edit-roles-permissions.systemFeatures')}}</th>
                            @foreach($employees as $employee)
                                <th>{{$employee->surname}}</th>
                            @endforeach


                        </tr>
                        </thead>
                        <tbody>
                        @foreach($authorizationsForRole4NotRole5 as $authorizationForRole4NotRole5)
                            <form method="post" action="/authorizeUser/store/{{$authorizationForRole4NotRole5->system_feature_id}}" class="m-form m-form--fit m-form--label-align-right">
                                @csrf
                            <tr>
                                <td>{{__('authorizations\authorizeUser.'.$authorizationForRole4NotRole5->systemFeature->lang_key_for_feature)}}</td>

                            @foreach($employees as $employee)
                                    <td>
                                        <span class="m-switch m-switch--outline m-switch--icon m-switch--warning">
                                            <label>
                                                <input type="checkbox"
                                                            @foreach($employeesAuthorizations as $employeesAuthorization)
                                                                @if(($employeesAuthorization->user_id == $employee->id) && ($authorizationForRole4NotRole5->system_feature_id == $employeesAuthorization->system_feature_id))
                                                                    checked="checked"
                                                                @endif
                                                            @endforeach
                                                       name="action[{{$authorizationForRole4NotRole5->system_feature_id}}][{{$employee->id}}]">
                                                <span></span>
                                            </label>
                                        </span>
                                    </td>
                            @endforeach
                                <td>
                                    <button id="" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn">{{__('authorizations\edit-roles-permissions.update')}}</button>&nbsp;&nbsp;
                                </td>
                            </tr>
                            </form>>
                        @endforeach

                        </tbody>
                    </table>
                    <!--END: Datatable -->
                </div>
            </div>
        </div>
    <!-- END: Main Content -->
    </div>

@endsection

@section ('pageVendorsAndScripts')
    <!--begin::Page Vendors -->
    <script src="{{ asset('metronic/assets/vendors/custom/fullcalendar/fullcalendar.bundle.js')}}" type="text/javascript"></script>
    <!--end::Page Vendors -->

    <!--begin::Page Scripts -->
    <script src="{{ asset('metronic/assets/app/js/dashboard.js')}}" type="text/javascript"></script>

    <!--end::Page Scripts -->
@endsection