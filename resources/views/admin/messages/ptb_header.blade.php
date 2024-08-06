<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="IE=7" />
        <meta http-equiv="X-UA-Compatible" content="IE=8" />
        <meta name="author" content="Arhamsoft Pvt Ltd.">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=8;FF=3;OtherUA=4" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <link href="{{ asset(env('PUBLIC_PREFIX').'admin/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset(env('PUBLIC_PREFIX').'admin/vendor/font-awesome/css/font-awesome.min.css') }}">
        <link href="{{ asset(env('PUBLIC_PREFIX').'admin/vendor/progress/jqprogress.min.css') }}" rel="stylesheet">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <script src="{{ asset(env('PUBLIC_PREFIX').'admin/vendor/jquery/jquery.js') }}"></script> 
        <script>
            var BASE_URL = '{{ URL::to('/') }}';
            var ADMIN_URL = '{{ URL::to('/admin') }}';
            var ajax_alert = 'Error Occured , Please try again later !';
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var infura_api_key = '{{ INFURA_API_KEY }}';
            var from_address = '{{ FROM_ADDRESS }}';
            var contract_address = '{{ CONTRACT_ADDRESS }}';
            contract_address = contract_address.toLowerCase().replace('0x', '');
        </script>
        <style>
            .main_container .top_nav {margin-left: 0px !important;}
            .nav-md .container.body .right_col { margin-left: 0px !important;}
            footer {margin-left: 0px !important;}
            .progress-bar-animated {-webkit-animation: progress-bar-stripes 1s linear infinite;animation: progress-bar-stripes 1s linear infinite;}
        </style>
        <style>
            body{font-family: 'Roboto', sans-serif !important;}
            h1{font-weight: 300;}
            .progress{margin-bottom: 0px;}
        </style>
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i" rel="stylesheet">
        <script src="{{ asset(env('PUBLIC_PREFIX').'admin/vendor/web3/dist/web3.min.js') }}"></script>
        <script src="{{ asset(env('PUBLIC_PREFIX').'admin/js/ipfs_web3_abi.js') }}"></script>
    </head>
    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                <br><br>
                <div class="content-wrapper" id="content-wrapper"></div>
            </div>
        </div>
        <script type="text/javascript" src="{{ asset(env('PUBLIC_PREFIX').'admin/vendor/bootstrap/js/bootstrap.min.js') }}"></script> 
        <script type="text/javascript" src="{{ asset(env('PUBLIC_PREFIX').'admin/vendor/moment/min/moment.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset(env('PUBLIC_PREFIX').'admin/vendor/progress/jqprogress.min.js') }}"></script>
    </body>
</html>