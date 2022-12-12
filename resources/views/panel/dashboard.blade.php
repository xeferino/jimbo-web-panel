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
                    <i class="icofont icofont-listing-number"></i>
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
                                                            <h5 class="text-warning">{{$data['title']}}</h5>
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
                                                            <p class="text-muted">{{$data['remaining_days']}} Dias restantes</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        @else
                                            <div class="carousel-item">
                                                <div class="row ">
                                                    <div class="col-sm-12">
                                                        <div class="text-left ml-5">
                                                            <h5 class="text-warning">{{$data['title']}}</h5>
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
                                                            <p class="text-muted">{{$data['remaining_days']}} Dias restantes</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                @endforeach
                            </div>
                            @if (count($raffles["raffle_to_end"])>=2)
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
                    <h5>Analisis rapido - {{\Carbon\Carbon::now()->locale('es')->translatedFormat('F Y')}}</h5>
                    <span>Informacion</span>
                </div>
            </div>
            <div class="card-block text-center">
                <div class="row">
                    <div class="col-sm-4 ">
                        <h5>{{$users['competitor_month']}}</h5>
                        <p class="text-muted">Competidores</p>
                        <h5 class="text-warning">{{Helper::amount($sales['competitor_sale_month'])}}</h5>
                    </div>
                    <div class="col-sm-4 ">
                        <h5>{{$users['seller_month']}}</h5>
                        <p class="text-muted">Vendedores</p>
                        <h5 class="text-warning">{{Helper::amount($sales['seller_sale_month'])}}</h5>
                    </div>
                    <div class="col-sm-4 ">
                        <h5>{{$sales['sale_total']}}</h5>
                        <p class="text-muted">Ventas</p>
                        <h5 class="text-warning">{{Helper::amount($sales['sale_month'])}}</h5>

                    </div>
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
            <div class="card-block text-center text-capitalize">
                <div class="row">
                    <div class="col-sm-3">
                        <h5 class="text-warning">{{Helper::amount($sales['sale_pending'])}}</h5>
                        <p class="text-danger">Pendientes</p>
                    </div>
                    <div class="col-sm-3 b-r-default">
                        <h5 class="text-warning">{{Helper::amount($sales['sale_approved'])}}</h5>
                        <p class="text-success">Aprobadas</p>
                    </div>
                    <div class="col-sm-3">
                        <h5 class="text-warning">{{Helper::amount($sales['sale_total'])}}</h5>
                        <p class="text-muted">Totales</p>
                    </div>
                    <div class="col-sm-3">
                        <h5 class="text-warning">{{Helper::amount($sales['sale_month'])}}</h5>
                        <p class="text-muted">{{\Carbon\Carbon::now()->locale('es')->translatedFormat('F')}}</p>
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
            <div class="card-block text-center text-capitalize">
                <div class="row">
                    <div class="col-sm-3 ">
                        <h5 class="text-warning">{{Helper::amount($egress['cash_approved'])}}</h5>
                        <p class="text-muted">Egresos</p>
                    </div>
                    <div class="col-sm-3 b-r-default">
                        <h5 class="text-warning">{{Helper::amount($egress['cash_month'])}}</h5>
                        <p class="text-muted">{{\Carbon\Carbon::now()->locale('es')->translatedFormat('F')}}</p>
                    </div>
                    <div class="col-sm-3 ">
                        <h5 class="text-warning">{{Helper::amount($cash['cash_pending'])}}</h5>
                        <p class="text-muted">Retiros</p>
                    </div>
                    <div class="col-sm-3">
                        <h5 class="text-warning">{{Helper::amount($cash['cash_month'])}}</h5>
                        <p class="text-muted">{{\Carbon\Carbon::now()->locale('es')->translatedFormat('F')}}</p>
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
            <div class="card-block text-center text-capitalize">
                <div class="row">
                    <div class="col-sm-4 ">
                        <h5>{{$users['users']}}</h5>
                        <p class="text-muted">Colaboradores</p>
                    </div>
                    <div class="col-sm-4 ">
                        <h5>{{$users['user_active']}}</h5>
                        <p class="text-success">Activos</p>
                    </div>
                    <div class="col-sm-4">
                        <h5>{{$users['user_inactive']}}</h5>
                        <p class="text-danger">Inactivos</p>
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
            <div class="card-block text-center text-capitalize">
                <div class="row">
                    <div class="col-sm-4 ">
                        <h5>{{$users['sellers']}}</h5>
                        <p class="text-muted">Vendedores</p>
                    </div>
                    <div class="col-sm-4 ">
                        <h5>{{$users['seller_active']}}</h5>
                        <p class="text-success">Activos</p>
                    </div>
                    <div class="col-sm-4 ">
                        <h5>{{$users['seller_inactive']}}</h5>
                        <p class="text-danger">Inactivos</p>
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
                    <div class="col-sm-4 ">
                        <h5>{{$users['competitors']}}</h5>
                        <p class="text-muted">Competidores</p>
                    </div>
                    <div class="col-sm-4 ">
                        <h5>{{$users['competitor_active']}}</h5>
                        <p class="text-success">Activos</p>
                    </div>
                    <div class="col-sm-4">
                        <h5>{{$users['competitor_inactive']}}</h5>
                        <p class="text-danger">Inactivos</p>
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
                    <div class="col-sm-4 ">
                        <h5>{{$promotions['promotions']}}</h5>
                        <p class="text-muted">Promociones</p>
                    </div>
                    <div class="col-sm-4 ">
                        <h5>{{$promotions['promotion_active']}}</h5>
                        <p class="text-success">Activas</p>
                    </div>
                    <div class="col-sm-4">
                        <h5>{{$promotions['promotion_inactive']}}</h5>
                        <p class="text-danger">Inactivas</p>
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
      <div class="col-md-12 col-sm-12 col-xl-12">
        <div class="card fb-card">
            <div class="card-header">
                <i class="icofont  icofont-money"></i>
                <div class="d-inline-block">
                    <h5>Venta Jimbo Boletos y Jibs Anual</h5>
                    <span>Sistema</span>
                </div>
            </div>
            <div class="card-block">
                <div class="table-responsive">
                    <canvas id="salesYears" width="400" height="400"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-6 col-xl-6">
        <div class="card fb-card">
            <div class="card-header">
                <i class="icofont  icofont-money"></i>
                <div class="d-inline-block">
                    <h5>Venta de Boletos Paises Anual</h5>
                    <span>Sistema</span>
                </div>
            </div>
            <div class="card-block">
                <div class="table-responsive">
                    <canvas id="barChart" width="400" height="400"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-6 col-xl-6">
        <div class="card fb-card">
            <div class="card-header">
                <i class="icofont  icofont-money"></i>
                <div class="d-inline-block">
                    <h5>Venta de Jibs Paises Anual</h5>
                    <span>Sistema</span>
                </div>
            </div>
            <div class="card-block">
                <div class="table-responsive">
                    <canvas id="barChartJib" width="400" height="400"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-6 col-xl-6">
        <div class="card fb-card">
            <div class="card-header">
                <i class="icofont icofont-users"></i>
                <div class="d-inline-block">
                    <h5>Venta Anual</h5>
                    <span>Usuarios</span>
                </div>
            </div>
            <div class="card-block">
                <canvas id="donutChartSales" width="400" height="400"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-6 col-xl-6">
        <div class="card fb-card">
            <div class="card-header">
                <i class="icofont icofont-users"></i>
                <div class="d-inline-block">
                    <h5>Sorteos</h5>
                    <span>Sistema</span>
                </div>
            </div>
            <div class="card-block">
                <canvas id="donutChartRaffles" width="400" height="400"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-6 col-xl-6">
        <div class="card fb-card">
            <div class="card-header">
                <i class="icofont  icofont-money"></i>
                <div class="d-inline-block">
                    <h5>Venta de Usuarios Boletos Perú Anual</h5>
                    <span>Sistema</span>
                </div>
            </div>
            <div class="card-block">
                <div class="table-responsive">
                    <canvas id="barChartBoletoPeru" width="400" height="400"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-6 col-xl-6">
        <div class="card fb-card">
            <div class="card-header">
                <i class="icofont  icofont-money"></i>
                <div class="d-inline-block">
                    <h5>Venta de Usuarios Boletos Ecuador Anual</h5>
                    <span>Sistema</span>
                </div>
            </div>
            <div class="card-block">
                <div class="table-responsive">
                    <canvas id="barChartBoletoEcuador" width="400" height="400"></canvas>
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

    var    seller_classic_sale_year =  '{{$sales["seller_classic_sale_year"]}}';
    var    seller_junior_sale_year  =  '{{$sales["seller_junior_sale_year"]}}';
    var    seller_middle_sale_year  =  '{{$sales["seller_middle_sale_year"]}}';
    var    seller_master_sale_year  =  '{{$sales["seller_master_sale_year"]}}';

    //-------------
    //- DONUT CHART - SALES
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var donutChartCanvas = $('#donutChartSales').get(0).getContext('2d')
    var donutData        = {
      labels: [
          "Clasico " + "{{Helper::amount($sales['seller_classic_sale_year_amount'])}}",
          "Junior " + "{{Helper::amount($sales['seller_junior_sale_year_amount'])}}",
          "Semi Señior " + "{{Helper::amount($sales['seller_middle_sale_year_amount'])}}",
          "Señior " + "{{Helper::amount($sales['seller_master_sale_year_amount'])}}",
      ],
      datasets: [
        {
          data: [seller_classic_sale_year,seller_junior_sale_year,seller_middle_sale_year,seller_master_sale_year],
          backgroundColor : ['#f56954', '#00a65a', '#00c0ef', '#3f4096'],
        }
      ]
    }
    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(donutChartCanvas, {
      type: 'doughnut',
      data: donutData,
      options: donutOptions
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

    //-------------
    //- DONUT CHART - SALES
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var donutChartCanvas = $('#donutChartRaffles').get(0).getContext('2d')
    var donutData        = {
      labels: ['Producto', 'Efectivo', 'Arbiertos', 'Finalizados', 'Publicados', 'Borradores', 'Activos', 'Inactivos'],
      datasets: [
        {
          data: [val1, val2, val3, val4, val5, val6, val7, val8],
          backgroundColor : ['#cc7514', '#8a5112', '#eb8413', '#e69232', '#eda85c', '#f2b263', '#f5ce9f', '#9c5705'],
        }
      ]
    }
    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(donutChartCanvas, {
      type: 'doughnut',
      data: donutData,
      options: donutOptions
    });


    var areaChartCanvas = $('#salesYears').get(0).getContext('2d')

    var areaChartData = {
      labels  : ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre'],
      datasets: [
        {
          label               : 'Venta total de boletos',
          backgroundColor     : 'rgba(245,135,53,0.7)',
          borderColor         : 'rgba(245,135,53,0.6)',
          pointRadius          : true,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(245,135,53,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(245,135,53,1)',
          data : [
                "{{$sales['sales_year'][0]['Ene']}}",
                "{{$sales['sales_year'][0]['Feb']}}",
                "{{$sales['sales_year'][0]['Mar']}}",
                "{{$sales['sales_year'][0]['Abr']}}",
                "{{$sales['sales_year'][0]['May']}}",
                "{{$sales['sales_year'][0]['Jun']}}",
                "{{$sales['sales_year'][0]['Jul']}}",
                "{{$sales['sales_year'][0]['Ago']}}",
                "{{$sales['sales_year'][0]['Sep']}}",
                "{{$sales['sales_year'][0]['Oct']}}",
                "{{$sales['sales_year'][0]['Nov']}}",
                "{{$sales['sales_year'][0]['Dic']}}"
            ]
        },
        {
          label               : 'Venta total de Jibs',
          backgroundColor     : 'rgba(63, 64, 150, 0.7)',
          borderColor         : 'rgba(63, 64, 150, 0.6)',
          pointRadius         : true,
          pointColor          : 'rgba(63, 64, 150, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(63, 64, 150,1)',
          data : [
                "{{$sales['jibs_year'][0]['Ene']}}",
                "{{$sales['jibs_year'][0]['Feb']}}",
                "{{$sales['jibs_year'][0]['Mar']}}",
                "{{$sales['jibs_year'][0]['Abr']}}",
                "{{$sales['jibs_year'][0]['May']}}",
                "{{$sales['jibs_year'][0]['Jun']}}",
                "{{$sales['jibs_year'][0]['Jul']}}",
                "{{$sales['jibs_year'][0]['Ago']}}",
                "{{$sales['jibs_year'][0]['Sep']}}",
                "{{$sales['jibs_year'][0]['Oct']}}",
                "{{$sales['jibs_year'][0]['Nov']}}",
                "{{$sales['jibs_year'][0]['Dic']}}"
            ]
        },
      ]
    }

    var areaChartOptions = {
      maintainAspectRatio : false,
      responsive : true,
      legend: {
        display: true
      },
      scales: {
        xAxes: [{
          gridLines : {
            display : false,
          }
        }],
        yAxes: [{
          gridLines : {
            display : false,
          },
        }]
      },
    }

    // This will get the first returned node in the jQuery collection.
    new Chart(areaChartCanvas, {
      type: 'line',
      data: areaChartData,
      options: areaChartOptions
    });

    //-------------
    //- BAR CHART VENTA BOLETOS PAISES ANUAL -
    //-------------
    var barChartData = {
      labels  : ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre'],
      datasets: [
        {
          label               : 'Venta de Boletos Perú',
          backgroundColor     : 'rgba(255,0,0,0.7)',
          borderColor         : 'rgba(255,0,0,0.6)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(255,0,0,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(255,0,0,1)',
          data : [
                "{{$sales['sales_year_peru'][0]['Ene']}}",
                "{{$sales['sales_year_peru'][0]['Feb']}}",
                "{{$sales['sales_year_peru'][0]['Mar']}}",
                "{{$sales['sales_year_peru'][0]['Abr']}}",
                "{{$sales['sales_year_peru'][0]['May']}}",
                "{{$sales['sales_year_peru'][0]['Jun']}}",
                "{{$sales['sales_year_peru'][0]['Jul']}}",
                "{{$sales['sales_year_peru'][0]['Ago']}}",
                "{{$sales['sales_year_peru'][0]['Sep']}}",
                "{{$sales['sales_year_peru'][0]['Oct']}}",
                "{{$sales['sales_year_peru'][0]['Nov']}}",
                "{{$sales['sales_year_peru'][0]['Dic']}}"
            ]
        },
        {
          label               : 'Venta de Boletos Ecuador',
          backgroundColor     : 'rgba(255, 240, 0, 0.7)',
          borderColor         : 'rgba(255, 240, 0, 0.6)',
          pointRadius         : false,
          pointColor          : 'rgba(255, 240, 0, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(255, 240, 0,1)',
          data : [
                "{{$sales['sales_year_ecuador'][0]['Ene']}}",
                "{{$sales['sales_year_ecuador'][0]['Feb']}}",
                "{{$sales['sales_year_ecuador'][0]['Mar']}}",
                "{{$sales['sales_year_ecuador'][0]['Abr']}}",
                "{{$sales['sales_year_ecuador'][0]['May']}}",
                "{{$sales['sales_year_ecuador'][0]['Jun']}}",
                "{{$sales['sales_year_ecuador'][0]['Jul']}}",
                "{{$sales['sales_year_ecuador'][0]['Ago']}}",
                "{{$sales['sales_year_ecuador'][0]['Sep']}}",
                "{{$sales['sales_year_ecuador'][0]['Oct']}}",
                "{{$sales['sales_year_ecuador'][0]['Nov']}}",
                "{{$sales['sales_year_ecuador'][0]['Dic']}}"
            ]
        },
      ]
    }
    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChartData = $.extend(true, {}, barChartData)
    var temp0 = barChartData.datasets[0]
    var temp1 = barChartData.datasets[1]
    barChartData.datasets[0] = temp1
    barChartData.datasets[1] = temp0

    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false,
      scales: {
        xAxes: [{
          gridLines : {
            display : false,
          }
        }],
        yAxes: [{
          gridLines : {
            display : false,
          },
        }]
      },
    }

    new Chart(barChartCanvas, {
      type: 'bar',
      data: barChartData,
      options: barChartOptions
    });

    //-------------
    //- BAR CHART VENTA JIBS PAISES ANUAL -
    //-------------
    var barChartData = {
      labels  : ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre'],
      datasets: [
        {
          label               : 'Venta de Jibs Perú',
          backgroundColor     : 'rgba(255,0,0,0.7)',
          borderColor         : 'rgba(255,0,0,0.6)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(255,0,0,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(255,0,0,1)',
          data : [
                "{{$sales['jibs_year_peru'][0]['Ene']}}",
                "{{$sales['jibs_year_peru'][0]['Feb']}}",
                "{{$sales['jibs_year_peru'][0]['Mar']}}",
                "{{$sales['jibs_year_peru'][0]['Abr']}}",
                "{{$sales['jibs_year_peru'][0]['May']}}",
                "{{$sales['jibs_year_peru'][0]['Jun']}}",
                "{{$sales['jibs_year_peru'][0]['Jul']}}",
                "{{$sales['jibs_year_peru'][0]['Ago']}}",
                "{{$sales['jibs_year_peru'][0]['Sep']}}",
                "{{$sales['jibs_year_peru'][0]['Oct']}}",
                "{{$sales['jibs_year_peru'][0]['Nov']}}",
                "{{$sales['jibs_year_peru'][0]['Dic']}}"
            ]
        },
        {
          label               : 'Venta de Jibs Ecuador',
          backgroundColor     : 'rgba(255, 240, 0, 0.7)',
          borderColor         : 'rgba(255, 240, 0, 0.6)',
          pointRadius         : false,
          pointColor          : 'rgba(255, 240, 0, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(255, 240, 0,1)',
          data : [
                "{{$sales['jibs_year_ecuador'][0]['Ene']}}",
                "{{$sales['jibs_year_ecuador'][0]['Feb']}}",
                "{{$sales['jibs_year_ecuador'][0]['Mar']}}",
                "{{$sales['jibs_year_ecuador'][0]['Abr']}}",
                "{{$sales['jibs_year_ecuador'][0]['May']}}",
                "{{$sales['jibs_year_ecuador'][0]['Jun']}}",
                "{{$sales['jibs_year_ecuador'][0]['Jul']}}",
                "{{$sales['jibs_year_ecuador'][0]['Ago']}}",
                "{{$sales['jibs_year_ecuador'][0]['Sep']}}",
                "{{$sales['jibs_year_ecuador'][0]['Oct']}}",
                "{{$sales['jibs_year_ecuador'][0]['Nov']}}",
                "{{$sales['jibs_year_ecuador'][0]['Dic']}}"
            ]
        },
      ]
    }
    var barChartCanvas = $('#barChartJib').get(0).getContext('2d')
    var barChartData = $.extend(true, {}, barChartData)
    var temp0 = barChartData.datasets[0]
    var temp1 = barChartData.datasets[1]
    barChartData.datasets[0] = temp1
    barChartData.datasets[1] = temp0

    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false,
      scales: {
        xAxes: [{
          gridLines : {
            display : false,
          }
        }],
        yAxes: [{
          gridLines : {
            display : false,
          },
        }]
      },
    }

    new Chart(barChartCanvas, {
      type: 'bar',
      data: barChartData,
      options: barChartOptions
    });


     //---------------------
    //- STACKED BAR CHART Perú-
    //---------------------
    var stackedChartData = {
      labels  : ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre'],
      datasets: [
        {
          label               : 'Clasicos',
          backgroundColor     : 'rgba(255,255,0,0.7)',
          borderColor         : 'rgba(255,255,0,0.6)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(255,255,0,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(255,255,0,1)',
          data : [
                "{{$sales['sales_year_classic_peru'][0]['Ene']}}",
                "{{$sales['sales_year_classic_peru'][0]['Feb']}}",
                "{{$sales['sales_year_classic_peru'][0]['Mar']}}",
                "{{$sales['sales_year_classic_peru'][0]['Abr']}}",
                "{{$sales['sales_year_classic_peru'][0]['May']}}",
                "{{$sales['sales_year_classic_peru'][0]['Jun']}}",
                "{{$sales['sales_year_classic_peru'][0]['Jul']}}",
                "{{$sales['sales_year_classic_peru'][0]['Ago']}}",
                "{{$sales['sales_year_classic_peru'][0]['Sep']}}",
                "{{$sales['sales_year_classic_peru'][0]['Oct']}}",
                "{{$sales['sales_year_classic_peru'][0]['Nov']}}",
                "{{$sales['sales_year_classic_peru'][0]['Dic']}}"
            ]
        },
        {
          label               : 'Junior',
          backgroundColor     : 'rgba(255, 0, 255, 0.7)',
          borderColor         : 'rgba(255, 0, 255, 0.6)',
          pointRadius         : false,
          pointColor          : 'rgba(255, 0, 255, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(255, 0, 255,1)',
          data : [
                "{{$sales['sales_year_junior_peru'][0]['Ene']}}",
                "{{$sales['sales_year_junior_peru'][0]['Feb']}}",
                "{{$sales['sales_year_junior_peru'][0]['Mar']}}",
                "{{$sales['sales_year_junior_peru'][0]['Abr']}}",
                "{{$sales['sales_year_junior_peru'][0]['May']}}",
                "{{$sales['sales_year_junior_peru'][0]['Jun']}}",
                "{{$sales['sales_year_junior_peru'][0]['Jul']}}",
                "{{$sales['sales_year_junior_peru'][0]['Ago']}}",
                "{{$sales['sales_year_junior_peru'][0]['Sep']}}",
                "{{$sales['sales_year_junior_peru'][0]['Oct']}}",
                "{{$sales['sales_year_junior_peru'][0]['Nov']}}",
                "{{$sales['sales_year_junior_peru'][0]['Dic']}}"
            ]
        },
        {
          label               : 'Semi Señior',
          backgroundColor     : 'rgba(0,23,255,0.7)',
          borderColor         : 'rgba(0,23,255,0.6)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(0,23,255,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(0,23,255,1)',
          data : [
                "{{$sales['sales_year_middle_peru'][0]['Ene']}}",
                "{{$sales['sales_year_middle_peru'][0]['Feb']}}",
                "{{$sales['sales_year_middle_peru'][0]['Mar']}}",
                "{{$sales['sales_year_middle_peru'][0]['Abr']}}",
                "{{$sales['sales_year_middle_peru'][0]['May']}}",
                "{{$sales['sales_year_middle_peru'][0]['Jun']}}",
                "{{$sales['sales_year_middle_peru'][0]['Jul']}}",
                "{{$sales['sales_year_middle_peru'][0]['Ago']}}",
                "{{$sales['sales_year_middle_peru'][0]['Sep']}}",
                "{{$sales['sales_year_middle_peru'][0]['Oct']}}",
                "{{$sales['sales_year_middle_peru'][0]['Nov']}}",
                "{{$sales['sales_year_middle_peru'][0]['Dic']}}"
            ]
        },
        {
          label               : 'Señior',
          backgroundColor     : 'rgba(255,0,0,0.7)',
          borderColor         : 'rgba(255,0,0,0.6)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(255,0,0,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(255,0,0,1)',
          data : [
                "{{$sales['sales_year_master_peru'][0]['Ene']}}",
                "{{$sales['sales_year_master_peru'][0]['Feb']}}",
                "{{$sales['sales_year_master_peru'][0]['Mar']}}",
                "{{$sales['sales_year_master_peru'][0]['Abr']}}",
                "{{$sales['sales_year_master_peru'][0]['May']}}",
                "{{$sales['sales_year_master_peru'][0]['Jun']}}",
                "{{$sales['sales_year_master_peru'][0]['Jul']}}",
                "{{$sales['sales_year_master_peru'][0]['Ago']}}",
                "{{$sales['sales_year_master_peru'][0]['Sep']}}",
                "{{$sales['sales_year_master_peru'][0]['Oct']}}",
                "{{$sales['sales_year_master_peru'][0]['Nov']}}",
                "{{$sales['sales_year_master_peru'][0]['Dic']}}"
            ]
        },
      ]
    }
    var stackedBarChartCanvas = $('#barChartBoletoPeru').get(0).getContext('2d')
    var stackedBarChartData = $.extend(true, {}, stackedChartData)

    var stackedBarChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      scales: {
        xAxes: [{
          stacked: true,
          gridLines : {
            display : false,
          }
        }],
        yAxes: [{
          stacked: true,
          gridLines : {
            display : false,
          }
        }]
      }
    }

    new Chart(stackedBarChartCanvas, {
      type: 'bar',
      data: stackedBarChartData,
      options: stackedBarChartOptions
    });

     //---------------------
    //- STACKED BAR CHART Ecuador-
    //---------------------
    var stackedChartData = {
      labels  : ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre'],
      datasets: [
        {
          label               : 'Clasicos',
          backgroundColor     : 'rgba(255,255,0,0.7)',
          borderColor         : 'rgba(255,255,0,0.6)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(255,255,0,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(255,255,0,1)',
          data : [
                "{{$sales['sales_year_classic_ecuador'][0]['Ene']}}",
                "{{$sales['sales_year_classic_ecuador'][0]['Feb']}}",
                "{{$sales['sales_year_classic_ecuador'][0]['Mar']}}",
                "{{$sales['sales_year_classic_ecuador'][0]['Abr']}}",
                "{{$sales['sales_year_classic_ecuador'][0]['May']}}",
                "{{$sales['sales_year_classic_ecuador'][0]['Jun']}}",
                "{{$sales['sales_year_classic_ecuador'][0]['Jul']}}",
                "{{$sales['sales_year_classic_ecuador'][0]['Ago']}}",
                "{{$sales['sales_year_classic_ecuador'][0]['Sep']}}",
                "{{$sales['sales_year_classic_ecuador'][0]['Oct']}}",
                "{{$sales['sales_year_classic_ecuador'][0]['Nov']}}",
                "{{$sales['sales_year_classic_ecuador'][0]['Dic']}}"
            ]
        },
        {
          label               : 'Junior',
          backgroundColor     : 'rgba(255, 0, 255, 0.7)',
          borderColor         : 'rgba(255, 0, 255, 0.6)',
          pointRadius         : false,
          pointColor          : 'rgba(255, 0, 255, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(255, 0, 255,1)',
          data : [
                "{{$sales['sales_year_junior_ecuador'][0]['Ene']}}",
                "{{$sales['sales_year_junior_ecuador'][0]['Feb']}}",
                "{{$sales['sales_year_junior_ecuador'][0]['Mar']}}",
                "{{$sales['sales_year_junior_ecuador'][0]['Abr']}}",
                "{{$sales['sales_year_junior_ecuador'][0]['May']}}",
                "{{$sales['sales_year_junior_ecuador'][0]['Jun']}}",
                "{{$sales['sales_year_junior_ecuador'][0]['Jul']}}",
                "{{$sales['sales_year_junior_ecuador'][0]['Ago']}}",
                "{{$sales['sales_year_junior_ecuador'][0]['Sep']}}",
                "{{$sales['sales_year_junior_ecuador'][0]['Oct']}}",
                "{{$sales['sales_year_junior_ecuador'][0]['Nov']}}",
                "{{$sales['sales_year_junior_ecuador'][0]['Dic']}}"
            ]
        },
        {
          label               : 'Semi Señior',
          backgroundColor     : 'rgba(0,23,255,0.7)',
          borderColor         : 'rgba(0,23,255,0.6)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(0,23,255,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(0,23,255,1)',
          data : [
                "{{$sales['sales_year_middle_ecuador'][0]['Ene']}}",
                "{{$sales['sales_year_middle_ecuador'][0]['Feb']}}",
                "{{$sales['sales_year_middle_ecuador'][0]['Mar']}}",
                "{{$sales['sales_year_middle_ecuador'][0]['Abr']}}",
                "{{$sales['sales_year_middle_ecuador'][0]['May']}}",
                "{{$sales['sales_year_middle_ecuador'][0]['Jun']}}",
                "{{$sales['sales_year_middle_ecuador'][0]['Jul']}}",
                "{{$sales['sales_year_middle_ecuador'][0]['Ago']}}",
                "{{$sales['sales_year_middle_ecuador'][0]['Sep']}}",
                "{{$sales['sales_year_middle_ecuador'][0]['Oct']}}",
                "{{$sales['sales_year_middle_ecuador'][0]['Nov']}}",
                "{{$sales['sales_year_middle_ecuador'][0]['Dic']}}"
            ]
        },
        {
          label               : 'Señior',
          backgroundColor     : 'rgba(255,0,0,0.7)',
          borderColor         : 'rgba(255,0,0,0.6)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(255,0,0,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(255,0,0,1)',
          data : [
                "{{$sales['sales_year_master_ecuador'][0]['Ene']}}",
                "{{$sales['sales_year_master_ecuador'][0]['Feb']}}",
                "{{$sales['sales_year_master_ecuador'][0]['Mar']}}",
                "{{$sales['sales_year_master_ecuador'][0]['Abr']}}",
                "{{$sales['sales_year_master_ecuador'][0]['May']}}",
                "{{$sales['sales_year_master_ecuador'][0]['Jun']}}",
                "{{$sales['sales_year_master_ecuador'][0]['Jul']}}",
                "{{$sales['sales_year_master_ecuador'][0]['Ago']}}",
                "{{$sales['sales_year_master_ecuador'][0]['Sep']}}",
                "{{$sales['sales_year_master_ecuador'][0]['Oct']}}",
                "{{$sales['sales_year_master_ecuador'][0]['Nov']}}",
                "{{$sales['sales_year_master_ecuador'][0]['Dic']}}"
            ]
        },
      ]
    }
    var stackedBarChartCanvas = $('#barChartBoletoEcuador').get(0).getContext('2d')
    var stackedBarChartData = $.extend(true, {}, stackedChartData)

    var stackedBarChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      scales: {
        xAxes: [{
          stacked: true,
          gridLines : {
            display : false,
          }
        }],
        yAxes: [{
          stacked: true,
          gridLines : {
            display : false,
          }
        }]
      }
    }

    new Chart(stackedBarChartCanvas, {
      type: 'bar',
      data: stackedBarChartData,
      options: stackedBarChartOptions
    });
</script>
@endsection
