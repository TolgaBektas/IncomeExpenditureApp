@extends('layouts.admin')
@section('title')
Income Expenditure
@endsection
@section('css')

@endsection
@section('content')
<div class="row">
  <div class="col-md-3">
    <!-- small box -->
    <div class="small-box bg-success">
      <div class="inner">
        <h3>$ 150</h3>
        <p>Monthly Income</p>
      </div>
      <div class="icon">
        <i class="ion ion-bag"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>  
  <!-- ./col -->
  <div class="col-md-3">
    <!-- small box -->
    <div class="small-box bg-success">
      <div class="inner">
        <h3>$ 44</h3>
        <p>Yearly Income</p>
      </div>
      <div class="icon">
        <i class="ion ion-person-add"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->   
   <div class="col-md-3">
    <!-- small box -->
    <div class="small-box bg-success">
      <div class="inner">
        <h3>$ 44</h3>
        <p>Monthly Profit</p>
      </div>
      <div class="icon">
        <i class="ion ion-person-add"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
   <!-- ./col -->
   <div class="col-md-3">
    <!-- small box -->
    <div class="small-box bg-success">
      <div class="inner">
        <h3>$ 44</h3>
        <p>Yearly Profit</p>
      </div>
      <div class="icon">
        <i class="ion ion-person-add"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col --> 
  <div class="col-md-3">
    <!-- small box -->
    <div class="small-box bg-danger">
      <div class="inner">
        <h3>$ 65</h3>
        <p>Monthly Expenditure</p>
      </div>
      <div class="icon">
        <i class="ion ion-pie-graph"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-md-3">
    <!-- small box -->
    <div class="small-box bg-danger">
      <div class="inner">
        <h3>$ 65</h3>
        <p>Yearly Expenditure</p>
      </div>
      <div class="icon">
        <i class="ion ion-pie-graph"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-md-3">
    <!-- small box -->
    <div class="small-box bg-danger">
      <div class="inner">
        <h3>$ 65</h3>

        <p>Monthly Loss</p>
      </div>
      <div class="icon">
        <i class="ion ion-pie-graph"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->    
    <div class="col-md-3">
      <!-- small box -->
      <div class="small-box bg-danger">
        <div class="inner">
          <h3>$ 53</h3>
  
          <p>Yearly Loss</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
   <!-- ./col -->
   {{-- donut chart --}}
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
        <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
      </div>
      <!-- /.card-body -->
    </div>
   </div>
   {{-- donut chart --}}

   {{-- bar chart --}}
   <div class="col-md-6">
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
          data                : [28, 48, 40, 19, 86, 27, 250,123,23,56,33,12]
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
          data                : [65, 59, 80, 81, 56, 55, 40,28, 48, 40, 19, 86]
        },
      ]
    }
    
    //-------------
    //- DONUT CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
    var donutData        = {
      labels: [
          'Income',
          'Expenditure',
          
      ],
      datasets: [
        {
          data: [700.50,500.36],
          backgroundColor : ['#00a65a', '#dc3545'],
        }
      ]
    }
    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    var donutChart = new Chart(donutChartCanvas, {
      type: 'doughnut',
      data: donutData,
      options: donutOptions
    })

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
  });
</script>
@endsection