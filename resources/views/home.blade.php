@extends('layouts.admin_app')
@section('title')
Dashboard
@endsection

@section('content')
<div class="container-fluid px-4">
    <h4 class="mt-4 black">Dashboard</h4>
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card card-custom mb-4">
                <div class="green">
                 <i class="fa fa-usd"></i>
                </div>
                <div><h4 class="amount"> {{currencySymbol($closing_cash)}}</h4>
                </div>
                <div class="about">Cash Transaction Summary</div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card card-custom mb-4">
                <div class="blue">
                 <i class="fa fa-usd"></i>
                </div>
                <div><h4 class="amount"> {{currencySymbol($closing_bank)}}</h4>
                </div>
                <div class="about">Bank Transaction Summary
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card card-custom mb-4">
                <div class="red">
                 <i class="fa fa-usd"></i>
                </div>
                <div><h4 class="amount"> {{currencySymbol($closing_payable)}}</h4>
                </div>
                <div class="about">Account Payable Summary
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card card-custom mb-4">
                <div class="pink">
                 <i class="fa fa-usd"></i>
                </div>
                <div><h4 class="amount"> {{currencySymbol($closing_recievable)}}</h4>
                </div>
                <div class="about">Account Receivable Summary
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div id="chartContainerCash"></div>
        </div>
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div id="chartContainerBank"></div>
        </div>
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div id="chartContainerReceivable"></div>
        </div>
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div id="chartContainerPayable"></div>
        </div>


    </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
    window.onload = function() {
    
        var options = {
            exportEnabled: true,
            animationEnabled: true,
            title:{
                text: "Cash Summary"
            },
            legend:{
                horizontalAlign: "right",
                verticalAlign: "center"
            },
            data: [{
                type: "pie",
                showInLegend: true,
                toolTipContent: "<b>{name}</b>: ${y}",
                indexLabel: "{name}",
                legendText: "{name}",
                indexLabelPlacement: "inside",
                dataPoints: [
                    { y: {{$opening_cash}}, name: "Opening" },
                    { y: {{$pay_cash}}, name: "Payment" },
                    { y: {{$rcv_cash}}, name: "Receipt" },
                    { y: {{$closing_cash}}, name: "Current Balance" }
                ]
            }]
        };
        $("#chartContainerCash").CanvasJSChart(options);
    
        var options = {
            exportEnabled: true,
            animationEnabled: true,
            title:{
                text: "Bank Summary"
            },
            legend:{
                horizontalAlign: "right",
                verticalAlign: "center"
            },
            data: [{
                type: "pie",
                showInLegend: true,
                toolTipContent: "<b>{name}</b>: ${y}",
                indexLabel: "{name}",
                legendText: "{name}",
                indexLabelPlacement: "inside",
                dataPoints: [
                    { y: {{$opening_bank}}, name: "Opening" },
                    { y: {{$pay_bank}}, name: "Payment" },
                    { y: {{$rcv_bank}}, name: "Receipt" },
                    { y: {{$closing_bank}}, name: "Current Balance" }
                ]
            }]
        };
        $("#chartContainerBank").CanvasJSChart(options);
    
        var options = {
            exportEnabled: true,
            animationEnabled: true,
            title:{
                text: "Receivable Summary"
            },
            legend:{
                horizontalAlign: "right",
                verticalAlign: "center"
            },
            data: [{
                type: "pie",
                showInLegend: true,
                toolTipContent: "<b>{name}</b>: ${y}",
                indexLabel: "{name}",
                legendText: "{name}",
                indexLabelPlacement: "inside",
                dataPoints: [
                    { y: {{$opening_recievable}}, name: "Opening" },
                    { y: {{$pay_recievable}}, name: "Payment" },
                    { y: {{$rcv_recievable}}, name: "Receipt" },
                    { y: {{$closing_recievable}}, name: "Current Balance" }
                ]
            }]
        };
        $("#chartContainerReceivable").CanvasJSChart(options);
        
        var options = {
            exportEnabled: true,
            animationEnabled: true,
            title:{
                text: "Payable Summary"
            },
            legend:{
                horizontalAlign: "right",
                verticalAlign: "center"
            },
            data: [{
                type: "pie",
                showInLegend: true,
                toolTipContent: "<b>{name}</b>: ${y}",
                indexLabel: "{name}",
                legendText: "{name}",
                indexLabelPlacement: "inside",
                dataPoints: [
                    { y: {{$opening_payable}}, name: "Opening" },
                    { y: {{$pay_payable}}, name: "Payment" },
                    { y: {{$rcv_payable}}, name: "Receipt" },
                    { y: {{$closing_payable}}, name: "Current Balance" }
                ]
            }]
        };
        $("#chartContainerPayable").CanvasJSChart(options);
    
    }
</script>
<script src="{{asset('assets/plugins/chart/canvasjs.min.js')}}"></script>
@endpush
