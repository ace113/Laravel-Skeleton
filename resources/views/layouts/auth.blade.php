<!DOCTYPE html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <meta charset="utf-8" />
    <title>{!! config('app.name', 'Career Planet') !!} | Admin | Login</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="Login page for CareerPlanet admin " name="description" />
    <meta content="" name="author" />
    <link rel="shortcut icon" href="{{ url('images/favicon.ico') }}" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet"
        type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/global/plugins/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/global/plugins/bootstrap/css/bootstrap.min.css') }}">

    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->

    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link rel="stylesheet" href="{{ asset('assets/global/css/components.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/global/css/plugins.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/pages/css/login.min.css') }}">
    <link rel="shortcut icon" href="{{ url('images/favicon.ico') }}" />
</head>
<!-- END HEAD -->

<body class="login">
    @yield('content')

    </div>
    <!-- END LOGIN -->
    <!--[if lt IE 9]> -->
    <script src="{{asset('assets/global/plugins/respond.min.js')}}"></script> 
    <script src="{{asset('assets/global/plugins/excanvas.min.js')}}"></script> 
    {{-- <script src="{{asset('assets/global/plugins/ie8.fix.min.js')}}"></script>  --}}
    <!--[endif]-->
    <!-- BEGIN CORE PLUGINS -->
    <script src="{{asset('assets/global/plugins/jquery.min.js')}}"></script> 
    <script src="{{asset('assets/global/plugins/bootstrap/js/bootstrap.min.js')}}"></script> 
    <script src="{{asset('assets/global/plugins/js.cookie.min.js')}}"></script> 
    <script src="{{asset('assets/global/plugins/jquery.blockui.min.js') }}"></script>
    <!-- END CORE PLUGINS -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="{{asset('assets/global/plugins/jquery-validation/js/jquery.validate.min.js')}}"></script> 
    <script src="{{asset('assets/global/plugins/jquery-validation/js/additional-methods.min.js')}}"></script> 
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL SCRIPTS -->
    <script src="{{asset('assets/global/scripts/app.min.js')}}"></script> 

    <!-- END THEME GLOBAL SCRIPTS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="{{asset('assets/pages/scripts/login.min.js')}}"></script> 
    
    {{-- cutom scripts --}}
    @yield('additional-scripts')
    <!-- End -->
</body>


</html>
