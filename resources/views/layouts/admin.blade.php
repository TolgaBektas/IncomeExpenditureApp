<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{asset('assets/plugins/toastr/toastr.min.css')}}"> 
    <script src="https://kit.fontawesome.com/a030024a2c.js" crossorigin="anonymous"></script>
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('assets/adminLTE/css/adminlte.min.css')}}">
    <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">

  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="{{asset('assets/plugins/sweetalert2/css/sweetalert2.min.css')}}">
  <!-- Jquery -->
  <script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>  
    @yield('css')
    <title>@yield('title')</title>
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
  
      <!-- NAVBAR START -->
      <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- NAVBAR Sol Taraf START -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          </li>
          <li class="nav-item d-sm-inline-block">
            <a href="{{ route('index') }}" class="nav-link">Home Page</a>
          </li>
          
        </ul>
        <!-- NAVBAR Sol Taraf END -->
  
  
  
        <!-- NAVBAR Sag Taraf START -->
        <ul class="navbar-nav ml-auto">
          <!-- Cikis Yap START -->
          <form action="{{route('logout')}}" id="logout" method="POST">
            <li id="time" class="nav-item d-none d-sm-inline-block"></li>
          <li class="nav-item d-none d-sm-inline-block">
              @csrf
            <a type="submit" class="nav-link" onclick="document.getElementById('logout').submit();">Logout</a>
          </li>
          
      </form>
          <!-- Cikis Yap START -->
        </ul>
        <!-- NAVBAR Sag Taraf END -->
  
      </nav>
      <!-- NAVBAR END -->
  
      <!-- SIDEBAR START -->
      <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- LOGO START -->
        <a href="{{ route('index') }}" class="brand-link">
          <img src="" alt="" class="brand-image img-circle elevation-3" style="opacity: .8">
          <span class="brand-text font-weight-light">Income Expenditure App</span>
        </a>
        <!-- LOGO END -->
  
  
        <div class="sidebar">
          <!-- SIDEBAR kullanici adi START -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
              <h5 class="m-0 text-light">Welcome, {{auth()->user()->name}}</h5>
            </div>
          </div>
          <!--SIDEBAR kullanici adi END -->
          <!-- SIDEBAR MENULER START -->
          <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <li class="nav-item">
                <a href="{{ route('index') }}" class="nav-link">
                  <i class="fas fa-home"></i>
                  <p>Home Page</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('category.index') }}" class="nav-link">
                  <i class="fas fa-list"></i>
                  <p>Category</p>
                </a>
              </li>
             </ul>
          </nav>
          <!-- SIDEBAR MENULER END -->
        </div>
  
      </aside>
      <!-- SIDEBAR END -->
  
      <!-- ANASAYFA START-->
      <div class="content-wrapper">
        <!-- ANASAYFA BASLIK START -->
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6"></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{ route('index') }}">Home Page</a></li>
                  <li class="breadcrumb-item active">@yield('title')</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <!-- ANASAYFA BASLIK END -->
        <div class="content">
          <div class="container-fluid">
              @yield('content')
  
          </div>
      </div>
      </div>
      <!-- Main Footer -->
      <footer class="main-footer">
          <!-- To the right -->
          <div class="float-right d-none d-sm-inline">
              Tolga Bektaş
      
          </div>
          <!-- Default to the left -->
          <a href="{{ route('index') }}">Home Page</a>
      </footer>
      </div>
    <!-- REQUIRED SCRIPTS -->
    <!-- Bootstrap -->
    <script src="{{asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- Toastr -->
    <script src="{{asset('assets/plugins/toastr/toastr.min.js')}}"></script>
    <!-- ChartJs -->
    <script src="{{asset('assets/plugins/chart.js/Chart.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('assets/adminLTE/js/adminlte.min.js')}}"></script>
     
     <!-- SweetAlert2 -->
     <script src="{{asset('assets/plugins/sweetalert2/js/sweetalert2.min.js')}}"></script>
     <script src="{{asset('assets/plugins/sweetalert2/js/sweetalert2.all.min.js')}}"></script>
     <!-- DataTables -->
     <script src="{{asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
     <script src="{{asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
     <script src="{{asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
     <script src="{{asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
     
     <script>
       function showTime() {
    var date = new Date(),
        utc = new Date(
          date.getFullYear(),
          date.getMonth(),
          date.getDate(),
          date.getHours(),
          date.getMinutes(),
          date.getSeconds()
       );

    document.getElementById('time').innerHTML = utc.toLocaleTimeString('tr-TR',{ weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
  }

  setInterval(showTime, 1000);
     </script>
    @yield('js')
</body>
</html>