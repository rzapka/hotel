<?php

namespace App\Http\Controllers\Api;

use App\Helpers\DateHelper;
use App\Http\Controllers\Controller;
use App\Models\BookedBowling;
use App\Repository\BowlingRepository;
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
        $hours = $request->post('hours');
        DateHelper::checkIfTimePassed($day, $hours);
        if (!BowlingRepository::isBooked($track,$day,$hours)) {
            BowlingRepository::createReservation($track,$day,$hours);
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
