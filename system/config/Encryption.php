<?php

namespace System\Config;

use \OpenSSL;

class Encryption
{
    private $key;
    private $iv;
    private $method = 'aes-256-cbc';

    public function __construct($key, $iv)
    {
        $this->key = $key;
        $this->iv = $iv;
    }

    public function encrypt($data)
    {
        $iv_length = openssl_cipher_iv_length($this->method);
        $iv = openssl_random_pseudo_bytes($iv_length);
        $encrypt = openssl_encrypt($data, $this->method, $this->key, OPENSSL_RAW_DATA, $iv);
        $hash = hash_hmac('sha3-512', $encrypt, $this->iv, true);
        return base64_encode($iv . $hash . $encrypt);
    }

    public function decrypt($data)
    {
        $mix = base64_decode($data);
        $iv_length = openssl_cipher_iv_length($this->method);
        $iv = substr($mix, 0, $iv_length);
        $hash = substr($mix, $iv_length, 64);
        $encrypt = substr($mix, $iv_length + 64);

        $data = openssl_decrypt($encrypt, $this->method, $this->key, OPENSSL_RAW_DATA, $iv);
        $rehash = hash_hmac('sha3-512', $encrypt, $this->iv, true);
        if (hash_equals($hash, $rehash)) {
            return $data;
        }
        return false;
    }

    public function toHex($data)
    {
        return bin2hex($data);
    }
    public function toBin($data)
    {
        return hex2bin($data);
    }
}
