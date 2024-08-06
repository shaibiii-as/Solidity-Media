<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="fullscreen-bg">
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
    <!-- MAIN CSS -->
    <link rel="stylesheet" href="{{ asset(env('PUBLIC_PREFIX').'admin/css/main.css') }}">

    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
    <!-- ICONS -->
    <link rel="icon" type="image/png" sizes="96x96" href="{{ siteIcon('site_favicon','site-favicon.png') }}">

</head>
<body>
    <div id="wrapper" class="login-bg">
        <div class="login-bg-overlay"></div>
        <div class="container">
            @yield('content')
        </div>
    </div>
</body>
</html>