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
                <a class="nav-link @if (Route::is('journal.*') && !Route::is('journal.work_order.*')) active @endif" href="{{route('journal.index')}}">Misc. Journal</a>
                <a class="nav-link @if (Route::is('journal.work_order.*')) active @endif" href="{{route('journal.work_order.index')}}">W/O Journal</a>
                <a class="nav-link @if (Route::is('opening-balance.*')) active @endif" href="{{route('opening-balance.index')}}">Opening Balance</a>
            </nav>
        </div>
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseApprovalAccounting" aria-expanded="false" aria-controls="collapseApprovalAccounting">
            Approval
            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
        </a>
        <div class="collapse" id="collapseApprovalAccounting" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
            <nav class="sb-sidenav-menu-nested nav">
                <a class="nav-link @if (Route::is('voucher.approval_index')) active @endif" href="{{route('voucher.approval_index')}}">Pending</a>
                <a class="nav-link @if (Route::is('reject_by_accountant.index')) active @endif" href="{{route('reject_by_accountant.index')}}">Rejected</a>
            </nav>
        </div>
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseReportsAccounting" aria-expanded="false" aria-controls="collapseReportsAccounting">
            Reports
            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
        </a>
        <div class="collapse" id="collapseReportsAccounting" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
            <nav class="sb-sidenav-menu-nested nav">
                <a class="nav-link @if (0) active @endif" href="{{route('voucher.approval_index')}}">Cashbook</a>
                <a class="nav-link @if (0) active @endif" href="{{route('reject_by_accountant.index')}}">Bankbook</a>
                <a class="nav-link @if (0) active @endif" href="{{route('reject_by_accountant.index')}}">Ledger Report</a>
                <a class="nav-link @if (0) active @endif" href="{{route('reject_by_accountant.index')}}">Party Report</a>
                <a class="nav-link @if (0) active @endif" href="{{route('reject_by_accountant.index')}}">Party Summary</a>
                <a class="nav-link @if (0) active @endif" href="{{route('reject_by_accountant.index')}}">Party Type</a>
                <a class="nav-link @if (0) active @endif" href="{{route('reject_by_accountant.index')}}">Work Order Report</a>
                <a class="nav-link @if (0) active @endif" href="{{route('reject_by_accountant.index')}}">W/O Summary</a>
                <a class="nav-link @if (0) active @endif" href="{{route('reject_by_accountant.index')}}">W/O Profit Loss</a>
                <a class="nav-link @if (0) active @endif" href="{{route('reject_by_accountant.index')}}">W/O Asset and Liability</a>
                <a class="nav-link @if (0) active @endif" href="{{route('reject_by_accountant.index')}}">W/O Receipt & Payment</a>
                <a class="nav-link @if (0) active @endif" href="{{route('reject_by_accountant.index')}}">Receipt & Payment Report</a>
                <a class="nav-link @if (0) active @endif" href="{{route('reject_by_accountant.index')}}">Balance Sheet</a>
                <a class="nav-link @if (0) active @endif" href="{{route('reject_by_accountant.index')}}">Trial Balance</a>
                <a class="nav-link @if (0) active @endif" href="{{route('reject_by_accountant.index')}}">Income Statement</a>
            </nav>
        </div>
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseAccountingConfig" aria-expanded="false" aria-controls="collapseAccountingConfig">
            Config
            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
        </a>
        <div class="collapse" id="collapseAccountingConfig" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
            <nav class="sb-sidenav-menu-nested nav">
                <a class="nav-link @if (Route::is('accountings.report-config')) active @endif" href="{{route('accountings.report-config')}}">Report</a>
                <a class="nav-link @if (Route::is('accountings.day_closing_list')) active @endif" href="{{route('accountings.day_closing_list')}}">Day Close</a>
                <a class="nav-link @if (Route::is('multi-cash-receive.*')) active @endif" href="javascript">Fiscal Year</a>
            </nav>
        </div>
    </nav>
</div>