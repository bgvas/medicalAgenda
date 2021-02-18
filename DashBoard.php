<?php
echo "Start" ; 
    ob_start();
    
    include 'DataBase/UserDataBaseService.php';
    include 'DataBase/PatientDataBaseService.php';

    // If user comes from login, must have username and password from POST response //
    if(isset($_POST['username']) && isset($_POST['password'])){
        $password = hashing($_POST['password']);
        $username = $_POST['username'];
        if(!CheckUser($username, $password)){   // check if username and password, are valid
            header("Location: Authorization/Login.html?result=errorlogin");
            exit;
        }
        $userId = GetUserIdByUsernameAndPassword($username, $password); 
        if($userId <= 0){
            header("Location: Authorization/Login.html?result=usernotfound");
            exit;
        }
        $token = GenerateToken($userId);
        setcookie("token", $token, time() + (600));// Keep token alive for 10 minutes
    } // if user is already logged in, must have a valid token in COOKIE
    else if(isset($_COOKIE['token'])){
        $userId = GetUserIdByToken($_COOKIE['token']);
        if($userId <= 0){
            header("Location: Authorization/Login.html?result=usernotfound");
            exit;
        }
        $token = GenerateToken($userId);        // refresh token in Cookie and in DB every time the user comes in dashboard
        setcookie("token", $token, time() + (600), '/');/// Keep token alive for 10 minutes
    } 
    else {
        header("Location: Authorization/Login.html?result=errorlogin");
        exit;
    }
    $patients = GetPatientsByUserId($userId);

    $user = GetUserByUserId($userId);


    // if user is visitor redirect to VisitorsDashboard //
    if($user->Role == "visitor"){ 

        header("Location: ./Visitor/VisitorDashBoard.php");
        exit;
    }

    // if user is admin redirect to AdminDashboard //
    if($user->Role == "admin"){
    
        header("Location: ./Admin/AdminDashBoard.php");
        exit;
    }

    include_once "./Decorations/MainTemplate.php";  // use the base html template
   


?>

<title>DashBoard</title>

<!-- Chart For monthly visits from patients-->
<script type="text/javascript">
// Load google charts
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

// Draw the chart and set the chart values
function drawChart() {
    var data = google.visualization.arrayToDataTable([
        ['Month', 'Visits'],
        <?php
            if($patients == null){
                ?> 
                    document.getElementById('areachart').innerHtml = "No Data";
                    return;
                <?php 
            }
            else{
                    echo "['1',".VisitsPerMonth($userId, 1)."],";
                    echo "['2',".VisitsPerMonth($userId, 2)."],";
                    echo "['3',".VisitsPerMonth($userId, 3)."],";
                    echo "['4',".VisitsPerMonth($userId, 4)."],";
                    echo "['5',".VisitsPerMonth($userId, 5)."],";
                    echo "['6',".VisitsPerMonth($userId, 6)."],";
                    echo "['7',".VisitsPerMonth($userId, 7)."],";
                    echo "['8',".VisitsPerMonth($userId, 8)."],";
                    echo "['9',".VisitsPerMonth($userId, 9)."],";
                    echo "['10',".VisitsPerMonth($userId, 10)."],";
                    echo "['11',".VisitsPerMonth($userId, 11)."],";
                    echo "['12',".VisitsPerMonth($userId, 12)."],";
                
            }
        ?>
    ]);

    // Optional; add a title and set the width and height of the chart
    var options = {
        chartArea:{
            width: '60%',
        },
          title: 'Monthly Visits',
          hAxis: {title: 'Month',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0}
    };

    // Display the chart inside the <div> element with id="areachart"
    var chart = new google.visualization.AreaChart(document.getElementById('areachart'));
           
    chart.draw(data, options);
}
$(window).resize(function(){
  drawChart();
});

</script>
 


