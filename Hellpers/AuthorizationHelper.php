<?php

    function Hashing($string){

        $salt = "MyEncryptionKey";
        $cipher_method = 'aes-128-ctr';
        $enc_key = openssl_digest(php_uname(), 'SHA256', true);
        $enc_iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher_method));
        $token = openssl_encrypt($string, $cipher_method, $enc_key, 0, $enc_iv)."2".bin2hex($enc_iv);
        unset($salt, $cipher_method, $enc_key, $enc_iv);

        return $token;
    }

?>