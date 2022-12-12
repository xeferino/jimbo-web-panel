<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Exception;

class LegalityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function legality(Request $request)
    {
        try {
            $terms_and_conditions = Setting::where('name', 'terms_and_conditions')->first();
            $game_rules = Setting::where('name', 'game_rules')->first();
            $policies_privacy = Setting::where('name', 'policies_privacy')->first();
            return response()->json([
                'legality'   => $terms_and_conditions->value,
                'game'       => $game_rules->value,
                'privacity'  => $policies_privacy->value
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status'   => 500,
                'message' =>  $e->getMessage()
            ], 500);
        }
    }
}
