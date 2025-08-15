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
            <h1 class="h3 mb-0 text-gray-800">Sale Overview</h1>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Daily Sale Rate - {{date('M')}}, {{$year}}</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="dailySaleChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-6">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Trending Products - {{$year}}</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        @if (count($trending_products) > 0)
                            @foreach ($trending_products as $key=>$dproduct)
                                <a href="{{route('admin.products-edit',$dproduct->product_id)}}" style="text-decoration: none">
                                    <div class="demanding-product">
                                        <div class="image">
                                            <img src="https://www.riniforyou.com/storage/app/public/{{$dproduct->product->image_url}}" alt="" srcset="">
                                        </div>
                                        <div class="title">{{$dproduct->product->title}}</div>
                                        <div class="count" style="font-size: 12px;"> <i class="fas fa-shopping-cart"></i>  {{$dproduct->total_quantity}} .</div>
                                        <div class="count" style="font-size: 12px;"> <i class="far fa-eye"></i> {{formatCount($dproduct->product->view)}}</div>
                                    </div>
                                </a>
                            @endforeach
                        @else
                            No trending product
                        @endif
                        
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-6">
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
                                            <img src="https://www.riniforyou.com/storage/app/public/{{$dproduct->product->image_url}}" alt="" srcset="">
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

             <!-- Area Chart -->
            <div class="col-12">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Trending - {{$year}}</h6>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                aria-labelledby="dropdownMenuLink">
                                <div class="dropdown-header">Select Year:</div>
                                 @php
                                    $year = date('Y');
                                @endphp
                                @for ($i = $year; $i >=2025; $i--)
                                    <a class="dropdown-item" href="?year={{$i}}">{{$i}}</a>
                                @endfor
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
        </div>
    </div>

    <script src="{{asset('adm/vendor/chart.js/Chart.min.js')}}"></script>
    <script>
        {
            let saleRateByCategory = @json($saleRateByCategory);
            let product_categories = @json($product_categories);
            Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
            Chart.defaults.global.defaultFontColor = '#858796';
            
            let __data=[];
            let __label = [];

            for(var i=0;i<product_categories.length ;i++){
                let category = product_categories[i];
                 __data[i] = 0;
                saleRateByCategory.forEach(sale => {
                    if(sale.product_category_id == category.id){
                        __data[i] = sale.total_quantity;
                       
                    }
                });

                 __label[i] = category.category;

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
                    labels: __label,
                    datasets: [
                        {
                            label: "Sale",
                            lineTension: 0.3,
                            backgroundColor: "#e83e8c10",
                            borderColor: "#e83e8c",
                            pointRadius: 3,
                            pointBackgroundColor: "#e83e8c",
                            pointBorderColor: "#e83e8c",
                            pointHoverRadius: 3,
                            pointHoverBackgroundColor: "#e83e8c",
                            pointHoverBorderColor: "#e83e8c",
                            pointHitRadius: 10,
                            pointBorderWidth: 2,
                            data: __data,
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
                            return number_format(value);
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
                        return datasetLabel+': ' + number_format(tooltipItem.yLabel)+' item(s)';
                        }
                    }
                    }
                }
            });
        }
    </script>

    <script>
        {
            let month = "{{date('m')}}";
            let M = "{{date('M')}}";
            let year = "{{date('Y')}}";
            month = month*1;
            let daily_sale_rates = @json($daily_sale_rates);
            
           
            Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
            Chart.defaults.global.defaultFontColor = '#858796';
            
            let __data=[];
            let __label = [];

            $day_count = 0;
            switch (month){
                case 9:
                case 4:
                case 6:
                case 11:
                    $day_count = 30;
                    break;
                case 2:
                    $day_count = 28;
                    if(year%4==0){
                        $day_count = 29;
                        if(year%100 ==0){
                            if(year%400 != 0){
                                $day_count = 28;
                            }
                        }
                    }
                    break;
                default:
                    $day_count = 31;
            }

            for(var i=0;i<$day_count ;i++){
                let day = i+1;
                __label[i] = M+'-'+day;
                __data[i] = 0;
                daily_sale_rates.forEach(sale => {
                   if(sale.day == day){
                    __data[i] = sale.total_quantity;
                   }
                });
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

        
            var ctx = document.getElementById("dailySaleChart");
            var myLineChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: __label,
                    datasets: [
                        {
                            label: "Sale",
                            lineTension: 0.3,
                            backgroundColor: "#e83e8c10",
                            borderColor: "#e83e8c",
                            pointRadius: 3,
                            pointBackgroundColor: "#e83e8c",
                            pointBorderColor: "#e83e8c",
                            pointHoverRadius: 3,
                            pointHoverBackgroundColor: "#e83e8c",
                            pointHoverBorderColor: "#e83e8c",
                            pointHitRadius: 10,
                            pointBorderWidth: 2,
                            data: __data,
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
                            return number_format(value);
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
                        return datasetLabel+': ' + number_format(tooltipItem.yLabel)+' item(s)';
                        }
                    }
                    }
                }
            });
        }
    </script>

@endsection