<?php

namespace App\Repository;
use App\Models\FoodOrder;
use Illuminate\Http\Request;

class FoodOrderRepository
{
    public static function createOrder(Request $request)
    {
        $price = $request->post('price');
        $foodModel = null;
        if ($price > 0) {
           $foodModel = FoodOrder::create([
                'room' => $request->post('room'),
                'price' => $price,
                'description' => $request->post('description'),
                'meals' => $request->post('meals'),
            ]);
        }
        return $foodModel;
    }
}
