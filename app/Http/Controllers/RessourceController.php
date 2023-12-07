<?php

namespace App\Http\Controllers;

use App\Models\Guide;
use App\Models\Ressource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RessourceController extends Controller
{
    /**
     * Display a listing of the resource.
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
     * Store a newly created resource in storage.
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
     * Display the specified resource.
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
     * Update the specified resource in storage.
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
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Ressource::find($id)->delete();
        return response()->json(['message' => 'Ressource supprimé avec succès'], 200);
    }
}
