<?php

namespace App\Api;

class ApiError{
    public static function errorMessage($message, $code){
        return [
            'data' => [
                'msg' => $message,
                'code' => $code
            ]
        ];
    }
}
