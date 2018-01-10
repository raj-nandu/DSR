<?php 
	session_start();
	if($_SESSION['auth']){
			include 'connection.php';

			$name_of_vendor = $_GET['name'];
			$sql  = "SELECT name_of_vendor FROM vendor WHERE name_of_vendor like '%{$name_of_vendor}%'";
 
			$res = mysqli_query($link,$sql);
 
			while( $row = $res->fetch_object() )
				echo "<option value='".$row->name_of_vendor."'>";
		}
		else
	{
		header('location: login.php');
	}
 
?>
</option>

