@extends('layouts.app', ['title' => $title ?? 'Dashboard'])

@section('css-content')
    <!-- metroui.css -->
   {{--  <link rel="stylesheet" href="{{ asset('assets/css/metroui/metro-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/metroui/metro.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/metroui/metro-colors.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/metroui/metro-icons.min.css') }}"> --}}
@endsection

@section('page-content')
<div class="row">
    @if (count($raffles["raffle_to_end"])>0)
        <div class="col-md-6 col-sm-6 col-xl-6">
            <div class="card fb-card">
                <div class="card-header">
                    <i class="icofont icofont-calendar"></i>
                    <div class="d-inline-block">
                        <h5>Sorteos aputos de finalizar</h5>
                        <span>Cantidad {{count($raffles["raffle_to_end"])}}</span>
                    </div>
                </div>
                <div class="card-block text-center">
                    <div class="row">
                        <div id="carouselExampleControls" class="carousel slide col-md-12 col-sm-12 col-xl-12" data-interval="false" data-ride="carousel">
                            <div class="carousel-inner">
                                @foreach ($raffles["raffle_to_end"] as $key => $data )
                                        @if ($key == 0)
                                            <div class="carousel-item active">
                                                <div class="row ">
                                                    <div class="col-sm-12">
                                                        <div class="text-left ml-5">
                                                            <h5>{{$data['title']}}</h5>
                                                            <p class="text-muted">ID - {{$data['id']}}</p>
                                                            <h5 class="text-warning">{{$data['cash_to_draw']}}</h5>
                                                        </div>
                                                        <div
                                                            style="
                                                                float:right !important;
                                                                margin-top:-50px !important;
                                                                margin-right:50px !important;
                                                            "
                                                            id="donut1"
                                                            data-size="100"
                                                            data-fill="#ff9800"
                                                            data-role="donut"
                                                            data-show-value="true"
                                                            data-total="100"
                                                            data-value="{{$data['percent']}}">
                                                        </div>
                                                        <div class="text-left ml-5">
                                                            <p class="text-muted">Inicio - {{$data['date_start']}}</p>
                                                            <p class="text-muted">Fin - {{$data['date_end']}}</p>
                                                            <p class="text-muted">Lanzamiento - {{$data['date_release']}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        @else
                                            <div class="carousel-item">
                                                <div class="row ">
                                                    <div class="col-sm-12">
                                                        <div class="float-left text-left ml-5">
                                                            <h5>{{$data['title']}}</h5>
                                                            <p class="text-muted">ID - {{$data['id']}}</p>
                                                            <h5 class="text-warning">{{$data['cash_to_draw']}}</h5>
                                                        </div>
                                                        <div
                                                            style="float:right !important;"
                                                            id="donut1"
                                                            data-fill="#ff9800"
                                                            data-role="donut"
                                                            data-show-value="true"
                                                            data-total="100"
                                                            data-value="{{$data['percent']}}">
                                                        </div>
                                                        <div class="float-left text-left ml-1">
                                                            <p class="text-muted">Inicio - {{$data['date_start']}}</p>
                                                            <p class="text-muted">Fin - {{$data['date_end']}}</p>
                                                            <p class="text-muted">Lanzamiento - {{$data['date_release']}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                @endforeach
                            </div>
                            @if (count($raffles["raffle_to_end"])>0)
                                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"><i class="ti-angle-left"></i></span>
                                    <span class="sr-only">Anterior</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"><i class="ti-angle-right"></i></span>
                                    <span class="sr-only">Siguiente</span>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="col-md-6 col-sm-6 col-xl-6">
        <div class="card fb-card">
            <div class="card-header">
                <i class="icofont icofont-calendar"></i>
                <div class="d-inline-block">
                    <h5>Analisis rapido - {{date('M')}}</h5>
                    <span>Informacion</span>
                </div>
            </div>
            <div class="card-block text-center">
                <div class="row">

                </div>
            </div>
        </div>
    </div>

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
<!--metroui-->
<script src="{{ asset('assets/js/metroui/metro.min.js') }}"></script>
<script src="{{ asset('assets/js/jimbo/dashboard.js') }}"></script>
<script>
    var donut = Metro.getPlugin('#donut','donut');
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
