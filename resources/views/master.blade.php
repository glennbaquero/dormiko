<!doctype html>
<html class="no-js" lang="en">
    <head>
        <base href="/" />
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Dormiko | @yield('pageTitle')</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <meta name="keywords" content="Beds, Bunk Beds, Trancients, Co-Living, Condominium for Rent, Apartment for Rent, Room for Rent, Studio for Rent, Bedspace, BGC, Makati Central Business District, Pinagkaisahan, Cembo, Pembo, Guadalupe Nuevo, OLX, AirBNB, Booking.com, Expedia, Agoda, MyTown, iDorm">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <link rel="shortcut icon" href="{{ asset('favicon.jpg') }}" type="image/x-icon" />
        <meta property="og:image" content="{{ asset('favicon.jpg') }}">
        <meta property="og:title" content="Dormiko">
        <meta property="og:description" content="Dormiko">
        <meta property="og:url" content="">
        <meta property="og:site_name" content="Dormiko">
        <meta property="og:type" content="website">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Chrome, Firefox OS and Opera -->
        <meta name="theme-color" content="#151540">
        <!-- Windows Phone -->
        <meta name="msapplication-navbutton-color" content="#151540">
        <!-- iOS Safari -->
        <meta name="apple-mobile-web-app-status-bar-style" content="#151540">
        
        <!-- Ionicon -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/1.5.2/css/ionicons.min.css">

        <!-- Light Gallery -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.6.4/css/lightgallery.min.css">

        <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>


        <!--Jquery UI-->
        {{-- <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> --}}
                
        @yield('styles')

        <!-- CSS -->
        <link rel="stylesheet" href="{{ mix('/css/app.css') }}">


        <!--[if lt IE 9]>
        <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        
    </head>
    <body>
        @include('includes.header')
        <div id="main">
            
            <div id="page_padding_top"></div>
            @yield('content')

            @include('includes.footer')
        </div>
        <!-- Vars -->
        <script type="text/javascript">
            var pageID = '{{ \Request::route()->getName() }}',
                systemToken = '{{ csrf_token() }}'

                @yield('data')

                baseHref = '{{ url("/") }}',
                urlHref = '{{ \Request::url() }}',

                systemVars = {
                    status: {
                        title: '{{ session('status_title') }}',
                        message: '{{ session('status_message') }}',
                        type: '{{ session('status_type') }}',
                    },
                };
        </script>
        <script>
            window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
            ]); ?>
        </script>

        @include('includes.all_buildings_script')
        
        <!-- Google  -->
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAxRaOIK2odsKvUbUckPcuHxFb9NopS_8M"></script>
            
        <!-- App -->
        <script type="text/javascript" src="{{ asset('assets/manifest.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/vendor.js') }}"></script>        
        <script type="text/javascript" src="{{ asset('assets/app.js') }}"></script>
                
        <!-- TweenMax -->
        <script src="//cdnjs.cloudflare.com/ajax/libs/gsap/1.19.0/TweenMax.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/gsap/1.19.0/plugins/ScrollToPlugin.min.js"></script>

        <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>


         <!-- ScrollMagic -->
        <script src="//cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.5/ScrollMagic.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.5/plugins/animation.gsap.js"></script>
        
        <!--Text Fit -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/textfit/2.3.1/textFit.min.js"></script>
    
        <!-- Light Gallery -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.6.11/js/lightgallery-all.min.js"></script>

        <!--Jquery UI -->
        {{-- <script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> --}}

        <!--Jquery Input Mask -->
        {{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.js"></script> --}}

        @yield('js')
        
        <script src="{{ asset('js/script.js') }}"></script>
        
    </body>
</html>
