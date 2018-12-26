@extends ('partials.master')

@section ('content')

    <!-- BEGIN: Main Content "stays right before 'Subheader' section and rigth after 'END: Left Aside' section of the original html files'"-->
    <div class="m-grid m-grid--hor m-grid--root m-page">
        <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signup m-login--2 m-login-2--skin-2" id="m_login" style="background-image: url({{ asset('assets/app/media/img/bg/bg-3.jpg')}});">
            <div class="m-grid__item m-grid__item--fluid	m-login__wrapper">
                <div class="m-login__container">
                    <div class="m-login__signin">

                        <div class="m-login__head">
                            <h3 class="m-login__title">{{__('authorizations\createSysFeatureAndAuthorizeRoles.newSystemFeatureAndPermissions')}}</h3>
                        </div>
                        <form class="m-login__form m-form" action="">
                            <div class="form-group m-form__group">
                                <input class="form-control m-input" type="text" placeholder="Email" name="email" autocomplete="off">
                            </div>
                            <div class="form-group m-form__group">
                                <input class="form-control m-input m-login__form-input--last" type="password" placeholder="Password" name="password">
                            </div>
                            <div class="row m-login__form-sub">
                                <div class="col m--align-left m-login__form-left">
                                    <label class="m-checkbox  m-checkbox--focus">
                                        <input type="checkbox" name="remember"> Remember me
                                        <span></span>
                                    </label>
                                </div>
                                <div class="col m--align-right m-login__form-right">
                                    <a href="javascript:;" id="m_login_forget_password" class="m-link">Forget Password ?</a>
                                </div>
                            </div>
                            <div class="m-login__form-action">
                                <button id="m_login_signin_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">Sign In</button>
                            </div>
                        </form>
                    </div>
                    <div class="m-log__signup">
                        <!--begin::Form-->
                        <form method="post" action="/systemfeatureandauthorization/store" class="m-form m-form--fit m-form--label-align-right">
                            @csrf
                            <div class="m-portlet m-portlet--tab">
                                <div class="m-portlet__head">
                                    <div class="m-portlet__head-caption">
                                        <div class="m-portlet__head-title">
                                            <span class="m-portlet__head-icon m--hide"><i class="la la-gear"></i></span>
                                            <h3 class="m-portlet__head-text">
                                                {{__('authorizations\createSysFeatureAndAuthorizeRoles.newSystemFeatureAndPermissions')}}
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-portlet__body">
                                    <div class="form-group m-form__group">
                                        <input type="text" name="model" class="form-control m-input m-input--air m-input--pill" placeholder={{__('authorizations\createSysFeatureAndAuthorizeRoles.model')}} >
                                    </div>
                                    <div class="form-group m-form__group">
                                        <input type="text" name="action" class="form-control m-input m-input--air m-input--pill" placeholder={{__('authorizations\createSysFeatureAndAuthorizeRoles.action')}} >
                                    </div>


                                    <!--begin::Portlet-->
                                    <div class="m-portlet">
                                        <div class="m-portlet__head">
                                            <div class="m-portlet__head-caption">
                                                <div class="m-portlet__head-title">
                                                    <h3 class="m-portlet__head-text">
                                                        {{__('authorizations\createSysFeatureAndAuthorizeRoles.assignPermission')}}
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-portlet__body">

                                            <!--begin::Section-->
                                            <div class="m-section">
                                                <div class="m-section__content">
                                                    <table class="table table-bordered table-hover">
                                                        <thead>
                                                        <tr>
                                                            <th>{{__('authorizations\createSysFeatureAndAuthorizeRoles.roles')}}</th>
                                                            <th>{{__('authorizations\createSysFeatureAndAuthorizeRoles.permissions')}}</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>{{__('authorizations\createSysFeatureAndAuthorizeRoles.systemAdmin')}}</td>
                                                                <td>
                                                                    <span class="m-switch m-switch--outline m-switch--icon m-switch--warning">
																		<label>
																			<input type="checkbox" checked="checked" name="permissionRole1">
																			<span></span>
																		</label>
																	</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{__('authorizations\createSysFeatureAndAuthorizeRoles.powerUserInToker')}}</td>
                                                                <td>
                                                                    <span class="m-switch m-switch--outline m-switch--icon m-switch--warning">
																		<label>
																			<input type="checkbox" checked="checked" name="permissionRole2">
																			<span></span>
																		</label>
																	</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{__('authorizations\createSysFeatureAndAuthorizeRoles.userInToker')}}</td>
                                                                <td>
                                                                    <span class="m-switch m-switch--outline m-switch--icon m-switch--warning">
																		<label>
																			<input type="checkbox" name="permissionRole3">
																			<span></span>
																		</label>
																	</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{__('authorizations\createSysFeatureAndAuthorizeRoles.powerUserInDealer')}}</td>
                                                                <td>
                                                                    <span class="m-switch m-switch--outline m-switch--icon m-switch--warning">
																		<label>
																			<input type="checkbox" name="permissionRole4">
																			<span></span>
																		</label>
																	</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{__('authorizations\createSysFeatureAndAuthorizeRoles.userInDealer')}}</td>
                                                                <td>
                                                                    <span class="m-switch m-switch--outline m-switch--icon m-switch--warning">
																		<label>
																			<input type="checkbox" name="permissionRole5">
																			<span></span>
																		</label>
																	</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{__('authorizations\createSysFeatureAndAuthorizeRoles.guest')}}</td>
                                                                <td>
                                                                    <span class="m-switch m-switch--outline m-switch--icon m-switch--warning">
																		<label>
																			<input type="checkbox"  name="permissionRole6">
																			<span></span>
																		</label>
																	</span></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <!--end::Section-->
                                        </div>

                                        <!--end::Form-->
                                    </div>

                                    <!--end::Portlet-->

                                    <div class="form-group m-form__group" align="center">
                                        <button id="m_login_signup_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn">{{__('authorizations\createSysFeatureAndAuthorizeRoles.submit')}}</button>&nbsp;&nbsp;
                                    </div>

                                </div>


                            </div>
                        </form>

                        <!--end::Form-->
                    </div>
                    <div class="m-login__account">
							<span class="m-login__account-msg">
								Don't have an account yet ?
							</span>&nbsp;&nbsp;
                        <a href="javascript:;" id="m_login_signup" class="m-link m-link--light m-login__account-link">Sign Up</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Main Content -->

@endsection

@section ('pageVendorsAndScripts')
    <!--begin::Page Vendors -->
    <script src="{{ asset('metronic/assets/vendors/custom/fullcalendar/fullcalendar.bundle.js')}}" type="text/javascript"></script>
    <!--end::Page Vendors -->

    <!--begin::Page Scripts -->
    <script src="{{ asset('metronic/assets/app/js/dashboard.js')}}" type="text/javascript"></script>
    <script src="{{ asset('metronic/assets/snippets/custom/pages/user/login2.js')}}" type="text/javascript"></script>
    <!--end::Page Scripts -->
@endsection