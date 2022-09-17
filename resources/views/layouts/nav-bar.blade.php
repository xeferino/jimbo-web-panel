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
                {{-- <li class="header-notification">
                    <a href="#!">
                        <i class="ti-bell"></i>
                        <span class="badge bg-c-blue"></span>
                    </a>
                    <ul class="show-notification">
                        <li>
                            <h6>Proyectos</h6>
                            <label class="label label-primary">Nuevos</label>
                        </li>
                        <li>
                            <div class="media">
                                <img class="d-flex align-self-center img-radius" src="{{ asset('assets/images/avatar-4.jpg') }}" alt="Generic placeholder image">
                                <div class="media-body">
                                    <h5 class="notification-user">Titulo</h5>
                                    <p class="notification-msg">Descripcion</p>
                                    <span class="notification-time">Fecha minutos</span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li> --}}
                <li class="user-profile header-notification">
                    <a href="#!">
                        <img src="{{ asset('assets/images/avatar.svg') }}" class="img-radius" alt="User-Profile-Image">
                        <span>{{ Auth::user()->name." ".Auth::user()->surname }}</span>
                        <i class="ti-angle-down"></i>
                    </a>
                    <ul class="show-notification profile-notification">
                        <li>
                            <a href="#!">
                                <i class="ti-settings"></i> Configuracion
                            </a>
                        </li>
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
                                <i class="ti-layout-sidebar-left"></i> Salir
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
