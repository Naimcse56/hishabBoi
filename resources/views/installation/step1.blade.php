@extends('layouts.install')
@section('content')
    <div class="container pt-5">
        <div class="d-flex justify-content-center mt-5">
            <div class="card install-card position-relative">
                <!-- Content -->
                <div class="card-body install-card-body h-100 w-100 z-3 position-relative">
                    <!-- Top content -->
                    <div class="mar-ver pad-btm text-center">
                        <h1 class="fs-21 fw-700 text-uppercase mt-2" style="color: #3d3d3d;">CHECKING FILE PERMISSIONS</h1>
                        <p class="fs-12 fw-500" style="color:  #666; line-height: 18px;">
                            We ran diagnosis on your server. Review the items that have a <span style="color: #fe2b25">red</span> mark on it. <br> If everything is green, you are good to go to the next step.
                        </p>
                    </div>

                    <ul class="list-group rounded-2">
                        <li class="list-group-item fs-12 fw-600 d-flex align-items-center justify-content-between" style="line-height: 18px; color: #666; gap: 7px;">
                            Php version 8.0

                            @php
                                $phpVersion = number_format((float)phpversion(), 2, '.', '');
                            @endphp
                            @if ($phpVersion >= 8.0)
                                <svg xmlns="http://www.w3.org/2000/svg" width="13.435" height="13.435" viewBox="0 0 13.435 13.435">
                                    <path id="Union_2" data-name="Union 2" d="M-4076.25,7a.75.75,0,0,1-.75-.75V.75a.75.75,0,0,1,.75-.75.75.75,0,0,1,.75.75V5.5h9.75a.75.75,0,0,1,.75.75.75.75,0,0,1-.75.75Z" transform="translate(2882.875 -2874.389) rotate(-45)" fill="#00ac47"/>
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="13.435" height="13.435" viewBox="0 0 13.435 13.435">
                                    <path id="Union_2" data-name="Union 2" d="M-4076.25,7a.75.75,0,0,1-.75-.75V.75a.75.75,0,0,1,.75-.75.75.75,0,0,1,.75.75V5.5h9.75a.75.75,0,0,1,.75.75.75.75,0,0,1-.75.75Z" transform="translate(2882.875 -2874.389) rotate(-45)" fill="#fe2b25"/>
                                </svg>
                            @endif
                        </li>
                        <li class="list-group-item fs-12 fw-600 d-flex align-items-center justify-content-between" style="line-height: 18px; color: #666; gap: 7px;">
                            Curl Enabled

                            @if ($permission['curl_enabled'])
                                <svg xmlns="http://www.w3.org/2000/svg" width="13.435" height="13.435" viewBox="0 0 13.435 13.435">
                                    <path id="Union_2" data-name="Union 2" d="M-4076.25,7a.75.75,0,0,1-.75-.75V.75a.75.75,0,0,1,.75-.75.75.75,0,0,1,.75.75V5.5h9.75a.75.75,0,0,1,.75.75.75.75,0,0,1-.75.75Z" transform="translate(2882.875 -2874.389) rotate(-45)" fill="#00ac47"/>
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="13.435" height="13.435" viewBox="0 0 13.435 13.435">
                                    <path id="Union_2" data-name="Union 2" d="M-4076.25,7a.75.75,0,0,1-.75-.75V.75a.75.75,0,0,1,.75-.75.75.75,0,0,1,.75.75V5.5h9.75a.75.75,0,0,1,.75.75.75.75,0,0,1-.75.75Z" transform="translate(2882.875 -2874.389) rotate(-45)" fill="#fe2b25"/>
                                </svg>
                            @endif
                        </li>
                        <li class="list-group-item fs-12 fw-600 d-flex align-items-center justify-content-between" style="line-height: 18px; color: #666; gap: 7px;">
                            .env File Permission

                            @if ($permission['db_file_write_perm'])
                                <svg xmlns="http://www.w3.org/2000/svg" width="13.435" height="13.435" viewBox="0 0 13.435 13.435">
                                    <path id="Union_2" data-name="Union 2" d="M-4076.25,7a.75.75,0,0,1-.75-.75V.75a.75.75,0,0,1,.75-.75.75.75,0,0,1,.75.75V5.5h9.75a.75.75,0,0,1,.75.75.75.75,0,0,1-.75.75Z" transform="translate(2882.875 -2874.389) rotate(-45)" fill="#00ac47"/>
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="13.435" height="13.435" viewBox="0 0 13.435 13.435">
                                    <path id="Union_2" data-name="Union 2" d="M-4076.25,7a.75.75,0,0,1-.75-.75V.75a.75.75,0,0,1,.75-.75.75.75,0,0,1,.75.75V5.5h9.75a.75.75,0,0,1,.75.75.75.75,0,0,1-.75.75Z" transform="translate(2882.875 -2874.389) rotate(-45)" fill="#fe2b25"/>
                                </svg>
                            @endif
                        </li>
                        <li class="list-group-item fs-12 fw-600 d-flex align-items-center justify-content-between" style="line-height: 18px; color: #666; gap: 7px;">
                            Bootstrap App File Permission

                            @if ($permission['routes_file_write_perm'])
                                <svg xmlns="http://www.w3.org/2000/svg" width="13.435" height="13.435" viewBox="0 0 13.435 13.435">
                                    <path id="Union_2" data-name="Union 2" d="M-4076.25,7a.75.75,0,0,1-.75-.75V.75a.75.75,0,0,1,.75-.75.75.75,0,0,1,.75.75V5.5h9.75a.75.75,0,0,1,.75.75.75.75,0,0,1-.75.75Z" transform="translate(2882.875 -2874.389) rotate(-45)" fill="#00ac47"/>
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="13.435" height="13.435" viewBox="0 0 13.435 13.435">
                                    <path id="Union_2" data-name="Union 2" d="M-4076.25,7a.75.75,0,0,1-.75-.75V.75a.75.75,0,0,1,.75-.75.75.75,0,0,1,.75.75V5.5h9.75a.75.75,0,0,1,.75.75.75.75,0,0,1-.75.75Z" transform="translate(2882.875 -2874.389) rotate(-45)" fill="#fe2b25"/>
                                </svg>
                            @endif
                        </li>
                    </ul>
                    
                    <div class="d-flex mt-3">
                        <p class="ml-2 mb-0 fs-12 fw-500 text-justify text-gray-dark" style="color: #666; line-height: 18px;">
                            Note: Go to your server  and find the php <span class="text-dark fw-900">extension/package</span> and disable <span class="text-dark fw-900">pdo_mysql</span> then enable <span class="text-dark fw-900">nd_mysqli</span> and <span class="text-dark fw-900">nd_pdo_mysql</span> both for preventing value convert issue like an integer to string.
                        </p>
                    </div>

                    <p class="mb-4 pb-4 absolute-bottom-left right-0 d-flex justify-content-center">
                        @if ($permission['curl_enabled'] == 1 && $permission['db_file_write_perm'] == 1 && $permission['routes_file_write_perm'] == 1 && $phpVersion >= 8.2)
                            @if ($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '127.0.0.1')
                                <a href = "{{ route('step3') }}" class="btn btn-primary text-uppercase mt-3">Go To Next Step</a>
                            @else
                                <a href = "{{ route('step2') }}" class="btn btn-primary text-uppercase mt-3">Go To Next Step</a>
                            @endif
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
