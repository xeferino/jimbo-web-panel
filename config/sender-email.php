<?php

$emails = [
    'email_registration'    => 'registro@jimbosorteos.com',
    'email_reset_password'  => 'password@jimbosorteos.com',
    'email_verified_at'     => 'email@jimbosorteos.com',
    'email_receipt_payment' => 'email@jimbosorteos.com',
];

if (env('MAIL_MAILER_OPTION') == 'testing')
{
    $emails = [
        'email_registration'    => 'info@jimbosorteos.com',
        'email_reset_password'  => 'info@jimbosorteos.com',
        'email_verified_at'     => 'info@jimbosorteos.com',
        'email_receipt_payment' => 'info@jimbosorteos.com',
    ];
}

return [

    /*
    |--------------------------------------------------------------------------
    | Emails from the Fudeat app
    |--------------------------------------------------------------------------
    |
    |
    */

    //Events
    'events' => [
        'notif_user_registration_email_from'     => $emails['email_registration'],
        'notif_user_reset_password_email_from'   => $emails['email_reset_password'],
        'notif_user_verified_email_from'         => $emails['email_verified_at'],
        'notif_user_receipt_payment_email_from'  => $emails['email_receipt_payment'],
    ]
];
