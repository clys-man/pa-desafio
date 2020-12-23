<?php

namespace App\Api;

class Validate{
    public static function equals($request, $user){
        if($request === $user){
            return true;
        }

        return false;
    }
}
