<!doctype html>
<html class="no-js" lang="{{ app()->getLocale() }}">
    <head>
        <base href="/" />
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>{{ config('app.name') }} | @yield('pageTitle')</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    
        <link rel="stylesheet" type="text/css" href="{{ mix('assets/vendor-backend.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ mix('assets/app-backend.css') }}">
    </head>

    <body class="hold-transition skin-red-light sidebar-mini">
        
        <div id="app" class="wrapper">
            @include('admin.includes.header')      
            @yield('content')
            @include('admin.includes.sidebar')
            @include('admin.includes.footer')
            <prx-alert></prx-alert>
        </div>
        @yield('js')
        @include('PRXPayPal::includes.js')
        <script type="text/javascript" src="https://cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script>
        <script type="text/javascript" src="{{ mix('assets/manifest.js') }}"></script>
        <script type="text/javascript" src="{{ mix('assets/vendor.js') }}"></script>
        <script type="text/javascript" src="{{ mix('assets/app.js') }}"></script>
       

    </body>
</html>