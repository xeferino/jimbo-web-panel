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
            <i class="ti-eye"></i>
            <div class="d-inline-block">
                <h5>Tabla de acciones en el sistema y app</h5>
                <span>Informacion</span>
            </div>
        </div>
        <div class="card-block table-border-style">
            <div class="table-responsive">
                <table class="table table-hover table-action">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Titulo</th>
                            <th>Desripcion</th>
                            <th>Fecha</th>
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
    <!-- Hover table card end -->
@endsection
@section('script-content')
<script src="{{ asset('assets/js/jimbo/actions.js') }}"></script>
@endsection
