@extends('layouts.app', [
    'title'              => $title,
    'title_header'       => $title_header,
    'description_module' => $description_module,
    'title_nav'          => $title_nav,
    'icon'               => $icon
])
@section('page-content')
    <!-- Hover table card start -->
    <div class="card fb-card">
        <div class="card-header">
            <i class="ti-money"></i>
            <div class="d-inline-block">
                <h5>Tabla de ventas</h5>
                <span>Informacion</span>
            </div>
            @can('create-sale')
                <div class="float-right">
                    <a href="{{ route('panel.sales.create') }}" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Nueva Venta">Nueva</a>
                </div>
            @endcan
        </div>
        <div class="card-block table-border-style">
            <div class="table-responsive">
                <table class="table table-hover table-sale">
                    <thead>
                        <tr>
                            <th>Codigo</th>
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
    <!-- Hover table card end -->
@endsection
@section('script-content')
<script src="{{ asset('assets/js/jimbo/sales.js') }}"></script>
@endsection
