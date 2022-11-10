<?php
namespace App\Helpers;

use Carbon\Carbon;
use NumberFormatter;
use App\Models\Action;

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
        return $value.' jib';
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
}
