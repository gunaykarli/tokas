@extends ('partials.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">CSV Import</div>

                    <div class="panel-body">
                        Data imported successfully.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('pageVendorsAndScripts')
    <!--begin::Page Vendors -->
    <script src="{{ asset('metronic/assets/vendors/custom/fullcalendar/fullcalendar.bundle.js')}}" type="text/javascript"></script>
    <!--end::Page Vendors -->

    <!--begin::Page Scripts -->
    <script src="{{ asset('metronic/assets/app/js/dashboard.js')}}" type="text/javascript"></script>
    <script src="{{ asset('metronic/assets/demo/default/custom/crud/wizard/createProviderwizard3.js')}}" type="text/javascript"></script>
    <!--end::Page Scripts -->
@endsection