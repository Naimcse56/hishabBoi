@extends('layouts.install')
@section('content')
    <div class="container pt-5">
        <div class="d-flex justify-content-center mt-5">
            <div class="card  position-relative">
                <!-- Content -->
                <div class="card-body -body h-100 w-100 z-3 position-relative">
                  <!-- Top content -->
                    <div class="mar-ver pad-btm text-center">
                        <h1 class="fs-21 fw-700 text-uppercase mt-2" style="color: #3d3d3d;">Purchase Code</h1>
                        <p class="fs-12 fw-500" style="color:  #666; line-height: 18px;">
                            Provide your codecanyon purchase code.<br>
                            <a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code" target="_blank" class="text-blue hov-text-primary"><i>Where to get purchase code?</i></a>
                        </p>
                    </div>

                    <form method="POST" action="{{ route('purchase.code') }}">
                        @csrf
                        <div class="form-group">
                            <label for="purchase_code" class="fs-12 fw-500" style="color: #666;">Purchase Code</label>
                            <input type="text" class="form-control rounded-2 border" style="height: 36px !important;" id="purchase_code" name="purchase_code" placeholder="**** **** **** ****" required="">
                        </div>
                        <div class="mb-4 pb-4 absolute-bottom-left right-0 d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary text-uppercase">Continue</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
