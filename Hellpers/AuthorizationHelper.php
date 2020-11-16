<?php

    function Hashing($string){

        $salt = "MyEncryptionKey";
        $enc_key = bin2hex($string);
        $enc_salt = bin2hex($salt);
        $token = hash('sha512', $enc_key.$enc_salt);
        return $token;
    }

?>