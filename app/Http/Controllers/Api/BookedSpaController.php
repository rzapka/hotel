<?php

namespace App\Http\Controllers\Api;

use App\Helpers\DateHelper;
use App\Http\Controllers\Controller;
use App\Models\BookedSpa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookedSpaController extends Controller
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
        $employeeId = $request->post('employee');
        $bookedSpa = BookedSpa::where('day', $day)->where('hours', $hours)->where('employee', $employeeId)->get();;
        if (!$bookedSpa->count()) {
            $user = Auth::user();
            BookedSpa::create([
                'booked_by' => $user['firstname'] . ' ' . $user['lastname'],
                'day' => $day,
                'hours' => $hours,
                'employee' => $employeeId,
                'user_id' => $user['id'],
            ]);
            $success = true;
            $message = 'success';
        } else {
            $success = false;
            $message = 'Niestety podany termin z tym pracownikiem jest już zarezerwowany';
        }
        return response()->json(['success' => $success, 'message' => $message]);
    }


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
