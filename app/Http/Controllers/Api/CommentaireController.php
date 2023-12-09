<?php

namespace App\Http\Controllers\Api;

use App\Models\User;


use App\Models\Commentaire;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PartageExperience;
use App\Traits\ReturnJsonResponseTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommentaireController extends Controller
{
    use ReturnJsonResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this -> returnJsonResponse(200, 'LISTE DES COMMENTAIRES AINSI QUE LES REPONSES ASSOCIE A CHAQUE COMMENTAIRE', Commentaire::with('reponses')->get());
    }


    public function rules(): array
    {
        return [
            'commentaire' => ['required', 'string'],
            'partageExperienceId' => ['required', 'integer'],
        ];
    }
    public function messages()
    {
        return [
            'commentaire.required' => 'Le champ libelle est Obligatoire',
            'partageExperienceId.required' => 'Ce commentaire n\'es rattaché à aucun partage d\experience',
        ];
    }

    public function create(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), $this->rules());
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

         if(! PartageExperience::find($request->partageExperienceId) ){
            return $this->returnNotFoundJsonResponse('Partage experience');
         }
        
        $user = Auth::user();
        $partageExperience = new Commentaire();
        $partageExperience->commentaire = $request->commentaire;
        $partageExperience->user_id = $user->id;
        $partageExperience->partage_experience_id = $request->partageExperienceId;
        $partageExperience->save();

        return response()->json(['message' => 'commentaire  ajouter avec succès'], 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(Commentaire $commentaire, $id)
    {
        $commentaire = Commentaire::find($id);
        if(! $commentaire){
            return $this->returnNotFoundJsonResponse('Commentaire');
        }
        return $this->returnJsonResponse(200, 'voir plus', $commentaire->load('reponses') );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Commentaire $commentaire)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Commentaire $commentaire)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $commentaire = Commentaire::find($id);
        if(! $commentaire){
            return $this->returnNotFoundJsonResponse('Commentaire');
        }
        $commentaire->delete($id);
        return response()->json(['message' => 'commentaire suprimer avec succès'], 201);
    }
}
