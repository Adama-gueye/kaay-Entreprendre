<?php

namespace App\Http\Controllers;

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
        //
    }

    /**
     * 
     */

    public function rules()
    {
        return [
            'titre' => 'required',
            'description' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'titre.required' => 'Desolé! le champ libelle est Obligatoire',
            'description.required' => 'Desolé! veuillez choisir une description svp',
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
        $ressource->description = $request->description;
        $ressource->user_id = $user->id;
        $ressource->save();

        return response()->json(['message' => 'Ressource créé avec succès'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ressource $ressource)
    {
        //
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
    public function update(Request $request, Ressource $ressource)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ressource $ressource)
    {
        //
    }
}
