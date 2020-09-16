<!DOCTYPE html>
<html lang="en">

<head>
    <title>CorpErm</title>
    <!-- HTML5 Shim and Respond.js IE11 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 11]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    <!-- Meta -->
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
    <style type="text/css">
        .pagination > li{
            margin: 10px;
        }
    </style>
    <script type="text/javascript">
        window.localStorage.setItem('cpurl', '{{ url('')}} ')
    </script>

</head>
<body class="" id="">
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->
    @include('CorpFIN.includes.Sidebar')
    @include('CorpFIN.includes.HeaderNav')
    
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10">Dashboard Analytics</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="#!">Dashboard Analytics</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                    @if(session('error'))
                        <div class = "alert alert-error">
                            {{ session('error') }}.
                        </div>
                    @elseif(session('success'))
                        <div class = "alert alert-success">
                            {{ session('success') }}.
                        </div>
                    @endif
                </div>
        @yield('content')
        </div>
    </div>
    


    <!-- Warning Section start -->
    <!-- Older IE warning message -->
    <!--[if lt IE 11]>
        <div class="ie-warning">
            <h1>Warning!!</h1>
            <p>You are using an outdated version of Internet Explorer, please upgrade
               <br/>to any of the following web browsers to access this website.
            </p>
            <div class="iew-container">
                <ul class="iew-download">
                    <li>
                        <a href="http://www.google.com/chrome/">
                            <img src="assets/images/browser/chrome.png" alt="Chrome">
                            <div>Chrome</div>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.mozilla.org/en-US/firefox/new/">
                            <img src="assets/images/browser/firefox.png" alt="Firefox">
                            <div>Firefox</div>
                        </a>
                    </li>
                    <li>
                        <a href="http://www.opera.com">
                            <img src="assets/images/browser/opera.png" alt="Opera">
                            <div>Opera</div>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.apple.com/safari/">
                            <img src="assets/images/browser/safari.png" alt="Safari">
                            <div>Safari</div>
                        </a>
                    </li>
                    <li>
                        <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                            <img src="assets/images/browser/ie.png" alt="">
                            <div>IE (11 & above)</div>
                        </a>
                    </li>
                </ul>
            </div>
            <p>Sorry for the inconvenience!</p>
        </div>
    <![endif]-->
    <!-- Warning Section Ends -->

    <!-- Required Js -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>

    <script src="{{ asset('assets/js/vendor-all.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/ripple.js') }}"></script>
    <script src="{{ asset('assets/js/pcoded.min.js') }}"></script>
    <script src="{{ asset('assets/js/menu-setting.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/PNotify.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/PNotifyButtons.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/PNotifyCallbacks.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/PNotifyDesktop.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/PNotifyConfirm.js') }}"></script>

<!-- Apex Chart -->
<script src="{{ asset('assets/js/plugins/apexcharts.min.js') }}"></script>
<!-- custom-chart js -->
<script src="{{ asset('assets/js/pages/dashboard-main.js') }}"></script>

<!-- Full calendar js -->
<script src="{{ asset('assets/js/plugins/moment.js') }}"></script>
<script src="{{ asset('assets/js/plugins/jquery-ui.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/fullcalendar.min.js') }}"></script>
<script src="{{ asset('js/pages/product.js') }}"></script>
<script src="{{ asset('js/pages/services.js') }}"></script>
<script src="{{ asset('js/pages/transactionpartner.js') }}"></script>
<script src="{{ asset('js/pages/ledgerentry.js') }}"></script>
<script type="text/javascript">
    // swal({
    //             title: "Are you sure?",
    //             text: "Once deleted, you will not be able to recover this imaginary file!",
    //             icon: "warning",
    //             buttons: true,
    //             dangerMode: true,
    //         })
    //         .then((willDelete) => {
    //             if (willDelete) {
    //                 swal("Poof! Your imaginary file has been deleted!", {
    //                     icon: "success",
    //                 });
    //             } else {
    //                 swal("Your imaginary file is safe!", {
    //                     icon: "error",
    //                 });
    //             }
    //         });
    /*new PNotify.alert({
            title: 'Success notice',
            text: 'Check me out! I\'m a notice.',
            type: 'success'
        });*/
    // Full calendar
    
</script>


<script>
    $(document).ready(function() {
        checkCookie();
    });

    function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = "expires=" + d.toGMTString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    function getCookie(cname) {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    function checkCookie() {
        var ticks = getCookie("modelopen");
        if (ticks != "") {
            ticks++ ;
            setCookie("modelopen", ticks, 1);
            if (ticks == "2" || ticks == "1" || ticks == "0") {
                $('#exampleModalCenter').modal();
            }
        } else {
            // user = prompt("Please enter your name:", "");
            $('#exampleModalCenter').modal();
            ticks = 1;
            setCookie("modelopen", ticks, 1);
        }
    }
</script>

<!--/Ajax edit admin call_up script -->
<!-- <script type="text/javascript">
    $('.delete_selected').click(function () {
        //   if ($('input.checkboxes').is(':checked')) {
        //       var values = $('input.checkboxes:checked').map(function () {
        //           return this.value;
        //       }).get();
        var id = $(this).attr('iid');
        confirm_statement = "Are you sure you want to delete this Product?";
        if (confirm(confirm_statement)) {
            // App.blockUI({
            //     target: '#BlockUI',
            //     boxed: true,
            //     textOnly: true,
            //     message: '<img src="{{asset('img/spinner.gif')}}" /> Just a moment...'
            // });
            $.ajax({
                // url: '{{ url('corpfin/del/tp') }}',
                // type:'post',
                // data: { "hall_id" : values },
                type: "GET",
                url: "{{ route('corpfin.service.delete') }}?id=" + id,
                dataType: 'json',
                success: function (data) {
                    if (data.result == 'success') {
                        location.reload();
                        Command: toastr["success"]("Product deleted Successfully!")
                        toastr.options = {
                            "closeButton": false,
                            "debug": false,
                            "newestOnTop": false,
                            "progressBar": false,
                            "positionClass": "toast-top-right",
                            "preventDuplicates": false,
                            "onclick": null,
                            "showDuration": "300",
                            "hideDuration": "1000",
                            "timeOut": "5000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        }
                        // alert("OKK");
                    }
                    if (data.result == 'fail') {
                        // App.unblockUI('#BlockUI');
                        // $('#fail').show();
                        Command: toastr["error"]("Error Completing Request. Try Again!")

                        toastr.options = {
                            "closeButton": false,
                            "debug": false,
                            "newestOnTop": false,
                            "progressBar": false,
                            "positionClass": "toast-top-right",
                            "preventDuplicates": false,
                            "onclick": null,
                            "showDuration": "3000",
                            "hideDuration": "1000",
                            "timeOut": "5000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        }
                    }
                    if (data.result == 'login') {
                        window.location.href = u + '/login';
                        Command: toastr["error"]("Session Expired. Login to continue!")

                        toastr.options = {
                            "closeButton": false,
                            "debug": false,
                            "newestOnTop": false,
                            "progressBar": false,
                            "positionClass": "toast-top-right",
                            "preventDuplicates": false,
                            "onclick": null,
                            "showDuration": "3000",
                            "hideDuration": "1000",
                            "timeOut": "5000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        }
                    }
                }
            })

        }
        // }else{ 
        //     alert('Select Hall First');
        //     return false;
        // }
    })
</script> -->
</body>

</html>
