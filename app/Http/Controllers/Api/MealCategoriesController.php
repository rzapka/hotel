<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\MealCategory;
use Illuminate\Http\Request;

class MealCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return ApiResource::collection(MealCategory::with('meals')->get());
    }

    public function onlyMealCategories(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return ApiResource::collection(MealCategory::all());
    }

    public function store(Request $request)
    {
       $category = MealCategory::create(['name' => $request->post('name')]);
       return response()->json(['category' => $category]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       MealCategory::find($id)->delete();
    }
}
