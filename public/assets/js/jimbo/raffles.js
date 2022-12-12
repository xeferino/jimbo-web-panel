'use strict';
const APP_URL = $('meta[name="base-url"]').attr('content');
const JIMBO = { url : '/panel/raffles' };
const JIMBO_AJAX = { url : '/panel/ajax/raffles' };

jQuery(document).ready(function() {

    $("#cash_to_draw, #prize_1, #prize_2, #prize_3, #prize_4, #prize_5, #prize_6, #prize_7, #prize_8, #prize_9, #prize_10").change(function (e) {

        var cash_to_draw = $('#cash_to_draw').val()!=0 ? parseFloat($('#cash_to_draw').val()) : 0;
        var prize_1 = $('#prize_1').val()!=0 ? parseFloat($('#prize_1').val()) : 0;
        var prize_2 = $('#prize_2').val()!=0 ? parseFloat($('#prize_2').val()) : 0;
        var prize_3 = $('#prize_3').val()!=0 ? parseFloat($('#prize_3').val()) : 0;
        var prize_4 = $('#prize_4').val()!=0 ? parseFloat($('#prize_4').val()) : 0;
        var prize_5 = $('#prize_5').val()!=0 ? parseFloat($('#prize_5').val()) : 0;
        var prize_6 = $('#prize_6').val()!=0 ? parseFloat($('#prize_6').val()) : 0;
        var prize_7 = $('#prize_7').val()!=0 ? parseFloat($('#prize_7').val()) : 0;
        var prize_8 = $('#prize_8').val()!=0 ? parseFloat($('#prize_8').val()) : 0;
        var prize_9 = $('#prize_9').val()!=0 ? parseFloat($('#prize_9').val()) : 0;
        var prize_10 = $('#prize_10').val()!=0 ? parseFloat($('#prize_10').val()) : 0;
        var gateway_percentage = $('#percent').val()!=0 ? parseFloat($('#percent').val()) : 0;

        var percent = prize_1+prize_2+prize_3+prize_4+prize_5+prize_6+prize_7+prize_8+prize_9+prize_10;
        //var amount = Math.round((percent/100)*cash_to_draw) + Math.round((gateway_percentage/100)*cash_to_draw);
        var amount = Math.round((percent/100)*cash_to_draw);

        //gateway_percentage = Math.round((percent/100)*cash_to_draw)

        $('#cash_to_collect').val(amount);
    });

    const promotions = [];
    /*DataTables*/
    var table = $('.table-raffle').DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        scrollX: true,
        scrollY: "50vh",
        scrollCollapse: true,
        order: [[0, 'desc']],
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
        dom: 'lBfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [ 0,1,2,3,4,5,6,7,8,10 ]
                },
                filename: function() {
                    return "Reportes-de-sorteos"
                },
                title: "Reportes de sorteos"
            },
            {
                extend: 'csvHtml5',
                exportOptions: {
                    columns: [ 0,1,2,3,4,5,6,7,8,10 ]
                },
                filename: function() {
                    return "Reportes-de-sorteos"
                },
                title: "Reportes de sorteos"
            }
        ],
        ajax: {
            url: APP_URL+JIMBO.url,
            data: function (d) {
                d.public           = $('#public').val(),
                d.active           = $('#active').val(),
                d.finish           = $('#finish').val(),
                d.type             = $('#type').val(),
                d.title            = $('#title').val(),
                d.cash_to_draw     = $('#cash_to_draw').val(),
                d.cash_to_collect  = $('#cash_to_collect').val(),
                d.date_start       = $('#date_start').val(),
                d.date_end         = $('#date_end').val()
              }
          },
        columns: [
            {data: 'id', name: 'id'},
            {data: 'title', name: 'title'},
            {data: 'cash_to_draw', name: 'cash_to_draw'},
            //{data: 'cash_to_collect', name: 'cash_to_collect'},
            {data: 'progress', name: 'progress'},
            {data: 'date_start', name: 'date_start'},
            {data: 'date_end', name: 'date_end'},
            {data: 'date_release', name: 'date_release'},
            {data: 'type', name: 'type'},
            {data: 'public', name: 'public'},
            {data: 'active', name: 'active'},
            {data: 'finish', name: 'finish'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    $("#form-raffle-filter").submit(function( event ) {
        event.preventDefault();
        table.draw();
    });

    $('#form-raffle-filter').each(function () {
        var form = $(this),
            reset = form.find(':reset'),
            inputs = form.find(':input');
        reset.on('click', function () {
          setTimeout(function () {
            //inputs.trigger('change');
            $('select').select2('');
            table.draw();
          }, 50);
        });
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

                    if (error.response.data.errors.date_release) {
                        $('.has-danger-date_release').text('' + error.response.data.errors.date_release + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-date_release').text('');
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

                    if (error.response.data.errors.type) {
                        $('.has-danger-type').text('' + error.response.data.errors.type + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-type').text('');
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

                    if (error.response.data.errors.promotions_raffle) {
                        $('.has-danger-promotions_raffle').text('' + error.response.data.errors.promotions_raffle + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-promotions_raffle').text('');
                    }

                    if (error.response.data.errors.promotions) {
                        $('.has-danger-promotions').text('' + error.response.data.errors.promotions + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-promotions').text('');
                    }

                    if (error.response.data.errors.quantity) {
                        $('.has-danger-quantity').text('' + error.response.data.errors.quantity + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-quantity').text('');
                    }


                    if (error.response.data.errors.total) {
                        $('.has-danger-total').text('' + error.response.data.errors.total + '$').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-total').text('');
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

    var raffle_id = $('#raffle_id').val();
    if (raffle_id>0){
        getpromotions(raffle_id);
    }
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

                    if (error.response.data.errors.date_release) {
                        $('.has-danger-date_release').text('' + error.response.data.errors.date_release + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-date_release').text('');
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

                    if (error.response.data.errors.type) {
                        $('.has-danger-type').text('' + error.response.data.errors.type + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-type').text('');
                    }

                    if (error.response.data.errors.days_extend) {
                        $('.has-danger-days_extend').text('' + error.response.data.errors.days_extend + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-days_extend').text('');
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

                    if (error.response.data.errors.promotions_raffle) {
                        $('.has-danger-promotions_raffle').text('' + error.response.data.errors.promotions_raffle + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-promotions_raffle').text('');
                    }

                    if (error.response.data.errors.promotions) {
                        $('.has-danger-promotions').text('' + error.response.data.errors.promotions + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-promotions').text('');
                    }

                    if (error.response.data.errors.quantity) {
                        $('.has-danger-quantity').text('' + error.response.data.errors.quantity + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-quantity').text('');
                    }


                    if (error.response.data.errors.total) {
                        $('.has-danger-total').text('' + error.response.data.errors.total + '$').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-total').text('');
                    }

                }else{
                    notify('Error, Intente nuevamente mas tarde.', 'danger', '5000', 'bottom', 'right');
                }
            }else{
                notify('Error, Intente nuevamente mas tarde.', 'danger', '5000', 'bottom', 'right');
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
                            notify(response.data.message, 'warning', '5000', 'top', 'right');
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

    /*create promotions*/
    $(".add-promotion").click(function( event ) {
        event.preventDefault();

        var prom_name = $("#promotions").select2('data')[0]['text'];
        var promotion = $("#promotions").select2('val').split("-")[0];
        var ticket    = $("#promotions").select2('val').split("-")[1];
        var price     = $("#promotions").select2('val').split("-")[2];
        var serial    = $("#promotions").select2('val').split("-")[3];
        var quantity  = $("#quantity").val();

        if(promotion == '' || promotion == null){
            console.log(promotions);
            $('.has-danger-promotions').text('seleccione una opcion para crear promociones de boletos').css("color", "red");
        } else if (quantity == '' ||  quantity == 0) {
            $('.has-danger-quantity').text('La cantidad debe ser mayor a cero').css("color", "red");
        } else if (quantity>0 && (quantity % ticket) != 0) {
            var message = "La cantidad de boletos debe ser multiplo de "+ticket+" para la promocion ("+prom_name+").";
            notify(message, 'danger', '5000', 'bottom', 'right');
        } else{
            var valid = 0;
            $.each(promotions, function(key, value) {
                if(value.id == promotion){
                    valid = 1;
                }
            });
            if(valid){
                $('.has-danger-promotions').text('el item seleccionado, ya esta igresado en la creacion de los boletos para el sorteo.').css("color", "red");
            }else{
                $('.has-danger-promotions').text('');
                $('.has-danger-quantity').text('');

                promotions.push({
                    'id' : promotion,
                    'promotion' : prom_name,
                    'ticket' : quantity,
                    'quantity' : ticket,
                    'price' : price,
                    'serial': serial,
                });
                console.log(promotions);
                writePromotions(promotions);
                $('#promotions_raffle').val(JSON.stringify(promotions));
            }
        }
    });
    /*create promotions*/

    /*delete promotions*/
    $('body').on('click', '.delete', function(e){
        var index = $(this).data('id');
        promotions.splice(index, 1);
        console.log(promotions);
        writePromotions(promotions);
    });
    /*delete promotions*/

    /*create promotions*/
    $(".add-promotion-new").click(function( event ) {
        var promotion    = $("#promotions").select2('val');
        var quantity  = $("#quantity").val();

        if(promotion == '' || promotion == null){
            notify('Jimbo panel notifica: seleccione una opcion para crear promociones de boletos.', 'danger', '5000', 'bottom', 'right');
        } else if (quantity == '' ||  quantity == 0) {
            notify('Jimbo panel notifica: La cantidad es obligatoria y debe ser mayor a cero.', 'danger', '5000', 'bottom', 'right');
        } else {
            axios({
                method:'POST',
                url:APP_URL+JIMBO_AJAX.url+'/promotions/add',
                data:{
                    'raffle_id':$('#raffle_id').val(),
                    'promotion_id' : $("#promotions").select2('val'),
                    'quantity': $("#quantity").val()
                },
            }).then(response => {
                if(response.data.success){
                    notify(response.data.message, 'success', '5000', 'bottom', 'right');
                    getpromotions($('#raffle_id').val());
                }else {
                    notify(response.data.message, 'danger', '5000', 'bottom', 'right');
                }
            }).catch(error => {
                if (error.response) {
                    notify('Error, Intente nuevamente mas tarde.', 'danger', '5000', 'bottom', 'right');
                }else{
                    notify('Error, Intente nuevamente mas tarde.', 'danger', '5000', 'bottom', 'right');
                }
            });
        }

    });

    $('body').on('click', '.deletePromotion', function () {
        var id = $(this).data("id");
        swal({
                title: '¿Desea eliminar la promocion del sorteo?',
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
                    axios({
                        method:'POST',
                        url:APP_URL+JIMBO_AJAX.url+'/promotions/delete',
                        data:{
                            'id':id
                        },
                    }).then(response => {
                        if(response.data.success){
                            notify(response.data.message, 'success', '3000', 'bottom', 'right');
                            getpromotions($('#raffle_id').val());
                        }else {
                            notify(response.data.message, 'danger', '3000', 'bottom', 'right');
                        }
                    }).catch(error => {
                        if (error.response) {
                            notify('Error, Intente nuevamente mas tarde.', 'danger', '5000', 'bottom', 'right');
                        }else{
                            notify('Error, Intente nuevamente mas tarde.', 'danger', '5000', 'bottom', 'right');
                        }
                    });
                } else {
                    swal.close();
                }
            });
    });
    /*create promotions*/
});

function writePromotions(promotions){
    $('.add-input-content').html(function(){
        var items = '';
        items += `<div class="card-block table-border-style">
                    <div class="table-responsive">
                        <table class="table table-hover table-user">
                            <thead>
                                <th>#</th>
                                <th>Promocion</th>
                                <th>Boletos</th>
                                <th>Conjuntos</th>
                                <th>Aciones</th>
                            </thead>
                            <tbody>`;
                                var i = 1;
                                var total = 0;
                                    $.each(promotions, function(key, value) {
                                    items +=     `<tr>
                                                        <td>${i++}</td>
                                                        <td>${value.promotion}</td>
                                                        <td>${value.ticket}</td>
                                                        <td>${value.ticket/value.quantity}</td>
                                                        <td align="center">
                                                            <button type="button" class="btn btn-danger btn-sm delete" data-id="${key}">
                                                                <i class="ti-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>`;
                                        total += (value.ticket/value.quantity)*value.price;
                                    });
                            items +=`<tr>
                                        <td colspan="4" bgcolor="#e9ecef" align="right"><b>Total boleteria</b></td>
                                        <td bgcolor="#e9ecef">${total}$</td>
                                    </tr>`;
                    items +=`</tbody>
                        </table>
                    </div>
                </div>`;
                $('#total').val(total);
        return items;
    });
}

function getpromotions(id){

    axios({
        method:'POST',
        url:APP_URL+JIMBO_AJAX.url+'/promotions',
        data:{'id':id},
    }).then(response => {
        if(response.data.success){
            //console.log(data.promotions);
            $('.add-input-content').html(function(){
                var items = '';
                items += `<div class="card-block table-border-style">
                            <div class="table-responsive">
                                <table class="table table-hover table-user">
                                    <thead>
                                        <th>#</th>
                                        <th>Promocion</th>
                                        <th>Boletos</th>
                                        <th>Conjuntos</th>
                                        <th>Aciones</th>
                                    </thead>
                                    <tbody>`;
                                        var i = 1;
                                        var total = 0;
                                            $.each(response.data.promotions, function(key, value) {
                                            items +=     `<tr>
                                                                <td>${i++}</td>
                                                                <td>${value.promotion.name}</td>
                                                                <td>${value.quantity}</td>
                                                                <td>${value.quantity/value.promotion.quantity}</td>
                                                                <td align="center">
                                                                    <button type="button" class="btn btn-danger btn-sm deletePromotion" data-id="${value.id}">
                                                                        <i class="ti-trash"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>`;
                                                total += (value.quantity/value.promotion.quantity)*value.promotion.price;
                                            });
                                    items +=`<tr>
                                                <td colspan="4" bgcolor="#e9ecef" align="right"><b>Total boleteria</b></td>
                                                <td bgcolor="#e9ecef">${total}$</td>
                                            </tr>`;
                            items +=`</tbody>
                                </table>
                            </div>
                        </div>`;
                        $('#total').val(total);
                return items;
            });
        }
    }).catch(error => {
        if (error.response) {
            notify('Error, Intente nuevamente mas tarde.', 'danger', '5000', 'bottom', 'right');
        }else{
            notify('Error, Intente nuevamente mas tarde.', 'danger', '5000', 'bottom', 'right');
        }
    });
}
