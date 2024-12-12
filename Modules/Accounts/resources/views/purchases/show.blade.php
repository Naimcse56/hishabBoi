@extends('layouts.admin_app')
@section('title')
Purchase Details
@endsection
@section('content')
<div class="invoice-container">
    <div class="float-start">
        <img src="{{ asset('assets/images/invoice.png') }}" width="205px"  alt="invoice" />
    </div>
    <div class="float-end datetime">
        INVOICE ID:{{$purchase->invoice_no}}
        <br>
        {{$purchase->date}}
    </div>
    <div class="d-block">
        <div class="float-start">
            <span class="orange">WELCOME TO:</span> <br>
            {{$purchase->sub_ledger->name}}<br> Dhaka , BD
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
        <span class="float-start">
            {{$purchase->creator->name}}
            <hr>
        </span>
        <span class="float-end">
            Authorised Signature   
            <hr>
        </span>
    </div>
</div>

@endsection