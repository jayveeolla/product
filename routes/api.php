<?php

use App\Http\Controllers\Api\V1\Admin as Admin;
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

Route::prefix('v1')->name('api.')->group(function () {
    Route::post('/login', [Admin\AuthController::class, 'login'])->name('login');
  
    Route::apiResources([]);
});

Route::prefix('v1')->name('api.')->middleware('auth:sanctum')->group(function () {


    Route::post('/change_password', [Admin\AuthController::class, 'change_password'])->name('customer.change_password');

    Route::post('weeks/upload', [Admin\WeekController::class, 'upload'])->name('week.upload');


    Route::apiResources([
        'weeks' => Admin\WeekController::class,
    ]);
});
