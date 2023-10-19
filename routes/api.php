<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\StationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('company')
    ->name('company.')
    ->group(function () {
        Route::name('create')
            ->post('/', [CompanyController::class, 'create']);
        Route::name('get')
            ->get('/{id}', [CompanyController::class, 'get']);
        Route::name('update')
            ->put('/{id}', [CompanyController::class, 'update']);
        Route::name('delete')
            ->delete('/{id}', [CompanyController::class, 'delete']);
        Route::name('getClosest')
            ->get('/{id}/closestStations', [CompanyController::class, 'getClosestStations']);
});

Route::prefix('station')
    ->name('station.')
    ->group(function () {
        Route::name('create')
            ->post('/', [StationController::class, 'create']);
        Route::name('get')
            ->get('/{id}', [StationController::class, 'get']);
        Route::name('update')
            ->put('/{id}', [StationController::class, 'update']);
        Route::name('delete')
            ->delete('/{id}', [StationController::class, 'delete']);
    });

