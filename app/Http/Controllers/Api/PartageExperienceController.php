<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\PartageExperience;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\PartageExperienceRequest;
use Illuminate\Support\Facades\Auth;
use App\Traits\ReturnJsonResponseTrait;
use Illuminate\Database\Eloquent\Model;

class PartageExperienceController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    use ReturnJsonResponseTrait;

    public function index()
    { 
        return $this->returnJsonResponse(200, 'Liste des expériences partagé', PartageExperience::all() );
    }

    public function creation(CreatePostRequest $request)
    {
        return $this->returnJsonResponse(200, 'Votre experience à été ajouté avec sucess', $request->validated(), PartageExperience::create($request->all()));
    }

    public function update(CreatePostRequest $request, $id)
    {
        $partageExperience = PartageExperience::find($id);
        return auth()->user()->id !== $partageExperience->user_id
            ? $this->returnJsonResponse(422, 'Vous nest pas lauteur de ce post', $request->validated(), NULL)
            :  $this->returnJsonResponse(200, 'Votre post à été mis à jour', $partageExperience,  $partageExperience->update($request->validated()));
    }

    public function destroy(Request $request, $id)
    {
        $pe = PartageExperience::find($id);
        $pe->contenue = $request->contenue;
        $pe->delete($id);
        return response()->json(['message' => 'Ressource suprimer avec succès'], 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        $partageExperience = PartageExperience::find($id);
        if(! $partageExperience  ){
            return $this->returnJsonResponse(404, 'Enregistrement innexistant', $partageExperience );
        }
        return $this->returnJsonResponse(200, 'voir plus', $partageExperience->load('commentaires') );
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PartageExperience $partageExperience)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

    /**
     * Remove the specified resource from storage.
     */
}
