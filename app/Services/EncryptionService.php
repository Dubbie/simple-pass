<?php

namespace App\Services;

class EncryptionService
{
    function encryptString($string, $key)
    {
        $cipher = "AES-256-CBC";
        $ivLength = openssl_cipher_iv_length($cipher);
        $iv = openssl_random_pseudo_bytes($ivLength);
        $encrypted = openssl_encrypt($string, $cipher, $key, OPENSSL_RAW_DATA, $iv);
        $encrypted = $iv . $encrypted;
        $encrypted = base64_encode($encrypted);
        return $encrypted;
    }

    function decryptString($encrypted, $key)
    {
        $cipher = "AES-256-CBC";
        $encrypted = base64_decode($encrypted);
        $ivLength = openssl_cipher_iv_length($cipher);
        $iv = substr($encrypted, 0, $ivLength);
        $encrypted = substr($encrypted, $ivLength);
        $decrypted = openssl_decrypt($encrypted, $cipher, $key, OPENSSL_RAW_DATA, $iv);
        return $decrypted;
    }
}
