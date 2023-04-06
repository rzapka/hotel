<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ValidateUser;
use App\Http\Resources\ApiResource;
use App\Models\BookedRoom;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $success = Auth::attempt(['email' => $request->email, 'password' => $request->password]);
        $message = $success ? 'Proces zalogowania przebiegł pomyślnie' : 'Niepoprawny email lub hasło';
        return response()->json(['success' => $success, 'message' => $message]);
    }

    public function register(ValidateUser $request)
    {
        try {
            $user = new User();
            $data = $request->validated();
            $user->email = $data['email'];
            $user->firstname = $data['firstname'];
            $user->lastname = $data['lastname'];
            $user->company = $data['company'];
            $user->nip = $data['nip'];
            $user->isCompany = (bool) $data['nip'] ;
            $user->phonenumber = $data['phonenumber'];
            $user->password = Hash::make($data['password']);
            $user->save();

            $success = true;
            $message = 'Pomyślnie utworzono użytkownika';
        } catch (\Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        return response()->json(['success' => $success, 'message' => $message]);
    }

    public function logout()
    {
        try {
            Session::flush();
            $success = true;
            $message = 'Wylogowano pomyślnie';
        } catch (QueryException $e) {
            $success = false;
            $message = 'Cos poszło nie tak';
        }

        return response()->json(['success' => $success, 'message' => $message]);
    }

    public function getSpaEmployees(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return ApiResource::collection(User::where('admin_category_id', 2)->get());
    }


    public function hasBookedRoom()
    {
        $bookedRoom = BookedRoom::where('user_id', Auth::id())->whereDate('booked_from', '>=', date('Y-m-d'))->get();
        return $bookedRoom->count();
    }

    public function index()
    {
        return ApiResource::collection(User::where('admin_category_id', null)->get());
    }

    public function show(User $user)
    {
        return new ApiResource($user);
    }

    public function update(User $user, Request $request)
    {
        $password = $request->post('password');
        $user->update([
            'firstname' => $request->post('firstname'),
            'lastname' => $request->post('lastname'),
            'company' => $request->post('company'),
            'nip' => $request->post('nip'),
            'email' => $request->post('email'),
            'phonenumber' => $request->post('phonenumber'),
            'password' => $password ? Hash::make($password) : $user->password,
        ]);
    }

    public function destroy(User $user)
    {
        $user->delete();
    }
}
