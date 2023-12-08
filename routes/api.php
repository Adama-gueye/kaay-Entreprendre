<?php

use App\Http\Controllers\Api\CommentaireController;
use App\Http\Controllers\Api\GuideController;
use App\Http\Controllers\Api\LivrableController;
use App\Http\Controllers\Api\RessourceController;
use App\Http\Controllers\Api\UserController;
use Egulias\EmailValidator\Parser\Comment;
use App\Http\Controllers\Api\DemandeAccompagnementController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APi\PartageExperienceController;
use App\Http\Controllers\APi\ReponseController;

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
    Route::post('logout',[UserController::class,'logout']);
    Route::get('user',[UserController::class,'userDetails']);
    Route::get('logout',[UserController::class,'logout']);
    Route::get('/users',[UserController::class,'listeUtilisteurs']);
    Route::post('/guideStore',[GuideController::class,'store']);
    Route::patch('/guideUpdate{id}',[GuideController::class,'update']);
    Route::get('/guideShow{id}',[GuideController::class,'show']);
    Route::get('/guideIndex',[GuideController::class,'index']);
    Route::delete('/guideDelete{id}',[GuideController::class,'destroy']);
    Route::post('/experience',[PartageExperienceController::class,'create']);

//partege Expérience
    Route::put('/experience/update{id}',[PartageExperienceController::class,'update']);
    Route::delete('/experience/suprimmer{id}',[PartageExperienceController::class,'destroy']);
    Route::post('/commentaire',[CommentaireController::class,'create']);
    Route::delete('/commentaire/sup{id}',[CommentaireController::class,'destroy']);
    Route::post('/reponse',[ReponseController::class,'create']);
    Route::delete('/reponse/sup{id}',[ReponseController::class,'destroy']);
//ressource
    Route::get('/ressourceIndex',[RessourceController::class,'index']);
    Route::post('/ressourceStore',[RessourceController::class,'store']);
    Route::delete('/ressourceDelete{id}',[RessourceController::class,'destroy']);
    Route::patch('/ressourceUpdate{id}',[RessourceController::class,'update']);
    Route::get('/ressourceShow{id}',[RessourceController::class,'show']);

//livrable
    Route::get('/ressourceIndex',[LivrableController::class,'index']);
    Route::post('/ressourceStore',[LivrableController::class,'store']);
    
//acommpagnement
    Route::post('/accompany/create', [DemandeAccompagnementController::class, 'store']);
    Route::delete('/post/{demandeAccompagnement}', [DemandeAccompagnementController::class, 'destroy']);
    Route::post('/accompany/create', [DemandeAccompagnementController::class, 'store']);
    Route::delete('/accompany/{id}', [DemandeAccompagnementController::class, 'destroy']);
    Route::get('/accompany', [DemandeAccompagnementController::class, 'index']);
    
    Route::get('/livrable', [LivrableController::class, 'index']);
    Route::get('/livrable/{id}', [LivrableController::class, 'show']);
    Route::post('/livrable/create', [LivrableController::class, 'store']);
    Route::patch('/livrable/{id}', [LivrableController::class, 'update']);
    Route::delete('/livrable/{id}', [LivrableController::class, 'destroy']);


});