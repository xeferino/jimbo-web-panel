<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ config('app.name', 'Laravel') .' - '. $title ?? '' }}</title>
    <!-- HTML5 Shim and Respond.js IE9 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
      <!-- Meta -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="description" content="CodedThemes">
      <meta name="keywords" content=" Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
      <meta name="author" content="CodedThemes">
      <meta name="csrf-token" content="{{ csrf_token() }}">

      <!-- Favicon icon -->
      <link rel="icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon">
      <!-- Google font-->
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
      <!-- Required Fremwork -->
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap/css/bootstrap.min.css') }}">
      <!-- themify-icons line icon -->
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/icon/themify-icons/themify-icons.css') }}">
      <!-- ico font -->
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/icon/icofont/css/icofont.css') }}">
      <!-- Notification.css -->
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/pages/notification/notification.css') }}">
      <!-- Animate.css -->
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/animate.css/css/animate.css') }}">
      <!-- Style.css -->
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery.mCustomScrollbar.css') }}">
       <!-- select2 js -->
       <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2/select2.min.css') }}">
       <style>
            .swal-modal{
                border: 3px solid #f4893f  !important;
                border-radius: 10px  !important;
            }
            .swal-button--warning {
                color: #fff !important;
                background-color: rgb(244, 137, 63) !important;
            }
            .swal-overlay {
                background-color: rgb(244 138 63 / 45%) !important;
            }
            .main-footer{
                background-color: #fff;
                border-top: 1px solid #dee2e6;
                color: #869099;
                padding: 1rem;
            }
       </style>
  </head>

  <body>
    <!-- Pre-loader start -->
   <!-- Pre-loader start -->
   <div class="theme-loader">
        <div class="ball-scale">
            <div class='contain'>
                <div class="ring"><div class="frame"></div></div>
                <div class="ring"><div class="frame"></div></div>
                <div class="ring"><div class="frame"></div></div>
                <img src="{{ asset('assets/images/logo-icon.png') }}" class="ring" width="30" alt="logo.png">
                <div class="ring"><div class="frame"></div></div>
                <div class="ring"><div class="frame"></div></div>
                <div class="ring"><div class="frame"></div></div>
            </div>
        </div>
    </div>

    <div class="jimbo-loader" style="display: none;">
        <div class="ball-scale">
            <div class='contain'>
                <div class="ring"><div class="frame"></div></div>
                <div class="ring"><div class="frame"></div></div>
                <div class="ring"><div class="frame"></div></div>
                <img src="{{ asset('assets/images/logo-icon.png') }}" class="ring" width="30" alt="logo.png">
                <div class="ring"><div class="frame"></div></div>
                <div class="ring"><div class="frame"></div></div>
                <div class="ring"><div class="frame"></div></div>
            </div>
        </div>
        <div class="load-text"></div>
    </div>
    <!-- Pre-loader end -->

    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">

           @include('layouts.nav-bar')
            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">
                    @include('layouts.menu')
                    <div class="pcoded-content">
                        <div class="pcoded-inner-content">
                            <div class="main-body">
                                <div class="page-wrapper">
                                    @yield('page-header')
                                    <div class="page-body">
                                        @yield('page-content')
                                    </div>
                                </div>
                            </div>
                        </div>
                        <footer class="main-footer">
                            <div class="row">
                                <div class="col-12 text-center text-inverse">
                                    <strong>© {{date('Y')}} Jimbo Sorteos.</strong> Todos los derechos reservados.
                                    <div class="float-right d-none d-sm-inline-block">
                                      <b> {{env('APP_VERSION')}} </b>
                                    </div>
                                </div>
                            </div>
                        </footer>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Required Jquery -->
