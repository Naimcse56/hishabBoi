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
                        <div class="col-md-12">
                            <div class="card">
                                <div class="text-white chart_div_custom" id="chart_div"></div>
                            </div>
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
    <script>
        (function($) {
            "use strict";
            
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Month', 'Income', 'Expenses'],
                ['2013',  1000,      400],
                ['2014',  1170,      460],
                ['2015',  660,       1120],
                ['2016',  1030,      540]
            ]);

            var options = {
                title: 'Income VS Expense',
                hAxis: {title: 'Month',  titleTextStyle: {color: '#333'}},
                vAxis: {minValue: 0}
            };

            var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
            chart.draw(data, options);
            }
        })(jQuery);
    </script>
@endpush
