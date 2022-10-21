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
                        <div class="col-6 b-r-default">
                            <h2>{{$raffle->cash_to_draw}}$</h2>
                            <p class="text-muted">Premio Mayor</p>
                        </div>
                        <div class="col-6">
                            <h2>{{$raffle->cash_to_collect}}$</h2>
                            <p class="text-muted">Dinero a Recaudar</p>
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

                    <strong class="text-uppercase">Visibilidad</strong>
                    @if ($raffle->public == 1)
                        <span class="badge badge-success" title="Activo">Publico</span>
                    @else
                        <span class="badge badge-danger" title="Inactivo">Borrador</span>
                    @endif
                    <hr>
                    <strong class="text-uppercase">Estatus</strong>
                    @if ($raffle->active == 1)
                        <span class="badge badge-success" title="Activo"><i class="ti-check"></i> Activo</span>
                    @else
                        <span class="badge badge-danger" title="Inactivo"><i class="ti-close"></i> Inactivo</span>
                    @endif
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
                                        <p class="d-inline-block m-r-20">{{ ($raffle->cash_to_draw*$raffle->prize_1)/100 }}$</p>
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
                                        <p class="d-inline-block m-r-20">{{ ($raffle->cash_to_draw*$raffle->prize_2)/100 }}$</p>
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
                                        <p class="d-inline-block m-r-20">{{ ($raffle->cash_to_draw*$raffle->prize_3)/100 }}$</p>
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
                                        <p class="d-inline-block m-r-20">{{ ($raffle->cash_to_draw*$raffle->prize_4)/100 }}$</p>
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
                                        <p class="d-inline-block m-r-20">{{ ($raffle->cash_to_draw*$raffle->prize_5)/100 }}$</p>
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
                                        <p class="d-inline-block m-r-20">{{ ($raffle->cash_to_draw*$raffle->prize_6)/100 }}$</p>
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
                                        <p class="d-inline-block m-r-20">{{ ($raffle->cash_to_draw*$raffle->prize_7)/100 }}$</p>
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
                                        <p class="d-inline-block m-r-20">{{ ($raffle->cash_to_draw*$raffle->prize_8)/100 }}$</p>
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
                                        <p class="d-inline-block m-r-20">{{ ($raffle->cash_to_draw*$raffle->prize_9)/100 }}$</p>
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
                                        <p class="d-inline-block m-r-20">{{ ($raffle->cash_to_draw*$raffle->prize_10)/100 }}$</p>
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
