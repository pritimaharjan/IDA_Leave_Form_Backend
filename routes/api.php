<?php

use App\Http\Controllers\LeaveApplicationController;
use App\Http\Controllers\LeaveTypeController;
use App\Http\Controllers\UserController;
use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/leave-applications', [LeaveApplicationController::class, 'store']);
Route::get('/users/{email}', [UserController::class, 'show']);
Route::get('/leave-types', [LeaveTypeController::class, 'show']);

Route::get('/departments', function () {
    return \App\Models\Department::all();
});

Route::get('/leave', function () {
    return Leave::all();
});
