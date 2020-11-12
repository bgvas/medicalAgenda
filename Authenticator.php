<?php

   function HashingPassword($password){
       $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
       return $hashedPassword;
   }

?>