<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BalanceController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\Api\NotificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use File;
use Exception;
use App\Http\Requests\Api\FormRequestSignup;
use App\Http\Requests\Api\FormRequestProfile;
use App\Http\Requests\Api\FormRequestForgot;
use App\Http\Requests\Api\FormRequestRecoveryPassword;
use App\Http\Requests\Api\FormRequestVerifiedEmail;
use App\Services\CulqiService as Culqi;
use App\Mail\RecoveryPassword;
use App\Mail\VerifiedEmail;
use App\Mail\RegisterUser;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Customer;
use App\Models\LevelUser;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Helpers\Helper;
use Illuminate\Support\Carbon;
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
        $this->asset  = config('app.url').'/assets/images/';
        $this->avatar = asset('/').'storage/';
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
                    $balance = SettingController::bonus()['bonus']['to_access'] ?? 0;
                    $user->save();
                    if($user->type == 1) {
                        BalanceController::store('Bono de ingreso a la aplicacion', 'credit', $balance, 'jib', $user->id);
                        NotificationController::store('Bono de ingreso a la aplicacion', 'Bono de '.$balance.' jibs', $user->id);
                    }
                    NotificationController::store('Hola, '.$user->email.' has accedido a jimbo!','has iniciado sesion en nuestra App!', $user->id);

                    $user = User::find($user->id);

                    $level = "Usuario";
                    if(isset($user->LevelSeller->level->name) && $user->LevelSeller->level->name == 'classic') {
                        $level = 'Clasico';
                    }elseif(isset($user->LevelSeller->level->name) && $user->LevelSeller->level->name == 'junior') {
                        $level = 'Junior';
                    }elseif(isset($user->LevelSeller->level->name) && $user->LevelSeller->level->name == 'middle') {
                        $level = 'Semi Senior';
                    }elseif(isset($user->LevelSeller->level->name) && $user->LevelSeller->level->name == 'master') {
                        $level = 'Senior';
                    }

                    $image = $this->asset.'avatar.svg';
                    if ($user->image != 'avatar.svg' && $user->type == 2) {
                        $image = $this->asset.'sellers/'.$user->image;
                    } elseif ($user->image != 'avatar.svg' && $user->type == 1) {
                        $image = $this->asset.'competitors/'.$user->image;
                    }

                    return response()->json(
                        [
                            'profile'    => [
                                'id'                => $user->id,
                                'names'             => $user->names,
                                'surnames'          => $user->surnames,
                                'email'             => $user->email,
                                'dni'               => $user->dni,
                                'phone'             => $user->phone,
                                'address'           => $user->address,
                                'address_city'      => $user->address_city,
                                'usd'               => Helper::amount($user->balance_usd),
                                'jib'               => Helper::jib($user->balance_jib),
                                'jib_rate'          => SettingController::jib()['value']['jib_usd'],
                                'balance_jib'       => $user->balance_jib,
                                'balance_usd'       => $user->balance_usd,
                                'amount_shopping'   => Helper::amount($user->Shoppings->sum('amount')),
                                'shoppings'         => $user->Shoppings->count(),
                                'amount_sale'       => Helper::amount($user->Sales->sum('amount')),
                                'sales'             => $user->Sales->count(),
                                'guests_month'      => Carbon::now()->locale('es')->translatedFormat('F').' ('.LevelUser::where('referral_id', $user->id)->whereMonth('created_at', date('m'))->count().')',
                                'guests'            => count(User::Guests($user->id)),
                                'guests_list'       => User::Guests($user->id),
                                'email_verified_at' => $user->email_verified_at,
                                'code_referral'     => $user->code_referral,
                                'role'              => count($user->getRoleNames()) > 1 ? $user->getRoleNames()->join(',') : $user->getRoleNames()->join(''),
                                'seller'            => $user->type == 2 ? true : false,
                                'level'             => $level,
                                'status'            => 'Activo',
                                'become_seller'     => $user->become_seller == 1 ? true : false,
                                'image'             => $image,
                                'country'      => [
                                    'id'    => $user->country->id,
                                    'name'  => $user->country->name,
                                    'iso'   => $user->country->iso,
                                    'code'  => $user->country->code,
                                    'icon'  => $user->country->img != 'flag.png' ? $this->asset.'flags/'.$user->country->img : $this->asset.'flags/flag.png'
                                ]
                            ],
                            'token'   => $accessToken,
                            'message' => "Bienvenido a Jimbo, ".$user->names,
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
    public function signup(FormRequestSignup $request)
    {
        try {
            $user = new User();
            $user->names            = $request->names;
            $user->surnames         = $request->surnames;
            $user->email            = $request->email;
            $user->dni              = $request->dni;
            $user->phone            = $request->phone;
            $user->country_id       = $request->country_id;
            $user->code_referral    = substr(sha1(time()), 0, 8);
            $user->password         = Hash::make($request->password);
            $user->image            = 'avatar.svg';
            $user->type             = 1;
            $user->save();
            $user->assignRole('competitor');

            $balance = SettingController::bonus()['bonus']['to_access'] ?? 0;


            if($user->type == 1) {
                BalanceController::store('Bono de registro en la aplicacion', 'credit', $balance, 'jib', $user->id);
                $notification = NotificationController::store('Bono de regitro en la aplicacion', 'Bono de '.$balance.' jibs', $user->id);
                $notification = NotificationController::store('Hola, '.$user->email.' bienvenido a jimbo!', 'Felicidades, ahora eres parte de la familia jimbo sorteos', $user->id);
            }

            if ($request->has('code_referral') && $request->has('code_referral') != '') {
                $referral = User::where('code_referral', $request->code_referral)->first();
                if ($referral) {
                    LevelUser::insert([
                        'seller_id'     => $user->id,
                        'referral_id'   => $referral->id,
                        'created_at'    =>now(),
                    ]);
                    BalanceController::store('Bono de referido en la aplicacion', 'credit', SettingController::bonus()['bonus']['referrals'], 'jib', $referral->id);
                    NotificationController::store('Bono de Referido', 'Bono de '.Helper::amount(SettingController::bonus()['bonus']['referrals']).' jibs', $user->id);
                }
            }

            $data = [
                'user'  => $user,
                'code'  => substr(sha1(time()), 0, 6)
            ];

            Mail::to($user->email)->send(new RegisterUser($data));

            $accessToken = $user->createToken('AuthToken')->plainTextToken;
            $user = User::find($user->id);

            $level = "Usuario";
            if(isset($user->LevelSeller->level->name) && $user->LevelSeller->level->name == 'classic') {
                $level = 'Clasico';
            }elseif(isset($user->LevelSeller->level->name) && $user->LevelSeller->level->name == 'junior') {
                $level = 'Junior';
            }elseif(isset($user->LevelSeller->level->name) && $user->LevelSeller->level->name == 'middle') {
                $level = 'Semi Senior';
            }elseif(isset($user->LevelSeller->level->name) && $user->LevelSeller->level->name == 'master') {
                $level = 'Senior';
            }


            $image = $this->asset.'avatar.svg';
            if ($user->image != 'avatar.svg' && $user->type == 2) {
                $image = $this->asset.'sellers/'.$user->image;
            } elseif ($user->image != 'avatar.svg' && $user->type == 1) {
                $image = $this->asset.'competitors/'.$user->image;
            }

            return response()->json([
                'profile'    => [
                    'id'                => $user->id,
                    'names'             => $user->names,
                    'surnames'          => $user->surnames,
                    'email'             => $user->email,
                    'dni'               => $user->dni,
                    'phone'             => $user->phone,
                    'address'           => $user->address,
                    'address_city'      => $user->address_city,
                    'usd'               => Helper::amount($user->balance_usd),
                    'jib'               => Helper::jib($user->balance_jib),
                    'jib_rate'          => SettingController::jib()['value']['jib_usd'],
                    'balance_jib'       => $user->balance_jib,
                    'balance_usd'       => $user->balance_usd,
                    'amount_shopping'   => Helper::amount($user->Shoppings->sum('amount')),
                    'shoppings'         => $user->Shoppings->count(),
                    'amount_sale'       => Helper::amount($user->Sales->sum('amount')),
                    'sales'             => $user->Sales->count(),
                    'guests_month'      => Carbon::now()->locale('es')->translatedFormat('F').' ('.LevelUser::where('referral_id', $user->id)->whereMonth('created_at', date('m'))->count().')',
                    'guests'            => count(User::Guests($user->id)),
                    'guests_list'       => User::Guests($user->id),
                    'email_verified_at' => $user->email_verified_at,
                    'code_referral'     => $user->code_referral,
                    'role'              => count($user->getRoleNames()) > 1 ? $user->getRoleNames()->join(',') : $user->getRoleNames()->join(''),
                    'seller'            => $user->type == 2 ? true : false,
                    'level'             => $level,
                    'status'            => 'Activo',
                    'image'             => $image,
                    'country'      => [
                        'id'    => $user->country->id,
                        'name'  => $user->country->name,
                        'iso'   => $user->country->iso,
                        'code'  => $user->country->code,
                        'icon'  => $user->country->img != 'flag.png' ? $this->asset.'flags/'.$user->country->img : $this->asset.'flags/flag.png'
                    ]
                ],
                'token'    => $accessToken,
                'message'  => 'Bienvenido a Jimbo, '.$user->names,
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
                $level = "Usuario";
                if(isset($user->LevelSeller->level->name) && $user->LevelSeller->level->name == 'classic') {
                    $level = 'Clasico';
                }elseif(isset($user->LevelSeller->level->name) && $user->LevelSeller->level->name == 'junior') {
                    $level = 'Junior';
                }elseif(isset($user->LevelSeller->level->name) && $user->LevelSeller->level->name == 'middle') {
                    $level = 'Semi Senior';
                }elseif(isset($user->LevelSeller->level->name) && $user->LevelSeller->level->name == 'master') {
                    $level = 'Senior';
                }

                $image = $this->asset.'avatar.svg';
                if ($user->image != 'avatar.svg' && $user->type == 2) {
                    $image = $this->asset.'sellers/'.$user->image;
                } elseif ($user->image != 'avatar.svg' && $user->type == 1) {
                    $image = $this->asset.'competitors/'.$user->image;
                }

                return response()->json([
                    'profile'    => [
                        'id'                => $user->id,
                        'names'             => $user->names,
                        'surnames'          => $user->surnames,
                        'email'             => $user->email,
                        'dni'               => $user->dni,
                        'phone'             => $user->phone,
                        'address'           => $user->address,
                        'address_city'      => $user->address_city,
                        'usd'               => Helper::amount($user->balance_usd),
                        'jib'               => Helper::jib($user->balance_jib),
                        'jib_rate'          => SettingController::jib()['value']['jib_usd'],
                        'balance_jib'       => $user->balance_jib,
                        'balance_usd'       => $user->balance_usd,
                        'amount_shopping'   => Helper::amount($user->Shoppings->sum('amount')),
                        'shoppings'         => $user->Shoppings->count(),
                        'amount_sale'       => Helper::amount($user->Sales->sum('amount')),
                        'sales'             => $user->Sales->count(),
                        'guests_month'      => Carbon::now()->locale('es')->translatedFormat('F').' ('.LevelUser::where('referral_id', $user->id)->whereMonth('created_at', date('m'))->count().')',
                        'guests'            => count(User::Guests($user->id)),
                        'guests_list'       => User::Guests($user->id),
                        'email_verified_at' => $user->email_verified_at,
                        'code_referral'     => $user->code_referral,
                        'role'              => count($user->getRoleNames()) > 1 ? $user->getRoleNames()->join(',') : $user->getRoleNames()->join(''),
                        'seller'            => $user->type == 2 ? true : false,
                        'level'             => $level,
                        'status'            => 'Activo',
                        'become_seller'     => $user->become_seller == 1 ? true : false,
                        'image'             => $image,
                        'country'   => [
                            'id'    => $user->country->id,
                            'name'  => $user->country->name,
                            'iso'   => $user->country->iso,
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
    public function settingProfile(FormRequestProfile $request, User $User, $id)
    {
        try {
            $user                    = User::find($id);
            $user->names             = $request->names;
            $user->surnames          = $request->surnames;
            $user->email             = $request->email;
            $user->dni               = $request->dni;
            $user->phone             = $request->phone;
            $user->address           = $request->address;
            $user->address_city      = $request->address_city;
            $user->become_seller     = $request->become_seller == 1 ? 1 : 0;

            if ($request->has('code') && $request->code && $user->code == $request->code) {
                $user->email_verified_at = now();
            }

            if($request->password){
                $user->password     = Hash::make($request->password);
            }

            if ($user->type == 2) {
                $image = 'assets/images/sellers/';
            } elseif ($user->type == 1) {
                $image = 'assets/images/competitors/';
            }

            if ($user->image != "avatar.svg") {

                if ($user->type == 2) {
                    $folder = 'assets/images/sellers/';
                } elseif ($user->type == 1) {
                    $folder = 'assets/images/competitors/';
                }

                if (File::exists(public_path($folder . $user->image))) {
                    File::delete(public_path($folder . $user->image));
                }

                $user->image = $this->saveBase64($request->image, $folder, $user->id.time().'.'.'jpeg');
            }

            $level = "Usuario";
            if(isset($user->LevelSeller->level->name) && $user->LevelSeller->level->name == 'classic') {
                $level = 'Clasico';
            }elseif(isset($user->LevelSeller->level->name) && $user->LevelSeller->level->name == 'junior') {
                $level = 'Junior';
            }elseif(isset($user->LevelSeller->level->name) && $user->LevelSeller->level->name == 'middle') {
                $level = 'Semi Senior';
            }elseif(isset($user->LevelSeller->level->name) && $user->LevelSeller->level->name == 'master') {
                $level = 'Senior';
            }

            $image = $this->asset.'avatar.svg';
            if ($user->image != 'avatar.svg' && $user->type == 2) {
                $image = $this->asset.'sellers/'.$user->image;
            } elseif ($user->image != 'avatar.svg' && $user->type == 1) {
                $image = $this->asset.'competitors/'.$user->image;
            }

             $data =    [
                "address"       => $request->address,
                "address_city"  => $request->address_city,
                "country_code"  => $user->country->iso,
                "email"         => $request->email,
                "first_name"    => $request->names,
                "last_name"     => $request->surnames,
                "metadata"      => [
                    "DNI"  => $request->dni
                ],
                "phone_number" => $request->phone
            ];

            if ($user->save()) {

                $message_culqi = null;
                $culqi_customer_id = isset($user->Customer->culqi_customer_id) ? $user->Customer->culqi_customer_id : null;
                if($culqi_customer_id == null) {
                    $culqi = new Culqi();
                    $customer =  $culqi->customer($data);
                    $object = $customer->object ?? 'error';

                    if($object =='customer') {
                        $customer =  Customer::updateOrCreate(
                            ['culqi_customer_id' => $customer->id, 'user_id' => $user->id],
                        );
                    } else {
                        $customer = json_decode($customer, true);
                        $message_culqi = "Culqi informa:".$customer['merchant_message'];
                    }
                }

                NotificationController::store('Datos de perfil actualizados','Hola, '.$user->email.' has actualizado tu datos de perfil con exito, recuerda tener tu correo siempre activo!', $user->id);
                return response()->json([
                    'profile'    => [
                        'id'                => $user->id,
                        'names'             => $user->names,
                        'surnames'          => $user->surnames,
                        'email'             => $user->email,
                        'dni'               => $user->dni,
                        'phone'             => $user->phone,
                        'address'           => $user->address,
                        'address_city'      => $user->address_city,
                        'usd'               => Helper::amount($user->balance_usd),
                        'jib'               => Helper::jib($user->balance_jib),
                        'jib_rate'          => SettingController::jib()['value']['jib_usd'],
                        'balance_jib'       => $user->balance_jib,
                        'balance_usd'       => $user->balance_usd,
                        'amount_shopping'   => Helper::amount($user->Shoppings->sum('amount')),
                        'shoppings'         => $user->Shoppings->count(),
                        'amount_sale'       => Helper::amount($user->Sales->sum('amount')),
                        'sales'             => $user->Sales->count(),
                        'guests_month'      => Carbon::now()->locale('es')->translatedFormat('F').' ('.LevelUser::where('referral_id', $user->id)->whereMonth('created_at', date('m'))->count().')',
                        'guests'            => count(User::Guests($user->id)),
                        'guests_list'       => User::Guests($user->id),
                        'email_verified_at' => $user->email_verified_at,
                        'code_referral'     => $user->code_referral,
                        'role'              => count($user->getRoleNames()) > 1 ? $user->getRoleNames()->join(',') : $user->getRoleNames()->join(''),
                        'seller'            => $user->type == 2 ? true : false,
                        'level'             => $level,
                        'status'            => 'Activo',
                        'become_seller'     => $user->become_seller == 1 ? true : false,
                        'image'             => $image,
                        'country'      => [
                            'id'    => $user->country->id,
                            'name'  => $user->country->name,
                            'iso'   => $user->country->iso,
                            'code'  => $user->country->code,
                            'icon'  => $user->country->img != 'flag.png' ? $this->asset.'flags/'.$user->country->img : $this->asset.'flags/flag.png'
                        ]
                    ],
                    'status'        => 200,
                    'message'       => $user->names.'!, Perfil actualizado. '.$message_culqi,
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
    public function forgot(FormRequestForgot $request)
    {
        try {
            $data = [];
            $user = User::where('email', $request->email)->first();

            if ($user) {

                $data = [
                    'user'      => $user,
                    'password'  => substr(sha1(time()), 0, 6)
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
    public function RecoveryPassword(FormRequestRecoveryPassword $request)
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
            NotificationController::store('Recuperacion de contraseña', 'Hola! '.$user->email.' has solicitado un envio de codigo, para el restablecimiento de tu contraseña', $user->id);
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
    public function sendCodeVerifiedEmail(Request $request)
    {
        try {
            $data = [];
            $search = User::where('email', $request->email)->where('id', '<>', $request->id)->first();

            if (!$search) {
                $user = User::find($request->id);
                $data = [
                    'user'  => $user,
                    'code'  => substr(sha1(time()), 0, 6)
                ];
                Mail::to($request->email)->send(new VerifiedEmail($data));

                $user->code = $data['code'];
                $user->save();

                return response()->json([
                    'status'   => 200,
                    'message' =>  'Su codigo de verificacion ha sido enviado exitosamente!'
                ], 200);
            }
            return response()->json([
                'status'   => 404,
                'message' =>  'El email igresado no esta disponible!.'
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
    public function verifiedEmail(FormRequestVerifiedEmail $request)
    {
        try {
            $user = User::where('email', $request->email)->where('code', $request->code)->first();

            if ($user) {
                $user->email_verified_at = now();
                $user->code = null;
                $user->save();
            }
            return response()->json([
                'status'   => 404,
                'message' =>  'El email ha sido verificado exitosamente.!'
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
