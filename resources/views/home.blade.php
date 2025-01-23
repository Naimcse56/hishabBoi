@extends('layouts.admin_app')
@section('title')
Dashboard
@endsection

@section('content')
<div class="container-fluid px-4">
    <h4 class="mt-4 black">Dashboard</h4>
    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="card card-custom green">
                                <div><h4 class="amount"> {{currencySymbol($closing_cash)}}</h4>
                                </div>
                                <div class="text-white">Current Cash</div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="card card-custom blue">
                                <div><h4 class="amount"> {{currencySymbol($closing_bank)}}</h4>
                                </div>
                                <div class="text-white">Current Bank</div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="card card-custom red">
                                <div><h4 class="amount"> {{currencySymbol($closing_payable)}}</h4>
                                </div>
                                <div class="text-white">Current Payable</div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="card card-custom pink">
                                <div><h4 class="amount"> {{currencySymbol($closing_recievable)}}</h4>
                                </div>
                                <div class="text-white">Current Recievable</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="fw-semibold">Income VS Expense</p>
                            <div class="card">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">Month</th>
                                            <th scope="col" class="text-end">Income</th>
                                            <th scope="col" class="text-end">Expense</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($income_expense_array as $income_expense)
                                            <tr>
                                                <td>{{ $income_expense["month"] }}</td>
                                                <td class="text-end">{{ currencySymbol($income_expense['income']) }}</td>
                                                <td class="text-end">{{ currencySymbol($income_expense['expense']) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                  </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <p class="fw-semibold">Asset VS Liabilities</p>
                            <div class="card">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">Month</th>
                                            <th scope="col" class="text-end">Asset</th>
                                            <th scope="col" class="text-end">Liability</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($asset_liability_array as $asset_liability)
                                            <tr>
                                                <td>{{ $income_expense["month"] }}</td>
                                                <td class="text-end">{{ currencySymbol($asset_liability['liability']) }}</td>
                                                <td class="text-end">{{ currencySymbol($asset_liability['asset']) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                  </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div id="income_chart"></div>
                        </div>
                        <div class="col-md-6">
                            <div id="expense_chart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script src="{{asset('assets/plugins/chart/google_chart.min.js')}}"></script>
    <script type="text/javascript">
        // Load the Google Chart library
        google.charts.load('current', {
            packages: ['corechart', 'line']
        });

        // Draw the charts when the library is loaded
        google.charts.setOnLoadCallback(drawCharts);

        function drawCharts() {
            // Income Chart Data
            var incomeData = google.visualization.arrayToDataTable([
                ['Month', 'Income'],
                @foreach ($income_chart_array as $data)
                    ['{{ $data[0] }}', {{ $data[1] }}],
                @endforeach
            ]);

            var incomeOptions = {
                title: 'Monthly Income',
                curveType: 'function',
                legend: { position: 'bottom' },
                hAxis: {
                    title: 'Month',
                    format: '0'
                },
                vAxis: {
                    title: 'Income',
                    format: 'currency'
                }
            };

            var incomeChart = new google.visualization.LineChart(document.getElementById('income_chart'));
            incomeChart.draw(incomeData, incomeOptions);

            // Expense Chart Data
            var expenseData = google.visualization.arrayToDataTable([
                ['Month', 'Expense'],
                @foreach ($expense_chart_array as $data)
                    ['{{ $data[0] }}', {{ $data[1] }}],
                @endforeach
            ]);

            var expenseOptions = {
                title: 'Monthly Expense',
                curveType: 'function',
                legend: { position: 'bottom' },
                hAxis: {
                    title: 'Month',
                    format: '0'
                },
                vAxis: {
                    title: 'Expense',
                    format: 'currency'
                }
            };

            var expenseChart = new google.visualization.LineChart(document.getElementById('expense_chart'));
            expenseChart.draw(expenseData, expenseOptions);
        }
    </script>
@endpush