<div class="container-fluid " style="width:90%">
    <div class="row justify-content-lg-center" style="margin-top:80px;">
        <div class="col-lg-8 col-lg-push-3 col-sm-12 col-xs-12 order-lg-1 order-1" >
            <div class="p-2 bg-primary" style="height:120px">
                <h4 style="color:white;padding-left:10px;padding-top:8px;padding-bottom:0px">Welcome Dr.  <?php echo " ".$user->Lname." ".$user->Fname ?></h4>
                <p style="color:white;padding-left:10px;padding-top:0px">Here are your important task and reports.</p> 
            </div>
        </div>
        <div class="col-lg-3 col-lg-push-3 col-sm-12 col-xs-12 order-lg-2 order-2" style="height:150px">
           <div class="bg-white" style="height:150px">
                <div style="width:30%;border-radius:25px;margin-left:38%">
                    <img src="Images/person.jfif" style="width:75%;height:77%;margin-top:10px" class="img-thumbnail" default="User Image"></img>  
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-lg-push-3 col-sm-12 col-xs-12 order-lg-3 order-5" ><div name="visits"  id="areachart" class="p-2 bg-white" style="height:250px"></div></div>
        <div class="col-lg-3 col-lg-push-3 col-sm-12 col-xs-12 order-lg-4 order-3" style="height:280px;text-align: center;">
                <div class="p-2 bg-white" style="height:280px;">
                        <hr style="margin-top:0">
                        <div class="row justify-content">
                            <div class="col-6 col-lg-6" style="text-align:center">
                                <p class="text-black"><span class="text-primary"><strong><?php echo GetNumberOfPatientsByUserId($userId)?></strong></span></p>
                                <p>Total Patients</p>
                            </div>
                            <div class="col-6 col-lg-6" style="text-align:center">
                                <p class="text-black" ><span class="text-primary"><strong><?php echo TotalVisits($userId)?></strong></span></p>
                                <p>Total Visits</p>
                            </div>
                            <div class="col-6 col-lg-6" style="text-align:center">
                                <p class="text-black"><span class="text-primary"><strong><?php echo PatientsWithOneVisit($userId)."</br>"?></strong></span></p>
                                <p>Patients with one visit</p>
                            </div>
                            <div class="col-6 col-lg-6" style="text-align:center">
                                <p class="text-black"><span class="text-primary"><strong><?php echo ReturningPatients($userId)."</br>"?></strong></span></p>
                                <p>Returning patients</p>
                            </div>
                        </div> 
                </div>
        </div>
        <div class="col-lg-3 col-lg-push-3 col-sm-12 col-xs-12 order-lg-6 order-4" style="height:280px">
                <div class="p-2 bg-white" style="height:250px;text-align:center">
                        <div class="row justify-content-lg-center">
                            <div class="col-sm-3 col-md-3 col-lg-5" style="margin-top:25px">
                                <a href="./Visits/ListOfVisits.php" type="button" class="btn btn-primary" style="width:80%;padding-left:5px">All Visits</a>
                            </div>
                            <div class="col-sm-3 col-md-3 col-lg-5" style="margin-top:25px">
                                <a href="./Pattients/NewPatient.php" type="button" class="btn btn-success" style="width:80%;padding-left:5px">New Patient</a>
                            </div>
                        </div>
                </div>
        </div>
        <div class="col-lg-8 col-lg-push-3 col-sm-12 col-xs-12 order-lg-5 order-6 " style="height:280px">
            <div class="p-2 bg-white" style="height:250px">
                <h6  style="padding-left:15px;padding-top:15px">Recent Visits for current month</h6>
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
                    <div class="col-lg-1 col-4 d-none d-lg-block d-lg-none" style="font-size:0.8rem;"> <!-- visible only on large screens -->
                    Address
                    </div>
                    <div class="col-lg-1 col-4 d-none d-lg-block d-lg-none" style="font-size:0.8rem;"> <!-- visible only on large screens -->
                    Town
                    </div>
                    <div class="col-lg-1 col-4 d-none d-lg-block d-lg-none" style="font-size:0.8rem;"> <!-- visible only on large screens -->
                    Phone
                    </div>
                    <div class="col-lg-1 col-4 d-none d-lg-block d-lg-none" style="font-size:0.8rem;"> <!-- visible only on large screens -->
                    AMKA
                    </div>
                    <div class="col-4 col-lg-2"  style="font-size:0.8rem;">
                    Visit at
                    </div>
                </div>
                <div style="margin-left:5px;height:150px;overflow:hidden;overflow-y:scroll;text-align:center">
                    <?php 
                    $counter = 0;
                        $recentPatients = GetRecentVisitsByUserId($userId); // Get List with recent Visits from DB 
                        if($recentPatients != null){
                            foreach($recentPatients as $pattient){
                                if($counter % 2 == 0){?>
                                    <div class="p-1 border  bg-light" style="text-align:center">
                                <?php }else {?>
                                    <div class="p-1 border" style="text-align:center">
                                <?php }?>
                                    <div class="row">
                                        <div class="col-4 col-lg-2 "  style="font-size:0.7rem;">
                                            <?php echo $pattient->Lastname; ?>
                                        </div>
                                        <div class="col-4 col-lg-2"  style="font-size:0.7rem;">
                                            <?php echo $pattient->Firstname; ?>
                                        </div>
                                        <div class="col-lg-1 col-4 d-none d-lg-block d-lg-none" style="font-size:0.7rem;"> <!-- visible only on large screens -->
                                            <?php echo $pattient->Age; ?>
                                        </div>
                                        <div class="col-lg-1 col-4 d-none d-lg-block d-lg-none" style="font-size:0.7rem;"> <!-- visible only on large screens -->
                                            <?php echo $pattient->Address; ?>
                                        </div>
                                        <div class="col-lg-1 col-4 d-none d-lg-block d-lg-none" style="font-size:0.7rem;"> <!-- visible only on large screens -->
                                            <?php echo $pattient->Town; ?>
                                        </div>
                                        <div class="col-lg-1 col-4 d-none d-lg-block d-lg-none" style="font-size:0.7rem;"> <!-- visible only on large screens -->
                                            <?php echo $pattient->Phone; ?>
                                        </div>
                                        <div class="col-lg-1 col-4 d-none d-lg-block d-lg-none" style="font-size:0.7rem;"> <!-- visible only on large screens -->
                                            <?php echo $pattient->Amka;?>
                                        </div>
                                        <div class="col-4 col-lg-2"  style="font-size:0.7rem;">
                                            <?php echo $pattient->VisitAt; ?>
                                        </div>
                                    </div>
                                </div><?php $counter++?>
                    
                        <?php }}else{ echo "<div class='col-12 center-block' style='font-size:0.8rem;text-align:center;margin-top:10px'>No visits found</div>";}?>
                </div>
            </div>
        </div>
       
    </div>
</div>

</body>
</html>
<?php 

function Hashing($string){

    $salt = "MyEncryptionKey";
    $enc_key = bin2hex($string);
    $enc_salt = bin2hex($salt);
    $token = hash('sha512', $enc_key.$enc_salt);
    return $token;
}
ob_end_flush();

?>

