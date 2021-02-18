<?php
ob_start();
Require_once '../DataBase/UserDataBaseService.php';
require_once '../DataBase/PatientDataBaseService.php';

if(isset($_POST['patientId']) && isset($_POST['userId'])){
    $patientId = $_POST['patientId'];
    $userId = $_POST['userId'];
    $visitAt = date("Y/m/d  H:m:s");
    $txtArea = $_POST['txtArea'];
    $systolic = $_POST['systolic'];
    $diastolic = $_POST['diastolic'];
    $glucose = $_POST['glucose'];

    $newVisit = new stdClass();

    $newVisit->patientId = $patientId;
    $newVisit->userId = $userId;
    $newVisit->visitAt = $visitAt;
    $newVisit->glucose = $glucose;
    $newVisit->systolic = $systolic;
    $newVisit->diastolic = $diastolic;
    $newVisit->comments = $txtArea;


    if(AddNewVisit($newVisit)){
        header("Location: ../Pattients/Patients.php");
        exit;
    }
    
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
    header("Location: ../Pattients/Patients.php");
    exit;
}
$patientId = $_POST['id'];

include_once "../Decorations/MainTemplate.php";  // use the base html template
$token = GenerateToken($userId);        // refresh token in Cookie and in DB every time the user comes here
setcookie("token", $token, time() + (600), '/');/// Keep token alive for 10 minutes ?>


<div class = "container mt-5 border bg-light">
    <div class="row justify-content-center border text-white bg-primary">
        <div class="col-12">
            <p class="pt-3" style="font-size:large; font-weight: bold">New Visit for Georgoulas Vasileios</p>
        </div>
    </div>
    <form action="./NewVisit.php" method = "post">
    <div class="row justify-content-center">
        <div class="col-lg-4 col-12 text-center p-2">
            <input type="text" class="text-center" name="visitAt" style="font-size:large" value="<?php echo date("d/m/Y  H:m:s")?>" disabled />
        </div>
        <div class="col-lg-4 col-12">
            <div class="row justify-content-center">
                <div class="col-3 p-2 text-center">
                    <img src="../Images/blood-pressure.jpg" name="bloodPressure" width="80px" height="80px" />
                </div>
                <div class="col-8 p-2">
                    <div class="row">
                        <div class="col-12 text-center">
                            <input type="number" class="text-center" name="systolic" step="0.1" min="6" max="30" placeholder="systolic" style="width:110px" >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-center">
                            <input type="number" class="text-center" name="diastolic" step="0.1" min="4" max="10" placeholder="diastolic" style="width:110px" >
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="row justify-content-center">
                <div class="col-3 p-2 text-center">
                    <img src="../Images/blood-glucose.jpg" name="glucose" width="80px" height="60px" />
                </div>
                <div class="col-8 p-2 text-center">
                    <input type="number" name="glucose" class="text-center" step="0.1" min="0.5" max="10.0" placeholder="Glucose" style="width:110px" />
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
       <div class="col-12">
            <textarea name="txtArea" class="form-group w-100" cols="30" rows="10" placeholder="Comments" ></textarea>
       </div>
    </div>
    <div class="row text-center">
        <div class="col-6 mb-2"><button class="btn btn-primary btn-lg" type="submit">submit</button></div>
        <div class="col-6 mb-2"><a href="../Pattients/Patients.php" class="btn btn-secondary btn-lg" type="button">cancel</a></div>
    </div>
    <input type="hidden" name="patientId" value="<?php echo $patientId ?>">
    <input type="hidden" name="userId" value="<?php echo $userId ?>">
    </form>
</div>

<?php ob_end_flush();?>