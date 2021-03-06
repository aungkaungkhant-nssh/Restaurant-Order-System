{{-- #9b59b6  theme color--}}
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chefs Login</title>

    {{--bootstrap css--}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    {{--custom css--}}
    <link rel="stylesheet" href="{{asset('admin/style.css')}}">
</head>
<body>
    <div class="container">
        @yield('content')
    </div>

        
    {{--bootstrap js--}}
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
   
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" ></script>
</body>
</html>