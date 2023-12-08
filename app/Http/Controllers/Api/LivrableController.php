<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Livrable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ReturnJsonResponseTrait;
use App\Http\Requests\LivrableFormRequest;
use App\Models\Ressource;

class LivrableController extends Controller
{
    use ReturnJsonResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       

        try {
            $query = Livrable::query();
            $perPage = 1;
            $page = $request->input('page', 1);
            $search = $request->input('search');
            if ($search) {
                $query->whereRaw("title LIKE '%" . $search . "%'");
            }
            $total = $query->count();
            $result = $query->offset(($page - 1) * $perPage)->limit($perPage)->get();

            return response()->json([
                'status_code' => 'status_code',
                'status_message' => 'status_message',
                'current_page' => $page,
                'last_page' => ceil($total / $perPage),
                'items' => $result,
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
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
    public function store(LivrableFormRequest $request)
    {
       
        $existsResource = Ressource::find($request->validated('ressource_id'));
        if($existsResource === null )
        {
            return $this->returnJsonResponse(422, 'La ressource de ce livrable est introuvable', $request->validated() );
        }
        return $this->returnJsonResponse(200, 'Livrable ajouté avec succes', $request->validated(), Livrable::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $livrable = Livrable::find( $request->id);
        if($livrable != null){
            return $this->returnJsonResponse(200, 'Le livrable sélectionné est : ', $livrable);
        } else {
            return $this->returnJsonResponse(400, 'Le livrable sélectionné introuvable : ', $livrable);       
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Livrable $livrable)
    {
      
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LivrableFormRequest $request)
    {
    
            $livrable = Livrable::find($request->id);

            if (! $livrable-> exists) {
                return $this->returnJsonResponse(422, 'Enregistrement introuvable ', $livrable);
            }
            if ($livrable->user_id !== $livrable->id && $livrable->user->role == 'admin') {
                return $this->returnJsonResponse(422, 'Vous nest pas lauteur de ce livrable', $livrable, NULL);
            } else if ($livrable->exists) {
                return $this->returnJsonResponse(200, 'Le livrable à été mis à jour ', $livrable, $livrable->updated($request -> validated()));
            }
       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $livrable = Livrable::find($request->id);
            if ($livrable == null) {
                return $this->returnJsonResponse(422, 'Enregistrement introuvable ', $livrable);
            }
            if ($livrable->user_id !== $livrable->id && $livrable->user->role == 'admin') {
                return $this->returnJsonResponse(422, 'Vous nest pas lauteur de ce livrable', $livrable, NULL);
            } else if ($livrable !== null) {
                return $this->returnJsonResponse(200, 'Le livrable à été bien supprimé ', $livrable, $livrable->delete());
            }
        } catch (Exception $e) {
            return $this->returnJsonResponse(422, 'Enregistrement introuvable ', $e);
        }
    }
}
