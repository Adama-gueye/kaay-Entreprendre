<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DemandeAccomagnementFromRequest;
use App\Models\DemandeAccompagnement;
use App\Traits\ReturnJsonResponseTrait;
use Illuminate\Http\Request;

class DemandeAccompagnementController extends Controller
{

    use ReturnJsonResponseTrait;

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DemandeAccompagnement $demandeAccompagnement)
    {
        return 'Le formulaire dédition';
        
    }

 

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $demandeAccompagnement = DemandeAccompagnement::find($request->demandeAccompagnement);    
        if ($demandeAccompagnement->user_id !== $demandeAccompagnement->id) {
            return $this->returnJsonResponse(422, 'Vous nest pas lauteur de ce demandeAccompagnement', $demandeAccompagnement, NULL);
        } else {
            if ($demandeAccompagnement !== null) {
                return $this->returnJsonResponse(200, 'Le demandeAccompagnement à été bien supprimé ', $demandeAccompagnement, $demandeAccompagnement->delete());
            } else {
                return $this->returnJsonResponse(422, 'Enregistrement introuvable ', $demandeAccompagnement);
            }
        }
    }
}
