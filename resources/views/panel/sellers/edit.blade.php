@extends('layouts.app', ['title' => $title ?? 'Vendedores'])

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
            <form method="POST" action="{{ route('panel.sellers.update', ['seller' => $seller->id]) }}" name="form-seller-edit" id="form-seller-edit" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group row">
                    <div class="col-sm-12">
                        <img src="{{ $seller->image != 'avatar.svg' ? asset('assets/images/sellers/'.$seller->image): asset('assets/images/avatar.svg') }}" style= "margin: 0px 0 5px 0;" width="100px" height="100px" alt="avatar" id="avatar" class="img-radius">

                        <br>
                        <label for="exampleFormControlFile1"><b>Imagen <i class="ti ti-info-alt" data-toggle="tooltip" data-placement="top" title="El formato de imagen debe ser (jpg, jpeg, png o svg). El peso maximo de la imagen es de 512 KB"></i></b></label>
                        <input type="file" name="image" id="image" file="true" class="form-control-file" id="exampleFormControlFile1">
                        <div class="col-form-label has-danger-image"></div>
                    </div>
                    <div class="col-sm-6">
                        <label class="col-form-label">Nombres</label>
                        <input type="text" name="names" id="names" value="{{ $seller->names }}" class="form-control">
                        <div class="col-form-label has-danger-names"></div>
                    </div>
                    <div class="col-sm-6">
                        <label class="col-form-label">Apellidos</label>
                        <input type="text" name="surnames" id="surnames" value="{{ $seller->surnames }}" class="form-control">
                        <div class="col-form-label has-danger-surnames"></div>
                    </div>
                    <div class="col-sm-6">
                        <label class="col-form-label">Email</label>
                        <input type="text" name="email" id="email" value="{{ $seller->email }}" class="form-control">
                        <div class="col-form-label has-danger-email"></div>
                    </div>

                    <div class="col-sm-6">
                        <label class="col-form-label">DNI</label>
                        <input type="text" name="dni" id="dni" value="{{ $seller->dni }}" class="form-control">
                        <div class="col-form-label has-danger-dni"></div>
                    </div>

                    <div class="col-sm-6">
                        <label class="col-form-label">Ciudad</label>
                        <textarea name="address_city" id="address_city" class="form-control" cols="10" rows="5">{{ $seller->address_city }}</textarea>
                        <div class="col-form-label has-danger-address_city"></div>
                    </div>

                    <div class="col-sm-6">
                        <label class="col-form-label">Direccion</label>
                        <textarea name="address" id="address" class="form-control" cols="10" rows="5">{{ $seller->address }}</textarea>
                        <div class="col-form-label has-danger-address"></div>
                    </div>

                    <div class="col-sm-6">
                        <label class="col-form-label">Telefono</label>
                        <input type="text" name="phone" id="phone" value="{{ $seller->phone }}" class="form-control">
                        <div class="col-form-label has-danger-phone"></div>
                    </div>

                   {{--  <div class="col-sm-6">
                        <label class="col-form-label">Balance Jib</label>
                        <input type="text" name="balance_jib" id="balance_jib" value="{{ $seller->balance_jib }}" class="form-control">
                        <div class="col-form-label has-danger-balance_jib"></div>
                    </div> --}}


                    <div class="col-sm-6">
                        <label class="col-form-label">Role</label>
                        <select name="role" id="role" class="form-control">
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}" {{ in_array($role->id, $sellerRole) ? 'selected' : '' }}>{{ $role->name }}</option>
                            @endforeach
                        </select>
                        <div class="col-form-label has-danger-role"></div>
                    </div>

                    <div class="col-sm-6">
                        <label class="col-form-label">Pais</label>
                        <select name="country_id" id="country_id" class="form-control">
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}" {{ $country->id == $seller->country_id ? 'selected' : '' }}>{{ $country->name }}</option>
                            @endforeach
                        </select>
                        <div class="col-form-label has-danger-country_id"></div>
                    </div>

                    <div class="col-sm-6">
                        <label class="col-form-label">Estatus</label>
                        <select name="active" id="active" class="form-control">
                            <option value="1" @if ($seller->active === 1) selected @endif>Activo</option>
                            <option value="0" @if ($seller->active === 0) selected @endif>Inactivo</option>
                        </select>
                        <div class="col-form-label has-danger-active"></div>
                    </div>
                    <div class="col-sm-6">
                        <label class="col-form-label">Contrase&ntilde;a</label>
                        <input type="password" name="password" id="password" class="form-control">
                        <div class="col-form-label has-danger-password"></div>
                    </div>
                    <div class="col-sm-6">
                        <label class="col-form-label">Confirmar Contrase&ntilde;a</label>
                        <input type="password" name="cpassword" id="cpassword" class="form-control">
                        <div class="col-form-label has-danger-cpassword"></div>
                    </div>
                </div>
                <div class="col-md-12 text-right">
                    <a href="{{route('panel.sellers.index')}}" type="submit" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="cancelar"><i class="ti-back-left"></i></a>
                    {{-- <button type="reset" class="btn btn-inverse" data-toggle="tooltip" data-placement="top" title="Limpiar"><i class="ti-reload"></i></button> --}}
                    <button type="submit" class="btn btn-warning  btn-seller">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Basic Form Inputs card end -->
@endsection

@section('script-content')
<script src="{{ asset('assets/js/jimbo/sellers.js') }}"></script>
@endsection
