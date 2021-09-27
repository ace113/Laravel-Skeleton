<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">


<!-- BEGIN HEAD -->
@include('partials.head')
<!-- END HEAD -->

<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
    <!-- BEGIN HEADER -->
    @include('partials.header')
    <!-- END HEADER & CONTENT DIVIDER -->

    <!-- BEGIN CONTAINER -->
    <div class="page-container">

        <!-- BEGIN SIDEBAR -->
        @include('partials.sidebar')
        <!-- END SIDEBAR -->

        <!-- BEGIN CONTENT -->
        <div class="page-content-wrapper">
            <!-- BEGIN CONTENT BODY -->
            <div class="page-content">
                <!-- BEGIN BREADCRUMBS -->
                @include('partials.breadcrumbs')
                @yield('breadcrumb')
                <!-- END BREADCRUMBS -->

                @include('partials.message')

                @yield('content')
            </div>
        </div>
        <!-- END CONTENT -->

    </div>
    <!-- END CONTAINER -->

    <!-- BEGIN FOOTER -->
    @include('partials.footer')
    <!-- END FOOTER -->

    </div>
    @include('partials.footer-js')

    @yield('additional-scripts')
</body>

</html>
