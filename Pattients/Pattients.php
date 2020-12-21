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
                <div class="p-2 bg-primary border text-white" style="text-align:center"><h4>List of all patients</h4></div>
                <div class="p-1 border bg-light" style="text-align:center">
                    <div class="row">
                        <div class="col-4 col-lg-1"><strong>Lastname</strong></div>
                        <div class="col-4 col-lg-1"><strong>Firtname</strong></div>
                        <div class="col-4 col-lg-1"><strong>ID</strong></div>
                        <div class="col-4 col-lg-2 d-none d-lg-block d-lg-none"><strong>Email</strong></div> <!-- Visible only on big screens-->
                        <div class="col-4 col-lg-1 d-none d-lg-block d-lg-none"><strong>Phone</strong></div> <!-- Visible only on big screens-->
                        <div class="col-4 col-lg-2 d-none d-lg-block d-lg-none"><strong>Address</strong></div> <!-- Visible only on big screens-->
                        <div class="col-4 col-lg-1 d-none d-lg-block d-lg-none"><strong>Town</strong></div> <!-- Visible only on big screens-->
                        <div class="col-4 col-lg-1 d-none d-lg-block d-lg-none"><strong>Age</strong></div> <!-- Visible only on big screens-->
                        <div class="col-4 col-lg-1 d-none d-lg-block d-lg-none"><strong>Insurance</strong></div> <!-- Visible only on big screens-->
                        <div class="col-4 col-lg-1 d-none d-lg-block d-lg-none"><strong>AMKA</strong></div><!--  Visible only on big screens-->
                        <!-- <div class="col-4 col-lg-1 d-none d-lg-block d-lg-none"><strong>Active From</strong></div>  Visible only on big screens-->
                        <!-- <div class="col-4 col-lg-1 d-none d-lg-block d-lg-none"><strong>Last visit</strong></div>  Visible only on big screens-->   
                    </div>
                    <div style="overflow:hidden;overflow-y:scroll;text-align:center">
                            <?php
                            $allPatients = GetPatientsByUserId($userId);
                            $counter = 0;
                        
                            foreach($allPatients as $patient){
                                if($counter % 2 == 0){?> 
                        <div class="p-1 border" >
                                <?php }else {?>
                        <div class="p-1 border bg-secondary" style="text-align:center" id="odd">
                                <?php }?>
                            
                            <div class="row">
                                <div class="col-4 col-lg-1" style="font-size:0.7rem;"><?php echo $patient->Lastname;?></div>
                                <div class="col-4 col-lg-1" style="font-size:0.7rem;"><?php echo $patient->Firstname;?></div>
                                <div class="col-4 col-lg-1" style="font-size:0.7rem;"><?php echo $patient->Id;?></div>
                                <div class="col-4 col-lg-2 d-none d-lg-block d-lg-none" style="font-size:0.6rem;"><?php echo $patient->Email;?></div><!-- Visible only on big screens-->
                                <div class="col-4 col-lg-1 d-none d-lg-block d-lg-none" style="font-size:0.7rem;"><?php echo $patient->Phone;?></div><!-- Visible only on big screens-->
                                <div class="col-4 col-lg-2 d-none d-lg-block d-lg-none" style="font-size:0.7rem;"><?php echo $patient->Address;?></div><!-- Visible only on big screens-->
                                <div class="col-4 col-lg-1 d-none d-lg-block d-lg-none" style="font-size:0.7rem;"><?php echo $patient->Town;?></div><!-- Visible only on big screens-->
                                <div class="col-4 col-lg-1 d-none d-lg-block d-lg-none" style="font-size:0.7rem;"><?php echo $patient->Age;?></div><!-- Visible only on big screens-->
                                <div class="col-4 col-lg-1 d-none d-lg-block d-lg-none" style="font-size:0.7rem;"><?php echo $patient->Insurance;?></div><!-- Visible only on big screens-->
                                <div class="col-4 col-lg-1 d-none d-lg-block d-lg-none" style="font-size:0.7rem;"><?php echo $patient->Amka;?></div><!-- Visible only on big screens-->
                                <!-- <div class="col-4 col-lg-1 d-none d-lg-block d-lg-none" style="font-size:0.7rem;">22/11/2020</div>
                                <div class="col-4 col-lg-1 d-none d-lg-block d-lg-none" style="font-size:0.7rem;">22/11/2020</div>-->
                            </div>
                        </div><?php  $counter++; }?>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3">
                <div class="p-2 bg-primary border text-white" style="text-align:center"><h4>Statistics</h4></div>
                <div class="p-1 border" style="text-align:center">
                    <div class="row">
                        <div class="col-4 col-lg-1" style="text-align:center"><strong>Alpha</strong>
                    </div>
                </div>
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

