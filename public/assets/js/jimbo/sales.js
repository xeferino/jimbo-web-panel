'use strict';
const APP_URL = $('meta[name="base-url"]').attr('content');
const JIMBO = { url : '/panel/sales' };
//alert(JIMBO.url)
$(function () {
    var id = $('#sale_id').val();
    var raffle_id = $('#raffle_id').val();
    var ticket_id = $('#ticket').val();

    //raffleTicket();

    /*DataTables*/
    var table = $('.table-sale').DataTable({
        processing: true,
        serverSide: true,
        order: [[0, 'desc']],
        "language": {
            "decimal":        "",
            "info":           "Mostrando _START_ - _END_ de un total _TOTAL_ ventas",
            "infoEmpty":      "Mostrando 0 para 0 de 0 ventas",
            "infoFiltered":   "(Filtrado para un total de _MAX_ ventas)",
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
        dom: 'lBfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [ 0,1,2,3,4,5,6,7,8,9 ]
                },
                filename: function() {
                    return "Reporte-de-ventas"
                },
                title: "Reporte de ventas"
            },
            {
                extend: 'csvHtml5',
                exportOptions: {
                    columns: [ 0,1,2,3,4,5,6,7,8,9 ]
                },
                filename: function() {
                    return "Reporte-de-ventas"
                },
                title: "Reporte de ventas"
            }
        ],
        ajax: APP_URL+JIMBO.url,
        columns: [
            {data: 'id', name: 'id'},
            {data: 'seller', name: 'seller'},
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

    var table_ticket = $('.table-sale-ticket').DataTable({
        processing: true,
        serverSide: true,
        "language": {
            "decimal":        "",
            "info":           "Mostrando _START_ - _END_ de un total _TOTAL_ boletos",
            "infoEmpty":      "Mostrando 0 para 0 de 0 boletos",
            "infoFiltered":   "(Filtrado para un total de _MAX_ boletos)",
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
        dom: 'lBfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [ 1 ]
                },
                filename: function() {
                    return "Reporte-de-ventas-boletos"
                },
                title: "Reporte de ventas de boletos"
            },
            {
                extend: 'csvHtml5',
                exportOptions: {
                    columns: [ 1 ]
                },
                filename: function() {
                    return "Reporte-de-ventas-boletos"
                },
                title: "Reporte de ventas de boletos"
            }
        ],
        ajax: APP_URL+JIMBO.url+'/'+id,
        columns: [
            {data: 'id', name: 'id'},
            {data: 'serial', name: 'serial'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    table_ticket.columns([2]).visible(false);
    /*DataTables*/

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

    $("#raffle_id").change(function( event ) {
        event.preventDefault();
        if ($(this).val() > 0 ){
            $('.has-danger-raffle_id').text('');
            $('.jimbo-loader').show();
            $('.load-text').text('cargango...');

            axios.get(APP_URL+JIMBO.url+'/create?raffle_id='+$(this).val())
            .then(response => {
                if(response.data.success){
                    $('#ticket_id').html(function(){
                        var items = '';

                        items +=`<option value="">.::Seleccione::.</option>`;
                        $.each(response.data.promotions, function(key, value) {
                            items +=`<option value="${value.id}">${value.name}</option>`;
                        });
                        return items;
                    });
                    setTimeout(() => {$('.jimbo-loader').hide();}, 500);

                }
            }).catch(error => {
                if (error.response) {

                }else{
                    notify('Error, Intente nuevamente mas tarde.', 'danger', '5000', 'bottom', 'right');
                }
                setTimeout(() => {$('.jimbo-loader').hide();}, 500);
            });
        } else {
            $('#ticket_id').html(function(){
                var items = '';
                items +=`<option value="">.::Seleccione::.</option>`;
                return items;
            });
            $('.has-danger-raffle_id').text('debe seleccionar un sorteo disponible').css("color", "#dc3545e3");
        }
    });

    $('body').on('click', '.change-sale', function () {
        swal({
            title: 'La venta esta '+$(this).data("status")+'!',
            text: "Recuerde que esta acción no tiene revera.",
            type: 'error',
            icon : APP_URL+"/assets/images/jimbo-logo.png",
            buttons:{
                confirm: {
                    text : 'Aprobar',
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
                axios.get(APP_URL+JIMBO.url+'/'+id)
                .then(response => {
                    if(response.data.success){
                        setTimeout(() => {$('.jimbo-loader').hide();}, 500);
                        notify(response.data.message, 'success', '3000', 'top', 'right');
                        setTimeout(() => {location.reload()}, 3000);
                    }else {
                        setTimeout(() => {$('.jimbo-loader').hide();}, 500);
                        notify(response.data.message, 'danger', '3000', 'top', 'right');
                        setTimeout(() => {location.reload()}, 3000);
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

    /*sale-register*/
    $("#form-sale-create").submit(function( event ) {
        event.preventDefault();
        $('.jimbo-loader').show();
        $('.load-text').text('Enviando...');
        $('.btn-sale').prop("disabled", true).text('Enviando...');

        var formData = new FormData(event.currentTarget);

        axios.post($(this).attr('action'), formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        }).then(response => {
            if(response.data.success){
                notify(response.data.message, 'success', '3000', 'top', 'right');
                $('#form-sale-create').trigger("reset");
                $('.btn-sale').prop("disabled", false).text('Registrar');
                $('div.col-form-label').text('');
                setTimeout(() => {$('.jimbo-loader').hide();}, 500);
                setTimeout(() => {location.href = response.data.url;}, 3000);
            } else {
                notify(response.data.message, 'danger', '3000', 'top', 'right');
                setTimeout(() => {$('.jimbo-loader').hide();}, 500);
                $('#form-sale-create').trigger("reset");
                $('.btn-sale').prop("disabled", false).text('Registrar');
                setTimeout(() => {location.reload();}, 3000);
            }
        }).catch(error => {
            if (error.response) {
                if(error.response.status === 422){
                    var err = error.response.data.errors;
                    /* $.each(err, function( key, value) {
                        notify(value, 'danger', '5000', 'bottom', 'right');
                    }); */
                    if (error.response.data.errors.fullnames) {
                        $('.has-danger-fullnames').text('' + error.response.data.errors.fullnames + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-fullnames').text('');
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

                    if (error.response.data.errors.country_id) {
                        $('.has-danger-country_id').text('' + error.response.data.errors.country_id + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-country_id').text('');
                    }

                    if (error.response.data.errors.status) {
                        $('.has-danger-status').text('' + error.response.data.errors.status + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-status').text('');
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

                    if (error.response.data.errors.raffle_id) {
                        $('.has-danger-raffle_id').text('' + error.response.data.errors.raffle_id + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-raffle_id').text('');
                    }

                    if (error.response.data.errors.ticket_id) {
                        $('.has-danger-ticket_id').text('' + error.response.data.errors.ticket_id + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-ticket_id').text('');
                    }

                }else{
                    notify('Error, Intente nuevamente mas tarde.', 'danger', '5000', 'bottom', 'right');
                }
            }else{
                notify('Error, Intente nuevamente mas tarde.', 'danger', '5000', 'bottom', 'right');
            }
            $('.btn-sale').prop("disabled", false).text('Registrar');
            setTimeout(() => {$('.jimbo-loader').hide();}, 500);
        });
    });
    /* sale-register*/

    /*sale-edit*/
    $("#form-sale-edit").submit(function( event ) {
        event.preventDefault();
        $('.jimbo-loader').show();
        $('.load-text').text('Enviando...');
        $('.jimbo-loader').show();
        $('.load-text').text('Enviando...');
        $('.btn-sale').prop("disabled", true).text('Enviando...');

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
                $('#form-sale-edit').trigger("reset");
                $('.btn-sale').prop("disabled", false).text('Actualizar');
                $('div.col-form-label').text('');
                setTimeout(() => {location.href = response.data.url;}, 3000);
            } else {
                notify(response.data.message, 'danger', '3000', 'top', 'right');
                setTimeout(() => {$('.jimbo-loader').hide();}, 500);
                $('#form-sale-edit').trigger("reset");
                $('.btn-sale').prop("disabled", false).text('Actualizar');
                setTimeout(() => {location.reload();}, 3000);
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
                $('.btn-sale').prop("disabled", false).text('Actualizar');
                setTimeout(() => {$('.jimbo-loader').hide();}, 500);
        });
    });
    /*sale-edit*/

    /*alert-sale-delete*/
    $('body').on('click', '.deleteSale', function () {
        var url = $(this).data("url");
        swal({
                title: '¿Desea eliminar la venta?',
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
    /*alert-sale-delete*/
});

/*function raffleTicket()
{
    var raffle = $('#raffle_id').val();
    var ticket = $('#ticket').val();
    axios.get(APP_URL+JIMBO.url+'/create?raffle_id='+raffle)
        .then(response => {
            if(response.data.success){
                $('#ticket_id').html(function(){
                    var items = '';
                    $.each(response.data.promotions, function(key, value) {
                        if(ticket == value.id) {
                            items +=`<option value="${value.id}" selected>${value.name}</option>`;
                        } else {
                            items +=`<option value="${value.id}">${value.name}</option>`;
                        }
                    });
                    return items;
                });
                setTimeout(() => {$('.jimbo-loader').hide();}, 500);

            }
        }).catch(error => {
            if (error.response) {

            }else{
                notify('Error, Intente nuevamente mas tarde.', 'danger', '5000', 'bottom', 'right');
            }
            setTimeout(() => {$('.jimbo-loader').hide();}, 500);
        });
}*/
