<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Auth
Route::post('login', [\App\Http\Controllers\Api\UserController::class, 'login']);
Route::post('register', [\App\Http\Controllers\Api\UserController::class, 'register']);
Route::post('logout', [\App\Http\Controllers\Api\UserController::class, 'logout'])->middleware('auth:sanctum');

// Restaurant
Route::apiResource('meal-categories', App\Http\Controllers\Api\MealCategoriesController::class);
Route::post('only-meal-categories', [\App\Http\Controllers\Api\MealCategoriesController::class, 'onlyMealCategories']);
Route::apiResource('meals', App\Http\Controllers\Api\MealController::class);


// Attractions
Route::apiResource('attractions', App\Http\Controllers\Api\AttractionController::class);
Route::apiResource('booked-spa', App\Http\Controllers\Api\BookedSpaController::class);
Route::apiResource('booked-bowling', App\Http\Controllers\Api\BookedBowlingController::class);
Route::apiResource('booked-hall', App\Http\Controllers\Api\BookedHallController::class);
Route::apiResource('food-orders', App\Http\Controllers\Api\FoodOrdersController::class);


// Rooms
Route::post('available-rooms', [App\Http\Controllers\Api\BookedRoomController::class, 'getAvailableRooms']);
Route::post('has-booked-room', [App\Http\Controllers\Api\UserController::class, 'hasBookedRoom']);
Route::apiResource('booked-rooms', App\Http\Controllers\Api\BookedRoomController::class);
Route::apiResource('room-numbers', App\Http\Controllers\Api\RoomNumbersController::class);
Route::apiResource('rooms', App\Http\Controllers\Api\RoomController::class);

// Admin
Route::post('upload-images', [\App\Http\Controllers\Api\RoomController::class, 'uploadImages']);
Route::post('get-spa-employees', [\App\Http\Controllers\Api\UserController::class, 'getSpaEmployees']);
Route::post('get-user-booked-rooms', [\App\Http\Controllers\Api\BookedRoomController::class, 'getUserBookedRooms']);
Route::apiResource('notifications', App\Http\Controllers\Api\NotificationsController::class);
Route::apiResource('users', App\Http\Controllers\Api\UserController::class);

// Opinions
Route::apiResource('opinions', App\Http\Controllers\Api\OpinionsController::class);
Route::post('is-user-opinion', [\App\Http\Controllers\Api\OpinionsController::class, 'isUserOpinion']);

// Reservations
Route::get('reservations/rooms', [\App\Http\Controllers\Api\ReservationsController::class, 'room']);
Route::delete('reservations/delete-room/{id}', [\App\Http\Controllers\Api\ReservationsController::class, 'deleteRoom']);
Route::get('reservations/spa', [\App\Http\Controllers\Api\ReservationsController::class, 'spa']);
Route::delete('reservations/delete-spa/{id}', [\App\Http\Controllers\Api\ReservationsController::class, 'deleteSpa']);
Route::get('reservations/hall', [\App\Http\Controllers\Api\ReservationsController::class, 'hall']);
Route::delete('reservations/delete-hall/{id}', [\App\Http\Controllers\Api\ReservationsController::class, 'deleteHall']);
Route::get('reservations/bowling', [\App\Http\Controllers\Api\ReservationsController::class, 'bowling']);
Route::delete('reservations/delete-bowling/{id}', [\App\Http\Controllers\Api\ReservationsController::class, 'deleteBowling']);

