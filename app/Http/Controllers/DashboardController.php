<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Sale;
use App\Models\CashRequest;
use App\Helpers\Helper;
use App\Models\Promotion;
use App\Models\Raffle;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        return view('panel.dashboard', [
            'title'         => 'Dashboard',
            'users'         => $this->users(),
            'sellers'       => $this->sellers(),
            'sales'         => $this->sales(),
            'egress'        => $this->egress(),
            'cash'          => $this->requestCash(),
            'raffles'       => $this->raffles(),
            'promotions'    => $this->promotions()
        ]);
    }

    private function users()
    {
        $users = User::whereHas("roles", function ($q) {
            $q->whereNotIn('name', ['seller','competitor']);
        })->whereNull('deleted_at')->count();

        $user_active = User::whereHas("roles", function ($q) {
            $q->whereNotIn('name', ['seller','competitor']);
        })->whereNull('deleted_at')->where('active', 1)->count();

        $user_inactive = User::whereHas("roles", function ($q) {
            $q->whereNotIn('name', ['seller','competitor']);
        })->whereNull('deleted_at')->where('active', 0)->count();

        $competitors = User::whereHas("roles", function ($q) {
            $q->whereIn('name', ['competitor']);
        })->whereNull('deleted_at')->count();

        $competitor_active = User::whereHas("roles", function ($q) {
            $q->whereIn('name', ['competitor']);
        })->whereNull('deleted_at')->where('active', 1)->count();

        $competitor_inactive = User::whereHas("roles", function ($q) {
            $q->whereIn('name', ['competitor']);
        })->whereNull('deleted_at')->where('active', 0)->count();

        $sellers = User::whereHas("roles", function ($q) {
            $q->whereIn('name', ['seller']);
        })->whereNull('deleted_at')->count();

        $seller_active = User::whereHas("roles", function ($q) {
            $q->whereIn('name', ['seller']);
        })->whereNull('deleted_at')->where('active', 1)->count();

        $seller_inactive = User::whereHas("roles", function ($q) {
            $q->whereIn('name', ['seller']);
        })->whereNull('deleted_at')->where('active', 0)->count();

        return [
            'users'               => $users,
            'user_active'         => $user_active,
            'user_inactive'       => $user_inactive,
            'competitors'         => $competitors,
            'competitor_active'   => $competitor_active,
            'competitor_inactive' => $competitor_inactive,
            'sellers'             => $sellers,
            'seller_active'       => $seller_active,
            'seller_inactive'     => $seller_inactive
        ];
    }

    private function sellers()
    {
       /*  $top = Sale::select(DB::raw("CONCAT(users.names,' ',users.surnames) AS fullnames"), DB::raw('SUM(amount) as amount'))
                ->join('users', 'users.id', '=', 'sales.seller_id')
                ->groupBy('sales.seller_id')
                ->groupBy('sales.id')
                ->whereNotNull('sales.seller_id')
                ->offset(0)->limit(10)
                ->orderBy('sales.id','DESC')
                ->get(); */
        /* $top = DB::table('sales')
        ->select(
            DB::raw("CONCAT(users.names,' ',users.surnames) AS fullnames"),
            DB::raw('SUM(sales.amount) as amount')
        )->join('users', 'users.id', '=', 'sales.seller_id')
        ->whereNotNull('sales.seller_id')
        ->orderBy('sales.seller_id','DESC')
        ->groupBy('sales.seller_id')
        ->offset(0)->limit(10)
        ->get()->groupBy(function($data) {
            return $data->seller_id;
        }); */
        return [
            'top'  => $top ?? []
        ];
    }


    private function sales()
    {
        $sale_approved = Sale::where('status', 'approved')->sum('amount');
        $sale_pending = Sale::select('amount')->where('status', 'pending')->sum('amount');

        return  [
            'sale_approved' =>  $sale_approved,
            'sale_pending'  =>  $sale_pending,
            'sale_total'    =>  $sale_approved+$sale_pending
        ];
    }

    private function egress()
    {
        $cash_approved = CashRequest::where('status', 'approved')->sum('amount');
        return $cash_approved;
    }

    private function requestCash()
    {
        $cash_pending = CashRequest::where('status', 'pending')->sum('amount');
        return $cash_pending;
    }

    private function raffles()
    {
        $raffles            = Raffle::whereNull('deleted_at')->count();
        $raffle_open        = Raffle::where('finish', 0)->whereNull('deleted_at')->count();
        $raffle_close       = Raffle::where('finish', 1)->whereNull('deleted_at')->count();
        $raffle_public      = Raffle::where('public', 1)->whereNull('deleted_at')->count();
        $raffle_draft       = Raffle::where('public', 0)->whereNull('deleted_at')->count();
        $raffle_active      = Raffle::where('active', 1)->whereNull('deleted_at')->count();
        $raffle_inactive    = Raffle::where('active', 0)->whereNull('deleted_at')->count();
        $raffle_p           = Raffle::where('type', 'product')->whereNull('deleted_at')->count();
        $raffle_r           = Raffle::where('type','raffle')->whereNull('deleted_at')->count();

        $raffles_to_ends = Raffle::select(
            'raffles.*',
            DB::raw("TIMESTAMPDIFF(DAY, now(), raffles.date_end) AS remaining_days"),
            DB::raw("TIMESTAMPDIFF(DAY, now(), raffles.date_release) AS date_release_end"))
            ->where('raffles.active', 1)
            ->where('raffles.public', 1)
            ->where('raffles.finish', 0)
            ->whereNull('raffles.deleted_at')
            ->orderBy('raffles.id', 'DESC')
            ->get();

        $raffle_to_ends = [];

        foreach ($raffles_to_ends as $key => $value) {
            $amount = ((($value->cash_to_draw*$value->prize_1)/100) +
                                          (($value->cash_to_draw*$value->prize_2)/100) +
                                          (($value->cash_to_draw*$value->prize_3)/100) +
                                          (($value->cash_to_draw*$value->prize_4)/100) +
                                          (($value->cash_to_draw*$value->prize_5)/100) +
                                          (($value->cash_to_draw*$value->prize_6)/100) +
                                          (($value->cash_to_draw*$value->prize_7)/100) +
                                          (($value->cash_to_draw*$value->prize_8)/100) +
                                          (($value->cash_to_draw*$value->prize_9)/100) +
                                          (($value->cash_to_draw*$value->prize_10)/100));
            $percent = (($value->totalSale->sum('amount')*100)/($value->cash_to_collect-$amount));
            if ($value->remaining_days <=5) {
                array_push($raffle_to_ends, [
                    'id'                => substr(sha1( $value->id), 0, 8),
                    'title'             => $value->title,
                    'cash_to_draw'      => Helper::amount($value->cash_to_draw),
                    'date_start'        => $value->date_start->format('d/m/Y'),
                    'date_end'          => $value->date_end->format('d/m/Y'),
                    'date_release'      => $value->date_release->format('d/m/Y'),
                    'percent'           => $percent == 100 ?  100 : $percent,
                    'remaining_days'    => $value->remaining_days
                ]);
            }
        }

        return [
            'raffles'           => $raffles,
            'raffle_open'       => $raffle_open,
            'raffle_close'      => $raffle_close,
            'raffle_public'     => $raffle_public,
            'raffle_draft'      => $raffle_draft,
            'raffle_active'     => $raffle_active,
            'raffle_inactive'   => $raffle_inactive,
            'raffle_p'          => $raffle_p,
            'raffle_r'          => $raffle_r,
            'raffle_to_end'     => $raffle_to_ends
        ];
    }

    private function promotions()
    {
        $promotions            = Promotion::whereNull('deleted_at')->count();
        $promotion_active      = Promotion::where('active', 1)->whereNull('deleted_at')->count();
        $promotion_inactive    = Promotion::where('active', 0)->whereNull('deleted_at')->count();

        return [
            'promotions'            => $promotions,
            'promotion_active'      => $promotion_active,
            'promotion_inactive'    => $promotion_inactive
        ];
    }
}
