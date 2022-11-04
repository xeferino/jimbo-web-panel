@extends('layouts.app', ['title' => $title ?? 'Promociones'])

@section('page-content')
    <!-- Hover table card start -->
    <div class="card fb-card">
        <div class="card-header">
            <i class="ti-announcement"></i>
            <div class="d-inline-block">
                <h5>Tabla de promociones</h5>
                <span>Informacion</span>
            </div>
            @can('create-promotion')
                <div class="float-right">
                    <a href="{{ route('panel.promotions.create') }}" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Nueva Promocion">Nueva</a>
                </div>
            @endcan
        </div>
        <div class="card-block table-border-style">
            <div class="table-responsive">
                <table class="table table-hover table-promotion">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Codigo</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
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
<script src="{{ asset('assets/js/jimbo/promotions.js') }}"></script>
@endsection
