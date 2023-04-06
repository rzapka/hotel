<?php

namespace App\Http\Controllers\Api;

use App\Helpers\DateHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\BookedRoom;
use App\Models\RoomNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookedRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
       return ApiResource::collection(BookedRoom::where('user_id', Auth::id())->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $startingDate = $request->post('startingDate');
        if (date('Y-m-d') > $startingDate) {
            return response()->json(['success' => false, 'message' => 'Nie można zarezerwować pokoju z ubiegłą datą']);
        }

        $quantity = $request->post('quantity');
        BookedRoom::create([
            'booked_from' => $startingDate,
            'booked_to' => date('Y-m-d', strtotime($startingDate. ' + '. $quantity .'days')),
            'price' => $request->post('price'),
            'room_number_id' => $request->post('roomNumber'),
            'user_id' => Auth::id(),
        ]);
    }

    public function getAvailableRooms(Request $request)
    {
        $startingDate = $request->post('startingDate');
        $quantity = $request->post('quantity');
        $id = $request->post('id');
        $endDate = date('Y-m-d', strtotime($startingDate. ' + '. $quantity .'days'));
        $rooms = RoomNumber::with('bookedRooms')->where('room_id', $id)->get();
        $availableRooms = [];
        $bookedTime = DateHelper::dateRange($startingDate, $endDate);
        foreach ($rooms as $room) {

            if (!$room->bookedRooms->count()) {
                $availableRooms[] = $room;
            } else {
                foreach ($room->bookedRooms as $bookedRoom) {
                    $bookedRoomTime = DateHelper::dateRange($bookedRoom->booked_from, $bookedRoom->booked_to);
                    if (empty(array_intersect($bookedTime, $bookedRoomTime))) {
                        $availableRooms[] = $room;
                    }
                }
            }
        }
        return $availableRooms;
    }

    public function getUserBookedRooms()
    {
        $todayDate = date('Y-m-d');
        $bookedRooms = BookedRoom::where('user_id',Auth::id())->get();
        $todayRooms = [];
        foreach ($bookedRooms as $room) {
            if (in_array($todayDate, DateHelper::dateRange($room->booked_from, $room->booked_to))) {
                $todayRooms[] = $room->room_number_id;
            }
        }
        return $todayRooms;
    }
}
