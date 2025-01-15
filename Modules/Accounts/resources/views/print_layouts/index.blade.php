<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{auth()->check() ? (auth()->user()->theme == 'light' ? 'light-theme' : 'dark-theme') : 'light-theme' }}">
<head>
    <script>
        const APP_URL = '{{url('/')}}';
        const APP_TOKEN = '{{csrf_token()}}';
    </script>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> @yield('title', 'Print') | {{ config('app.name', 'E-Billing & Accounting') }}</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{asset('assets/images/favicon.png')}}" type="image/png"/>

	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="{{asset('assets/css/styles.css')}}" rel="stylesheet" type="text/css" />
    <style>
        body {
            font-size: 14px;
            font-weight: 700;
            color: #000000;
            background: #ffffff;
        }
        .page-footer {
            left: 0;
            border-top: none;
        }
        .nowrap {
            white-space: nowrap;
        }
        .table {
            border: #000000 !important;
        }
        th {
            font-size: 12px;
            font-weight: bold;
            color: #000000 !important;
        }
        td {
            font-size: 10px;
            padding-top: 0.15rem !important;
            padding-bottom: 0.15rem !important;
            color: #000000 !important;
            vertical-align: middle !important;
        }
        .tab-5{
            padding-left: 1.5rem !important;
        }
        .tab-10{
            padding-left: 3.5rem !important;
        }
        .tabspace-1{
            padding-left: 1rem !important;
        }
        .tabspace-2{
            padding-left: 2rem !important;
        }
        .tabspace-3{
            padding-left: 3rem !important;
        }
        .tabspace-4{
            padding-left: 4rem !important;
        }
        a.text-black {
            text-decoration: none;
            font-size: 11px;
            font-weight: 700;
        }
        .sign_dash {
            border-top: 1px solid;
            padding-top: 5px;
            padding-left: 10px;
            padding-right: 10px;
            margin-bottom: 0px;
        }
        .mt-25 {
            margin-top: 30px;
        }
        .bottom_footer{
            background: #fff;
            left: 0px;
            right: 0;
            bottom: 0;
            position: fixed;
            padding: 7px;
            font-size: 14px;
            z-index: 3;
            width: -webkit-fill-available;
        }
        .debit_info {
            font-size: 1rem;
            position: relative;
        }

        .debit_info_span {
            background-color: white;
            padding-right: 10px;
        }

        .debit_info:after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 0.5em;
            /* border-top: 1px solid #666666; */
            z-index: -1;
        }
        .sky-bg {
            background-color: #c8e6ff !important;
        }
        .fs-14{
            font-size: 14px !important;
        }
        .align-middle {
            vertical-align: middle;
        }
        .image-container{
            width: 80%;
            height: 300px;
            position: absolute;
            display: block;
            margin: 2px auto;
            top: 70px;
            left: 80px;
        }

        .test{
            object-fit: contain;
            /* z-index: 1; */
            display: block;
            width: 100%;
            height: 100%;
            border: 3px solid white;
            opacity: .08;
        }
        .text-right {
            text-align: right !important;
        }
        .fw-semibold{font-weight:700!important}
        .relative-z-index {
            z-index: 10;
            position: relative;
        }
        .signing-footer {
            font-size: 14px;
            padding-bottom: 10px;
        }
        .mt-45 {
            margin-top: 45px;
        }
        .mt-5 {
            margin-top: 5px;
        }
        .top-border-signing {
            border-top: 1px #666666 solid;
        }
        @media print {
            .pagebreak { page-break-before: always; } /* page-break-after works, as well */
            table { page-break-after:auto }
            tr    { page-break-inside:avoid; page-break-after:auto }
            td    { page-break-inside:avoid; page-break-after:auto }
            thead { display:table-header-group }
            tfoot { display:table-footer-group }
        }
    </style>
</head>

<body>
<!--wrapper-->
<div class="wrapper">
    <div class="row">
        <div class="col-md-12">
            <div class="image-container">
                {{-- <img class="test" src="{{asset(app('branch_info')['current_branch_logo'])}}" alt=""> --}}             
            </div>
        </div>
    </div>
    @yield('content')
</div>
<!--end wrapper-->

<script src="{{asset('assets/js/jquery.min.js')}}"></script>
@if (auth()->check())
<script>
    document.addEventListener('contextmenu', event=> event.preventDefault()); 
        document.onkeydown = function(e) { 
        if(event.keyCode == 123) { 
        return false; 
        } 
        if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)){ 
        return false; 
        } 
        if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)){ 
        return false; 
        } 
        if(e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)){ 
        return false; 
        } 
        if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)){ 
        return false; 
        } 
    } 
    $( document ).ready(function() {
        window.print();
    });
</script>
@endif

</body>
</html>
