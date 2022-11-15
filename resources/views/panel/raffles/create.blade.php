@extends('layouts.app', ['title' => $title ?? 'Sorteos'])

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
            <form method="POST" action="{{ route('panel.raffles.store') }}" name="form-raffle-create" id="form-raffle-create">
                @csrf
                <input type="hidden" name="promotions_raffle" id="promotions_raffle">
                <input type="hidden" name="total" id="total">

                <div class="form-group row">
                    <div class="col-sm-12">
                        <img src="{{asset('assets/images/raffles/raffle.jpg')}}" style= "margin: 0px 0 5px 0;" alt="Sorteo" id="raffle">
                        <br>
                        <label for="exampleFormControlFile1"><b>Imagen <i class="ti ti-info-alt" data-toggle="tooltip" data-placement="top" title="El formato de imagen debe ser (jpg, jpeg, png o svg) con unas dimensiones de 400x200 El peso maximo de la imagen es de 512 KB"></i></b></label>
                        <input type="file" name="image" id="image" file="true" class="form-control-file" id="exampleFormControlFile1">
                        <div class="col-form-label has-danger-image"></div>
                    </div>
                    <div class="col-sm-6">
                        <label class="col-form-label">Nombre</label>
                        <input type="text" name="title" id="title" class="form-control">
                        <div class="col-form-label has-danger-title"></div>
                    </div>
                    <div class="col-sm-6">
                        <label class="col-form-label">Marca</label>
                        <input type="text" name="brand" id="brand" class="form-control">
                        <div class="col-form-label has-danger-brand"></div>
                    </div>

                    <div class="col-sm-12">
                        <label class="col-form-label">Descripcion</label>
                        <textarea name="description" id="description" class="form-control" cols="10" rows="5"></textarea>
                        <div class="col-form-label has-danger-description"></div>
                    </div>

                    <div class="col-sm-4">
                        <label class="col-form-label">Promotor</label>
                        <input type="text" name="promoter" id="promoter" class="form-control">
                        <div class="col-form-label has-danger-promoter"></div>
                    </div>

                    <div class="col-sm-4">
                        <label class="col-form-label">Proveedor</label>
                        <input type="text" name="provider" id="provider" class="form-control">
                        <div class="col-form-label has-danger-provider"></div>
                    </div>

                    <div class="col-sm-4">
                        <label class="col-form-label">Localidad</label>
                        <input type="text" name="place" id="place" class="form-control">
                        <div class="col-form-label has-danger-place"></div>
                    </div>

                    <div class="col-sm-6">
                        <label class="col-form-label">Fecha de apertura</label>
                        <div class="input-group">
                            <input type="text" name="date_start" id="date_start" class="form-control datepicker">
                            <span class="input-group-addon" id="date_start"><i class="icofont icofont-calendar"></i></span>
                        </div>
                        <div class="col-form-label has-danger-date_start"></div>
                    </div>

                    <div class="col-sm-6">
                        <label class="col-form-label">Fecha de cierre</label>
                        <div class="input-group">
                            <input type="text" name="date_end" id="date_end" class="form-control datepicker">
                            <span class="input-group-addon" id="date_end"><i class="icofont icofont-calendar"></i></span>
                        </div>
                        <div class="col-form-label has-danger-date_end"></div>
                    </div>

                    <div class="col-sm-6">
                        <label class="col-form-label">Fecha de sorteo</label>
                        <div class="input-group">
                            <input type="text" name="date_release" id="date_release" class="form-control datepicker">
                            <span class="input-group-addon" id="date_release"><i class="icofont icofont-calendar"></i></span>
                        </div>
                        <div class="col-form-label has-danger-date_release"></div>
                    </div>

                    <div class="col-sm-6">
                        <label class="col-form-label">Premio en Efectivo</label>
                        <div class="input-group">
                            <input type="text" min="1" name="cash_to_draw" id="cash_to_draw" class="form-control">
                            <span class="input-group-addon" id="cash_to_draw"><i class="icofont icofont-bill-alt"></i></span>
                        </div>
                        <div class="col-form-label has-danger-cash_to_draw"></div>
                    </div>

                    <div class="col-sm-6">
                        <label class="col-form-label">Dinero a recolectar</label>
                        <div class="input-group">
                            <input type="text" min="1" name="cash_to_collect" id="cash_to_collect" class="form-control">
                            <span class="input-group-addon" id="cash_to_collect"><i class="icofont icofont-bill-alt"></i></span>
                        </div>
                        <div class="col-form-label has-danger-cash_to_collect"></div>
                    </div>

                    <div class="col-sm-6">
                        <label class="col-form-label">Tipo de sorteo</label>
                        <select name="type" id="type" class="form-control">
                            <option value="">.::Seleccione::.</option>
                            <option value="raffle">Efectivo</option>
                            <option value="product">Producto</option>
                        </select>
                        <div class="col-form-label has-danger-type"></div>
                    </div>

                    <div class="col-sm-6">
                        <label class="col-form-label">Visibilidad</label>
                        <select name="public" id="public" class="form-control">
                            <option value="">.::Seleccione::.</option>
                            <option value="1">Publico</option>
                            <option value="0">Borrador</option>
                        </select>
                        <div class="col-form-label has-danger-public"></div>
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
                    <div class="col-sm-12 mt-4">
                        <div class="alert alert-warning" role="alert"><b>Porcentaje de premios en el sorteo</b></div>
                    </div>

                    <div class="col-sm-3">
                        <label class="col-form-label">1° (%)</label>
                        <input type="text" name="prize_1" id="prize_1" value="100" min="100" max="100" class="form-control">
                        <div class="col-form-label has-danger-prize_1"></div>
                    </div>

                    <div class="col-sm-3">
                        <label class="col-form-label">2° (%)</label>
                        <input type="text" name="prize_2" id="prize_2" value="20" min="1" max="100" class="form-control">
                        <div class="col-form-label has-danger-prize_2"></div>
                    </div>

                    <div class="col-sm-3">
                        <label class="col-form-label">3° (%)</label>
                        <input type="text" name="prize_3" id="prize_3" value="0.6" min="0.6" max="100" class="form-control">
                        <div class="col-form-label has-danger-prize_3"></div>
                    </div>

                    <div class="col-sm-3">
                        <label class="col-form-label">4° (%)</label>
                        <input type="text" name="prize_4" id="prize_4" value="0.6" min="0.6" max="100" class="form-control">
                        <div class="col-form-label has-danger-prize_4"></div>
                    </div>

                    <div class="col-sm-2">
                        <label class="col-form-label">5° (%)</label>
                        <input type="text" name="prize_5" id="prize_5" value="0.6" min="0.6" max="100" class="form-control">
                        <div class="col-form-label has-danger-prize_5"></div>
                    </div>

                    <div class="col-sm-2">
                        <label class="col-form-label">6° (%)</label>
                        <input type="text" name="prize_6" id="prize_6" value="0.6" min="0.6" max="100" class="form-control">
                        <div class="col-form-label has-danger-prize_6"></div>
                    </div>

                    <div class="col-sm-2">
                        <label class="col-form-label">7° (%)</label>
                        <input type="text" name="prize_7" id="prize_7" value="0.6" min="0.6" max="100" class="form-control">
                        <div class="col-form-label has-danger-prize_7"></div>
                    </div>

                    <div class="col-sm-2">
                        <label class="col-form-label">8° (%)</label>
                        <input type="text" name="prize_8" id="prize_8" value="0.6" min="0.6" max="100" class="form-control">
                        <div class="col-form-label has-danger-prize_8"></div>
                    </div>

                    <div class="col-sm-2">
                        <label class="col-form-label">9° (%)</label>
                        <input type="text" name="prize_9" id="prize_9" value="0.6" min="0.6" max="100" class="form-control">
                        <div class="col-form-label has-danger-prize_9"></div>
                    </div>

                    <div class="col-sm-2">
                        <label class="col-form-label">10° (%)</label>
                        <input type="text" name="prize_10" id="prize_10" value="0.6" min="0.6" max="100" class="form-control">
                        <div class="col-form-label has-danger-prize_10"></div>
                    </div>

                    <div class="col-sm-12 mt-4">
                        <div class="alert alert-warning" role="alert"><b>Promociones de boletos del sorteo</b></div>
                    </div>

                    <div class="col-sm-8">
                        <label class="col-form-label">Promociones</label>
                        <select name="promotions" id="promotions" class="form-control">
                            <option value="">.::Seleccione::.</option>
                            @foreach ($promotions as $key => $item)
                            <option value="{{$item->id.'-'.$item->quantity.'-'.$item->price.'-'.$item->code}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                        <div class="col-form-label has-danger-promotions"></div>
                    </div>

                    <div class="col-sm-2">
                        <label class="col-form-label">Cantidad de Boletos</label>
                        <input type="text" name="quantity" id="quantity" value="1" min="1" class="form-control">
                        <div class="col-form-label has-danger-quantity"></div>
                    </div>

                    <div class="col-sm-2 mt-3">
                        <br>
                        <a href="javascript:void(0)" class="btn btn-warning btn-sm add-promotion" data-toggle="tooltip" data-placement="top" title="Agregar promocion de boletos"><i class="ti-plus"></i> Agregar Promocion</a>
                    </div>

                    <div class="col-sm-12">
                        {{-- <div class="col-form-label has-danger-promotions_raffle text-center"></div> --}}
                        <div class="col-form-label has-danger-total  text-center"></div>
                        <div class="add-input-content"></div>
                    </div>
                </div>
                <div class="col-md-12 text-right">
                    <a href="{{route('panel.raffles.index')}}" type="submit" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="cancelar"><i class="ti-back-left"></i></a>
                    {{-- <button type="reset" class="btn btn-inverse" data-toggle="tooltip" data-placement="top" title="Limpiar"><i class="ti-reload"></i></button> --}}
                    <button type="submit" class="btn btn-warning  btn-raffle">Registrar</button>
                </div>

            </form>
        </div>
    </div>
    <!-- Basic Form Inputs card end -->
@endsection

@section('script-content')
<script src="{{ asset('assets/js/jimbo/raffles.js') }}"></script>
@endsection
