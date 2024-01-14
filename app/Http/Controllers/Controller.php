<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function successResponse($result, $message)
    {
        $response = [
            'success' => true,
            'message' => $message,
            'data'    => $result,
        ];
        return response()->json($response, 200);
    }

    public function successAuthResponse($result, $token, $message)
    {
        $response = [
            'success' => true,
            'token' => $token,
            'message' => $message,
            'data'    => $result,
        ];
        return response()->json($response, 200);
    }
    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function errorResponse($message, $data = [])
    {
        return response()->json([

            'error' => true,
            'message' => $message,
            'data' => $data,

        ]);
    }
}
