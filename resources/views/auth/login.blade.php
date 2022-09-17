@extends('layouts.auth', ['title' => 'Login'])
@section('form-content')
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
                            <p class="text-inverse m-b-0">Bienvenido, Inicia sesi&oacute;n!</p>
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
                @include('layouts.auth-footer')
            </div>
        </form>
        <!-- end of form -->
    </div>
@endsection

@section('scripts')
    <script>
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
                        $('.has-danger-email').remove();
                        $('.has-danger-password').remove();
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
                    $('#btn-login').prop("disabled", false).text("Login");
                });
            });
        });
    </script>
@endsection
