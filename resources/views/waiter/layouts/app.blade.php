<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>စုစံစားသောက်ဆိုင်</title>
    {{-- csrf --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href={{asset("plugins/fontawesome-free/css/all.min.css")}}>
    {{-- select2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>
<style>
    .highlight{
        border-bottom: 1px solid #f9f9f9;
        /* width: 50px; */
    }
    .foodsearch{
      border:none;
      border-bottom: 1px solid #ccc;
      padding: 10px;
      width: 200px
    }
    .foodsearch:focus{
      border: none;
      outline: none;
      border-bottom: 1px solid #2ecc71;
    }
    i{
      cursor: pointer;
    }
    .action{
      padding: 10px;
      transition: all 0.5s ;
      border-radius: 10px;
      cursor: pointer;
    }
    .action:hover{
      background-color: #ccc;

    }
    .notibox{
      max-height: 430px;
      overflow-y: scroll
    }
</style>
<body>
      <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #2ecc71">
        <div class="container">
          <a class="navbar-brand" href="">
            <img src={{asset("images/rs.png")}} alt="AdminLTE Logo" class="img-circle"  style="width: 65px">
             <span class="text-white  d-none d-md-inline-block" style="margin-left: 10px">(စုစံစားသောက်ဆိုင်)</span>
            </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
              <li class="nav-item ">
                <a class="nav-link  text-white  @yield('order_highlight')"  href="/">အစားသောက်ကောက်ရန်</a>
              </li>
              <li class="nav-item ">
                <a class="nav-link  text-white @yield('bill_highlight')"  href="/bill">​ငွေရှင်းရန်</a>
              </li>
              <li class="nav-item ">
                <a class="nav-link  text-white @yield('table_highlight')"  href="/tables">စားပွဲများ</a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-white  @yield('detail_highlight')" href="/details">အသေးစိတ် <span class="badge bg-danger">{{$unread_notifications}}</span></a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      
      <div class="container mt-4">
          <div class="d-flex justify-content-center align-items-center">
                <div class="col-md-8">
                    @yield('content')
                </div>
          </div>
            
      </div>
      

      <!-- jQuery -->
      <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
      
     <!-- Bootstrap 5 -->
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
     <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
      {{-- jsscroll --}}
      <script src="{{asset("frontend/jsscroll.js")}}"></script>
       {{--select 2--}}
      <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
      {{--sweet-alert2--}}
      <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <script>
          $(document).ready(function(){
            $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
           });
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
          @if(session("success")){
              Toast.fire({
              icon: 'success',
              title: '{{session('success')}}'
              })
          }
          @endif
          
          })

      </script>
      @yield('script')
</body>
</html>