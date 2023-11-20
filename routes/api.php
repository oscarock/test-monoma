<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AspirantController;

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

Route::post('/auth', [AuthController::class, 'authenticate']);

Route::middleware('custom.jwt')->group(function () {
    Route::get('/leads', [AspirantController::class, 'index'])->name('aspirants.index');
    Route::get('/leads/{id}', [AspirantController::class, 'show'])->name('aspirants.show');
    Route::post('/leads', [AspirantController::class, 'store'])->name('aspirants.store');
});