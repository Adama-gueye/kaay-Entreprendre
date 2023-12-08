<?php

namespace App\Http\Controllers;

use App\Models\Livrable;
use Illuminate\Http\Request;

class LivrableController extends Controller
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
    public function create()
    {
        //
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
    public function show(Livrable $livrable)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Livrable $livrable)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Livrable $livrable)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,$id )
    {
        $pe=Livrable::find($id);
        $pe->contenu =$request->contenue;
        $pe->delete($id);
        return response()->json(['message' => ' Livrablesuprimer avec succès'], 201); 
    }
}
