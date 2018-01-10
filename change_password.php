<?php 
	session_start();
	if($_SESSION['auth'] && ($_SESSION['role'] == 'lab' || $_SESSION['role'] == 'incharge') ){
		include 'connection.php';
		$error = '';
		$lab_id = $_SESSION['lab_id'];
		$role = $_SESSION['role'];
		$query2 = "SELECT staff_id,name,phone,username,email FROM staff WHERE lab_id = '$lab_id' AND role = '$role'";
		$result2 = mysqli_query($link,$query2);
		while($row = $result2->fetch_assoc()){
			$staff_id = $row['staff_id'];
			$name = $row['name'];
			$phone = $row['phone'];
			$username = $row['username'];
			$email = $row['email'];
		}

		if($_POST){
			$big = 0;
			if(isset($_POST['name']) && isset($_POST['phone']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password1'])){
				if($_POST['password1'] != $_POST['password']){
					$error .= 'Password did not match<br>';
					$big++;
				}
				$name = $_POST['name'];
				$phone = $_POST['phone'];
				$username = $_POST['username'];
				$email = $_POST['email'];
				$password = $_POST['password'];
				$password1 = $_POST['password1'];
				
				if (!preg_match("/^[ 0-9A-Za-z. \\- \s]+$/",$name)) {
		            $error .= "Only letters and white space are allowed in name.<br>"; 
		            $big++;
		        }
				if (!preg_match("/^[0-9]*$/",$phone)) {
		             $error .= "Only numbers are allowed in quantity.<br>"; 
		             $big++;
		        }
		        if (!preg_match("/^[a-zA-Z0-9._]*$/",$username)) {				// [a-zA-Z0-9@!# "add more special characters in here"]
					$error .= "Only letters,numbers and dots are allowed in username.<br>"; 
					$big++;
				}
				if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
					$error .= "Invalid email format.<br>";
					$big++;
				}
				if (!preg_match("/^[a-zA-Z0-9@!# ]*$/",$password)) {			// [a-zA-Z0-9@!# "add more special characters in here"]
					$error .= "Only letters,numbers @!# are allowed in password.<br>"; 
					$big++;
				}
				if (!preg_match("/^[a-zA-Z0-9@!# ]*$/",$password1)) {			// [a-zA-Z0-9@!# "add more special characters in here"]
					$error .= "Only letters,numbers @!# are allowed in password.<br>"; 
					$big++;
				}
				if($big == 0){
					$password = password_hash($password, PASSWORD_DEFAULT);
					$query1 = "UPDATE staff set name = '$name', phone = '$phone', username = '$username',password = '$password', email = '$email' WHERE staff_id = $staff_id";
					$res1 = mysqli_query($link,$query1);
					header('location: lab_details_lab.php');
				}

			}
			else{
				$error = "No field should be empty";
			}
			
		}
		
	}
	else {
		header('location:login.php');
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Add new user</title>
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
			        	<li ><a href="report_lab.php">Generate Report</a></li>
			        	<li ><a href="lab_details_lab.php">Lab Details</a></li>
			        	<li class = "active"><a href="change_password.php" class = "active-page">Update User Details</a></li>
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
	                    <h1>Updating User</h1>
	                    <div class="form-group inputs">
                     		<!-- Format here -->
							<?php
								echo "Current lab: ".$_SESSION['lab_name']."<br>";
								
							?>	
						</div>
						<form action="" method = 'post'>
							<div class="form-group">
								<div class = 'row'>
									<div class="form-group col-md-4 container">
										<label>Name:<input type="text" class="form-control" required  name="name" value = '<?php echo $name; ?>'></label>
									</div>
                                    <div class="form-group col-md-4 container">
										<label>Phone No:<input type="text" class="form-control" required  name="phone" value = '<?php echo $phone; ?>'></label>
									</div>
                                    <div class="form-group col-md-4 container">
										<label>Username:<input type="text" class="form-control" required  name="username" value = '<?php echo $username; ?>'></label>
									</div>
                                    <div class="form-group col-md-4 container">
										<label>Email-Id:<input type="email" class="form-control" required  name="email" value = '<?php echo $email; ?>'></label>
									</div>
                                    <div class="form-group col-md-4 container">
										<label>Password:<input type="password" class="form-control" required  name="password"></label>
									</div>
                                    <div class="form-group col-md-4 container">
										<label>Re-Enter Password:<input type="password" class="form-control" required  name="password1"></label>
									</div>
                                    <div class="form-group col-md-4 col-sm-offset-4 container">
                                        <input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-register" value="Submit" style="width : 225">
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