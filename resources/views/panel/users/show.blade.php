@extends('layouts.app', ['title' => $title ?? 'Usuarios'])

@section('page-content')
    <!-- Basic card start -->
    <div class="row">

        <div class="col-sm-12">
            <div class="card fb-card">
                <div class="card-header">
                    <i class="ti-user"></i>
                    <div class="d-inline-block">
                        <h5>Datos del usuario</h5>
                        <span>Detalles</span>
                    </div>
                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$user->names}}</strong>
                            <p class="text-muted">Nombres</p>
                        </div>
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$user->surnames}}</strong>
                            <p class="text-muted">Apellidos</p>
                        </div>
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$user->email}}</strong>
                            <p class="text-muted">Email</p>
                        </div>
                        @php
                            $btn = '';
                            if($user->active==1){
                                $btn .= '<strong class="text-success text-uppercase">Activo</strong>';
                            }else{
                                $btn .= '<strong class="text-danger text-uppercase">Inactivo</strong>';
                            }
                        @endphp
                        <div class="col-sm-4">
                            {!!$btn!!}
                            <p class="text-muted">Estatus</p>
                        </div>
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{ $user->getRoleNames()->join('') }}</strong>
                            <p class="text-muted">Role</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card fb-card">
                <div class="card-header">
                    <i class="ti-list"></i>
                    <div class="d-inline-block">
                        <h5>Permisos del usuario</h5>
                        <span>Detalles</span>
                    </div>
                </div>
                <div class="card-block">
                    <div class="row">
                        @foreach ($permissions as $key => $item)
                            <div class="col-md-4">
                                <div class="checkbox-fade fade-in-warning">
                                    <label style="font-size: 14px !important;">
                                        <input type="checkbox" name="syncPermissions[]" value="{{  $item->id }}" {{ (in_array($item->id , old('syncPermissions', $permissions_users))) ? ' checked' : '' }} disabled>
                                        <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                        <span class="text-inverse"><b>{{  $item->name }}</b></span>
                                    </label>
                                </div>
                                <br>
                                <label style="font-size: 12px !important;">
                                    <span class="text-inverse">{{  $item->description }}</span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script-content')
<script src="{{ asset('assets/js/jimbo/users.js') }}"></script>
@endsection
