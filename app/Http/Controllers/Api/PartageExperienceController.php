<?php

namespace App\Http\Controllers\Api;
namespace App\Http\Controllers;

use App\Models\PartageExperience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function update(Request $request, $id)
    {
        $pe=PartageExperience::find($id);
        $pe->contenue =$request->contenue;
        $pe->save();
        return response()->json(['message' => 'Ressource modifié avec succès'], 201);

        
    }
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
     * Display the specified resource.
     */
    public function show(PartageExperience $partageExperience)
    {
        //
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
