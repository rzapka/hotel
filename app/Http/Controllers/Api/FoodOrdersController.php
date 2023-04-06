<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FoodOrder;
use Illuminate\Http\Request;

class FoodOrdersController extends Controller
{
    public function store(Request $request)
    {
        $price = $request->post('price');
        if ($price > 0) {
            FoodOrder::create([
                'room' => $request->post('room'),
                'price' => $price,
                'description' => $request->post('description'),
                'meals' => $request->post('meals'),
            ]);
            $success = true;
            $message = 'success';
        } else {
            $success = false;
            $message = 'Najpierw musisz coś zamówić!';
        }
        return response()->json(['success' => $success, 'message' => $message]);
    }

}
