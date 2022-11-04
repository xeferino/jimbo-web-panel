@extends('layouts.app', ['title' => $title ?? 'Ventas'])

@section('page-content')
    <!-- Basic card start -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card fb-card">
                <div class="card-header">
                    <i class="ti-money"></i>
                    <div class="d-inline-block">
                        <h5>Datos de la venta</h5>
                        <span>Detalles</span>
                    </div>
                </div>
                <div class="card-block text-center">
                    <div class="row">
                        <div class="col-sm-4 b-r-default">
                            <h4>{{Helper::amount($sale->amount)}}</h4>
                            <p class="text-muted">Monto</p>
                        </div>
                        @php
                            $btn = '';
                            if($sale->status=='approved'){
                                $btn .= '<h4 class="text-success">Aprobada</h4>';
                            }elseif($sale->status=='refused'){
                                $btn .= '<h4 class="text-danger">Rechazada</h4>';
                            } else{
                                $btn .= '<h4 class="text-warning">Pendiente</h4>';
                            }
                        @endphp
                        <div class="col-sm-4 b-r-default">
                            {!!$btn!!}
                            <p class="text-muted">Estatus</p>
                        </div>
                        @php
                            $method = '';
                            if($sale->method=='card'){
                                $method .= 'Tarjeta';
                            }elseif($sale->method=='jib'){
                                $method .= 'Jib';
                            } else{
                                $method .= 'Otro';
                            }
                        @endphp
                        <div class="col-sm-4">
                            <h4>{{$method}}</h4>
                            <p class="text-muted">Metodo</p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-4 b-r-default">
                            <h4>{{$sale->number}}</h4>
                            <p class="text-muted">Referencia</p>
                        </div>
                        <div class="col-sm-4 b-r-default">
                            <h4>{{$sale->number_culqi ?? '*******'}}</h4>
                            <p class="text-muted">Referencia Culqi</p>
                        </div>
                        <div class="col-sm-4">
                            <h4>{{ $sale->created_at->format('d/m/Y H:i:s') }}</h4>
                            <p class="text-muted">Fecha y hora</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="card fb-card">
                <div class="card-header">
                    <i class="ti-calendar"></i>
                    <div class="d-inline-block">
                        <h5>Datos del sorteo</h5>
                        <span>Informacion</span>
                    </div>
                </div>
                <div class="card-block text-center">
                    <div class="row">
                        <div class="col-sm-4 b-r-default">
                            <h4>{{$sale->raffle->title}}</h4>
                            <p class="text-muted">Nombre</p>
                        </div>
                        @php
                            $btn = '';
                            if($sale->raffle->finish==0){
                                $btn .= '<h4 class="text-success">Abierto</h4>';
                            } else{
                                $btn .= '<h4 class="text-warning">Finalizado</h4>';
                            }
                        @endphp
                        <div class="col-sm-4 b-r-default">
                            {!!$btn!!}
                            <p class="text-muted">Estatus</p>
                        </div>

                        <div class="col-sm-4">
                            <h4>{{Helper::amount($sale->raffle->cash_to_draw)}}</h4>
                            <p class="text-muted">Premio</p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-4 b-r-default">
                            <h4>{{$sale->ticket->serial}}</h4>
                            <p class="text-muted">Ticket codido</p>
                        </div>
                        <div class="col-sm-4 b-r-default">
                            <h4>{{$sale->raffle->type == 'product' ? 'Producto' : 'Sorteo'}}</h4>
                            <p class="text-muted">Tipo</p>
                        </div>
                        <div class="col-sm-4">
                            <h4>{{ $sale->quantity }}</h4>
                            <p class="text-muted">Cantidad de boletos</p>
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
                            <strong class="text-uppercase">{{$sale->user->names}}</strong>
                            <p class="text-muted">Nombres</p>
                        </div>
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$sale->user->surnames}}</strong>
                            <p class="text-muted">Apellidos</p>
                        </div>
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$sale->user->dni}}</strong>
                            <p class="text-muted">Dni</p>
                        </div>
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$sale->user->email}}</strong>
                            <p class="text-muted">Email</p>
                        </div>
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$sale->user->phone}}</strong>
                            <p class="text-muted">Telefono</p>
                        </div>
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$sale->user->country->name}}</strong>
                            <p class="text-muted">Pais</p>
                        </div>
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$sale->user->address_city}}</strong>
                            <p class="text-muted">Ciudad</p>
                        </div>
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$sale->user->address}}</strong>
                            <p class="text-muted">Direcion</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        @if (isset($sale->seller_id) && $sale->seller_id)
            <div class="col-sm-12">
                <div class="card fb-card">
                    <div class="card-header">
                        <i class="ti-id-badge"></i>
                        <div class="d-inline-block">
                            <h5>Datos del vendedor</h5>
                            <span>Detalles</span>
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="row">
                            <div class="col-sm-4">
                                <strong class="text-uppercase">{{$sale->seller->names}}</strong>
                                <p class="text-muted">Nombres</p>
                            </div>
                            <div class="col-sm-4">
                                <strong class="text-uppercase">{{$sale->seller->surnames}}</strong>
                                <p class="text-muted">Apellidos</p>
                            </div>
                            <div class="col-sm-4">
                                <strong class="text-uppercase">{{$sale->seller->dni}}</strong>
                                <p class="text-muted">Dni</p>
                            </div>
                            <div class="col-sm-4">
                                <strong class="text-uppercase">{{$sale->seller->email}}</strong>
                                <p class="text-muted">Email</p>
                            </div>
                            <div class="col-sm-4">
                                <strong class="text-uppercase">{{$sale->seller->phone}}</strong>
                                <p class="text-muted">Telefono</p>
                            </div>
                            <div class="col-sm-4">
                                <strong class="text-uppercase">{{$sale->seller->country->name ?? ''}}</strong>
                                <p class="text-muted">Pais</p>
                            </div>
                            <div class="col-sm-4">
                                <strong class="text-uppercase">{{$sale->seller->address_city ?? ''}}</strong>
                                <p class="text-muted">Ciudad</p>
                            </div>
                            <div class="col-sm-4">
                                <strong class="text-uppercase">{{$sale->seller->address ?? ''}}</strong>
                                <p class="text-muted">Direcion</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <!-- Basic card end -->
@endsection

@section('script-content')
<script src="{{ asset('assets/js/jimbo/sales.js') }}"></script>
@endsection
