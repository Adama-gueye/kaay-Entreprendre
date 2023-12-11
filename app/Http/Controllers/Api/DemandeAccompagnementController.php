<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\DemandeAccompagnement;
use App\Traits\ReturnJsonResponseTrait;
use App\Http\Requests\DemandeAccomagnementFromRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class DemandeAccompagnementController extends Controller
{

    use ReturnJsonResponseTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, DemandeAccompagnement $demandeAccompagnement)
    {
        $this->authorize('view', $demandeAccompagnement);
        try {
            return $this->returnJsonResponse(200, 'LISTE DES DEMANDES DACCOMPAGNEMENT ', DemandeAccompagnement::with('user')->paginate(3));
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return 'le formulaire d\'accompagnment ';
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DemandeAccomagnementFromRequest $request, DemandeAccompagnement $demandeAccompagnement)
    {

        try {
            $this->authorize('store', $demandeAccompagnement);
            return $this->returnJsonResponse(200, 'SUPER ! Votre accompagnement est enregistré.  C\'est le debut de ton voyage entreprenarial', $request->validated(), DemandeAccompagnement::create($request->all()));
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_FORBIDDEN);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        try {
            $demandeAccompagnement = DemandeAccompagnement::findOrFail($request->id);
            $this->authorize('view', $demandeAccompagnement);
            if (!$demandeAccompagnement) {
                return $this->returnNotFoundJsonResponse('Demande D\'accompagnement');
            }
            return $this->returnJsonResponse(200, 'voir plus', $demandeAccompagnement);
        } catch (ModelNotFoundException $error) {
            return response()->json(['message' => $error->getMessage()], 404);
        } catch (Exception $error) {
            return response()->json(['message' => $error->getMessage()], 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $demandeAccompagnement = DemandeAccompagnement::findOrFail($request->id);
            $this->authorize('delete', $demandeAccompagnement);
            if ($demandeAccompagnement == null) {
                return $this->returnJsonResponse(422, 'Enregistrement introuvable ', $demandeAccompagnement);
            }
            return $this->returnJsonResponse(200, 'Le demandeAccompagnement à été bien supprimé ', $demandeAccompagnement, $demandeAccompagnement->delete());

        } catch (ModelNotFoundException $error) {
            return $this->returnNotFoundJsonResponse('Enregistrement');
        } catch (Exception $error) {
            return $this->returnAuthorizationJsonResponse(403);
        }
    }
}
