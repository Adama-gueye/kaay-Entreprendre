<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DemandeAccompagnementController;

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

Route::post('/accompany/create', [DemandeAccompagnementController::class, 'store']);
Route::delete('/post/{demandeAccompagnement}', [DemandeAccompagnementController::class, 'destroy']);


// Route::get('/posts', [PostController::class, 'index']);
//     Route::post('/post/create', [PostController::class, 'store']);
//     Route::put('/post/edit/{post}', [PostController::class, 'update']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
