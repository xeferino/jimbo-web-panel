@extends('layouts.app', ['title' => $title ?? 'Dashboard'])

@section('page-content')
<div class="row">

    <div class="col-md-6 col-sm-12 col-xl-6">
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
                        <h4>{{Helper::amount($sales['sale_pending'])}}</h4>
                        <p class="text-muted">Ventas pendientes</p>
                    </div>
                    <div class="col-sm-4 b-r-default">
                        <h4>{{Helper::amount($sales['sale_approved'])}}</h4>
                        <p class="text-muted">Ventas completadas</p>
                    </div>
                    <div class="col-sm-4">
                        <h4>{{Helper::amount($sales['sale_total'])}}</h4>
                        <p class="text-muted">Ventas totales</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-12 col-xl-6">
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
                        <h4>{{Helper::amount($egress)}}</h4>
                        <p class="text-muted">Egresos</p>
                    </div>
                    <div class="col-sm-6">
                        <h4>{{Helper::amount($cash)}}</h4>
                        <p class="text-muted">Solicitude de Retiros</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-12 col-xl-6">
        <div class="card fb-card">
            <div class="card-header">
                <i class="icofont icofont-users"></i>
                <div class="d-inline-block">
                    <h5>Colaboradores</h5>
                    <span>Sistema</span>
                </div>
            </div>
            <div class="card-block text-center">
                <div class="row">
                    <div class="col-sm-4 b-r-default">
                        <h4>{{$users['users']}}</h4>
                        <p class="text-muted">Colaboradores</p>
                    </div>
                    <div class="col-sm-4 b-r-default">
                        <h4>{{$users['user_active']}}</h4>
                        <p class="text-muted">Colaboradores Activos</p>
                    </div>
                    <div class="col-sm-4">
                        <h4>{{$users['user_inactive']}}</h4>
                        <p class="text-muted">Colaboradores Inactivos</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-12 col-xl-6">
        <div class="card fb-card">
            <div class="card-header">
                <i class="icofont icofont-users"></i>
                <div class="d-inline-block">
                    <h5>Vendedores</h5>
                    <span>Sistema</span>
                </div>
            </div>
            <div class="card-block text-center">
                <div class="row">
                    <div class="col-sm-4 b-r-default">
                        <h4>{{$users['sellers']}}</h4>
                        <p class="text-muted">Vendedores</p>
                    </div>
                    <div class="col-sm-4 b-r-default">
                        <h4>{{$users['seller_active']}}</h4>
                        <p class="text-muted">Vendedores Activos</p>
                    </div>
                    <div class="col-sm-4 b-r-default">
                        <h4>{{$users['seller_inactive']}}</h4>
                        <p class="text-muted">Vendedores Inactivos</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-12 col-xl-6">
        <div class="card fb-card">
            <div class="card-header">
                <i class="icofont icofont-users"></i>
                <div class="d-inline-block">
                    <h5>Competidores / Participantes</h5>
                    <span>Sistema</span>
                </div>
            </div>
            <div class="card-block text-center">
                <div class="row">
                    <div class="col-sm-4 b-r-default">
                        <h4>{{$users['competitors']}}</h4>
                        <p class="text-muted">Competidores</p>
                    </div>
                    <div class="col-sm-4 b-r-default">
                        <h4>{{$users['competitor_active']}}</h4>
                        <p class="text-muted">Competidores Activos</p>
                    </div>
                    <div class="col-sm-4">
                        <h4>{{$users['user_active']}}</h4>
                        <p class="text-muted">Colaboradores Inactivos</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-12 col-xl-6">
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
                        <h4>{{$promotions['promotions']}}</h4>
                        <p class="text-muted">Todas</p>
                    </div>
                    <div class="col-sm-4 b-r-default">
                        <h4>{{$promotions['promotion_active']}}</h4>
                        <p class="text-muted">Promociones Activas</p>
                    </div>
                    <div class="col-sm-4">
                        <h4>{{$promotions['promotion_inactive']}}</h4>
                        <p class="text-muted">Promociones Inactivas</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (count($sellers['top'])>0 )
        <div class="col-md-6 col-sm-12 col-xl-6">
            <div class="card project-task fb-card">
                <div class="card-header">
                    <i class="icofont icofont-users"></i>
                    <div class="d-inline-block">
                        <h5>Top vendedores</h5>
                        <span>mejores</span>
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
    <!-- Statestics Start -->
    <div class="col-md-8 col-sm-8 col-xl-8">
        <div class="card fb-card">
            <div class="card-header">
                <i class="icofont icofont-gift"></i>
                <div class="d-inline-block">
                    <h5>Sorteos</h5>
                    <span>Sistema</span>
                </div>
            </div>
            <div class="card-block">
                <div class="table-responsive">
                    <canvas id="barChartRaflles" width="400" height="400"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 col-sm-4 col-xl-4">
        <div class="card fb-card">
            <div class="card-header">
                <i class="icofont icofont-users"></i>
                <div class="d-inline-block">
                    <h5>Venta Anual</h5>
                    <span>Usuarios</span>
                </div>
            </div>
            <div class="card-block">
                <div class="table-responsive">
                    <ul class="">
                        <li> <button class="btn btn-user btn-sm"></button> Usuario </li>
                        <li> <button class="btn btn-classic btn-sm"></button> Clasico </li>
                        <li> <button class="btn btn-junior btn-sm"></button> Junior </li>
                        <li> <button class="btn btn-middle btn-sm"></button> Semi Senior </li>
                        <li> <button class="btn btn-master btn-sm"></button> Senior </li>
                    </ul>
                    <div id="graph-donut"></div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
@section('script-content')
<script src="{{ asset('assets/js/jimbo/dashboard.js') }}"></script>

<script>
    Morris.Donut({
        element: 'graph-donut',
        data: [
          {value: 70, label: 'Usuario'},
          {value: 15, label: 'Clasico'},
          {value: 10, label: 'Junior'},
          {value: 5, label: 'Semi Senior'},
          {value: 5, label: 'Senior'}
        ],
        backgroundColor: '#ccc',
        labelColor: '#000',
        colors: [
          '#cc7514',
          '#8a5112',
          '#eb8413',
          '#e69232',
          '#eda85c'
        ],
        //formatter: function (x) { return x + "%"}
    });

    var val1 = '{{$raffles["raffle_p"]}}';
    var val2 = '{{$raffles["raffle_r"]}}';
    var val3 = '{{$raffles["raffle_open"]}}';
    var val4 = '{{$raffles["raffle_close"]}}';
    var val5 = '{{$raffles["raffle_public"]}}';
    var val6 = '{{$raffles["raffle_draft"]}}';
    var val7 = '{{$raffles["raffle_active"]}}';
    var val8 = '{{$raffles["raffle_inactive"]}}';
    var raffles = '{{$raffles["raffles"]}}';

    const ctx = document.getElementById('barChartRaflles');
    const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Producto', 'Sorteo', 'Arbiertos', 'Finalizados', 'Publicados', 'Borradores', 'Activos', 'Inactivos'],
            datasets: [{
                label: `Graficas de sorteos (${raffles})`,
                data: [val1, val2, val3, val4, val5, val6, val7, val8],
                backgroundColor: [
                    '#cc7514',
                    '#8a5112',
                    '#eb8413',
                    '#e69232',
                    '#eda85c',
                    '#f2b263',
                    '#f5ce9f',
                    '#9c5705'
                ],
                borderColor: [
                    '#cc7514',
                    '#8a5112',
                    '#eb8413',
                    '#e69232',
                    '#eda85c',
                    '#f2b263',
                    '#f5ce9f',
                    '#9c5705'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection
