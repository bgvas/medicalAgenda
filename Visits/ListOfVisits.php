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

include_once "../Decorations/VisitorTemplate.php";  // use the base html template
$token = GenerateToken($userId);        // refresh token in Cookie and in DB every time the user comes here
$id = 0;
if(isset($_POST['id'])){ 
    $id = $_POST['id'];
}
if(isset($_POST['role'])){
    $role = $_POST['role'];
}
else{
    $role = null;
}
setcookie("token", $token, time() + (600), '/');/// Keep token alive for 10 minutes ?>

<?php ob_end_flush();?>


<?php 
        if($id == 0 && $role != 'patient'){        // if did not passed patient Id then print visits of all patients
           $recentPatients = GetListOfAllVisitsByUserId($userId);
           
   
?>
<div class="container">
    <div class="row p-4">
        <div class="p-2 bg-light col-12 " style="height:650px">
            <div class="bg-primary">
                <h4 class="text-white" style="padding-left:15px;padding-top:15px;padding-bottom:15px">List of all visits</h4>
            </div>
            <div class="row justify-content text-primary" style="margin-left:5px; text-align:center">
                <div class="col-4 col-lg-2 "  style="font-size:0.8rem;">
                Last name
                </div>
                <div class="col-4 col-lg-2"  style="font-size:0.8rem;">
                First name
                </div>
                <div class="col-lg-1 col-4 d-none d-lg-block d-lg-none" style="font-size:0.8rem;"> <!-- visible only on large screens -->
                Age
                </div>
                <div class="col-lg-2 col-4 d-none d-lg-block d-lg-none" style="font-size:0.8rem;"> <!-- visible only on large screens -->
                Address
                </div>
                <div class="col-lg-2 col-4 d-none d-lg-block d-lg-none" style="font-size:0.8rem;"> <!-- visible only on large screens -->
                Town
                </div>
                <div class="col-lg-1 col-4 d-none d-lg-block d-lg-none" style="font-size:0.8rem;"> <!-- visible only on large screens -->
                Phone
                </div>
                <div class="col-lg-1 col-4 d-none d-lg-block d-lg-none" style="font-size:0.8rem;"> <!-- visible only on large screens -->
                AMKA
                </div>
                <div class="col-4 col-lg-1"  style="font-size:0.8rem;">
                Visit at
                </div>
            </div>
            <div style="margin-left:5px;height:550px;overflow:hidden;overflow-y:scroll;text-align:center">
                    <?php 
                       
                        $counter = 0;                       
                    
                        if($recentPatients != null){
                            foreach($recentPatients as $patient){
                                if($counter % 2 == 0){?>
                                    <div class="p-1 border  bg-white" style="text-align:center">
                                <?php }else {?>
                                    <div class="p-1 border" style="text-align:center">
                                <?php }?>
                                    <div class="row">
                                        <div class="col-4 col-lg-2 "  style="font-size:0.7rem;">
                                            <?php echo $patient->Lastname; ?>
                                        </div>
                                        <div class="col-4 col-lg-2"  style="font-size:0.7rem;">
                                            <?php echo $patient->Firstname; ?>
                                        </div>
                                        <div class="col-lg-1 col-4 d-none d-lg-block d-lg-none" style="font-size:0.7rem;"> <!-- visible only on large screens -->
                                            <?php echo $patient->Age; ?>
                                        </div>
                                        <div class="col-lg-2 col-4 d-none d-lg-block d-lg-none" style="font-size:0.7rem;"> <!-- visible only on large screens -->
                                            <?php echo $patient->Address; ?>
                                        </div>
                                        <div class="col-lg-2 col-4 d-none d-lg-block d-lg-none" style="font-size:0.7rem;"> <!-- visible only on large screens -->
                                            <?php echo $patient->Town; ?>
                                        </div>
                                        <div class="col-lg-1 col-4 d-none d-lg-block d-lg-none" style="font-size:0.7rem;"> <!-- visible only on large screens -->
                                            <?php echo $patient->Phone; ?>
                                        </div>
                                        <div class="col-lg-1 col-4 d-none d-lg-block d-lg-none" style="font-size:0.7rem;"> <!-- visible only on large screens -->
                                            <?php echo $patient->Amka;?>
                                        </div>
                                        <div class="col-4 col-lg-1"  style="font-size:0.7rem;">
                                            <?php $date = new DateTime($patient->VisitAt); echo $date->format('d-m-Y'); ?>
                                        </div>
                                    </div>
                                </div><?php $counter++?>
                    
                        <?php }}else{ echo "<div class='col-12 center-block' style='font-size:0.8rem;text-align:center;margin-top:10px'>No visits found</div>";}?>
                </div>
        </div>
    </div>
</div>

<?php  }else {
    $specificPatient = GetPatientByUserIdAndPatientId($userId, $id);  // find patient with a specific userId and patientId
    $recentPatients = GetListOfAllVisitsOfPatientByUserId($id, $userId); //  else print visits for a specific patient
   
?>
<div class="container">
    <div class="row p-4">
        <div class="p-2 bg-light col-12 " style="height:650px">
            <div class="bg-primary">
                <h4 class="text-white" style="padding-left:15px;padding-top:15px;padding-bottom:15px">Visits of <?php  echo $specificPatient->Firstname." ".$specificPatient->Lastname;?></h4>
            </div>
            <div class="row justify-content text-primary" style="margin-left:5px; text-align:center">
                <div class="col-6 col-lg-2 "  style="font-size:0.8rem;">
                Visit at
                </div>
                <div class="col-6 col-lg-2 "  style="font-size:0.8rem;"> 
                Comments
                </div>
                <div class="col-lg-1 col-4 d-none d-lg-block d-lg-none" style="font-size:0.8rem;"> <!-- visible only on large screens -->
                Systolic
                </div>
                <div class="col-lg-2 col-4 d-none d-lg-block d-lg-none" style="font-size:0.8rem;"> <!-- visible only on large screens -->
                Diastolic
                </div>
                <div class="col-lg-2 col-9 d-none d-lg-block d-lg-none" style="font-size:0.8rem;"> <!-- visible only on large screens -->
                Glucose
                </div>
            </div>
            <div style="margin-left:5px;height:550px;overflow:hidden;overflow-y:scroll;text-align:center">
                    <?php 
                       
                        $counter = 0;
                    
                        if($recentPatients != null){
                            foreach($recentPatients as $patient){
                                if($counter % 2 == 0){?>
                                    <div class="p-1 border  bg-white" style="text-align:center">
                                <?php }else {?>
                                    <div class="p-1 border" style="text-align:center">
                                <?php }?>
                                    <div class="row">
                                        <div class="col-6 col-lg-2 "  style="font-size:0.7rem;">
                                            <?php echo $patient->VisitAt; ?>
                                        </div>
                                        <div class="col-6 col-lg-2"  style="font-size:0.7rem;">
                                            <?php echo $patient->Comments; ?>
                                        </div>
                                        <div class="col-lg-1 col-4 d-none d-lg-block d-lg-none" style="font-size:0.7rem;"> <!-- visible only on large screens -->
                                            <?php echo $patient->Diastolic; ?>
                                        </div>
                                        <div class="col-lg-2 col-4 d-none d-lg-block d-lg-none" style="font-size:0.7rem;"> <!-- visible only on large screens -->
                                            <?php echo $patient->Systolic; ?>
                                        </div>
                                        <div class="col-lg-2 col-4 d-none d-lg-block d-lg-none" style="font-size:0.7rem;"> <!-- visible only on large screens -->
                                            <?php echo $patient->Glucose; ?>
                                        </div>
                                    </div>
                                </div><?php $counter++?>
                    
                        <?php }}else{ echo "<div class='col-12 center-block' style='font-size:0.8rem;text-align:center;margin-top:10px'>No visits found</div>";}?>
                </div>
        </div>
    </div>
</div>
<?php }?>