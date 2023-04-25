<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Raffle;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Api\NotificationController;
use App\Models\User;

class RaffleCompleted extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'raffle:completed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para la finalizacion de sorteos';

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
            DB::raw("TIMESTAMPDIFF(DAY, now(), raffles.date_end) AS remaining_days"),
            DB::raw("TIMESTAMPDIFF(DAY, now(), raffles.date_release) AS date_release_end"))
            ->where('raffles.active', 1)
            ->where('raffles.public', 1)
            ->where('raffles.finish', 0)
            ->whereNull('raffles.deleted_at')
            ->orderBy('raffles.id', 'DESC')
            ->get();
        $users = User::whereIn('type', [1,2])->where('active', 1)->get();
        $ids  = [];
        $save = 0;
        foreach ($raffles as $key => $value) {
            $raffle = Raffle::find($value->id);
            $end = $raffle->date_end->format('Y-m-d 11:59:00');
            if ($value->remaining_days == 0 && (date('Y-m-d H:i:s') > $end ) ) {
                foreach ($users as $key => $user) {
                    NotificationController::store('Sorteo Finalizado!', 'se ha finalizado sorteo en jimbo! '.$raffle->title, $user->id);
                }
                $raffle->finish = 1;
                $save+=1;
            }
            $raffle->save();
        }

        if($save>=1){
            return $this->info('Se han finalizados todos los sorteos encontrados ('.count($raffles).')');
        }
        return $this->info('No se han encontrado sorteos por finalizar.');
    }
}
