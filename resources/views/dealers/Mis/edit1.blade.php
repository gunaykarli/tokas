@extends ('partials.master')

@section ('content')

    <!-- BEGIN: Main Content "stays right before 'Subheader' section and rigth after 'END: Left Aside' section of the original html files'"-->
    <div class="m-grid__item m-grid__item--fluid m-wrapper">

        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title m-subheader__title--separator">Provider Management</h3>
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
                                Provider Registration
                                <small>Provider Registration</small>
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

                <!--begin: Form Wizard-->
                <div class="m-wizard m-wizard--2 m-wizard--success" id="m_wizard">

                    <!--begin: Message container -->
                    <div class="m-portlet__padding-x">

                        <!-- Here you can put a message or alert -->
                    </div>

                    <!--end: Message container -->

                    <!--begin: Form Wizard Head -->
                    <div class="m-wizard__head m-portlet__padding-x">

                        <!--begin: Form Wizard Progress -->
                        <div class="m-wizard__progress">
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <!--end: Form Wizard Progress -->

                        <!--begin: Form Wizard Nav -->
                        <div class="m-wizard__nav">
                            <div class="m-wizard__steps">
                                <div class="m-wizard__step m-wizard__step--current" m-wizard-target="m_wizard_form_step_1">
                                    <a href="#" class="m-wizard__step-number">
                                        <span><i class="fa  flaticon-placeholder"></i></span>
                                    </a>
                                    <div class="m-wizard__step-info">
                                        <div class="m-wizard__step-title">
                                            1. General Info
                                        </div>
                                        <div class="m-wizard__step-desc">

                                        </div>
                                    </div>
                                </div>
                                <div class="m-wizard__step" m-wizard-target="m_wizard_form_step_2">
                                    <a href="#" class="m-wizard__step-number">
                                        <span><i class="fa  flaticon-layers"></i></span>
                                    </a>
                                    <div class="m-wizard__step-info">
                                        <div class="m-wizard__step-title">
                                            2. Address
                                        </div>
                                        <div class="m-wizard__step-desc">

                                        </div>
                                    </div>
                                </div>
                                <div class="m-wizard__step" m-wizard-target="m_wizard_form_step_3">
                                    <a href="#" class="m-wizard__step-number">
                                        <span><i class="fa  flaticon-layers"></i></span>
                                    </a>
                                    <div class="m-wizard__step-info">
                                        <div class="m-wizard__step-title">
                                            3. Member Codes
                                        </div>
                                        <div class="m-wizard__step-desc">

                                        </div>
                                    </div>
                                </div>
                                <div class="m-wizard__step" m-wizard-target="m_wizard_form_step_4">
                                    <a href="#" class="m-wizard__step-number">
                                        <span><i class="fa  flaticon-layers"></i></span>
                                    </a>
                                    <div class="m-wizard__step-info">
                                        <div class="m-wizard__step-title">
                                            4. Bank Account
                                        </div>
                                        <div class="m-wizard__step-desc">

                                        </div>
                                    </div>
                                </div>
                                <!-- this section is removed from edit operation. It will be operated in user managemen section

                                <div class="m-wizard__step" m-wizard-target="m_wizard_form_step_5">
                                    <a href="#" class="m-wizard__step-number">
                                        <span><i class="fa  flaticon-layers"></i></span>
                                    </a>
                                    <div class="m-wizard__step-info">
                                        <div class="m-wizard__step-title">
                                            5. Admin Account
                                        </div>
                                        <div class="m-wizard__step-desc">

                                        </div>
                                    </div>
                                </div>

                                -->
                                <div class="m-wizard__step" m-wizard-target="m_wizard_form_step_5">
                                    <a href="#" class="m-wizard__step-number">
                                        <span><i class="fa  flaticon-layers"></i></span>
                                    </a>
                                    <div class="m-wizard__step-info">
                                        <div class="m-wizard__step-title">
                                            5. Confirmation
                                        </div>
                                        <div class="m-wizard__step-desc">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end: Form Wizard Nav -->

                    </div>
                    <!--end: Form Wizard Head -->

                    <!--begin: Form Wizard Form-->
                    <div class="m-wizard__form">

                        <!--
                            1) Use m-form--label-align-left class to alight the form input labels to the right
                            2) Use m-form--state class to highlight input control borders on form validation
                        -->


                        <div class="m-separator m-separator--dashed m-separator--lg"></div>
                        <!--begin: Form -->
                        <form method="POST" action="/dealer/update/{{$dealer->id}}" class="m-form m-form--label-align-left- m-form--state-" id="m_form">
                            @csrf
                            <!--begin: Form Body -->
                            <div class="m-portlet__body">

                                <!--begin: Form Wizard Step 1-->
                                <div class="m-wizard__form-step m-wizard__form-step--current" id="m_wizard_form_step_1">
                                    <div class="row">
                                        <div class="col-xl-8 offset-xl-2">
                                            <div class="m-form__section m-form__section--first">
                                                <div class="m-form__heading">
                                                    <h3 class="m-form__heading-title">Client Details</h3>
                                                </div>

                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">* Dealer Name:</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <input type="text" name="name" class="form-control m-input" placeholder="" value={{$dealer->name}}>
                                                    </div>
                                                </div>

                                                <div class="form-group m-form__group row">
                                                    <label for="exampleSelect1" class="col-xl-3 col-lg-3 col-form-label">* Type:</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <select name="type" class="form-control m-input" id="exampleSelect1" >
                                                            <option value="1">Handler</option>
                                                            <option value="2">2</option>
                                                            <option value="3">3</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label" for="exampleSelect2">* Category:</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <select name="categoryID" class="form-control m-input" id="exampleSelect2">
                                                            <option value="1">1</option>
                                                            <option value="2">2</option>
                                                            <option value="3">3</option>
                                                            <option value="4">4</option>
                                                            <option value="5" selected>5</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label" for="exampleSelect2">Date:</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <input class="form-control m-input" type="date" id="example-date-input" name="date" value={{$dealer->date}}>
                                                    </div>
                                                </div>

                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">* Owner Name</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend"><span class="input-group-text"><i class="la la-phone"></i></span></div>
                                                            <input type="text" name="ownerName" class="form-control m-input" placeholder="" value={{$dealer->owner_name}}>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">* Owner Surname</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend"><span class="input-group-text"><i class="la la-phone"></i></span></div>
                                                            <input type="text" name="ownerSurname" class="form-control m-input" placeholder="" value={{$dealer->owner_surname}}>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!--
                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label" for="exampleInputEmail1">* Email</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <div class="input-group m-input-group">
                                                            <div class="input-group-prepend"><span class="input-group-text">@</span></div>
                                                            <input type="email" name="email" class="form-control m-input" placeholder="Email" aria-describedby="basic-addon1" value={{$dealer->email}}>
                                                        </div>
                                                    </div>
                                                </div>
                                                -->

                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">* Status:</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <span class="m-switch m-switch--sm m-switch--icon">
                                                            <label>
                                                                <input type="checkbox" checked="checked" name="status">
                                                                <span></span>
                                                            </label>
                                                        </span>
                                                    </div>
                                                </div>

                                            </div>


                                        </div>
                                    </div>
                                </div>
                                <!--end: Form Wizard Step 1-->

                                <!--begin: Form Wizard Step 2-->
                                <div class="m-wizard__form-step" id="m_wizard_form_step_2">
                                    <div class="row">
                                        <div class="col-xl-8 offset-xl-2">
                                            <div class="m-form__section m-form__section--first">
                                                <div class="m-form__heading">
                                                    <h3 class="m-form__heading-title">Main Office Address</h3>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">* Address Line :</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <input type="text" name="streetAddress" class="form-control m-input" placeholder="" value={{$address->street_address}} >
                                                    </div>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">P.O. box:</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <input type="text" name="POBox" class="form-control m-input" placeholder="" value={{$address->PO_box}}>
                                                    </div>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">Postal Code:</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <input type="text" name="postalCode" class="form-control m-input" placeholder="" value={{$address->postal_code}}>
                                                    </div>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">* City:</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <input type="text" name="city" class="form-control m-input" placeholder="" value={{$address->city}}>
                                                    </div>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">* State:</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <input type="text" name="state" class="form-control m-input" placeholder="" value={{$address->state}}>
                                                    </div>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">* Country:</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <select name="country" class="form-control m-input">
                                                            <option value="">Select</option>
                                                            <option value="AF">Afghanistan</option>
                                                            <option value="AX">Åland Islands</option>
                                                            <option value="AL">Albania</option>
                                                            <option value="DZ">Algeria</option>
                                                            <option value="AS">American Samoa</option>
                                                            <option value="AD">Andorra</option>
                                                            <option value="AO">Angola</option>
                                                            <option value="AI">Anguilla</option>
                                                            <option value="AQ">Antarctica</option>
                                                            <option value="AG">Antigua and Barbuda</option>
                                                            <option value="AR">Argentina</option>
                                                            <option value="AM">Armenia</option>
                                                            <option value="AW">Aruba</option>
                                                            <option value="AU">Australia</option>
                                                            <option value="AT">Austria</option>
                                                            <option value="AZ">Azerbaijan</option>
                                                            <option value="BS">Bahamas</option>
                                                            <option value="BH">Bahrain</option>
                                                            <option value="BD">Bangladesh</option>
                                                            <option value="BB">Barbados</option>
                                                            <option value="BY">Belarus</option>
                                                            <option value="BE">Belgium</option>
                                                            <option value="BZ">Belize</option>
                                                            <option value="BJ">Benin</option>
                                                            <option value="BM">Bermuda</option>
                                                            <option value="BT">Bhutan</option>
                                                            <option value="BO">Bolivia, Plurinational State of</option>
                                                            <option value="BQ">Bonaire, Sint Eustatius and Saba</option>
                                                            <option value="BA">Bosnia and Herzegovina</option>
                                                            <option value="BW">Botswana</option>
                                                            <option value="BV">Bouvet Island</option>
                                                            <option value="BR">Brazil</option>
                                                            <option value="IO">British Indian Ocean Territory</option>
                                                            <option value="BN">Brunei Darussalam</option>
                                                            <option value="BG">Bulgaria</option>
                                                            <option value="BF">Burkina Faso</option>
                                                            <option value="BI">Burundi</option>
                                                            <option value="KH">Cambodia</option>
                                                            <option value="CM">Cameroon</option>
                                                            <option value="CA">Canada</option>
                                                            <option value="CV">Cape Verde</option>
                                                            <option value="KY">Cayman Islands</option>
                                                            <option value="CF">Central African Republic</option>
                                                            <option value="TD">Chad</option>
                                                            <option value="CL">Chile</option>
                                                            <option value="CN">China</option>
                                                            <option value="CX">Christmas Island</option>
                                                            <option value="CC">Cocos (Keeling) Islands</option>
                                                            <option value="CO">Colombia</option>
                                                            <option value="KM">Comoros</option>
                                                            <option value="CG">Congo</option>
                                                            <option value="CD">Congo, the Democratic Republic of the</option>
                                                            <option value="CK">Cook Islands</option>
                                                            <option value="CR">Costa Rica</option>
                                                            <option value="CI">Côte d'Ivoire</option>
                                                            <option value="HR">Croatia</option>
                                                            <option value="CU">Cuba</option>
                                                            <option value="CW">Curaçao</option>
                                                            <option value="CY">Cyprus</option>
                                                            <option value="CZ">Czech Republic</option>
                                                            <option value="DK">Denmark</option>
                                                            <option value="DJ">Djibouti</option>
                                                            <option value="DM">Dominica</option>
                                                            <option value="DO">Dominican Republic</option>
                                                            <option value="EC">Ecuador</option>
                                                            <option value="EG">Egypt</option>
                                                            <option value="SV">El Salvador</option>
                                                            <option value="GQ">Equatorial Guinea</option>
                                                            <option value="ER">Eritrea</option>
                                                            <option value="EE">Estonia</option>
                                                            <option value="ET">Ethiopia</option>
                                                            <option value="FK">Falkland Islands (Malvinas)</option>
                                                            <option value="FO">Faroe Islands</option>
                                                            <option value="FJ">Fiji</option>
                                                            <option value="FI">Finland</option>
                                                            <option value="FR">France</option>
                                                            <option value="GF">French Guiana</option>
                                                            <option value="PF">French Polynesia</option>
                                                            <option value="TF">French Southern Territories</option>
                                                            <option value="GA">Gabon</option>
                                                            <option value="GM">Gambia</option>
                                                            <option value="GE">Georgia</option>
                                                            <option value="DE" selected>Germany</option>
                                                            <option value="GH">Ghana</option>
                                                            <option value="GI">Gibraltar</option>
                                                            <option value="GR">Greece</option>
                                                            <option value="GL">Greenland</option>
                                                            <option value="GD">Grenada</option>
                                                            <option value="GP">Guadeloupe</option>
                                                            <option value="GU">Guam</option>
                                                            <option value="GT">Guatemala</option>
                                                            <option value="GG">Guernsey</option>
                                                            <option value="GN">Guinea</option>
                                                            <option value="GW">Guinea-Bissau</option>
                                                            <option value="GY">Guyana</option>
                                                            <option value="HT">Haiti</option>
                                                            <option value="HM">Heard Island and McDonald Islands</option>
                                                            <option value="VA">Holy See (Vatican City State)</option>
                                                            <option value="HN">Honduras</option>
                                                            <option value="HK">Hong Kong</option>
                                                            <option value="HU">Hungary</option>
                                                            <option value="IS">Iceland</option>
                                                            <option value="IN">India</option>
                                                            <option value="ID">Indonesia</option>
                                                            <option value="IR">Iran, Islamic Republic of</option>
                                                            <option value="IQ">Iraq</option>
                                                            <option value="IE">Ireland</option>
                                                            <option value="IM">Isle of Man</option>
                                                            <option value="IL">Israel</option>
                                                            <option value="IT">Italy</option>
                                                            <option value="JM">Jamaica</option>
                                                            <option value="JP">Japan</option>
                                                            <option value="JE">Jersey</option>
                                                            <option value="JO">Jordan</option>
                                                            <option value="KZ">Kazakhstan</option>
                                                            <option value="KE">Kenya</option>
                                                            <option value="KI">Kiribati</option>
                                                            <option value="KP">Korea, Democratic People's Republic of</option>
                                                            <option value="KR">Korea, Republic of</option>
                                                            <option value="KW">Kuwait</option>
                                                            <option value="KG">Kyrgyzstan</option>
                                                            <option value="LA">Lao People's Democratic Republic</option>
                                                            <option value="LV">Latvia</option>
                                                            <option value="LB">Lebanon</option>
                                                            <option value="LS">Lesotho</option>
                                                            <option value="LR">Liberia</option>
                                                            <option value="LY">Libya</option>
                                                            <option value="LI">Liechtenstein</option>
                                                            <option value="LT">Lithuania</option>
                                                            <option value="LU">Luxembourg</option>
                                                            <option value="MO">Macao</option>
                                                            <option value="MK">Macedonia, the former Yugoslav Republic of</option>
                                                            <option value="MG">Madagascar</option>
                                                            <option value="MW">Malawi</option>
                                                            <option value="MY">Malaysia</option>
                                                            <option value="MV">Maldives</option>
                                                            <option value="ML">Mali</option>
                                                            <option value="MT">Malta</option>
                                                            <option value="MH">Marshall Islands</option>
                                                            <option value="MQ">Martinique</option>
                                                            <option value="MR">Mauritania</option>
                                                            <option value="MU">Mauritius</option>
                                                            <option value="YT">Mayotte</option>
                                                            <option value="MX">Mexico</option>
                                                            <option value="FM">Micronesia, Federated States of</option>
                                                            <option value="MD">Moldova, Republic of</option>
                                                            <option value="MC">Monaco</option>
                                                            <option value="MN">Mongolia</option>
                                                            <option value="ME">Montenegro</option>
                                                            <option value="MS">Montserrat</option>
                                                            <option value="MA">Morocco</option>
                                                            <option value="MZ">Mozambique</option>
                                                            <option value="MM">Myanmar</option>
                                                            <option value="NA">Namibia</option>
                                                            <option value="NR">Nauru</option>
                                                            <option value="NP">Nepal</option>
                                                            <option value="NL">Netherlands</option>
                                                            <option value="NC">New Caledonia</option>
                                                            <option value="NZ">New Zealand</option>
                                                            <option value="NI">Nicaragua</option>
                                                            <option value="NE">Niger</option>
                                                            <option value="NG">Nigeria</option>
                                                            <option value="NU">Niue</option>
                                                            <option value="NF">Norfolk Island</option>
                                                            <option value="MP">Northern Mariana Islands</option>
                                                            <option value="NO">Norway</option>
                                                            <option value="OM">Oman</option>
                                                            <option value="PK">Pakistan</option>
                                                            <option value="PW">Palau</option>
                                                            <option value="PS">Palestinian Territory, Occupied</option>
                                                            <option value="PA">Panama</option>
                                                            <option value="PG">Papua New Guinea</option>
                                                            <option value="PY">Paraguay</option>
                                                            <option value="PE">Peru</option>
                                                            <option value="PH">Philippines</option>
                                                            <option value="PN">Pitcairn</option>
                                                            <option value="PL">Poland</option>
                                                            <option value="PT">Portugal</option>
                                                            <option value="PR">Puerto Rico</option>
                                                            <option value="QA">Qatar</option>
                                                            <option value="RE">Réunion</option>
                                                            <option value="RO">Romania</option>
                                                            <option value="RU">Russian Federation</option>
                                                            <option value="RW">Rwanda</option>
                                                            <option value="BL">Saint Barthélemy</option>
                                                            <option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>
                                                            <option value="KN">Saint Kitts and Nevis</option>
                                                            <option value="LC">Saint Lucia</option>
                                                            <option value="MF">Saint Martin (French part)</option>
                                                            <option value="PM">Saint Pierre and Miquelon</option>
                                                            <option value="VC">Saint Vincent and the Grenadines</option>
                                                            <option value="WS">Samoa</option>
                                                            <option value="SM">San Marino</option>
                                                            <option value="ST">Sao Tome and Principe</option>
                                                            <option value="SA">Saudi Arabia</option>
                                                            <option value="SN">Senegal</option>
                                                            <option value="RS">Serbia</option>
                                                            <option value="SC">Seychelles</option>
                                                            <option value="SL">Sierra Leone</option>
                                                            <option value="SG">Singapore</option>
                                                            <option value="SX">Sint Maarten (Dutch part)</option>
                                                            <option value="SK">Slovakia</option>
                                                            <option value="SI">Slovenia</option>
                                                            <option value="SB">Solomon Islands</option>
                                                            <option value="SO">Somalia</option>
                                                            <option value="ZA">South Africa</option>
                                                            <option value="GS">South Georgia and the South Sandwich Islands</option>
                                                            <option value="SS">South Sudan</option>
                                                            <option value="ES">Spain</option>
                                                            <option value="LK">Sri Lanka</option>
                                                            <option value="SD">Sudan</option>
                                                            <option value="SR">Suriname</option>
                                                            <option value="SJ">Svalbard and Jan Mayen</option>
                                                            <option value="SZ">Swaziland</option>
                                                            <option value="SE">Sweden</option>
                                                            <option value="CH">Switzerland</option>
                                                            <option value="SY">Syrian Arab Republic</option>
                                                            <option value="TW">Taiwan, Province of China</option>
                                                            <option value="TJ">Tajikistan</option>
                                                            <option value="TZ">Tanzania, United Republic of</option>
                                                            <option value="TH">Thailand</option>
                                                            <option value="TL">Timor-Leste</option>
                                                            <option value="TG">Togo</option>
                                                            <option value="TK">Tokelau</option>
                                                            <option value="TO">Tonga</option>
                                                            <option value="TT">Trinidad and Tobago</option>
                                                            <option value="TN">Tunisia</option>
                                                            <option value="TR">Turkey</option>
                                                            <option value="TM">Turkmenistan</option>
                                                            <option value="TC">Turks and Caicos Islands</option>
                                                            <option value="TV">Tuvalu</option>
                                                            <option value="UG">Uganda</option>
                                                            <option value="UA">Ukraine</option>
                                                            <option value="AE">United Arab Emirates</option>
                                                            <option value="GB">United Kingdom</option>
                                                            <option value="US">United States</option>
                                                            <option value="UM">United States Minor Outlying Islands</option>
                                                            <option value="UY">Uruguay</option>
                                                            <option value="UZ">Uzbekistan</option>
                                                            <option value="VU">Vanuatu</option>
                                                            <option value="VE">Venezuela, Bolivarian Republic of</option>
                                                            <option value="VN">Viet Nam</option>
                                                            <option value="VG">Virgin Islands, British</option>
                                                            <option value="VI">Virgin Islands, U.S.</option>
                                                            <option value="WF">Wallis and Futuna</option>
                                                            <option value="EH">Western Sahara</option>
                                                            <option value="YE">Yemen</option>
                                                            <option value="ZM">Zambia</option>
                                                            <option value="ZW">Zimbabwe</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end: Form Wizard Step 2-->

                                <!--begin: Form Wizard Step 3-->
                                <div class="m-wizard__form-step" id="m_wizard_form_step_3">
                                    <div class="row">
                                        <div class="col-xl-8 offset-xl-2">
                                            <div class="m-form__section m-form__section--first">
                                                <div class="m-form__heading">
                                                    <h3 class="m-form__heading-title">Member Codes</h3>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">Vodafone UVP:</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <input type="text" name="vodafoneUVP" class="form-control m-input" placeholder="" value={{$memberCodes->vodafone_UVP}} >
                                                    </div>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">Vodafone GVO:</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <input type="text" name="vodafoneGVO" class="form-control m-input" placeholder="" value={{$memberCodes->vodafone_GVO}}>
                                                    </div>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">Vodafone DSL UVP:</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <input type="text" name="vodafoneDSLUVP" class="form-control m-input" placeholder="" value={{$memberCodes->vodafone_DSL_UVP}}>
                                                    </div>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">Mobilcom Debitel UVP:</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <input type="text" name="mobilcomDebitelUVP" class="form-control m-input" placeholder="" value={{$memberCodes->mobilcom_debitel_UVP}} >
                                                    </div>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">Energie User:</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <input type="text" name="energieUser" class="form-control m-input" placeholder="" value={{$memberCodes->energie_user}}>
                                                    </div>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">Yourfone UVP:</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <input type="text" name="yourfoneUVP" class="form-control m-input" placeholder="" value={{$memberCodes->yourfone_UVP}}>
                                                    </div>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">Ay Yıldız UVP:</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <input type="text" name="ayyildizUVP" class="form-control m-input" placeholder="" value={{$memberCodes->ayyildiz_UVP}}>
                                                    </div>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">Blau UVP:</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <input type="text" name="blauUVP" class="form-control m-input" placeholder="" value={{$memberCodes->blau_UVP}}>
                                                    </div>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">Otelo Neu:</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <input type="text" name="oteloNeu" class="form-control m-input" placeholder="" value={{$memberCodes->otelo_neu}} >
                                                    </div>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">Otelo Alt:</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <input type="text" name="oteloAlt" class="form-control m-input" placeholder="" value={{$memberCodes->otelo_alt}} >
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end: Form Wizard Step 3-->

                                <!--begin: Form Wizard Step 4-->
                                <div class="m-wizard__form-step" id="m_wizard_form_step_4">
                                    <div class="row">
                                        <div class="col-xl-8 offset-xl-2">
                                            <div class="m-form__section m-form__section--first">
                                                <div class="m-form__heading">
                                                    <h3 class="m-form__heading-title">Bank Account</h3>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">Bank Account:</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <input type="text" name="IBAN" class="form-control m-input" placeholder="" value = {{$bankAccount->IBAN}} >
                                                    </div>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">Cash Deposit:</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <span class="m-switch m-switch--sm m-switch--icon">
                                                            <label>
                                                                <input type="checkbox"  name="cashDeposit" checked="checked">
                                                                <span></span>
                                                            </label>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end: Form Wizard Step 4-->

                                <!--begin: Form Wizard Step 5
                                <div class="m-wizard__form-step" id="m_wizard_form_step_5">
                                    <div class="row">
                                        <div class="col-xl-8 offset-xl-2">
                                            <div class="m-form__section m-form__section--first">
                                                <div class="m-form__heading">
                                                    <h3 class="m-form__heading-title">Account Details</h3>
                                                </div>

                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">Name :</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <input type="text" name="accountName" class="form-control m-input" placeholder="" value = $adminAccount->name}}>
                                                    </div>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">Surname :</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <input type="text" name="accountSurname" class="form-control m-input" placeholder="" value = $adminAccount->surname}}>
                                                    </div>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label" for="exampleInputEmail1">Username :</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <div class="input-group m-input-group">
                                                            <div class="input-group-prepend"><span class="input-group-text">@</span></div>
                                                            <input type="email" name="accountEmail" class="form-control m-input" placeholder="Email" aria-describedby="basic-addon1" value="g@g.com">
                                                        </div>
                                                        <span class="m-form__help">Your username to login to your dashboard</span>
                                                    </div>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">Password :</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <div class="input-group m-input-group">
                                                            <input type="password" name="password" class="form-control m-input" placeholder="" >
                                                        </div>
                                                        <span class="m-form__help">Tokas.123</span>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                end: Form Wizard Step 5-->


                                <!--begin: Form Wizard Step 5 Confirmation-->
                                <div class="m-wizard__form-step" id="m_wizard_form_step_5">
                                    <div class="row">
                                        <div class="col-xl-8 offset-xl-2">

                                            <!--begin::Section-->
                                            <ul class="nav nav-tabs m-tabs-line--2x m-tabs-line m-tabs-line--danger" role="tablist">
                                                <li class="nav-item m-tabs__item">
                                                    <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_form_confirm_1" role="tab">1. General Info</a>
                                                </li>
                                                <li class="nav-item m-tabs__item">
                                                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_form_confirm_2" role="tab">2. Address</a>
                                                </li>
                                                <li class="nav-item m-tabs__item">
                                                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_form_confirm_3" role="tab">3. Member Codes</a>
                                                </li>
                                                <li class="nav-item m-tabs__item">
                                                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_form_confirm_4" role="tab">4. Bank Account</a>
                                                </li>
                                                <li class="nav-item m-tabs__item">
                                                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_form_confirm_5" role="tab">5. Admin Account</a>
                                                </li>
                                            </ul>
                                            <div class="tab-content m--margin-top-40">
                                                <div class="tab-pane active" id="m_form_confirm_1" role="tabpanel">
                                                    <div class="m-form__section m-form__section--first">
                                                        <div class="m-form__heading">
                                                            <h4 class="m-form__heading-title">Client Details</h4>
                                                        </div>
                                                        <div class="form-group m-form__group m-form__group--sm row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">Name:</label>
                                                            <div class="col-xl-9 col-lg-9">
                                                                <span class="m-form__control-static">Nick Stone</span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group m-form__group m-form__group--sm row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">Email:</label>
                                                            <div class="col-xl-9 col-lg-9">
                                                                <span class="m-form__control-static">nick.stone@gmail.com</span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group m-form__group m-form__group--sm row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">Phone</label>
                                                            <div class="col-xl-9 col-lg-9">
                                                                <span class="m-form__control-static">+206-78-55034890</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="m-separator m-separator--dashed m-separator--lg"></div>
                                                    <div class="m-form__section">
                                                        <div class="m-form__heading">
                                                            <h4 class="m-form__heading-title">Corresponding Address <i data-toggle="m-tooltip" data-width="auto" class="m-form__heading-help-icon flaticon-info" title="Some help text goes here"></i></h4>
                                                        </div>
                                                        <div class="form-group m-form__group m-form__group--sm row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">Address Line 1:</label>
                                                            <div class="col-xl-9 col-lg-9">
                                                                <span class="m-form__control-static">Headquarters 1120 N Street Sacramento 916-654-5266</span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group m-form__group m-form__group--sm row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">Address Line 2:</label>
                                                            <div class="col-xl-9 col-lg-9">
                                                                <span class="m-form__control-static">P.O. Box 942873 Sacramento, CA 94273-0001</span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group m-form__group m-form__group--sm row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">City:</label>
                                                            <div class="col-xl-9 col-lg-9">
                                                                <span class="m-form__control-static">Polo Alto</span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group m-form__group m-form__group--sm row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">State:</label>
                                                            <div class="col-xl-9 col-lg-9">
                                                                <span class="m-form__control-static">California</span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group m-form__group m-form__group--sm row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">Country:</label>
                                                            <div class="col-xl-9 col-lg-9">
                                                                <span class="m-form__control-static">USA</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="m_form_confirm_2" role="tabpanel">
                                                    <div class="m-form__section m-form__section--first">
                                                        <div class="m-form__heading">
                                                            <h4 class="m-form__heading-title">Account Details</h4>
                                                        </div>
                                                        <div class="form-group m-form__group m-form__group--sm row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">URL:</label>
                                                            <div class="col-xl-9 col-lg-9">
                                                                <span class="m-form__control-static">sinortech.vertoffice.com</span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group m-form__group m-form__group--sm row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">Username:</label>
                                                            <div class="col-xl-9 col-lg-9">
                                                                <span class="m-form__control-static">sinortech.admin</span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group m-form__group m-form__group--sm row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">Password:</label>
                                                            <div class="col-xl-9 col-lg-9">
                                                                <span class="m-form__control-static">*********</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="m-separator m-separator--dashed m-separator--lg"></div>
                                                    <div class="m-form__section">
                                                        <div class="m-form__heading">
                                                            <h4 class="m-form__heading-title">Account Details</h4>
                                                        </div>
                                                        <div class="form-group m-form__group m-form__group--sm row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">URL:</label>
                                                            <div class="col-xl-9 col-lg-9">
                                                                <span class="m-form__control-static">sinortech.vertoffice.com</span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group m-form__group m-form__group--sm row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">Username:</label>
                                                            <div class="col-xl-9 col-lg-9">
                                                                <span class="m-form__control-static">sinortech.admin</span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group m-form__group m-form__group--sm row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">Password:</label>
                                                            <div class="col-xl-9 col-lg-9">
                                                                <span class="m-form__control-static">*********</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="m_form_confirm_3" role="tabpanel">
                                                    <div class="m-form__section m-form__section--first">
                                                        <div class="m-form__section">
                                                            <div class="m-form__heading">
                                                                <h4 class="m-form__heading-title">Client Settings</h4>
                                                            </div>
                                                            <div class="form-group m-form__group m-form__group--sm row">
                                                                <label class="col-xl-3 col-lg-3 col-form-label">User Group:</label>
                                                                <div class="col-xl-9 col-lg-9">
                                                                    <span class="m-form__control-static">Customer</span>
                                                                </div>
                                                            </div>
                                                            <div class="form-group m-form__group m-form__group--sm row">
                                                                <label class="col-xl-3 col-lg-3 col-form-label">Communications:</label>
                                                                <div class="col-xl-9 col-lg-9">
                                                                    <span class="m-form__control-static">Phone, Email</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="m_form_confirm_4" role="tabpanel">
                                                    <div class="m-form__section m-form__section--first">
                                                        <div class="m-form__section">
                                                            <div class="m-form__heading">
                                                                <h4 class="m-form__heading-title">Client Settings</h4>
                                                            </div>
                                                            <div class="form-group m-form__group m-form__group--sm row">
                                                                <label class="col-xl-3 col-lg-3 col-form-label">User Group:</label>
                                                                <div class="col-xl-9 col-lg-9">
                                                                    <span class="m-form__control-static">Customer</span>
                                                                </div>
                                                            </div>
                                                            <div class="form-group m-form__group m-form__group--sm row">
                                                                <label class="col-xl-3 col-lg-3 col-form-label">Communications:</label>
                                                                <div class="col-xl-9 col-lg-9">
                                                                    <span class="m-form__control-static">Phone, Email</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="m_form_confirm_5" role="tabpanel">
                                                    <div class="m-form__section m-form__section--first">
                                                        <div class="m-form__section">
                                                            <div class="m-form__heading">
                                                                <h4 class="m-form__heading-title">Client Settings</h4>
                                                            </div>
                                                            <div class="form-group m-form__group m-form__group--sm row">
                                                                <label class="col-xl-3 col-lg-3 col-form-label">User Group:</label>
                                                                <div class="col-xl-9 col-lg-9">
                                                                    <span class="m-form__control-static">Customer</span>
                                                                </div>
                                                            </div>
                                                            <div class="form-group m-form__group m-form__group--sm row">
                                                                <label class="col-xl-3 col-lg-3 col-form-label">Communications:</label>
                                                                <div class="col-xl-9 col-lg-9">
                                                                    <span class="m-form__control-static">Phone, Email</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Section-->

                                            <div class="m-separator m-separator--dashed m-separator--lg"></div>
                                            <div class="form-group m-form__group m-form__group--sm row">
                                                <div class="col-xl-12">
                                                    <div class="m-checkbox-inline">
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            <input type="checkbox" name="accept" value="1">
                                                            Click here to indicate that you have read and agree to the terms presented in the Terms and Conditions agreement
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!--end: Form Wizard Step 5-->

                            </div>
                            <!--end: Form Body -->

                            <!--begin: Form Actions -->
                            <div class="m-portlet__foot m-portlet__foot--fit m--margin-top-40">
                                <div class="m-form__actions">
                                    <div class="row">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-4 m--align-left">
                                            <a href="#" class="btn btn-secondary m-btn m-btn--custom m-btn--icon" data-wizard-action="prev">
															<span>
																<i class="la la-arrow-left"></i>&nbsp;&nbsp;
																<span>Back</span>
															</span>
                                            </a>
                                        </div>
                                        <div class="col-lg-4 m--align-right">
                                            <a href="#" class="btn btn-primary m-btn m-btn--custom m-btn--icon" data-wizard-action="submit">
															<span>
																<i class="la la-check"></i>&nbsp;&nbsp;
																<span>Submit</span>
															</span>
                                            </a>
                                            <a href="#" class="btn btn-warning m-btn m-btn--custom m-btn--icon" data-wizard-action="next">
															<span>
																<span>Save & Continue</span>&nbsp;&nbsp;
																<i class="la la-arrow-right"></i>
															</span>
                                            </a>
                                        </div>
                                        <div class="col-lg-2"></div>
                                    </div>
                                </div>
                            </div>
                            <!--end: Form Actions -->

                        </form>
                        <!--end: Form -->

                    </div>
                    <!--end: Form Wizard Form-->

                </div>
                <!--end: Form Wizard-->

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