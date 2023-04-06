<?php

namespace App\Http\Controllers\Api;

use App\Helpers\DateHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\BookedBowling;
use App\Models\BookedHall;
use App\Models\BookedRoom;
use App\Models\BookedSpa;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ReservationsController extends Controller
{
    public function room()
    {
        return ApiResource::collection(BookedRoom::where('user_id', Auth::id())->orderBy('booked_from', 'desc')->get());
    }

    public function deleteRoom($id)
    {
        $bookedRoom = BookedRoom::find($id);
        $range = DateHelper::dateRange($bookedRoom->booked_from, $bookedRoom->booked_to);
        $bookedSpaCollection = BookedSpa::where('user_id', Auth::id())->orderBy('day', 'desc')->get();
        $bookedBowlingCollection = BookedBowling::where('user_id', Auth::id())->orderBy('day', 'desc')->get();
        $bookedHallCollection = BookedHall::where('user_id', Auth::id())->orderBy('day','desc')->get();
        $this->deleteItemIfInDateRange($bookedSpaCollection, $range);
        $this->deleteItemIfInDateRange($bookedBowlingCollection, $range);
        $this->deleteItemIfInDateRange($bookedHallCollection, $range);
        $bookedRoom->delete();
    }

    public function spa()
    {
        $collection = BookedSpa::where('user_id', Auth::id())->orderBy('day', 'desc')->get();
        foreach ($collection as &$row) {
            $employee = User::find($row->employee);
            $row->employee_firstname = $employee->firstname;
            $row->employee_lastname = $employee->lastname;
        }
        return ApiResource::collection($collection);
    }

    public function deleteSpa($id)
    {
        BookedSpa::find($id)->delete();
    }

    public function bowling()
    {
        return ApiResource::collection(BookedBowling::where('user_id', Auth::id())->orderBy('day', 'desc')->get());
    }

    public function deleteBowling($id)
    {
        BookedBowling::find($id)->delete();
    }

    public function hall()
    {
        return ApiResource::collection(BookedHall::where('user_id', Auth::id())->orderBy('day','desc')->get());
    }

    public function deleteHall($id)
    {
        BookedHall::find($id)->delete();
    }

    public function deleteItemIfInDateRange(&$collection, $dateRange)
    {
        foreach ($collection as &$row) {
            if (in_array($row->day, $dateRange)) {
                $row->delete();
            }
        }
    }

}
