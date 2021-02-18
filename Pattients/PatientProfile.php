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
    setcookie("token", $token, time() + (600), '/');/// Keep token alive for 10 minutes 

    if(!isset($_POST['id'])){
        header("Location: ./Patients.php");
        exit; 
    }
    $id = $_POST['id'];
    $patient = GetPatientByUserIdAndPatientId($userId, $id);
   
    if($patient == new stdClass()){
        header("Location: ./Patients.php");
        exit; 
    }
?>

<title>Patients</title>
<div class="container" style="width:100%">
    <div class="row justify-content-center" style="margin-top:80px;">
        <div class="col-12 col-lg-6">
            <div class="p-2 bg-primary border text-white" style="text-align:center"><h5>Patient's profile</h5></div>
            <div class="p-1 border bg-light" style="height:600px">
                <div class="row justify-content-center">
                    <div class="col-10 col-lg-5 p-2"><strong>Last name</strong>
                        <div class="border bg-white p-2" style="width:100%"><?php echo $patient->Lastname; ?></div>
                    </div>
                    <div class="col-10 col-lg-5 p-2"><strong>First name</strong>
                        <div class="border bg-white p-2" style="width:100%"><?php echo $patient->Firstname; ?></div>
                    </div>
                    <div class="col-3 col-lg-5 p-2"><strong>Age</strong>
                        <div class="border bg-white p-2 w-50" ><?php echo $patient->Age; ?></div>
                    </div>
                    <div class="col-7 col-lg-5 p-2"><strong>Gender</strong>
                        <div style="width:100%">
                            <input class="m-2" type="radio" name="gender" id = "Fmale" value = "Fmale" <?php if($patient->Gender == "Fmale"){echo "checked";}?> disabled='disabled'>Fmale</input>
                            <input class="m-2" type="radio" name="gender" id = "Male" value = "Male" <?php if($patient->Gender == "Male"){echo "checked";}?> disabled='disabled'>Male</input>
                        </div>
                    </div>
                    <div class="col-10 col-lg-10 p-2"><strong>Address</strong>
                        <div class="border bg-white p-2" style="width:100%"><?php echo $patient->Address; ?></div>
                    </div>
                    <div class="col-5 col-lg-5 p-2"><strong>Town</strong>
                        <div class="border bg-white p-2" style="width:100%"><?php echo $patient->Town; ?></div>
                    </div>
                    <div class="col-5 col-lg-5 p-2"><strong>Zip Code</strong>
                        <div class="border bg-white p-2" style="width:100%"><?php echo $patient->ZipCode; ?></div>
                    </div>
                    <div class="col-5 col-lg-5 p-2"><strong>Profession</strong>
                        <div class="border bg-white p-2" style="width:100%"><?php echo $patient->Profession; ?></div>
                    </div>
                    <div class="col-5 col-lg-5 p-2 pb-4"><strong>Phone</strong>
                        <div class="border bg-white p-2" style="width:100%"><?php echo $patient->Phone; ?></div>
                    </div>
                    <div class="col-5 col-lg-5 p-2 pb-4"><strong>Email</strong>
                        <div class="border bg-white p-2" style="width:100%"><?php echo $patient->Email; ?></div>
                    </div>
                    <div class="col-5 col-lg-5 p-2 pb-4"><strong>Created at</strong>
                        <div class="border bg-white p-2" style="width:100%"><?php $date = new DateTime($patient->CreatedAt); echo $date->format('d-m-Y'); ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-3">
            <div class="p-2 bg-primary border text-white" style="text-align:center"><h5>Personal details</h5></div>
            <div class="p-1 border bg-light" style="height:600px">
                <div class="row justify-content-center">
                    <div class="col-10 col-lg-10 p-2"><strong>AMKA</strong>
                       <div class="border bg-white p-2" style="width:100%"><?php echo $patient->Amka; ?></div>
                    </div>
                    <div class="col-10 col-lg-10 p-2"><strong>Insurance</strong>
                       <div class="border bg-white p-2" style="width:100%"><?php echo $patient->Insurance; ?></div>
                    </div>
                    <div class="col-10 col-lg-10 p-2"><strong>Last visit</strong>
                       <div class="border bg-white p-2" style="width:100%"><?php echo $patient->LastVisitAt; ?></div>
                    </div>
                    <div class="col-10 col-lg-10 p-2"><strong>Medical Bio</strong>
                       <textarea class="border border-primary p-2 " style="width:100%;height:80px;font-size:0.8rem;overflow:hidden;overflow-y:scroll" disabled><?php echo $patient->MedicalBio;?></textarea>
                       <form action="./EditPatientProfile.php" method="post">
                            <div class="p-2" style="width:100%;text-align:center">
                                    <button class="btn btn-info btn-sm" role="button" style="width:60%">Edit patient</button>
                                    <input type="hidden" name="id" value="<?php echo $id;?>"/>
                            </div>
                       </form>
                       <form action="../Visits/ListOfVisits.php" method="post">
                            <div class="p-2" style="width:100%;text-align:center">
                                    <input type="hidden" name="id" value="<?php echo $id?>"/>
                                    <input type="submit" class="btn btn-info btn-sm" value="View All Visits" style="width:60%">
                            </div>
                       </form>
                       <form action="../Visits/NewVisit.php" method="post">
                            <div class="p-2" style="width:100%;text-align:center">
                                    <button class="btn btn-info btn-sm" role="button" style="width:60%">Add a new visit</button>
                                    <input type="hidden" name="id" value="<?php echo $patient->Id;?>"/>
                            </div>
                       </form>
                       <form action="./DeletePatient.php" method="post">
                            <div class="p-2" style="width:100%;text-align:center">
                                    <button class="btn btn-danger btn-sm" role="button" style="width:60%">Delete patient</button>
                                    <input type="hidden" name="id" value="<?php echo $patient->Id;?>"/>
                            </div>
                       </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php ob_end_flush();?>
