<?php

namespace App\Http\Controllers;

use App\Models\Society;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function createResponseAPI($status, $message, $data)
    {
        return response()->json([
            "success" => $status === 200 ? true : false,
            "message" => $message,
            "data" => $data
        ], $status);
    }

    public function createResponseValidate($errors)
    {
        return response()->json([
            "message" => "Invalid Field",
            "errors" => $errors
        ], 422);
    }

    public function createResponseInvalidToken($message)
    {
        return response()->json([
            "message" => $message
        ], 401);
    }

    public function isValidToken($token)
    {
        $society = Society::with('regional')->where('login_tokens', $token)->first();

        if(is_null($society)){
            return false;
        }

        return $society;
    }

}
