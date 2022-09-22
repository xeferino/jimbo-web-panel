@extends('layouts.auth', ['title' => 'Send link reset password'])
@section('form-content')
    <div class="login-card card-block auth-body mr-auto ml-auto">
        <form class="md-float-material" method="POST" action="" name="form-forgot" id="form-forgot">
            @csrf
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
                                ¿Olvidaste tu contraseña? No hay problema. Simplemente háganos saber su dirección de correo electrónico y le enviaremos un enlace de restablecimiento de contraseña que le permitirá elegir una nueva.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <input type="email" name="email" id="email" class="form-control" placeholder="Email">
                        <div class="text-left has-danger-email"></div>
                        <div class="col-form-label"></div>
                    </div>
                </div>

                <div class="row m-t-10">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-warning btn-md btn-block waves-effect text-center m-b-20" id="btn-forgot">Email Password Reset Link</button>
                    </div>
                </div>
                @include('layouts.auth-footer')
            </div>
        </form>
        <!-- end of form -->
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $("#form-forgot").submit(function( event ) {
                event.preventDefault();
                $("#btn-forgot").prop("disabled", true).text("Enviando...");
                $('.jimbo-loader').show();
                axios.post('{{ route('password.email') }}', $(this).serialize()).then(response => {
                    if(response.data.success){
                        notify(response.data.message, 'success', '5000', 'top', 'right');
                        $('#btn-forgot').prop("disabled", false).text("Email Password Reset Link");
                        $('#form-forgot').trigger("reset");
                        $('.has-danger-email').remove();
                    } else {
                        $('#btn-forgot').prop("disabled", false).text("Email Password Reset Link");
                        $('.has-danger-email').text('No podemos encontrar un usuario con esa dirección de correo electrónico.').css("color", "red");
                    }
                    setTimeout(() => {$('.jimbo-loader').hide();}, 500);
                }).catch(error => {
                    if (error.response) {
                        if(error.response.status === 422){
                            if (error.response.data.errors.email) {
                                $('.has-danger-email').text('El email es requerido.').css("color", "red");
                            }else{
                                $('.has-danger-email').text('');
                            }
                        }else{
                            notify('Error, Intente nuevamente mas tarde.', 'danger', '5000', 'top', 'right');
                        }
                    }else{
                        notify('Error, Intente nuevamente mas tarde.', 'danger', '5000', 'top', 'right');
                    }
                    setTimeout(() => {$('.jimbo-loader').hide();}, 500);
                    $('#btn-forgot').prop("disabled", false).text("Email Password Reset Link");
                });
            });
        });
    </script>
@endsection

