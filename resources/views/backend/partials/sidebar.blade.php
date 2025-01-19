<!-- Sidenav Menu Start -->
<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark bg-primary" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <a class="nav-link" href="{{route('dashboard')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                @include('accounts::menu')
                @include('base::menu')
            </div>
        </div>
        {{-- <div class="sb-sidenav-footer text-bg-primary">
            <div class="small fw-semibold">Logged in as:</div>
            <div class="small fw-semibold">{{auth()->user()->name}}</div>
        </div> --}}
    </nav>
</div>
<!-- Sidenav Menu End -->
