<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Guide;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Traits\ReturnJsonResponseTrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * @OA\Info(
 *     description="EndPoints pour guide",
 *     version="1.0.0",
 *     title="Swagger Petstore"
 * )
 * 
 */
class GuideController extends Controller
{
    use ReturnJsonResponseTrait;
    /**
     * @OA\Get(
     *     path="/api/guideIndex",
     *     summary="Retourne tout les guides",
     *     @OA\Response(response="200", description="Successful operation")
     * )
     */
    public function index(Guide $guide)
    {
        //$this->authorize('view', $guide);
        try {
            $guides = Guide::all();
            return response()->json(compact('guides'), 200);
        } catch (Exception $error) {
            return response()->json(['message' => $error->getMessage()]);
        }
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
            'titre' => 'required',
            'description' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'titre.required' => 'Desolé! le champ libelle est Obligatoire',
            'description.required' => 'Desolé! le champ descrption est obligatoire',
        ];
    }

    /**
     * 
     * @OA\Post(
     *     path="/api/guideStore",
     *     summary="Ajout d'un guide",
     *     @OA\Response(response="201", description="Guide créé avec succes"),
     *     @OA\Response(response="422", description="erreur")
     * )
     */
    public function store(Request $request, Guide $guide)
    {

        //$this->authorize('store', $guide);
        try {

            $user = Auth::user();
            $validator = Validator::make($request->all(), $this->rules());

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $existeAutreGuide = Guide::all()->count();
            if ($existeAutreGuide) {
                return response()->json(['errors' => 'Vous ne pouvez ajouter qu\'un seul guide pour l\'instant '], 422);
            }

            $guide = new Guide();
            $guide->titre = $request->titre;
            $guide->description = $request->description;
            $guide->user_id = $user->id;
            $guide->save();

            return response()->json(['message' => 'Guide créé avec succès'], 201);
        } catch (Exception $error) {
            return response()->json(['message' => $error->getMessage()]);
        }
    }

    /**
     * 
     * @OA\Get(
     *     path="/api/guideShow{id}",
     *     summary="Afficher un guide",
     *     @OA\Response(response="200", description="succes"),
     * )
     */
    public function show($id, Guide $guide)
    {
        //$this->authorize('view', $guide);

        try {
            $guide = Guide::find($id);
            return response()->json(compact('guide'), 200);
        } catch (Exception $error) {
            return response()->json(['message' => $error->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Guide $guide)
    {
        //
    }

    /**
     * 
     * @OA\Patch(
     *     path="/api/guideUpdate{id}",
     *     summary="Modification d'un guide",
     *     @OA\Response(response="201", description="Guide modifié avec succes"),
     *     @OA\Response(response="422", description="erreur")
     * )
     */
    public function update(Request $request)
    {

        //$this->authorize('update', $guide);
        try {
            $guideUpdated = Guide::findOrFail($request->id);
            $user = Auth::user();
            $validator = Validator::make($request->all(), $this->rules(), $this->messages());
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            dd($user->id);

            $guideUpdated->titre = $request->titre;
            $guideUpdated->description = $request->description;
            $guideUpdated->user_id = $user->id;
            $guideUpdated->save();
            return response()->json(['message' => 'Guide modifié avec succès'], 201);

        } catch (ModelNotFoundException $error) {
            return response()->json(['message' => $error->getMessage()], 404);
        } catch (Exception $error) {
            return response()->json(['message' => $error->getMessage()], 403);
        }
    }

    /**
     * 
     * @OA\Delete(
     *     path="/api/guideDelete{id}",
     *     summary="Suppression d'un guide",
     *     @OA\Response(response="200", description="Guide supprimé avec succes"),
     * )
     */
    public function destroy($id, Guide $guide)
    {
        //$this->authorize('delete', $guide);

        try {
            Guide::find($id)->delete();
            return response()->json(['message' => 'Guide supprimé avec succès'], 200);
        } catch (Exception $error) {
            return response()->json(['message' => $error->getMessage()]);
        }
    }
}
