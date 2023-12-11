<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Commentaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotations as OA;

class CommentaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     
/**
 * @OA\Info(
 *     description="Endpoind commentaire",
 *     version="1.0.0",
 *     title="Swagger Petstore"
 * )
 * 
 */
    public function index() {
    
    }
    

     /**
     * @OA\Post(
     *     path="/api/user",
     *     summary="Retourne cree des commentaires",
     *     @OA\Response(response="201", description="Successful operation")
     *    
     * )
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
     * @OA\delete(
     *     path="/api/user",
     *     summary="Retourne suprimmer des commentaires",
     *     @OA\Response(response="201", description="Successful operation")
     *    
     * )
     */
    public function destroy(Request $request,$id)
    {
        $pe=Commentaire::find($id);
        $pe->contenue =$request->contenue;
        $pe->delete($id);
        return response()->json(['message' => 'commentaire suprimer avec succès'], 200); 
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

       /**
     * @OA\Get(
     *     path="/api/user",
     *     summary="Retourne suprimmer des commentaires",
     *     @OA\Response(response="201", description="Successful operation")
     *    
     * )
     */
    public function show()
    {
        $commentaire = Commentaire::all();
        return response()->json(compact('commentaire'),200);
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
    
}
