<?php 
	session_start();
	if($_SESSION['auth'] && ($_SESSION['role'] == 'lab' || $_SESSION['role'] == 'incharge')){
		include 'connection.php';
	}
	else
	{
		header('location: login.php');
	}



 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Generate Report</title>
	<link rel="stylesheet" type="text/css" href="assets/css/lib/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="assets/css/data_entry_lab_assistant.css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300" rel="stylesheet">
	<script type="text/javascript" src = "assets/javascript/lib/jQuery.js"></script>
	<script type="text/javascript" src = "assets/javascript/lib/bootstrap.js"></script>
	<style type="text/css">
		.col-md-3{
			text-align: left;
		}
	</style>
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
						<li class = "active"><a href="report_lab.php" class = "active-page">Generate Report</a></li>
			        	<li ><a href="lab_details_lab.php">Lab Details</a></li>
			        	<li><a href="change_password.php">Update User Details</a></li>
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
                    <a href="#" class="active" id="product-form-link">Report Detail</a>
							</div> <br> 
							<?php
										echo "Current lab = ".$_SESSION['lab_name']."<br>";
										if(isset($_SESSION['error'])){
											echo $_SESSION['error']."<br>";
											$_SESSION['error'] = "";
										}
										
									?>      
	<form method="post" action = "report1_lab.php" id="report-form">
       
	
	
       
        <div class="panel-body" style="color : #1CA347">
			<div class="row">
				<div class="col-lg-12">
                    <label>Enter type of report</label><br>
                    <div class="form-group col-md-3 inp2"><input type="radio" required name="typo" value="regular">Regular report</div>
                    <div class="form-group col-md-3 inp2"><input type="radio" required name="typo" value="transfer">Transfer report</div>
        			<div class="form-group col-md-3 inp2"><input type="radio" required name="typo" value="write_off">Write off report</div>
        			<div class="form-group col-md-3 inp2"><input type="radio" required name="typo" value="summary">Summary</div>
			        <div class="form-group col-md-12 container">
						<label>From <input type = "date" class = "form-control inputs" name = "from_date"></label>
						&nbsp;
						&nbsp;
						&nbsp;
						&nbsp;
						<label>To <input type = "date" class = "form-control inputs" name = "to_date"></label>
					</div><br>
        <label>Enter the fields you want to display in the report</label><br>
        <hr>
        <br><div class="form-group col-md-3 container"><input type="checkbox" id = 'sel_all' name="select_all"><strong>Select All</strong><br></div>
        <div class="form-group col-md-3 container"><input type="checkbox" name="name_of_equip">Name of Equipment<br></div>
        <div class="form-group col-md-3 container"><input type="checkbox" name="quantity">Quantity<br></div>
        <div class="form-group col-md-3 container"><input type="checkbox" name="type">Type of item<br></div>
        <div class="form-group col-md-3 container"><input type="checkbox" name="warranty">Warranty<br></div>
        <div class="form-group col-md-3 container"><input type="checkbox" name="rate">Rate<br></div>
        <div class="form-group col-md-3 container"><input type="checkbox" name="amount">Amount<br></div>
        <div class="form-group col-md-3 container"><input type="checkbox" name="central_dsr_no">DSR No<br></div>
        <div class="form-group col-md-3 container"><input type="checkbox" name="description">Description<br></div>
        <div class="form-group col-md-3 container"><input type="checkbox" name="purchase_date">Purchase Date<br></div>
        <div class="form-group col-md-3 container"><input type="checkbox" name="supply_date">Supply Date<br></div>
        <div class="form-group col-md-3 container"><input type="checkbox" name="bill_no">Bill Number<br></div>
        <div class="form-group col-md-3 container"><input type="checkbox" name="purchase_order_no">Purchase Order Number<br></div>
        <div class="form-group col-md-3 container"><input type="checkbox" name="name_of_vendor">Name of Vendor<br></div>
        <div class="form-group col-md-3 container"><input type="checkbox" name="contact_no">Vendor's Contact No<br></div>
        <div class="form-group col-md-3 container"><input type="checkbox" name="address">Address of Vendor<br></div>
         <div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
												<input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-register" value="Submit">
											</div>
										</div>
									</div>
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