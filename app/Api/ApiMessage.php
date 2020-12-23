<?php

namespace App\Api;

class ApiMessage{
    public static function display($message, $code){
        return [
            'data' => [
                'msg' => $message,
                'code' => $code
            ]
        ];
    }
}
