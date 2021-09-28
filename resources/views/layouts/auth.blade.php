<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <title>{{ config('app.name') }} | Admin | Login</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="" name="author" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}" hidden>
    <!-- Styles -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all">
    <link rel="stylesheet" href="{{url('assets/global/plugins/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{url('assets/global/plugins/simple-line-icons/simple-line-icons.min.css')}}">
    <link rel="stylesheet" href="{{url('assets/global/plugins/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{url('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}">

    <link rel="stylesheet" href="{{url('assets/global/css/components.min.css')}}">
    <link rel="stylesheet" href="{{url('assets/global/css/plugins.min.css')}}">

    {{-- login css --}}
    <link rel="stylesheet" href="{{url('assets/pages/css/login.min.css')}}">


    
</head>
<!-- END HEAD -->

<body class=" login">
    @yield('content')

     
    {{-- scripts --}}
    <script src="{{url('assets/global/plugins/jquery.min.js')}}"></script>
    <script src="{{url('assets/global/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{url('assets/global/plugins/js.cookie.min.js')}}"></script>
    <script src="{{url('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
    <script src="{{url('assets/global/plugins/jquery.blockui.min.js')}}"></script>
    <script src="{{url('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}"></script>

    {{-- page level plugins --}}
    <script src="{{url('assets/global/plugins/jquery-validation/js/jquery.validate.min.js')}}"></script>
    <script src="{{url('assets/global/plugins/jquery-validation/js/additional-methods.min.js')}}"></script>

    <script src="{{url('assets/global/scripts/app.min.js')}}"></script>

    {{-- <script src="{{url('assets/pages/scripts/login.min.js')}}"></script> --}}
    

    {{-- additional scripts --}}
    @yield('additional-scripts')
</body>

</html>
