<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="{{ siteIcon('site_favicon','site-favicon.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#000000">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{settingValue('site_title')}}</title>

    <link rel="manifest" href="{{ asset(env('PUBLIC_PREFIX').'manifest.json') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="{{ asset(env('PUBLIC_PREFIX').'js/jquery.min.js') }}"></script>
    <script src="{{ asset(env('PUBLIC_PREFIX').'js/bootstrap.min.js') }}"></script>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
</head>
<body>
    <div id="app"></div>
    <script type="text/javascript" src="{{ asset(env('PUBLIC_PREFIX').'js/app.js') }}"></script>
</body>
</html>
