@extends('layouts.app', ['title' => $title ?? 'Sorteos'])

@section('page-content')
    <!-- Basic card start -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card fb-card">
                <div class="card-header">
                    <i class="ti-money"></i>
                    <div class="d-inline-block">
                        <h5>Premios y Recaudos</h5>
                        <span>Ganancias</span>
                    </div>
                </div>
                <div class="card-block text-center">
                    <div class="row">
                        <div class="col-4 b-r-default">
                            <h2>{{Helper::amount($raffle->cash_to_draw)}}</h2>
                            <p class="text-muted">Premio Mayor</p>
                        </div>
                        <div class="col-4 b-r-default">
                            @php
                                $amount = ((($raffle->cash_to_draw*$raffle->prize_1)/100) +
                                          (($raffle->cash_to_draw*$raffle->prize_2)/100) +
                                          (($raffle->cash_to_draw*$raffle->prize_3)/100) +
                                          (($raffle->cash_to_draw*$raffle->prize_4)/100) +
                                          (($raffle->cash_to_draw*$raffle->prize_5)/100) +
                                          (($raffle->cash_to_draw*$raffle->prize_6)/100) +
                                          (($raffle->cash_to_draw*$raffle->prize_7)/100) +
                                          (($raffle->cash_to_draw*$raffle->prize_8)/100) +
                                          (($raffle->cash_to_draw*$raffle->prize_9)/100) +
                                          (($raffle->cash_to_draw*$raffle->prize_10)/100));
                            @endphp
                            <h2>{{Helper::amount($amount)}}</h2>
                            <p class="text-muted">Dinero de premiaciones</p>
                        </div>
                        <div class="col-4">
                            <h2>{{Helper::amount($raffle->cash_to_collect-$amount)}}</h2>
                            <p class="text-muted">Dinero total a recaudar</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card fb-card">
                <div class="card-header">
                    <div class="d-inline-block">
                        <h5>Datos del sorteo</h5>
                    </div>
                </div>
                <div class="card-block">
                    <strong class="text-uppercase">Titulo</strong>
                    <p class="text-muted">{{$raffle->title}}</p>
                    <hr>

                    <strong class="text-uppercase">Marca</strong>
                    <p class="text-muted">{{$raffle->brand}}</p>
                    <hr>

                    <strong class="text-uppercase">Descripcion</strong>
                    <p class="text-muted">{{$raffle->description}}</p>
                    <hr>

                    <strong class="text-uppercase">Promotor</strong>
                    <p class="text-muted">{{$raffle->promoter}}</p>
                    <hr>

                    <strong class="text-uppercase">Proveedor</strong>
                    <p class="text-muted">{{$raffle->provider}}</p>
                    <hr>

                    <strong class="text-uppercase">Localidad</strong>
                    <p class="text-muted">{{$raffle->place}}</p>
                    <hr>

                    <strong class="text-uppercase">Fecha de apertura</strong>
                    <p class="text-muted">{{$raffle->date_start->format('d/m/Y')}}</p>
                    <hr>

                    <strong class="text-uppercase">Fecha de cierre</strong>
                    <p class="text-muted">{{$raffle->date_end->format('d/m/Y')}}</p>
                    <hr>

                    <strong class="text-uppercase">Fecha de sorteo</strong>
                    <p class="text-muted">{{$raffle->date_release->format('d/m/Y')}}</p>
                    <hr>

                    <strong class="text-uppercase">Fecha de prorroga</strong>
                    <p class="text-muted">{{$raffle->date_extend != null ? $raffle->date_extend->format('d/m/Y') : 'No hay prorroga'}}</p>
                    <hr>

                    <strong class="text-uppercase">Tipo</strong>
                    <span class="badge badge-warning" title="Activo">{{$raffle->type == 'raffle' ? 'Sorteo' : 'Producto'}}</span>
                    <hr>

                    <strong class="text-uppercase">Visibilidad</strong>
                    <span class="badge badge-{{$raffle->public == 1 ? 'success' : 'danger'}}" title="{{$raffle->public == 1 ? 'Publico' : 'Borrador'}}">
                        <i class="ti-{{$raffle->public == 1 ? 'check' : 'close'}}"></i>
                        {{$raffle->public == 1 ? 'Publico' : 'Borrador'}}
                    </span>
                    <hr>
                    <strong class="text-uppercase">Estatus</strong>
                    <span class="badge badge-{{$raffle->active == 1 ? 'success' : 'danger'}}" title="{{$raffle->active == 1 ? 'Activo' : 'Inactivo'}}">
                        <i class="ti-{{$raffle->active == 1 ? 'check' : 'close'}}"></i>
                        {{$raffle->active == 1 ? 'Activo' : 'Inactivo'}}
                    </span>
                    <hr>
                    <strong class="text-uppercase">Progreso de recaudacion</strong>
                    <div class="progress mt-2">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-8">
            <div class="card project-task fb-card">
                <div class="card-header">
                    <div class="card-header-left ">
                        <h5>Premios del sorteo</h5>
                    </div>
                </div>
                <div class="card-block p-b-10">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Ganadores</th>
                                    <th>Monto</th>
                                    <th>Porcentaje</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="task-contain">
                                            <h6 class="bg-c-yellow d-inline-block text-center">1</h6>
                                            <p class="d-inline-block m-l-20">1 primer premio</p>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($raffle->type == 'product')
                                            <p class="d-inline-block m-r-20">{{ $raffle->title }}</p>
                                        @else
                                            <p class="d-inline-block m-r-20">{{ Helper::amount(($raffle->cash_to_draw*$raffle->prize_1)/100) }}</p>
                                        @endif
                                    </td>
                                    <td>
                                        <p class="d-inline-block m-r-20">{{ Helper::percent($raffle->prize_1) }}</p>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="task-contain">
                                            <h6 class="bg-c-yellow d-inline-block text-center">2</h6>
                                            <p class="d-inline-block m-l-20">2 segundo premio</p>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="d-inline-block m-r-20">{{ Helper::amount(($raffle->cash_to_draw*$raffle->prize_2)/100) }}</p>
                                    </td>
                                    <td>
                                        <p class="d-inline-block m-r-20">{{ Helper::percent($raffle->prize_2) }}</p>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="task-contain">
                                            <h6 class="bg-c-yellow d-inline-block text-center">3</h6>
                                            <p class="d-inline-block m-l-20">3 tercer premio</p>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="d-inline-block m-r-20">{{ Helper::amount(($raffle->cash_to_draw*$raffle->prize_3)/100) }}</p>
                                    </td>
                                    <td>
                                        <p class="d-inline-block m-r-20">{{ Helper::percent($raffle->prize_3) }}</p>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="task-contain">
                                            <h6 class="bg-c-yellow d-inline-block text-center">4</h6>
                                            <p class="d-inline-block m-l-20">4 cuarto premio</p>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="d-inline-block m-r-20">{{ Helper::amount(($raffle->cash_to_draw*$raffle->prize_4)/100) }}</p>
                                    </td>
                                    <td>
                                        <p class="d-inline-block m-r-20">{{ Helper::percent($raffle->prize_4) }}</p>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="task-contain">
                                            <h6 class="bg-c-yellow d-inline-block text-center">5</h6>
                                            <p class="d-inline-block m-l-20">5 quinto premio</p>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="d-inline-block m-r-20">{{ Helper::amount(($raffle->cash_to_draw*$raffle->prize_5)/100) }}</p>
                                    </td>
                                    <td>
                                        <p class="d-inline-block m-r-20">{{ Helper::percent($raffle->prize_5) }}</p>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="task-contain">
                                            <h6 class="bg-c-yellow d-inline-block text-center">6</h6>
                                            <p class="d-inline-block m-l-20">6 sexto premio</p>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="d-inline-block m-r-20">{{ Helper::amount(($raffle->cash_to_draw*$raffle->prize_6)/100) }}</p>
                                    </td>
                                    <td>
                                        <p class="d-inline-block m-r-20">{{ Helper::percent($raffle->prize_6) }}</p>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="task-contain">
                                            <h6 class="bg-c-yellow d-inline-block text-center">7</h6>
                                            <p class="d-inline-block m-l-20">7 septimo premio</p>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="d-inline-block m-r-20">{{ Helper::amount(($raffle->cash_to_draw*$raffle->prize_7)/100) }}</p>
                                    </td>
                                    <td>
                                        <p class="d-inline-block m-r-20">{{ Helper::percent($raffle->prize_7) }}</p>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="task-contain">
                                            <h6 class="bg-c-yellow d-inline-block text-center">8</h6>
                                            <p class="d-inline-block m-l-20">8 octavo premio</p>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="d-inline-block m-r-20">{{ Helper::amount(($raffle->cash_to_draw*$raffle->prize_8)/100) }}</p>
                                    </td>
                                    <td>
                                        <p class="d-inline-block m-r-20">{{ Helper::percent($raffle->prize_7) }}</p>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="task-contain">
                                            <h6 class="bg-c-yellow d-inline-block text-center">9</h6>
                                            <p class="d-inline-block m-l-20">9 noveno premio</p>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="d-inline-block m-r-20">{{ Helper::amount(($raffle->cash_to_draw*$raffle->prize_9)/100) }}</p>
                                    </td>
                                    <td>
                                        <p class="d-inline-block m-r-20">{{ Helper::percent($raffle->prize_9) }}</p>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="task-contain">
                                            <h6 class="bg-c-yellow d-inline-block text-center">10</h6>
                                            <p class="d-inline-block m-l-20">10 decimo premio</p>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="d-inline-block m-r-20">{{ Helper::amount(($raffle->cash_to_draw*$raffle->prize_10)/100) }}</p>
                                    </td>
                                    <td>
                                        <p class="d-inline-block m-r-20">{{ Helper::percent($raffle->prize_10) }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right" colspan="2">
                                        <p><h5><strong>Total de dinero</strong></h5></p>
                                    </td>
                                    <td>
                                        <p><h5><strong>{{ Helper::amount($amount) }}</strong></h5></p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="card project-task fb-card">
                <div class="card-header">
                    <div class="card-header-left ">
                        <h5>Boletos y/o promociones del sorteo</h5>
                    </div>
                </div>
                <div class="card-block p-b-10">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Promocion</th>
                                    <th>Boletos</th>
                                    <th>Conjuntos</th>
                                    <th>Cantidad</th>
                                    <th>Disponibles</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($raffle->tickets as $data)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>{{$data->promotion->name}}</td>
                                        <td>{{$data->quantity}}</td>
                                        <td>{{$data->quantity/$data->promotion->quantity}}</td>
                                        <td>{{$data->total}}</td>
                                        <td>{{$data->quantity}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="card project-task fb-card">
                <div class="card-header">
                    <div class="card-header-left ">
                        <h5>Fechas de prorrogas</h5>
                    </div>
                </div>
                <div class="card-block p-b-10">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Dias</th>
                                    <th>Fecha Anterior</th>
                                    <th>Fecha de prorroga</th>
                                    <th>Estatus</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="5">No hay fechas de prorrogas</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Basic card end -->
@endsection

@section('script-content')
<script src="{{ asset('assets/js/jimbo/raffles.js') }}"></script>
@endsection
