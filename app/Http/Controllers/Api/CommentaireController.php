<?php

namespace App\Http\Controllers\Api;

use Exception;


use App\Models\User;
use App\Models\Commentaire;
use Illuminate\Http\Request;
use App\Models\PartageExperience;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Traits\ReturnJsonResponseTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;




class CommentaireController extends Controller
{
    use ReturnJsonResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->returnJsonResponse(200, 'LISTE DES COMMENTAIRES AINSI QUE LES REPONSES ASSOCIE A CHAQUE COMMENTAIRE', Commentaire::with([
            'reponses', 
            'user' => function($query){
                $query->select('id', 'nom', 'prenom', 'email');
            },
            'partageExperience'=> function($query){
                $query->select('id', 'titre', 'contenu');
            },
        ])->paginate(3));
    }


    public function rules(): array
    {
        return [
            'commentaire' => ['required', 'string'],
        ];
    }
    public function messages()
    {
        return [
            'commentaire.required' => 'Le champ commentaire est Obligatoire',

        ];
    }

    public function create(Request $request, $partageExperienceId, Commentaire $commentaire)
    {

        $this->authorize('create', $commentaire);
        try {

            $user = Auth::user();
            $validator = Validator::make($request->all(), $this->rules(), $this->messages());

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            if (!PartageExperience::find($partageExperienceId)) {
                return $this->returnNotFoundJsonResponse('Partage experience');
            }

            $user = Auth::user();
            $partageExperience = new Commentaire();
            $partageExperience->commentaire = $request->commentaire;
            $partageExperience->user_id = $user->id;
            $partageExperience->partage_experience_id = $request->partageExperienceId;
            $partageExperience->save();

            return response()->json(['message' => 'commentaire  ajouter avec succès'], 201);
        } catch (Exception $e) {
            return $this->returnAuthorizationJsonResponse();
        }
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
        if (!$commentaire) {
            return $this->returnNotFoundJsonResponse('Commentaire');
        }
        return $this->returnJsonResponse(200, 'voir plus', $commentaire->load('reponses'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id, Commentaire $commentaire ): JsonResponse
    {
        $this->authorize('delete', $commentaire);
        try {
            $commentaire = Commentaire::find($id);
            if (!$commentaire) {
                return $this->returnNotFoundJsonResponse('Commentaire');
            }
            $commentaire->delete($commentaire);
            return response()->json(['message' => 'commentaire suprimer avec succès'], 201);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }
}
