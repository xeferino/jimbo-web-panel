@extends('layouts.app', ['title' => $title ?? 'Solicitudes de Efectivo'])

@section('page-content')
    <!-- Basic card start -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card fb-card">
                <div class="card-header">
                    <i class="ti-money"></i>
                    <div class="d-inline-block">
                        <h5>Datos del egreso en efectivo</h5>
                        <span>Detalles</span>
                    </div>
                </div>
                <div class="card-block text-center">
                    <div class="row">
                        <div class="col-sm-4 b-r-default">
                            <h4>{{Helper::amount($egress->amount)}}</h4>
                            <p class="text-muted">Monto</p>
                        </div>
                        @php
                            $btn = '';
                            if($egress->status=='approved'){
                                $btn .= '<h4 class="text-success">Aprobada</h4>';
                            }elseif($egress->status=='refused'){
                                $btn .= '<h4 class="text-danger">Rechazada</h4>';
                            }elseif($egress->status=='pending'){
                                $btn .= '<h4 class="text-danger">Pendiente</h4>';
                            }elseif($egress->status=='return'){
                                $btn .= '<h4 class="text-danger">Devuelta</h4>';
                            } else{
                                $btn .= '<h4 class="text-warning">Creada</h4>';
                            }
                        @endphp
                        <div class="col-sm-4 b-r-default">
                            {!!$btn!!}
                            <p class="text-muted">Estatus</p>
                        </div>
                        <div class="col-sm-4">
                            <h4>{{$egress->reference}}</h4>
                            <p class="text-muted">Referencia</p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-4 b-r-default">
                            <h4>{{$egress->description}}</h4>
                            <p class="text-muted">Descripcion</p>
                        </div>
                        <div class="col-sm-4 b-r-default">
                            <h4>{{$egress->updated_at->format('d/m/Y')}}</h4>
                            <p class="text-muted">Fecha</p>
                        </div>
                        <div class="col-sm-4">
                            <h4>{{$egress->updated_at->format('H:i:s')}}</h4>
                            <p class="text-muted">Hora</p>
                        </div>
                    </div>
                    @if($egress->observation != null)
                        <div class="row mt-3">
                            <div class="col-sm-12  text-left">
                                <strong class="text-uppercase">
                                    <span class="badge badge-light" style="float: left !important;">
                                        Observaciones: {{$egress->observation}}
                                    </span>
                                </strong>
                            </div>
                        </div>
                    @endif
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
                            <strong class="text-uppercase">{{$egress->user->names}}</strong>
                            <p class="text-muted">Nombres</p>
                        </div>
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$egress->user->surnames}}</strong>
                            <p class="text-muted">Apellidos</p>
                        </div>
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$egress->user->dni}}</strong>
                            <p class="text-muted">Dni</p>
                        </div>
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$egress->user->email}}</strong>
                            <p class="text-muted">Email</p>
                        </div>
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$egress->user->phone}}</strong>
                            <p class="text-muted">Telefono</p>
                        </div>
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$egress->user->country->name}}</strong>
                            <p class="text-muted">Pais</p>
                        </div>
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$egress->user->address_city}}</strong>
                            <p class="text-muted">Ciudad</p>
                        </div>
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$egress->user->address}}</strong>
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
                            <strong class="text-uppercase">{{$egress->AccountUser->bank}}</strong>
                            <p class="text-muted">Banco</p>
                        </div>
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$egress->AccountUser->number}}</strong>
                            <p class="text-muted">Numero de cuenta</p>
                        </div>
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$egress->AccountUser->type}}</strong>
                            <p class="text-muted">Tipo</p>
                        </div>
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$egress->name ?? $egress->user->names.' '.$egress->user->surnames}}</strong>
                            <p class="text-muted">Nombres y apellidos</p>
                        </div>
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$egress->dni ?? $egress->user->dni}}</strong>
                            <p class="text-muted">Dni</p>
                        </div>
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$egress->email ?? $egress->user->email}}</strong>
                            <p class="text-muted">Email</p>
                        </div>
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$egress->phone ?? $egress->user->phone}}</strong>
                            <p class="text-muted">Telefono</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Basic card end -->
@endsection

@section('script-content')
<script src="{{ asset('assets/js/jimbo/egress.js') }}"></script>
@endsection
