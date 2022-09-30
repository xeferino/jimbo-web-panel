@extends('layouts.app', ['title' => $title ?? 'Promociones'])

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
            <form method="POST" action="{{ route('panel.promotions.update', ['promotion' => $promotion->id]) }}" name="form-promotion-edit" id="form-promotion-edit" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label class="col-form-label">Nombre</label>
                        <input type="text" name="name" id="name" value="{{ $promotion->name }}" class="form-control">
                        <div class="col-form-label has-danger-name"></div>
                    </div>
                    <div class="col-sm-6">
                        <label class="col-form-label">Codigo</label>
                        <input type="text" name="code" id="code" value="{{ $promotion->code }}" class="form-control">
                        <div class="col-form-label has-danger-code"></div>
                    </div>

                    <div class="col-sm-6">
                        <label class="col-form-label">Precio</label>
                        <input type="text" name="price" id="price" value="{{ $promotion->price }}" class="form-control">
                        <div class="col-form-label has-danger-price"></div>
                    </div>

                    <div class="col-sm-6">
                        <label class="col-form-label">Estatus</label>
                        <select name="active" id="active" class="form-control">
                            <option value="1" @if ($promotion->active === 1) selected @endif>Activo</option>
                            <option value="0" @if ($promotion->active === 0) selected @endif>Inactivo</option>
                        </select>
                        <div class="col-form-label has-danger-active"></div>
                    </div>
                </div>
                <div class="col-md-12 text-right">
                    <a href="{{route('panel.promotions.index')}}" type="submit" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="cancelar"><i class="ti-back-left"></i></a>
                    {{-- <button type="reset" class="btn btn-inverse" data-toggle="tooltip" data-placement="top" title="Limpiar"><i class="ti-reload"></i></button> --}}
                    <button type="submit" class="btn btn-warning  btn-promotion">Actualizar</button>
                </div>

            </form>
        </div>
    </div>
    <!-- Basic Form Inputs card end -->
@endsection

@section('script-content')
<script src="{{ asset('assets/js/jimbo/promotions.js') }}"></script>
@endsection
