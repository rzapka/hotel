<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\Meal;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MealController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return ApiResource::collection(Meal::with('mealCategory')->get());
    }

    public function store(Request $request)
    {
        Meal::create([
            'name' => $request->post('name'),
            'price' => $request->post('price'),
            'meal_category_id' => $request->post('meal_category_id'),
        ]);
    }


    public function show(Meal $meal): ApiResource
    {
        return new ApiResource($meal);
    }


    public function update(Request $request, $id)
    {
        Meal::find($id)->update([
            'name' => $request->post('name'),
            'price' => $request->post('price'),
            'meal_category_id' => $request->post('meal_category_id'),
        ]);
    }


    public function destroy($id)
    {
        Meal::find($id)->delete();
    }
}
