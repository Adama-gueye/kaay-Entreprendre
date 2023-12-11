<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Models\PartageExperience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotations as OA;
 /**
    * @OA\Info(
    *     description="Endpoind PartageExperience",
    *     version="1.0.0",
    *     title="Swagger Petstore"
    * )
    */
class PartageExperienceController extends Controller
{
    
    // public function rules()
    // {
    //     return [
    //         'contenue' => 'required',
           
    //     ];
    // }
    // public function messages()
    // {
    //     return [
    //         'contenue' => 'Desolé! le champ libelle est Obligatoire',
           
    //     ];
    
    // }
   
    /**
     * Show the form for creating a new resource.
     */
     /**
     * @OA\Post(
     *     path="/api/user",
     *     summary="Retourne cree une partage d'experiance",
     *     @OA\Response(response="201", description="Successful operation")
     *    
     * )
     */
    public function create(Request $request)


    {
        $request->validate([
            "contenue"=> "required",
            
           ]);
           $user=Auth::user();
          $pe=new PartageExperience ();
          $pe->contenue=$request->contenue;
           $pe->user_id=$user->id;
           $pe->save()  ;
           
        return response()->json(['message' => 'Ressource ajouter avec succès'], 201);

    }
     /**
     * Show the form for creating a new resource.
     */
     /**
     * @OA\Put(
     *     path="/api/user",
     *     summary="Retourne modifier une partage d'experiance",
     *     @OA\Response(response="201", description="Successful operation")
     *    
     * )
     */
    public function update(Request $request, $id)
    {
        $pe=PartageExperience::find($id);
        $pe->contenue =$request->contenue;
        $pe->save();
        return response()->json(['message' => 'Ressource modifié avec succès'], 201);

        
    }
     /**
     * Show the form for creating a new resource.
     */
     /**
     * @OA\Delete(
     *     path="/api/user",
     *     summary="Retourne suprimer une partage d'experiance",
     *     @OA\Response(response="201", description="Successful operation")
     *    
     * )
     */
    public function destroy(Request $request,$id)
    {
        $pe=PartageExperience::find($id);
        $pe->contenue =$request->contenue;
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
     * Show the form for creating a new resource.
     */
     /**
     * @OA\Get(
     *     path="/api/user",
     *     summary="Retourne lister les partage d'experiance",
     *     @OA\Response(response="200", description="Successful operation")
     *    
     * )
     */
    public function show()
    {
        $reponse = PartageExperience::all();
        return response()->json(compact('reponse'),200);
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
