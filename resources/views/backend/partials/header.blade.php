<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="{{ route('dashboard') }}">Base Template</a>
    <!-- Sidebar Toggle-->
    <a class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></a>
    <ul class="navbar-nav ms-auto">
        <li class="nav-item dropdown">
            {{-- <img src="{{ Avatar::create(Auth::user()->name)->toBase64() }}" width="32" class="rounded-circle me-lg-2 d-flex" alt="user-image"> --}}
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="{{route('profile_edit')}}">Account</a></li>
                <li><hr class="dropdown-divider" /></li>
                <li>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item text-danger">
                        <span class="align-middle">Sign Out</span>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</nav>