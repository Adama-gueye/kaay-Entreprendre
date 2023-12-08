<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

use App\Http\Controllers\GuideController;
use Egulias\EmailValidator\Parser\Comment;
use App\Http\Controllers\CommentaireController;
use App\Http\Controllers\LivrableController;
use App\Http\Controllers\PartageExperienceController;
use App\Http\Controllers\ReponseController;

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

Route::post('login',[UserController::class,'loginUser']);
Route::post('/register',[UserController::class,'createCompte'])->name('create');
//partage d'experiance




Route::group(['middleware' => 'auth:sanctum'],function(){
    Route::get('user',[UserController::class,'userDetails']);
    Route::get('logout',[UserController::class,'logout']);
    Route::get('/users',[UserController::class,'listeUtilisteurs']);
    Route::post('/guideStore',[GuideController::class,'store']);
    Route::patch('/guideUpdate{id}',[GuideController::class,'update']);
    Route::get('/guideShow{id}',[GuideController::class,'show']);
    Route::get('/guideIndex',[GuideController::class,'index']);
    Route::delete('/guideDelete{id}',[GuideController::class,'destroy']);
    Route::post('/experience',[PartageExperienceController::class,'create']);
    
Route::put('/experience/update{id}',[PartageExperienceController::class,'update']);
Route::delete('/experience/suprimmer{id}',[PartageExperienceController::class,'destroy']);
Route::post('/commentaire',[CommentaireController::class,'create']);
Route::delete('/commentaire/sup{id}',[CommentaireController::class,'destroy']);
Route::post('/reponse',[ReponseController::class,'create']);
Route::delete('/reponse/sup{id}',[ReponseController::class,'destroy']);
Route::delete('/livrablle/sup{id}',[LivrableController::class,'destroy']);





});