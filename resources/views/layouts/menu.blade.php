<nav class="pcoded-navbar">
    <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
    <div class="pcoded-inner-navbar main-menu">
        <div class="">
            <div class="main-menu-header">
                <img class="img-40 img-radius" src="{{ asset('assets/images/logo-icon.png') }}" alt="User-Profile-Image">
                <div class="user-details">
                    <span>{{ Auth::user()->name." ".Auth::user()->surname }}</span>
                    <span id="more-details" class="text-success">Conectado<i class="ti-angle-down"></i></span>
                </div>
            </div>

            <div class="main-menu-content">
                <ul>
                    <li class="more-details">
                        <a href="#"><i class="ti-bookmark"></i>Role - {{ Auth::user()->getRoleNames()->join('')  }}</a>
                    </li>
                    <li class="more-details">
                        <a href=""><i class="ti-user"></i>Perfil</a>
                    </li>
                    <li class="more-details alert_logout">
                        <a href="#"><i class="ti-unlock"></i>Salir</a>
                    </li>
                </ul>
            </div>
        </div>
        <ul class="pcoded-item pcoded-left-item">
            @can('dashboard-menu')
                <li class="{{(\Request::segment(2)=='dashboard')?'active':''}}">
                    <a href="{{ route('panel.dashboard') }}">
                        <span class="pcoded-micon"><i class="icofont icofont-dashboard"></i><b>D</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.dash.main">Dashboard</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            @endcan
            @can('sale-menu')
                    <li class="{{(\Request::segment(2)=='sales')?'active':''}}">
                        <a href="{{route('panel.sales.index')}}">
                            <span class="pcoded-micon"><i class="icofont icofont-bars"></i><b>VT</b></span>
                            <span class="pcoded-mtext" data-i18n="nav.form-components.main">Ventas</span>
                            <span class="pcoded-mcaret"></span>
                            {{-- <span class="badge badge-info">30</span> --}}
                        </a>
                    </li>
            @endcan

            @can('egress-menu')
                <li class="">
                    <a href="">
                        <span class="pcoded-micon"><i class="icofont icofont-money"></i><b>EG</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Egresos</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            @endcan

            @can('raffle-menu')
                <li class="{{(\Request::segment(2)=='raffles')?'active':''}}">
                    <a href="{{route('panel.raffles.index')}}">
                        <span class="pcoded-micon"><i class="icofont icofont-gift"></i><b>ST</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Sorteos</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            @endcan

            @can('promotion-menu')
                <li class="{{(\Request::segment(2)=='promotions')?'active':''}}">
                    <a href="{{route('panel.promotions.index')}}">
                        <span class="pcoded-micon"><i class="icofont icofont-megaphone"></i><b>PM</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Promociones de Sorteos</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            @endcan

            @can('seller-menu')
                <li class="{{(\Request::segment(2)=='sellers')?'active':''}}">
                    <a href="{{route('panel.sellers.index')}}">
                        <span class="pcoded-micon"><i class="icofont icofont-users"></i><b>VD</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Vendedores</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            @endcan

            @can('competitor-menu')
                <li class="{{(\Request::segment(2)=='competitors')?'active':''}}">
                    <a href="{{route('panel.competitors.index')}}">
                        <span class="pcoded-micon"><i class="icofont icofont-users"></i><b>VD</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Participantes</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            @endcan

            @can('withdrawal-menu')
                <li class="">
                    <a href="">
                        <span class="pcoded-micon"><i class="icofont icofont-bill-alt"></i><b>SL</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Solicitudes de Retiros</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            @endcan

            @can('notification-menu')
                <li class="">
                    <a href="">
                        <span class="pcoded-micon"><i class="icofont icofont-notification"></i><b>NT</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Notificaciones</span>
                        <span class="pcoded-mcaret"></span>
                        {{-- <span class="badge badge-info">21</span> --}}
                    </a>
                </li>
            @endcan

            @can('report-menu')
                <li class="">
                    <a href="">
                        <span class="pcoded-micon"><i class="icofont icofont-chart-bar-graph"></i><b>RP</b></span>Reportes</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            @endcan


            @can('setting-menu')
                <div class="pcoded-navigatio-lavel" data-i18n="nav.category.navigation">Configuraciones</div>
                @can('rewards-bonuses-menu')
                    <li class="">
                        <a href="">
                            <span class="pcoded-micon"><i class="icofont icofont-money-bag"></i><b>RB</b></span>
                            <span class="pcoded-mtext" data-i18n="nav.form-components.main">Recompensas y Bonos</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan

                @can('user-menu')
                    <li class="{{(\Request::segment(2)=='users')?'active':''}}">
                        <a href="{{route('panel.users.index')}}">
                            <span class="pcoded-micon"><i class="icofont icofont-users"></i><b>US</b></span>
                            <span class="pcoded-mtext" data-i18n="nav.form-components.main">Usuarios</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan

                @can('role-menu')
                    <li class="{{(\Request::segment(2)=='roles')?'active':''}}">
                        <a href="{{route('panel.roles.index')}}">
                            <span class="pcoded-micon"><i class="icofont icofont-settings"></i><b>RL</b></span>
                            <span class="pcoded-mtext" data-i18n="nav.form-components.main">Roles</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan

                @can('country-menu')
                    <li class="{{(\Request::segment(2)=='contries')?'active':''}}">
                        <a href="{{route('panel.countries.index')}}">
                            <span class="pcoded-micon"><i class="icofont icofont-flag"></i><b>PS</b></span>
                            <span class="pcoded-mtext" data-i18n="nav.form-components.main">Paises</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan

                @can('slider-menu')
                    <li class="{{(\Request::segment(2)=='sliders')?'active':''}}">
                        <a href="{{route('panel.sliders.index')}}">
                            <span class="pcoded-micon"><i class="icofont icofont-image"></i><b>IM</b></span>
                            <span class="pcoded-mtext" data-i18n="nav.form-components.main">Slider de imagenes</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan

                {{-- <li class="pcoded-hasmenu">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="icofont icofont-options"></i><b>CF</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.dash.main">Configuraciones</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="">
                            <a href="javascript:void(0)">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Slider de Imagenes</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="">
                            <a href="javascript:void(0)">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Jibs</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="">
                            <a href="javascript:void(0)">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Comisiones</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li> --}}
            @endcan
        </ul>
    </div>
</nav>
