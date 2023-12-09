<?php

namespace App\Http\Controllers\Api;

use App\Models\Reponse;

use Illuminate\Http\Request;
use App\Models\PartageExperience;
use App\Http\Controllers\Controller;
use App\Models\Commentaire;
use App\Traits\ReturnJsonResponseTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
     * Show the form for creating a new resource.
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

    public function create(Request $request, $commentaireId)
    {

        $validator = Validator::make($request->all(), $this->rules());
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

         if(! Commentaire::find($commentaireId) ){
            return $this->returnNotFoundJsonResponse('vous tentez de repondre un commentaire innexistant ');
        }

        $user = Auth::user()->id;
        $reponse = new Reponse();
        $reponse->reponse = $request->reponse;
        $reponse->user_id  = Auth::user()->id;
        $reponse->commentaire_id = $request->commentaireId;
        $reponse->save();

        return response()->json(['message' => 'reponse  ajouter avec succès'], 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function destroy(Request $request, $id)
    {
        $Reponse = Reponse::find($id);
        if(! $Reponse){
            return $this->returnNotFoundJsonResponse('La Reponse que vous essayez de supprimé est ');
        }
        $Reponse->delete($id);
        return response()->json(['message' => 'reponse suprimer avec succès'], 201);
    }
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
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
    public function update(Request $request, Reponse $reponse)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
}
