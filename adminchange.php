<?php 
	session_start();
	if($_SESSION['auth'] && $_SESSION['role'] == 'admin'){
		include 'connection.php';
		$error = '';
		$lab_id = $_SESSION['lab_id'];

		$query2 = "SELECT staff_id,name,phone,username,email FROM staff WHERE lab_id = 0 AND role='admin'";
		$result2 = mysqli_query($link,$query2);
		while($row = $result2->fetch_assoc()){
			$name = $row['name'];
			$phone = $row['phone'];
			$username = $row['username'];
			$email = $row['email'];
			$staff_id = $row['staff_id'];
		}

		if(isset($_POST['adminstrator'])){
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
					header('location: lab_details.php');
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
 
<html>
<head>
	<title>Data Entry</title>
	<link rel="stylesheet" type="text/css" href="assets/css/lib/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="assets\javascript\lib\bootstrap-select-1.12.4\dist\css\bootstrap-select.css">
	<link rel="stylesheet" type="text/css" href="assets/css/data_entry_lab_assistant.css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300" rel="stylesheet">
	<script type="text/javascript" src = "assets/javascript/lib/jQuery.js"></script>
	<script type="text/javascript" src = "assets/javascript/lib/bootstrap.js"></script>
    <script type="text/javascript" src = "assets\javascript\lib\bootstrap-select-1.12.4\js\bootstrap-select.js"></script>
       


    <script type="text/javascript">
		// Get the element with id="defaultOpen" and click on it
		document.getElementById("defaultOpen").click();

		function openFormPart(evt, typename) {
		    // Declare all variables
		    var i, tabcontent, tablinks;

		    // Get all elements with class="tabcontent" and hide them
		    tabcontent = document.getElementsByClassName("tabcontent");
		    for (i = 0; i < tabcontent.length; i++) {
		        tabcontent[i].style.display = "none";
		    }

		    // Get all elements with class="tablinks" and remove the class "active"
		    tablinks = document.getElementsByClassName("tablinks");
		    for (i = 0; i < tablinks.length; i++) {
		        tablinks[i].className = tablinks[i].className.replace(" active", "");
		    }

		    // Show the current tab, and add an "active" class to the button that opened the tab
		    document.getElementById(typename).style.display = "block";
		    evt.currentTarget.className += " active";
		}

		
	</script>
	<style type="text/css">
		.sbm{
			text-align: center;
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
				        	<li ><a href="data_entry.php">Data Entry</a></li>
				        	<li ><a href="admin.php">Edit Data</a></li>
				        	<li ><a href="delete.php">Write Off</a></li>
				        	<li ><a href="report.php">Generate Report</a></li>
				        	<li ><a href="transfer.php">Transfer</a></li>
				        	<li ><a href="newuser.php">Add new user</a></li>
				        	<li ><a href="lab_details.php">Lab Details</a></li>
				        	<li ><a href="undo.php">Roll Back Operations</a></li>
				        	<li ><a href="admin_labid.php">Change Lab</a></li>
				        	<li class = "active"><a href="adminchange.php" class = "active-page">Change Admin</a></li>				        	
					        	
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
    		<div class="row"></div>
			<div class="col-md-6 col-md-offset-3">
				<div class="panel panel-login">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-12">
								<a href="#" class="active" id="product-form-link">Update Lab Assistant</a>
							</div>
                            
						</div>
						<hr>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								
								<form method="post" action="" >
									<div class="tabcontent" id="product-form" style="display: block;">
										<div style="color: #68100d; text-align: center;">
											<?php 
											if(isset($_SESSION['res'])){
												echo $_SESSION['res'].'<br>';
												$_SESSION['res'] = null;
											}
											

										 ?>	
										</div>
										<br>
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
	                                    
										<div class="form-group">
											<div class="row">
												<div class="col-md-12 sbm"><br><br>
													<input type="submit" name="adminstrator" class="form-control btn btn-register" style="width : 150px;">
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
		</div>
	</div>	
</body>
    	<script>
            $(function() {

    $('#product-form-link').click(function(e) {
		$("#product-form").delay(100).fadeIn(100);
 		$("#vendor-form").fadeOut(100);
		$('#vendor-form-link').removeClass('active');
        $("#bill-form").fadeOut(100);
		$('#bill-form-link').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
	});
    $('#next1').click(function(e) {
		$("#vendor-form").delay(100).fadeIn(100);
 		$("#product-form").fadeOut(100);
		$('#product-form-link').removeClass('active');
        $("#bill-form").fadeOut(100);
		$('#bill-form-link').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
	});
	$('#vendor-form-link').click(function(e) {
		$("#vendor-form").delay(100).fadeIn(100);
 		$("#product-form").fadeOut(100);
		$('#product-form-link').removeClass('active');
        $("#bill-form").fadeOut(100);
		$('#bill-form-link').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
	});
    $('#next2').click(function(e) {
		$("#bill-form").delay(100).fadeIn(100);
 		$("#product-form").fadeOut(100);
		$('#product-form-link').removeClass('active');
        $("#vendor-form").fadeOut(100);
		$('#vendor-form-link').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
	});
    $('#bill-form-link').click(function(e) {
		$("#bill-form").delay(100).fadeIn(100);
 		$("#product-form").fadeOut(100);
		$('#product-form-link').removeClass('active');
        $("#vendor-form").fadeOut(100);
		$('#vendor-form-link').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
	});
});
	</script>
</html>






	