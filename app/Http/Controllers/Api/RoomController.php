<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\Room;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class RoomController extends Controller
{

    public function index()
    {
        return ApiResource::collection(Room::all());
    }


    public function store(Request $request)
    {
        Room::create([
            'name' => $request->post('name'),
            'description' => $request->post('description'),
            'area' => $request->post('area'),
            'price' => $request->post('price'),
            'images' => $request->post('images'),
        ]);
    }

    public function show(Room $room)
    {
        return new ApiResource($room);
    }


    public function update(Request $request, $id)
    {
        try {
            Room::find($id)->update([
                'name' => $request->post('name'),
                'description' => $request->post('description'),
                'area' => $request->post('area'),
                'price' => $request->post('price'),
                'images' => $request->post('images'),
            ]);
            $success = true;
            $message = 'Pomyślnie zaktualizowano dane';
        } catch (\Exception $exception) {
            $success = false;
            $message = 'Cos poszło nie tak';
        }
        return response()->json(['success' => $success, 'message' => $message]);
    }

    public function uploadImages()
    {
        $data = [];
        $formats = ['jpeg', 'jpg', 'png', 'svg', 'bmp', 'gif', 'webp'];
        foreach($_FILES['files'] as $name => $row) {
            foreach ($row as $key => $value) {
                $exploded = explode('.', $value);
                $format = end($exploded);
                if ($name == 'name' && !in_array($format, $formats)) {
                    return response()->json(['success' => false, 'message' => 'Niepoprawny format zdjęcia.']);
                }
                $data[$key][$name] = $value;
            }
        }
        try {
            foreach ($data as $row) {
                move_uploaded_file($row['tmp_name'], storage_path('app\public\rooms\\'.strtolower($row['name'])));
            }
            $success = true;
            $message = 'Pomyślnie zaktualizowano dane';
        } catch (\Exception $e) {
            $success = false;
            $message = 'Cos poszło nie tak';
        }
        return response()->json(['success' => $success, 'message' => $message]);
    }

    public function destroy($id)
    {
        Room::find($id)->delete();
    }

}
