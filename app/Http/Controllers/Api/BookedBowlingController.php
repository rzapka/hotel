<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BookedBowling;
use App\Models\BookedSpa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookedBowlingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $track = $request->post('track');
        $day = $request->post('day');
        $today = Carbon::now()->format('Y-m-d');
        $nowHour = Carbon::now()->format('H:i');
        $hours = $request->post('hours');
        $startHour = trim(explode('-', $hours)[0]);
        if (strtotime($nowHour) >= strtotime($startHour) && $today == $day) {
            return response()->json(['success' => false, 'message' => 'Niestety godziny, w których chcesz zarezerwować juz upłynęły']);
        }
        $bookedBowling = BookedBowling::where('track', $track)->where('hours', $hours)->where('day', $day)->get();;
        if (!$bookedBowling->count()) {
            $user = Auth::user();
            BookedBowling::create([
                'booked_by' => $user['firstname'] . ' ' . $user['lastname'],
                'track' => $track,
                'day' => $day,
                'hours' => $hours,
                'user_id' => Auth::id()
            ]);
            $success = true;
            $message = 'success';
        } else {
            $success = false;
            $message = 'Niestety ten tor o tej porze jest juz zarezerwowany';
        }
        return response()->json(['success' => $success, 'message' => $message]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
