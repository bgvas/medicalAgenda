<?php 
    ob_start();
    include_once 'DataBase/UserDataBaseService.php';
    include_once 'DataBase/PattientDataBaseService.php';
    include_once './Hellpers/AuthorizationHelper.php';

    // If user comes from login
    if(isset($_POST['username']) || !isset($_POST['password'])){
        $password = Hashing($_POST['password']);
        $username = $_POST['username'];
        if(!CheckUser($username, $password)){
            header("Location: Authorization/Login.html?result=errorlogin");
            exit;
        }
        $userId = GetUserIdByUsernameAndPassword($username, $password);
        if($userId <= 0){
            header("Location: Authorization/Login.html?result=usernotfound");
            exit;
        }
        $token = GenerateToken($userId);
        setcookie("token", $token, time() + (86400));// Keep token alive for one day
    } // if user is already loggedin
    else if(isset($_COOKIE['token'])){
        $userId = GetUserIdByToken($_COOKIE['token']);
        if($userId <= 0){
            header("Location: Authorization/Login.html?result=usernotfound");
            exit;
        }
        $token = GenerateToken($userId);
        setcookie("token", $token, time() + (86400), '/');// one day
    } 
    else {
        header("Location: Authorization/Login.html?result=errorlogin");
        exit;
    }
   
    include_once "./Decorations/MainTemplate.php";
    $pattients = GetPattientsByUserId($userId, 1);

    foreach($pattients as $p){
        if($p->UserId == null){
            exit;
        }
    }
    $user = GetUserByUserId($userId);
?>
<title>DashBoard</title>

<!-- Chart For Montly pattient visits -->
<script type="text/javascript">
// Load google charts
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

