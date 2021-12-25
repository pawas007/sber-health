<?php

namespace App\Services;

use Illuminate\Support\Facades\Response;

class CodeGenerator
{



    static function generateCode(){

        $length = 6;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        //        if uppercase & lowercase
//        return $randomString;
//        if uppercase
        return strtoupper($randomString);




    }


}
