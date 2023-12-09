<?php

use Illuminate\Http\Request;
use App\Models\PartageExperience;
use Illuminate\Support\Facades\Route;
use Egulias\EmailValidator\Parser\Comment;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\GuideController;
use App\Http\Controllers\APi\ReponseController;
use App\Http\Controllers\Api\LivrableController;
use App\Http\Controllers\Api\RessourceController;
use App\Http\Controllers\Api\CommentaireController;
use App\Http\Controllers\APi\PartageExperienceController;
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




Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [UserController::class, 'loginUser']);
Route::post('/register', [UserController::class, 'createCompte']);
//partage d'experiance

 //ShareExperience
 Route::post('/testRoute', [PartageExperienceController::class, 'test'] );


Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('logout', [UserController::class, 'logout']);
    Route::get('user', [UserController::class, 'userDetails']);
    Route::get('logout', [UserController::class, 'logout']);
    Route::get('/users', [UserController::class, 'listeUtilisteurs']);
    Route::post('/guideStore', [GuideController::class, 'store']);
    Route::patch('/guideUpdate{id}', [GuideController::class, 'update']);
    Route::get('/guideShow{id}', [GuideController::class, 'show']);
    Route::get('/guideIndex', [GuideController::class, 'index']);
    Route::delete('/guideDelete{id}', [GuideController::class, 'destroy']);
    
    //partege Expérience
    Route::get('/experienceIndex', [PartageExperienceController::class, 'index']);
    Route::get('/experience/{id}', [PartageExperienceController::class, 'show']);
    Route::post('/experienceStore', [PartageExperienceController::class, 'creation']);
    Route::put('/experience/update{id}', [PartageExperienceController::class, 'update']);
    Route::delete('/experience/suprimmer{id}', [PartageExperienceController::class, 'destroy']);
    
    //commentaire
    Route::get('/commentaireIndex', [CommentaireController::class, 'index']);
    Route::get('/commentaireShow/{id}', [CommentaireController::class, 'show']);
    Route::post('/commentaire', [CommentaireController::class, 'create']);
    Route::delete('/commentaire/sup{id}', [CommentaireController::class, 'destroy']);

    //reponse
    Route::post('/reponse', [ReponseController::class, 'create']);
    Route::delete('/reponse/sup{id}', [ReponseController::class, 'destroy']);

    //ressource
    Route::get('/ressourceIndex', [RessourceController::class, 'index']);
    Route::post('/ressourceStore', [RessourceController::class, 'store']);
    Route::delete('/ressourceDelete{id}', [RessourceController::class, 'destroy']);
    Route::patch('/ressourceUpdate{id}', [RessourceController::class, 'update']);
    Route::get('/ressourceShow{id}', [RessourceController::class, 'show']);

    //livrable
    Route::get('/ressourceIndex', [LivrableController::class, 'index']);
    Route::post('/ressourceStore', [LivrableController::class, 'store']);

    //acommpagnement
    Route::get('/accompany', [DemandeAccompagnementController::class, 'index']);
    Route::get('/accompany/{id}', [DemandeAccompagnementController::class, 'show']);
    Route::post('/accompany/create', [DemandeAccompagnementController::class, 'store']);
    Route::delete('/accompany/{id}', [DemandeAccompagnementController::class, 'destroy']);

    Route::get('/livrable', [LivrableController::class, 'index']);
    Route::get('/livrable/{id}', [LivrableController::class, 'show']);
    Route::post('/livrable/create', [LivrableController::class, 'store']);
    Route::patch('/livrable/{id}', [LivrableController::class, 'update']);
    Route::delete('/livrable/{id}', [LivrableController::class, 'destroy']);
});
