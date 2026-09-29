<?php

namespace App\Services;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class Operations
{
    public static function decryptId($value)
    {
        try {
            // decrypt the value
            $value = Crypt::decrypt($value);
        } catch (DecryptException $e) {
            return null;
        }
        // return the decrypted value
        return $value;
    }
}
