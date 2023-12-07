<?php

namespace App\Http\Controllers;

use App\Models\Livrable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LivrableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $livrable = Livrable::all();
        return response()->json(compact('livrable'),200);
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
            'contenu' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'contenu.required' => 'Desolé! le champ contenu est Obligatoire',
            ];
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $livrable = new Livrable();
        $livrable->contenu = $request->contenu;
        $livrable->ressource_id = $request->ressource_id;
        $livrable->user_id = $user->id;
        $livrable->save();
        return response()->json(['message' => 'Livrable créé avec succès'], 201);
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
    public function destroy(Livrable $livrable)
    {
        //
    }
}
