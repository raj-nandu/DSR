<!DOCTYPE html>
<html>
<head>
	<title>Lab Details</title>
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
			        	<li ><a href="transfer.php">Transfer</a></li>
			        	<li ><a href="newuser.php">Add new user</a></li>
			        	<li class = "active"><a href="lab_details.php" class = "active-page">Lab Details</a></li>
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
	                    	<div class="row">
	                    		<div class="col-md-12">
	                    			<?php 
										session_start();
										if ($_SESSION['auth']) {
											$lab_id = $_SESSION['lab_id'];
											include 'connection.php';
											$query = "SELECT lab_name,lab_incharge,lab_cost,lab_investment,room_no,name,phone,email FROM lab,staff WHERE lab.lab_id = $lab_id AND lab.lab_id = staff.lab_id LIMIT 1";
											$res0 = mysqli_query($link,$query);
											if ($res0->num_rows > 0) {
												echo "Lab Details<br>";
												while($row = $res0->fetch_assoc()) {
													echo "Lab Name: ".$row['lab_name']."<br>";
													echo "Lab Incharge: ".$row['lab_incharge']."<br>";
													echo "Lab Cost: ".$row['lab_cost']."<br>";
													echo "Lab Investment: ".$row['lab_investment']."<br>";
													echo "Lab Room No: ".$row['room_no']."<br><br>";
													echo "Lab Assistant Details:"."<br>";
													echo "Name: ".$row['name']."<br>";
													echo "Phone Number: ".$row['phone']."<br>";
													echo "Email-id: ".$row['email']."<br>";
												}

											}
										}
										else{
											header('location: login.php');
										}

									?>
	                    		</div>
	                    	</div>
	                        
	                    </div>
	                </div>
	            </div>
	        </div>
    	</div>
</body>
</html>
