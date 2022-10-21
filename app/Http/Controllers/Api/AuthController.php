<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BalanceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use File;
use Exception;
use App\Http\Requests\FormRequestSignupUser;
use App\Http\Requests\FormRequestProfileUserSetting;
use App\Http\Requests\FormRequestForgotUser;
use App\Http\Requests\FormRequestRecoveryPasswordUser;
use App\Http\Requests\FormRequestVerifiedEmailUser;
use App\Mail\RecoveryPassword;
use App\Mail\VerifiedEmail;
use App\Mail\RegisterUser;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    private $asset;
    private $data;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->asset = config('app.url').'/assets/images/';
        $this->data = [];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $error = [];

        $formData = $request->all();
        try {

            if (!isset($formData['email'])) {
                $error['email'] = "El campo email es requerido";
            }

            if (!isset($formData['password'])) {
                $error['password'] = "El campo password es requerido";
            }

            if (count($error) > 0) {
                return response()->json([
                    'message'    => 'Por favor completa los datos de acceso',
                    'errors'     => $error,
                    'status'     => 422
                ], 422);
            }

            $user = User::where('email', $request->email)->first();
            if ($user) {
                if ($user->hasRole('seller') or $user->hasRole('competitor')) {
                    if (! Auth::attempt(array_merge( $request->only('email', 'password'), ['active' => 1 ]))) {
                        return response()->json([ 'message' => 'Credenciales de acceso invalidos', 'status' => 422 ], 422);
                    }

                    $accessToken = $user->createToken('AuthToken')->plainTextToken;
                    $balance = config('jibs.bonus.to_access') + $user->balance_jib ?? 0;
                    $user->save();
                    BalanceController::store('Bono de ingreso a la aplicacion', 'credit', $balance, 'jib', $user->id);
                    $user = User::find($user->id);
                    return response()->json(
                        [
                            'profile'    => [
                                'id'           => $user->id,
                                'name'         => $user->name,
                                'email'        => $user->email,
                                'dni'          => $user->dni,
                                'phone'        => $user->phone,
                                'usd'          => $user->balance_usd,
                                'jib'          => $user->balance_jib,
                                'image'        => $user->image != 'avatar.svg' ? $this->asset.'users/'.$user->image : $this->asset.'avatar.svg',
                                'country'      => [
                                    'id'    => $user->country->id,
                                    'name'  => $user->country->name,
                                    'code'  => $user->country->code,
                                    'icon'  => $user->country->img != 'flag.png' ? $this->asset.'flags/'.$user->country->img : $this->asset.'flags/flag.png'
                                ]
                            ],
                            'token'   => $accessToken,
                            'message' => "Bienvenido a Jimbo, ".$user->name,
                            'status'  => 200
                        ],
                        200
                    );
                }
            }
            return response()->json([ 'message' => 'Credenciales de acceso invalidos', 'status' => 422 ], 422);
        } catch (Exception $e) {
            return response()->json([
                'status'   => 500,
                'message' =>  $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function signup(FormRequestSignupUser $request)
    {
        try {
            $user = new User();
            $user->name             = $request->name;
            $user->email            = $request->email;
            $user->dni              = $request->dni;
            $user->phone            = $request->phone;
            $user->country_id       = $request->country_id;
            $user->password         = Hash::make($request->password);
            $user->image            = 'avatar.svg';
            $user->save();
            $user->assignRole('competitor');
            BalanceController::store('Bono de registro en la aplicacion', 'credit', config('jibs.bonus.register'), 'jib', $user->id);

            $data = [
                'user'  => $user,
                'code'  => date('Y').$user->id.date('m').date('d')
            ];

            Mail::to($user->email)->send(new RegisterUser($data));
            Mail::to($user->email)->send(new VerifiedEmail($data));

            $accessToken = $user->createToken('AuthToken')->plainTextToken;
            $user = User::find($user->id);
            return response()->json([
                'profile'    => [
                    'id'           => $user->id,
                    'name'         => $user->name,
                    'email'        => $user->email,
                    'dni'          => $user->dni,
                    'phone'        => $user->phone,
                    'usd'          => $user->balance_usd,
                    'jib'          => $user->balance_jib,
                    'email_verified_at' => $user->email_verified_at,
                    'image'        => $user->image != 'avatar.svg' ? $this->asset.'users/'.$user->image : $this->asset.'avatar.svg',
                    'country'      => [
                        'id'    => $user->country->id,
                        'name'  => $user->country->name,
                        'code'  => $user->country->code,
                        'icon'  => $user->country->img != 'flag.png' ? $this->asset.'flags/'.$user->country->img : $this->asset.'flags/flag.png'
                    ]
                ],
                'token'    => $accessToken,
                'message'  => 'Bienvenido a Jimbo, '.$user->name,
                'status'   => 200
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status'   => 500,
                'message' =>  $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function profile($id)
    {
        try {
            $user = User::find($id);
            if ($user) {
                return response()->json([
                    'profile'    => [
                        'id'           => $user->id,
                        'name'         => $user->name,
                        'email'        => $user->email,
                        'dni'          => $user->dni,
                        'phone'        => $user->phone,
                        'usd'          => $user->balance_usd,
                        'jib'          => $user->balance_jib,
                        'email_verified_at' => $user->email_verified_at,
                        'image'        => $user->image != 'avatar.svg' ? $this->asset.'users/'.$user->image : $this->asset.'avatar.svg',
                        'country'      => [
                            'id'    => $user->country->id,
                            'name'  => $user->country->name,
                            'code'  => $user->country->code,
                            'icon'  => $user->country->img != 'flag.png' ? $this->asset.'flags/'.$user->country->img : $this->asset.'flags/flag.png'
                        ]
                    ],
                    'status'   => 200
                ], 200);
            }
            return response()->json([
                'status'   => 404,
                'message' =>  'perfil de usuario no encontrado'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status'   => 500,
                'message' =>  $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display profile dada.
     *
     * @return \Illuminate\Http\Response
     */
    public function settingProfile(FormRequestProfileUserSetting $request, User $User, $id)
    {
        try {
            $user                   = User::find($id);
            $user->name             = $request->name;
            $user->email            = $request->email;
            $user->dni              = $request->dni;
            $user->phone            = $request->phone;

            if($request->password){
                $user->password     = Hash::make($request->password);
            }

            if($request->file('image')){
                if ($user->image != "avatar.svg") {
                    if (File::exists(public_path('assets/images/users/' . $user->image))) {
                        File::delete(public_path('assets/images/users/' . $user->image));
                    }
                }

                $file           = $request->file('image');
                $extension      = $file->getClientOriginalExtension();
                $fileName       = time() . '.' . $extension;
                $user->image      = $fileName;
                $file->move(public_path('assets/images/users/'), $fileName);
            }

            if ($user->save()) {
                return response()->json([
                    'profile'    => [
                        'id'           => $user->id,
                        'name'         => $user->name,
                        'email'        => $user->email,
                        'dni'          => $user->dni,
                        'phone'        => $user->phone,
                        'usd'          => $user->balance_usd,
                        'jib'          => $user->balance_jib,
                        'email_verified_at' => $user->email_verified_at,
                        'image'        => $user->image != 'avatar.svg' ? $this->asset.'users/'.$user->image : $this->asset.'avatar.svg',
                        'country'      => [
                            'id'    => $user->country->id,
                            'name'  => $user->country->name,
                            'code'  => $user->country->code,
                            'icon'  => $user->country->img != 'flag.png' ? $this->asset.'flags/'.$user->country->img : $this->asset.'flags/flag.png'
                        ]
                    ],
                    'status' => 200,
                    'message' => $user->name.'!, Perfil actualizado',
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'status'   => 500,
                'message' =>  $e->getMessage()
            ], 500);
        }
    }

    /**
     * Recover password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function forgot(FormRequestForgotUser $request)
    {
        try {
            $data = [];
            $user = User::where('email', $request->email)->first();

            if ($user) {

                $data = [
                    'user'      => $user,
                    'password'  => date('Y').$user->id.date('m').date('d')
                ];

                $user->code = $data['password'];
                $user->save();

                Mail::to($user->email)->send(new RecoveryPassword($data));
                return response()->json([
                    'status'   => 200,
                    'message' =>  'You have been send successfully email recovery password.'
                ], 200);
            }
            return response()->json([
                'status'   => 404,
                'message' =>  'El email igresado no existe!.'
            ], 404);

        } catch (Exception $e) {
            return response()->json([
                'status'   => 500,
                'message' =>  $e->getMessage()
            ], 500);
        }
    }

    /**
     * Recover password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function RecoveryPassword(FormRequestRecoveryPasswordUser $request)
    {
        try {
            $data = [];
            $user = User::where('email', $request->email)->where('code', $request->code)->first();

            if ($user) {
                $user->password = Hash::make($request->password);
                $user->save();
                return response()->json([
                    'status'   => 200,
                    'message' =>  'Su contraseña ha sido recuperada exitosamente!'
                ], 200);
            }
            return response()->json([
                'status'   => 404,
                'message' =>  'El email igresado no existe!.'
            ], 404);

        } catch (Exception $e) {
            return response()->json([
                'status'   => 500,
                'message' =>  $e->getMessage()
            ], 500);
        }
    }

    /**
     * send code email_verified_at.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendCodeVerifiedEmail(FormRequestVerifiedEmailUser $request)
    {
        try {
            $data = [];
            $user = User::where('email', $request->email)->first();

            if ($user) {
                $data = [
                    'user'  => $user,
                    'code'  => date('Y').$user->id.date('m').date('d')
                ];

                $user->code = $data['code'];
                $user->save();

                Mail::to($user->email)->send(new VerifiedEmail($data));
                return response()->json([
                    'status'   => 200,
                    'message' =>  'Su codigo de verificacion ha sido enviado exitosamente!'
                ], 200);
            }
            return response()->json([
                'status'   => 404,
                'message' =>  'El email igresado no existe!.'
            ], 404);

        } catch (Exception $e) {
            return response()->json([
                'status'   => 500,
                'message' =>  $e->getMessage()
            ], 500);
        }
    }

    /**
     * Recover email_verified_at.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function verifiedEmail(FormRequestVerifiedEmailUser $request)
    {
        try {
            $data = [];
            $user = User::where('email', $request->email)->where('code', $request->code)->first();

            if ($user) {
                $user->email_verified_at = now();
                $user->save();
            }
            return response()->json([
                'status'   => 404,
                'message' =>  'El email igresado no existe!.'
            ], 404);

        } catch (Exception $e) {
            return response()->json([
                'status'   => 500,
                'message' =>  $e->getMessage()
            ], 500);
        }
    }

    /**
     * Destroy session in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout($id)
    {
        try {
            $user = User::find($id);
            $user->tokens()->where('tokenable_id', $id)->delete();

            return response()->json([
                'status'   => 200,
                'message' =>  'You have been successfully logged out.'
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status'   => 500,
                'message' =>  $e->getMessage()
            ], 500);
        }
    }
}
