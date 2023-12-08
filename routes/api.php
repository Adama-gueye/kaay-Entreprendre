<?php

use App\Http\Controllers\CommentaireController;
use App\Http\Controllers\Api\GuideController;
use App\Http\Controllers\UserController;
use Egulias\EmailValidator\Parser\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DemandeAccompagnementController;
use App\Http\Controllers\Api\RessourceController;
use App\Http\Controllers\Api\LivrableController;

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
    
    Route::post('/accompany/create', [DemandeAccompagnementController::class, 'store']);
    Route::delete('/accompany/{id}', [DemandeAccompagnementController::class, 'destroy']);
    Route::get('/accompany', [DemandeAccompagnementController::class, 'index']);
    
    Route::get('/livrable', [LivrableController::class, 'index']);
    Route::get('/livrable/{id}', [LivrableController::class, 'show']);
    Route::post('/livrable/create', [LivrableController::class, 'store']);
    Route::patch('/livrable/{id}', [LivrableController::class, 'update']);
    Route::delete('/livrable/{id}', [LivrableController::class, 'destroy']);

    // Route::get('/livrable/{id}', [LivrableController::class, 'show']);
    // Route::post('/livrable/create', [LivrableController::class, 'store']);
    // Route::patch('/livrable/update{id}', [LivrableController::class, 'update']);   
    // Route::delete('/livrable/{id}', [LivrableController::class, 'destroy']);


});