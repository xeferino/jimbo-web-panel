@extends('layouts.app', ['title' => $title ?? 'Paises'])

@section('page-content')
    <!-- Basic Form Inputs card start -->
    <div class="card">
        <div class="card-header">
            <h5>Fomulario de registro</h5>
            <div class="card-header-right">
                <i class="icofont icofont-spinner-alt-5"></i>
            </div>
            <div class="card-header-right">
                <i class="icofont icofont-spinner-alt-5"></i>
            </div>
        </div>
        <div class="card-block">
            <h4 class="sub-title">Informacion requerida</h4>
            <form method="POST" action="{{ route('panel.countries.store') }}" name="form-country-create" id="form-country-create" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <div class="col-sm-12">
                        <img src="{{asset('assets/images/flags/flag.png')}}" style= "margin: 0px 0 5px 0;" width="50px" height="50px" alt="avatar" id="avatar" class="img-radius">
                        <br>
                        <label for="exampleFormControlFile1"><b>Imagen <i class="ti ti-info-alt" data-toggle="tooltip" data-placement="top" title="El formato de imagen debe ser (jpg, jpeg, png o svg) con unas dimensiones de 20x20. El peso maximo de la imagen es de 512 KB"></i></b></label>
                        <input type="file" name="img" id="image" file="true" class="form-control-file" id="exampleFormControlFile1">
                        <div class="col-form-label has-danger-img"></div>
                    </div>
                    <div class="col-sm-6">
                        <label class="col-form-label">Nombre</label>
                        <input type="text" name="name" id="name" class="form-control">
                        <div class="col-form-label has-danger-name"></div>
                    </div>
                    <div class="col-sm-6">
                        <label class="col-form-label">Codigo</label>
                        <input type="text" name="code" id="code" class="form-control">
                        <div class="col-form-label has-danger-code"></div>
                    </div>

                    <div class="col-sm-6">
                        <label class="col-form-label">Iso</label>
                        <input type="text" name="iso" id="iso" class="form-control">
                        <div class="col-form-label has-danger-iso"></div>
                    </div>

                    <div class="col-sm-6">
                        <label class="col-form-label">Moneda</label>
                        <input type="text" name="currency" id="currency" class="form-control">
                        <div class="col-form-label has-danger-currency"></div>
                    </div>

                    <div class="col-sm-6">
                        <label class="col-form-label">Tasa de Cambio</label>
                        <input type="text" name="exchange_rate" id="exchange_rate" class="form-control">
                        <div class="col-form-label has-danger-exchange_rate"></div>
                    </div>

                    <div class="col-sm-6">
                        <label class="col-form-label">Estatus</label>
                        <select name="active" id="active" class="form-control">
                            <option value="">.::Seleccione::.</option>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                        <div class="col-form-label has-danger-active"></div>
                    </div>

                </div>
                <div class="col-md-12 text-right">
                    <a href="{{route('panel.countries.index')}}" type="submit" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="cancelar"><i class="ti-back-left"></i></a>
                    {{-- <button type="reset" class="btn btn-inverse" data-toggle="tooltip" data-placement="top" title="Limpiar"><i class="ti-reload"></i></button> --}}
                    <button type="submit" class="btn btn-warning  btn-country">Registrar</button>
                </div>

            </form>
        </div>
    </div>
    <!-- Basic Form Inputs card end -->
@endsection

@section('script-content')
<script src="{{ asset('assets/js/jimbo/countries.js') }}"></script>
@endsection
