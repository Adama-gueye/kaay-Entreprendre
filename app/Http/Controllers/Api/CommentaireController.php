<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Commentaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
    
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $request->validate([
            "commentaire"=> "required",
            
           ]);
           
           $user=Auth::user();
          $pe=new Commentaire ();
          $pe->commentaire=$request->commentaire;
            $pe->user_id=$user->id;
           $pe->partage_experience_id=$user->id;
           $pe->save()  ;
           
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
    public function show(Commentaire $commentaire)
    {
        //
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
    public function destroy(Request $request,$id)
    {
        $pe=Commentaire::find($id);
        $pe->contenue =$request->contenue;
        $pe->delete($id);
        return response()->json(['message' => 'commentaire suprimer avec succès'], 201); 
    }
}
