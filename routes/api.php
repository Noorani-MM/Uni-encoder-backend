<?php

use App\Http\Controllers\Api\V1\CryptoHandlerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(CryptoHandlerController::class)->group(function () {
    Route::post('encrypt', 'encrypt');
    Route::post('decrypt', 'decrypt');
});
