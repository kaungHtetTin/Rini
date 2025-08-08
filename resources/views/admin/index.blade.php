@php
    $total_demand = 0;
    foreach ($demanding_products as $dproduct){
        $total_demand += $dproduct->total_quantity;
    }

    function formatCount($count){
        if($count<1000) return $count;
        else if($count>=1000 && $count<1000000) return floor($count/1000).'k';
        else return floor($count/1000000).'M';
    }

    $user = Auth::user();

@endphp
@extends('admin.master')
@section('content')
<style>
        .demanding-product{
            display: flex;
            cursor: pointer;
            padding:5px;
            border-radius: 5px;
        }

        .demanding-product:hover{
          background: #dbe7ff;
        }

        .demanding-product .image img{
            width: 25px;
            border-radius: 3px;
            margin-right: 10px;
        }

        .demanding-product .title{
             flex: 1;
             color:#444;
        }

        .demanding-product .quantity{
            min-width: 20px;
            text-align: center;
            height: 20px;
            padding:3px;
            background: red;
            color:white;
            border-radius: 50%;
            font-weight: bold;
            margin-top: 5px;
        }

         .demanding-product .count{
            min-width: 20px;
            text-align: center;
            height: 20px;
            padding:3px;
            color:#777;
            border-radius: 50%;
            margin-top: 5px;
        }

    </style>
    
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        </div>
        <!-- Content Row -->
        <div class="row">
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Earnings (Monthly)</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$monthly_earning}} KS</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Earnings (Annual)</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$annual_earning}} KS</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Customer
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$total_customer}}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    New Orders</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"> {{$new_orders}} </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-cart-plus fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Row -->

        <div class="row">
            <!-- Area Chart -->
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                aria-labelledby="dropdownMenuLink">
                                <div class="dropdown-header">Dropdown Header:</div>
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="mySaleChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Demand Now</h6>
                        <div style="background:red;color:white;padding:3px; border-radius:7px; font-weight:bold;min-width:25px;text-align:center;font-size:12px;">
                            {{$total_demand}}
                        </div>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        @if (count($demanding_products) > 0)
                            @foreach ($demanding_products as $dproduct)
                                <a href="{{route('admin.products-edit',$dproduct->product_id)}}" style="text-decoration: none">
                                    <div class="demanding-product">
                                        <div class="image">
                                            <img src="http://localhost/rini/storage/app/public/{{$dproduct->product->image_url}}" alt="" srcset="">
                                        </div>
                                        <div class="title">{{$dproduct->product->title}}</div>
                                        <div class="quantity" style="font-size: 10px;"> {{$dproduct->total_quantity}}</div>
                                    </div>
                                </a>
                            @endforeach
                        @else
                            No Demand for Product now.
                        @endif
                        
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="{{asset('adm/vendor/chart.js/Chart.min.js')}}"></script>
    <script>
        let saleOfYear = @json($saleOfYear);
     
        Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.global.defaultFontColor = '#858796';
        
        var dataSale=[];
       
        for(var i=0;i<12;i++){
            var month=i+1;
            var trx=saleOfYear.filter(element => element.month==month);
            if(trx.length>0){
                dataSale[i]=trx[0].amount;
            }else{
                dataSale[i]=0;
            }

           
        }

        function number_format(number, decimals, dec_point, thousands_sep) {
            // *     example: number_format(1234.56, 2, ',', ' ');
            // *     return: '1 234,56'
            number = (number + '').replace(',', '').replace(' ', '');
            var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                s = '',
                toFixedFix = function(n, prec) {
                var k = Math.pow(10, prec);
                return '' + Math.round(n * k) / k;
                };
            // Fix for IE parseFloat(0.55).toFixed(0) = 0;
            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }
            return s.join(dec);
        }

    
        var ctx = document.getElementById("mySaleChart");
        var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [
                    {
                        label: "Sale",
                        lineTension: 0.3,
                        backgroundColor: "#4e73df10",
                        borderColor: "#4e73df",
                        pointRadius: 3,
                        pointBackgroundColor: "#4e73df",
                        pointBorderColor: "#4e73df",
                        pointHoverRadius: 3,
                        pointHoverBackgroundColor: "#4e73df",
                        pointHoverBorderColor: "#4e73df",
                        pointHitRadius: 10,
                        pointBorderWidth: 2,
                        data: dataSale,
                    },
                ],
            },
            options: {
                maintainAspectRatio: false,
                layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                }
                },
                scales: {
                xAxes: [{
                    time: {
                    unit: 'date'
                    },
                    gridLines: {
                    display: false,
                    drawBorder: false
                    },
                    ticks: {
                    maxTicksLimit: 7
                    }
                }],
                yAxes: [{
                    ticks: {
                    maxTicksLimit: 5,
                    padding: 10,
                    // Include a dollar sign in the ticks
                    callback: function(value, index, values) {
                        return 'mmk ' + number_format(value);
                    }
                    },
                    gridLines: {
                    color: "rgb(234, 236, 244)",
                    zeroLineColor: "rgb(234, 236, 244)",
                    drawBorder: false,
                    borderDash: [2],
                    zeroLineBorderDash: [2]
                    }
                }],
                },
                legend: {
                display: false
                },
                tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                titleMarginBottom: 10,
                titleFontColor: '#6e707e',
                titleFontSize: 14,
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                intersect: false,
                mode: 'index',
                caretPadding: 10,
                callbacks: {
                    label: function(tooltipItem, chart) {
                    var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                    return datasetLabel + ': mmk ' + number_format(tooltipItem.yLabel);
                    }
                }
                }
            }
        });
    </script>
@endsection