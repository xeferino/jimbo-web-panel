<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPassword;
use App\Models\User;
class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $request->only('email'))->first();
        $status = null;
        if($user) {
            // We will send the password reset link to this user. Once we have attempted
            // to send the link, we will examine the response then see the message we
            // need to show to the user. Finally, we'll send out a proper response.
            /* $status = Password::sendResetLink(
                ['email' => $user->email]
            ); */
            $token = \Illuminate\Support\Facades\Password::broker('users')->createToken($user);
            $url = route('password.reset', $token) . '?email=' . $user->email;
            $status = Mail::to($user->email)->queue(new ResetPassword($url, $user->email));
        }
        return $status == "0"
        ? response()->json(['success' => true, 'message' => 'El link de acceso fue enviado exitosamente!'], 200)
        : response()->json(['success' => false, 'message' => 'No podemos encontrar un usuario con esa dirección de correo electrónico.'], 200);

        /* return $status == Password::RESET_LINK_SENT
                    ? response()->json(['success' => true, 'message' => 'El link de acceso fue enviado exitosamente!'], 200)
                    : response()->json(['success' => false, 'message' => 'No podemos encontrar un usuario con esa dirección de correo electrónico.'], 200); */
    }
}
