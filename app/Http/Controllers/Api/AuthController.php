<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use File;
use Exception;
use App\Http\Requests\FormRequestSignupUser;
use App\Http\Requests\FormRequestProfileUserSetting;
use App\Http\Requests\FormRequestForgotUser;
use App\Mail\RecoveryPassword;
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
        $this->asset = asset('/').'storage/';
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
                    'status'     => 401
                ], 401);
            }

            if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return response()->json([ 'message' => 'Credenciales de acceso invalidos', 'status' => 400 ], 400);
            }

            $accessToken = Auth::user()->createToken('AuthToken')->plainTextToken;

            return response()->json(
                [
                    'profile'    => [
                        'id'                => Auth::user()->id,
                        'name'              => Auth::user()->name,
                        'email'             => Auth::user()->email,
                        //'date_of_birth'     => Auth::user()->date_of_birth,
                        //'phone'             => Auth::user()->phone,
                        //'gender'            => Auth::user()->gender,
                        //'img'               => Auth::user()->avatar ? $this->asset.'profile/'.Auth::user()->avatar : $this->asset.'profile/400x400.png',
                    ],
                    'token'   => $accessToken,
                    'message' => "Bienvenido, ".Auth::user()->name,
                    'status'  => 200
                ],
                200
            );
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
            $user = new User;
            $user->name             = $request->name;
            $user->email            = $request->email;
            //$user->date_of_birth    = $request->date_of_birth;
            //$user->phone            = $request->phone;
            //$user->gender           = $request->gender;
            //$user->avatar           = ($request->avatar ? $request->avatar : '400x400.png');
            $user->password         = Hash::make($request->password);
            $user->save();

            Auth::attempt(['email' => $request->email, 'password' => $request->password]);

            $accessToken = Auth::user()->createToken('AuthToken')->plainTextToken;

            return response()->json([
                'profile'    => [
                    'id'                => Auth::user()->id,
                    'name'              => Auth::user()->name,
                    'email'             => Auth::user()->email,
                    //'date_of_birth'     => Auth::user()->date_of_birth,
                    //'email'             => Auth::user()->email,
                    //'phone'             => Auth::user()->phone,
                    //'gender'            => Auth::user()->gender,
                    //'img'               => Auth::user()->avatar ? $this->asset.'profile/'.Auth::user()->avatar : $this->asset.'profile/400x400.png',
                ],
                'token'    => $accessToken,
                'message'  => 'Bienvenido, '.$user->name,
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
                        'id'                => Auth::user()->id,
                        'name'              => Auth::user()->name,
                        'email'             => Auth::user()->email,
                        //'date_of_birth'     => Auth::user()->date_of_birth,
                        //'phone'             => Auth::user()->phone,
                        //'gender'            => Auth::user()->gender,
                        //'img'               => Auth::user()->avatar ? $this->asset.'profile/'.Auth::user()->avatar : $this->asset.'profile/400x400.png',
                        //'colors'            => Auth::user()->Colors
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
                'status'   => 400,
                'message' =>  $e->getMessage()
            ], 400);
        }
    }

    /**
     * Display profile dada.
     *
     * @return \Illuminate\Http\Response
     */
    public function settingProfile(FormRequestProfileUserSetting $request)
    {
        try {
            $user = User::find(Auth::user()->id);
            $user->name             = $request->name;
            $user->email            = $request->email;
            $user->date_of_birth    = $request->date_of_birth;
            $user->phone            = $request->phone;
            $user->gender           = $request->gender;
            if ($request->has('password_new') && isset($request->password_new)){
                $user->password = Hash::make($request->password_new);
            }

            if ($request->has('img') && isset($request->img)) {
                if ($user->avatar != "400x400.png") {
                    if (Storage::disk('public')->exists('profile/'.$user->avatar))
                    {
                        Storage::disk('public')->delete('profile/'.$user->avatar);
                    }
                }
                $image_64 = $request->img;
                $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];
                $replace = substr($image_64, 0, strpos($image_64, ',')+1);
                $image = str_replace($replace, '', $image_64);
                $image = str_replace(' ', '+', $image);
                //$imageName = Str::random(10).'.'.$extension;
                $imageName = Str::random(10).'.png';
                Storage::disk('public')->put('profile/'.$imageName, base64_decode($image));
                $user->avatar = $imageName;
            }

            if ($user->save()) {
                return response()->json([
                    'profile'    => [
                        'id'                => $user->id,
                        'name'              => $user->name,
                        'email'             => $user->email,
                        'date_of_birth'     => $user->date_of_birth,
                        'email'             => $user->email,
                        'phone'             => $user->phone,
                        'gender'            => $user->gender,
                        'img'               => $user->avatar ? $this->asset.'profile/'.$user->avatar : $this->asset.'profile/400x400.png',
                        'colors'            => $user->Colors
                    ],
                    'status' => 200,
                    'message' => $user->name.'!, Perfil actualizado',
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'status'   => 400,
                'message' =>  $e->getMessage()
            ], 400);
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

                Mail::to($user->email)->send(new RecoveryPassword($data));
                $user->password = Hash::make($data['password']);
                $user->save();
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
                'status'   => 400,
                'message' =>  $e->getMessage()
            ], 400);
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
                'status'   => 400,
                'message' =>  $e->getMessage()
            ], 400);
        }
    }
}
