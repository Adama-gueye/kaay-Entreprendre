<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Guide;
use App\Models\Ressource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Info(
 *     description="EndPoints pour ressource",
 *     version="1.0.0",
 *     title="Swagger Petstore"
 * )
 * 
 */
class RessourceController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/ressourceIndex",
     *     summary="Retourne tout les ressources",
     *     @OA\Response(response="200", description="Successful operation")
     * )
     */
    public function index()
    {
        $ressources = Ressource::all();
        return response()->json(compact('ressources'), 200);
    }

    /**
     * 
     */

    public function rules()
    {
        return [
            'titre' => 'required',
            'consigne' => 'required',
            'objectif' => 'required',
            'etat' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'titre.required' => 'Desolé! le champ libelle est Obligatoire',
            'consigne.required' => 'Desolé! le champ consigne est Obligatoire',
            'objectif.required' => 'Desolé! le champ objectif est Obligatoire',
            'etat.required' => 'Desolé! le champ etat est Obligatoire',
        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * 
     * @OA\Post(
     *     path="/api/ressourceStore",
     *     summary="Ajout d'un ressource",
     *     @OA\Response(response="201", description="Ressource créé avec succes"),
     *     @OA\Response(response="422", description="erreur")
     * )
     */
    public function store(Request $request)
    {
       $user = Auth::user();
       $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $ressource = new Ressource();
        $ressource->titre = $request->titre;
        $ressource->objectif = $request->objectif;
        $ressource->consigne = $request->consigne;
        $ressource->etat = $request->etat;
        $ressource->guide_id = 1;
        $ressource->save();

        return response()->json(['message' => 'Ressource créé avec succès'], 201);
    }

    /**
     * 
     * @OA\Get(
     *     path="/api/ressourceShow{id}",
     *     summary="Afficher un ressource",
     *     @OA\Response(response="200", description="succes"),
     * )
     */
    public function show($id)
    {
        $ressource = Ressource::find($id);
        return response()->json(compact('ressource'),200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ressource $ressource)
    {
        //
    }

    /**
     * 
     * @OA\Patch(
     *     path="/api/ressourceUpdate{id}",
     *     summary="Modification d'un ressource",
     *     @OA\Response(response="201", description="Ressource modifié avec succes"),
     *     @OA\Response(response="422", description="erreur")
     * )
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
       $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $ressource = Ressource::find($id);
        $ressource->titre = $request->titre;
        $ressource->objectif = $request->objectif;
        $ressource->consigne = $request->consigne;
        $ressource->etat = $request->etat;
        $ressource->guide_id = 1;
        $ressource->save();

        return response()->json(['message' => 'Ressource modifié avec succès'], 201);
    }

    /**
     * 
     * @OA\Delete(
     *     path="/api/ressourceDelete{id}",
     *     summary="Suppression d'un ressource",
     *     @OA\Response(response="200", description="Ressource supprimé avec succes"),
     * )
     */
    public function destroy($id)
    {
        Ressource::find($id)->delete();
        return response()->json(['message' => 'Ressource supprimé avec succès'], 200);
    }
}
