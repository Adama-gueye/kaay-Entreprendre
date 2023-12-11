<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\DemandeAccompagnement;
use App\Traits\ReturnJsonResponseTrait;
use App\Http\Requests\DemandeAccomagnementFromRequest;
use Exception;

class DemandeAccompagnementController extends Controller
{

    use ReturnJsonResponseTrait;

    /**
     * Display a listing of the resource.
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
     * Store a newly created resource in storage.
     */
    public function store(DemandeAccomagnementFromRequest $request)
    {
        return $this->returnJsonResponse(200, 'SUPER ! C\'est le debut de ton voyage entreprenarial', $request->validated(), DemandeAccompagnement::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(DemandeAccompagnement $demandeAccompagnement)
    {
        return $this->returnJsonResponse(200, 'voir plus', $demandeAccompagnement );
    }

    /**
     * Remove the specified resource from storage.
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
