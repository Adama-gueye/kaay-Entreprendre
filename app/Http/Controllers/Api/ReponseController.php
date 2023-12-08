<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Reponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReponseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request ,$id)
    {
        $request->validate([
            "reponse"=> "required",
            
           ]);
           
             $user=Auth::user();
            $pe=new Reponse ();
             $pe->commentaire=$request->commentaire;
            $pe->user_id=$user->id;
           $pe->commentaire_id=$user->id;
           $pe->save()  ;
           
        return response()->json(['message' => 'reponse  ajouter avec succès'], 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function destroy(Request $request,$id)
    {
        $pe=Reponse::find($id);
        $pe->repose =$request->contenue;
        $pe->delete($id);
        return response()->json(['message' => 'reponse suprimer avec succès'], 201);
    }
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Reponse $reponse)
    {
        //
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
