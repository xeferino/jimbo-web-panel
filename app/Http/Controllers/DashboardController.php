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
        $top = Sale::select(DB::raw("CONCAT(users.names,' ',users.surnames) AS fullnames"), DB::raw('SUM(amount) as amount'))
                ->join('users', 'users.id', '=', 'sales.seller_id')
                ->groupBy('sales.seller_id')
                ->groupBy('sales.id')
                ->whereNotNull('sales.seller_id')
                ->offset(0)->limit(10)
                ->orderBy('sales.id','DESC')
                ->get();
        return [
            'top'  => $top
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

        return [
            'raffles'           => $raffles,
            'raffle_open'       => $raffle_open,
            'raffle_close'      => $raffle_close,
            'raffle_public'     => $raffle_public,
            'raffle_draft'      => $raffle_draft,
            'raffle_active'     => $raffle_active,
            'raffle_inactive'   => $raffle_inactive,
            'raffle_p'          => $raffle_p,
            'raffle_r'          => $raffle_r
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
