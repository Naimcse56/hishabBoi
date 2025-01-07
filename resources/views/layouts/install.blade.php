<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script>
        const APP_URL = '{{url('/')}}';
        const APP_TOKEN = '{{csrf_token()}}';
    </script>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> @yield('title', 'Dashboard') | {{ config('app.name', 'Hishab Boi') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Hishab Boi" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.png')}}">
    <link href="{{asset('assets/plugins/flatpickr/flatpickr.min.css')}}" rel="stylesheet"/>
    <link href="{{asset('assets/plugins/summernote/summernote.min.css')}}" rel="stylesheet"/>
    <link href="{{asset('assets/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/css/styles.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    @stack('css')
</head>
<body class="sb-nav-fixed">
    <!-- Begin page -->
    <div class="wrapper">
        <div id="layoutSidenav">
            <div id="layoutSidenav_content">
                <main>
                    @yield('content')
                </main>
    
                @include('backend.partials.footer')
    
            </div>
        </div>

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>

    <!-- App js -->
    <script src="{{asset('assets/js/jquery.min.js')}}"></script>
    <script src="{{asset('assets/js/select2.min.js')}}"></script>
    <script src="{{asset('assets/js/fontawesome.js')}}" crossorigin="anonymous"></script>
    <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/plugins/flatpickr/flatpickr.js')}}"></script>
    <script src="{{asset('assets/plugins/summernote/summernote.min.js')}}"></script>
    <script src="{{asset('assets/js/sweetAlert.js')}}"></script>
    <script src="{{asset('assets/js/scripts.js')}}"></script>
    <script src="{{asset('assets/js/custom.js')}}"></script>
    <script src="{{asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatables/dataTables.bootstrap5.min.js')}}"></script>
    <script src="{{asset('assets/js/toastr.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            var serverTime = new Date("{{ now() }}");
            // Use serverTime for additional logic if needed
        });
    </script>
    
    @include('backend.partials.session_message')
    @stack('scripts')
</body>
</html>
