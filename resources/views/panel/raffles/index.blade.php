@extends('layouts.app', ['title' => $title ?? 'Sorteos'])

@section('page-content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card fb-card">
                <div class="card-header">
                    <h5>Filtros</h5>
                </div>
                <div class="card-block table-border-style">
                    <div class="container">
                        <div class="border rounded py-2 px-2 mb-2">
                            <form method="POST" action="" name="form-raffle-filter" id="form-raffle-filter">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Nombre</label>
                                        <input type="text" name="title" id="title" class="form-control">
                                    </div>

                                    <div class="col-sm-3">
                                        <label class="col-form-label">Desde</label>
                                        <div class="input-group">
                                            <input type="text" name="date_start" id="date_start" class="form-control datepicker">
                                            <span class="input-group-addon"><i class="icofont icofont-calendar"></i></span>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <label class="col-form-label">Hasta</label>
                                        <div class="input-group">
                                            <input type="text" name="date_end" id="date_end" class="form-control datepicker">
                                            <span class="input-group-addon"><i class="icofont icofont-calendar"></i></span>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <label class="col-form-label">Tipo</label>
                                        <select name="type" id="type" class="form-control">
                                            <option value="">.::Seleccione::.</option>
                                            <option value="raffle">Sorteo</option>
                                            <option value="product">Producto</option>
                                        </select>
                                    </div>

                                    <div class="col-sm-3">
                                        <label class="col-form-label">Visibilidad</label>
                                        <select name="public" id="public" class="form-control">
                                            <option value="">.::Seleccione::.</option>
                                            <option value="1">Publico</option>
                                            <option value="0">Borrador</option>
                                        </select>
                                    </div>

                                    <div class="col-sm-3">
                                        <label class="col-form-label">Estatus</label>
                                        <select name="active" id="active" class="form-control">
                                            <option value="">.::Seleccione::.</option>
                                            <option value="1">Activo</option>
                                            <option value="0">Inactivo</option>
                                        </select>
                                    </div>

                                    <div class="col-sm-3">
                                        <label class="col-form-label">Proceso</label>
                                        <select name="finish" id="finish" class="form-control">
                                            <option value="">.::Seleccione::.</option>
                                            <option value="1">Abierto</option>
                                            <option value="0">Finalizado</option>
                                        </select>
                                    </div>

                                    <div class="col-sm-3">
                                        <label class="col-form-label">Dinero de Premios</label>
                                        <select name="cash_to_draw" id="cash_to_draw" class="form-control">
                                            <option value="">.::Seleccione::.</option>
                                            <option value="100-500">{{Helper::amount(100). ' - '. Helper::amount(500)}}</option>
                                            <option value="500-1000">{{Helper::amount(500). ' - '. Helper::amount(1000)}}</option>
                                            <option value="1000-5000">{{Helper::amount(1000). ' - '. Helper::amount(5000)}}</option>
                                            <option value="5000-10000">{{Helper::amount(5000). ' - '. Helper::amount(10000)}}</option>
                                            <option value="10000-20000">{{Helper::amount(10000). ' - '. Helper::amount(20000)}}</option>
                                            <option value="20000-50000">{{Helper::amount(20000). ' - '. Helper::amount(50000)}}</option>
                                        </select>
                                    </div>

                                    <div class="col-sm-3">
                                        <label class="col-form-label">Dinero a Recolectar</label>
                                        <select name="cash_to_collect" id="cash_to_collect" class="form-control">
                                            <option value="">.::Seleccione::.</option>
                                            <option value="100-500">{{Helper::amount(100). ' - '. Helper::amount(500)}}</option>
                                            <option value="500-1000">{{Helper::amount(500). ' - '. Helper::amount(1000)}}</option>
                                            <option value="1000-5000">{{Helper::amount(1000). ' - '. Helper::amount(5000)}}</option>
                                            <option value="5000-10000">{{Helper::amount(5000). ' - '. Helper::amount(10000)}}</option>
                                            <option value="10000-20000">{{Helper::amount(10000). ' - '. Helper::amount(20000)}}</option>
                                            <option value="20000-50000">{{Helper::amount(20000). ' - '. Helper::amount(50000)}}</option>
                                        </select>
                                    </div>

                                <div class="col-lg-12 col-md-6 col-sm-6 text-center mt-4">
                                    <button type="reset" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Reiniciar Filtros"><i class="ti-reload"></i>Reiniciar Filtros</button>
                                    <button type="submit" class="btn btn-warning">Filtrar Busqueda</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="col-md-12 col-xl-12">
        <div class="card fb-card">
            <div class="card-header">
                <i class="ti-calendar"></i>
                <div class="d-inline-block">
                    <h5>Tabla de sorteos</h5>
                    <span>Informacion</span>
                </div>
                @can('create-raffle')
                    <div class="float-right">
                        <a href="{{ route('panel.raffles.create') }}" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Nuevo Sorteo">Nuevo</a>
                    </div>
                @endcan
            </div>
            <div class="card-block table-border-style">
                <div class="container">
                    {{-- <div class="row">
                        <div class="col-md-6 col-xl-3">
                            <div class="card widget-card-1">
                                <div class="card-block-small">
                                    <i class="icofont icofont-pie-chart bg-c-blue card1-icon"></i>
                                    <span class="text-c-blue f-w-600">Use space</span>
                                    <h4>49/50GB</h4>
                                    <div>
                                        <span class="f-left m-t-10 text-muted">
                                            <i class="text-c-blue f-16 icofont icofont-warning m-r-10"></i>Get more space
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3">
                            <div class="card widget-card-1">
                                <div class="card-block-small">
                                    <i class="icofont icofont-pie-chart bg-c-blue card1-icon"></i>
                                    <span class="text-c-blue f-w-600">Use space</span>
                                    <h4>49/50GB</h4>
                                    <div>
                                        <span class="f-left m-t-10 text-muted">
                                            <i class="text-c-blue f-16 icofont icofont-warning m-r-10"></i>Get more space
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3">
                            <div class="card widget-card-1">
                                <div class="card-block-small">
                                    <i class="icofont icofont-pie-chart bg-c-blue card1-icon"></i>
                                    <span class="text-c-blue f-w-600">Use space</span>
                                    <h4>49/50GB</h4>
                                    <div>
                                        <span class="f-left m-t-10 text-muted">
                                            <i class="text-c-blue f-16 icofont icofont-warning m-r-10"></i>Get more space
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3">
                            <div class="card widget-card-1">
                                <div class="card-block-small">
                                    <i class="icofont icofont-pie-chart bg-c-blue card1-icon"></i>
                                    <span class="text-c-blue f-w-600">Use space</span>
                                    <h4>49/50GB</h4>
                                    <div>
                                        <span class="f-left m-t-10 text-muted">
                                            <i class="text-c-blue f-16 icofont icofont-warning m-r-10"></i>Get more space
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-xl-6">
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
                                            <h4>$1,500.00</h4>
                                            <p class="text-muted">Egresos</p>
                                        </div>
                                        <div class="col-sm-6">
                                            <h4>$1,000.00</h4>
                                            <p class="text-muted">Retiros</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-xl-6">
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
                                            <h4>$1,500.00</h4>
                                            <p class="text-muted">Egresos</p>
                                        </div>
                                        <div class="col-sm-6">
                                            <h4>$1,000.00</h4>
                                            <p class="text-muted">Retiros</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <div class="table-responsive">
                        <table class="table table-hover table-raffle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Premio a repartir</th>
                                    {{-- <th>Dinero a recaudar</th> --}}
                                    <th>Avance de la recaudacion</th>
                                    <th>Fecha de apertura</th>
                                    <th>Fecha de cierre</th>
                                    <th>Fecha de sorteo</th>
                                    <th>Tipo</th>
                                    <th>Visibilidad</th>
                                    <th>Estatus</th>
                                    <th>Proceso</th>
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

@endsection

@section('script-content')
<script src="{{ asset('assets/js/jimbo/raffles.js') }}"></script>
@endsection
