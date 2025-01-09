<a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseInventory" aria-expanded="false" aria-controls="collapseAccounts">
    <div class="sb-nav-link-icon"><i class="fa fa-shopping-cart"></i></div>
    Inventory
    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
</a>
<div class="collapse" id="collapseInventory" aria-labelledby="headingInventory" data-bs-parent="#sidenavAccordion">
    <nav class="sb-sidenav-menu-nested nav accordion" id="sideNavProducts">
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#head_child" aria-expanded="false" aria-controls="head_child">
            Products
            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
        </a>
        <div class="collapse" id="head_child" aria-labelledby="headingOne" data-bs-parent="#sideNavProducts">
            <nav class="sb-sidenav-menu-nested nav">
                @can('create_product')
                <a class="nav-link @if (Route::is('products.create')) active @endif" href="{{route('products.create')}}">New Product</a>
                @endcan
                @can('view_product')
                <a class="nav-link @if (Route::is('products.*') && !Route::is('products.create')) active @endif" href="{{route('products.index')}}">Products List</a>
                @endcan
                @can('view_product_unit')
                <a class="nav-link @if (Route::is('products-unit.*')) active @endif" href="{{route('products-unit.index')}}">Product Unit</a>
                @endcan
            </nav>
        </div>
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#QuotationMenu" aria-expanded="false" aria-controls="QuotationMenu">
            Quotations
            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
        </a>
        <div class="collapse" id="QuotationMenu" aria-labelledby="headingOne" data-bs-parent="#sideNavProducts">
            <nav class="sb-sidenav-menu-nested nav">
                @can('create_quotation')
                <a class="nav-link @if (Route::is('quotations.create')) active @endif" href="{{route('quotations.create')}}">New Quotation</a>
                @endcan
                @can('view_quotation')
                <a class="nav-link @if (Route::is('quotations.*') && !Route::is('quotations.create')) active @endif" href="{{route('quotations.index')}}">Quotation List</a>
                @endcan
            </nav>
        </div>
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#SalesMenu" aria-expanded="false" aria-controls="SalesMenu">
            Sales
            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
        </a>
        <div class="collapse" id="SalesMenu" aria-labelledby="headingOne" data-bs-parent="#sideNavProducts">
            <nav class="sb-sidenav-menu-nested nav">
                @can('create_sales')
                <a class="nav-link @if (Route::is('sales.create')) active @endif" href="{{route('sales.create')}}">New Sale</a>
                @endcan
                @can('view_sales')
                <a class="nav-link @if (Route::is('sales.*') && !Route::is('sales.create')) active @endif" href="{{route('sales.index')}}">Sale List</a>
                @endcan
            </nav>
        </div>
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#PurchaseMenu" aria-expanded="false" aria-controls="PurchaseMenu">
            Purchase
            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
        </a>
        <div class="collapse" id="PurchaseMenu" aria-labelledby="headingOne" data-bs-parent="#sideNavProducts">
            <nav class="sb-sidenav-menu-nested nav">
                @can('create_purcahse')
                <a class="nav-link @if (Route::is('purchases.create')) active @endif" href="{{route('purchases.create')}}">New Purchase</a>
                @endcan
                @can('view_purcahse')
                <a class="nav-link @if (Route::is('purchases.*') && !Route::is('purchases.create')) active @endif" href="{{route('purchases.index')}}">Purchase List</a>
                @endcan
            </nav>
        </div>
    </nav>
