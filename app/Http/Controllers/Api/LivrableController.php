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

class LivrableController extends Controller
{
    use ReturnJsonResponseTrait;
    /**
     * Display a listing of the resource.
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
     * Store a newly created resource in storage.
     */
    public function store(LivrableFormRequest $request, Livrable $livrable)
    {
        $this->authorize('store', $livrable);
        $existsResource = Ressource::find($request->ressourceId);

        if ($existsResource === null) {
            return $this->returnJsonResponse(404, 'La ressource de ce livrable est introuvable', $request->all());
        }
        return $this->returnJsonResponse(200, 'Livrable ajouté avec succes', $request->validated(), Livrable::create($request->all()));
    }

    /**
     * Display the specified resource.
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
     * Update the specified resource in storage.
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
     * Remove the specified resource from storage.
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
