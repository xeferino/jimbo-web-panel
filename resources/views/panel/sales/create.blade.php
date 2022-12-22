@extends('layouts.app', ['title' => $title ?? 'Ventas'])

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
            <form method="POST" action="{{ route('panel.sales.store') }}" name="form-sale-create" id="form-sale-create" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label class="col-form-label">Nombres y Apellidos</label>
                        <input type="text" name="fullnames" id="fullnames" class="form-control">
                        <div class="col-form-label has-danger-fullnames"></div>
                    </div>
                    <div class="col-sm-6">
                        <label class="col-form-label">Email</label>
                        <input type="text" name="email" id="email" class="form-control">
                        <div class="col-form-label has-danger-email"></div>
                    </div>
                    <div class="col-sm-6">
                        <label class="col-form-label">DNI</label>
                        <input type="text" name="dni" id="dni" class="form-control">
                        <div class="col-form-label has-danger-dni"></div>
                    </div>
                    <div class="col-sm-6">
                        <label class="col-form-label">Telefono</label>
                        <input type="text" name="phone" id="phone" class="form-control">
                        <div class="col-form-label has-danger-phone"></div>
                    </div>
                    <div class="col-sm-6">
                        <label class="col-form-label">Estatus</label>
                        <select name="status" id="status" class="form-control">
                            <option value="">.::Seleccione::.</option>
                            <option value="pending">Pendiente</option>
                            <option value="approved">Aprobada</option>
                            <option value="refused">Rechazada</option>
                        </select>
                        <div class="col-form-label has-danger-status"></div>
                    </div>
                    <div class="col-sm-6">
                        <label class="col-form-label">Pais</label>
                        <select name="country_id" id="country_id" class="form-control">
                            <option value="">.::Seleccione::.</option>
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                        <div class="col-form-label has-danger-country_id"></div>
                    </div>
                    <div class="col-sm-12">
                        <label class="col-form-label">Direccion</label>
                        <textarea name="address" id="address" class="form-control" cols="10" rows="5"></textarea>
                        <div class="col-form-label has-danger-address"></div>
                    </div>
                    <div class="col-sm-12 mt-4">
                        <div class="alert alert-warning" role="alert"><b>Configuracion del sorteo y promocion de boleteria a vender</b></div>
                    </div>
                    <div class="col-sm-6">
                        <label class="col-form-label">Sorteos disponibles</label>
                        <select name="raffle_id" id="raffle_id" class="form-control">
                            <option value="">.::Seleccione::.</option>
                            @foreach ($raffles as $key => $item)
                            <option value="{{$item->id}}">{{$item->title}}</option>
                            @endforeach
                        </select>
                        <div class="col-form-label has-danger-raffle_id"></div>
                    </div>
                    <div class="col-sm-6">
                        <label class="col-form-label">Promociones de boletos</label>
                        <select name="ticket_id" id="ticket_id" class="form-control">
                            <option value="">.::Seleccione::.</option>
                        </select>
                        <div class="col-form-label has-danger-ticket_id"></div>
                    </div>
                </div>
                <div class="col-md-12 text-right">
                    <a href="{{route('panel.sales.index')}}" type="submit" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="cancelar"><i class="ti-back-left"></i></a>
                    {{-- <button type="reset" class="btn btn-inverse" data-toggle="tooltip" data-placement="top" title="Limpiar"><i class="ti-reload"></i></button> --}}
                    <button type="submit" class="btn btn-warning  btn-sale">Registrar</button>
                </div>

            </form>
        </div>
    </div>
    <!-- Basic Form Inputs card end -->
@endsection

@section('script-content')
<script src="{{ asset('assets/js/jimbo/sales.js') }}"></script>
@endsection
