<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();
        $request->session()->regenerate();

        /* $credentials = $request->only('email', 'password');
        $user = User::where('email', $request->email)->first();
        if ($user) {
            if ($user->active) {
                //if ($user->role=='administer' or $user->role=='super') {
                    if (Auth::attempt($credentials)) {
                        return response()->json(['success' => true, 'message' => 'Iniciando la sesión, redireccionando...', 'url' => url('dashboard')], 200);
                    }else {
                        return response()->json(['error' => true,  'message' => 'Accceso no autorizado, Error en las credenciales.'], 401);
                    }
                }else{
                    return response()->json(['error' => true,  'message' => 'Accceso no autorizado, verifique sus credenciales.'], 401);
                }
            }else {
                return response()->json(['error' => true,  'message' => 'Accceso no autorizado, Usuario Inactivo.'], 401);
            }
        }else {
            return response()->json(['error' => true,  'message' => 'Accceso no autorizado, Credenciales no existen.'], 401);
        } */
        return response()->json(['success' => true, 'message' => 'Iniciando la sesión, redireccionando...', 'url' => route('panel.dashboard')], 200);

        //return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json(['success' => true, 'message' => 'Sesión cerrada correctamente, redireccionando...', 'url' => url('login')], 200);

        //return redirect('/');
    }
}
