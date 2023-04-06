<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FoodOrder;
use App\Repository\FoodOrderRepository;
use Illuminate\Http\Request;

class FoodOrdersController extends Controller
{
    public function store(Request $request)
    {
        $foodOrder = FoodOrderRepository::createOrder($request);
        if ($foodOrder) {
            $success = true;
            $message = 'success';
        } else {
            $success = false;
            $message = 'Najpierw musisz coś zamówić!';
        }
        return response()->json(['success' => $success, 'message' => $message]);
    }

}
