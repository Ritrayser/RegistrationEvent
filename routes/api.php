<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UserToEventController;

Route::post('user/register',[AuthController::class, 'register']);
Route::post('user/login',[AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
  Route::apiResource('event', EventController::class);
  Route::post('event/{event}/register',  [UserToEventController::class, 'register']);
  Route::post('event/{event}/cancel',  [UserToEventController::class, 'cancel']);
  Route::get('event/{event}/participants', [UserToEventController::class, 'getParticipants']);
});
