@extends('layouts.app', ['title' => $title ?? 'Sliders'])

@section('page-content')
    <!-- Hover table card start -->
    <div class="card fb-card">
        <div class="card-header">
            <i class="ti-image"></i>
            <div class="d-inline-block">
                <h5>Tabla de sliders</h5>
                <span>Informacion</span>
            </div>
            @can('create-slider')
                <div class="float-right">
                    <a href="{{ route('panel.sliders.create') }}" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Nuevo Slider">Nuevo</a>
                </div>
            @endcan
        </div>
        <div class="card-block table-border-style">
            <div class="table-responsive">
                <table class="table table-hover table-slider">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Imagen</th>
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
<script src="{{ asset('assets/js/jimbo/sliders.js') }}"></script>
@endsection
