<a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseHumanResource" aria-expanded="false" aria-controls="collapseHumanResource">
    <div class="sb-nav-link-icon"><i class="fa fa-cog"></i></div>
    @lang('base::menu.Human Resource')
    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
</a>
<div class="collapse" id="collapseHumanResource" aria-labelledby="headingInventory" data-bs-parent="#sidenavAccordion">
    <nav class="sb-sidenav-menu-nested nav accordion" id="sideNavProducts">
        @can('view_users')
        <a class="nav-link @if (Route::is('staffs.*')) active @endif" href="{{ route('staffs.index') }}">@lang('base::menu.Staff')</a>
        @endcan
        @can('view_designation')
        <a class="nav-link @if (Route::is('designation.*')) active @endif" href="{{ route('designation.index') }}">@lang('base::menu.Designation')</a>
        @endcan
        @can('view_department')
        <a class="nav-link @if (Route::is('departments.*')) active @endif" href="{{ route('departments.index') }}">@lang('base::menu.Department')</a>
        @endcan
        @can('staff_permission')
        <a class="nav-link @if (Route::is('user.permisssions')) active @endif" href="{{ route('user.permisssions') }}">@lang('base::menu.Staff Permissions')</a>
        @endcan
    </nav>
</div>
<a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseBaseSettings" aria-expanded="false" aria-controls="collapseBaseSettings">
    <div class="sb-nav-link-icon"><i class="fa fa-cog"></i></div>
    @lang('base::menu.Configurations')
    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
</a>
<div class="collapse" id="collapseBaseSettings" aria-labelledby="headingInventory" data-bs-parent="#sidenavAccordion">
    <nav class="sb-sidenav-menu-nested nav accordion" id="sideNavProducts">
        @can('company_settings')
        <a class="nav-link @if (Route::is('company_settings.configurations')) active @endif" href="{{ route('company_settings.configurations') }}">@lang('base::menu.Company Settings')</a>
        @endcan
        @can('general_settings')
        <a class="nav-link @if (Route::is('general_settings.configurations')) active @endif" href="{{ route('general_settings.configurations') }}">@lang('base::menu.General Settings')</a>
        @endcan
        @can('view_currency')
        <a class="nav-link @if (Route::is('currencies.*')) active @endif" href="{{ route('currencies.index') }}">@lang('base::menu.Currency')</a>
        @endcan
        @can('view_language')
        <a class="nav-link @if (Route::is('language.*')) active @endif" href="{{ route('language.index') }}">@lang('base::menu.Language')</a>
        @endcan
        @can('email_settings')
        <a class="nav-link @if (Route::is('email_settings.configurations')) active @endif" href="{{ route('email_settings.configurations') }}">@lang('base::menu.Email Setup')</a>
        @endcan
        @can('sales_purchase_settings')
        <a class="nav-link @if (Route::is('sales_purchase.configurations')) active @endif" href="{{ route('sales_purchase.configurations') }}">@lang('base::menu.Sales & Purchase')</a>
        @endcan
    </nav>
</div>