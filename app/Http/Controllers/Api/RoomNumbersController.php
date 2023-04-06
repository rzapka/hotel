<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\RoomNumber;
use Illuminate\Http\Request;

class RoomNumbersController extends Controller
{

    public function index()
    {
        return ApiResource::collection(RoomNumber::with('room')->get());
    }

    public function store(Request $request)
    {
        $id = $request->post('id');
        $room = RoomNumber::find($id);
        if ($room) {
            return response()->json(['success' => false, 'message' => 'Ten numer pokoju już istnieje']);
        } else {
            RoomNumber::create([
               'id' => $id,
               'number' => $id,
                'room_id' => $request->post('room_id'),
                'floor' => $request->post('floor')
            ]);
            return response()->json(['success' => true, 'message' => 'success']);
        }
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
        RoomNumber::find($id)->delete();
    }
}
