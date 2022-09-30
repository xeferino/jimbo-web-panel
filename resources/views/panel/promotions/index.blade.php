@extends('layouts.app', ['title' => $title ?? 'Promociones'])

@section('page-content')
    <!-- Hover table card start -->
    <div class="card">
        <div class="card-header">
            <h5>Tabla de promociones</h5>
            @can('create-promotion')
                <div class="card-header-right">
                    <a href="{{ route('panel.promotions.create') }}" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Nueva Promocion"><i class="ti-plus"></i></a>
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
