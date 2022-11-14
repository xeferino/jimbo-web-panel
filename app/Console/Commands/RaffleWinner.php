<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Raffle;
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
            DB::raw("TIMESTAMPDIFF(DAY, now(), raffles.date_end) AS remaining_days"),
            DB::raw("TIMESTAMPDIFF(DAY, now(), raffles.date_release) AS date_release_end"))
            ->where('raffles.active', 1)
            ->where('raffles.public', 1)
            ->where('raffles.finish', 0)
            ->whereNull('raffles.deleted_at')
            ->orderBy('raffles.id', 'DESC')
            ->get();
        $ids  = [];
        $save = 0;
        foreach ($raffles as $key => $value) {
            $raffle = Raffle::find($value->id);
            if ($value->remaining_days == 0) {
                NotificationController::store('Sorteo Finalizado!', 'se ha finalizado sorteo en jimbo! '.$raffle->title);
                //array_push($ids, $value->id);
                $raffle->finish = 1;
                $save+=1;
            } elseif ($value->date_release_end == 0) {
                $raffle->active = 0;
                NotificationController::store('Sorteo Finalizado!', 'se ha finalizado sorteo en jimbo! '.$raffle->title);
                //array_push($ids, $value->id);
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
