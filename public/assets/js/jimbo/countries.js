'use strict';
const APP_URL = $('meta[name="base-url"]').attr('content');
const JIMBO = { url : '/panel/countries' };
//alert(JIMBO.url)
$(function () {
    /*DataTables*/
    var table = $('.table-country').DataTable({
        processing: true,
        serverSide: true,
        "language": {
            "decimal":        "",
            "info":           "Mostrando _START_ - _END_ de un total _TOTAL_ paises",
            "infoEmpty":      "Mostrando 0 para 0 de 0 paises",
            "infoFiltered":   "(Filtrado para un total de _MAX_ paises)",
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
            {data: 'name', name: 'name'},
            {data: 'code', name: 'code'},
            {data: 'iso', name: 'iso'},
            {data: 'img', name: 'img'},
            {data: 'currency', name: 'currency'},
            {data: 'exchange_rate', name: 'exchange_rate'},
            {data: 'active', name: 'active'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
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

    /*country-register*/
    $("#form-country-create").submit(function( event ) {
        event.preventDefault();
        $('.jimbo-loader').show();
        $('.load-text').text('Enviando...');
        $('.btn-country').prop("disabled", true).text('Enviando...');

        var formData = new FormData(event.currentTarget);

        axios.post($(this).attr('action'), formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        }).then(response => {
            if(response.data.success){
                notify(response.data.message, 'success', '3000', 'top', 'right');
                $('#form-country-create').trigger("reset");
                $('.btn-country').prop("disabled", false).text('Registrar');
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
                    if (error.response.data.errors.name) {
                        $('.has-danger-name').text('' + error.response.data.errors.name + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-name').text('');
                    }
                    if (error.response.data.errors.code) {
                        $('.has-danger-code').text('' + error.response.data.errors.code + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-code').text('');
                    }

                    if (error.response.data.errors.iso) {
                        $('.has-danger-iso').text('' + error.response.data.errors.iso + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-iso').text('');
                    }

                    if (error.response.data.errors.currency) {
                        $('.has-danger-currency').text('' + error.response.data.errors.currency + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-currency').text('');
                    }

                    if (error.response.data.errors.exchange_rate) {
                        $('.has-danger-exchange_rate').text('' + error.response.data.errors.exchange_rate + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-exchange_rate').text('');
                    }

                    if (error.response.data.errors.active) {
                        $('.has-danger-active').text('' + error.response.data.errors.active + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-active').text('');
                    }
                    if (error.response.data.errors.img) {
                        $('.has-danger-img').text('' + error.response.data.errors.img + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-img').text('');
                    }

                }else{
                    notify('Error, Intente nuevamente mas tarde.', 'danger', '5000', 'bottom', 'right');
                }
            }else{
                notify('Error, Intente nuevamente mas tarde.', 'danger', '5000', 'bottom', 'right');
            }
            $('.btn-country').prop("disabled", false).text('Registrar');
            setTimeout(() => {$('.jimbo-loader').hide();}, 500);
        });
    });
    /* country-register*/

    /*country-edit*/
    $("#form-country-edit").submit(function( event ) {
        event.preventDefault();
        $('.jimbo-loader').show();
        $('.load-text').text('Enviando...');
        $('.jimbo-loader').show();
        $('.load-text').text('Enviando...');
        $('.btn-country').prop("disabled", true).text('Enviando...');

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
                $('#form-country-edit').trigger("reset");
                $('.btn-country').prop("disabled", false).text('Actualizar');
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
                        if (error.response.data.errors.name) {
                            $('.has-danger-name').text('' + error.response.data.errors.name + '').css("color", "#dc3545e3");
                        }else{
                            $('.has-danger-name').text('');
                        }

                        if (error.response.data.errors.active) {
                            $('.has-danger-active').text('' + error.response.data.errors.active + '').css("color", "#dc3545e3");
                        }else{
                            $('.has-danger-active').text('');
                        }

                        if (error.response.data.errors.currency) {
                            $('.has-danger-currency').text('' + error.response.data.errors.currency + '').css("color", "#dc3545e3");
                        }else{
                            $('.has-danger-currency').text('');
                        }

                        if (error.response.data.errors.exchange_rate) {
                            $('.has-danger-exchange_rate').text('' + error.response.data.errors.exchange_rate + '').css("color", "#dc3545e3");
                        }else{
                            $('.has-danger-exchange_rate').text('');
                        }

                        if (error.response.data.errors.img) {
                            $('.has-danger-img').text('' + error.response.data.errors.img + '').css("color", "#dc3545e3");
                        }else{
                            $('.has-danger-img').text('');
                        }
                        if (error.response.data.errors.code) {
                            $('.has-danger-code').text('' + error.response.data.errors.code + '').css("color", "#dc3545e3");
                        }else{
                            $('.has-danger-code').text('');
                        }

                        if (error.response.data.errors.iso) {
                            $('.has-danger-iso').text('' + error.response.data.errors.iso + '').css("color", "#dc3545e3");
                        }else{
                            $('.has-danger-iso').text('');
                        }

                    }else{
                        notify('Error, Intente nuevamente mas tarde.', 'danger', '5000', 'top', 'right');
                    }
                }else{
                    notify('Error, Intente nuevamente mas tarde.', 'danger', '5000', 'top', 'right');
                }
                $('.btn-country').prop("disabled", false).text('Actualizar');
                setTimeout(() => {$('.jimbo-loader').hide();}, 500);
        });
    });
    /*country-edit*/

     /*alert-country-delete*/
     $('body').on('click', '.deleteCountry', function () {
        var url = $(this).data("url");
        swal({
                title: '¿Desea eliminar el Pais?',
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
    /*alert-country-delete*/

});
