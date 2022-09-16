<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ config('app.name', 'Laravel') }} - Forgot your password</title>
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
                        <form class="md-float-material" method="POST" action="" name="form-reset-password" id="form-reset-password">
                            @csrf
                              <!-- Password Reset Token -->
                              <input type="hidden" name="token" value="{{ $request->route('token') }}">
                            <div class="text-center">
                                <a href="{{ route('login') }}">
                                    <img src="{{ asset('assets/images/jimbo.png') }}" width="200" alt="logo.png">
                                </a>
                            </div>
                            <div class="auth-box">
                                <div class="row m-b-20">
                                    <div class="col-md-12">
                                        <div class="text-center">
                                            <a href="{{ route('login') }}">
                                                <img src="{{ asset('assets/images/logo-icon.png') }}"  width="80" alt="logo.png">
                                            </a>
                                            <p class="text-inverse text-justify m-t-10 m-b-0" style="font-size: 15px !important;">
                                                Restablecimiento de contraseña, por favor complete el sieguiente formulario.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <input type="email" name="email" id="email" value="{{old('email', $request->email)}}" class="form-control" placeholder="Email">
                                        <div class="text-left has-danger-email"></div>
                                        <div class="col-form-label"></div>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="password" name="password" id="password" class="form-control" placeholder="new password">
                                        <div class="text-left has-danger-password"></div>
                                        <div class="col-form-label"></div>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="confirm password">
                                        <div class="text-left has-danger-password_confirmation"></div>
                                        <div class="col-form-label"></div>
                                    </div>
                                </div>

                                <div class="row m-t-10">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-warning btn-md btn-block waves-effect text-center m-b-20" id="btn-reset-password">Reset Password</button>
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
            $("#form-reset-password").submit(function( event ) {
                event.preventDefault();
                $("#btn-reset-password").prop("disabled", true).text("Enviando...");
                $('.jimbo-loader').show();
                axios.post('{{ route('password.update') }}', $(this).serialize()).then(response => {
                    if(response.data.success){
                        //notify(response.data.message, 'warning', '3000', 'top', 'right');
                        $('.load-text').text(''+response.data.message+'');
                        setTimeout(function () {location.href = response.data.url}, 5000);
                        $('#btn-reset-password').prop("disabled", false).text("Reset Password");
                        $('#form-reset-password').trigger("reset");
                        setTimeout(() => {$('.jimbo-loader').hide();}, 5000);

                    } else {
                        $('#btn-reset-password').prop("disabled", false).text("Reset Password");
                        if(response.data.message == 'passwords.token') {
                            notify('Este token de restablecimiento de contraseña no es válido.', 'danger', '5000', 'bottom', 'right');
                        } else if (response.data.message == 'passwords.user'){
                            notify('No podemos encontrar un usuario con esa dirección de correo electrónico.', 'danger', '5000', 'bottom', 'right');

                        }
                        setTimeout(() => {$('.jimbo-loader').hide();}, 500);
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
                    $('#btn-reset-password').prop("disabled", false).text("Reset Password");
                });
            });
        });
    </script>
</body>

</html>
