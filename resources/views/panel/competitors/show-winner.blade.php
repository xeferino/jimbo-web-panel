@extends('layouts.app', ['title' => $title ?? 'Participantes'])

@section('page-content')
    <!-- Basic card start -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card fb-card">
                <div class="card-header">
                    <i class="ti-money"></i>
                    <div class="d-inline-block">
                        <h5>Datos del premio</h5>
                        <span>Detalles</span>
                    </div>
                </div>
                <div class="card-block text-center">
                    <div class="row">
                        <div class="col-sm-3 b-r-default">
                            <h4>{{Helper::amount($competitor->amount)}}</h4>
                            <p class="text-muted">Monto</p>
                        </div>
                        <div class="col-sm-3 b-r-default">
                            <h4>{{$competitor->Raffle->title}}</h4>
                            <p class="text-muted">Sorteo</p>
                        </div>
                        <div class="col-sm-3 b-r-default">
                            <h4>{{$competitor->Raffle->date_release->format('d/m/Y H:i:s')}}</h4>
                            <p class="text-muted">Fecha del sorteo</p>
                        </div>
                        <div class="col-sm-3">
                            <h4>{{$competitor->TicketWinner->serial}}</h4>
                            <p class="text-muted">Boleto Ganador</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="card fb-card">
                <div class="card-header">
                    <i class="ti-user"></i>
                    <div class="d-inline-block">
                        <h5>Datos del ganador</h5>
                        <span>Detalles</span>
                    </div>
                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$competitor->name}}</strong>
                            <p class="text-muted">Nombres y Apellidos</p>
                        </div>
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$competitor->dni}}</strong>
                            <p class="text-muted">Dni</p>
                        </div>
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$competitor->email}}</strong>
                            <p class="text-muted">Email</p>
                        </div>
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$competitor->phone}}</strong>
                            <p class="text-muted">Telefono</p>
                        </div>
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$competitor->country->name}}</strong>
                            <p class="text-muted">Pais</p>
                        </div>
                        <div class="col-sm-4">
                            <strong class="text-uppercase">{{$competitor->address}}</strong>
                            <p class="text-muted">Direcion</p>
                        </div>
                        @if (empty($competitor->user_id))
                          <div class="col-sm-12">
                            <strong class="text-uppercase">Observacion</strong>
                            <p class="text-danger">Este usuario ganador no esta registrado en la plataforma</p>
                          </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Basic card end -->
@endsection

@section('script-content')
<script src="{{ asset('assets/js/jimbo/competitors.js') }}"></script>
@endsection
