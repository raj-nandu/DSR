<?php 
    session_start();
    if($_SESSION['auth'] && $_SESSION['role'] == 'admin'){
        if($_POST){
            include 'connection.php';
            $cdn = $_POST['r1'];
            $lab_name = $_POST['lab_name'];
            $from_lab = $_SESSION['from_lab_id'];
            $link = mysqli_connect($servername,$username,$password,$dbname);
            if(isset($_POST['r1']) && isset($_POST['lab_name'])){
                $query = "SELECT eqp_id,rate,quantity FROM equipment WHERE central_dsr_no = '$cdn'";
                $result = mysqli_query($link,$query);
                while ($row = $result->fetch_assoc()) {
                    $eqp_id = $row['eqp_id'];
                    $rate = $row['rate'];
                    $quantity = $row['quantity'];
                }
                $query4 = "SELECT lab_name FROM lab WHERE lab_id = $from_lab";
                $result4 = mysqli_query($link,$query4);
                while ($row = $result4->fetch_assoc()) {
                    $from_lab_name = $row['lab_name'];
                }

                $query1 = "SELECT lab_id FROM lab WHERE lab_name = '$lab_name'";
                $result1 = mysqli_query($link,$query1);
                while ($row = $result1->fetch_assoc()) {
                    $lab_idi = $row['lab_id'];
                }
                if($lab_idi != $from_lab){
                    $query2 = "UPDATE equip_lab SET lab_id = $lab_idi, transferred = 1 WHERE eqp_id = $eqp_id AND lab_id = $from_lab";
                    $result2 = mysqli_query($link,$query2);
                    $date = date("Y-m-d");
                    $query3 = "INSERT INTO transfer VALUES ($from_lab,'$from_lab_name',$lab_idi,'$lab_name',$eqp_id,'$date')";
                    $result3 = mysqli_query($link,$query3);

                    $quer = "UPDATE lab SET lab_cost = lab_cost + $rate WHERE lab_id = $lab_idi";
                    $resu = mysqli_query($link,$quer);

                    $quer2 = "UPDATE lab SET lab_cost = lab_cost - $rate WHERE lab_id = $from_lab";
                    $resu2 = mysqli_query($link,$quer2);

                    $cdn = chop($cdn,'(t)');
                    $cdn = strrev($cdn);
                    $to_remove = "KJSCE/COMP/".$from_lab_name."/";
                    $to_remove = strrev($to_remove);

                    $cdn = chop($cdn,$to_remove);
                    $cdn = strrev($cdn);

                    if($quantity == 1){
                        $cdn = "KJSCE/COMP/".$lab_name."/".$cdn."(t)";
                    } else {
                        $cdn = "KJSCE/COMP/".$lab_name."/".$cdn.")(t)";
                    }
                    

                    $query5 = "UPDATE equipment SET central_dsr_no = '$cdn' WHERE eqp_id = $eqp_id";
                    $result5 = mysqli_query($link,$query5);


                    $output = '<h3>Transfer successful</h3>';
                }
                else{
                    $output = '<h3>Cannot transfer to same lab</h3>';
                }
            }
        }
    } 
        
    
    else
    {
       header('location: login.php');
    }


?>
<!DOCTYPE html>
<html>
<head>
    <title>Transfer</title>
    <link rel="stylesheet" type="text/css" href="assets/css/lib/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="assets/css/data_entry_lab_assistant.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300" rel="stylesheet">

    <script type="text/javascript" src = "assets/javascript/lib/jQuery.js"></script>
    <script type="text/javascript" src = "assets/javascript/lib/bootstrap.js"></script>
</head>
<body>
    <h1 class = "header"><img src = "images/logo.png" style="width:40px;height:40px;"><span style="display:inline-block; width: 40px;"></span>Computer Department, K.J. Somaiya College Of Engineering</h1>

    <div>
        <nav class="navbar navbar-default">
            <div class="container-fluid">

                <div class="navbar-header">
                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                  </button>
                  <p class = "navbar-text">COMPS DSR</p>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li ><a href="data_entry.php">Data Entry</a></li>
                        <li ><a href="admin.php">Edit Data</a></li>
                        <li ><a href="delete.php">Write Off</a></li>
                        <li ><a href="report.php">Generate Report</a></li>
                        <li class = "active"><a href="transfer.php" class = "active-page">Transfer</a></li>
                        <li ><a href="newuser.php">Add new user</a></li>
                        <li ><a href="lab_details.php">Lab Details</a></li>
                        <li ><a href="undo.php">Roll Back Operations</a></li>
                        <li ><a href="admin_labid.php">Change Lab</a></li>
                        <li ><a href="adminchange.php">Change Admin</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="logout.php">Log Out</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-login">
                    <div class="panel-heading">
                    <?php echo $output; ?>
                        <form method="post" action='transfer3.php'>
                             <div class="form-group">    
                                <div class="row">
                                    <div class="col-sm-12 ">
                                        <input type="submit" name="home" id="register-submit" class="form-control btn btn-register" value="home">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
