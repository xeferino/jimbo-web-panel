'use strict';
const APP_URL = $('meta[name="base-url"]').attr('content');
const JIMBO = { url : '/panel/raffles' };

$(function () {
    /*DataTables*/
    var table = $('.table-raffle').DataTable({
        processing: true,
        serverSide: true,
        "language": {
            "decimal":        "",
            "info":           "Mostrando _START_ - _END_ de un total _TOTAL_ sorteos",
            "infoEmpty":      "Mostrando 0 para 0 de 0 sorteos",
            "infoFiltered":   "(Filtrado para un total de _MAX_ sorteos)",
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
            {data: 'title', name: 'title'},
            {data: 'cash_to_draw', name: 'cash_to_draw'},
            {data: 'cash_to_collect', name: 'cash_to_collect'},
            {data: 'date_start', name: 'date_start'},
            {data: 'date_end', name: 'date_end'},
            {data: 'public', name: 'public'},
            {data: 'active', name: 'active'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    /*DataTables*/

    /*raffle-register*/
    $("#form-raffle-create").submit(function( event ) {
        event.preventDefault();
        $('.jimbo-loader').show();
        $('.load-text').text('Enviando...');
        $('.btn-raffle').prop("disabled", true).text('Enviando...');

        var formData = new FormData(event.currentTarget);

        axios.post($(this).attr('action'), formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        }).then(response => {
            if(response.data.success){
                notify(response.data.message, 'success', '3000', 'top', 'right');
                $('#form-raffle-create').trigger("reset");
                $('.btn-raffle').prop("disabled", false).text('Registrar');
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
                    if (error.response.data.errors.title) {
                        $('.has-danger-title').text('' + error.response.data.errors.title + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-title').text('');
                    }

                    if (error.response.data.errors.brand) {
                        $('.has-danger-brand').text('' + error.response.data.errors.brand + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-brand').text('');
                    }

                    if (error.response.data.errors.promoter) {
                        $('.has-danger-promoter').text('' + error.response.data.errors.promoter + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-promoter').text('');
                    }

                    if (error.response.data.errors.provider) {
                        $('.has-danger-provider').text('' + error.response.data.errors.provider + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-provider').text('');
                    }

                    if (error.response.data.errors.place) {
                        $('.has-danger-place').text('' + error.response.data.errors.place + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-place').text('');
                    }

                    if (error.response.data.errors.date_start) {
                        $('.has-danger-date_start').text('' + error.response.data.errors.date_start + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-date_start').text('');
                    }

                    if (error.response.data.errors.date_end) {
                        $('.has-danger-date_end').text('' + error.response.data.errors.date_end + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-date_end').text('');
                    }

                    if (error.response.data.errors.cash_to_collect) {
                        $('.has-danger-cash_to_collect').text('' + error.response.data.errors.cash_to_collect + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-cash_to_collect').text('');
                    }

                    if (error.response.data.errors.cash_to_draw) {
                        $('.has-danger-cash_to_draw').text('' + error.response.data.errors.cash_to_draw + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-cash_to_draw').text('');
                    }

                    if (error.response.data.errors.description) {
                        $('.has-danger-description').text('' + error.response.data.errors.description + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-description').text('');
                    }

                    if (error.response.data.errors.active) {
                        $('.has-danger-active').text('' + error.response.data.errors.active + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-active').text('');
                    }

                    if (error.response.data.errors.public) {
                        $('.has-danger-public').text('' + error.response.data.errors.public + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-public').text('');
                    }

                    if (error.response.data.errors.prize_1) {
                        $('.has-danger-prize_1').text('' + error.response.data.errors.prize_1 + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-prize_1').text('');
                    }

                    if (error.response.data.errors.prize_2) {
                        $('.has-danger-prize_2').text('' + error.response.data.errors.prize_2 + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-prize_2').text('');
                    }

                    if (error.response.data.errors.prize_3) {
                        $('.has-danger-prize_3').text('' + error.response.data.errors.prize_3 + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-prize_3').text('');
                    }

                    if (error.response.data.errors.prize_4) {
                        $('.has-danger-prize_4').text('' + error.response.data.errors.prize_4 + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-prize_4').text('');
                    }

                    if (error.response.data.errors.prize_5) {
                        $('.has-danger-prize_5').text('' + error.response.data.errors.prize_5 + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-prize_5').text('');
                    }

                    if (error.response.data.errors.prize_6) {
                        $('.has-danger-prize_6').text('' + error.response.data.errors.prize_6 + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-prize_6').text('');
                    }

                    if (error.response.data.errors.prize_7) {
                        $('.has-danger-prize_7').text('' + error.response.data.errors.prize_7 + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-prize_7').text('');
                    }

                    if (error.response.data.errors.prize_8) {
                        $('.has-danger-prize_8').text('' + error.response.data.errors.prize_8 + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-prize_8').text('');
                    }

                    if (error.response.data.errors.prize_9) {
                        $('.has-danger-prize_9').text('' + error.response.data.errors.prize_9 + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-prize_9').text('');
                    }

                    if (error.response.data.errors.prize_10) {
                        $('.has-danger-prize_10').text('' + error.response.data.errors.prize_10 + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-prize_10').text('');
                    }





                }else{
                    notify('Error, Intente nuevamente mas tarde.', 'danger', '5000', 'bottom', 'right');
                }
            }else{
                notify('Error, Intente nuevamente mas tarde.', 'danger', '5000', 'bottom', 'right');
            }
            $('.btn-raffle').prop("disabled", false).text('Registrar');
            setTimeout(() => {$('.jimbo-loader').hide();}, 500);
        });
    });
    /* raffle-register*/

     /*raffle-edit*/
     $("#form-raffle-edit").submit(function( event ) {
        event.preventDefault();
        $('.jimbo-loader').show();
        $('.load-text').text('Enviando...');
        $('.jimbo-loader').show();
        $('.load-text').text('Enviando...');
        $('.btn-raffle').prop("disabled", true).text('Enviando...');

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
                $('#form-raffle-edit').trigger("reset");
                $('.btn-raffle').prop("disabled", false).text('Actualizar');
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

                        if (error.response.data.errors.price) {
                            $('.has-danger-price').text('' + error.response.data.errors.price + '').css("color", "#dc3545e3");
                        }else{
                            $('.has-danger-price').text('');
                        }

                        if (error.response.data.errors.code) {
                            $('.has-danger-code').text('' + error.response.data.errors.code + '').css("color", "#dc3545e3");
                        }else{
                            $('.has-danger-code').text('');
                        }

                    }else{
                        notify('Error, Intente nuevamente mas tarde.', 'danger', '5000', 'top', 'right');
                    }
                }else{
                    notify('Error, Intente nuevamente mas tarde.', 'danger', '5000', 'top', 'right');
                }
                $('.btn-raffle').prop("disabled", false).text('Actualizar');
                setTimeout(() => {$('.jimbo-loader').hide();}, 500);
        });
    });
    /*raffle-edit*/

    /*alert-Raffle-delete*/
    $('body').on('click', '.deleteRaffle', function () {
        var url = $(this).data("url");
        swal({
                title: '¿Desea eliminar el Sorteo?',
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
    /*alert-Raffle-delete*/
});
