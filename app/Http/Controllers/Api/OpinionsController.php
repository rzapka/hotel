<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\Opinion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OpinionsController extends Controller
{

    public function index()
    {
        return ApiResource::collection(Opinion::with('user')->get());
    }

    public function store(Request $request)
    {
       Opinion::create([
           'user_id' => Auth::id(),
           'message' => $request->post('message'),
           'stars' => $request->post('stars'),
           'date' => date('Y-m-d')
       ]);
    }


    public function show(Opinion $opinion)
    {
        return new ApiResource($opinion);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Opinion::find($id)->update([
            'message' => $request->post('message'),
            'stars' => $request->post('stars'),
            'date' => date('Y-m-d')
        ]);
    }


    public function destroy(Opinion $opinion)
    {
        $opinion->delete();
    }

    public function isUserOpinion()
    {
        $opinion = Opinion::where('user_id', Auth::id())->first();
        if ($opinion) {
            $isOpinion = true;
            $opinionId = $opinion->id;
        } else {
            $isOpinion = false;
            $opinionId = 0;
        }
        return response()->json(['isUserOpinion' => $isOpinion, 'opinionId' => $opinionId]);
    }
}
