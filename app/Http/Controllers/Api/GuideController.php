<?php

namespace App\Http\Controllers\Api;

use App\Models\Guide;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ReturnJsonResponseTrait;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class GuideController extends Controller
{
    use ReturnJsonResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Guide $guide)
    {
        $this->authorize('view', $guide);
        try {
            $guides = Guide::all();
            return response()->json(compact('guides'), 200);
        } catch (Exception $error) {
            return response()->json(['message' => $error->getMessage()]);
        }
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
    public function store(Request $request, Guide $guide)
    {

        //$this->authorize('store', $guide);
        try {

            $user = Auth::user();
            $validator = Validator::make($request->all(), $this->rules());

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $existeAutreGuide = Guide::all()->count();
            if ($existeAutreGuide) {
                return response()->json(['errors' => 'Vous ne pouvez ajouter qu\'un seul guide pour l\'instant '], 422);
            }

            $guide = new Guide();
            $guide->titre = $request->titre;
            $guide->description = $request->description;
            $guide->user_id = $user->id;
            $guide->save();

            return response()->json(['message' => 'Guide créé avec succès'], 201);
        } catch (Exception $error) {
            return response()->json(['message' => $error->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id, Guide $guide)
    {
        $this->authorize('view', $guide);

        try {
            $guide = Guide::find($id);
            return response()->json(compact('guide'), 200);
        } catch (Exception $error) {
            return response()->json(['message' => $error->getMessage()]);
        }
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
    public function update(Request $request, $id, Guide $guide)
    {

        $this->authorize('update', $guide);
        try {
            $guideUpdated = Guide::findOrFail($request->id);
           
        } catch (Exception $error) {
            return response()->json(['message' => 'Enregistrement innexistant']);
        }

        try {
           
            $user = Auth::user();
            $validator = Validator::make($request->all(), $this->rules(), $this->messages());

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $guideUpdated->titre = $request->titre;
            $guideUpdated->description = $request->description;
            $guideUpdated->user_id = $user->id;
            $guideUpdated->save();
            return response()->json(['message' => 'Guide modifié avec succès'], 201);
        } catch (Exception $error) {
            return response()->json(['message' => $error->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, Guide $guide)
    {
        $this->authorize('delete', $guide);

        try {
            Guide::find($id)->delete();
            return response()->json(['message' => 'Guide supprimé avec succès'], 200);
        } catch (Exception $error) {
            return response()->json(['message' => $error->getMessage()]);
        }
    }
}
