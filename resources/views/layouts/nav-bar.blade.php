<nav class="navbar header-navbar pcoded-header">
    <div class="navbar-wrapper">

        <div class="navbar-logo">
            <a class="mobile-menu" id="mobile-collapse" href="#!">
                <i class="ti-menu"></i>
            </a>
            <a href="{{ route('panel.dashboard') }}">
                <img class="img-fluid" src="{{ asset('assets/images/jimbo.png') }}"
                style="
                height: 50px;
                width: 150px;
                /* margin-left: 15%; */
                " alt="Theme-Logo" />
            </a>
            <a class="mobile-options">
                <i class="ti-more"></i>
            </a>
        </div>

        <div class="navbar-container container-fluid">
            <ul class="nav-left">
                <li>
                    <div class="sidebar_toggle"><a href="javascript:void(0)"><i class="ti-menu"></i></a></div>
                </li>

            </ul>
            <ul class="nav-right">
                <li class="header-notification">
                    <a href="#!">
                        <i class="ti-bell"></i>
                        <span class="badge bg-c-green"></span>
                    </a>
                    <ul class="show-notification">
                        <li>
                            <h6>Notificaciones</h6>
                            <a href="">
                                <label class="label label-warning" style="cursor: pointer !important;">Ver Todas</label>
                            </a>
                        </li>
                        <li>
                            <div class="media">
                                <div class="media-body">
                                    <h5 class="notification-user text-warning">Nuevo usuario en la plataforma</h5>
                                    <p class="notification-msg">oh! Jose Lozada, se acaba de registrar en jimbo sorteos, desde Ecuador</p>
                                    <span class="notification-time">17 de septiembre de 2022</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="media">
                                <div class="media-body">
                                    <h5 class="notification-user text-warning">Nuevo usuario en la plataforma</h5>
                                    <p class="notification-msg">oh! Miguel Lopez, se acaba de registrar en jimbo sorteos, desde Peru</p>
                                    <span class="notification-time">17 de septiembre de 2022</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="media">
                                <div class="media-body">
                                    <h5 class="notification-user text-warning">Nuevo usuario en la plataforma</h5>
                                    <p class="notification-msg">oh! Daniel Rios, se acaba de registrar en jimbo sorteos, desde Peru</p>
                                    <span class="notification-time">17 de septiembre de 2022</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="media">
                                <div class="media-body">
                                    <h5 class="notification-user text-warning">Nuevo usuario en la plataforma</h5>
                                    <p class="notification-msg">oh! Luisa Espinoza, se acaba de registrar en jimbo sorteos, desde Ecuador</p>
                                    <span class="notification-time">17 de septiembre de 2022</span>
                                </div>
                            </div>
                        </li>

                    </ul>
                </li>
                <li class="user-profile header-notification">
                    <a href="#!">
                        <img src="{{ asset('assets/images/avatar.svg') }}" class="img-radius" alt="User-Profile-Image">
                        <span>{{ Auth::user()->name." ".Auth::user()->surname }}</span>
                        <i class="ti-angle-down"></i>
                    </a>
                    <ul class="show-notification profile-notification">
                       {{--  <li>
                            <a href="#!">
                                <i class="ti-settings"></i> Configuracion
                            </a>
                        </li> --}}
                        <li>
                            <a href="#"><i class="ti-bookmark"></i>Rol</a>
                        </li>
                        <li>
                            <a href="">
                                <i class="ti-user"></i> Perfil
                            </a>
                        </li>
                        <li class="alert_logout">
                            <a href="#">
                                <i class="ti-unlock"></i> Salir
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
