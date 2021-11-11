<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Restaurant Order System</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
   {{-- select2 --}}
   {<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
   {{-- datables --}}
   <link rel="stylesheet" href="https://cdn.datatables.net/1.11.1/css/dataTables.bootstrap4.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href={{asset("plugins/fontawesome-free/css/all.min.css")}}>
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href={{asset("plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css")}}>
  <!-- iCheck -->
  <link rel="stylesheet" href={{asset("plugins/icheck-bootstrap/icheck-bootstrap.min.css")}}>
  <!-- JQVMap -->
  <link rel="stylesheet" href={{asset("plugins/jqvmap/jqvmap.min.css")}}>
  <!-- Theme style -->
  <link rel="stylesheet" href={{asset("dist/css/adminlte.min.css")}}>
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href={{asset("plugins/overlayScrollbars/css/OverlayScrollbars.min.css")}}>
  <!-- Daterange picker -->
  <link rel="stylesheet" href={{asset("plugins/daterangepicker/daterangepicker.css")}}>
  <!-- summernote -->
  <link rel="stylesheet" href={{asset("plugins/summernote/summernote-bs4.min.css")}}>
 <style>
   .dishesImage{
     width: 200px;
     border-radius: 10px
   }
 </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  {{-- <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src={{asset("dist/img/AdminLTELogo.png")}} alt="AdminLTELogo" height="60" width="60">
  </div> --}}

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
   
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
    

      <!-- Messages Dropdown Menu -->
     
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown mr-2">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <form action="/admins/logout" method="POST">
          @csrf
          <button class="btn btn-warning">
            အကောင့်ထွက်ရန်
            <i class="fas fa-arrow-circle-right"></i>
          </button>
        </form>
      </li>
     
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src={{asset("images/rs.png")}} alt="AdminLTE Logo" class="img-circle"  style="width: 80px">
      <span class="brand-text font-weight-light">စုစံ (စားသောက်ဆိုင်)</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          
        </div>
        <div class="info">
          <a href="#" class="d-block">{{auth()->guard("admin")->user()->name}}</a>
        </div>
      </div>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="/admins" class="nav-link @yield("admins_active")">
              <i class="fas fa-book-open mr-2"></i>
              <p>
                အနှစ်ချုပ်
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('admins.tables.index')}}" class="nav-link  @yield("tables_active")">
              <i class="fas fa-table mr-2"></i>
              <p>
                စားပွဲများ
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/admins/chef" class="nav-link @yield("waiters_active")">
              <i class="fas fa-user-friends mr-2"></i>
              <p>
                စားဖိုမှူးများ
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('admins.categories.index')}}" class="nav-link  @yield("categories_active")">
              <i class="fas fa-clipboard mr-2"></i>
              <p>
                အမျိုးအစားများ
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('admins.dishes.index')}}" class="nav-link  @yield("dishes_active")">
              <i class="fas fa-utensils mr-2"></i>
              <p>
                အစားသောက်များ
              </p>
            </a>
          </li>
        </ul>
          
              
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <div class="d-flex align-items-center">
                @yield('icon')
              <h1 class="m-0">@yield('title')</h1>
            
            </div>
           
          </div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
         @yield('content')
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.1.0
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
{{--datatable--}}
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
{{--sweet-alert2--}}
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- jQuery UI 1.11.4 -->
<script src={{asset("plugins/jquery-ui/jquery-ui.min.js")}}></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src={{asset("plugins/bootstrap/js/bootstrap.bundle.min.js")}}></script>
<!-- ChartJS -->
<script src={{asset("plugins/chart.js/Chart.min.js")}}></script>
<!-- Sparkline -->
<script src={{asset("plugins/sparklines/sparkline.js")}}></script>
<!-- JQVMap -->
<script src={{asset("plugins/jqvmap/jquery.vmap.min.js")}}></script>
<script src={{asset("plugins/jqvmap/maps/jquery.vmap.usa.js")}}></script>
<!-- jQuery Knob Chart -->
<script src={{asset("plugins/jquery-knob/jquery.knob.min.js")}}></script>
<!-- daterangepicker -->
<script src={{asset("plugins/moment/moment.min.js")}}></script>
<script src={{asset("plugins/daterangepicker/daterangepicker.js")}}></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src={{asset("plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js")}}></script>
<!-- Summernote -->
<script src={{asset("plugins/summernote/summernote-bs4.min.js")}}></script>
<!-- overlayScrollbars -->
<script src={{asset("plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js")}}></script>
<!-- AdminLTE App -->
<script src={{asset("dist/js/adminlte.js")}}></script>
<!-- AdminLTE for demo purposes -->
<script src={{asset("dist/js/demo.js")}}></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src={{asset("dist/js/pages/dashboard.js")}}></script>
{{--js validation--}}

<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
 {{--select 2--}}
 <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
  $(document).ready(function(){
      $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
      $(".back").click(function(e){
        e.preventDefault()
        window.history.back()
      })
      const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
        @if(session("create")){
            Toast.fire({
            icon: 'success',
            title: '{{session('create')}}'
            })
        }
        @endif
        @if(session("update")){
            Toast.fire({
            icon: 'success',
            title: '{{session('update')}}'
            })
        }
        @endif
        @if(session("delete")){
            Toast.fire({
            icon: 'success',
            title: '{{session('delete')}}'
            })
        }
        @endif
  })
</script>
@yield('scripts')
</body>
</html>