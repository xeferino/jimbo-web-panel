@extends('layouts.app', ['title' => $title ?? 'Participantes'])

@section('page-content')
    <!-- Basic card start -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card fb-card">
                <div class="card-header">
                    <i class="ti-money"></i>
                    <div class="d-inline-block">
                        <h5>Datos de Balance</h5>
                        <span>Detalles</span>
                    </div>
                </div>
                <div class="card-block text-center">
                    <div class="row">
                        <div class="col-sm-3 b-r-default">
                            <h4>{{Helper::amount($competitor->shoppings->sum('amount'))}}</h4>
                            <p class="text-muted">Monto en compras</p>
                        </div>
                        <div class="col-sm-3 b-r-default">
                            <h4>{{$competitor->shoppings->count()}}</h4>
                            <p class="text-muted">Compras</p>
                        </div>
                        <div class="col-sm-3 b-r-default">
                            <h4>{{Helper::amount($competitor->balance_usd ?? 0)}}</h4>
                            <p class="text-muted">Balance de efectivo</p>
                        </div>
                        <div class="col-sm-3">
                            <h4>{{Helper::jib($competitor->balance_jib ?? 0)}}</h4>
                            <p class="text-muted">Balance de jibs</p>
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
                        <h5>Datos del participante</h5>
                        <span>Detalles</span>
                    </div>
                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$competitor->names}}</strong>
                            <p class="text-muted">Nombres</p>
                        </div>
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$competitor->surnames}}</strong>
                            <p class="text-muted">Apellidos</p>
                        </div>
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$competitor->dni}}</strong>
                            <p class="text-muted">Dni</p>
                        </div>
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$competitor->email}}</strong>
                            <p class="text-muted">Email</p>
                        </div>
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$competitor->phone}}</strong>
                            <p class="text-muted">Telefono</p>
                        </div>
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$competitor->country->name}}</strong>
                            <p class="text-muted">Pais</p>
                        </div>
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$competitor->address_city}}</strong>
                            <p class="text-muted">Ciudad</p>
                        </div>
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$competitor->address}}</strong>
                            <p class="text-muted">Direcion</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="card fb-card">
                <div class="card-header">
                    <i class="ti-money"></i>
                    <div class="d-inline-block">
                        <h5>Historial de compras</h5>
                        <span>Detalles</span>
                    </div>
                </div>
                <div class="card-block p-b-10">
                    <input type="hidden" name="competitor_id" id="competitor_id" value="{{$competitor->id}}">
                    <div class="table-responsive">
                        <table class="table table-hover table-competitor-shoppings">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Numero de operacion</th>
                                    <th>Refencia de culqi</th>
                                    <th>Monto</th>
                                    <th>Metodo</th>
                                    <th>Sorteo</th>
                                    <th>Cantidad de ticket</th>
                                    <th>Promocion</th>
                                    <th>Fecha</th>
                                    <th>Estatus</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="card fb-card">
                <div class="card-header">
                    <i class="ti-money"></i>
                    <div class="d-inline-block">
                        <h5>Historial de pagos</h5>
                        <span>Detalles</span>
                    </div>
                </div>
                <div class="card-block p-b-10">
                    <div class="table-responsive">
                        <table class="table table-hover table-competitor-payment-history">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Numero de operacion</th>
                                    <th>Metodo</th>
                                    <th>Monto</th>
                                    <th>Descripcion</th>
                                    <th>Mensaje</th>
                                    <th>Fecha</th>
                                    <th>Estatus</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="card fb-card">
                <div class="card-header">
                    <i class="ti-money"></i>
                    <div class="d-inline-block">
                        <h5>Solicitudes de efectivo</h5>
                        <span>Informacion</span>
                    </div>
                </div>
                <div class="card-block table-border-style">
                    <div class="table-responsive">
                        <table class="table table-hover table-cash">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Monto</th>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Referencia</th>
                                    <th>Usuario</th>
                                    <th>Estatus</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="card fb-card">
                <div class="card-header">
                    <i class="ti-money"></i>
                    <div class="d-inline-block">
                        <h5>Balances</h5>
                        <span>Informacion</span>
                    </div>
                </div>
                <div class="card-block table-border-style">
                    <div class="table-responsive">
                        <table class="table table-hover table-balance">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Referencia</th>
                                    <th>Descripcion</th>
                                    <th>Tipo</th>
                                    <th>Monto</th>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Usuario</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
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
<script src="{{ asset('assets/js/jimbo/competitors.js') }}"></script>
@endsection
