<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StatusOverviewController;
use App\Http\Controllers\TruckController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\TruckStatusController;
use App\Http\Controllers\DriverController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::any('/status_overview/index',[StatusOverviewController::class, 'index']);

Route::any('/truck/index',[TruckController::class, 'index']);
Route::any('/truck/add', [TruckController::class, 'add']);

Route::any('/status/index',[StatusController::class, 'index']);

Route::any('/driver/index',[DriverController::class, 'index']);

Route::any('/truck_status/index',[TruckStatusController::class, 'index']);
Route::post('/truck_status/update', [TruckStatusController::class, 'update']);

