<?php

namespace App\Helpers;

use Exception;

class PhoneValidator 
{
    public function isValid($phone_number){
        $response = false;
        $condition = '/\(\+\d{2}\)(\s|\S)+\d{3}(\s|\D)(\d{3})(\s|\D)(\d{2})(\s|\D)(\d{2})/';
        if(preg_match($condition, $phone_number)) {
            $response = true;
        }
        return $response;
    }
}
