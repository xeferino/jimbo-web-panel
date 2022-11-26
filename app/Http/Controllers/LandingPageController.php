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
use App\Models\Setting;

class LandingPageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function home(Request $request)
    {
        return view('landing.page', [
            'title'  => 'Jimbo Sorteos'
        ]);
    }

    public function term(Request $request)
    {
        return view('landing.term_conditions', [
            'title'  => 'Jimbo Sorteos'
        ]);
    }

    public function privacy(Request $request)
    {
        $privacy_policies = DB::table('settings')->where('name', 'terms_and_conditions')->first();
        return view('landing.privacy_policies', [
            'title'  => 'Jimbo Sorteos',
            'privacy_policies' => $privacy_policies->value
        ]);
    }

    public function faq(Request $request)
    {

        return view('landing.faq', [
            'title'  => 'Jimbo Sorteos'
        ]);
    }
}
