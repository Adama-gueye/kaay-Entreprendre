<?php

namespace App\Http\Controllers\Api;
use Exception;

use App\Models\Reponse;
use App\Models\Commentaire;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
use App\Models\PartageExperience;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Traits\ReturnJsonResponseTrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
/**
 * @OA\Info(
 *     description="Endpoind commentaire",
 *     version="1.0.0",
 *     title="Swagger Petstore"
 * )
 * 
 */
class ReponseController extends Controller
{
    use ReturnJsonResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->returnJsonResponse(200, 'LISTE DES REPONSES AINSI QUE LUTILISATEUR AYANT REPONDU ', Reponse::with('commentaire', 'user')->get());
    }

  /**
     * @OA\Post(
     *     path="/api/reponse",
     *     summary="Retourne cree une reponse",
     *     @OA\Response(response="201", description="Successful operation")
     *    
     * )
     */

    public function rules(): array
    {
        return [
            'reponse' => ['required', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'commentaire.required' => 'Le champ commentaire est Obligatoire',
        ];
    }

    public function create(Request $request, Commentaire $commentaire)
    {

        $this->authorize('create', $commentaire);

        $validator = Validator::make($request->all(), $this->rules());
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

         if(! Commentaire::find($request->commentaireId) ){
            return $this->returnNotFoundJsonResponse('vous tentez de repondre un commentaire innexistant ');
        }

        $reponse = new Reponse();
        $reponse->reponse = $request->reponse;
        $reponse->user_id  = Auth::user()->id;
        $reponse->commentaire_id = $request->commentaireId;
        $reponse->save();

        return response()->json(['message' => 'reponse  ajouter avec succès'], 201);
    }

    /**
     * Store a newly created resource in storage.
     * 
     */
    /**
     * @OA\delete(
     *     path="/api/reponse/sup{id}",
     *     summary="Retourne suprimer une reponse",
     *     @OA\Response(response="201", description="Successful operation")
     *    
     * )
     */
    public function destroy(Request $request, Commentaire $commentaire)
    {
        
        $Reponse = Reponse::find($request->id);
        $this->authorize('delete', $Reponse);
        if(! $Reponse){
            return $this->returnNotFoundJsonResponse('La Reponse que vous essayez de supprimé est ');
        }
        $Reponse->delete($Reponse);
        return response()->json(['message' => 'reponse suprimer avec succès'], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/user",
     *     summary="Retourne la liste des reponse",
     *     @OA\Response(response="200", description="Successful operation")
     *    
     * )
     */
    public function show(Reponse $reponse, $id)
    {
        $commentaire = Commentaire::find($id);
        if(! $commentaire){
            return $this->returnNotFoundJsonResponse('reponse');
        }
        return $this->returnJsonResponse(200, 'voir plus', $commentaire->load('reponses') );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reponse $reponse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {       
        try {  
        
            return $this-> returnJsonResponse(200, 'Reponse envoyé', Reponse::findOrFail($request->id), Reponse::findOrFail($request->id)->save(), Commentaire::findOrFail($request->id->commentaire_id) );
        
        } catch (ModelNotFoundException $error) {
            return response()->json(['message' => $error->getMessage()], 404);
        } catch (Exception $error) {
            return response()->json(['message' => $error->getMessage()], 403);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
}
