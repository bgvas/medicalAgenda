<?php
ob_start();
Require_once '../DataBase/UserDataBaseService.php';
require_once '../DataBase/PatientDataBaseService.php';
include_once "../Decorations/AdminTemplate.php";  // use the base html template
  
if(!isset($_COOKIE['token'])){
    header("Location: ../Authorization/Login.html?result=errorlogin");
    exit;
}

$token = $_COOKIE['token'];


$user =  GetUserByToken($token);
if($user == new stdClass()){
    
    header("Location: ../Authorization/Login.html?result=usernotfound");
    exit;
}

$userId = $user->id;
$id = $user->patientId;


$token = GenerateToken($userId);        // refresh token in Cookie and in DB every time the user comes here
setcookie("token", $token, time() + (600), '/');/// Keep token alive for 10 minutes 


   
?>

<div class="container">
        <div class="row mt-4 bg-primary">
            <div class="col-12 text-white">
                List Of Users
            </div>
        </div>
        <div class="row text-primary bg-white text-center mb-2">
            
                <div class="col-md-1 col-3" style="font-size:0.8rem">
                    Id
                </div>
                <div class="col-md-2 col-3" style="font-size:0.8rem">
                    Username
                </div>
                <div class="col-1 d-none d-lg-block d-lg-none" style="font-size:0.8rem"> <!-- visible only on large screens -->
                    Created
                </div>
                <div class="col-1 d-none d-lg-block d-lg-none" style="font-size:0.8rem"> <!-- visible only on large screens -->
                    Modified
                </div>
                <div class="col-2 d-none d-lg-block d-lg-none" style="font-size:0.8rem"> <!-- visible only on large screens -->
                    First name
                </div>
                <div class="col-2 d-none d-lg-block d-lg-none" style="font-size:0.8rem"> <!-- visible only on large screens -->
                    Last name
                </div>
                <div class="col-1 d-none d-lg-block d-lg-none" style="font-size:0.8rem"> <!-- visible only on large screens -->
                    Active
                </div>
                <div class="col-md-1 col-3" style="font-size:0.8rem">
                    Role
                </div>
                <div class="col-md-1 col-3" style="font-size:0.8rem">
                    Email
                </div>
           
        </div>
        <hr>
        <?php 
        
            $users = getAllUsers();
            foreach($users as $user){?>
                 <div class="row mb-1 bg-white text-center">
                    <div class="col-md-1 col-3" style="font-size:0.8rem">
                        <?php echo $user->id ?>
                    </div>
                    <div class="col-md-2 col-3" style="font-size:0.8rem">
                        <?php echo $user->username ?>
                    </div>
                    <div class="col-1 d-none d-lg-block d-lg-none" style="font-size:0.8rem"> <!-- visible only on large screens -->
                        <?php echo $user->createdat ?>
                    </div>
                    <div class="col-1 d-none d-lg-block d-lg-none" style="font-size:0.8rem"> <!-- visible only on large screens -->
                        <?php echo  $user->modifiedat ?>
                    </div>
                    <div class="col-2 d-none d-lg-block d-lg-none" style="font-size:0.8rem"> <!-- visible only on large screens -->
                        <?php echo  $user->fname ?>
                    </div>
                    <div class="col-2 d-none d-lg-block d-lg-none" style="font-size:0.8rem"> <!-- visible only on large screens -->
                        <?php echo  $user->lname ?>
                    </div>
                    <div class="col-1 d-none d-lg-block d-lg-none" style="font-size:0.8rem"> <!-- visible only on large screens -->
                        <?php echo  $user->active ?>
                    </div>
                    <div class="col-md-1 col-3" style="font-size:0.8rem">
                        <?php echo  $user->role ?>
                    </div>
                    <div class="col-md-1 col-3" style="font-size:0.8rem">
                        <?php echo  $user->email ?>
                    </div>
                </div><?php } ?>
</div>









<?php ob_end_flush();?>