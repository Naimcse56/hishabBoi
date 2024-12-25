<a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseBaseSettings" aria-expanded="false" aria-controls="collapseBaseSettings">
    <div class="sb-nav-link-icon"><i class="fa fa-cog"></i></div>
    Configurations
    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
</a>
<div class="collapse" id="collapseBaseSettings" aria-labelledby="headingInventory" data-bs-parent="#sidenavAccordion">
    <nav class="sb-sidenav-menu-nested nav accordion" id="sideNavProducts">
        <a class="nav-link @if (Route::is('company_settings.configurations')) active @endif" href="{{ route('company_settings.configurations') }}">Company Settings</a>
        <a class="nav-link @if (Route::is('currencies.*')) active @endif" href="{{ route('currencies.index') }}">Currency</a>
        <a class="nav-link @if (Route::is('email_settings.configurations')) active @endif" href="{{ route('email_settings.configurations') }}">Email Setup</a>
        <a class="nav-link @if (Route::is('terms_condition.configurations')) active @endif" href="{{ route('terms_condition.configurations') }}">Terms & Conditions</a>
    </nav>
</div>