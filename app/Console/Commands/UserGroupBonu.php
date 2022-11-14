<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Sale;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Api\NotificationController;
use App\Models\Level;
use App\Models\LevelUser;
use App\Http\Controllers\Api\BalanceController;
use App\Helpers\Helper;
use App\Http\Controllers\SettingController;
use App\Models\User;

class UserGroupBonu extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user-group:bonus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para la carg ade bonos de usuarios';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $month = date('m');
        $month_name = null;
        if ($month == '12') {
            $month = '11';
            $month_name = 'Noviembre';
        }elseif($month == '11') {
            $month = '10';
            $month_name = 'Octubre';
        }elseif($month == '10') {
            $month = '09';
            $month_name = 'Septiembre';
        }elseif($month == '09') {
            $month = '08';
            $month_name = 'Agosto';
        }elseif($month == '08') {
            $month = '07';
            $month_name = 'Julio';
        }elseif($month == '07') {
            $month = '06';
            $month_name = 'Junio';
        }elseif($month == '06') {
            $month = '05';
            $month_name = 'Mayo';
        }elseif($month == '05') {
            $month = '04';
            $month_name = 'Abril';
        }elseif($month == '04') {
            $month = '03';
            $month_name = 'Marzo';
        }elseif($month == '03') {
            $month = '02';
            $month_name = 'Febrero';
        }elseif($month == '02') {
            $month = '01';
            $month_name = 'Enero';
        }elseif($month == '01') {
            $month = '12';
            $month_name = 'Diciembre';
        }

        $level_group_junior  = Setting::where('name', 'level_group_junior')->first();
        $level_group_middle  = Setting::where('name', 'level_group_middle')->first();
        $level_group_master  = Setting::where('name', 'level_group_master')->first();

        $level_percent_group_junior = Setting::where('name', 'level_percent_group_junior')->first();
        $level_percent_group_middle = Setting::where('name', 'level_percent_group_middle')->first();
        $level_percent_group_master = Setting::where('name', 'level_percent_group_master')->first();

        $users = Sale::select(
            'users.id AS user_id',
            DB::raw("CONCAT(users.names,' ',users.surnames) AS fullnames"),
            'users.email',
            DB::raw('SUM(sales.amount) as amount'),
            'level_users.referral_id',
            'level_users.level_id',
            'levels.name as level'
            )
            ->join('level_users', 'level_users.seller_id', '=', 'sales.seller_id')
            ->join('users', 'users.id', '=', 'level_users.referral_id')
            ->leftJoin('levels', 'levels.id', '=', 'level_users.level_id')
            ->groupBy('level_users.referral_id')
            ->groupBy('level_users.level_id')
            ->whereNotNull('sales.seller_id')
            ->whereNull('sales.user_id')
            ->whereMonth('sales.created_at', $month)
            ->orderBy('sales.id','DESC')
            ->get();

        $data = [];
        $save = 0;
        foreach ($users as $key => $value) {
            # code...
            $level = null;
            $bonus = 0;
            if($value->level == 'junior' && $value->amount>=$level_group_junior->value) {
                $level = $value->level;
                $bonus = (($value->amount/100)*$level_percent_group_junior->value);
            }elseif($value->level == 'middle' && $value->amount>=$level_group_middle->value) {
                $level = $value->level;
                $bonus = (($value->amount/100)*$level_percent_group_middle->value);
            }elseif($value->level == 'master' && $value->amount>=$level_group_master->value) {
                $level = $value->level;
                $bonus = (($value->amount/100)*$level_percent_group_master->value);
            }

            if($bonus > 0) {
                $user = User::find($value->user_id);
                $user->balance_usd  =  $user->balance_usd+$bonus;
                $user->save();
                BalanceController::store('Cierre ventas del mes de '.$month_name.' de referidos', 'credit', $bonus, 'usd', $user->id);
                NotificationController::store('Cierre ventas del mes de '.$month_name.' de referidos', 'Hola, '.$user->email.' has recibido un bono de '.Helper::amount($bonus).', con Jimbo siempre ganas', $user->id);
                $save+=1;
            }
        }

        if($save>=1){
            return $this->info('Se han entregados los diferentes bonos a los usuarios');
        }
        return $this->info('No se han entregados bonos y/o ha ocurrido un error, Veridique!.');
    }
}
