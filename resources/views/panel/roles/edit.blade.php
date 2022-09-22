@extends('layouts.app', ['title' => $title ?? 'Roles'])

@section('page-content')
    <!-- Basic Form Inputs card start -->
    <div class="card">
        <div class="card-header">
            <h5>Fomulario de actualizacion</h5>
            <div class="card-header-right">
                <i class="icofont icofont-spinner-alt-5"></i>
            </div>
            <div class="card-header-right">
                <i class="icofont icofont-spinner-alt-5"></i>
            </div>
        </div>
        <div class="card-block">
            <h4 class="sub-title">Informacion requerida</h4>
            <form method="POST" action="{{ route('panel.roles.update', ['role' => $role->id]) }}" name="form-role-edit" id="form-role-edit">
                @csrf
                @method('PUT')

                <div class="form-group row">
                    <div class="col-sm-12">
                        <label class="col-form-label">Nombre</label>
                        <input type="text" name="name" id="name" value="{{ $role->name }}" class="form-control">
                        <div class="col-form-label has-danger-name"></div>
                    </div>
                    <div class="col-sm-12">
                        <label class="col-form-label">Descripcion</label>
                        <textarea name="description" id="description" cols="5" rows="5" class="form-control"> {{ $role->description }} </textarea>
                        <div class="col-form-label has-danger-description"></div>
                        <div class="alert alert-warning" role="alert"><b>Permisos en el sistema del role ({{ $role->name }})</b></div>
                        <div class="alert alert-danger has-danger-syncPermissions" role="alert"></div>
                    </div>

                    @foreach ($permissions as $key => $item)
                        <div class="col-md-4">
                            <div class="checkbox-fade fade-in-warning">
                                <label style="font-size: 14px !important;">
                                    <input type="checkbox" name="syncPermissions[]" value="{{  $item->id }}" {{ (in_array($item->id , old('syncPermissions', $syncPermissions))) ? ' checked' : '' }}>
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
                <div class="col-md-12 text-right">
                    <a href="{{route('panel.roles.index')}}" type="submit" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="cancelar"><i class="ti-back-left"></i></a>
                    {{-- <button type="reset" class="btn btn-inverse" data-toggle="tooltip" data-placement="top" title="Limpiar"><i class="ti-reload"></i></button> --}}
                    <button type="submit" class="btn btn-warning  btn-role">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Basic Form Inputs card end -->
@endsection

@section('script-content')
<script src="{{ asset('assets/js/jimbo/roles.js') }}"></script>
@endsection
