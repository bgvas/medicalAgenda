<?php
    ob_start();
    Require_once '../DataBase/UserDataBaseService.php';
    Require_once '../DataBase/PattientDataBaseService.php';
      
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

    
    <title>Pattients</title>
    <script>activateSelection("pattients")</script> <!-- Change Pattients-sellection text color, to white, in header bar -->

    <div class="container-fluid " style="width:90%">
    <div class="row justify-content-lg-center" style="margin-top:80px;">
            <div class="col-12 col-lg-8">
                <div class="p-2 bg-primary border text-white" style="text-align:center"><h2>List of all patients</h2></div>
                <div class="row">
                    <div class="col-4 col-lg-1">ID</div>
                    <div class="col-4 col-lg-1">Firtname</div>
                    <div class="col-4 col-lg-1">Lastname</div>
                    <div class="col-4 col-lg-1">Email</div>
                    <div class="col-4 col-lg-1">Phone</div>
                    <div class="col-4 col-lg-1">Address</div>
                    <div class="col-4 col-lg-1">Town</div>
                    <div class="col-4 col-lg-1">Age</div>
                    <div class="col-4 col-lg-1">Insurance</div>
                    <div class="col-4 col-lg-1">AMKA</div>
                    <div class="col-4 col-lg-1">Active From</div>
                    <div class="col-4 col-lg-1">Last visit</div>    
                </div>
            </div>
            <div class="col-12 col-lg-3">
                <div class="p-2 bg-primary border text-white" style="text-align:center"><h2>Statistics</h2></div>
            </div>
        </div>
    </div>





































   <?php // List of all pattients //
    /* $totalnumber = GetNumberOfPattientsByUserId($userId);
    $allPattientsByUser = GetPattientsByUserId($userId); 
    if(!$allPattientsByUser){
        echo "No Data From DataBase";
        exit;
    }
    $aa = 1;
    echo "<table>
            <tr><td>A/A</td>
                <td>Lastname</td>
                <td>Firstname</td>
                <td>PattientId</td>
                <td>Age</td>
                <td>Gender</td>
                <td>Insurance</td>
                <td>AMKA</td>
                <td>Address</td>
                <td>Town</td>
                <td>Phone</td>
                <td>Active from</td>
                <td>Last visit</td>
            </tr>";

    foreach($allPattientsByUser as $pattient){
        echo "<tr>
                <td>"."$aa"."</td>
                <td>".$pattient->Lastname."</td>
                <td>".$pattient->Firstname."</td>
                <td>".$pattient->Id."</td>
                <td>".$pattient->Age."</td>
                <td>".$pattient->Gender."</td>
                <td>".$pattient->Insurance."</td>
                <td>".$pattient->Amka."</td>
                <td>".$pattient->Address."</td>
                <td>".$pattient->Town."</td>
                <td>".$pattient->Phone."</td>
                <td>".$pattient->CreatedAt."</td>
                <td>".$pattient->LastVisitAt."</td>
        </tr>";
                       
      $aa++;         
                
    }
    echo "</table>";
    // List Of All Pattients ^^^^^^ //

    
    // Average Age of All Pattients //
    if(GetAverageAgeOfPattientsByUserId($userId) == false){
        echo "false";
    }
    else echo GetAverageAgeOfPattientsByUserId($userId);
    

    // number of males and fmales //
    $total =  GetNumberOfFmalesAndMalesByUserId($userId);
    echo $total->Males."   ".$total->Fmales;  */
?>
   
    
   </body>
</html>
<?php ob_end_flush();?>

