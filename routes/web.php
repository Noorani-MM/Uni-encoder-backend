<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('app', ['message' => '', 'result' => '', 'success' => true]);
});

Route::post('/', [\App\Http\Controllers\CryptoHandlerController::class, 'handle'])
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class])
    ->name('crypto.handler');
