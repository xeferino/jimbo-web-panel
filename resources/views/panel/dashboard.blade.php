@extends('layouts.app', ['title' => $title ?? 'Dashboard'])

@section('page-content')
<div class="row">

    <div class="col-sm-12">
        <div class="card fb-card">
            <div class="card-header">
                <i class="icofont icofont-money"></i>
                <div class="d-inline-block">
                    <h5>Ventas y Recaudos</h5>
                    <span>Balances</span>
                </div>
            </div>
            <div class="card-block text-center">
                <div class="row">
                    <div class="col-sm-4 b-r-default">
                        <h2>{{Helper::amount($sales['sale_pending'])}}</h2>
                        <p class="text-muted">Ventas pendientes</p>
                    </div>
                    <div class="col-sm-4 b-r-default">
                        <h2>{{Helper::amount($sales['sale_approved'])}}</h2>
                        <p class="text-muted">Ventas completadas</p>
                    </div>
                    <div class="col-sm-4">
                        <h2>{{Helper::amount($sales['sale_total'])}}</h2>
                        <p class="text-muted">Ventas totales</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="card fb-card">
            <div class="card-header">
                <i class="icofont icofont-bill-alt"></i>
                <div class="d-inline-block">
                    <h5>Egresos y solicitudes de retiro de efectivo</h5>
                    <span>Balances</span>
                </div>
            </div>
            <div class="card-block text-center">
                <div class="row">
                    <div class="col-sm-6 b-r-default">
                        <h2>{{Helper::amount($egress)}}</h2>
                        <p class="text-muted">Egresos</p>
                    </div>
                    <div class="col-sm-6">
                        <h2>{{Helper::amount($cash)}}</h2>
                        <p class="text-muted">Retiros</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="card fb-card">
            <div class="card-header">
                <i class="icofont icofont-users"></i>
                <div class="d-inline-block">
                    <h5>Usuarios</h5>
                    <span>Sistema</span>
                </div>
            </div>
            <div class="card-block text-center">
                <div class="row">
                    <div class="col-sm-4 b-r-default">
                        <h2>{{$users['sellers']}}</h2>
                        <p class="text-muted">Vendedores</p>
                    </div>
                    <div class="col-sm-4 b-r-default">
                        <h2>{{$users['competitors']}}</h2>
                        <p class="text-muted">Competidores</p>
                    </div>
                    <div class="col-sm-4">
                        <h2>{{$users['users']}}</h2>
                        <p class="text-muted">Colaboradores</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 b-r-default">
                        <h2>{{$users['seller_active']}}</h2>
                        <p class="text-muted">Vendedores Activos</p>
                    </div>
                    <div class="col-sm-4 b-r-default">
                        <h2>{{$users['competitor_active']}}</h2>
                        <p class="text-muted">Competidores Activos</p>
                    </div>
                    <div class="col-sm-4">
                        <h2>{{$users['user_active']}}</h2>
                        <p class="text-muted">Colaboradores Activos</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 b-r-default">
                        <h2>{{$users['seller_inactive']}}</h2>
                        <p class="text-muted">Vendedores Activos</p>
                    </div>
                    <div class="col-sm-4 b-r-default">
                        <h2>{{$users['competitor_inactive']}}</h2>
                        <p class="text-muted">Competidores Activos</p>
                    </div>
                    <div class="col-sm-4">
                        <h2>{{$users['user_inactive']}}</h2>
                        <p class="text-muted">Colaboradores Activos</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="card fb-card">
            <div class="card-header">
                <i class="icofont icofont-gift"></i>
                <div class="d-inline-block">
                    <h5>Sorteos</h5>
                    <span>Sistema</span>
                </div>
            </div>
            <div class="card-block text-center">
                <div class="row">
                    <div class="col-sm-4 b-r-default">
                        <h2>{{$raffles['raffles']}}</h2>
                        <p class="text-muted">Todos</p>
                    </div>
                    <div class="col-sm-4 b-r-default">
                        <h2>{{$raffles['raffle_p']}}</h2>
                        <p class="text-muted">Sorteos de Productos</p>
                    </div>
                    <div class="col-sm-4">
                        <h2>{{$raffles['raffle_r']}}</h2>
                        <p class="text-muted">Sorteos de Efectivo</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4 b-r-default">
                        <h2>{{$raffles['raffle_open']}}</h2>
                        <p class="text-muted">Sorteos Abiertos</p>
                    </div>
                    <div class="col-sm-4 b-r-default">
                        <h2>{{$raffles['raffle_close']}}</h2>
                        <p class="text-muted">Sorteos Finalizados</p>
                    </div>
                    <div class="col-sm-4">
                        <h2>{{$raffles['raffle_public']}}</h2>
                        <p class="text-muted">Sorteos publicados</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4 b-r-default">
                        <h2>{{$raffles['raffle_draft']}}</h2>
                        <p class="text-muted">Sorteos Borrdores</p>
                    </div>
                    <div class="col-sm-4 b-r-default">
                        <h2>{{$raffles['raffle_active']}}</h2>
                        <p class="text-muted">Sorteos activos</p>
                    </div>
                    <div class="col-sm-4">
                        <h2>{{$raffles['raffle_inactive']}}</h2>
                        <p class="text-muted">Sorteos de inactivos</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="card fb-card">
            <div class="card-header">
                <i class="icofont icofont-megaphone"></i>
                <div class="d-inline-block">
                    <h5>Promociones</h5>
                    <span>Sistema</span>
                </div>
            </div>
            <div class="card-block text-center">
                <div class="row">
                    <div class="col-sm-4 b-r-default">
                        <h2>{{$promotions['promotions']}}</h2>
                        <p class="text-muted">Todas</p>
                    </div>
                    <div class="col-sm-4 b-r-default">
                        <h2>{{$promotions['promotion_active']}}</h2>
                        <p class="text-muted">Promociones Activas</p>
                    </div>
                    <div class="col-sm-4">
                        <h2>{{$promotions['promotion_inactive']}}</h2>
                        <p class="text-muted">Promociones Inactivas</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statestics Start -->
    {{-- <div class="col-md-12 col-xl-12">
        <div class="card">
            <div class="card-header">
                <h5>Statestics</h5>
                <div class="card-header-left ">
                </div>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="icofont icofont-simple-left "></i></li>
                        <li><i class="icofont icofont-maximize full-card"></i></li>
                        <li><i class="icofont icofont-minus minimize-card"></i></li>
                        <li><i class="icofont icofont-refresh reload-card"></i></li>
                        <li><i class="icofont icofont-error close-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-block">
                <div id="statestics-chart" style="height:517px;"></div>
            </div>
        </div>
    </div> --}}

    <!-- Email Sent End -->
    <!-- Data widget start -->
    @if (count($sellers['top'])>0 )
        <div class="col-md-12 col-xl-12">
            <div class="card project-task fb-card">
                <div class="card-header">
                    <div class="card-header-left ">
                        <h5>Top mejores vendedores</h5>
                    </div>
                </div>
                <div class="card-block p-b-10">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Vendedores</th>
                                    <th>Montos</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i=1;
                                @endphp
                                @foreach ($sellers['top'] as $top)
                                    <tr>
                                        <td>
                                            <div class="task-contain">
                                                <h6 class="bg-c-yellow d-inline-block text-center">{{ $i++ }}</h6>
                                                <p class="d-inline-block m-l-20">{{$top->fullnames}}</p>
                                            </div>
                                        </td>
                                        <td>
                                        {{Helper::amount($top->amount)}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
