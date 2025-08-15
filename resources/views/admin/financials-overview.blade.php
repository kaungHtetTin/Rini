@extends('admin.master')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Financial Overview</h1>
        </div>

        <div class="row">
            <!-- Area Chart -->
            <div class="col-12">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Earnings Overview - {{$year}}</h6>
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
                        <div class="mt-4 small">
                            <span class="mr-2">
                                <i class="fas fa-circle" style="color:#e83e8c "></i> Sale
                            </span>
                            <span class="mr-2">
                                <i class="fas fa-circle" style="color:#e74a3b "></i> Cost
                            </span>
                            <span class="mr-2">
                                <i class="fas fa-circle" style="color:#1cc88a "></i> Earning
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Sale, Cost and Earning</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                         
                        <h6 class="mt-4"> <i class="fas fa-circle" style="color:#e83e8c "></i> Sales:</h6>
                        <div class="small" style="display: flex">
                            
                            <table class="" style="flex: 1">
                                <tr>
                                    <td width="100px"> Today</td>
                                    <td>{{$sale_today}} ks</td>
                                </tr>
                                <tr>
                                    <td>Current Month</td>
                                    <td>{{$sale_current_month}} ks</td>
                                </tr>
                            </table>
                            <table class="" style="flex: 1">
                                <tr>
                                    <td width="100px">Current year</td>
                                    <td>{{$sale_current_year}} ks</td>
                                </tr>
                                <tr>
                                    <td>All Time</td>
                                    <td>{{$sale_all_time}} ks</td>
                                </tr>
                            </table>
                        </div>
                        <h6 class="mt-4"><i class="fas fa-circle" style="color:#e74a3b "></i> Cost:</h6>
                        <div class="small" style="display: flex">
                            
                            <table class="" style="flex: 1">
                                <tr>
                                    <td width="100px"> Today</td>
                                    <td>{{$cost_today}} ks</td>
                                </tr>
                                <tr>
                                    <td>Current Month</td>
                                    <td>{{$cost_current_month}} ks</td>
                                </tr>
                            </table>
                            <table class="" style="flex: 1">
                                <tr>
                                    <td width="100px">Current year</td>
                                    <td>{{$cost_current_year}} ks</td>
                                </tr>
                                <tr>
                                    <td>All Time</td>
                                    <td>{{$cost_all_time}} ks</td>
                                </tr>
                            </table>
                        </div>

                        <h6 class="mt-4"> <i class="fas fa-circle" style="color:#1cc88a "></i> Earning:</h6>
                        <div class="small" style="display: flex">
                            
                            <table class="" style="flex: 1">
                                <tr>
                                    <td width="100px"> Today</td>
                                    <td>{{$sale_today - $cost_today}} ks</td>
                                </tr>
                                <tr>
                                    <td>Current Month</td>
                                    <td>{{$sale_current_month - $cost_current_month}} ks</td>
                                </tr>
                            </table>
                            <table class="" style="flex: 1">
                                <tr>
                                    <td width="100px">Current year</td>
                                    <td>{{$sale_current_year - $cost_current_year}} ks</td>
                                </tr>
                                <tr>
                                    <td>All Time</td>
                                    <td>{{$sale_all_time - $cost_all_time}} ks</td>
                                </tr>
                            </table>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Costs - {{$year}}</h6>
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
                        <div class="chart-pie pt-4 pb-2">
                            <canvas id="costPieChart"></canvas>
                        </div>
                        <div class="mt-4 text-center small" id="costPieLabelContainer">
                        </div>

                        <div class="mt-4">
                            Total: <span id="costPieTotal"> </span> ks
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Costs - All</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="chart-pie pt-4 pb-2">
                            <canvas id="allCostPieChart"></canvas>
                        </div>
                        <div class="mt-4 text-center small" id="allCostPieLabelContainer">
                             
                        </div>
                        <div class="mt-4">
                            Total: <span id="allCostPieTotal"> </span> ks
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{asset('adm/vendor/chart.js/Chart.min.js')}}"></script>
    <script>
        {
            let saleOfYear = @json($saleOfYear);
            let costOfYear = @json($costOfYear);
            Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
            Chart.defaults.global.defaultFontColor = '#858796';
            
            var dataSale=[];
            var dataCost=[];
            var dataEar=[];

            for(var i=0;i<12;i++){
                var month=i+1;
                var trx=saleOfYear.filter(element => element.month==month);
                if(trx.length>0){
                    dataSale[i]=trx[0].amount;
                }else{
                    dataSale[i]=0;
                }

                var wdr=costOfYear.filter(element => element.month==month);
                if(wdr.length>0){
                    dataCost[i]=wdr[0].amount;
                }else{
                    dataCost[i]=0;
                }

                dataEar[i] = dataSale[i]  - dataCost[i];
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
                            data: dataSale,
                        },
                        {
                            label: "Cost",
                            lineTension: 0.3,
                            backgroundColor: "#e74a3b10",
                            borderColor: "#e74a3b",
                            pointRadius: 3,
                            pointBackgroundColor: "#e74a3b",
                            pointBorderColor: "#e74a3b",
                            pointHoverRadius: 3,
                            pointHoverBackgroundColor: "#e74a3b",
                            pointHoverBorderColor: "#e74a3b",
                            pointHitRadius: 10,
                            pointBorderWidth: 2,
                            data: dataCost,
                        },
                        {
                            label: "Earning",
                            lineTension: 0.3,
                            backgroundColor: "#1cc88a10",
                            borderColor: "#1cc88a",
                            pointRadius: 3,
                            pointBackgroundColor: "#1cc88a",
                            pointBorderColor: "#1cc88a",
                            pointHoverRadius: 3,
                            pointHoverBackgroundColor: "#1cc88a",
                            pointHoverBorderColor: "#1cc88a",
                            pointHitRadius: 10,
                            pointBorderWidth: 2,
                            data: dataEar,
                        }
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
        }
    </script>

    <script>
        {
            let colorArr = [
                "#e83e8c",
                "#36b9cc",
                "#1cc88a",
                "#e74a3b",
                "#f6c23e",
                "#e74a3b",

            ];

            Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
            Chart.defaults.global.defaultFontColor = '#858796';

            let costs = @json($costs);

            let __labels = [];
            let __colors = [];
            let __data = [];
            let total_cost = 0;
            for(let i =0; i<costs.length; i++){
                let cost = costs[i];
                __labels[i] = cost.category;
                __data[i] = cost.amount;
                total_cost+=(cost.amount)*1;
                let colorIndex = i;
                if(colorIndex>=colorArr.length) colorIndex = 0;
                __colors[i] = colorArr[colorIndex];

                $('#costPieLabelContainer').append(`
                    <span class="mr-2">
                        <i class="fas fa-circle" style="color:${colorArr[colorIndex]}"></i> ${cost.category}
                    </span>
                `)
                
            }

            $('#costPieTotal').html(total_cost);

            // Pie Chart Example
            var ctx = document.getElementById("costPieChart");
            var costPieChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: __labels,
                datasets: [{
                data: __data,
                backgroundColor: __colors,
                hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
                },
                legend: {
                display: false
                },
                cutoutPercentage: 80,
            },
            });

             
        }
    </script>

    <script>
        {
            let colorArr = [
                "#e83e8c",
                "#36b9cc",
                "#1cc88a",
                "#e74a3b",
                "#f6c23e",
                "#e74a3b",
            ];

            Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
            Chart.defaults.global.defaultFontColor = '#858796';

            let costs = @json($allCosts);

            let __labels = [];
            let __colors = [];
            let __data = [];
            let total_cost = 0;

            for(let i =0; i<costs.length; i++){
                let cost = costs[i];
                __labels[i] = cost.category;
                __data[i] = cost.amount;
                total_cost += (cost.amount)*1;

                let colorIndex = i;
                if(colorIndex>=colorArr.length) colorIndex = 0;
                __colors[i] = colorArr[colorIndex];

                $('#allCostPieLabelContainer').append(`
                    <span class="mr-2">
                        <i class="fas fa-circle" style="color:${colorArr[colorIndex]}"></i> ${cost.category}
                    </span>
                `)
                
            }

            $('#allCostPieTotal').html(total_cost);

            // Pie Chart Example
            var ctx = document.getElementById("allCostPieChart");
            var costPieChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: __labels,
                datasets: [{
                data: __data,
                backgroundColor: __colors,
                hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
                },
                legend: {
                display: false
                },
                cutoutPercentage: 80,
            },
            });

             
        }
    </script>

@endsection