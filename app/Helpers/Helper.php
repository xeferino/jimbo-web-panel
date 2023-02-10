<?php
namespace App\Helpers;

use Carbon\Carbon;
use NumberFormatter;
use App\Models\Action;
use App\Models\User;
use App\Models\Setting;
class Helper
{
    /**
     * Return amount formated
     *
     * @param float $amount
     * @return string
     */
    public static function amount($value)
	{
		return NumberFormatter::create( 'en_US', NumberFormatter::CURRENCY )->formatCurrency($value, 'USD');
	}


    /**
     * Return amount formated
     *
     * @param float $amount
     * @return string
     */
    public static function amountJib($value)
	{
        $jib_unit = Setting::where('name', 'jib_unit_x_usd')->first();
        $jib_usd = Setting::where('name', 'jib_usd')->first();
        return  (($value*$jib_unit->value)/$jib_usd->value).' JIB';
	}

    /**
     * Return percent formated
     *
     * @param float $percent
     * @return string
     */
    public static function percent($value)
	{
        return sprintf("%.2f%%", $value);
	}

     /**
     * Return jib formated
     *
     * @param float $jib
     * @return string
     */
    public static function jib($value)
	{
        return $value.' JIB';
	}

    /**
     * Return list resource notifications
     *
     * @param float $jib
     * @return string
     */
    public static function notifications()
	{
       return  Action::select('id', 'title', 'description', 'created_at AS date')
                ->offset(0)->limit(4)
                ->orderBy('actions.id','DESC')
                ->get();
	}

     /**
     * Return object user
     *
     * @param float $jib
     * @return string
     */
    public static function user($id)
	{
        return User::find($id);
	}
}
