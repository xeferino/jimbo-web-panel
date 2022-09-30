@extends('layouts.app', ['title' => $title ?? 'Sliders'])

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
            <form method="POST" action="{{ route('panel.sliders.update', ['slider' => $slider->id]) }}" name="form-slider-edit" id="form-slider-edit" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group row">
                    <div class="col-sm-12">
                        <img src="{{ $slider->image != 'slider.png' ? asset('assets/images/sliders/'.$slider->image): asset('assets/images/sliders/slider.png') }}" style= "margin: 0px 0 5px 0;" width="50px" height="50px" alt="slider" id="avatar">
                        <br>
                        <label for="exampleFormControlFile1"><b>Imagen <i class="ti ti-info-alt" data-toggle="tooltip" data-placement="top" title="El formato de imagen debe ser (jpg, jpeg, png o svg) con unas dimensiones de 20x20. El peso maximo de la imagen es de 512 KB"></i></b></label>
                        <input type="file" name="image" id="image" file="true" class="form-control-file" id="exampleFormControlFile1">
                        <div class="col-form-label has-danger-image"></div>
                    </div>
                    <div class="col-sm-6">
                        <label class="col-form-label">Nombre</label>
                        <input type="text" name="name" id="name" value="{{ $slider->name }}" class="form-control">
                        <div class="col-form-label has-danger-name"></div>
                    </div>

                    <div class="col-sm-6">
                        <label class="col-form-label">Estatus</label>
                        <select name="active" id="active" class="form-control">
                            <option value="1" @if ($slider->active === 1) selected @endif>Activo</option>
                            <option value="0" @if ($slider->active === 0) selected @endif>Inactivo</option>
                        </select>
                        <div class="col-form-label has-danger-active"></div>
                    </div>

                </div>
                <div class="col-md-12 text-right">
                    <a href="{{route('panel.sliders.index')}}" type="submit" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="cancelar"><i class="ti-back-left"></i></a>
                    {{-- <button type="reset" class="btn btn-inverse" data-toggle="tooltip" data-placement="top" title="Limpiar"><i class="ti-reload"></i></button> --}}
                    <button type="submit" class="btn btn-warning  btn-slider">Actualizar</button>
                </div>

            </form>
        </div>
    </div>
    <!-- Basic Form Inputs card end -->
@endsection

@section('script-content')
<script src="{{ asset('assets/js/jimbo/sliders.js') }}"></script>
@endsection
