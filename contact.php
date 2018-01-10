<?php 
	session_start();
	if($_SESSION['auth']){
			include 'connection.php';

			$name_of_vendor = $_GET['con'];
			$sql  = "SELECT contact_no FROM vendor WHERE name_of_vendor like '%{$name_of_vendor}%'";
 
			$res = mysqli_query($link,$sql);
 
			while( $row = $res->fetch_assoc() )
				echo $row['contact_no'];
		}
		else
	{
		header('location: login.php');
	}
 
?>