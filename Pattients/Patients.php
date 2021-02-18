<?php
    ob_start();
    require_once '../DataBase/UserDataBaseService.php';
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
    include "../Decorations/MainTemplate.php";  // use the base html template
    $token = GenerateToken($userId);        // refresh token in Cookie and in DB every time the user comes here
    setcookie("token", $token, time() + (600), '/');/// Keep token alive for 10 minutes ?>

    
    <title>Patients</title>
    <script>
        activateSelection("pattients")<!-- Change Patients-selection text color, to white, in header bar -->
    </script>
        <div class="container-fluid " style="width:90%">
            <div class="row justify-content-lg-center" style="margin-top:80px;">
                <div class="col-12 col-lg-8">
                    <div class="p-2 bg-primary border text-white" style="text-align:center"><h4>List of all patients</h4></div>
                    <div class="p-1 border bg-light" style="text-align:center">
                        <div class="row">
                            <div class="col-4 col-lg-1"><strong>Lastname</strong></div>
                            <div class="col-4 col-lg-1"><strong>Firtname</strong></div>
                            <div class="col-4 col-lg-1 d-none d-lg-block d-lg-none"><strong>ID</strong></div> <!-- Visible only on big screens-->
                            <div class="col-4 col-lg-2 d-none d-lg-block d-lg-none"><strong>Email</strong></div> <!-- Visible only on big screens-->
                            <div class="col-4 col-lg-1 d-none d-lg-block d-lg-none"><strong>Phone</strong></div> <!-- Visible only on big screens-->
                            <div class="col-4 col-lg-2 d-none d-lg-block d-lg-none"><strong>Address</strong></div> <!-- Visible only on big screens-->
                            <div class="col-4 col-lg-1 d-none d-lg-block d-lg-none"><strong>Town</strong></div> <!-- Visible only on big screens-->
                            <div class="col-4 col-lg-1"></div>
                            <div class="col-4 col-lg-1 d-none d-lg-block d-lg-none"></div> <!-- Visible only on big screens-->
                            <div class="col-4 col-lg-1 d-none d-lg-block d-lg-none"></div><!--  Visible only on big screens-->
                        </div>
                        <div style="overflow:hidden;overflow-y:scroll;text-align:center;height:410px;">
                                <?php
                                $allPatients = GetPatientsByUserId($userId);
                                $counter = 0;

                                foreach($allPatients as $patient){
                                    if($counter % 2 == 0){?>
                            <div class="p-1 border  bg-white" style="text-align:center">
                                    <?php }else {?>
                            <div class="p-1 border" style="text-align:center">
                                    <?php }?>

                                <div class="row">
                                    <div class="col-4 col-lg-1" style="font-size:0.8rem;"><?php echo $patient->Lastname;?></div>
                                    <div class="col-4 col-lg-1" style="font-size:0.8rem;"><?php echo $patient->Firstname;?></div>
                                    <div class="col-4 col-lg-1 d-none d-lg-block d-lg-none" style="font-size:0.8rem;"><?php echo $patient->Id;?></div><!-- Visible only on big screens-->
                                    <div class="col-4 col-lg-2 d-none d-lg-block d-lg-none" style="font-size:0.7rem;"><?php echo $patient->Email;?></div><!-- Visible only on big screens-->
                                    <div class="col-4 col-lg-1 d-none d-lg-block d-lg-none" style="font-size:0.8rem;"><?php echo $patient->Phone;?></div><!-- Visible only on big screens-->
                                    <div class="col-4 col-lg-2 d-none d-lg-block d-lg-none" style="font-size:0.8rem;"><?php echo $patient->Address;?></div><!-- Visible only on big screens-->
                                    <div class="col-4 col-lg-1 d-none d-lg-block d-lg-none" style="font-size:0.8rem;"><?php echo $patient->Town;?></div><!-- Visible only on big screens-->
                                    <div class="col-4 col-lg-1">
                                        <form action="./PatientProfile.php" method="POST">
                                            <button style="border:0"><img src="../Images/view.png" width="15px" height="17px" /></button>
                                            <input type="hidden" name="id" value="<?php echo $patient->Id; ?>"/>
                                        </form>
                                    </div>
                                    <div class="col-4 col-lg-1 d-none d-lg-block d-lg-none">   <!-- visible only on big screens -->
                                        <form action="./EditPatientProfile.php" method="POST">
                                            <button style="border:0"><img src="../Images/edit.png" width="15px" height="17px"/></button>
                                            <input type="hidden" name="id" value="<?php echo $patient->Id; ?>"/>
                                        </form>
                                    </div>
                                    <div class="col-4 col-lg-1 d-none d-lg-block d-lg-none">  <!-- visible only on big screens -->
                                        <form action="./DeletePatient.php" method="POST">
                                            <button style="border:0"><img src="../Images/delete.png" width="15px" height="17px"/></button>
                                            <input type="hidden" name="id" value="<?php echo $patient->Id; ?>"/>
                                        </form>
                                    </div><!-- Visible only on big screens-->
                                </div>
                            </div><?php  $counter++; }?>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-3">
                    <div class="p-2 bg-primary border text-white" style="text-align:center"><h4>My Patients</h4></div>
                    <div class="p-1 border bg-light">
                        <div class="row justify-content-lg-center">
                            <div class="col-6 col-lg-4" style="text-align:center"><strong>Total number: </strong></div>
                            <div class="col-6 col-lg-4" style="text-align:center"><?php echo GetNumberOfPatientsByUserId($userId);?></div>
                        </div>
                        <div class="row justify-content-lg-center">
                            <div class="col-6 col-lg-4" style="text-align:center"><strong>Average Age: </strong></div>
                            <div class="col-6 col-lg-4" style="text-align:center"><?php echo GetAverageAgeOfPatientsByUserId($userId);?></div>
                        </div>
                        <div class="row justify-content-lg-center">
                            <div class="col-6 col-lg-4" style="text-align:center"><strong>Females: </strong></div>
                            <div class="col-6 col-lg-4" style="text-align:center"><?php echo GetNumberOfFmalesAndMalesByUserId($userId)->Fmales;?></div>
                        </div>
                        <div class="row justify-content-lg-center">
                            <div class="col-6 col-lg-4" style="text-align:center"><strong>Males: </strong></div>
                            <div class="col-6 col-lg-4" style="text-align:center"><?php echo GetNumberOfFmalesAndMalesByUserId($userId)->Males;?></div>
                        </div>
                        <div class="row justify-content-lg-center">
                            <div class="col-lg col-md-1" >
                                <!-- Chart For age analysis -->
                                <?php $age = GetPatientsAgeAnalysis($userId);?>
                                <script type="text/javascript">
                                    // Load google charts
                                    google.charts.load('current', {'packages':['corechart']});
                                    google.charts.setOnLoadCallback(drawChart);
                                    // Set the data and draw the chart//
                                    function drawChart() {
                                        var a18To30 = parseInt("<? echo $age->a18To30;?>");
                                        var data = google.visualization.arrayToDataTable([
                                           ['Age', 'Number of patients'],
                                           <?php echo "['18-30',".$age->a18To30."],";
                                           echo "['31-50',".$age->a31To50."],";
                                           echo "['51-70',".$age->a51To70."],";
                                           echo "['70 +',".$age->a70plus."],";?>
                                        ]);

                                        // Optional; add a title and set the width and height of the chart
                                        var options = {
                                            title: 'Age Analysis',
                                            is3D: true,
                                        };
                                        // Display the chart inside the <div> element with id="piechart"
                                        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                                        chart.draw(data, options);
                                    }
                                </script>
                                <div class="bg-light p-2" id="piechart"></div>
                            </div>
                        </div>
                    </div>
                    <div class="pt-4">
                        <div class="row">
                            <div class="col-12">
                                <div class="p-2 border bg-light">
                                    <div class="row p-4">
                                        <div class="col-12" style="text-align:center">
                                            <a class="btn btn-info btn-sm" style="width:200px" href="./NewPatient.php" role="button">Add new patient</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</body>
</html>
<?php ob_end_flush();?>
