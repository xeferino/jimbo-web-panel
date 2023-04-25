<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Raffle;
use App\Models\Sale;
use App\Models\Winner;
use App\Models\TicketUser;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Api\NotificationController;

class RaffleWinner extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'raffle:winner';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para el lanzamiento de sorteos y extraer los ganadores';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $raffles = Raffle::select(
            'raffles.id',
            'raffles.title',
            'raffles.cash_to_draw',
            'raffles.date_start',
            'raffles.date_end',
            'raffles.date_release',
            )
            ->where('raffles.active', 1)
            ->where('raffles.public', 1)
            ->where('raffles.finish', 1)
            ->where('date_release', date('Y-m-d'))
            //->where('raffles.date_release', '2023-04-25')
            ->whereNull('raffles.deleted_at')
            ->orderBy('raffles.id', 'DESC')
            ->pluck('id');
        if(count($raffles)>0) {
            $sales = Sale::whereIn('sales.raffle_id', $raffles)
                    ->where('sales.status', 'approved')
                    ->whereNull('sales.deleted_at')->get();
            $prewinners = [];
            $user = 0;
            $raffle = 0;
            foreach ($sales as $key => $sale) {
                if(($user != $sale->user_id) && ($raffle != $sale->raffle_id)) {
                    if($sale->user_id != null) {
                        array_push($prewinners, [
                            'sale'      => $sale->id,
                            'user_id'   => $sale->user_id,
                            'raffle_id' => $sale->raffle_id
                        ]);
                    }
                }

                if($sale->user_id == null && ($raffle != $sale->raffle_id)) {
                    array_push($prewinners, [
                        'sale'      => $sale->id,
                        'user_id'   => $sale->user_id,
                        'raffle_id' => $sale->raffle_id
                    ]);
                }
                $user = $sale->user_id;
            }

            $winners = array();
            while(count($winners) < 10) {
                $rand_pre_win = $prewinners[array_rand($prewinners)];
                if(!in_array($rand_pre_win, $winners)){
                    array_push($winners, $rand_pre_win);
                }
            }

            $winnersCompleted = [];
            foreach ($winners as $key => $value) {
                $sale = Sale::find($value['sale']);
                $raffle = Raffle::find($sale->raffle_id);
                $ticket_user = TicketUser::where('ticket_id', $sale->ticket_id)
                                ->where('sale_id', $sale->id)
                                ->where('raffle_id', $raffle->id)
                                ->first();
                $amount = 0;
                if($key == 0) {
                    $amount = ($raffle->prize_1*$raffle->cash_to_draw)/100;
                }
                if($key == 1) {
                    $amount = ($raffle->prize_2*$raffle->cash_to_draw)/100;
                }
                if($key == 2) {
                    $amount = ($raffle->prize_3*$raffle->cash_to_draw)/100;
                }
                if($key == 3) {
                    $amount = ($raffle->prize_4*$raffle->cash_to_draw)/100;
                }
                if($key == 4) {
                    $amount = ($raffle->prize_5*$raffle->cash_to_draw)/100;
                }
                if($key == 5) {
                    $amount = ($raffle->prize_6*$raffle->cash_to_draw)/100;
                }
                if($key == 6) {
                    $amount = ($raffle->prize_7*$raffle->cash_to_draw)/100;
                }
                if($key == 7) {
                    $amount = ($raffle->prize_8*$raffle->cash_to_draw)/100;
                }
                if($key == 8) {
                    $amount = ($raffle->prize_9*$raffle->cash_to_draw)/100;
                }
                if($key == 9) {
                    $amount = ($raffle->prize_10*$raffle->cash_to_draw)/100;
                }

                array_push($winnersCompleted, [
                    'name' => $sale->name,
                    'dni' => $sale->dni,
                    'phone' => $sale->phone,
                    'email' => $sale->email,
                    'address' => $sale->address,
                    'country_id' => $sale->country_id,
                    'amount' => $amount,
                    'ticket_id' => $sale->ticket_id,
                    'ticket_user_id' => $ticket_user->id,
                    'seller_id' => $sale->seller_id ?? null,
                    'user_id' => $sale->user_id ?? null,
                    'raffle_id' => $sale->raffle_id ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            Winner::insert($winnersCompleted);
            return $this->info('si hay ganadores');
        }
        return $this->info('no hay ganadores');
    }
}
