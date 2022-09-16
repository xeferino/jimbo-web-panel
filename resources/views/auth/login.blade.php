<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ config('app.name', 'Laravel') }} - Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="CodedThemes">
    <meta name="keywords" content=" Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
    <meta name="author" content="CodedThemes">
    <!-- Favicon icon -->
    <link rel="icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800" rel="stylesheet">
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
</head>

<body class="fix-menu">
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

    <section class="login p-fixed d-flex text-center bg-primary common-img-bg">
        <!-- Container-fluid starts -->
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Authentication card start -->
                    <div class="login-card card-block auth-body mr-auto ml-auto">
                        <form class="md-float-material" method="POST" action="" name="form-login" id="form-login">
                            @csrf
                            <div class="text-center">
                                <img src="{{ asset('assets/images/jimbo.png') }}" width="200" alt="logo.png">
                            </div>
                            <div class="auth-box">
                                <div class="row m-b-20">
                                    <div class="col-md-12">
                                        <div class="text-center">
                                            <img src="{{ asset('assets/images/logo-icon.png') }}" width="80" alt="logo.png">
                                            <h3 class="text-center txt-primary">Panel Administrativo</h3>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <input type="email" name="email" id="email" class="form-control" placeholder="Email">
                                        <div class="text-left has-danger-email"></div>
                                        <div class="col-form-label"></div>
                                    </div>

                                    <div class="col-sm-12">
                                        <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                                        <div class="text-left has-danger-password"></div>
                                    </div>
                                </div>
                                {{-- <div class="text-left has-danger-email"></div>
                                <div class="input-group">
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Email">
                                    <span class="md-line"></span>
                                </div>
                                <div class="text-left has-danger-password"></div>
                                <div class="input-group">
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                                    <span class="md-line"></span>
                                </div> --}}
                                <div class="row m-t-25 text-left">
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="checkbox-fade fade-in-warning">
                                            <label>
                                                <input type="checkbox" name="remember">
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span class="text-warning">Recordarme</span>
                                            </label>
                                        </div>
                                    </div>
                                    @if (Route::has('password.request'))
                                        <div class="col-sm-6 col-xs-12 forgot-phone text-right">
                                            <a href="{{ route('password.request') }}" class="text-right f-w-600 text-warning">¿Olvid&oacute; su contrase&ntilde;a?</a>
                                        </div>
                                    @endif

                                </div>
                                <div class="row m-t-10">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-warning btn-md btn-block waves-effect text-center m-b-20" id="btn-login">Login</button>
                                    </div>
                                </div>
                                <hr/>
                                <div class="row">
                                    <div class="col-md-2">
                                        <img src="{{ asset('assets/images/dinero.png') }}" alt="small-logo.png">
                                    </div>
                                    <div class="col-md-10">
                                        <p class="text-inverse text-left m-b-0">Iniciar sesi&oacute;n en el sistema.</p>
                                        <p class="text-inverse text-left"><b>Jimbo sorteos, donde todos son ganadores.</b></p>
                                    </div>
                                </div>

                            </div>
                        </form>
                        <!-- end of form -->
                    </div>
                    <!-- Authentication card end -->
                </div>
                <!-- end of col-sm-12 -->
            </div>
            <!-- end of row -->
        </div>
        <!-- end of container-fluid -->
    </section>
    <!-- Warning Section Starts -->
    <!-- Warning Section Ends -->
    <!-- Required Jquery -->
    <script type="text/javascript" src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/jquery-ui/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/popper.js/popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- jquery slimscroll js -->
    <script type="text/javascript" src="{{ asset('assets/js/jquery-slimscroll/jquery.slimscroll.js') }}"></script>
    <!-- modernizr js -->
    <script type="text/javascript" src="{{ asset('assets/js/modernizr/modernizr.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/modernizr/css-scrollbars.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap-growl.min.js') }}"></script>
    <script src="{{ asset('assets/js/axios.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/common-pages.js') }}"></script>

    <script>
        'use strict';
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

        /* $(window).on('load',function(){
            //Welcome Message (not for login page)
            notify('Bienvenido al sistema de administracion de proyectos', 'inverse', '3000', 'top', 'right');
        }); */

        $(document).ready(function() {
            $("#form-login").submit(function( event ) {
                event.preventDefault();
                $("#btn-login").prop("disabled", true).text("Enviando...");
                $('.jimbo-loader').show();
                axios.post('{{ route('login')}}', $(this).serialize()).then(response => {
                    if(response.data.success){
                        //notify(response.data.message, 'success', '3000', 'top', 'right');
                        //$('#btn-login').text("Cargando...");
                        $('#form-login').trigger("reset");
                        $('.load-text').text('Iniciando panel de Jimbo...');
                        setTimeout(function () {location.href = response.data.url}, 3000);
                    }
                }).catch(error => {
                    if (error.response) {
                        if(error.response.status === 422){
                            if (error.response.data.errors.email) {
                                $('.has-danger-email').text('' + error.response.data.errors.email + '').css("color", "red");
                            }else{
                                $('.has-danger-email').text('');
                            }
                            if (error.response.data.errors.password) {
                                $('.has-danger-password').text('' + error.response.data.errors.password + '').css("color", "red");
                            }else{
                                $('.has-danger-password').text('');
                            }
                        }else{
                            notify('Error, Intente nuevamente mas tarde.', 'danger', '5000', 'top', 'right');
                        }
                    }else{
                        notify('Error, Intente nuevamente mas tarde.', 'danger', '5000', 'top', 'right');
                    }
                    setTimeout(() => {$('.jimbo-loader').hide();}, 500);
                    $('#btn-login').prop("disabled", false).text("Login");
                });
            });
        });
    </script>
</body>

</html>
