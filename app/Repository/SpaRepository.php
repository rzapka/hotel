<?php

namespace App\Repository;

use App\Models\BookedSpa;
use Illuminate\Support\Facades\Auth;

class SpaRepository
{
    public static function createReservation($day, $hours, $employeeId)
    {
        $user = Auth::user();
        BookedSpa::create([
            'booked_by' => $user['firstname'] . ' ' . $user['lastname'],
            'day' => $day,
            'hours' => $hours,
            'employee' => $employeeId,
            'user_id' => $user['id'],
        ]);
    }

    public static function isBooked($day, $hours, $employeeId)
    {
       return BookedSpa::where('day', $day)->where('hours', $hours)->where('employee', $employeeId)->first();
    }
}
