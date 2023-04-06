<?php

namespace App\Http\Controllers\Api;

use App\Helpers\DateHelper;
use App\Http\Controllers\Controller;
use App\Models\BookedHall;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookedHallController extends Controller
{

    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $day = $request->post('day');
        $hours = $request->post('hours');
        DateHelper::checkIfTimePassed($day, $hours);

        $bookedSpa = BookedHall::where('day', $day)->where('hours', $hours)->get();;
        if (!$bookedSpa->count()) {
            $user = Auth::user();
            BookedHall::create([
                'booked_by' => $user['firstname'] . ' ' . $user['lastname'],
                'day' => $day,
                'hours' => $hours,
                'user_id' => Auth::id()
            ]);
            $success = true;
            $message = 'success';
        } else {
            $success = false;
            $message = 'Niestety sala w tym terminie jest juz zarezerwowana';
        }
        return response()->json(['success' => $success, 'message' => $message]);
    }


    public function show($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
