'use strict';
const APP_URL = $('meta[name="base-url"]').attr('content');
const JIMBO = { url : '/panel/roles' };

$(function () {
    /*DataTables*/
    var table = $('.table-role').DataTable({
        processing: true,
        serverSide: true,
        "language": {
            "decimal":        "",
            "info":           "Mostrando _START_ - _END_ de un total _TOTAL_ roles",
            "infoEmpty":      "Mostrando 0 para 0 de 0 roles",
            "infoFiltered":   "(Filtrado para un total de _MAX_ roles)",
            "infoPostFix":    "",
            "thousands":      ",",
            "lengthMenu":     "Mostrar _MENU_ Registros",
            "loadingRecords": "Cargando...",
            "processing":     "Procesando...",
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
            {data: 'description', name: 'description'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    /*DataTables*/

    $('.has-danger-syncPermissions').hide();

    /*role-add*/
    $("#form-role-create").submit(function( event ) {
        event.preventDefault();
        $('.btn-role').prop("disabled", true).text('Enviando...');
        $('.jimbo-loader').show();
        $('.load-text').text('Enviando...');

        axios.post($(this).attr('action'), $(this).serialize(), {
        }).then(response => {
            if(response.data.success){
                setTimeout(() => {$('.jimbo-loader').hide();}, 500);
                notify(response.data.message, 'success', '3000', 'top', 'right');
                $('#form-role-create').trigger("reset");
                $('.btn-role').prop("disabled", false).text('Registrar');
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
                            $('.has-danger-name').text('' + error.response.data.errors.name + '').css("color", "red");
                        }else{
                            $('.has-danger-name').text('');
                        }

                        if (error.response.data.errors.description) {
                            $('.has-danger-description').text('' + error.response.data.errors.description + '').css("color", "red");
                        }else{
                            $('.has-danger-description').text('');
                        }

                        if (error.response.data.errors.syncPermissions) {
                            $('.has-danger-syncPermissions').text('' + error.response.data.errors.syncPermissions + '').show();
                        }else{
                            $('.has-danger-syncPermissions').text('').hide();
                        }
                    }else{
                        notify('Error, Intente nuevamente mas tarde.', 'danger', '5000', 'top', 'right');
                    }
                }else{
                    notify('Error, Intente nuevamente mas tarde.', 'danger', '5000', 'top', 'right');
                }
                $('.btn-role').prop("disabled", false).text('Registrar');
                setTimeout(() => {$('.jimbo-loader').hide();}, 500);
        });
    });
    /*role-add*/

    /*role-edit*/
    $("#form-role-edit").submit(function( event ) {
        event.preventDefault();
        $('.btn-role').prop("disabled", true).text('Enviando...');
        $('.jimbo-loader').show();
        $('.load-text').text('Enviando...');
        axios.put($("#form-role-edit").attr("action"), $(this).serialize(), {
        }).then(response => {
            if(response.data.success){
                notify(response.data.message, 'success', '3000', 'top', 'right');
                $('#form-role-edit').trigger("reset");
                $('.btn-role').prop("disabled", false).text('Actualizar');
                $('div.col-form-label').text('');
                setTimeout(() => {$('.jimbo-loader').hide();}, 500);
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
                            $('.has-danger-name').text('' + error.response.data.errors.name + '').css("color", "red");
                        }else{
                            $('.has-danger-name').text('');
                        }

                        if (error.response.data.errors.description) {
                            $('.has-danger-description').text('' + error.response.data.errors.description + '').css("color", "red");
                        }else{
                            $('.has-danger-description').text('');
                        }

                        if (error.response.data.errors.syncPermissions) {
                            $('.has-danger-syncPermissions').text('' + error.response.data.errors.syncPermissions + '').show();
                        }else{
                            $('.has-danger-syncPermissions').text('').hide();
                        }
                    }else{
                        notify('Error, Intente nuevamente mas tarde.', 'danger', '5000', 'top', 'right');
                    }
                }else{
                    notify('Error, Intente nuevamente mas tarde.', 'danger', '5000', 'top', 'right');
                }
                $('.btn-role').prop("disabled", false).text('Actualizar');
                setTimeout(() => {$('.jimbo-loader').hide();}, 500);
        });
    });
    /*roles-edit*/

    /*alert-Role-delete*/
    $('body').on('click', '.deleteRole', function () {
        var url = $(this).data("url");
        swal({
                title: '¿Desea eliminar el Role?',
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
    /*alert-Role-delete*/
});
