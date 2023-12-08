<?php

namespace App\Http\Controllers\Api;

use App\Models\Guide;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class GuideController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $guides = Guide::all();
        return response()->json(compact('guides'),200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $user = Auth::user();
       $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $guide = new Guide();
        $guide->titre = $request->titre;
        $guide->description = $request->description;
        $guide->user_id = $user->id;
        $guide->save();

        return response()->json(['message' => 'Guide créé avec succès'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $guide = Guide::find($id);
        return response()->json(compact('guide'),200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Guide $guide)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
       $user = Auth::user();
       $validator = Validator::make($request->all(), $this->rules(), $this->messages());

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $guide = Guide::find($id);
        $guide->titre = $request->titre;
        $guide->description = $request->description;
        $guide->user_id = $user->id;
        $guide->save();

        return response()->json(['message' => 'Guide modifié avec succès'], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Guide::find($id)->delete();
        return response()->json(['message' => 'Guide supprimé avec succès'], 200);
    }
}
