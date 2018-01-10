<?php
session_start();


	if($_POST){
       
      	include 'connection.php';
      	$user = $_POST['username'];
      	$email = $_POST['email'];
        $big = 0;
		if (empty($_POST["username"])) {
			$big++;
			$nameErr = "Userame is required";
		} 
		else {
			if (!preg_match("/^[a-zA-Z0-9._]*$/",$user)) {				// [a-zA-Z0-9@!# "add more special characters in here"]
			$nameErr = "Only letters,numbers and dots are allowed in username"; 
			$big++;
			}
		}
        if (empty($_POST["email"])) {
			$big++;
			$nameErr = "Email is required";
		} 
		else {
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$error .= "Invalid email format.<br>";
				$big++;
			}
		}
        if($big==0){
      	    $query = "SELECT username, email FROM staff where username='$user' and email='$email'";
            if($result = mysqli_query($link, $query)){

                if(mysqli_num_rows($result)==1){
                    $random = rand(1236578,9876543);
                    $randomfinal = password_hash($random, PASSWORD_DEFAULT);
                    $query2 = "UPDATE staff set password = '$randomfinal' WHERE username = '$user'";
                    $res2 = mysqli_query($link,$query2);
                    $subject = "New Password For DSR KJSCE";
                    $message = "Your new password is ".$random." You can change the password after logging in."; 
                    $from = "From: datacentre.engg@somaiya.edu";
                    if (mail($email, $subject, $message, $from)) {
					   header('location: login.php');
					} else {
					   echo "ERROR";
					}
                }
            }
                
        }
	}

?>



<!DOCTYPE html>
<html>
<head>
	<title>LogIn</title>
	<link rel="stylesheet" type="text/css" href="assets/css/lib/bootstrap.css">
	<style type="text/css">
		.header{
			margin-top: 0px;
			margin-bottom: 150px;
			text-align: center;
			width: 100%;
			height:initial;
			font-size: 40px;
            background-color: rgba(01,01,01,0.25);
            padding-top: 0px;
            padding-bottom: 0px;
            padding-left: 20px;
		}
		body{
			background-image: url("image4.jpg");
			background-repeat: no-repeat;
			background-size: cover;
			color: white;
			font-size: 30px;
			font-family: 'Open Sans', sans-serif;
		}
        body{
            padding-top: 0px;
        }

		.loginForm{
			border: 5px solid white;
			border-radius: 30px;
			width: 40%;
			height: 50%;
			padding: 30px;
			font-size: 25px;
		}
		.form-control{
			height: 40px;
			font-size: 20px;
		}
		button{
			margin-top: 20px;
			margin-left: 190px;

		}
        .panel-login {
            border-color: #68100d;
            -webkit-box-shadow: 0px 2px 3px 0px rgba(0,0,0,0.2);
            -moz-box-shadow: 0px 2px 3px 0px rgba(0,0,0,0.2);
            box-shadow: 0px 2px 3px 0px rgba(0,0,0,0.2);
        }
        .panel-login>.panel-heading {
            color: #00415d;
            background-color: #fff;
            border-color: #fff;
            text-align:center;
        }
        .panel-login>.panel-heading a{
            text-decoration: none;
            color: #666;
            font-weight: bold;
            font-size: 15px;
            -webkit-transition: all 0.1s linear;
            -moz-transition: all 0.1s linear;
            transition: all 0.1s linear;
        }
        .panel-login>.panel-heading a.active{
            color: #911612;
            font-size: 18px;
        }
        .panel-login>.panel-heading hr{
            margin-top: 10px;
            margin-bottom: 0px;
            clear: both;
            border: 0;
            height: 1px;
            background-image: -webkit-linear-gradient(left,rgba(0, 0, 0, 0),rgba(0, 0, 0, 0.15),rgba(0, 0, 0, 0));
            background-image: -moz-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
            background-image: -ms-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
            background-image: -o-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
        }
        .panel-login input[type="text"],.panel-login input[type="email"],.panel-login input[type="password"] {
            height: 45px;
            border: 1px solid #911612;
            font-size: 16px;
            -webkit-transition: all 0.1s linear;
            -moz-transition: all 0.1s linear;
            transition: all 0.1s linear;
        }
        .panel-login input:hover,
        .panel-login input:focus {
            outline:none;
            -webkit-box-shadow: none;
            -moz-box-shadow: none;
            box-shadow: none;
            border-color: #68100d;
        }
        .btn-login {
            background-color: #911612;
            outline: none;
            color: #fff;
            font-size: 14px;
            height: auto;
            font-weight: normal;
            padding: 14px 0;
            text-transform: uppercase;
            border-color: #68100d;
            border-radius: 10px;
        }
        .btn-login:hover,
        .btn-login:focus {
            color: #fff;
            background-color: #911612;
            border-color: #68100d;
        }
        .forgot-password {
            text-decoration: underline;
            color: #888;
        }
        .forgot-password:hover,
        .forgot-password:focus {
            text-decoration: underline;
            color: #666;
        }
        label{
            color: #68100d;
        }
        .row{
            font-size: 15px;
        }

        .header{
        	background-color: white;
        	color: #911612;
        }
	</style>

	<link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300" rel="stylesheet">
</head>
<body>


		<h1 class = "header"><img src = "images/logo.png" style="width:40px;height:40px;"><span style="display:inline-block; width: 40px;"></span>Computer Department, K.J. Somaiya College Of Engineering</h1>

	<div class="container">
    	<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="panel panel-login">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-12">
								<a href="#" class="active" id="login-form-link">Forgot Password</a>
							</div>
						</div>
						<hr>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<form id="login-form" action="" method="post" role="form" style="display: block;">
									<div class="form-group">
										<input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Username" value="">
									</div>
									<div class="form-group">
										<input type="email" name="email" id="password" tabindex="2" class="form-control" placeholder="Email-ID">
									</div>
									
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
												<input type="submit" name="login-submit" id="login-submit" onclick="return checkFields();" tabindex="4" class="form-control btn btn-login" value="Submit">
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-12">
												<div class="text-center">
													<a tabindex="5" class="forgot-password" href="login.php">Back to Login Page?</a>
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

	
	<script type="text/javascript" src = "assets/javascript/lib/jQuery.js"></script>
	<script type="text/javascript" src = "assets/javascript/lib/bootstrap.js"></script>
    <script type="text/javascript">
	function checkFields()
	{
		var isvalid = true;
		var text ="";
		var z=0;
		var x = document.forms["login-form"]["username"].value;
		if(x.length==0){
			z++;
		}
		var x1 = document.forms["login-form"]["email"].value;
		if(x1.length==0){
			z++;
		}    			
	   	if(z!=0){
    		alert('Please fill both username and email');
			isvalid = false;
    	}
		return isvalid;
	}	
	</script>
    <script>
        $(function() {

    $('#login-form-link').click(function(e) {
		$("#login-form").delay(100).fadeIn(100);
 		$("#register-form").fadeOut(100);
		$('#register-form-link').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
	});
	

});
    </script>
    
</body>
</html>