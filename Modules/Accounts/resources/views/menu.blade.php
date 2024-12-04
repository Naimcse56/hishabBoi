<a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseAccounts" aria-expanded="false" aria-controls="collapseAccounts">
    <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
    Accounts
    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
</a>
<div class="collapse" id="collapseAccounts" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#head_child" aria-expanded="false" aria-controls="head_child">
            Account Head
            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
        </a>
        <div class="collapse" id="head_child" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
            <nav class="sb-sidenav-menu-nested nav">
                <a class="nav-link @if (Route::is('ledger.*')) active @endif" href="{{route('ledger.index')}}">Ledger</a>
                <a class="nav-link @if (Route::is('subledger-type.*')) active @endif" href="{{route('subledger-type.index')}}">Party Type</a>
                <a class="nav-link @if (Route::is('sub-ledger.*')) active @endif" href="{{route('sub-ledger.index')}}">Party</a>
                <a class="nav-link @if (Route::is('work-order.*')) active @endif" href="{{route('work-order.index')}}">Work Order</a>
                <a class="nav-link @if (Route::is('work-order-sites.*')) active @endif" href="{{route('work-order-sites.index')}}">W/O Sites</a>
            </nav>
        </div>
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseJournal" aria-expanded="false" aria-controls="collapseJournal">
            Journal
            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
        </a>
        <div class="collapse" id="collapseJournal" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
            <nav class="sb-sidenav-menu-nested nav">
                <a class="nav-link @if (Route::is('multi-cash-payment.*')) active @endif" href="{{route('multi-cash-payment.index')}}">Cash Payment</a>
                <a class="nav-link @if (Route::is('multi-bank-payment.*')) active @endif" href="{{route('multi-bank-payment.index')}}">Bank Payment</a>
                <a class="nav-link @if (Route::is('multi-cash-receive.*')) active @endif" href="{{route('multi-cash-receive.index')}}">Cash Recieve</a>
                <a class="nav-link @if (Route::is('multi-bank-receive.*')) active @endif" href="{{route('multi-bank-receive.index')}}">Bank Recieve</a>
                <a class="nav-link @if (Route::is('journal.*')) active @endif" href="{{route('journal.index')}}">Misc. Journal</a>
            </nav>
        </div>
    </nav>
</div>