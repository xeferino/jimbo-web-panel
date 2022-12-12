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
        $terms_and_conditions = DB::table('settings')->where('name', 'terms_and_conditions')->first();
        return view('landing.term_conditions', [
            'title'  => 'Jimbo Sorteos',
            'terms_and_conditions' => $terms_and_conditions->value
        ]);
    }

    public function privacy(Request $request)
    {
        $policies_privacy = DB::table('settings')->where('name', 'policies_privacy')->first();
        return view('landing.privacy_policies', [
            'title'  => 'Jimbo Sorteos',
            'policies_privacy' => $policies_privacy->value
        ]);
    }

    public function game(Request $request)
    {
        $game_rules = DB::table('settings')->where('name', 'game_rules')->first();
        return view('landing.rules_game', [
            'title'  => 'Jimbo Sorteos',
            'game_rules' => $game_rules->value
        ]);
    }

    public function faq(Request $request)
    {

        $faqs = DB::table('settings')->where('name', 'faqs')->first();
        return view('landing.faqs', [
            'title'  => 'Jimbo Sorteos',
            'faqs' => $faqs->value
        ]);
    }
}
