<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <!-- Title -->
    <title>Admin | @yield('title')</title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="{{ asset(env('PUBLIC_PREFIX').'admin/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset(env('PUBLIC_PREFIX').'admin/vendor/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset(env('PUBLIC_PREFIX').'admin/vendor/themify-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset(env('PUBLIC_PREFIX').'admin/css/vendor/animate/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset(env('PUBLIC_PREFIX').'admin/vendor/chartist/css/chartist-custom.css') }}">

    <link rel="stylesheet" href="{{ asset(env('PUBLIC_PREFIX').'admin/vendor/datatables/css-main/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset(env('PUBLIC_PREFIX').'admin/vendor/datatables/css-bootstrap/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset(env('PUBLIC_PREFIX').'admin/vendor/datatables-tabletools/css/dataTables.tableTools.css') }}">

    <!-- MAIN CSS -->
    <link rel="stylesheet" href="{{ asset(env('PUBLIC_PREFIX').'admin/css/main.css') }}">

    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
    <!-- ICONS -->
    <link rel="icon" type="image/png" sizes="96x96" href="{{ siteIcon('site_favicon','site-favicon.png') }}">
</head>
<body>

    <div id="wrapper">
        @include('admin.sections.header')
        @include('admin.sections.sidebar')
        <div class="main"> 
            <div class="main-content">
                @yield('content')
            </div>
        </div>
        <div class="clearfix"></div>
        <footer>
            <div class="container-fluid">
            <p class="copyright">&copy; {{date('Y')}} <a href="{{url('admin/dashboard')}}">{{settingValue('site_title')}}</a>. All Rights Reserved.</p>
            </div>
         </footer>
    </div>

    <!-- Scripts -->
    <script src="{{ asset(env('PUBLIC_PREFIX').'admin/vendor/jquery/jquery.min.js') }}"></script> 
    <script src="{{ asset(env('PUBLIC_PREFIX').'admin/vendor/bootstrap/js/bootstrap.min.js') }}"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.js"></script>
    <script src="{{ asset(env('PUBLIC_PREFIX').'admin/vendor/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script> 
    <script src="{{ asset(env('PUBLIC_PREFIX').'admin/scripts/klorofilpro-common.js') }}"></script>

    <script src="{{ asset(env('PUBLIC_PREFIX').'admin/vendor/datatables/js-main/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset(env('PUBLIC_PREFIX').'admin/vendor/datatables/js-bootstrap/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset(env('PUBLIC_PREFIX').'admin/vendor/datatables-colreorder/dataTables.colReorder.js') }}"></script>
    <script src="{{ asset(env('PUBLIC_PREFIX').'admin/vendor/datatables-tabletools/js/dataTables.tableTools.js') }}"></script>
    @yield('js')
</body>
</html>