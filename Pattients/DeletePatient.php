<?php
ob_start();
Require_once '../DataBase/UserDataBaseService.php';
require_once '../DataBase/PatientDataBaseService.php';

if(isset($_POST['patientId'])){
    DeletePatient($_POST['patientId']);
    header("Location: ./Patients.php");
    exit;
}

if(!isset($_COOKIE['token'])){
    header("Location: ../Authorization/Login.html?result=errorlogin");
    exit;
}

$userId =  GetUserIdByToken($_COOKIE['token']);
if($userId <= 0){
    header("Location: ../Authorization/Login.html?result=usernotfound");
    exit;
}

if(!isset($_POST['id'])){
    header("Location: ./Patients.php");
    exit;
}
$patientId = $_POST['id'];

include_once "../Decorations/MainTemplate.php";  // use the base html template
$token = GenerateToken($userId);        // refresh token in Cookie and in DB every time the user comes here
setcookie("token", $token, time() + (600), '/');/// Keep token alive for 10 minutes ?>



<div class="row justify-content-center mt-5" style="max-width: 100%">
    <div class="card border shadow p-3 mb-5 bg-white rounded" style="width: 20rem">
        <div class="card-body">
            <h5 class="card-title bg-danger text-white border text-center">Warning</h5>
            <p class="card-text text-center">Are you sure, that you want to delete that patient?</p>
            <form action="" method = "post" class="text-center">
                <input type="hidden" value="<?php echo $patientId;?>" name="patientId"/>
                <input type = "submit" class="card-link btn btn-danger" value="Delete" />
                <a href="./Patients.php" class="card-link btn btn-primary" type = "button">Cancel</a>
            </form>
        </div>
    </div>
</div>



<?php ob_end_flush();?>
