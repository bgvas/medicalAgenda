<?php
ob_start();
Require_once '../DataBase/UserDataBaseService.php';
require_once '../DataBase/PatientDataBaseService.php';



if(isset($_POST['userId'])&& isset($_POST['fname']) 
&& isset($_POST['lname']) && isset($_POST['email']))
{
   
    $updateUser = new stdClass();

    $updateUser->userId = $_POST['userId'];
    $updateUser->fname = $_POST['fname'];
    $updateUser->lname = $_POST['lname'];
    $updateUser->email = $_POST['email'];
    
    if(isset($_POST['password']) && $_POST['password'] != ""){
        $updateUser->password = $_POST['password'];
    }

    if(updateUserProfile($updateUser)){
        header("Location: ../DashBoard.php");
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
setcookie("token", $token, time() + (600), '/');/// Keep token alive for 10 minutes 

$user = GetUserByUserId($userId);
if($user == null){
    header("Location: ../Authorization/Login.html?result=usernotfound");
    exit;
}


if(isset($_POST['edit'])){?>

<div class="container">
    <div class="row mt-5">
        <form action="" method="POST">
        <div class="col-12 border form-control bg-primary text-center">
            <strong style="font-weight:bold; color:white">Edit User's Profile</strong>
        </div>
    </div>
    <div class="row bg-white" style="max-height:auto">
        <div class="col-12 col-md-6 col-lg-6">
            <label><strong class="text-secondary">First name</strong></label>
            <input type="text" class="form-control mb-2" value="<?php echo $user->Fname; ?>"  name="fname"/>
        </div>
        <div class="col-12 col-md-6 col-lg-6">
            <label><strong class="text-secondary">Last name</strong></label>
            <input type="text" class="form-control mb-2" value="<?php echo $user->Lname; ?>"  name="lname"/>
        </div>
    </div>
    <div class="row bg-white" style="max-height:auto">
        <div class="col-12 col-md-6 col-lg-6">
            <label><strong class="text-secondary">User name</strong></label>
            <input type="text" class="form-control mb-2" value="<?php echo $user->Username; ?>" disabled />
        </div>
        <div class="col-12 col-md-6 col-lg-6">
            <label><strong class="text-secondary">Email</strong></label>
            <input type="text" class="form-control mb-2" value="<?php echo $user->Email; ?>" name = "email"/>
        </div>
    </div>
    <div class="row bg-white" style="max-height:auto">
        <div class="col-12 col-md-6 col-lg-6">
            <label><strong class="text-secondary">Role</strong></label>
            <input type="text" class="form-control mb-2" value="<?php echo $user->Role; ?>" disabled />
        </div>
        <div class="col-12 col-md-6 col-lg-6">
            <label><strong class="text-secondary">New Password</strong></label>
            <input type="text" class="form-control mb-2" name = "password"/>
        </div>
    </div>
    <div class="row bg-white" style="max-height:auto">
        <div class="col-12 col-md-6 col-lg-6 mb-2  text-center">
            
                <input type="hidden" name="userId" value="<?php echo $userId; ?>" />
                <button type="submit" class="btn btn-primary" style="width:200px">Submit changes</button>
            </form>
        </div>
        <div class="col-12 col-md-6 col-lg-6 mb-2  text-center">
            <a role="button" href="../DashBoard.php" class="btn btn-secondary" style="width:200px">Cancel</a>
        </div>
    </div>
</div>


<?php }else{ ?>


<div class="container">
    <div class="row mt-5">
        <div class="col-12 border form-control bg-primary text-center">
            <strong style="font-weight:bold; color:white">User's Profile</strong>
        </div>
    </div>
    <div class="row bg-white" style="max-height:auto">
        <div class="col-12 col-md-6 col-lg-6">
            <label><strong class="text-secondary">First name</strong></label>
            <input type="text" class="form-control mb-2" value="<?php echo $user->Fname; ?>" disabled />
        </div>
        <div class="col-12 col-md-6 col-lg-6">
            <label><strong class="text-secondary">Last name</strong></label>
            <input type="text" class="form-control mb-2" value="<?php echo $user->Lname; ?>" disabled />
        </div>
    </div>
    <div class="row bg-white" style="max-height:auto">
        <div class="col-12 col-md-6 col-lg-6">
            <label><strong class="text-secondary">User name</strong></label>
            <input type="text" class="form-control mb-2" value="<?php echo $user->Username; ?>" disabled />
        </div>
        <div class="col-12 col-md-6 col-lg-6">
            <label><strong class="text-secondary">Email</strong></label>
            <input type="text" class="form-control mb-2" value="<?php echo $user->Email; ?>" disabled />
        </div>
    </div>
    <div class="row bg-white" style="max-height:auto">
        <div class="col-12 col-md-6 col-lg-6">
            <label><strong class="text-secondary">Role</strong></label>
            <input type="text" class="form-control mb-2" value="<?php echo $user->Role; ?>" disabled />
        </div>
        <div class="col-12 col-md-6 col-lg-6">
            <label><strong class="text-secondary">Password</strong></label>
            <input type="text" class="form-control mb-2" value="******" disabled />
        </div>
    </div>
    <div class="row bg-white" style="max-height:auto">
        <div class="col-12 col-md-6 col-lg-6 mb-2  text-center">
            <form action="" method="post">
            <input type="hidden" name="edit" value="true" />
                <button type="submit" class="btn btn-primary" style="width:200px">Edit</button>
            </form>
        </div>
        <div class="col-12 col-md-6 col-lg-6 mb-2  text-center">
            <a role="button" href="../DashBoard.php" class="btn btn-secondary" style="width:200px">Return</a>
        </div>
    </div>
</div>

<?php } ?>