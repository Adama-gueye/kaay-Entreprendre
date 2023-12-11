<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\DemandeAccompagnement;
use App\Traits\ReturnJsonResponseTrait;
use App\Http\Requests\DemandeAccomagnementFromRequest;
use Exception;

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
    public function index(Request $request)
    {
        try {

            $query = DemandeAccompagnement::query();
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
    public function store(DemandeAccomagnementFromRequest $request)
    {
        return $this->returnJsonResponse(201, 'SUPER ! C\'est le debut de ton voyage entreprenarial', $request->validated(), DemandeAccompagnement::create($request->all()));
    }

    /**
     * 
     * @OA\Get(
     *     path="/api/accompany{id}",
     *     summary="Afficher une demande d'accompagnement",
     *     @OA\Response(response="200", description="succes"),
     * )
     */
    public function show(DemandeAccompagnement $demandeAccompagnement)
    {
        return $this->returnJsonResponse(200, 'voir plus', $demandeAccompagnement );
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
            $demandeAccompagnement = DemandeAccompagnement::find($request->id);
            if ($demandeAccompagnement == null) {
                return $this->returnJsonResponse(422, 'Enregistrement introuvable ', $demandeAccompagnement);
            }
            if ($demandeAccompagnement->user_id !== $demandeAccompagnement->id && $demandeAccompagnement->user->role == 'admin') {
                return $this->returnJsonResponse(422, 'Vous nest pas lauteur de ce demandeAccompagnement', $demandeAccompagnement, NULL);
            } else if ($demandeAccompagnement !== null) {
                return $this->returnJsonResponse(200, 'Le demandeAccompagnement à été bien supprimé ', $demandeAccompagnement, $demandeAccompagnement->delete());
            }
        } catch (Exception $e) {
            return $this->returnJsonResponse(422, 'Enregistrement introuvable ', $e);
        }
    }
}
