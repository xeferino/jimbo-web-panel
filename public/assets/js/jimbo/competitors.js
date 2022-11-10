'use strict';
const APP_URL = $('meta[name="base-url"]').attr('content');
const JIMBO = { url : '/panel/competitors' };
//alert(JIMBO.url)
$(function () {
    var id = $('#competitor_id').val();
    /*DataTables*/
    var table = $('.table-competitor').DataTable({
        processing: true,
        serverSide: true,
        "language": {
            "decimal":        "",
            "info":           "Mostrando _START_ - _END_ de un total _TOTAL_ participantes",
            "infoEmpty":      "Mostrando 0 para 0 de 0 participantes",
            "infoFiltered":   "(Filtrado para un total de _MAX_ participantes)",
            "infoPostFix":    "",
            "thousands":      ",",
            "lengthMenu":     "Mostrar _MENU_ Registros",
            "loadingRecords": `<div class="ball-scale">
                                    <div class='contain'>
                                        <div class="ring"><div class="frame"></div></div>
                                        <div class="ring"><div class="frame"></div></div>
                                        <img src="${APP_URL+'/assets/images/jimbo-table.png'}" class="ring" width="48" alt="logo.png">
                                        <div class="ring"><div class="frame"></div></div>
                                        <div class="ring"><div class="frame"></div></div>
                                    </div>
                                </div>`,
            "processing": `<div class="ball-scale">
                                <div class='contain'>
                                    <div class="ring"><div class="frame"></div></div>
                                    <div class="ring"><div class="frame"></div></div>
                                    <img src="${APP_URL+'/assets/images/jimbo-table.png'}" class="ring" width="48" alt="logo.png">
                                    <div class="ring"><div class="frame"></div></div>
                                    <div class="ring"><div class="frame"></div></div>
                                </div>
                            </div>`,
            "search":         "Buscar:",
            "zeroRecords":    "No hay coicidencias de registros en la busqueda",
            "paginate": {
                "first":      "Primero",
                "last":       "Ultimo",
                "next":       "Siguiente",
                "previous":   "Anterior"
            },
            "aria": {
                "sortAscending":  ": activate to sort column ascending",
                "sortDescending": ": activate to sort column descending"
            }
        },
        ajax: APP_URL+JIMBO.url,
        columns: [
            {data: 'id', name: 'id'},
            {data: 'image', name: 'image'},
            {data: 'fullname', name: 'fullname'},
            {data: 'role', name: 'role'},
            {data: 'email', name: 'email'},
            {data: 'active', name: 'active'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    var table1 = $('.table-competitor-shoppings').DataTable({
        processing: true,
        serverSide: true,
        "language": {
            "decimal":        "",
            "info":           "Mostrando _START_ - _END_ de un total _TOTAL_ compras",
            "infoEmpty":      "Mostrando 0 para 0 de 0 compras",
            "infoFiltered":   "(Filtrado para un total de _MAX_ compras)",
            "infoPostFix":    "",
            "thousands":      ",",
            "lengthMenu":     "Mostrar _MENU_ Registros",
            "loadingRecords": `<div class="ball-scale">
                                    <div class='contain'>
                                        <div class="ring"><div class="frame"></div></div>
                                        <div class="ring"><div class="frame"></div></div>
                                        <img src="${APP_URL+'/assets/images/jimbo-table.png'}" class="ring" width="48" alt="logo.png">
                                        <div class="ring"><div class="frame"></div></div>
                                        <div class="ring"><div class="frame"></div></div>
                                    </div>
                                </div>`,
            "processing": `<div class="ball-scale">
                                <div class='contain'>
                                    <div class="ring"><div class="frame"></div></div>
                                    <div class="ring"><div class="frame"></div></div>
                                    <img src="${APP_URL+'/assets/images/jimbo-table.png'}" class="ring" width="48" alt="logo.png">
                                    <div class="ring"><div class="frame"></div></div>
                                    <div class="ring"><div class="frame"></div></div>
                                </div>
                            </div>`,
            "search":         "Buscar:",
            "zeroRecords":    "No hay coicidencias de registros en la busqueda",
            "paginate": {
                "first":      "Primero",
                "last":       "Ultimo",
                "next":       "Siguiente",
                "previous":   "Anterior"
            },
            "aria": {
                "sortAscending":  ": activate to sort column ascending",
                "sortDescending": ": activate to sort column descending"
            }
        },
        ajax: APP_URL+JIMBO.url+'/'+id+'?mod=shopping',
        columns: [
            {data: 'id', name: 'id'},
            {data: 'number', name: 'number'},
            {data: 'number_culqi', name: 'number_culqi'},
            {data: 'amount', name: 'amount'},
            {data: 'method', name: 'method'},
            {data: 'raffle', name: 'raffle'},
            {data: 'quantity', name: 'quantity'},
            {data: 'ticket', name: 'ticket'},
            {data: 'date', name: 'date'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    var table2 = $('.table-competitor-payment-history').DataTable({
        processing: true,
        serverSide: true,
        "language": {
            "decimal":        "",
            "info":           "Mostrando _START_ - _END_ de un total _TOTAL_ compras",
            "infoEmpty":      "Mostrando 0 para 0 de 0 compras",
            "infoFiltered":   "(Filtrado para un total de _MAX_ compras)",
            "infoPostFix":    "",
            "thousands":      ",",
            "lengthMenu":     "Mostrar _MENU_ Registros",
            "loadingRecords": `<div class="ball-scale">
                                    <div class='contain'>
                                        <div class="ring"><div class="frame"></div></div>
                                        <div class="ring"><div class="frame"></div></div>
                                        <img src="${APP_URL+'/assets/images/jimbo-table.png'}" class="ring" width="48" alt="logo.png">
                                        <div class="ring"><div class="frame"></div></div>
                                        <div class="ring"><div class="frame"></div></div>
                                    </div>
                                </div>`,
            "processing": `<div class="ball-scale">
                                <div class='contain'>
                                    <div class="ring"><div class="frame"></div></div>
                                    <div class="ring"><div class="frame"></div></div>
                                    <img src="${APP_URL+'/assets/images/jimbo-table.png'}" class="ring" width="48" alt="logo.png">
                                    <div class="ring"><div class="frame"></div></div>
                                    <div class="ring"><div class="frame"></div></div>
                                </div>
                            </div>`,
            "search":         "Buscar:",
            "zeroRecords":    "No hay coicidencias de registros en la busqueda",
            "paginate": {
                "first":      "Primero",
                "last":       "Ultimo",
                "next":       "Siguiente",
                "previous":   "Anterior"
            },
            "aria": {
                "sortAscending":  ": activate to sort column ascending",
                "sortDescending": ": activate to sort column descending"
            }
        },
        ajax: APP_URL+JIMBO.url+'/'+id+'?mod=paymentHistory',
        columns: [
            {data: 'id', name: 'id'},
            {data: 'number', name: 'number'},
            {data: 'method', name: 'method'},
            {data: 'amount', name: 'amount'},
            {data: 'description', name: 'description'},
            {data: 'message', name: 'message'},
            {data: 'date', name: 'date'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    var table3 = $('.table-cash').DataTable({
        processing: true,
        serverSide: true,
        "language": {
            "decimal":        "",
            "info":           "Mostrando _START_ - _END_ de un total _TOTAL_ solicitudes",
            "infoEmpty":      "Mostrando 0 para 0 de 0 solicitudes",
            "infoFiltered":   "(Filtrado para un total de _MAX_ solicitudes)",
            "infoPostFix":    "",
            "thousands":      ",",
            "lengthMenu":     "Mostrar _MENU_ Registros",
            "loadingRecords": `<div class="ball-scale">
                                    <div class='contain'>
                                        <div class="ring"><div class="frame"></div></div>
                                        <div class="ring"><div class="frame"></div></div>
                                        <img src="${APP_URL+'/assets/images/jimbo-table.png'}" class="ring" width="48" alt="logo.png">
                                        <div class="ring"><div class="frame"></div></div>
                                        <div class="ring"><div class="frame"></div></div>
                                    </div>
                                </div>`,
            "processing": `<div class="ball-scale">
                                <div class='contain'>
                                    <div class="ring"><div class="frame"></div></div>
                                    <div class="ring"><div class="frame"></div></div>
                                    <img src="${APP_URL+'/assets/images/jimbo-table.png'}" class="ring" width="48" alt="logo.png">
                                    <div class="ring"><div class="frame"></div></div>
                                    <div class="ring"><div class="frame"></div></div>
                                </div>
                            </div>`,
            "search":         "Buscar:",
            "zeroRecords":    "No hay coicidencias de registros en la busqueda",
            "paginate": {
                "first":      "Primero",
                "last":       "Ultimo",
                "next":       "Siguiente",
                "previous":   "Anterior"
            },
            "aria": {
                "sortAscending":  ": activate to sort column ascending",
                "sortDescending": ": activate to sort column descending"
            }
        },
        ajax: APP_URL+JIMBO.url+'/'+id+'?mod=cash',
        columns: [
            {data: 'id', name: 'id'},
            {data: 'amount', name: 'amount'},
            {data: 'date', name: 'date'},
            {data: 'hour', name: 'hour'},
            {data: 'reference', name: 'reference'},
            {data: 'user', name: 'user'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    var table4 = $('.table-balance').DataTable({
        processing: true,
        serverSide: true,
        "language": {
            "decimal":        "",
            "info":           "Mostrando _START_ - _END_ de un total _TOTAL_ balances",
            "infoEmpty":      "Mostrando 0 para 0 de 0 balances",
            "infoFiltered":   "(Filtrado para un total de _MAX_ balances)",
            "infoPostFix":    "",
            "thousands":      ",",
            "lengthMenu":     "Mostrar _MENU_ Registros",
            "loadingRecords": `<div class="ball-scale">
                                    <div class='contain'>
                                        <div class="ring"><div class="frame"></div></div>
                                        <div class="ring"><div class="frame"></div></div>
                                        <img src="${APP_URL+'/assets/images/jimbo-table.png'}" class="ring" width="48" alt="logo.png">
                                        <div class="ring"><div class="frame"></div></div>
                                        <div class="ring"><div class="frame"></div></div>
                                    </div>
                                </div>`,
            "processing": `<div class="ball-scale">
                                <div class='contain'>
                                    <div class="ring"><div class="frame"></div></div>
                                    <div class="ring"><div class="frame"></div></div>
                                    <img src="${APP_URL+'/assets/images/jimbo-table.png'}" class="ring" width="48" alt="logo.png">
                                    <div class="ring"><div class="frame"></div></div>
                                    <div class="ring"><div class="frame"></div></div>
                                </div>
                            </div>`,
            "search":         "Buscar:",
            "zeroRecords":    "No hay coicidencias de registros en la busqueda",
            "paginate": {
                "first":      "Primero",
                "last":       "Ultimo",
                "next":       "Siguiente",
                "previous":   "Anterior"
            },
            "aria": {
                "sortAscending":  ": activate to sort column ascending",
                "sortDescending": ": activate to sort column descending"
            }
        },
        ajax: APP_URL+JIMBO.url+'/'+id+'?mod=balance',
        columns: [
            {data: 'id', name: 'id'},
            {data: 'reference', name: 'reference'},
            {data: 'description', name: 'description'},
            {data: 'type', name: 'type'},
            {data: 'amount', name: 'amount'},
            {data: 'currency', name: 'currency'},
            {data: 'date', name: 'date'},
            {data: 'hour', name: 'hour'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    /*DataTables*/
    table4.columns([8]).visible(false);
    table2.columns([8]).visible(false);

    $("#image").on('change', function () {
        if(validarExtension(this)) {
            $('#avatar').show();
            if(validarPeso(this)) {
                verImagen(this);
	        }
	    }else{
            $('#avatar').hide();
        }
    });

    /*competitor-register*/
    $("#form-competitor-create").submit(function( event ) {
        event.preventDefault();
        $('.jimbo-loader').show();
        $('.load-text').text('Enviando...');
        $('.btn-competitor').prop("disabled", true).text('Enviando...');

        var formData = new FormData(event.currentTarget);

        axios.post($(this).attr('action'), formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        }).then(response => {
            if(response.data.success){
                notify(response.data.message, 'success', '3000', 'top', 'right');
                $('#form-competitor-create').trigger("reset");
                $('.btn-competitor').prop("disabled", false).text('Registrar');
                $('div.col-form-label').text('');
                setTimeout(() => {$('.jimbo-loader').hide();}, 500);
                setTimeout(() => {location.href = APP_URL+JIMBO.url;}, 3000);
            }
        }).catch(error => {
            if (error.response) {
                if(error.response.status === 422){
                    var err = error.response.data.errors;
                    /* $.each(err, function( key, value) {
                        notify(value, 'danger', '5000', 'bottom', 'right');
                    }); */
                    if (error.response.data.errors.names) {
                        $('.has-danger-names').text('' + error.response.data.errors.names + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-names').text('');
                    }
                    if (error.response.data.errors.surnames) {
                        $('.has-danger-surnames').text('' + error.response.data.errors.surnames + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-surnames').text('');
                    }
                    if (error.response.data.errors.email) {
                        $('.has-danger-email').text('' + error.response.data.errors.email + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-email').text('');
                    }
                    if (error.response.data.errors.dni) {
                        $('.has-danger-dni').text('' + error.response.data.errors.dni + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-dni').text('');
                    }
                    if (error.response.data.errors.phone) {
                        $('.has-danger-phone').text('' + error.response.data.errors.phone + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-phone').text('');
                    }
                    if (error.response.data.errors.balance_jib) {
                        $('.has-danger-balance_jib').text('' + error.response.data.errors.balance_jib + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-balance_jib').text('');
                    }
                    if (error.response.data.errors.country_id) {
                        $('.has-danger-country_id').text('' + error.response.data.errors.country_id + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-country_id').text('');
                    }
                    if (error.response.data.errors.role) {
                        $('.has-danger-role').text('' + error.response.data.errors.role + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-role').text('');
                    }
                    if (error.response.data.errors.active) {
                        $('.has-danger-active').text('' + error.response.data.errors.active + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-active').text('');
                    }
                    if (error.response.data.errors.image) {
                        $('.has-danger-image').text('' + error.response.data.errors.image + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-image').text('');
                    }
                    if (error.response.data.errors.password) {
                        $('.has-danger-password').text('' + error.response.data.errors.password + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-password').text('');
                    }
                    if (error.response.data.errors.cpassword) {
                        $('.has-danger-cpassword').text('' + error.response.data.errors.cpassword + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-cpassword').text('');
                    }
                }else{
                    notify('Error, Intente nuevamente mas tarde.', 'danger', '5000', 'bottom', 'right');
                }
            }else{
                notify('Error, Intente nuevamente mas tarde.', 'danger', '5000', 'bottom', 'right');
            }
            $('.btn-competitor').prop("disabled", false).text('Registrar');
            setTimeout(() => {$('.jimbo-loader').hide();}, 500);
        });
    });
    /* competitor-register*/

    /*competitor-edit*/
    $("#form-competitor-edit").submit(function( event ) {
        event.preventDefault();
        $('.jimbo-loader').show();
        $('.load-text').text('Enviando...');
        $('.jimbo-loader').show();
        $('.load-text').text('Enviando...');
        $('.btn-competitor').prop("disabled", true).text('Enviando...');

        var formData = new FormData(event.currentTarget);
        formData.append('_method', 'PUT');

        axios.post($(this).attr('action'), formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        }).then(response => {
            if(response.data.success){
                notify(response.data.message, 'success', '3000', 'top', 'right');
                setTimeout(() => {$('.jimbo-loader').hide();}, 500);
                $('#form-competitor-edit').trigger("reset");
                $('.btn-competitor').prop("disabled", false).text('Actualizar');
                $('div.col-form-label').text('');
                setTimeout(() => {location.href = APP_URL+JIMBO.url;}, 3000);
            }
        }).catch(error => {
            if (error.response) {
                    if(error.response.status === 422){
                        var err = error.response.data.errors;
                        /* $.each(err, function( key, value) {
                            notify(value, 'danger', '5000', 'top', 'right');
                        }); */
                        if (error.response.data.errors.names) {
                            $('.has-danger-names').text('' + error.response.data.errors.names + '').css("color", "#dc3545e3");
                        }else{
                            $('.has-danger-names').text('');
                        }
                        if (error.response.data.errors.surnames) {
                            $('.has-danger-surnames').text('' + error.response.data.errors.surnames + '').css("color", "#dc3545e3");
                        }else{
                            $('.has-danger-surnames').text('');
                        }
                        if (error.response.data.errors.email) {
                            $('.has-danger-email').text('' + error.response.data.errors.email + '').css("color", "#dc3545e3");
                        }else{
                            $('.has-danger-email').text('');
                        }
                        if (error.response.data.errors.dni) {
                            $('.has-danger-dni').text('' + error.response.data.errors.dni + '').css("color", "#dc3545e3");
                        }else{
                            $('.has-danger-dni').text('');
                        }

                        if (error.response.data.errors.address) {
                            $('.has-danger-address').text('' + error.response.data.errors.address + '').css("color", "#dc3545e3");
                        }else{
                            $('.has-danger-address').text('');
                        }

                        if (error.response.data.errors.address_city) {
                            $('.has-danger-address_city').text('' + error.response.data.errors.address_city + '').css("color", "#dc3545e3");
                        }else{
                            $('.has-danger-address_city').text('');
                        }
                        if (error.response.data.errors.phone) {
                            $('.has-danger-phone').text('' + error.response.data.errors.phone + '').css("color", "#dc3545e3");
                        }else{
                            $('.has-danger-phone').text('');
                        }
                        if (error.response.data.errors.balance_jib) {
                            $('.has-danger-balance_jib').text('' + error.response.data.errors.balance_jib + '').css("color", "#dc3545e3");
                        }else{
                            $('.has-danger-balance_jib').text('');
                        }
                        if (error.response.data.errors.country_id) {
                            $('.has-danger-country_id').text('' + error.response.data.errors.country_id + '').css("color", "#dc3545e3");
                        }else{
                            $('.has-danger-country_id').text('');
                        }
                        if (error.response.data.errors.role) {
                            $('.has-danger-role').text('' + error.response.data.errors.role + '').css("color", "#dc3545e3");
                        }else{
                            $('.has-danger-role').text('');
                        }
                        if (error.response.data.errors.active) {
                            $('.has-danger-active').text('' + error.response.data.errors.active + '').css("color", "#dc3545e3");
                        }else{
                            $('.has-danger-active').text('');
                        }
                        if (error.response.data.errors.image) {
                            $('.has-danger-image').text('' + error.response.data.errors.image + '').css("color", "#dc3545e3");
                        }else{
                            $('.has-danger-image').text('');
                        }
                        if (error.response.data.errors.password) {
                            $('.has-danger-password').text('' + error.response.data.errors.password + '').css("color", "#dc3545e3");
                        }else{
                            $('.has-danger-password').text('');
                        }
                        if (error.response.data.errors.cpassword) {
                            $('.has-danger-cpassword').text('' + error.response.data.errors.cpassword + '').css("color", "#dc3545e3");
                        }else{
                            $('.has-danger-cpassword').text('');
                        }
                    }else{
                        notify('Error, Intente nuevamente mas tarde.', 'danger', '5000', 'top', 'right');
                    }
                }else{
                    notify('Error, Intente nuevamente mas tarde.', 'danger', '5000', 'top', 'right');
                }
                $('.btn-competitor').prop("disabled", false).text('Actualizar');
                setTimeout(() => {$('.jimbo-loader').hide();}, 500);
        });
    });
    /*competitor-edit*/

    /*alert-competitor-delete*/
    $('body').on('click', '.deleteCompetitor', function () {
        var url = $(this).data("url");
        swal({
                title: '¿Desea eliminar el participante?',
                text: "Recuerde que esta acción no tiene revera.",
                type: 'error',
                icon : APP_URL+"/assets/images/jimbo-logo.png",
                buttons:{
                    confirm: {
                        text : 'Eliminar',
                        className : 'btn btn-warning',
                        showLoaderOnConfirm: true,
                    },
                    cancel: {
                        visible: true,
                        text : 'Cancelar',
                        className : 'btn btn-inverse',
                    }
                },
            }).then((confirm) => {
                if (confirm) {
                    $('.jimbo-loader').show();
                    axios.delete(url, {
                    }).then(response => {
                        if(response.data.success){
                            setTimeout(() => {$('.jimbo-loader').hide();}, 500);
                            notify(response.data.message, 'success', '3000', 'top', 'right');
                            table.ajax.reload();
                        }else {
                            setTimeout(() => {$('.jimbo-loader').hide();}, 500);
                            notify(response.data.message, 'success', '3000', 'top', 'right');
                        }
                    }).catch(error => {
                        if (error.response) {
                            if(error.response.status === 403){
                                notify(error.response.data.message, 'success', '3000', 'top', 'right');
                            }else{
                                notify('Error, Intente nuevamente mas tarde.', 'danger', '5000', 'bottom', 'right');
                            }
                        }else{
                            notify('Error, Intente nuevamente mas tarde.', 'danger', '5000', 'bottom', 'right');
                        }
                        setTimeout(() => {$('.jimbo-loader').hide();}, 500);
                    });
                } else {
                    swal.close();
                }
            });
    });
    /*alert-competitor-delete*/
});
