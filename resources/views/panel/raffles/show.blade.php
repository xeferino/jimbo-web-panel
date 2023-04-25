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
                        <div class="col-sm-4 b-r-default">
                            <h4>{{Helper::amount($raffle->cash_to_draw)}}</h4>
                            <p class="text-muted">Premio Mayor</p>
                        </div>
                        <div class="col-sm-4 b-r-default">
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
                                $percent = (($raffle->totalSale->sum('amount')*100)/($raffle->cash_to_collect-$amount));

                                $i = 1;
                                $total = 0;
                            @endphp
                            @foreach ($raffle->tickets as $data)
                                @php
                                    $total+=($data->quantity/$data->promotion->quantity)*$data->promotion->price;
                                @endphp
                            @endforeach
                            <h4>{{Helper::amount($amount)}}</h4>
                            <p class="text-muted">Dinero de premiaciones</p>
                        </div>
                        <div class="col-sm-4">
                            <h4>{{Helper::amount($raffle->cash_to_collect-$amount)}}</h4>
                            <p class="text-muted">Dinero total a recaudar</p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-4 b-r-default">
                            <h4>{{Helper::amount($total)}}</h4>
                            <p class="text-muted">Total boleteria</p>
                        </div>
                        <div class="col-sm-4 b-r-default">
                            <h4>{{Helper::amount(($total - ($raffle->cash_to_collect-$amount))-$amount)}}</h4>
                            <p class="text-muted">Sobrande recaudado - boleteria</p>
                        </div>
                        <div class="col-sm-4">
                            <h4>{{ $percent == 100 ?  Helper::percent(100) : Helper::percent($percent) }}</h4>
                            <p class="text-muted">Porcentaje de recaudacion</p>
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

                    <strong class="text-uppercase">Dias de prorroga</strong>
                    <p class="text-muted">{{$raffle->days_extend != null ? $raffle->days_extend : 'No hay dias prorroga'}}</p>
                    <hr>

                    <strong class="text-uppercase">Tipo</strong>
                    <span class="badge badge-warning" title="Activo">{{$raffle->type == 'raffle' ? 'Efectivo' : 'Producto'}}</span>
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
                    <strong class="text-uppercase">Finalizado</strong>
                    <span class="badge badge-{{$raffle->finish == 1 ? 'dark' : 'danger'}}" title="{{$raffle->active == 1 ? 'Si' : 'No'}}">
                        <i class="ti-{{$raffle->active == 1 ? 'check' : 'close'}}"></i>
                        {{$raffle->active == 1 ? 'Si' : 'No'}}
                    </span>
                    <hr>
                    <strong class="text-uppercase">Progreso de recaudacion</strong>
                    <div class="progress mt-2">
                        <div class="progress-bar bg-warning" data-toggle="tooltip" data-placement="top" title="{{Helper::percent($percent)}} ({{Helper::amount($raffle->cash_to_collect-$amount).' - '.Helper::amount($raffle->totalSale->sum('amount'))}})" role="progressbar" style="width: {{$percent}}%;" aria-valuenow="{{$percent}}" aria-valuemin="0" aria-valuemax="100">{{Helper::percent($percent)}}</div>
                    </div>
                    <p><b>({{Helper::amount($raffle->cash_to_collect-$amount).' - '.Helper::amount($raffle->totalSale->sum('amount'))}}) {{Helper::percent($percent)}}</b></p>
                    <hr>
                    <strong class="text-uppercase">Usuarios participantes</strong>
                    <p class="text-muted">{{ $competitors }}</p>
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
                            @if(count($raffle::Winners($raffle->id))>0)
                                <tbody>
                                    @php
                                        $i=1;
                                    @endphp
                                    @foreach ($raffle::Winners($raffle->id) as $winner)
                                        <tr>
                                                <td>
                                                    <div class="task-contain">
                                                        <h6 class="bg-c-yellow d-inline-block text-center">{{$i++}}</h6>
                                                        <p class="d-inline-block m-l-20"> {{$winner['name']}}</p>
                                                    </div>

                                                </td>
                                                <td>
                                                    @if ($raffle->type == 'product')
                                                        <p class="d-inline-block m-r-20">{{ $raffle->title }}</p>
                                                    @else
                                                        <p class="d-inline-block m-r-20">{{$winner['amount']}}</p>
                                                    @endif
                                                </td>
                                                <td>
                                                    <p class="d-inline-block m-r-20">{{ Helper::percent($raffle->prize_1) }}</p>
                                                    <a href="{{route('panel.competitors.winners.show',['competitor' => $winner['id']])}}" data-toggle="tooltip" data-placement="top" title="Detalles"  class="btn-lg">
                                                        <i class="ti-eye text-dark"></i>
                                                    </a>
                                                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="{{ ($winner['status']) ? 'Premio Entregado' : 'Premio Pendiente'}}" data-prize="{{$winner['prize']}}" data-id="{{$winner['id']}}" data-winner="{{$winner['user_id']}}" class="btn-lg {{(!empty($winner['user_id']) && $winner['status'] == 0) ? 'recharge' : ''}}">
                                                        <i class="{{ ($winner['status']) ? 'ti-check text-success' : 'ti-close text-danger'}} "></i>
                                                    </a>
                                                </td>
                                            </a>
                                        </tr>
                                    @endforeach
                                    <div class="modal fade" id="modalContent" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-b">
                                            <div class="col-sm-12">
                                                <div class="card fb-card">
                                                    <div class="card-header">
                                                        <i class="ti-user"></i>
                                                        <div class="d-inline-block">
                                                            <h5 class="title-modal">Detalles de la recarga</h5>
                                                            <span>Detalles</span>
                                                        </div>
                                                    </div>
                                                    <div class="card-block">
                                                        <form method="POST" action="{{ route('panel.raffles.competitor.recharge.jib')}}" name="form-recharge" id="form-recharge" enctype="multipart/form-data">
                                                            @csrf
                                                            <input type="hidden" name="id" id="id">
                                                            <input type="hidden" name="winner" id="winner">
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <label class="col-form-label">Jibs</label>
                                                                    <input type="number" name="jib" id="jib" readonly class="form-control">
                                                                    <div class="col-form-label has-danger-jib"></div>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <label class="col-form-label">Descripcion</label>
                                                                    <textarea name="description" id="description" class="form-control" cols="10" rows="5"></textarea>
                                                                    <div class="col-form-label has-danger-description"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 text-right">
                                                                <button type="button" class="btn btn-inverse btn-sm float-right " data-dismiss="modal">Cerrar</button>
                                                                <button type="submit" class="btn btn-warning  btn-sm btn-recharge mr-2">Recargar</button>
                                                            </div>
                                                        </form>
                                                        <div id="info-user"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                    <tr>
                                        <td align="right" colspan="2">
                                            <p><h5><strong>Total de dinero</strong></h5></p>
                                        </td>
                                        <td>
                                            <p><h5><strong>{{ Helper::amount($amount) }}</strong></h5></p>
                                        </td>
                                    </tr>
                                </tbody>
                            @else
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
                            @endif
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
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Disponibles</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                    $total = 0;
                                @endphp
                                @foreach ($raffle->tickets as $data)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>{{$data->promotion->name}}</td>
                                        <td>{{$data->quantity}}</td>
                                        <td>{{$data->quantity/$data->promotion->quantity}}</td>
                                        <td>{{Helper::amount($data->promotion->price)}}</td>
                                        <td>{{$data->quantity}}</td>
                                        <td>{{$data->total}}</td>
                                    </tr>
                                    @php
                                        $total+=($data->quantity/$data->promotion->quantity)*$data->promotion->price;
                                    @endphp
                                @endforeach
                                <tr>
                                    <td align="right" colspan="6">
                                        <p><h5><strong>Total dinero de boleteria</strong></h5></p>
                                    </td>
                                    <td>
                                        <p id="total"><h5><strong>{{ Helper::amount($total) }}</strong></h5></p>
                                        <input type="hidden" name="total_tickets" id="total_tickets" value="{{ Helper::amount($total) }}">
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
                        <h5>Fechas de prorrogas</h5>
                    </div>
                </div>
                <div class="card-block p-b-10">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Dias de prorroga</th>
                                    <th>Fecha de cierre Anterior</th>
                                    <th>Fecha de sorteo Anterior</th>
                                    <th>Fecha de prorroga</th>
                                    <th>Estatus</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i =1;
                                @endphp
                                @forelse ($raffle->ExtendsDate as $date)
                                    <tr>
                                        <td>{{ $i++}}</td>
                                        <td>{{ $date->days}}</td>
                                        <td>{{ $date->date_end_back->format('d/m/Y')}}</td>
                                        <td>{{ $date->date_release_back->format('d/m/Y')}}</td>
                                        <td>{{ $date->date_release_next->format('d/m/Y')}}</td>
                                        <td>
                                            <span class="badge badge-{{$raffle->active == 1 ? 'success' : 'danger'}}" title="{{$raffle->active == 1 ? 'Activa' : 'Inactiva'}}">
                                                <i class="ti-{{$raffle->active == 1 ? 'check' : 'close'}}"></i>
                                                {{$raffle->active == 1 ? 'Activa' : 'Inactiva'}}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">No hay fechas de prorrogas</td>
                                    </tr>
                                @endforelse
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
