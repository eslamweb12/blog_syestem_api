<?php

namespace App\service;

class message
{
    public static function success($data = [], $token = '', $message = '')
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'token' => $token
        ], 200); // Optionally include a status code, like 200 OK
    }

    public static function error($message="",$status){
        return response()->json(['message'=>$message,'status'=>$status]);
    }

}
