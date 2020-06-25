<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 17/05/2019
 * Time: 10:58 AM
 */

namespace App\Traits;
use Exception;
use Illuminate\Support\Carbon;

trait Deadline
{

    /**
     * Set a days passed into a month limit and confirm if the month is the same after subtracting x days
     *
     * @param int $limit the number of days to subtract
     * @return bool true if the month is the same
     */
    public static function dateSubLimit($limit = 10)
    {
        return (Carbon::now()->subDays($limit)->month == Carbon::now()->month);
    }

    public static function dateLimitMonth($limit = 10)
    {
        return Carbon::now()->subDays($limit)->localeMonth;
    }

    public static function dateFromTimestamp($timestamp)
    {
        return Carbon::createFromTimestamp(strtotime($timestamp))->toDateString();
    }

    public static function isSubMonth($month = 0)
    {
        return Carbon::now()->subMonths($month)->toDateString();
    }

    public static function firstOfMonth($timestamp, $adjustmonths = 0)
    {
        try { return Carbon::createFromTimestamp($timestamp)->addMonths($adjustmonths)->firstOfMonth(); } catch (Exception $exception){ }
        try { return Carbon::createFromDate($timestamp)->addMonths($adjustmonths)->firstOfMonth(); } catch (Exception $exception){ }
        return response();
    }

    public static function lastOfMonth($timestamp, $adjustmonths = 0)
    {
        try { return Carbon::createFromTimestamp($timestamp)->addMonths($adjustmonths)->lastOfMonth(); } catch (Exception $exception){ }
        try { return Carbon::createFromDate($timestamp)->addMonths($adjustmonths)->lastOfMonth(); } catch (Exception $exception){ }
        return response();
    }
}