<script type="text/javascript" src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/jquery-ui/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/popper.js/popper.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/bootstrap/js/bootstrap.min.js') }}"></script>
<!-- jquery slimscroll js -->
<script type="text/javascript" src="{{ asset('assets/js/jquery-slimscroll/jquery.slimscroll.js') }}"></script>
<!-- select2 js -->
<script type="text/javascript" src="{{ asset('assets/js/select2/select2.min.js') }}"></script>
<!-- modernizr js -->
<script type="text/javascript" src="{{ asset('assets/js/modernizr/modernizr.js') }}"></script>
<!-- am chart -->
<script src="{{ asset('assets/pages/widget/amchart/amcharts.min.js') }}"></script>
<script src="{{ asset('assets/pages/widget/amchart/serial.min.js') }}"></script>
<!-- Datatables -->
<script src="{{ asset('assets/js/datatables/datatables.min.js') }}"></script>
<!-- Todo js -->
<script type="text/javascript" src="{{ asset('assets/pages/todo/todo.js') }}"></script>
<!-- Sweet Alert -->
<script src="{{ asset('assets/js/sweetalert/sweetalert.min.js') }}"></script>
<!-- growl Alert -->
<script type="text/javascript" src="{{ asset('assets/js/bootstrap-growl.min.js') }}"></script>
<!-- axios js -->
<script src="{{ asset('assets/js/axios.js') }}"></script>
<!-- Custom js -->
<script type="text/javascript" src="{{ asset('assets/pages/dashboard/custom-dashboard.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/script.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/SmoothScroll.js') }}"></script>
<script src="{{ asset('assets/js/pcoded.min.js') }}"></script>
<script src="{{ asset('assets/js/demo-12.js') }}"></script>
<script src="{{ asset('assets/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
<script>

    $(function () {
        $('select').select2();
        $('[data-toggle="tooltip"]').tooltip();
    });

    var $window = $(window);
    var nav = $('.fixed-button');
        $window.scroll(function(){
            if ($window.scrollTop() >= 200) {
            nav.addClass('active');
        }
        else {
            nav.removeClass('active');
        }
    });

    function notify(message, type, time, from, align){
        $.growl({
            message: message
        },{
            type: type,
            allow_dismiss: false,
            label: 'Cancel',
            className: 'btn-xs btn-inverse',
            placement: {
                from: from,
                align: align
            },
            delay: time,
            animate: {
                    enter: 'animated fadeInRight',
                    exit: 'animated fadeOutRight'
            },
            offset: {
                x: 30,
                y: 30
            }
        });
    };

 var SweetAlert2Polls = function() {
        //== Demos
        var initDemos = function() {

            $('.alert_logout').click(function(e) {
                swal({
                    title: '{{ Auth::user()->name." ".Auth::user()->surname }}',
                    text: "Desea salir del panel administrativo de Jimbo!",
                    type: 'info',
                    icon : "{{ asset('assets/images/logo100x100.png') }}",
                    buttons:{
                        confirm: {
                            text : 'Salir',
                            className : 'btn btn-warning',
                            showLoaderOnConfirm: true,
                        },
                        cancel: {
                            visible: true,
                            text : 'Cancelar',
                            className : 'btn btn-inverse',
                        }
                    },
                }).then((confirm) => {
                    if (confirm) {
                        axios.post('{{ route('logout')}}', {
                        }).then(response => {
                            if(response.data.success){
                                //notify(response.data.message, 'success', '2000', 'top', 'right');
                                $('.jimbo-loader').show();
                                $('.load-text').text(''+response.data.message+'');
                                setTimeout(function () {location.href = response.data.url}, 2000);
                            }
                        }).catch(error => {
                            if (error.response) {
                                if(error.response.status === 502){
                                    notify(error.response.data.message, 'danger', '5000', 'top', 'right');
                                }else{
                                    notify('Error, Intente nuevamente mas tarde.', 'danger', '5000', 'top', 'right');
                                }
                            }else{
                                notify('Error, Intente nuevamente mas tarde.', 'danger', '5000', 'top', 'right');
                            }
                        });
                    } else {
                        swal.close();
                    }
                });
            });
        };
        return {
            //== Init
            init: function() {
                initDemos();
            },
        };
    }();
    //== Class Initialization
    jQuery(document).ready(function() {
    SweetAlert2Polls.init();
    });
</script>
    @yield('script-content')
</body>
</html>
