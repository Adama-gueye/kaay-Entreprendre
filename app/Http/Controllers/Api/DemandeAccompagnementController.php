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


/**
 * @OA\Info(
 *     description="EndPoints pour demande accompagnement",
 *     version="1.0.0",
 *     title="Swagger Petstore"
 * )
 * 
 */
class DemandeAccompagnementController extends Controller
{

    use ReturnJsonResponseTrait;

    /**
     * @OA\Get(
     *     path="/api/accompany",
     *     summary="Retourne tout les demandes",
     *     @OA\Response(response="200", description="Successful operation")
     * )
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
     * 
     * @OA\Post(
     *     path="/api/accompany/create",
     *     summary="Ajout d'un guide",
     *     @OA\Response(response="201", description="Demande Accompagnement créé avec succes"),
     *     @OA\Response(response="422", description="erreur")
     * )
     */
    public function store(DemandeAccomagnementFromRequest $request, DemandeAccompagnement $demandeAccompagnement)
    {
        return $this->returnJsonResponse(200, 'SUPER ! C\'est le debut de ton voyage entreprenarial', $request->validated(), DemandeAccompagnement::create($request->all()));
    }

    /**
     * 
     * @OA\Get(
     *     path="/api/accompany{id}",
     *     summary="Afficher une demande d'accompagnement",
     *     @OA\Response(response="200", description="succes"),
     * )
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
     * 
     * @OA\Delete(
     *     path="/api/accompany{id}",
     *     summary="Suppression d'une demande d'accompagnement",
     *     @OA\Response(response="200", description="Demande supprimé avec succes"),
     *     @OA\Response(response="422", description="erreur"),
     * )
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
