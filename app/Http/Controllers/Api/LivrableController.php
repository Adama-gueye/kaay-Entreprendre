<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Livrable;
use App\Models\Ressource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ReturnJsonResponseTrait;
use App\Http\Requests\LivrableFormRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     description="EndPoints pour livrable",
 *     version="1.0.0",
 *     title="Swagger Petstore"
 * )
 * 
 */
class LivrableController extends Controller
{
    use ReturnJsonResponseTrait;

     /**
     * @OA\Get(
     *     path="/api/livrable/index,
     *     summary="Retourne tout les livrables",
     *     @OA\Response(response="200", description="Successful operation")
     * )
     */
    public function index(Livrable $livrable)
    {
        $this->authorize('viewAny', $livrable);
        return $this->returnJsonResponse(200, 'LISTE DES LIVRABLES, LE USER AYANT LIVRE, SUR QUEL RESSOURCE IL A LIVRE ', Livrable::with('ressource', 'user')->paginate(8));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return 'Ajouter la route vers le laffichage du formulaire ajout';
    }

    /**
     * 
     * @OA\Post(
     *     path="api/livrable/store/{ressourceId}",
     *     summary="Ajout d'un livrable",
     *     @OA\Response(response="201", description="Livrable créé avec succes"),
     *     @OA\Response(response="422", description="livrable introuvable")
     * )
     */
    public function store(LivrableFormRequest $request, Livrable $livrable)
    {
        $this->authorize('store', $livrable);
        $existsResource = Ressource::find($request->ressourceId);
        if ($existsResource === null) {
            return $this->returnJsonResponse(404, 'La ressource de ce livrable est introuvable', $request->all());
        }
        return $this->returnJsonResponse(201, 'Livrable ajouté avec succes', $request->validated(), Livrable::create($request->all()));
    }

    /**
     * 
     * @OA\Get(
     *     path="/api/livrable/show/{id}",
     *     summary="Afficher un livrable",
     *     @OA\Response(response="200", description="succes"),
     *     @OA\Response(response="400", description="erreur"),
     * )
     */
    public function show(Request $request)
    {
        $livrable = Livrable::find($request->id);
        $this->authorize('view', $livrable);
        $livrable = Livrable::find($request->id);

        if ($livrable != null) {
            return $this->returnJsonResponse(200, 'Le livrable sélectionné est : ', $livrable->load('ressource', 'user'));
        } else {
            return $this->returnJsonResponse(404, 'Le livrable sélectionné introuvable : ', $livrable);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Livrable $livrable)
    {
        return 'le formulaire pour editer le livrable';
    }

    /**
     * 
     * @OA\Patch(
     *     path="/ap/livrable/{id}",
     *     summary="Modification d'un guide",
     *     @OA\Response(response="201", description="Livrable modifié avec succes"),
     *     @OA\Response(response="422", description="Erreur")
     * )
     */
    // public function update(LivrableFormRequest $request)
    // {
    //     try {
    //         $livrable = Livrable::findOrFail($request->ressourceId);
    //         $this->authorize('update', $livrable);

    //         if (!$livrable->exists) {
    //             return $this->returnJsonResponse(404, 'Enregistrement introuvable ', $livrable);
    //         }
    //         if ($livrable->user_id !== $livrable->id && $livrable->user->role == 'admin') {
    //             return $this->returnJsonResponse(401, 'Vous nest pas lauteur de ce livrable', $livrable, NULL);
    //         } else if ($livrable->exists) {
    //             return $this->returnJsonResponse(200, 'Le livrable à été mis à jour ', $livrable, $livrable->updated($request->validated()));
    //         }
    //     } catch (ModelNotFoundException $error) {
    //         return response()->json(['message' => $error->getMessage()], 404);
    //     } catch (Exception $error) {
    //         return response()->json(['message' => $error->getMessage()], 403);
    //     }
    // }

     /**
     * 
     * @OA\Delete(
     *     path="/api/livrable/{id}",
     *     summary="Suppression d'un livrable",
     *     @OA\Response(response="200", description="Livrable supprimé avec succes"),
     *     @OA\Response(response="422", description="erreur"),
     * )
     */
    public function destroy(Request $request)
    {
        try {
            $livrable = Livrable::findOrFail($request->id);
            $this->authorize('delete', $livrable);

            if ($livrable == null) {
                return $this->returnJsonResponse(401, 'Enregistrement introuvable ', $livrable);
            }
            
            return $this->returnJsonResponse(200, 'Le livrable à été bien supprimé ', $livrable, $livrable->delete() );
        
        } catch (ModelNotFoundException $error) {
            return $this->returnNotFoundJsonResponse('Enregistrement');
        } catch (Exception $error) {
            return $this->returnAuthorizationJsonResponse(403);
        }
    }
}
