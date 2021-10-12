<?php

namespace App\Helpers;

use Exception;

class DateValidator 
{
    public function isValid($phone_number){
        $response = false;
        $condition = '/\(|\d{4}\-\d{2}\-\d{2}|\)/';
        if(preg_match($condition, $phone_number)) {
            $response = true;
        }
        return $response;
    }
}
