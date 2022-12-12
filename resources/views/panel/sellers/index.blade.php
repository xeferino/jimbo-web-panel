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
            <i class="ti-user"></i>
            <div class="d-inline-block">
                <h5>Tabla de Vendedores</h5>
                <span>Informacion</span>
            </div>
            @can('create-seller')
                <div class="float-right">
                    <a href="{{ route('panel.sellers.create') }}" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Nuevo Vendedor">Nuevo</a>
                </div>
            @endcan
        </div>
        <div class="card-block table-border-style">
            <div class="table-responsive">
                <table class="table table-hover table-seller">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Imagen</th>
                            <th>Nombres y Apellidos</th>
                            <th>Role</th>
                            <th>Email</th>
                            <th>Tipo</th>
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
<script src="{{ asset('assets/js/jimbo/sellers.js') }}"></script>
@endsection
