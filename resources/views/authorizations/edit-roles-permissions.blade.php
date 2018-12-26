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
                            <li class="m-portlet__nav-item">
                                <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover" aria-expanded="true">
                                    <a href="#" class="m-portlet__nav-link btn btn-lg btn-secondary  m-btn m-btn--icon m-btn--icon-only m-btn--pill  m-dropdown__toggle">
                                        <i class="la la-ellipsis-h m--font-brand"></i>
                                    </a>
                                    <div class="m-dropdown__wrapper">
                                        <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                        <div class="m-dropdown__inner">
                                            <div class="m-dropdown__body">
                                                <div class="m-dropdown__content">
                                                    <ul class="m-nav">
                                                        <li class="m-nav__section m-nav__section--first">
                                                            <span class="m-nav__section-text">Quick Actions</span>
                                                        </li>
                                                        <li class="m-nav__item">
                                                            <a href="" class="m-nav__link">
                                                                <i class="m-nav__link-icon flaticon-share"></i>
                                                                <span class="m-nav__link-text">Create Post</span>
                                                            </a>
                                                        </li>
                                                        <li class="m-nav__item">
                                                            <a href="" class="m-nav__link">
                                                                <i class="m-nav__link-icon flaticon-chat-1"></i>
                                                                <span class="m-nav__link-text">Send Messages</span>
                                                            </a>
                                                        </li>
                                                        <li class="m-nav__item">
                                                            <a href="" class="m-nav__link">
                                                                <i class="m-nav__link-icon flaticon-multimedia-2"></i>
                                                                <span class="m-nav__link-text">Upload File</span>
                                                            </a>
                                                        </li>
                                                        <li class="m-nav__section">
                                                            <span class="m-nav__section-text">Useful Links</span>
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
                                                        <li class="m-nav__separator m-nav__separator--fit m--hide">
                                                        </li>
                                                        <li class="m-nav__item m--hide">
                                                            <a href="#" class="btn btn-outline-danger m-btn m-btn--pill m-btn--wide btn-sm">Submit</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">

                    <!--BEGIN: Datatable -->
                    <table class="table table-striped- table-bordered table-hover table-checkable" id="">
                        <thead>
                        <tr>
                            <th>{{__('authorizations\edit-roles-permissions.systemFeatures')}}</th>
                            <th>{{__('authorizations\edit-roles-permissions.role1')}}</th>
                            <th>{{__('authorizations\edit-roles-permissions.role2')}}</th>
                            <th>{{__('authorizations\edit-roles-permissions.role3')}}</th>
                            <th>{{__('authorizations\edit-roles-permissions.role4')}}</th>
                            <th>{{__('authorizations\edit-roles-permissions.role5')}}</th>
                            <th>{{__('authorizations\edit-roles-permissions.role6')}}</th>
                            <th>{{__('authorizations\edit-roles-permissions.action')}}</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($rolesAuthorizations as $rolesAuthorization)
                            <form method="post" action="/edit-roles-permissions/store/{{$rolesAuthorization->systemFeature->id}}" class="m-form m-form--fit m-form--label-align-right">
                                @csrf
                            <tr>
                                <td>{{__('authorizations\edit-roles-permissions.'.$rolesAuthorization->systemFeature->lang_key_for_feature)}}</td>
                                <td>
                                            <span class="m-switch m-switch--outline m-switch--icon m-switch--warning">
                                                <label>
                                                    <input type="checkbox"  @if($rolesAuthorization->permission_of_role1 == 1) checked="checked" @endif name="action[{{$rolesAuthorization->systemFeature->id}}][1]">
                                                    <span></span>
                                                </label>
                                            </span>
                                </td>

                                <td>
                                            <span class="m-switch m-switch--outline m-switch--icon m-switch--warning">
                                                <label>
                                                    <input type="checkbox"  @if($rolesAuthorization->permission_of_role2 == 1) checked="checked" @endif name="action[{{$rolesAuthorization->systemFeature->id}}][2]">
                                                    <span></span>
                                                </label>
                                            </span>
                                </td>

                                <td>
                                            <span class="m-switch m-switch--outline m-switch--icon m-switch--warning">
                                                <label>
                                                    <input type="checkbox"  @if($rolesAuthorization->permission_of_role3 == 1) checked="checked" @endif name="action[{{$rolesAuthorization->systemFeature->id}}][3]">
                                                    <span></span>
                                                </label>
                                            </span>
                                </td>

                                <td>
                                            <span class="m-switch m-switch--outline m-switch--icon m-switch--warning">
                                                <label>
                                                    <input type="checkbox"  @if($rolesAuthorization->permission_of_role4 == 1) checked="checked" @endif name="action[{{$rolesAuthorization->systemFeature->id}}][4]">
                                                    <span></span>
                                                </label>
                                            </span>
                                </td>

                                <td>
                                            <span class="m-switch m-switch--outline m-switch--icon m-switch--warning">
                                                <label>
                                                    <input type="checkbox"  @if($rolesAuthorization->permission_of_role5 == 1) checked="checked" @endif name="action[{{$rolesAuthorization->systemFeature->id}}][5]">
                                                    <span></span>
                                                </label>
                                            </span>
                                </td>

                                <td>
                                            <span class="m-switch m-switch--outline m-switch--icon m-switch--warning">
                                                <label>
                                                    <input type="checkbox"  @if($rolesAuthorization->permission_of_role6 == 1) checked="checked" @endif name="action[{{$rolesAuthorization->systemFeature->id}}][6]">
                                                    <span></span>
                                                </label>
                                            </span>
                                </td>

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