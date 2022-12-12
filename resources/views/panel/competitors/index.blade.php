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
                <h5>Tabla de Participantes</h5>
                <span>Informacion</span>
            </div>
            <div class="float-right">
                <a href="{{route('panel.competitors.winners')}}" class="btn btn-dark" data-toggle="tooltip" data-placement="top">Listados de ganadores</a>
                {{-- @can('create-competitor')
                    <a href="{{ route('panel.competitors.create') }}" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Nuevo participante">Nuevo</a>
                @endcan --}}
            </div>
        </div>
        <div class="card-block table-border-style">
            <div class="table-responsive">
                <table class="table table-hover table-competitor">
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
<script src="{{ asset('assets/js/jimbo/competitors.js') }}"></script>
@endsection
