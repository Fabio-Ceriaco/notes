<?php

namespace App\Services;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class Operations
{

    public static function decryptId($value)
    {

        // check if  $value is encrypted
        try {
            // decrypt value
            $value = Crypt::decrypt($value);
        } catch (DecryptException $e) {
            // if not encrypted, redirect to index
            return null;
        }

        return $value;
    }
}
