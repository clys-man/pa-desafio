<?php

namespace App\Api;

class Validate{
    public static function equals($request, $user){
        dd($request);
        return [
            'data' => [
                'msg' => $message,
                'code' => $code
            ]
        ];
    }
}
