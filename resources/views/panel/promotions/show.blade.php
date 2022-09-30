@extends('layouts.app', ['title' => $title ?? 'Roles - Detalle'])

@section('page-header')
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header card">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ti ti-eye bg-c-blue"></i>
                        <div class="d-inline">
                            <h4>Detalle Role ({{ $role->name }})</h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="page-header-breadcrumb">
                    <ul class="breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">
                                <i class="icofont icofont-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('roles.show', ['role' => $role->id]) }}">Detalle</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-content')
<div class="row">
    <div class="col-sm-12">
        <div class="card fb-card">
            <div class="card-header">
                <i class="ti-loop"></i>
                <div class="d-inline-block">
                    <h5>{{ $role->name }}</h5>
                    <span>{{ $role->description }}</span>
                </div>
            </div>
            <div class="card-block text-center">
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-info" role="alert"><b>Permisos en el sistema del role</b></div>
                    </div>
                    @foreach ($permissions as $key => $item)
                        <div class="col-6">
                            <h6><b>{{ $item->name }}</b></h6>
                            <p class="text-muted">{{ $item->description }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

