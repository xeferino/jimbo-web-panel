@extends('layouts.app', [
    'title'              => $title,
    'title_header'       => $title_header,
    'description_module' => $description_module,
    'title_nav'          => $title_nav,
    'icon'               => $icon
])
@section('page-content')
    <!-- Hover table card start -->
    <div class="card">
        <div class="card-header">
            <h5>Tabla de Usuarios</h5>
            @can('create-user')
                <div class="card-header-right">
                    <a href="{{ route('panel.users.create') }}" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Nuevo Usuario"><i class="ti-plus"></i></a>
                </div>
            @endcan
        </div>
        <div class="card-block table-border-style">
            <div class="table-responsive">
                <table class="table table-hover table-user">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Imagen</th>
                            <th>Nombres y Apellidos</th>
                            <th>Role</th>
                            <th>Email</th>
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
<script src="{{ asset('assets/js/jimbo/users.js') }}"></script>
@endsection
