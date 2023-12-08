<?php

namespace App\Traits;

use Exception;

trait ReturnJsonResponseTrait 
{
    public function returnJsonResponse($status_code, $status_message, $data, $EloquentQuery = null)
    {
        try {
            return response()->json([
                'status_code' => $status_code,
                'status_message' => $status_message,
                'data' => $data,
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }
    public function returnLoginJsonResponse($status_code, $status_message, $user = null, $token = null)
    {
        try {

            $user =  auth()->user();
            $token = $user ->createToken('Never_trust_TO_users')->plainTextToken;
            return response()->json([
                'status_code' => $status_code,
                'status_message' => $status_message,
                'data' => $user,
                'token' => $token ? $token : null,
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }
}
