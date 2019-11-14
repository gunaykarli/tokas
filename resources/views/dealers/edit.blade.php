@extends('ralewayLayouts.master')

<!-- Page Header is yielded in the header.blade.php-->
@section('pageHeader')
    <!-- Begin Page Header -->
    <div class="header">
        <div class="container">
            <div class="row">
                <!-- Page Title -->
                <div class="col-sm-6 col-xs-12">
                    <h1> {{__('dealers\list.dealers')}}</h1>
                </div>

                <!-- Breadcrumbs -->
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li><span class="ion-home breadcrumb-home"></span><a href="/home">Home</a></li>
                        <li><a href="/dealer/index">{{__('dealers\list.dealers')}}</a></li>
                    </ol>
                </div><!-- /column -->
            </div><!-- /row -->
        </div><!-- /container -->
    </div><!-- /page header -->
    <!-- End Page Header -->
@endsection

@section ('content')
    <!--begin: Form -->
    <form method="POST" action="/dealer/update/{{$dealer->id}}" class="form-horizontal" role="form">
    @csrf
    <!--begin: Form Body -->
        <!-- Begin: General info - 1 -->
        <section class="pt30 mb20">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <p class="lead text-center flipInY-animated"> {{__('dealers\create.editDealer')}} </p>
                        <hr style="width:600px">
                    </div>
                </div>

                <div class="heading mb30 text-left"><h4>{{__('dealers\create.generalInfo')}}</h4></div>

                <div class="form-group row">
                    <label class="col-md-4 text-right">{{__('dealers\create.status')}}:</label>
                    <div class="col-md-4">
                        <input type="checkbox" name="status" @if($dealer->status == 'on') {{'checked="checked"'}} @endif data-toggle="toggle" data-onstyle="primary" data-size="mini">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-4 control-label">{{__('dealers\create.name')}}:</label>
                    <div class="col-md-4">
                        <input type="text" name="name" class="form-control m-input" placeholder="" value={{$dealer->name}}>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-4 control-label">{{__('dealers\create.type')}}:</label>
                    <div class="col-md-4">
                        <select name="type" class="form-control m-input">
                            <option value={{$dealer->type}} selected>{{$dealer->type}}</option>
                            <option value="1">Handler</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-4 control-label">{{__('dealers\create.category')}}:</label>
                    <div class="col-md-4">
                        <select name="categoryID" class="form-control m-input">
                            <option value={{$dealer->category_id}} selected>{{$dealer->category_id}}</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-4 control-label">{{__('dealers\create.ownerName')}}:</label>
                    <div class="col-md-4">
                        <input type="text" name="ownerName" class="form-control m-input" placeholder="" value={{$dealer->owner_name}}>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-4 control-label">{{__('dealers\create.ownerSurname')}}:</label>
                    <div class="col-md-4">
                        <input type="text" name="ownerSurname" class="form-control m-input" placeholder="" value={{$dealer->owner_surname}}>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-4 control-label">{{__('dealers\create.ownerMobile')}}:</label>
                    <div class="col-md-4">
                        <input type="text" name="ownerMobile" class="form-control m-input" placeholder="" value={{$dealer->owner_mobile}}>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-4 control-label">{{__('dealers\create.ownerEmail')}}:</label>
                    <div class="col-md-4">
                        <div class="input-group">
                            <div class="input-group-addon">@</div>
                            <input type="email" name="ownerEmail" class="form-control" value={{$dealer->owner_email}}>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-4 text-right">{{__('dealers\create.limitedSales')}}:</label>
                    <div class="col-md-4">
                        <input type="checkbox" name="limitedSales" id="limitedSales" @if($dealer->is_limited_sales == 1) {{'checked="checked"'}} @endif data-toggle="toggle" data-onstyle="primary" data-size="mini" data-on="Ja" data-off="Nein">
                    </div>
                </div>

                <div class="form-group row" id="salesLimitDIV">
                    <label class="col-md-4 control-label">{{__('dealers\create.salesLimit')}}:</label>
                    <div class="col-md-4">
                        <input type="text" name="salesLimit" class="form-control m-input" placeholder="" value="{{$dealer->remaining_sales_amount}}">
                    </div>
                </div>

            </div>
        </section>
        <!-- End: General info -->

        <!-- Begin: Main office - 2 -->
        <section class=" mb20">
            <div class="container">
                <div class="heading mb30 text-left"><h4>{{__('dealers\create.mainOffice')}}</h4></div>

                <div class="form-group row">
                    <label class="col-md-4 control-label">{{__('dealers\create.officeName')}}:</label>
                    <div class="col-md-4">
                        <input type="text" name="officeName" class="form-control input-group" value={{$mainOffice->name}}>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-4 control-label">{{__('dealers\create.phone')}}:</label>
                    <div class="col-md-4">
                        <input type="text" name="phone" class="form-control m-input" placeholder="" value={{$mainOffice->phone}}>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-4 control-label">{{__('dealers\create.streetAddress')}}:</label>
                    <div class="col-md-4">
                        <input type="text" name="streetAddress" class="form-control m-input" placeholder="" value={{$mainOfficeAddress->street_address}}>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-4 control-label">{{__('dealers\create.POBox')}}:</label>
                    <div class="col-md-4">
                        <input type="text" name="POBox" class="form-control m-input" placeholder="" value={{$mainOfficeAddress->PO_box}}>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-4 control-label">{{__('dealers\create.postalCode')}}:</label>
                    <div class="col-md-4">
                        <input type="text" name="postalCode" class="form-control m-input" placeholder="" value={{$mainOfficeAddress->postal_code}}>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-4 control-label">{{__('dealers\create.city')}}:</label>
                    <div class="col-md-4">
                        <input type="text" name="city" class="form-control m-input" placeholder="" value={{$mainOfficeAddress->city}}>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-4 control-label">{{__('dealers\create.state')}}:</label>
                    <div class="col-md-4">
                        <input type="text" name="state" class="form-control m-input" placeholder="" value={{$mainOfficeAddress->state}}>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-4 control-label">{{__('dealers\create.country')}}:</label>
                    <div class="col-md-4">
                        <select name="country" class="form-control m-input">
                            <option value={{$mainOfficeAddress->country}}>{{$mainOfficeAddress->country}}</option>
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
                            <option value="DE">Germany</option>
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
        </section>
        <!-- End: Main office -->

        <!-- Begin: Member codes - 3 -->
        <section class=" mb20">
            <div class="container">
                <div class="heading mb30 text-left"><h4>{{__('dealers\create.memberCodes')}}</h4></div>

                <div class="form-group row">
                    <label class="col-md-4 control-label">Vodafone UVP:</label>
                    <div class="col-md-4">
                        <input type="text" name="vodafoneUVP" class="form-control m-input" placeholder="" value={{$memberCodes->vodafone_UVP}}>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-4 control-label">Vodafone GVO:</label>
                    <div class="col-md-4">
                        <input type="text" name="vodafoneGVO" class="form-control m-input" placeholder="" value={{$memberCodes->vodafone_GVO}}>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-4 control-label">Vodafone DSL UVP:</label>
                    <div class="col-md-4">
                        <input type="text" name="vodafoneDSLUVP" class="form-control m-input" placeholder="" value={{$memberCodes->vodafone_DSL_UVP}}>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-4 control-label">Mobilcom Debitel UVP:</label>
                    <div class="col-md-4">
                        <input type="text" name="mobilcomDebitelUVP" class="form-control m-input" placeholder="" value={{$memberCodes->mobilcom_debitel_UVP}}>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-4 control-label">Energie User:</label>
                    <div class="col-md-4">
                        <input type="text" name="energieUser" class="form-control m-input" placeholder="" value={{$memberCodes->energie_user}}>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-4 control-label">Yourfone UVP:</label>
                    <div class="col-md-4">
                        <input type="text" name="yourfoneUVP" class="form-control m-input" placeholder="" value={{$memberCodes->yourfone_UVP}}>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-4 control-label">Ay Yıldız UVP:</label>
                    <div class="col-md-4">
                        <input type="text" name="ayyildizUVP" class="form-control m-input" placeholder="" value={{$memberCodes->ayyildiz_UVP}}>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-4 control-label">Blau UVP:</label>
                    <div class="col-md-4">
                        <input type="text" name="blauUVP" class="form-control m-input" placeholder="" value={{$memberCodes->blau_UVP}}>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-4 control-label">Otelo Neu:</label>
                    <div class="col-md-4">
                        <input type="text" name="oteloNeu" class="form-control m-input" placeholder="" value={{$memberCodes->otelo_neu}}>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-4 control-label">Otelo Alt:</label>
                    <div class="col-md-4">
                        <input type="text" name="oteloAlt" class="form-control m-input" placeholder="" value={{$memberCodes->otelo_alt}}>
                    </div>
                </div>

            </div>
        </section>
        <!-- End: Member code -->

        <!-- Begin: Bank info - 4 -->
        <section class=" mb20">
            <div class="container">
                <div class="heading mb30 text-left"><h4>{{__('dealers\create.bankInfo')}}</h4></div>

                <div class="form-group row">
                    <label class="col-md-4 control-label">{{__('dealers\create.IBAN')}}:</label>
                    <div class="col-md-4">
                        <input type="text" name="IBAN" class="form-control m-input" value={{$bankAccount->IBAN}}>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-4 text-right">{{__('dealers\create.cashDeposit')}}:</label>
                    <div class="col-md-4">
                        <input type="checkbox" name="cashDeposit" @if ($bankAccount->cash_deposit == 'on') {{'checked="checked"'}} @endif data-toggle="toggle" data-onstyle="primary" data-size="mini" data-on="Ja" data-off="Nein">
                    </div>
                </div>

            </div>
        </section>
        <!-- End: Bank info  -->

        <!-- Begin: contactPerson  - 5 No need for contact person...deleted-->

        <!-- End:  -->

        <!-- Begin: Admin account - 6 -->
        <section class=" mb20">
            <div class="container">
                <div class="heading mb30 text-left"><h4>{{__('dealers\create.adminAccount')}}</h4></div>

                <div class="form-group row">
                    <label class="col-md-4 control-label">{{__('dealers\create.userName')}}:</label>
                    <div class="col-md-4">
                        <input type="text" name="userName" class="form-control m-input" placeholder="" value={{$adminAccount->name}}>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-4 text-right">{{__('dealers\create.passwordChange')}}:</label>
                    <div class="col-md-4">
                        <input type="checkbox" name="passwordChange" id="passwordChange" data-toggle="toggle" data-onstyle="primary" data-size="mini" data-on="Ja" data-off="Nein">
                    </div>
                </div>

                <div class="form-group row" id="passwordDIV">
                    <label class="col-md-4 control-label">{{__('dealers\create.password')}}:</label>
                    <div class="col-md-4">
                        <label class="sr-only" for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control"  placeholder="Password">
                    </div>
                </div>

            </div>
        </section>
        <!-- End:  -->

        <div class="form-group row">
            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-rw btn-primary">{{__('dealers\create.save')}}</button>
            </div>
        </div>

    </form>
    <!--end: Form -->
@endsection

@section ('pageVendorsAndScripts')
    <script src="{{ asset('js/dealersCreateEdit1.js')}}" type="text/javascript"></script>
    <script src="{{ asset('js/dataTable.js')}}" type="text/javascript"></script>
@endsection
