
<!doctype html>
<html lang="en" data-bs-theme="dark">
    @extends('layouts.error')
    @section('content')
    <!-- Start wrapper-->
    <div class="pt-5">
    
        <div class="container pt-5">
                <div class="row pt-5">
                    <div class="col-lg-12">
                        <div class="text-center error-pages">
                            <h1 class="error-title text-danger mb-3">500</h1>
                            <h2 class="error-sub-title text-danger">500 SERVER ERROR</h2>

                            <p class="error-message text-danger text-uppercase">SORRY, AN ERROR HAS OCCURED, CONTACT SERVER PROVIDER!</p>
                            
                            <div class="mt-4 d-flex align-items-center justify-content-center gap-3">
                            <a href="{{route('dashboard')}}" class="btn btn-primary rounded-5 px-4"><i class="bi bi-house-fill me-2"></i>Go To Home</a>
                            <a href="javascript:void();" class="btn btn-outline-light rounded-5 px-4"><i class="bi bi-arrow-left me-2"></i>Previous Page </a>
                            </div>

                            <div class="mt-4">
                                <p class="text-light">Copyright © {{date('Y')}} | All rights reserved.</p>
                            </div>
                        </div>
                    </div>
                </div><!--end row-->
            </div>

    </div><!--wrapper-->
@endsection
