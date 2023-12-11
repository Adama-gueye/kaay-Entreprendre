<?php

namespace App\Traits;

use Exception;
use App\Models\Guide;
use Illuminate\Database\Eloquent\Model;

trait ReturnJsonResponseTrait
{
    public function returnJsonResponse($statusCode, $statusMessage, $data, $EloquentQuery = null, $anotherQuery = null)
    {
        try {
            return response()->json([
                'statusCode' => $statusCode,
                'statusMessage' => $statusMessage,
                'data' => $data,
            ], $statusCode);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function returnLoginJsonResponse($statusCode, $statusMessage, $user = null, $token = null)
    {
        try {

            $user =  auth()->user();
            $token = $user->createToken('Never_trust_TO_users')->plainTextToken;
            return response()->json([
                'statusCode' => $statusCode,
                'statusMessage' => $statusMessage,
                'data' => $user,
                'token' => $token ? $token : null,
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    


    public function returnNotFoundJsonResponse($message =null, $statusCode = 404)
    {
        if($message == null) {
            $message = 'Enregistrement';
        }
        return response()->json([
            'message' => ucfirst($message) . ' non trouvé',
            'statusCode' => $statusCode,
        ], $statusCode);
        //}
    }

    public function returnAuthorizationJsonResponse($statusCode = 403)
    {
        return response()->json([
            'message' => 'VOUS NAVEZ PAS LAUTORISATION REQUISE POUR EFFECTUER CETTE ACTION',
            'statusCode' => $statusCode,
        ], $statusCode);
    }


   
}
