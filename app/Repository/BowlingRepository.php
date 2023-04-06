<?php

namespace App\Repository;

use App\Models\BookedBowling;
use Illuminate\Support\Facades\Auth;

class BowlingRepository
{
    public static function createReservation($track, $day, $hours)
    {
        $user = Auth::user();
        BookedBowling::create([
            'booked_by' => $user['firstname'] . ' ' . $user['lastname'],
            'track' => $track,
            'day' => $day,
            'hours' => $hours,
            'user_id' => $user['id']
        ]);
    }

    public static function isBooked($track, $day, $hours)
    {
        return BookedBowling::where('track', $track)->where('hours', $hours)->where('day', $day)->first();
    }
}
