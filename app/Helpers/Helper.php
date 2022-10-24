<?php
namespace App\Helpers;

use Carbon\Carbon;
use NumberFormatter;

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

}
