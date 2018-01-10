<?php
	session_start();
	if($_SESSION['auth']){
		if($_POST['submit']){
			echo $_SESSION['output'];
			$filename = "reports.xls";
			header("Content-Disposition: attachment; filename=\"$filename\"");
			header("Content-Type: application/xls");
		}
		if(isset($_POST['home'])){
			if($_SESSION['role'] == 'lab'){
				header('location:lab_details_lab.php');		
			}
			else{
				header('location: lab_details.php');
			}
			
		
		}
	}
	else{
		header('location: login.php');
	}
	
?>