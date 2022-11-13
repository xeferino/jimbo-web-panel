'use strict';
const APP_URL = $('meta[name="base-url"]').attr('content');
const JIMBO = { url : '/panel/cash-request' };
//alert(JIMBO.url)
$(function () {
    $('select').select2({
        dropdownParent: $('#modalContent')
    });
    /*DataTables*/
    var table = $('.table-cash').DataTable({
        processing: true,
        serverSide: true,
        order: [[0, 'desc']],
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
        ajax: APP_URL+JIMBO.url,
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
    /*DataTables*/

    $('body').on('click', '.changeStatu', function () {
        $('#modalContent').modal('show');
        $('.title-modal').text('Actualizar estado de la solicitud');
        $('#form-changeStatu').trigger("reset");
    });

     /*cash-changeStatu-request*/
     $("#form-changeStatu").submit(function( event ) {
        event.preventDefault();
        $('.btn-changeStatu').prop("disabled", true).text('Enviando...');

        var formData = new FormData(event.currentTarget);

        axios.post($(this).attr('action'), formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        }).then(response => {
            if(response.data.success){
                notify(response.data.message, 'success', '3000', 'top', 'right');
                $('#form-changeStatu').trigger("reset");
                $('.btn-changeStatu').prop("disabled", false).text('Actualizar');
                $('div.col-form-label').text('');
                $('#modalContent').modal('hide');
                setTimeout(() => {location.reload()}, 3000);
            }
        }).catch(error => {
            if (error.response) {
                if(error.response.status === 422){
                    var err = error.response.data.errors;
                    /* $.each(err, function( key, value) {
                        notify(value, 'danger', '5000', 'bottom', 'right');
                    }); */
                    if (error.response.data.errors.status) {
                        $('.has-danger-status').text('' + error.response.data.errors.status + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-status').text('');
                    }
                    if (error.response.data.errors.observation) {
                        $('.has-danger-observation').text('' + error.response.data.errors.observation + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-observation').text('');
                    }
                }else{
                    notify('Error, Intente nuevamente mas tarde.', 'danger', '5000', 'bottom', 'right');
                }
            }else{
                notify('Error, Intente nuevamente mas tarde.', 'danger', '5000', 'bottom', 'right');
            }
            $('.btn-changeStatu').prop("disabled", false).text('Actualizar');
        });
    });
    /* cash-changeStatu-request*/
});
