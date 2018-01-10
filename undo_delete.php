<?php 
	session_start();
	if($_SESSION['auth'] && $_SESSION['role'] == 'admin'){
		if ($_POST) {
			include("connection.php");
			$dsr = $_POST['dsr'];
			$query1 = "SELECT rate,lab_id from equipment, equip_lab WHERE equipment.eqp_id = equip_lab.eqp_id AND central_dsr_no LIKE '$dsr' AND del_flag = 0";
			$res1 = mysqli_query($link, $query1);
			if(mysqli_num_rows($res1) == 1){
				while($row=mysqli_fetch_assoc($res1)){
					$amount = $row['rate'];
					$lab_id = $row['lab_id'];
				}
				$query2 = "UPDATE lab SET lab_cost = lab_cost + $amount WHERE lab_id = $lab_id";
				$query3 = "UPDATE equipment SET del_flag = 1 WHERE central_dsr_no = '$dsr'";
				$res2 = mysqli_query($link, $query2);
				$res3 = mysqli_query($link, $query3);
				
				if($res2 && $res3){
					$_SESSION['res'] = "Delete Rolled Back";
					header("location: undo.php");
				}
				else{
					$_SESSION['res'] = "Undo Delete Unsuccessful";
					header("location: undo.php");
				}
			}
			else{
				$_SESSION['un_error'] = "No such entry";
				header("location: undo.php");
			}
		}
	}
	else{
		header("location: login.php");
	}
?>