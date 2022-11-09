@extends('layouts.app', ['title' => $title ?? 'Solicitudes de Efectivo'])

@section('page-content')
    <!-- Basic card start -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card fb-card">
                <div class="card-header">
                    <i class="ti-money"></i>
                    <div class="d-inline-block">
                        <h5>Datos de la solicitud</h5>
                        <span>Detalles</span>
                    </div>
                </div>
                <div class="card-block text-center">
                    <div class="row">
                        <div class="col-sm-4 b-r-default">
                            <h4>{{Helper::amount($cash->amount)}}</h4>
                            <p class="text-muted">Monto</p>
                        </div>
                        @php
                            $btn = '';
                            if($cash->status=='approved'){
                                $btn .= '<h4 class="text-success">Aprobada</h4>';
                            }elseif($cash->status=='refused'){
                                $btn .= '<h4 class="text-danger">Rechazada</h4>';
                            }elseif($cash->status=='pending'){
                                $btn .= '<h4 class="text-danger">Pendiente</h4>';
                            }elseif($cash->status=='return'){
                                $btn .= '<h4 class="text-danger">Devuelta</h4>';
                            } else{
                                $btn .= '<h4 class="text-warning">Creada</h4>';
                            }
                        @endphp
                        <div class="col-sm-4 b-r-default">
                            {!!$btn!!}
                            <p class="text-muted">Estatus</p>
                            <p class="text-muted"><button class="btn btn-inverse btn-sm changeStatu">Cambiar</button></p>
                        </div>
                        <div class="col-sm-4">
                            <h4>{{$cash->reference}}</h4>
                            <p class="text-muted">Referencia</p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-4 b-r-default">
                            <h4>{{$cash->description}}</h4>
                            <p class="text-muted">Descripcion</p>
                        </div>
                        <div class="col-sm-4 b-r-default">
                            @php
                                $date = explode('-', $cash->date);
                            @endphp
                            <h4>{{ $date[2].'/'.$date[1].'/'.$date[0]}}</h4>
                            <p class="text-muted">Fecha</p>
                        </div>
                        <div class="col-sm-4">
                            <h4>{{ $cash->hour }}</h4>
                            <p class="text-muted">Hora</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="card fb-card">
                <div class="card-header">
                    <i class="ti-user"></i>
                    <div class="d-inline-block">
                        <h5>Datos del usuario</h5>
                        <span>Detalles</span>
                    </div>
                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$cash->user->names}}</strong>
                            <p class="text-muted">Nombres</p>
                        </div>
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$cash->user->surnames}}</strong>
                            <p class="text-muted">Apellidos</p>
                        </div>
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$cash->user->dni}}</strong>
                            <p class="text-muted">Dni</p>
                        </div>
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$cash->user->email}}</strong>
                            <p class="text-muted">Email</p>
                        </div>
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$cash->user->phone}}</strong>
                            <p class="text-muted">Telefono</p>
                        </div>
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$cash->user->country->name}}</strong>
                            <p class="text-muted">Pais</p>
                        </div>
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$cash->user->address_city}}</strong>
                            <p class="text-muted">Ciudad</p>
                        </div>
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$cash->user->address}}</strong>
                            <p class="text-muted">Direcion</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="card fb-card">
                <div class="card-header">
                    <i class="ti-id-badge"></i>
                    <div class="d-inline-block">
                        <h5>Datos bancarios</h5>
                        <span>Detalles</span>
                    </div>
                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$cash->AccountUser->bank}}</strong>
                            <p class="text-muted">Banco</p>
                        </div>
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$cash->AccountUser->number}}</strong>
                            <p class="text-muted">Numero de cuenta</p>
                        </div>
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$cash->AccountUser->type}}</strong>
                            <p class="text-muted">Tipo</p>
                        </div>
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$cash->name ?? $cash->user->names.' '.$cash->user->surnames}}</strong>
                            <p class="text-muted">Nombres y apellidos</p>
                        </div>
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$cash->dni ?? $cash->user->dni}}</strong>
                            <p class="text-muted">Dni</p>
                        </div>
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$cash->email ?? $cash->user->email}}</strong>
                            <p class="text-muted">Email</p>
                        </div>
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$cash->phone ?? $cash->user->phone}}</strong>
                            <p class="text-muted">Telefono</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Basic card end -->
    <div class="modal fade" id="modalContent" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-b">
            <div class="col-sm-12">
                <div class="card fb-card">
                    <div class="card-header">
                        <i class="ti-user"></i>
                        <div class="d-inline-block">
                            <h5 class="title-modal">Datos del comparador</h5>
                            <span>Detalles</span>
                        </div>
                    </div>
                    <div class="card-block">
                        <form method="POST" action="{{ route('panel.cash.request.change.statu', ['id' => $cash->id]) }}" name="form-changeStatu" id="form-changeStatu" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <label class="col-form-label">Estado de la solicitud</label>
                                    <select name="status" id="status" class="form-control">
                                        @foreach ($status as $key => $data)
                                            <option value="{{ $key }}" {{$cash->status == $key ? 'selected' : null}}>{{ $data }}</option>
                                        @endforeach
                                    </select>
                                    <div class="col-form-label has-danger-status"></div>
                                </div>
                                <div class="col-sm-12">
                                    <label class="col-form-label">Observacion</label>
                                    <textarea name="observation" id="observation" class="form-control" cols="10" rows="5"></textarea>
                                    <div class="col-form-label has-danger-observation"></div>
                                </div>
                            </div>
                            <div class="col-md-12 text-right">
                                <button type="button" class="btn btn-inverse btn-sm float-right " data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-warning  btn-sm btn-changeStatu mr-2">Actualizar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script-content')
<script src="{{ asset('assets/js/jimbo/cash_requests.js') }}"></script>
@endsection
