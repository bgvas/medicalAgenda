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
<script>
    $.confirm({
        title: 'Delete that Patient!',
        content: 'Do you really want to continue?',
        buttons: {
            confirm: {
                text: 'Delete',
                btnClass: 'btn-danger',
                action: function () {
                    $.alert('Deleted!');
                }
            },
            cancel: {
                text: 'Cancel',
                btnClass: 'btn-info',
                action: function () {
                    $.alert('Canceled.');
                }
            }
        }
    });
</script>
</body>
</html>
