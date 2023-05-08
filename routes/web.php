<?php


use App\Http\Controllers\Page\Admin\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Page\Admin as Admin;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::middleware(['role:Admin|Customer'])->name('admin.')->prefix('admin')->group(function () {
        Route::get('', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('weeks/{id}/duplicate', [Admin\WeekController::class, 'duplicate'])->name('weeks.duplicate');

        Route::resources([
            'product' => Admin\WeekController::class,
        ], ['only' => ['index', 'create', 'show', 'edit']]);
    });
});
