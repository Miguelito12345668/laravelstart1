<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function sendResponse($result, $message){
        $reponse = [
            'success' => true,
            'data' => $result,
            'message' => $message,
        ];

        return response()->json($reponse, 200);
    }
    public function sendError($rerror, $errorMessage=[], $code = 404){
        $reponse = [
            'success' => false,
            'message' => $error,
        ];

        if(!empty($errorMessage)){
            $response['data'] = $errorMessage;
        }

        return response()->json($reponse, $code);
    }
}
