@extends('layouts.install')
@section('content')
    <div class="container pt-5">
        <div class="d-flex justify-content-center mt-5">
            <div class="card install-card position-relative">
                <!-- Content -->
                <div class="card-body install-card-body h-100 w-100 z-3 position-relative">
                    <!-- Top content -->
                    <div class="mar-ver pad-btm text-center">
                        <h1 class="fs-21 fw-700 text-uppercase mt-2" style="color: #3d3d3d;">E-BILLING ACCOUNTING SYSTEM INSTALLATION</h1>
                        <p class="fs-12 fw-500" style="color:  #fe2b25; line-height: 18px;">You will need to know the following items before proceeding</p>
                    </div>
                    <ol class="list-group rounded-2">
                        <li class="list-group-item fs-12 fw-600 d-flex align-items-center" style="line-height: 18px; color: #666; gap: 7px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13.435" height="13.435" viewBox="0 0 13.435 13.435">
                                <path id="Union_2" data-name="Union 2" d="M-4076.25,7a.75.75,0,0,1-.75-.75V.75a.75.75,0,0,1,.75-.75.75.75,0,0,1,.75.75V5.5h9.75a.75.75,0,0,1,.75.75.75.75,0,0,1-.75.75Z" transform="translate(2882.875 -2874.389) rotate(-45)" fill="#00ac47"/>
                            </svg>
                            Codecanyon purchase code
                        </li>
                        <li class="list-group-item fs-12 fw-600 d-flex align-items-center" style="line-height: 18px; color: #666; gap: 7px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13.435" height="13.435" viewBox="0 0 13.435 13.435">
                                <path id="Union_2" data-name="Union 2" d="M-4076.25,7a.75.75,0,0,1-.75-.75V.75a.75.75,0,0,1,.75-.75.75.75,0,0,1,.75.75V5.5h9.75a.75.75,0,0,1,.75.75.75.75,0,0,1-.75.75Z" transform="translate(2882.875 -2874.389) rotate(-45)" fill="#00ac47"/>
                            </svg>
                            Database Name
                        </li>
                        <li class="list-group-item fs-12 fw-600 d-flex align-items-center" style="line-height: 18px; color: #666; gap: 7px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13.435" height="13.435" viewBox="0 0 13.435 13.435">
                                <path id="Union_2" data-name="Union 2" d="M-4076.25,7a.75.75,0,0,1-.75-.75V.75a.75.75,0,0,1,.75-.75.75.75,0,0,1,.75.75V5.5h9.75a.75.75,0,0,1,.75.75.75.75,0,0,1-.75.75Z" transform="translate(2882.875 -2874.389) rotate(-45)" fill="#00ac47"/>
                            </svg>
                            Database Username
                        </li>
                        <li class="list-group-item fs-12 fw-600 d-flex align-items-center" style="line-height: 18px; color: #666; gap: 7px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13.435" height="13.435" viewBox="0 0 13.435 13.435">
                                <path id="Union_2" data-name="Union 2" d="M-4076.25,7a.75.75,0,0,1-.75-.75V.75a.75.75,0,0,1,.75-.75.75.75,0,0,1,.75.75V5.5h9.75a.75.75,0,0,1,.75.75.75.75,0,0,1-.75.75Z" transform="translate(2882.875 -2874.389) rotate(-45)" fill="#00ac47"/>
                            </svg>
                            Database Password
                        </li>
                        <li class="list-group-item fs-12 fw-600 d-flex align-items-center" style="line-height: 18px; color: #666; gap: 7px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13.435" height="13.435" viewBox="0 0 13.435 13.435">
                                <path id="Union_2" data-name="Union 2" d="M-4076.25,7a.75.75,0,0,1-.75-.75V.75a.75.75,0,0,1,.75-.75.75.75,0,0,1,.75.75V5.5h9.75a.75.75,0,0,1,.75.75.75.75,0,0,1-.75.75Z" transform="translate(2882.875 -2874.389) rotate(-45)" fill="#00ac47"/>
                            </svg>
                            Database Hostname
                        </li>
                    </ol>
                    <div class="d-flex mt-3">
                        <p class="ml-2 mb-0 fs-12 fw-500" style="color: #666; line-height: 18px;">
                            During the installation process, we will check if the files that are needed to be written (.env file) have write permission. We will also check if curl are enabled on your server or not.
                        </p>
                    </div>
                    <div class="d-flex mt-3">
                        <p class="ml-2 mb-0 fs-12 fw-500" style="color: #666; line-height: 18px;">
                            Gather the information mentioned above before hitting the start installation button. If you are ready….
                        </p>
                    </div>

                    <div class="mb-4 mt-3 pb-4 absolute-bottom-left right-0 d-flex justify-content-center">
                        <a href="{{ route('step1') }}" class="btn btn-primary text-uppercase">
                            Start Installation Process
                        </a>
                    </div>
                </div>                  
            </div>
        </div>
    </div>
@endsection
