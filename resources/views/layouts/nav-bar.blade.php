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
                {{-- @can('actions-menu')
                    <li class="header-notification">
                        <a href="#!">
                            <i class="ti-bell"></i>
                            @if (count($notifications)>0)
                                <span class="badge bg-c-green"></span>
                            @endif
                        </a>
                        <ul class="show-notification">
                            @if (count($notifications)>0)
                                <li>
                                    <h6>Acciones en el panel y app</h6>
                                    <a href="{{route('panel.actions.index')}}">
                                        <label class="label label-warning" style="cursor: pointer !important;">Ver Todas</label>
                                    </a>
                                </li>
                                @foreach ($notifications as $data)
                                    <li>
                                        <div class="media">
                                            <div class="media-body">
                                                <h5 class="notification-user text-warning">{{$data->title}}</h5>
                                                <p class="notification-msg">{{$data->description}}</p>
                                                <span class="notification-time">{{\Carbon\Carbon::parse($data->date)->format('d/m/Y H:i:s');}}</span>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            @else
                                <li>
                                    <h6>Acciones en el panel y app</h6>
                                    <a href="{{route('panel.actions.index')}}">
                                        <label class="label label-warning" style="cursor: pointer !important;">No hay registros</label>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endcan --}}
                <li class="user-profile header-notification">
                    <a href="#!">
                        <img src="{{ Auth::user()->image != 'avatar.svg' ? asset('assets/images/users/'.Auth::user()->image): asset('assets/images/avatar.svg') }}" class="img-radius" alt="User-Profile-Image">
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
                            <a href="#"><i class="ti-bookmark"></i>Role - {{ Auth::user()->getRoleNames()->join('')  }}</a>
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
