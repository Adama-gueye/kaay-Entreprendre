<?php

namespace App\Http\Controllers\Api;

use Exception;

use App\Models\Guide;
use App\Models\Ressource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;


class RessourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Ressource $ressource)
    {
        $this->authorize('viewAny', $ressource);
        try {
            $ressources = Ressource::all();
            return response()->json(compact('ressources'), 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
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
           
        ];
    }
    public function messages()
    {
        return [
            'titre.required' => 'Desolé! le champ libelle est Obligatoire',
            'consigne.required' => 'Desolé! le champ consigne est Obligatoire',
            'objectif.required' => 'Desolé! le champ objectif est Obligatoire',
        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Ressource $ressource)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Ressource $ressource)
    {
        $this->authorize('store', $ressource);
        try {
            Guide::findOrFail($request->id);

            $validator = Validator::make($request->all(), $this->rules());
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
    
            $ressource = new Ressource();
            $ressource->titre = $request->titre;
            $ressource->objectif = $request->objectif;
            $ressource->consigne = $request->consigne;
            $ressource->etat = 'activer';
            $ressource->guide_id = $request->id;
            $ressource->save();
    
            return response()->json(['message' => 'Ressource créé avec succès'], 201);
            
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }

      
    }

    /**
     * Display the specified resource.
     */
    public function show($id, Ressource $ressource)
    {
        try {
            $this->authorize('view', $ressource);
            $ressource = Ressource::find($id);
        return response()->json(compact('ressource'), 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
        
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
    public function update(Request $request, $id, Ressource $ressource)
    {
        try {
            $this->authorize('update', $ressource);
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
        
        } catch (ModelNotFoundException $error ) {
            return response()->json(['message' => $error->getMessage()], 403);
        } catch (Exception $error) {
            return response()->json(['message' => $error->getMessage()], 404);
        }
    
    }

        /*
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Ressource $ressource)
    {
      
        try {
            $this->authorize('delete', $ressource);
            Ressource::findOrFail($request->id)->delete();
            return response()->json(['message' => 'Ressource supprimé avec succès'], 200);
        } catch (ModelNotFoundException $error ) {
            return response()->json(['message' => $error->getMessage()], 404);
        } catch (Exception $error) {
            return response()->json(['message' => $error->getMessage()], 403);
        }
    }
}
