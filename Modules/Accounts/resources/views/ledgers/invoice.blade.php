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
    <title> @yield('title', 'Invoice') | {{ config('app.name', 'Hishab Boi') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Hishab Boi" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.png')}}">
    <link href="{{asset('assets/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/css/styles.css')}}" rel="stylesheet" type="text/css" />

    @stack('css')
</head>
<body class="sb-nav-fixed">
    <!-- Begin page -->
    <div class="wrapper">
         <div class="invoice-container">
            <div class="float-start">            <img src="{{ asset('assets/images/invoice.png') }}" width="205px"  alt="invoice" />
</div>
<div class="float-end">
    INVOICE ID:#098090
<br>
20th Jan 2024
</div>
         </div>
          
    </div>

 
</body>
</html>
