<?php
ob_start();
Require_once '../DataBase/UserDataBaseService.php';
require_once '../DataBase/PatientDataBaseService.php';

if(!isset($_COOKIE['token'])){
    header("Location: ../Authorization/Login.html?result=errorlogin");
    exit;
}

$userId =  GetUserIdByToken($_COOKIE['token']);
if($userId <= 0){
    header("Location: ../Authorization/Login.html?result=usernotfound");
    exit;
}
include_once "../Decorations/MainTemplate.php";  // use the base html template
$token = GenerateToken($userId);        // refresh token in Cookie and in DB every time the user comes here
setcookie("token", $token, time() + (600), '/');/// Keep token alive for 10 minutes ?>


<title>Patients</title>
<script>activateSelection("patients")</script> <!-- Change Patients-selection text color, to white, in header bar -->
