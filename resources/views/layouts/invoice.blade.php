
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
      <title> @yield('title', 'Invoice') | {{ config('app.name', 'E-Billing & Accounting') }}</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta content="E-Billing & Accounting" name="author" />
      <!-- App favicon -->
      <link rel="shortcut icon" href="{{asset('assets/images/favicon.png')}}">
      <link href="{{asset('assets/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" type="text/css"/>
      <link href="{{asset('assets/css/styles.css')}}" rel="stylesheet" type="text/css" />
   </head>
   <body>
      @yield('content')
   </body>
</html>