// Draw the chart and set the chart values
function drawChart() {
    var data = google.visualization.arrayToDataTable([
        ['Month', 'Visits'],
        <?php
            if($pattients == null){
                ?> 
                    document.getElementById('areachart').innerHtml = "No Data";
                    return;
                <?php 
            }
            else{
                $i = 1;
                foreach($pattients as $row){
                    echo "['".$row->Firstname."',".$i++."],";
                }
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

    // Display the chart inside the <div> element with id="piechart"
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
                <h4 style="color:white;padding-left:10px;padding-top:8px;padding-bottom:0px">Welcome Dr.  <?php echo " ".$user->Lastname." ".$user->Firstname ?></h4>
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
        <div class="col-lg-8 col-lg-push-3 col-sm-12 col-xs-12 order-lg-3 order-9" ><div name="visits"  id="areachart" class="p-2 bg-white" style="height:250px"></div></div>
        <div class="col-lg-3 col-lg-push-3 col-sm-12 col-xs-12 order-lg-4 order-3" style="height:280px;text-align: center;">
                <div class="p-2 bg-white" style="height:280px;">
                        <hr style="margin-top:0">
                        <div class="row justify-content">
                            <div class="col-6 col-lg-6" syle="text-align:center">
                                <p class="text-black"><span class="text-primary"><strong><?php echo GetNumberOfPattientsByUserId($userId)?></strong></span></p>
                                <p>Total Pattients</p>
                            </div>
                            <div class="col-6 col-lg-6" style="text-align:center">
                                <p class="text-black" ><span class="text-primary"><strong><?php echo "673"?></strong></span></p>
                                <p>Total Appointments</p>
                            </div>
                            <div class="col-6 col-lg-6" style="text-align:center">
                                <p class="text-black"><span class="text-primary"><strong><?php echo "45"."</br>"?></strong></span></p>
                                <p>Pattients with one visit</p>
                            </div>
                            <div class="col-6 col-lg-6" style="text-align:center">
                                <p class="text-black"><span class="text-primary"><strong><?php echo "123"."</br>"?></strong></span></p>
                                <p>Return pattients</p>
                            </div>
                        </div> 
                </div>
        </div>
        <div class="col-lg-4 col-lg-push-3 col-sm-12 col-xs-12 order-lg-5 order-5" style="height:280px">
                <div class="p-2 bg-white" style="height:250px">
                        <h6  style="padding-left:15px;padding-top:15px">Appointment Request</h6>
                </div>
        </div>
        <div class="col-lg-4 col-lg-push-3 col-sm-12 col-xs-12 order-lg-6 order-6" style="height:280px">
                <div class="p-2 bg-white" style="height:250px">
                        <h6  style="padding-left:15px;padding-top:15px">Appointments</h6>
                </div>
        </div>
        <div class="col-lg-3 col-lg-push-3 col-sm-12 col-xs-12 order-lg-7 order-4" style="height:280px">
                <div class="p-2 bg-white" style="height:250px;text-align:center">
                        <h6 class="text-black">Today appointments(limit 30)</h6>
                        <div class="progress">
                            <div class="progress-bar w-25" role="progressbar" aria-valuemin="0" aria-valuemax="100">7</div>
                        </div>
                        <hr>
                        <div class="row justify-content-lg-center">
                            <div class="col-sm-3 col-md-3 col-lg-5" style="margin-top:25px">
                                    <form action="" method="POST">
                                        <button type="submit" class="btn btn-primary " style="width:80%;padding-left:5px">New Appointment</button>
                                    </form>
                            </div>
                            <div class="col-sm-3 col-md-3 col-lg-5" style="margin-top:25px">
                                    <form action="" method="POST">
                                        <button type="button" class="btn btn-success  " style="width:80%;">New Pattient</button>
                                    </form>
                            </div>
                        </div>
                </div>
        </div>
        <div class="col-lg-8 col-lg-push-3 col-sm-12 col-xs-12 order-lg-8 order-7 " style="height:280px">
            <div class="p-2 bg-white" style="height:250px">
                <h6  style="padding-left:15px;padding-top:15px">Recent Pattients</h6>
                <div class="row justify-content" style="margin-left:5px; text-align:center">
                    <div class="col-4 col-lg-2 "  style="font-size:0.8rem;">
                    Last name
                    </div>
                    <div class="col-4 col-lg-2"  style="font-size:0.8rem;">
                    First name
                    </div>
                    <div class="col-4 col-lg-1"  style="font-size:0.8rem;">
                    Pattient code
                    </div>
                    <div class="col-lg-1 col-4 d-none d-lg-block d-lg-none" style="font-size:0.8rem;"> <!-- visible only on large screens -->
                    Age
                    </div>
                    <div class="col-lg-1 col-4 d-none d-lg-block d-lg-none" style="font-size:0.8rem;"> <!-- visible only on large screens -->
                    Gender
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
                    Insurance
                    </div>
                    <div class="col-lg-1 col-4 d-none d-lg-block d-lg-none" style="font-size:0.8rem;"> <!-- visible only on large screens -->
                    AMKA
                    </div>
                </div>
                <div style="margin-left:5px;height:150px;overflow:hidden;overflow-y:scroll;text-align:center">
                    <?php 
                        $recentPattients = GetRecentPattientsByUserId($userId); // Get List with recent pattients from DB 
                        if($recentPattients != null){
                            foreach($recentPattients as $pattient){
                                echo "<a href='#'><div class='row'>"
                    ?> 
                    <div class="col-4 col-lg-2 "  style="font-size:0.7rem;">
                        <?php echo $pattient->Lastname; ?>
                    </div>
                    <div class="col-4 col-lg-2"  style="font-size:0.7rem;">
                        <?php echo $pattient->Firstname; ?>
                    </div>
                    <div class="col-4 col-lg-1"  style="font-size:0.7rem;">
                        <?php echo $pattient->Id; ?>
                    </div>
                    <div class="col-lg-1 col-4 d-none d-lg-block d-lg-none" style="font-size:0.7rem;"> <!-- visible only on large screens -->
                        <?php echo $pattient->Age; ?>
                    </div>
                    <div class="col-lg-1 col-4 d-none d-lg-block d-lg-none" style="font-size:0.7rem;"> <!-- visible only on large screens -->
                        <?php echo $pattient->Gender; ?>
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
                        <?php echo $pattient->Insurance; ?>
                    </div>
                    <div class="col-lg-1 col-4 d-none d-lg-block d-lg-none" style="font-size:0.7rem;"> <!-- visible only on large screens -->
                        <?php echo $pattient->Amka;?>
                    </div>
                    
                        <?php  echo "</div></a>";}}else{ echo "<div class='col-12 center-block' style='font-size:0.8rem;text-align:center;margin-top:10px'>No recent users found</div>";}?>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-lg-push-8 col-sm-12 col-xs-12 order-lg-9 order-8 " style="height:280px">
            <div class="p-2 bg-white" style="height:250px">
                <h6  style="padding-left:15px;padding-top:15px">Incomes</h6>
            </div>
        </div>
    </div>
</div>

</body>
</html>
<?php ob_end_flush();?>

