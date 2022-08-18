<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\StockController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\PurchaseController;

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

Route::prefix('v1')->group(
    function () {
        //========= Auth ==========/
        Route::prefix('/auth')->group(
            function () {
                Route::post('/login', [AuthController::class, 'login']);
            }
        );
        Route::middleware('auth')->group(
            function () {
                Route::prefix('/client')->group(
                    function () {
                        Route::post('/', [ClientController::class, 'store']);
                        Route::get('/', [ClientController::class, 'index']);
                        Route::get('/{id}/stocks', [ClientController::class, 'show']);
                    }
                );
                Route::prefix('/stock')->group(
                    function () {
                        Route::delete('/', [StockController::class, 'destroy']);
                        Route::put('/', [StockController::class, 'update']);
                        Route::post('/', [StockController::class, 'store']);
                        Route::get('/', [StockController::class, 'index']);
                    }
                );
                Route::prefix('/purchase')->group(
                    function () {
                        Route::post('/', [PurchaseController::class, 'store']);
                    }
                );
            }
        );
    }
);
