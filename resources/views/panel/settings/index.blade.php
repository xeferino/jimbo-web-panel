@extends('layouts.app', ['title' => $title ?? 'Configuraciones'])

@section('page-content')
<div class="row">
    <div class="col-sm-6">
        <div class="card fb-card">
            <div class="card-header">
                <i class="ti-money"></i>
                <div class="d-inline-block">
                    <h5>Jibs</h5>
                    <span>Equivalencia en USD</span>
                </div>
            </div>
            <div class="card-block">
                <form method="POST" class="form-setting" action="{{ route('panel.settings.update') }}" name="form-setting" id="form-setting">
                    @csrf
                    <input type="hidden" name="type" value="jib">
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label class="col-form-label">Jib en USD</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="jib_usd" name="jib_usd" value="{{$settings['jib_usd']}}" placeholder="0.10">
                                <span class="input-group-addon">$</span>
                            </div>
                            <div class="col-form-label has-danger-jib_usd"></div>
                        </div>
                    </div>
                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-warning btn-sm  btn-setting-jib">Configurar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="card fb-card">
            <div class="card-header">
                <i class="ti-money"></i>
                <div class="d-inline-block">
                    <h5>Jibs</h5>
                    <span>Bonos y Recompenzas</span>
                </div>
            </div>
            <div class="card-block">
                <form method="POST" class="form-setting" action="{{ route('panel.settings.update') }}" name="form-setting" id="form-setting">
                    @csrf
                    <input type="hidden" name="type" value="bonus">
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label class="col-form-label">Jib al registrarse</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="register" name="register" value="{{$settings['register']}}" placeholder="1">
                                <span class="input-group-addon">#</span>
                            </div>
                            <div class="col-form-label has-danger-register"></div>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Jib al acceder al App</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="to_access" name="to_access" value="{{$settings['to_access']}}" placeholder="1">
                                <span class="input-group-addon">#</span>
                            </div>
                            <div class="col-form-label has-danger-to_access"></div>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Jib referidos</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="referrals" name="referrals" value="{{$settings['referrals']}}" placeholder="1">
                                <span class="input-group-addon">#</span>
                            </div>
                            <div class="col-form-label has-danger-referrals"></div>
                        </div>

                        <div class="col-sm-12 text-right">
                            <button type="submit" class="btn btn-warning btn-sm btn-setting-bonu">Configurar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="card fb-card">
            <div class="card-header">
                <i class="ti-money"></i>
                <div class="d-inline-block">
                    <h5>Vendedores Individuales</h5>
                    <span>Bonos y Recompenzas en USD (Metas)</span>
                </div>
            </div>
            <div class="card-block">
                <form method="POST" class="form-setting" action="{{ route('panel.settings.update') }}" name="form-setting" id="form-setting">
                    @csrf
                    <input type="hidden" name="type" value="seller_single">
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label class="col-form-label">Vendedor junior</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="level_single_junior" name="level_single_junior" value="{{$settings['level_single_junior']}}" placeholder="1">
                                <span class="input-group-addon">$</span>
                            </div>
                            <div class="col-form-label has-danger-level_single_junior"></div>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Vendedor semi se&ntilde;or</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="level_single_middle" name="level_single_middle" value="{{$settings['level_single_middle']}}" placeholder="1">
                                <span class="input-group-addon">$</span>
                            </div>
                            <div class="col-form-label has-danger-level_single_middle"></div>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">Vendedor se&ntilde;or</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="level_single_master" name="level_single_master" value="{{$settings['level_single_master']}}" placeholder="1">
                                <span class="input-group-addon">$</span>
                            </div>
                            <div class="col-form-label has-danger-level_single_master"></div>
                        </div>
                        <div class="col-sm-12 text-right">
                            <button type="submit" class="btn btn-warning btn-sm btn-setting-seller">Configurar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="card fb-card">
            <div class="card-header">
                <i class="ti-money"></i>
                <div class="d-inline-block">
                    <h5>Vendedores Individuales</h5>
                    <span>Bonos y Recompenzas Porcentajes (Metas)</span>
                </div>
            </div>
            <div class="card-block">
                <form method="POST" class="form-setting" action="{{ route('panel.settings.update') }}" name="form-setting" id="form-setting">
                    @csrf
                    <input type="hidden" name="type" value="seller_single_percent">
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label class="col-form-label">Vendedor junior</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="level_percent_single_junior" name="level_percent_single_junior" value="{{$settings['level_percent_single_junior']}}" placeholder="1">
                                <span class="input-group-addon">%</span>
                            </div>
                            <div class="col-form-label has-danger-level_percent_single_junior"></div>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Vendedor semi se&ntilde;or</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="level_percent_single_middle" name="level_percent_single_middle" value="{{$settings['level_percent_single_middle']}}" placeholder="1">
                                <span class="input-group-addon">%</span>
                            </div>
                            <div class="col-form-label has-danger-level_percent_single_middle"></div>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Vendedor se&ntilde;or</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="level_percent_single_master" name="level_percent_single_master" value="{{$settings['level_percent_single_master']}}" placeholder="1">
                                <span class="input-group-addon">%</span>
                            </div>
                            <div class="col-form-label has-danger-level_percent_single_master"></div>
                        </div>

                        <div class="col-sm-12 text-right">
                            <button type="submit" class="btn btn-warning btn-sm btn-setting-seller-percent">Configurar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="card fb-card">
            <div class="card-header">
                <i class="ti-money"></i>
                <div class="d-inline-block">
                    <h5>Vendedores Grupales</h5>
                    <span>Bonos y Recompenzas en USD (Metas)</span>
                </div>
            </div>
            <div class="card-block">
                <form method="POST" class="form-setting" action="{{ route('panel.settings.update') }}" name="form-setting" id="form-setting">
                    @csrf
                    <input type="hidden" name="type" value="seller_group">
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label class="col-form-label">Vendedor junior</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="level_group_junior" name="level_group_junior" value="{{$settings['level_group_junior']}}" placeholder="1">
                                <span class="input-group-addon">$</span>
                            </div>
                            <div class="col-form-label has-danger-level_group_junior"></div>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Vendedor semi se&ntilde;or</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="level_group_middle" name="level_group_middle" value="{{$settings['level_group_middle']}}" placeholder="1">
                                <span class="input-group-addon">$</span>
                            </div>
                            <div class="col-form-label has-danger-level_group_middle"></div>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Vendedor se&ntilde;or</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="level_group_master" name="level_group_master" value="{{$settings['level_group_master']}}" placeholder="1">
                                <span class="input-group-addon">$</span>
                            </div>
                            <div class="col-form-label has-danger-level_group_master"></div>
                        </div>

                        <div class="col-sm-12 text-right">
                            <button type="submit" class="btn btn-warning btn-sm btn-setting-seller-group">Configurar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="card fb-card">
            <div class="card-header">
                <i class="ti-money"></i>
                <div class="d-inline-block">
                    <h5>Vendedores Grupales</h5>
                    <span>Bonos y Recompenzas en porcentaje (Lideres - Porcentaje)</span>
                </div>
            </div>
            <div class="card-block">
                <form method="POST" class="form-setting" action="{{ route('panel.settings.update') }}" name="form-setting" id="form-setting">
                    @csrf
                    <input type="hidden" name="type" value="seller_group_percent">
                    <div class="form-group row">

                        <div class="col-sm-6">
                            <label class="col-form-label">Vendedor junior</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="level_percent_group_junior" name="level_percent_group_junior" value="{{$settings['level_percent_group_junior']}}" placeholder="1">
                                <span class="input-group-addon">%</span>
                            </div>
                            <div class="col-form-label has-danger-level_percent_group_junior"></div>
                        </div>


                        <div class="col-sm-6">
                            <label class="col-form-label">Vendedor semi se&ntilde;or</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="level_percent_group_middle" name="level_percent_group_middle" value="{{$settings['level_percent_group_middle']}}" placeholder="1">
                                <span class="input-group-addon">%</span>
                            </div>
                            <div class="col-form-label has-danger-level_percent_group_middle"></div>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Vendedor se&ntilde;or</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="level_percent_group_master" name="level_percent_group_master" value="{{$settings['level_percent_group_master']}}" placeholder="1">
                                <span class="input-group-addon">%</span>
                            </div>
                            <div class="col-form-label has-danger-level_percent_group_master"></div>
                        </div>
                        <div class="col-sm-12 text-right">
                            <button type="submit" class="btn btn-warning btn-sm btn-setting-seller-group">Configurar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="card fb-card">
            <div class="card-header">
                <i class="ti-money"></i>
                <div class="d-inline-block">
                    <h5>Nivel clasico</h5>
                    <span>Bonos y recompensas USD, Jibs, Porcentajes (Metas)</span>
                </div>
            </div>
            <div class="card-block">
                <form method="POST" class="form-setting" action="{{ route('panel.settings.update') }}" name="form-setting" id="form-setting">
                    @csrf
                    <input type="hidden" name="type" value="bonus_classic">
                    <div class="form-group row">

                        <div class="col-sm-6">
                            <label class="col-form-label">Bono unico de nivel</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="level_classic_ascent_unique_bonus" name="level_classic_ascent_unique_bonus" value="{{$settings['level_classic_ascent_unique_bonus']}}" placeholder="0.10">
                                <span class="input-group-addon">$</span>
                            </div>
                            <small class="text-danger">(9%+0.20%+mono) bono unico de nivel</small>
                            <div class="col-form-label has-danger-level_classic_ascent_unique_bonus"></div>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">Por convertirse en vendedor</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="level_classic_seller_percent" name="level_classic_seller_percent" value="{{$settings['level_classic_seller_percent']}}" placeholder="1">
                                <span class="input-group-addon">jib</span>
                            </div>
                            <div class="col-form-label has-danger-level_classic_seller_percent"></div>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Por referir a un vendedor</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="level_classic_referral_bonus" name="level_classic_referral_bonus" value="{{$settings['level_classic_referral_bonus']}}" placeholder="1">
                                <span class="input-group-addon">jib</span>
                            </div>
                            <div class="col-form-label has-danger-level_classic_referral_bonus"></div>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Por ventas netas</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="level_classic_sale_percent" name="level_classic_sale_percent" value="{{$settings['level_classic_sale_percent']}}" placeholder="1">
                                <span class="input-group-addon">%</span>
                            </div>
                            <div class="col-form-label has-danger-level_classic_sale_percent"></div>
                        </div>
                    </div>
                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-warning btn-sm  btn-setting-bonu-unique">Configurar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="card fb-card">
            <div class="card-header">
                <i class="ti-money"></i>
                <div class="d-inline-block">
                    <h5>Nivel Acenso vendedores</h5>
                    <span>Bonos y recompensas USD</span>
                </div>
            </div>
            <div class="card-block">
                <form method="POST" class="form-setting" action="{{ route('panel.settings.update') }}" name="form-setting" id="form-setting">
                    @csrf
                    <input type="hidden" name="type" value="bonus_ascent">
                    <div class="form-group row">

                        <div class="col-sm-6">
                            <label class="col-form-label">Vendedor junior</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="level_ascent_bonus_single_junior" name="level_ascent_bonus_single_junior" value="{{$settings['level_ascent_bonus_single_junior']}}" placeholder="1">
                                <span class="input-group-addon">$</span>
                            </div>
                            <div class="col-form-label has-danger-level_ascent_bonus_single_junior"></div>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Vendedor semi se&ntilde;or</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="level_ascent_bonus_single_middle" name="level_ascent_bonus_single_middle" value="{{$settings['level_ascent_bonus_single_middle']}}" placeholder="1">
                                <span class="input-group-addon">$</span>
                            </div>
                            <div class="col-form-label has-danger-level_ascent_bonus_single_middle"></div>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Vendedor se&ntilde;or</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="level_ascent_bonus_single_master" name="level_ascent_bonus_single_master" value="{{$settings['level_ascent_bonus_single_master']}}" placeholder="1">
                                <span class="input-group-addon">$</span>
                            </div>
                            <div class="col-form-label has-danger-level_ascent_bonus_single_master"></div>
                        </div>
                    </div>
                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-warning btn-sm  btn-setting-bonu-ascent">Configurar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="card fb-card">
            <div class="card-header">
                <i class="ti-eye"></i>
                <div class="d-inline-block">
                    <h5>Terminos y Condiciones</h5>
                    <span>Legalidad</span>
                </div>
            </div>
            <div class="card-block">
                <form method="POST" class="form-setting" action="{{ route('panel.settings.update') }}" name="form-setting" id="form-setting">
                    @csrf
                    <input type="hidden" name="type" value="terms_and_conditions">
                    <input type="hidden" name="terms_and_conditions" id="terms_and_conditions" value="{{$settings['terms_and_conditions']}}">
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label class="col-form-label">Terminos y Condiciones</label>
                            <textarea id="editor" autofocus></textarea>
                            <div class="col-form-label has-danger-terms_and_conditions"></div>
                        </div>
                    </div>
                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-warning btn-sm  btn-setting-term">Configurar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script-content')
<script src="{{ asset('assets/js/jimbo/settings.js') }}"></script>
@endsection
