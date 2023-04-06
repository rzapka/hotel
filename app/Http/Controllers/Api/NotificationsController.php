<?php

namespace App\Http\Controllers\Api;

use App\Helpers\NotificationsHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        switch($user['admin_category_id']) {
            case 1:
                return ApiResource::collection(Notification::whereIn('category', ['room', 'spa', 'bowling'])->latest()->get());
            case 2:
                return ApiResource::collection(Notification::where('category', 'spa')->where('user_id', $user['id'])->latest()->get());
            case 3:
                return ApiResource::collection(Notification::where('category', 'foodDelivery')->latest()->get());
        }
    }

    public function store(Request $request)
    {
        $now = Carbon::now();
        Notification::create([
              'name' => "Powiadomienie z $now",
              'message' => NotificationsHelper::execute($request),
              'displayed' => false,
              'category' => $request->post('category'),
              'user_id' => $request->post('user_id'),
               'created_at' => $now,
               'updated_at' => $now,
           ]);
    }

    public function update(Notification $notification, Request $request)
    {
        $notification->update(['displayed' => $request->post('displayed')]);
    }
}
