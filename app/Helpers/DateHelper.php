<?php

namespace App\Helpers;

use App\Models\RoomNumber;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DateHelper
{
    public static function dateRange($first, $last, $step = '+1 day', $output_format = 'Y-m-d')
    {

        $dates = [];
        $current = strtotime($first);
        $last = strtotime($last);

        while ($current <= $last) {

            $dates[] = date($output_format, $current);
            $current = strtotime($step, $current);
        }

        return $dates;
    }

    public static function checkIfTimePassed($day, $hours)
    {
        $today = Carbon::now()->format('Y-m-d');
        $nowHour = Carbon::now()->format('H:i');
        $startHour = trim(explode('-', $hours)[0]);
        if (strtotime($nowHour) >= strtotime($startHour) && $today == $day) {
            return response()->json(['success' => false, 'message' => 'Niestety godziny, w których chcesz zarezerwować juz upłynęły']);
        }
    }
}
