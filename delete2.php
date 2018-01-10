<?php 
	session_start();
	if($_SESSION['auth'] && $_SESSION['role'] == 'admin'){
		if($_POST['final_submit']){
			if(!isset($_POST['r1'])){
				header('location: delete.php');
			}
			include 'connection.php';

			$cdn = $_POST['r1'];
			$lab_id = $_SESSION['lab_id'];

			$query3 = "UPDATE equipment SET Del_flag = 0 WHERE central_dsr_no = '$cdn'";
			$result3 = mysqli_query($link, $query3); 

			$query0 = "SELECT rate FROM equipment WHERE central_dsr_no LIKE '$cdn'";
			$result0 = mysqli_query($link, $query0);
			
			if ($result0->num_rows > 0) {
	
				while($row = $result0->fetch_assoc()) {
					$amount = $row['rate'];
				}

			}

			$queri = "UPDATE lab SET lab_cost = lab_cost - $amount WHERE lab_id = $lab_id";
			$result = mysqli_query($link, $queri);
			$output = 'Successfully Deleted';

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
                        <li ><a href="admin.php" >Edit Data</a></li>
                        <li class = "active"><a href="delete.php" class = "active-page">Write Off</a></li>
                        <li ><a href="report.php">Generate Report</a></li>
                        <li ><a href="transfer.php">Transfer</a></li>
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
                        <form method="post" action='delete3.php'>
                             <div class="form-group">    
                                <div class="row">
                                    <div class="col-sm-12 ">
                                        <input type="submit" name="home" id="register-submit" class="form-control btn btn-register" value="Back">
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