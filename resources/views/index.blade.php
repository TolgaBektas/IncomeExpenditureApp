@extends('layouts.admin')
@section('title')
    Income Expenditure
@endsection
@section('css')
@endsection
@section('content')
    <div class="row">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Current Month Income-Expenditure Graphics</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>${{ $total_month_income }}</h3>
                                <p>Monthly Income</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="{{ route('income.index') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>${{ $total_month_expenditure }}</h3>
                                <p>Monthly Expenditure</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="{{ route('expenditure.index') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <figure class="highcharts-figure">
                            <div id="container1"></div>
                        </figure>
                    </div>


                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-8">
                        <h3 class="card-title">Current Year Income-Expenditure Graphics</h3>
                    </div>

                    <div class="col-md-4">
                        <div class="card-tools float-end">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <form action="" method="GET" class="float-end">
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Select Year
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" name="year" id="year">
                                    @foreach ($years as $year)
                                        <li><a class="dropdown-item" name="query"
                                                href="{{ route('index', 'q=' . $year) }}">{{ $year }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <figure class="highcharts-figure">
                            <div id="container2"></div>
                        </figure>
                    </div>
                    <div class="col-md-4">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>${{ $total_year_income }}</h3>
                                <p>Yearly Income</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="{{ route('income.index') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>${{ $total_year_expenditure }}</h3>
                                <p>Yearly Expenditure</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="{{ route('expenditure.index') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>

    <script>
        Highcharts.chart('container1', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: ''
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.y:.1f}$</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.y:.1f}'

                    },
                    showInLegend: true
                }
            },
            series: [{
                name: 'Total Price',
                colorByPoint: true,
                data: [{
                    color:'#28a745',
                        name: 'Monthly Income',
                        y: {{ $total_month_income }}
                    },
                    {
                        color:'#dc3545',
                        name: 'Monthly Expenditure',
                        y: {{ $total_month_expenditure }}
                    },
                ]
            }]
        });
        Highcharts.chart('container2', {
            chart: {
                type: 'column'              
            },
            
            title: {
                text: ''
            },
            xAxis: {
                    categories:[

                @foreach ($year_incomes as $key=>$value)
                    '{{ $key }}',
                @endforeach
                ]
            },
            yAxis: {
                min: 0,
                title: {
                    text: ''
                }
            },
            tooltip: {
                pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}$)<br/>',
                shared: true
            },
          
            series: [{
                color:'#28a745',
                name: 'Income',
                data: [  
                    @foreach ($year_incomes as $key=>$value)
                    {{ $value }},
                @endforeach
            ]
            }, {
                color:'#dc3545',
                name: 'Expenditure',
                data: [
                    @foreach ($year_expenditures as $key=>$value)
                    {{ $value }},
                @endforeach
                ]
            }]
        });
    </script>
@endsection
