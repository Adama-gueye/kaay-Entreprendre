<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\PartageExperience;
use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\PartageExperienceRequest;
use Illuminate\Support\Facades\Auth;
use App\Traits\ReturnJsonResponseTrait;
use Illuminate\Database\Eloquent\Model;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     description="Endpoind PartageExperience",
 *     version="1.0.0",
 *     title="Swagger Petstore"
 * )
 */
class PartageExperienceController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    use ReturnJsonResponseTrait;

    /**
     * 
     * @OA\Get(
     *     path="/api/experienceIndex",
     *     summary="Afficher la liste des partages d'expérience",
     *     @OA\Response(response="200", description="succes"),
     * )
     */

    public function index()
    {
        return $this->returnJsonResponse(200, 'Liste des expériences partagé', PartageExperience::all());
    }

    /**
     * 
     * @OA\post(
     *     path="/api/experienceStore",
     *     summary="Enregistrer un  partage d'expérience",
     *     @OA\Response(response="200", description="succes"),
     * )
     */
    public function creation(CreatePostRequest $request)
    {
        return $this->returnJsonResponse(200, 'Votre experience à été ajouté avec sucess', $request->validated(), PartageExperience::create($request->all()));
    }

    /**
     * 
     * @OA\put(
     *     path="/api/experience/update{id}",
     *     summary="Mettre à jour un partages d'expérience",
     *     @OA\Response(response="200", description="succes"),
     *     @OA\Response(response="422", description="Vous nest pas lauteur de ce post"),
     * )
     */

    public function update(CreatePostRequest $request, $id)
    {
        $partageExperience = PartageExperience::find($id);
        return auth()->user()->id !== $partageExperience->user_id
            ? $this->returnJsonResponse(422, 'Vous nest pas lauteur de ce post', $request->validated(), NULL)
            :  $this->returnJsonResponse(200, 'Votre post à été mis à jour', $partageExperience,  $partageExperience->update($request->validated()));
    }

    /**
     * 
     * @OA\delete(
     *     path="/api/experience/suprimmer{id}",
     *     summary="Supprimer un partages d'expérience",
     *     @OA\Response(response="200", description="succes"),
     * )
     */

    public function destroy(Request $request, $id)
    {
        $pe = PartageExperience::find($id);
        $pe->contenue = $request->contenue;
        $pe->delete($id);
        return response()->json(['message' => 'Ressource suprimer avec succès'], 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }


    /**
     * Show the form for creating a new resource.
     */

      /**
     * 
     * @OA\Get(
     *     path="/api/experience/{id}",
     *     summary="Afficher un partages d'expérience donnée",
     *     @OA\Response(response="200", description="succes"),
     *     @OA\Response(response="404", description="Enregistrement innexistant"),
     * )
     */
    public function show(Request $request, $id)
    {
        $partageExperience = PartageExperience::find($id);
        if (!$partageExperience) {
            return $this->returnJsonResponse(404, 'Enregistrement innexistant', $partageExperience);
        }
        return $this->returnJsonResponse(200, 'voir plus', $partageExperience->load('commentaires'));
    }

  /**
     * 
     * @OA\patch(
     *     path="/api/experience/edit{id}",
     *     summary="Afficher un partages d'expérience donnée",
     *     @OA\Response(response="200", description="succes"),
     *     @OA\Response(response="404", description="Enregistrement innexistant"),
     * )
     */
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PartageExperience $request)
    {
        if(! PartageExperience::find($request->id)){
            return $this->returnNotFoundJsonResponse();
        }
        return $this->returnJsonResponse(200, 'Editer ce partage d\'expérience', $partageExperience = PartageExperience::find($request->id));
    }

    /**
     * Update the specified resource in storage.
     */

    /**
     * Remove the specified resource from storage.
     */
}
