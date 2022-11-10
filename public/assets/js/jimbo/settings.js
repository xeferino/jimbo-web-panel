'use strict';
const APP_URL = $('meta[name="base-url"]').attr('content');
const JIMBO = { url : '/panel/settings' };
$(function () {
    $( document ).ready(function() {
        $("#editor").Editor();
        $("#editor").Editor("setText", $('#terms_and_conditions').val());
    });

    /*setting-register*/
    $(".form-setting").submit(function( event ) {
        $("#terms_and_conditions").val($("#editor").Editor("getText"));
        event.preventDefault();
        $('.jimbo-loader').show();
        $('.load-text').text('Enviando...');
        $('.btn-setting-jib').prop("disabled", true).text('Enviando...');
        $('.btn-setting-bonu').prop("disabled", true).text('Enviando...');
        $('.btn-setting-seller').prop("disabled", true).text('Enviando...');
        $('.btn-setting-seller-pencert').prop("disabled", true).text('Enviando...');
        $('.btn-setting-seller-pencert-group').prop("disabled", true).text('Enviando...');
        $('.btn-setting-seller-group').prop("disabled", true).text('Enviando...');
        $('.btn-setting-bonu-unique').prop("disabled", true).text('Enviando...');
        $('.btn-setting-bonu-ascent').prop("disabled", true).text('Enviando...');
        $('.btn-setting-term').prop("disabled", true).text('Enviando...');

        var formData = new FormData(event.currentTarget);

        axios.post($(this).attr('action'), formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        }).then(response => {
            if(response.data.success){
                notify(response.data.message, 'success', '3000', 'top', 'right');
                $('.btn-setting-jib').prop("disabled", false).text('Configurar');
                $('.btn-setting-bonu').prop("disabled", false).text('Configurar');
                $('.btn-setting-seller').prop("disabled", false).text('Configurar');
                $('.btn-setting-seller-pencent').prop("disabled", false).text('Configurar');
                $('.btn-setting-seller-group').prop("disabled", false).text('Configurar');
                $('.btn-setting-seller-pencent-group').prop("disabled", false).text('Configurar');
                $('.btn-setting-bonu-unique').prop("disabled", false).text('Configurar');
                $('.btn-setting-bonu-ascent').prop("disabled", false).text('Configurar');
                $('.btn-setting-term').prop("disabled", false).text('Configurar');

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
                    if (error.response.data.errors.jib_usd) {
                        $('.has-danger-jib_usd').text('' + error.response.data.errors.jib_usd + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-jib_usd').text('');
                    }

                    if (error.response.data.errors.register) {
                        $('.has-danger-register').text('' + error.response.data.errors.register + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-register').text('');
                    }

                    if (error.response.data.errors.referrals) {
                        $('.has-danger-referrals').text('' + error.response.data.errors.referrals + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-referrals').text('');
                    }

                    if (error.response.data.errors.to_access) {
                        $('.has-danger-to_access').text('' + error.response.data.errors.to_access + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-to_access').text('');
                    }

                    if (error.response.data.errors.level_single_junior) {
                        $('.has-danger-level_single_junior').text('' + error.response.data.errors.level_single_junior + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-level_single_junior').text('');
                    }

                    if (error.response.data.errors.level_single_middle) {
                        $('.has-danger-level_single_middle').text('' + error.response.data.errors.level_single_middle + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-level_single_middle').text('');
                    }

                    if (error.response.data.errors.level_single_master) {
                        $('.has-danger-level_single_master').text('' + error.response.data.errors.level_single_master + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-level_single_master').text('');
                    }

                    if (error.response.data.errors.level_percent_single_junior) {
                        $('.has-danger-level_percent_single_junior').text('' + error.response.data.errors.level_percent_single_junior + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-level_percent_single_junior').text('');
                    }

                    if (error.response.data.errors.level_percent_single_middle) {
                        $('.has-danger-level_percent_single_middle').text('' + error.response.data.errors.level_percent_single_middle + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-level_percent_single_middle').text('');
                    }

                    if (error.response.data.errors.level_percent_single_master) {
                        $('.has-danger-level_percent_single_master').text('' + error.response.data.errors.level_percent_single_master + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-level_percent_single_master').text('');
                    }

                    if (error.response.data.errors.level_group_junior) {
                        $('.has-danger-level_group_junior').text('' + error.response.data.errors.level_group_junior + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-level_group_junior').text('');
                    }

                    if (error.response.data.errors.level_group_middle) {
                        $('.has-danger-level_group_middle').text('' + error.response.data.errors.level_group_middle + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-level_group_middle').text('');
                    }

                    if (error.response.data.errors.level_group_master) {
                        $('.has-danger-level_group_master').text('' + error.response.data.errors.level_group_master + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-level_group_master').text('');
                    }

                    if (error.response.data.errors.level_percent_group_junior) {
                        $('.has-danger-level_percent_group_junior').text('' + error.response.data.errors.level_percent_group_junior + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-level_percent_group_junior').text('');
                    }

                    if (error.response.data.errors.level_percent_group_middle) {
                        $('.has-danger-level_percent_group_middle').text('' + error.response.data.errors.level_percent_group_middle + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-level_percent_group_middle').text('');
                    }

                    if (error.response.data.errors.level_percent_group_master) {
                        $('.has-danger-level_percent_group_master').text('' + error.response.data.errors.level_percent_group_master + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-level_percent_group_master').text('');
                    }

                    if (error.response.data.errors.level_classic_ascent_unique_bonus) {
                        $('.has-danger-level_classic_ascent_unique_bonus').text('' + error.response.data.errors.level_classic_ascent_unique_bonus + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-level_classic_ascent_unique_bonus').text('');
                    }

                    if (error.response.data.errors.level_classic_seller_percent) {
                        $('.has-danger-level_classic_seller_percent').text('' + error.response.data.errors.level_classic_seller_percent + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-level_classic_seller_percent').text('');
                    }

                    if (error.response.data.errors.level_classic_referral_bonus) {
                        $('.has-danger-level_classic_referral_bonus').text('' + error.response.data.errors.level_classic_referral_bonus + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-level_classic_referral_bonus').text('');
                    }

                    if (error.response.data.errors.level_classic_sale_percent) {
                        $('.has-danger-level_classic_sale_percent').text('' + error.response.data.errors.level_classic_sale_percent + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-level_classic_sale_percent').text('');
                    }

                    if (error.response.data.errors.level_ascent_bonus_single_junior) {
                        $('.has-danger-level_ascent_bonus_single_junior').text('' + error.response.data.errors.level_ascent_bonus_single_junior + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-level_ascent_bonus_single_junior').text('');
                    }

                    if (error.response.data.errors.level_ascent_bonus_single_middle) {
                        $('.has-danger-level_ascent_bonus_single_middle').text('' + error.response.data.errors.level_ascent_bonus_single_middle + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-level_ascent_bonus_single_middle').text('');
                    }

                    if (error.response.data.errors.level_ascent_bonus_single_master) {
                        $('.has-danger-level_ascent_bonus_single_master').text('' + error.response.data.errors.level_ascent_bonus_single_master + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-level_ascent_bonus_single_master').text('');
                    }

                    if (error.response.data.errors.terms_and_conditions) {
                        $('.has-danger-terms_and_conditions').text('' + error.response.data.errors.terms_and_conditions + '').css("color", "#dc3545e3");
                    }else{
                        $('.has-danger-terms_and_conditions').text('');
                    }
                }else{
                    notify('Error, Intente nuevamente mas tarde.', 'danger', '5000', 'bottom', 'right');
                }
            }else{
                notify('Error, Intente nuevamente mas tarde.', 'danger', '5000', 'bottom', 'right');
            }
            $('.btn-setting-jib').prop("disabled", false).text('Configurar');
            $('.btn-setting-bonu').prop("disabled", false).text('Configurar');
            $('.btn-setting-seller').prop("disabled", false).text('Configurar');
            $('.btn-setting-seller-percent').prop("disabled", false).text('Configurar');
            $('.btn-setting-seller-group').prop("disabled", false).text('Configurar');
            $('.btn-setting-seller-percent-group').prop("disabled", false).text('Configurar');
            $('.btn-setting-bonu-unique').prop("disabled", false).text('Configurar');
            $('.btn-setting-bonu-ascent').prop("disabled", false).text('Configurar');
            $('.btn-setting-term').prop("disabled", false).text('Configurar');
            setTimeout(() => {$('.jimbo-loader').hide();}, 500);
        });
    });
});
