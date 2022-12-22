@extends('layouts.app', ['title' => $title ?? 'Ventas'])

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
            <input type="hidden" name="ticket" id="ticket" value="{{$sale->ticket_id}}">
            <form method="POST" action="{{ route('panel.sales.update', ['sale' => $sale->id]) }}" name="form-sale-edit" id="form-sale-edit" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="type" id="type" value="edit">
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label class="col-form-label">Nombres y Apellidos</label>
                        <input type="text" name="fullnames" id="fullnames" value="{{$sale->name}}" class="form-control">
                        <div class="col-form-label has-danger-fullnames"></div>
                    </div>
                    <div class="col-sm-6">
                        <label class="col-form-label">Email</label>
                        <input type="text" name="email" id="email" value="{{$sale->email}}" class="form-control">
                        <div class="col-form-label has-danger-email"></div>
                    </div>
                    <div class="col-sm-6">
                        <label class="col-form-label">DNI</label>
                        <input type="text" name="dni" id="dni" value="{{$sale->dni}}" class="form-control">
                        <div class="col-form-label has-danger-dni"></div>
                    </div>
                    <div class="col-sm-6">
                        <label class="col-form-label">Telefono</label>
                        <input type="text" name="phone" id="phone" value="{{$sale->phone}}" class="form-control">
                        <div class="col-form-label has-danger-phone"></div>
                    </div>
                    <div class="col-sm-6">
                        <label class="col-form-label">Estatus</label>
                        <select name="status" id="status" class="form-control">
                            <option value="pending" {{$sale->status == 'pending' ? 'selected' : ''}} >Pendiente</option>
                            <option value="approved" {{$sale->status == 'approved' ? 'selected' : ''}}>Aprobada</option>
                            <option value="refused" {{$sale->status == 'refused' ? 'selected' : ''}}>Rechazada</option>
                        </select>
                        <div class="col-form-label has-danger-status"></div>
                    </div>
                    <div class="col-sm-6">
                        <label class="col-form-label">Pais</label>
                        <select name="country_id" id="country_id" class="form-control">
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}" {{$sale->country_id == $country->id ? 'selected' : ''}}>{{ $country->name }}</option>
                            @endforeach
                        </select>
                        <div class="col-form-label has-danger-country_id"></div>
                    </div>
                    <div class="col-sm-12">
                        <label class="col-form-label">Direccion</label>
                        <textarea name="address" id="address" class="form-control" cols="10" rows="5">{{$sale->address}}</textarea>
                        <div class="col-form-label has-danger-address"></div>
                    </div>
                    <div class="col-sm-12 mt-4">
                        <div class="alert alert-warning" role="alert"><b>Configuracion del sorteo y promocion de boleteria a vender</b></div>
                    </div>
                    <div class="col-sm-6">
                        <label class="col-form-label">Sorteos disponibles</label>
                        <select name="raffle_id" id="raffle_id" class="form-control" readonly>
                            @foreach ($raffles as $key => $item)
                                <option value="{{$item->id}}" {{$sale->raffle_id == $item->id ? 'selected' : ''}}>{{$item->title}}</option>
                            @endforeach
                        </select>
                        <div class="col-form-label has-danger-raffle_id"></div>
                    </div>
                    <div class="col-sm-6">
                        <label class="col-form-label">Promociones de boletos</label>
                        <select name="ticket_id" id="ticket_id" class="form-control" readonly>
                        </select>
                        <div class="col-form-label has-danger-ticket_id"></div>
                    </div>
                </div>
                <div class="col-md-12 text-right">
                    <a href="{{route('panel.sales.index')}}" type="submit" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="cancelar"><i class="ti-back-left"></i></a>
                    {{-- <button type="reset" class="btn btn-inverse" data-toggle="tooltip" data-placement="top" title="Limpiar"><i class="ti-reload"></i></button> --}}
                    <button type="submit" class="btn btn-warning  btn-sale">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Basic Form Inputs card end -->
@endsection

@section('script-content')
<script>
    $("#ticket_id").prop("disabled", true);
    $("#raffle_id").prop("disabled", true);
</script>
<script src="{{ asset('assets/js/jimbo/sales.js') }}"></script>
@endsection
