<?php

namespace System\Config;

use Exception;

class Encryption
{
    private $key;
    private $iv;
    private $method = 'aes-256-cbc';
    private $algo = 'MD5';
    private $algo_len;
    private $iv_length;

    public function __construct($key, $iv, $algo = 'MD5')
    {
        $this->algo = $algo;
        $this->key = $key;
        $this->iv = $iv;
        $this->algo_len = strlen(hash_hmac($this->algo, rand(),  $this->iv, true));
        $this->iv_length = openssl_cipher_iv_length($this->method);
    }


    public function encrypt($data)
    {
        $iv = openssl_random_pseudo_bytes($this->iv_length);
        $encrypt = openssl_encrypt($data, $this->method, $this->key, OPENSSL_RAW_DATA, $iv);
        $hash = hash_hmac($this->algo, $encrypt, $this->iv, true);
        return base64_encode($iv . $hash . $encrypt);
    }

    public function decrypt($data)
    {
        $mix = base64_decode($data);
        $iv = substr($mix, 0, $this->iv_length);
        $hash = substr($mix, $this->iv_length, $this->algo_len);
        $encrypt = substr($mix, $this->iv_length + $this->algo_len);

        $decrypted_data = openssl_decrypt($encrypt, $this->method, $this->key, OPENSSL_RAW_DATA, $iv);
        $rehash = hash_hmac($this->algo, $encrypt, $this->iv, true);
        if (hash_equals($hash, $rehash)) {
            return $decrypted_data;
        }
        return false;
    }

    public function toHex($bin)
    {
        return bin2hex($bin);
    }
    public function isHex($hex_code)
    {
        return @preg_match("/^[a-f0-9]{2,}$/i", $hex_code) && !(strlen($hex_code) & 1);
    }
    public function toBin($hex)
    {
        return hex2bin($hex);
    }
}
