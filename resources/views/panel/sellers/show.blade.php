@extends('layouts.app', ['title' => $title ?? 'Vendedores'])

@section('page-content')
    <!-- Basic card start -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card fb-card">
                <div class="card-header">
                    <i class="ti-money"></i>
                    <div class="d-inline-block">
                        <h5>Datos de ventas</h5>
                        <span>Detalles</span>
                    </div>
                </div>
                <div class="card-block text-center">
                    <div class="row">
                        <div class="col-sm-4 b-r-default">
                            <h4>{{Helper::amount($seller->sales->sum('amount'))}}</h4>
                            <p class="text-muted">Monto</p>
                        </div>
                        <div class="col-sm-4 b-r-default">
                            <h4>{{$seller->sales->count()}}</h4>
                            <p class="text-muted">Ventas</p>
                        </div>
                        <div class="col-sm-4">
                            <h4>{{Helper::jib($seller->balance_jib ?? 0)}}</h4>
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
                        <h5>Datos del vendedor</h5>
                        <span>Detalles</span>
                    </div>
                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$seller->names}}</strong>
                            <p class="text-muted">Nombres</p>
                        </div>
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$seller->surnames}}</strong>
                            <p class="text-muted">Apellidos</p>
                        </div>
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$seller->dni}}</strong>
                            <p class="text-muted">Dni</p>
                        </div>
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$seller->email}}</strong>
                            <p class="text-muted">Email</p>
                        </div>
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$seller->phone}}</strong>
                            <p class="text-muted">Telefono</p>
                        </div>
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$seller->country->name}}</strong>
                            <p class="text-muted">Pais</p>
                        </div>
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$seller->address_city}}</strong>
                            <p class="text-muted">Ciudad</p>
                        </div>
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$seller->address}}</strong>
                            <p class="text-muted">Direcion</p>
                        </div>
                        <div class="col-sm-4">
                            <strong class="text-uppercase">
                                <span class="badge badge-warning" style="float: left !important;">{{$seller->LevelSeller->level->name ?? '----'}}</span>
                            </strong>
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
                        <h5>Historial de ventas</h5>
                        <span>Detalles</span>
                    </div>
                </div>
                <div class="card-block p-b-10">
                    <input type="hidden" name="seller_id" id="seller_id" value="{{$seller->id}}">
                    <div class="table-responsive">
                        <table class="table table-hover table-seller-sales">
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
                    <div class="modal fade" id="detailUser" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-b">
                            <div class="col-sm-12">
                                <div class="card fb-card">
                                    <div class="card-header">
                                        <i class="ti-user"></i>
                                        <div class="d-inline-block">
                                            <h5>Datos del comparador</h5>
                                            <span>Detalles</span>
                                        </div>
                                    </div>
                                    <div class="card-block">
                                        <div id="info-user"></div>
                                    </div>
                                </div>
                          </div>
                        </div>
                      </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Basic card end -->
@endsection

@section('script-content')
<script src="{{ asset('assets/js/jimbo/sellers.js') }}"></script>
@endsection
