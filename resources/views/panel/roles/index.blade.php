@extends('layouts.app', ['title' => $title ?? 'Roles'])

@section('page-content')
    <!-- Hover table card start -->
    <div class="card">
        <div class="card-header">
            <h5>Tabla de roles</h5>
            @can('create-role')
                <div class="card-header-right">
                    <a href="{{ route('panel.roles.create') }}" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Nuevo Role"><i class="ti-plus"></i></a>
                </div>
            @endcan
        </div>
        <div class="card-block table-border-style">
            <div class="table-responsive">
                <table class="table table-hover table-role">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Descripcion</th>
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
<script src="{{ asset('assets/js/jimbo/roles.js') }}"></script>
@endsection
