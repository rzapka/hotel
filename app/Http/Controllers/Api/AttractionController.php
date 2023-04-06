<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\Attraction;
use Illuminate\Http\Request;

class AttractionController extends Controller
{

    public function index()
    {
       return ApiResource::collection(Attraction::all());
    }

    public function show(Attraction $attraction)
    {
        return new ApiResource($attraction);
    }


    public function update(Request $request, $id)
    {
        Attraction::find($id)->update([
           'title' => $request->post('title'),
           'description' => $request->post('description'),
           'icon' => $request->post('icon'),
           'color' => $request->post('color')
        ]);
    }
}
