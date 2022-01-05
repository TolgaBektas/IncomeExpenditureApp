@extends('layouts.admin')
@section('title')
Income Expenditure
@endsection
@section('css')

@endsection
@section('content')
<div class="row">
  <div class="col-md-6">
    {{-- donut chart --}}
    <div class="row">
   <div class="col-md-6">
    <!-- small box -->
    <div class="small-box bg-success">
      <div class="inner">
        <h3>${{ $total_month_income }}</h3>
        <p>Monthly Income</p>
      </div>
      <div class="icon">
        <i class="ion ion-bag"></i>
      </div>
      <a href="{{ route('income.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col --> 
  <div class="col-md-6">
    <!-- small box -->
    <div class="small-box bg-danger">
      <div class="inner">
        <h3>${{ $total_month_expenditure }}</h3>
        <p>Monthly Expenditure</p>
      </div>
      <div class="icon">
        <i class="ion ion-pie-graph"></i>
      </div>
      <a href="{{ route('expenditure.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-md-6">
    <!-- small box -->
    <div class="small-box bg-success">
      <div class="inner">
        <h3>${{ $total_year_income }}</h3>
        <p>Yearly Income</p>
      </div>
      <div class="icon">
        <i class="ion ion-person-add"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->

  <div class="col-md-6">
    <!-- small box -->
    <div class="small-box bg-danger">
      <div class="inner">
        <h3>${{ $total_year_expenditure }}</h3>
        <p>Yearly Expenditure</p>
      </div>
      <div class="icon">
        <i class="ion ion-pie-graph"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div> 
   <!-- ./col -->
  </div>
   {{-- donut chart --}}
  </div>
   

   {{-- pie chart --}}
   <div class="col-md-6">     
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
        <canvas id="pieChart" style="min-height: 215px; height: 215px; max-height: 215px; max-width: 100%;"></canvas>
      </div>
      <!-- /.card-body -->
    </div>
   </div>
   {{-- pie chart --}}

   {{-- bar chart --}}
   <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Current Year Income-Expenditure Graphics</h3>

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
        <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
        </div>
      </div>
      <!-- /.card-body -->
    </div>
   </div>
   {{-- bar chart --}}


@endsection
@section('js')
<script>
  $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */
     var areaChartData = {
      labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July','August', 'September', 'October','November', 'December'],
      datasets: [
        {
          label               : 'Expenditure',
          backgroundColor     : 'rgba(220,53,69,0.9)',
          borderColor         : 'rgba(220,53,69,0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(220,53,69,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,53,69,1)',
          data                : [
            @foreach ($year_expenditures as $year_expenditure)
              {{ $year_expenditure . ',' }}
            @endforeach
        ]
        },
        {
          label               : 'Income',
          backgroundColor     : 'rgba(60, 179, 113, 1)',
          borderColor         : 'rgba(60, 179, 113, 1)',
          pointRadius         : false,
          pointColor          : 'rgba(60, 179, 113, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [
            @foreach ($year_incomes as $year_income)
              {{ $year_income . ',' }}
            @endforeach
          ]
        },
      ]
    }
    
    //-------------
    //- DONUT CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var donutData        = {
      labels: [
          'Income',
          'Expenditure',
          
      ],
      datasets: [
        {
          data: [{{ $total_month_income }},{{ $total_month_expenditure }}],
          backgroundColor : ['#00a65a', '#dc3545'],
        }
      ]
    }
    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }

    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChartData = $.extend(true, {}, areaChartData)
    var temp0 = areaChartData.datasets[0]
    var temp1 = areaChartData.datasets[1]
    barChartData.datasets[0] = temp1
    barChartData.datasets[1] = temp0

    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false
    }

    var barChart = new Chart(barChartCanvas, {
      type: 'bar',
      data: barChartData,
      options: barChartOptions
    })
     //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieData        = donutData;
    var pieOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    // You can switch between pie and douhnut using the method below.
    var pieChart = new Chart(pieChartCanvas, {
      type: 'pie',
      data: pieData,
      options: pieOptions
    })
    //---------------------
    //- STACKED BAR CHART -
    //---------------------
    var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d')
    var stackedBarChartData = $.extend(true, {}, barChartData)

    var stackedBarChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      scales: {
        xAxes: [{
          stacked: true,
        }],
        yAxes: [{
          stacked: true
        }]
      }
    }

    var stackedBarChart = new Chart(stackedBarChartCanvas, {
      type: 'bar',
      data: stackedBarChartData,
      options: stackedBarChartOptions
    })
  });
</script>
@endsection