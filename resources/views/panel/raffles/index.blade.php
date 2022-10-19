@extends('layouts.app', ['title' => $title ?? 'Sorteos'])

@section('page-content')
    <!-- Hover table card start -->
    <div class="card">
        <div class="card-header">
            <h5>Tabla de sorteos</h5>
            @can('create-raffle')
                <div class="card-header-right">
                    <a href="{{ route('panel.raffles.create') }}" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Nuevo Sorteo"><i class="ti-plus"></i></a>
                </div>
            @endcan
        </div>
        <div class="card-block table-border-style">
            <div class="table-responsive">
                <table class="table table-hover table-raffle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Premio a repartir</th>
                            <th>Dinero a recaudar</th>
                            <th>Fecha de apertura</th>
                            <th>Fecha de cierre</th>
                            <th>Fecha de sorteo</th>
                            <th>Visibilidad</th>
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
<script src="{{ asset('assets/js/jimbo/raffles.js') }}"></script>
@endsection
