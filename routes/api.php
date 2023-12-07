<?php

use App\Http\Controllers\CommentaireController;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\UserController;
use Egulias\EmailValidator\Parser\Comment;
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

Route::post('login',[UserController::class,'loginUser']);
Route::post('/register',[UserController::class,'createCompte'])->name('create');

Route::group(['middleware' => 'auth:sanctum'],function(){
    Route::get('user',[UserController::class,'userDetails']);
    Route::get('logout',[UserController::class,'logout']);
    Route::get('/users',[UserController::class,'listeUtilisteurs']);
    Route::post('/guideStore',[GuideController::class,'store']);
    Route::patch('/guideUpdate{id}',[GuideController::class,'update']);
    Route::get('/guideShow{id}',[GuideController::class,'show']);
    Route::get('/guideIndex',[GuideController::class,'index']);
    Route::delete('/guideDelete{id}',[GuideController::class,'destroy']);

});