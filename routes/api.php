<?php

use App\Http\Controllers\LeaveApplicationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/leave-applications', [LeaveApplicationController::class, 'store']);
