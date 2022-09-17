<nav class="pcoded-navbar">
    <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
    <div class="pcoded-inner-navbar main-menu">
        <div class="">
            <div class="main-menu-header">
                <img class="img-40 img-radius" src="{{ asset('assets/images/logo-icon.png') }}" alt="User-Profile-Image">
                <div class="user-details">
                    <span>{{ Auth::user()->name." ".Auth::user()->surname }}</span>
                    {{-- <span id="more-details">{{ Auth::user()->getRoleNames()->join('')  }}<i class="ti-angle-down"></i></span> --}}
                    <span id="more-details">Conectado<i class="ti-angle-down"></i></span>
                </div>
                <img class="img-40 img-radius" src="{{ asset('assets/images/avatar.svg') }}" alt="User-Profile-Image">
            </div>

            <div class="main-menu-content">
                <ul>
                    <li class="more-details">
                        <a href="#"><i class="ti-bookmark"></i>Rol</a>
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
        {{-- <div class="pcoded-navigatio-lavel" data-i18n="nav.category.navigation">Menu</div> --}}
        <ul class="pcoded-item pcoded-left-item">
            <li class="{{(\Request::segment(2)=='dashboard')?'active':''}}">
                <a href="{{ route('panel.dashboard') }}">
                    <span class="pcoded-micon"><i class="ti-dashboard"></i><b>D</b></span>
                    <span class="pcoded-mtext" data-i18n="nav.dash.main">Dashboard</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>

            {{-- @can('show-project')
                @hasrole('super-admin')
                    <li class="{{(\Request::segment(1)=='projects')?'active':''}}">
                        <a href="{{ route('projects.index') }}">
                            <span class="pcoded-micon"><i class="ti-layers"></i><b>PY</b></span>
                            <span class="pcoded-mtext" data-i18n="nav.form-components.main">Proyectos</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @else
                    <li class="{{(\Request::segment(1)=='projects')?'active':''}}">
                        <a href="{{ route('projects.index', ['filter' => 'created']) }}">
                            <span class="pcoded-micon"><i class="ti-layers"></i><b>PY</b></span>
                            <span class="pcoded-mtext" data-i18n="nav.form-components.main">Proyectos</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endhasrole
            @endcan

            @can('show-department')
                <li class="{{(\Request::segment(1)=='departments')?'active':''}}">
                    <a href="{{ route('departments.index') }}">
                        <span class="pcoded-micon"><i class="ti-layers-alt"></i><b>DP</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Departamentos</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            @endcan


            @can('show-process')
                <li class="{{(\Request::segment(1)=='processes')?'active':''}}">
                    <a href="{{ route('processes.index') }}">
                        <span class="pcoded-micon"><i class="ti-loop"></i><b>PS</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Procesos</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            @endcan

            @can('show-procedure')
                <li class="{{(\Request::segment(1)=='procedures')?'active':''}}">
                    <a href="{{ route('procedures.index') }}">
                        <span class="pcoded-micon"><i class="ti-loop"></i><b>PR</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Procedimientos</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            @endcan

            @can('show-hire')
                <li class="{{(\Request::segment(1)=='hires')?'active':''}}">
                    <a href="{{ route('hires.index') }}">
                        <span class="pcoded-micon"><i class="ti-write"></i><b>CT</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Contrataciones</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            @endcan

            @can('show-step')
                <li class="{{(\Request::segment(1)=='steps')?'active':''}}">
                    <a href="{{ route('steps.index') }}">
                        <span class="pcoded-micon"><i class="ti-shift-right"></i><b>PS</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Pasos</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            @endcan

            @can('show-workflow')
                <li class="{{(\Request::segment(1)=='workflows')?'active':''}}">
                    <a href="{{ route('workflows.index') }}">
                        <span class="pcoded-micon"><i class="ti-direction-alt"></i><b>FJ</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Flujos</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            @endcan

            @can('show-role')
                <li class="{{(\Request::segment(1)=='roles')?'active':''}}">
                    <a href="{{ route('roles.index') }}">
                        <span class="pcoded-micon"><i class="ti-view-grid"></i><b>RL</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Roles</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            @endcan

            @can('show-user')
                <li class="{{(\Request::segment(1)=='users')?'active':''}}">
                    <a href="{{ route('users.index') }}">
                        <span class="pcoded-micon"><i class="ti-user"></i><b>US</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Usuarios</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            @endcan --}}

            {{-- @can('show-report')
                <li class="{{(\Request::segment(1)=='reports')?'active':''}}">
                    <a href="{{ route('reports') }}">
                        <span class="pcoded-micon"><i class="ti-files"></i><b>RP</b></span>Reportes</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            @endcan --}}
            <li class="">
                <a href="">
                    <span class="pcoded-micon"><i class="ti-layers-alt"></i><b>VT</b></span>
                    <span class="pcoded-mtext" data-i18n="nav.form-components.main">Ventas</span>
                    <span class="pcoded-mcaret"></span>
                    <span class="badge badge-info">30</span>
                </a>
            </li>
            <li class="">
                <a href="">
                    <span class="pcoded-micon"><i class="ti-money"></i><b>EG</b></span>
                    <span class="pcoded-mtext" data-i18n="nav.form-components.main">Egresos</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class="">
                <a href="">
                    <span class="pcoded-micon"><i class="ti-cup"></i><b>ST</b></span>
                    <span class="pcoded-mtext" data-i18n="nav.form-components.main">Sorteos</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>

            <li class="">
                <a href="">
                    <span class="pcoded-micon"><i class="ti-announcement"></i><b>SL</b></span>
                    <span class="pcoded-mtext" data-i18n="nav.form-components.main">Solicitudes de Retiros</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>

            <li class="">
                <a href="">
                    <span class="pcoded-micon"><i class="ti-user"></i><b>VD</b></span>
                    <span class="pcoded-mtext" data-i18n="nav.form-components.main">Vendedores</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>

            <li class="">
                <a href="">
                    <span class="pcoded-micon"><i class="ti-bell"></i><b>NT</b></span>
                    <span class="pcoded-mtext" data-i18n="nav.form-components.main">Notificaciones</span>
                    <span class="pcoded-mcaret"></span>
                    <span class="badge badge-info">21</span>
                </a>
            </li>

            <li class="">
                <a href="">
                    <span class="pcoded-micon"><i class="ti-image"></i><b>SIM</b></span>
                    <span class="pcoded-mtext" data-i18n="nav.form-components.main">Slider Imagenes</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>

            <li class="">
                <a href="">
                    <span class="pcoded-micon"><i class="ti-money"></i><b>RB</b></span>
                    <span class="pcoded-mtext" data-i18n="nav.form-components.main">Recompensas y Bonos</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>

            <li class="">
                <a href="">
                    <span class="pcoded-micon"><i class="ti-user"></i><b>US</b></span>
                    <span class="pcoded-mtext" data-i18n="nav.form-components.main">Usuarios</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class="">
                <a href="">
                    <span class="pcoded-micon"><i class="ti-view-grid"></i><b>RL</b></span>
                    <span class="pcoded-mtext" data-i18n="nav.form-components.main">Roles</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class="">
                <a href="">
                    <span class="pcoded-micon"><i class="ti-files"></i><b>RP</b></span>Reportes</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>

            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="ti-settings"></i><b>CF</b></span>
                    <span class="pcoded-mtext" data-i18n="nav.dash.main">Configuraciones</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
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
            </li>
        </ul>
    </div>
</nav>
