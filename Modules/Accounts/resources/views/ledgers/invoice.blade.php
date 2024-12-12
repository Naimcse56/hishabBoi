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
<div class="float-end datetime">
    INVOICE ID:#098090
<br>
20th Jan 2024
</div>
<div class="d-block">
<div class="float-start">
    <span class="orange">WELCOME TO:</span> <br>
    Monirul Islam<br> Dhaka , BD
</div>
<div class="float-end datetime">
    <span class="orange">PAYMENT METHOD</span>
<br>
Account NO: 102012012<br>
Account Name: Monir
</div>
</div>
<div class="mt30">
    <table class="table table-bordered">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">NAME</th>
            <th scope="col">ADDRESS</th>
            <th scope="col">PRICE</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">1</th>
            <td>Mark</td>
            <td>Otto</td>
            <td>@mdo</td>
          </tr>
          <tr>
            <th scope="row">2</th>
            <td>Jacob</td>
            <td>Thornton</td>
            <td>@fat</td>
          </tr>
          <tr>

            <td colspan="3" class="text-right"><b> Balance</b></td>
            <td><b>10020</b></td>
          </tr>
        </tbody>
      </table>
</div>
<div class="mt30">
 <b>Terms & Condition</b><br>
 <small>Bootstrap's tables are opt-in. Add the base class .table to anBootstrap's tables are opt-in. Add the base class .table to an</small>
         </div>
         <div class="mt30">
           <span class="float-start ">
            Authorised Signature   <hr></span>
            <span class="float-end ">
                Authorised Signature   <hr></span>
         </div>
         </div>

    </div>


</body>
</html>
