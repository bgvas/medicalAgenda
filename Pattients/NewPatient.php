<?php
ob_start();
Require_once '../DataBase/UserDataBaseService.php';
require_once '../DataBase/PatientDataBaseService.php';



if(isset($_POST['userId'])&& isset($_POST['fname']) 
&& isset($_POST['lname']) && isset($_POST['insurance'])
&& isset($_POST['amka'])){

    $newPatient = new stdClass();

    $newPatient->userId = $_POST['userId'];
    $newPatient->fname = $_POST['fname'];
    $newPatient->lname = $_POST['lname'];
    $newPatient->age = $_POST['age'];
    $newPatient->gender = $_POST['gender'];
    $newPatient->address = $_POST['address'];
    $newPatient->zipCode  = $_POST['postalCode'];
    $newPatient->town = $_POST['town'];
    $newPatient->email = $_POST['email'];
    $newPatient->phone = $_POST['phone'];
    $newPatient->insurance = $_POST['insurance'];
    $newPatient->amka = $_POST['amka'];

    if(AddNewPatient($newPatient)){
        header("Location: ./Patients.php");
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

include_once "../Decorations/MainTemplate.php";  // use the base html template
$token = GenerateToken($userId);        // refresh token in Cookie and in DB every time the user comes here
setcookie("token", $token, time() + (600), '/');/// Keep token alive for 10 minutes ?>


<div class="container mt-5 bg-light" style="max-width:90%">
    <div class="row" >
        <div class="col-12 bg-primary text-center" style="color:white; font-weight:bold; height:30px">Create new patient</div>
    </div>
    <div style="height: auto">
        <form action="./NewPatient.php" method="post"> 
            <div class="row mt-5">
                <div class="col-12 col-md-6 col-lg-4 mb-5" style="color:white; font-weight:bold; height:30px">
                    <label  style="color:grey">First Name</label><span class="text-danger">*</span>
                    <input type="text" class="form-control" name="fname" id="fname" placeholder="type first name" required/>
                </div>
                <div class="col-12 col-md-6 col-lg-6 " style="color:white; font-weight:bold; height:30px">
                    <label  style="color:grey">Last Name</label><span class="text-danger">*</span>
                    <input type="text" class="form-control" name="lname" id="lname" placeholder="type last name" required/>
                </div>
            </div>
            <div class="row mt-5 mb-5">
                <div class="col-4 " style="color:white; font-weight:bold; height:30px">
                    <label for="age" style="color:grey">Age</label><span class="text-danger" >*</span>
                    <input type="number" class="form-control w-lg-25" name="age" id="age" min="18" max="99"  step="1" required style="max-width:60%"/>
                </div>
                <div class="col-4 text-center" style="color:white; font-weight:bold; height:30px">
                    <label for="gender" style="color:grey">Male</label>
                    <input type="radio" class="form-control" name="gender" id="gender" value="Male" required/>
                </div>
                <div class="col-4 text-center" style="color:white; font-weight:bold; height:30px">
                    <label for="gender" style="color:grey">FeMale</label>
                    <input type="radio" class="form-control" name="gender" id="gender" value="Fmale" required/>
                </div>
            </div>
            <div class="row mt-5 mb-5">
                <div class="col-12 col-md-5 col-lg-5 mb-5" style="color:white; font-weight:bold; height:30px">
                    <label for="address" style="color:grey">Address</label>
                    <input type="text" class="form-control" name="address" id="address" placeholder="type address" default="null"/>
                </div>
                <div class="col-12 col-md-3 col-lg-3 mb-5" style="color:white; font-weight:bold; height:30px">
                    <label for="postalCode" style="color:grey">Postal Code</label>
                    <input type="text" class="form-control" name="postalCode" id="postalCode" placeholder="type postal code" onkeypress="return isNumber(event)" default="0" maxlength="5"/>
                </div>
                <div class="col-12 col-md-4 col-lg-4" style="color:white; font-weight:bold; height:30px">
                    <label for="town" style="color:grey">Town</label>
                    <input type="text" class="form-control" name="town" id="town" placeholder="type town" default="null"/>
                </div>
            </div>
            <div class="row mt-5 mb-5">
                <div class="col-12 col-md-3 col-lg-3 mb-5" style="color:white; font-weight:bold; height:30px">
                    <label for="email" style="color:grey">Email</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="type email" default="null"/>
                </div>
                <div class="col-12 col-md-3 col-lg-3 mb-5" style="color:white; font-weight:bold; height:30px">
                    <label for="phone" style="color:grey">Phone</label>
                    <input type="text" class="form-control" name="phone" id="phone" placeholder="type phone"onkeypress="return isNumber(event)" maxlength="10" default="0" required/>
                </div>
                <div class="col-12 col-md-3 col-lg-3 mb-5 " style="color:white; font-weight:bold; height:30px">
                    <label for="insurance" style="color:grey">Insurance</label><span class="text-danger">*</span>
                    <input type="text" class="form-control" name="insurance" id="insurance" placeholder="insurance" required/>
                </div>
                <div class="col-12 col-md-3 col-lg-3 mb-5" style="color:white; font-weight:bold; height:30px">
                    <label for="amka" style="color:grey">Insurance Number</label><span class="text-danger">*</span>
                    <input type="text" class="form-control" name="amka" id="amka" placeholder="insurance number"onkeypress="return isNumber(event)" maxlength="11" required/>
                </div>
            </div>
            <div class="row mt-5 mb-5">
                <div class="col-12 col-md-6 col-lg-6 text-center mb-5" style="color:white; font-weight:bold; height:30px">
                    <input type="hidden" name="userId" value="<?php echo $userId; ?>"/>
                    <button type="submit" class="btn btn-primary btn-lg" style="width:150px">Save patient</button>
                </div>
                <div class="col-12 col-md-6 col-lg-6 text-center mb-5" style="color:white; font-weight:bold; height:30px">
                    <a href="./Patients.php" type="button" class="btn btn-info btn-lg"  style="width:150px">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>


<script>
// allow only numbers //
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
</script>



<?php ob_end_flush();?>