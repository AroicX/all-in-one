<!DOCTYPE html>
<html lang="en">

<head>
    @yield('title')

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="" />
    <meta name="keywords" content="">
    <meta name="author" content="Phoenixcoded" />
    <!-- Favicon icon -->
    <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">

    <!-- vendor css -->
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/fullcalendar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">



</head>

<body class="" id="app">
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->
    @include('CorpHRM.layout.sidebar')
    @include('CorpHRM.layout.navbar')

    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10" id="title"></h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/"><i class="feather icon-home"></i></a>
                                </li>
                                {{-- <li class="breadcrumb-item"><a href="#!">Dashboard Analytics</a></li> --}}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                @if(session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}.
                </div>
                @elseif(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}.
                </div>
                @endif
            </div>
            @yield('content')
        </div>
    </div>


    <script src="{{ asset('assets/js/vendor-all.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/ripple.js') }}"></script>
    <script src="{{ asset('assets/js/pcoded.min.js') }}"></script>
    <script src="{{ asset('assets/js/menu-setting.min.js') }}"></script>

    <!-- Apex Chart -->
    <script src="{{ asset('assets/js/plugins/apexcharts.min.js') }}"></script>
    <!-- custom-chart js -->
    <script src="{{ asset('assets/js/pages/dashboard-main.js') }}"></script>

    <!-- Full calendar js -->
    <script src="{{ asset('assets/js/plugins/moment.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/fullcalendar.min.js') }}"></script>



    <script>

            var title = document.title;
    
            if(title){
                $('#title').html(title);
            }else{
                $('#title').html('Dashboard');  
            }
        </script>
    
    @yield('js')
</body>

</html>