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
use App\Mail\Notify;
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
                        NotificationController::store('Nuevo Bono!', 'Bono de '.$balance.' jibs por ingreso al App', $user->id);
                    }
                    NotificationController::store('Nuevo Ingreso!', 'Hola, '.$user->email.' has accedido a jimbo!', $user->id);

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
                    } elseif($user->type == 2) {
                        $level = 'Vendedor';
                    }elseif(($user->type == 1 or $user->type == 2) && $user->become_seller == 1 && $user->seller_at != null ) {
                        $level = 'Usuario - Vendedor';
                    }

                    $image = $this->asset.'avatar.svg';
                    if ($user->image != 'avatar.svg') {
                        if ($user->type == 2) {
                            $image = $this->asset.'sellers/'.$user->image;
                        } elseif ($user->type == 1) {
                            $image = $this->asset.'competitors/'.$user->image;
                        }
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
                                'amount_shopping'   => Helper::amountJib($user->Shoppings->sum('amount')),
                                'shoppings'         => $user->Shoppings->count(),
                                'amount_sale'       => Helper::amountJib($user->Sales->sum('amount')),
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
                                'become_seller'     => (($user->type == 1 or $user->type == 2) && $user->become_seller == 1 && $user->seller_at != null ) ? true : false,
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
                $notification = NotificationController::store('Nuevo Bono!', 'Bono de '.$balance.' jibs, por registrarte en Jimbo', $user->id);
                $notification = NotificationController::store('Bienvenido!', 'Hola, '.$user->email.' felicidades! ahora eres parte de la familia jimbo sorteos', $user->id);
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
                    NotificationController::store('Nuevo Bono!', 'Has recibo '.Helper::amount(SettingController::bonus()['bonus']['referrals']).' jibs, un nuevo usuario se ha registrado con tu codigo', $user->id);
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
            } elseif($user->type == 2) {
                $level = 'Vendedor';
            }elseif(($user->type == 1 or $user->type == 2) && $user->become_seller == 1 && $user->seller_at != null ) {
                $level = 'Usuario - Vendedor';
            }


            $image = $this->asset.'avatar.svg';
            if ($user->image != 'avatar.svg') {
                if ($user->type == 2) {
                    $image = $this->asset.'sellers/'.$user->image;
                } elseif ($user->type == 1) {
                    $image = $this->asset.'competitors/'.$user->image;
                }
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
                    'amount_shopping'   => Helper::amountJib($user->Shoppings->sum('amount')),
                    'shoppings'         => $user->Shoppings->count(),
                    'amount_sale'       => Helper::amountJib($user->Sales->sum('amount')),
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
                    'become_seller'     => (($user->type == 1 or $user->type ==2) && $user->become_seller == 1 && $user->seller_at != null ) ? true : false,
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
                } elseif($user->type == 2) {
                    $level = 'Vendedor';
                }elseif(($user->type == 1 or $user->type == 2) && $user->become_seller == 1 && $user->seller_at != null ) {
                    $level = 'Usuario - Vendedor';
                }

                $image = $this->asset.'avatar.svg';
                if ($user->image != 'avatar.svg') {
                    if ($user->type == 2) {
                        $image = $this->asset.'sellers/'.$user->image;
                    } elseif ($user->type == 1) {
                        $image = $this->asset.'competitors/'.$user->image;
                    }
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
                        'amount_shopping'   => Helper::amountJib($user->Shoppings->sum('amount')),
                        'shoppings'         => $user->Shoppings->count(),
                        'amount_sale'       => Helper::amountJib($user->Sales->sum('amount')),
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
                        'become_seller'     => (($user->type == 1 or $user->type ==2) && $user->become_seller == 1 && $user->seller_at != null ) ? true : false,
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

            if ($request->has('code') && $request->code && $user->code == $request->code) {
                $user->email_verified_at = now();
            }

            if($request->password){
                $user->password     = Hash::make($request->password);
            }

            if ($request->has('image') && isset($request->image)) {
                if ($user->image != "avatar.svg") {
                    if ($user->type == 2) {
                        if (File::exists(public_path('assets/images/sellers/' . $user->image))) {
                            File::delete(public_path('assets/images/sellers/' . $user->image));
                        }
                    } elseif ($user->type == 1) {
                        if (File::exists(public_path('assets/images/competitors/' . $user->image))) {
                            File::delete(public_path('assets/images/competitors/' . $user->image));
                        }
                    }
                }
                $image_64 = $request->image;
                $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];
                $replace = substr($image_64, 0, strpos($image_64, ',')+1);
                $image = str_replace($replace, '', $image_64);
                $image = str_replace(' ', '+', $image);
                $imageName = Str::random(10).'.'.$extension;
                //$imageName = Str::random(10).'.png';
                $path = null;
                if ($user->type == 2) {
                    $path = 'assets/images/sellers/';
                } elseif ($user->type == 1) {
                    $path = 'assets/images/competitors/';
                }
                File::put(public_path($path).$imageName, base64_decode($image));
                $user->image = $imageName;
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
            } elseif($user->type == 2) {
                $level = 'Vendedor';
            }elseif(($user->type == 1 or $user->type == 2) && $user->become_seller == 1 && $user->seller_at != null ) {
                $level = 'Usuario - Vendedor';
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

                $image = $this->asset.'avatar.svg';
                if ($user->image != "avatar.svg") {
                    if ($user->type == 2) {
                        $image = $this->asset.'sellers/'.$user->image;
                    } elseif ($user->type == 1) {
                        $image = $this->asset.'competitors/'.$user->image;
                    }
                }

                NotificationController::store('Datos Actualizados!','Hola, '.$user->email.' tu perfil se ha actualizado con exito, recuerda tener tu correo siempre activo!', $user->id);
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
                        'amount_shopping'   => Helper::amountJib($user->Shoppings->sum('amount')),
                        'shoppings'         => $user->Shoppings->count(),
                        'amount_sale'       => Helper::amountJib($user->Sales->sum('amount')),
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
                        'become_seller'     => (($user->type == 1 or $user->type == 2) && $user->become_seller == 1 && $user->seller_at != null ) ? true : false,
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
     * Display profile dada.
     *
     * @return \Illuminate\Http\Response
     */
    public function competitor_to_seller(Request $request, User $User, $id)
    {
        try {
            $user                    = User::findOrFail($id);
            if ($user->type == 2) {
                return response()->json([
                    'status'   => 422,
                    'message'  =>  $user->names.' '.$user->surnames.', actualmente eres vendedor de jimbo'
                ], 422);
            } elseif ($user->type == 1 && $user->become_seller == 1 && $user->seller_at == null) {
                return response()->json([
                    'status'   => 422,
                    'message'  =>  $user->names.' '.$user->surnames.', tienes una solicitud para convertirte en vendedor de jimbo pendiente'
                ], 422);
            } elseif ($user->type == 1 && $user->become_seller == 1 && $user->seller_at != null) {
                return response()->json([
                    'status'   => 422,
                    'message'  =>  $user->names.' '.$user->surnames.', actualmente eres vendedor de jimbo'
                ], 422);
            }

            $user->become_seller     = 1;

            if ($user->type == 2) {
                $image = 'assets/images/sellers/';
            } elseif ($user->type == 1) {
                $image = 'assets/images/competitors/';
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

            if ($user->save()) {
                NotificationController::store('Solicitud de vendedor!','Hola, '.$user->email.' has solicitado convertirte en vendedor, se le enviara un correo una vez aprobada su solicitud, como vendedor!', $user->id);
                $data = [
                    'user'      =>  $user,
                    'title'     => 'Has solicitado convertirte en vendedor!',
                    'message'   => 'Una vez aprobada tu solicitud se te notificara a traves de un email, te falta poco para formar parte de nuestra familia Jimbo.',
                    'subject'   => 'Quieres ser vendedor de Jimbo Sorteos?'
                ];
                Mail::to($user->email)->send(new Notify($data));

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
                        'amount_shopping'   => Helper::amountJib($user->Shoppings->sum('amount')),
                        'shoppings'         => $user->Shoppings->count(),
                        'amount_sale'       => Helper::amountJib($user->Sales->sum('amount')),
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
                        'become_seller'     => ($user->become_seller == 1 && $user->type == 1 && $user->seller_at != null ) ? true : false,
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
                    'message'       => $user->names.'!, Solicitud enviada exitosamente.',
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
