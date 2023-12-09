<?php

namespace App\Traits;

use Exception;
use Illuminate\Database\Eloquent\Model;

trait ReturnJsonResponseTrait 
{
    public function returnJsonResponse($statusCode, $statusMessage, $data, $EloquentQuery = null)
    {
        try {
            return response()->json([
                'statusCode' => $statusCode,
                'statusMessage' => $statusMessage,
                'data' => $data,
            ],$statusCode);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }
    public function returnLoginJsonResponse($statusCode, $statusMessage, $user = null, $token = null)
    {
        try {

            $user =  auth()->user();
            $token = $user ->createToken('Never_trust_TO_users')->plainTextToken;
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


    public function returnNotFoundJsonResponse($modelNotFound, $statusCode = 404 )
    {
        // $result = $model::find($id);
        // if(!$result || ! $result->exists )
        // {
            return response()->json([
                'message' => ucfirst($modelNotFound) . ' non trouvé',
                'statusCode' => $statusCode,
            ], $statusCode);
        //}

    }
}
