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
use App\Models\Commentaire;








use App\Http\Controllers\OpenaiController;

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
Route::get('/goLogin', [UserController::class, function(){
    return response()->json(['message'=>'Veuillez vous connecter'],404);
}]);
//partage d'experiance


Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('logout', [UserController::class, 'logout']);
    Route::get('user', [UserController::class, 'userDetails']);
    Route::get('logout', [UserController::class, 'logout']);
    Route::get('/users', [UserController::class, 'listeUtilisteurs']);

    //guide
    Route::get('/guideIndex', [GuideController::class, 'index']);
    Route::post('/guideStore', [GuideController::class, 'store']);
    Route::patch('/guideUpdate{id}', [GuideController::class, 'update']);
    Route::get('/guideShow{id}', [GuideController::class, 'show']);
    Route::delete('/guideDelete{id}', [GuideController::class, 'destroy']);

    //ressource
    Route::get('/ressourceIndex', [RessourceController::class, 'index']);
    Route::post('ressourceStore{id}', [RessourceController::class, 'store']);
    Route::delete('/ressourceDelete{id}', [RessourceController::class, 'destroy']);
    Route::patch('/ressourceUpdate{id}', [RessourceController::class, 'update']);
    Route::get('/ressourceShow{id}', [RessourceController::class, 'show']);

    
//acommpagnement
    Route::post('/accompany/create', [DemandeAccompagnementController::class, 'store']);
    Route::delete('/post/{demandeAccompagnement}', [DemandeAccompagnementController::class, 'destroy']);
    Route::post('/accompany/create', [DemandeAccompagnementController::class, 'store']);
    Route::delete('/accompany/{id}', [DemandeAccompagnementController::class, 'destroy']);

    //livrable
    Route::get('/livrable/index', [LivrableController::class, 'index']);
    Route::get('/livrable/show/{id}', [LivrableController::class, 'show']);
    Route::post('/livrable/store/{ressourceId}', [LivrableController::class, 'store']);
    Route::delete('/livrable/{id}', [LivrableController::class, 'destroy']);

    //partege Expérience
    Route::get('/experienceIndex', [PartageExperienceController::class, 'index']);
    Route::get('/experience/{id}', [PartageExperienceController::class, 'show']);
    Route::post('/experienceStore', [PartageExperienceController::class, 'creation']);
    Route::put('/experience/update{id}', [PartageExperienceController::class, 'update']);
    Route::patch('/experience/edit{id}', [PartageExperienceController::class, 'edit']);
    Route::delete('/experience/suprimmer{id}', [PartageExperienceController::class, 'destroy']);

    //commentaire
    Route::get('/commentaireIndex', [CommentaireController::class, 'index']);
    Route::get('/commentaireShow/{id}', [CommentaireController::class, 'show']);
    Route::post('/commentaireCreate/{partageExperienceId}', [CommentaireController::class, 'create']);
    Route::delete('/commentaireDestroy/{id}', [CommentaireController::class, 'destroy']);

    //reponse
    Route::get('/reponse/index', [ReponseController::class, 'index']);
    Route::get('/reponse/show/{id}', [ReponseController::class, 'show']);
    Route::post('/reponse/create{commentaireId}', [ReponseController::class, 'create']);
    Route::delete('/reponse/{id}', [ReponseController::class, 'destroy']);


    // Route::get('/livrable', [LivrableController::class, 'index']);
    // Route::get('/livrable/{id}', [LivrableController::class, 'show']);
    // Route::post('/livrable/create', [LivrableController::class, 'store']);
    // Route::patch('/livrable/{id}', [LivrableController::class, 'update']);
    // Route::delete('/livrable/{id}', [LivrableController::class, 'destroy']);
});
