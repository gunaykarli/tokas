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
                                {{__('regions\create.addRegion')}}
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">

                    <!--BEGIN: import form -->
                    <form  action="/region/store" class="form-horizontal" method="post" enctype="multipart/form-data">
                        @csrf

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (\Illuminate\Support\Facades\Session::has('success'))
                            <div class="alert alert-success">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                <p>{{ \Illuminate\Support\Facades\Session::get('success') }}</p>
                            </div>
                        @endif

                        <div class="m-portlet__body">

                            <div class="form-group m-form__group">
                                <label for="provider">{{__('regions\create.provider')}}</label>
                                <select name="providerID" class="form-control m-input m-input--air m-input--pill" id="provider" >
                                    <option >{{__('regions\create.selectProvider')}}</option>
                                    @foreach($providers as $provider)
                                        <option value={{$provider->id}}>{{$provider->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group m-form__group">
                                <label for="regionAbbID">{{__('regions\create.regionName')}}</label>
                                <input type="text" name="regionName" class="form-control m-input m-input--air m-input--pill" id="regionNameID"  placeholder="">
                            </div>

                            <div class="form-group m-form__group">
                                <label for="regionAbbID">{{__('regions\create.regionAbbreviation')}}</label>
                                <input type="text" name="regionAbbreviation" class="form-control m-input m-input--air m-input--pill" id="regionAbbID"  placeholder="">
                            </div>

                        </div>
                        <div class="m-portlet__foot m-portlet__foot--fit">
                            <div class="m-form__actions">
                                <button type="submit" class="btn btn-brand">Submit</button>
                            </div>
                        </div>
                    </form>
                    <!--END: import form -->
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