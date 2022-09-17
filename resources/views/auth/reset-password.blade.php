@extends('layouts.auth', ['title' => 'Forgot password'])
@section('form-content')
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

                @include('layouts.auth-footer')

            </div>
        </form>
        <!-- end of form -->
    </div>
@endsection
@section('scripts')
    <script>
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
                        $('.has-danger-email').remove();
                        $('.has-danger-password').remove();
                        $('.has-danger-password_confirmation').remove();

                    } else {
                        $('#btn-reset-password').prop("disabled", false).text("Reset Password");
                        if(response.data.message == 'passwords.token') {
                            notify('Este token de restablecimiento de contraseña no es válido.', 'danger', '5000', 'bottom', 'right');
                        } else if (response.data.message == 'passwords.user'){
                            notify('No podemos encontrar un usuario con esa dirección de correo electrónico.', 'danger', '5000', 'bottom', 'right');
                        }
                        setTimeout(function () {location.reload()}, 5000);
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
                            setTimeout(function () {location.reload()}, 5000);
                        }
                    }else{
                        notify('Error, Intente nuevamente mas tarde.', 'danger', '5000', 'top', 'right');
                        setTimeout(function () {location.reload()}, 5000);
                    }
                    setTimeout(() => {$('.jimbo-loader').hide();}, 500);
                    $('#btn-reset-password').prop("disabled", false).text("Reset Password");
                });
            });
        });
    </script>
@endsection

