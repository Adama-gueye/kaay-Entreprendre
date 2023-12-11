<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Reponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotations as OA;
/**
 * @OA\Info(
 *     description="Endpoind commentaire",
 *     version="1.0.0",
 *     title="Swagger Petstore"
 * )
 * 
 */
class ReponseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    

   

  /**
     * @OA\Post(
     *     path="/api/reponse",
     *     summary="Retourne cree une reponse",
     *     @OA\Response(response="201", description="Successful operation")
     *    
     * )
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
     * 
     */
    /**
     * @OA\delete(
     *     path="/api/reponse/sup{id}",
     *     summary="Retourne suprimer une reponse",
     *     @OA\Response(response="201", description="Successful operation")
     *    
     * )
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
     * @OA\Get(
     *     path="/api/user",
     *     summary="Retourne la liste des reponse",
     *     @OA\Response(response="200", description="Successful operation")
     *    
     * )
     */
    public function show()
    {
        
        $reponse = Reponse::all();
        return response()->json(compact('reponse'),200);
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