</div>
<a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseAccounts" aria-expanded="false" aria-controls="collapseAccounts">
    <div class="sb-nav-link-icon"><i class="fa fa-bar-chart"></i></div>
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
                @can('view_ledger')
                <a class="nav-link @if (Route::is('ledger.*')) active @endif" href="{{route('ledger.index')}}">Ledger</a>
                @endcan
                @can('view_party_type')
                <a class="nav-link @if (Route::is('subledger-type.*')) active @endif" href="{{route('subledger-type.index')}}">Party Type</a>
                @endcan
                @can('view_party')
                <a class="nav-link @if (Route::is('sub-ledger.*')) active @endif" href="{{route('sub-ledger.index')}}">Party</a>
                @endcan
                @can('view_work_order')
                <a class="nav-link @if (Route::is('work-order.*')) active @endif" href="{{route('work-order.index')}}">Work Order</a>
                @endcan
                @can('view_work_order_site')
                <a class="nav-link @if (Route::is('work-order-sites.*')) active @endif" href="{{route('work-order-sites.index')}}">W/O Sites</a>
                @endcan
            </nav>
        </div>
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseJournal" aria-expanded="false" aria-controls="collapseJournal">
            Journal
            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
        </a>
        <div class="collapse" id="collapseJournal" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
            <nav class="sb-sidenav-menu-nested nav">
                @can('view_cash_payment')
                <a class="nav-link @if (Route::is('multi-cash-payment.*')) active @endif" href="{{route('multi-cash-payment.index')}}">Cash Payment</a>
                @endcan
                @can('view_bank_payment')
                <a class="nav-link @if (Route::is('multi-bank-payment.*')) active @endif" href="{{route('multi-bank-payment.index')}}">Bank Payment</a>
                @endcan
                @can('view_cash_recieve')
                <a class="nav-link @if (Route::is('multi-cash-receive.*')) active @endif" href="{{route('multi-cash-receive.index')}}">Cash Recieve</a>
                @endcan
                @can('view_bank_recieve')
                <a class="nav-link @if (Route::is('multi-bank-receive.*')) active @endif" href="{{route('multi-bank-receive.index')}}">Bank Recieve</a>
                @endcan
                @can('view_journal')
                <a class="nav-link @if (Route::is('journal.*') && !Route::is('journal.work_order.*')) active @endif" href="{{route('journal.index')}}">Misc. Journal</a>
                @endcan
                @can('view_work_order_journal')
                <a class="nav-link @if (Route::is('journal.work_order.*')) active @endif" href="{{route('journal.work_order.index')}}">W/O Journal</a>
                @endcan
                @can('view_opening_balance')
                <a class="nav-link @if (Route::is('opening-balance.*')) active @endif" href="{{route('opening-balance.index')}}">Opening Balance</a>
                @endcan
            </nav>
        </div>
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseApprovalAccounting" aria-expanded="false" aria-controls="collapseApprovalAccounting">
            Approval
            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
        </a>
        <div class="collapse" id="collapseApprovalAccounting" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
            <nav class="sb-sidenav-menu-nested nav">
                @can('view_pending_vocuher')
                <a class="nav-link @if (Route::is('voucher.approval_index')) active @endif" href="{{route('voucher.approval_index')}}">Pending</a>
                @endcan
                @can('view_rejected_vocuher')
                <a class="nav-link @if (Route::is('reject_by_accountant.index')) active @endif" href="{{route('reject_by_accountant.index')}}">Rejected</a>
                @endcan
            </nav>
        </div>
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseReportsAccounting" aria-expanded="false" aria-controls="collapseReportsAccounting">
            Reports
            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
        </a>
        <div class="collapse" id="collapseReportsAccounting" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
            <nav class="sb-sidenav-menu-nested nav">
                @can('cashbook_report')
                <a class="nav-link @if (Route::is('accountings.cashbook')) active @endif" href="{{route('accountings.cashbook')}}">Cashbook</a>
                @endcan
                @can('bankbook_report')
                <a class="nav-link @if (Route::is('accountings.bankbook')) active @endif" href="{{route('accountings.bankbook')}}">Bankbook</a>
                @endcan
                @can('ledger_report')
                <a class="nav-link @if (Route::is('accountings.ledger_report')) active @endif" href="{{route('accountings.ledger_report')}}">Ledger Report</a>
                @endcan
                @can('party_report')
                <a class="nav-link @if (Route::is('accountings.sub_ledger_report')) active @endif" href="{{route('accountings.sub_ledger_report')}}">Party Report</a>
                @endcan
                @can('party_summary_report')
                <a class="nav-link @if (Route::is('accountings.sub_ledger_summary_report')) active @endif" href="{{route('accountings.sub_ledger_summary_report')}}">Party Summary</a>
                @endcan
                @can('work_order_report')
                <a class="nav-link @if (Route::is('accountings.work_order_report')) active @endif" href="{{route('accountings.work_order_report')}}">Work Order Report</a>
                @endcan
                @can('work_order_summary_report')
                <a class="nav-link @if (Route::is('accountings.work_order_summary_report')) active @endif" href="{{route('accountings.work_order_summary_report')}}">W/O Summary</a>
                @endcan
                @can('work_order_pl_report')
                <a class="nav-link @if (Route::is('work-orders.pl_report')) active @endif" href="{{route('work-orders.pl_report')}}">W/O Profit Loss</a>
                @endcan
                @can('work_order_asset_liability_report')
                <a class="nav-link @if (Route::is('work-orders.balance_sheet_report')) active @endif" href="{{route('work-orders.balance_sheet_report')}}">W/O Asset and Liability</a>
                @endcan
                @can('work_order_reciept_payemnt_report')
                <a class="nav-link @if (Route::is('work-orders.receive_payment_report')) active @endif" href="{{route('work-orders.receive_payment_report')}}">W/O Receipt & Payment</a>
                @endcan
                @can('reciept_payemnt_report')
                <a class="nav-link @if (Route::is('accountings.receive_payment_report')) active @endif" href="{{route('accountings.receive_payment_report')}}">Receipt & Payment Report</a>
                @endcan
                @can('balancesheet_report')
                <a class="nav-link @if (Route::is('accountings.balancesheet')) active @endif" href="{{route('accountings.balancesheet')}}">Balance Sheet</a>
                @endcan
                @can('trial_report')
                <a class="nav-link @if (Route::is('accountings.trial_balance')) active @endif" href="{{route('accountings.trial_balance')}}">Trial Balance</a>
                @endcan
                @can('income_statement_report')
                <a class="nav-link @if (Route::is('accountings.income_statement')) active @endif" href="{{route('accountings.income_statement')}}">Income Statement</a>
                @endcan
            </nav>
        </div>
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseAccountingConfig" aria-expanded="false" aria-controls="collapseAccountingConfig">
            Config
            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
        </a>
        <div class="collapse" id="collapseAccountingConfig" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
            <nav class="sb-sidenav-menu-nested nav">
                @can('accounting_report_config')
                <a class="nav-link @if (Route::is('accountings.report-config')) active @endif" href="{{route('accountings.report-config')}}">Report</a>
                @endcan
                @can('day_closing')
                <a class="nav-link @if (Route::is('accountings.day_closing_list')) active @endif" href="{{route('accountings.day_closing_list')}}">Day Close</a>
                @endcan
            </nav>
        </div>
    </nav>
</div>