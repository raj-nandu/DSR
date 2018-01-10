<?php 
	session_start();
	if($_SESSION['auth'] && $_SESSION['role'] == 'admin'){
		if ($_POST) {
			include("connection.php");
			$name = $_POST['name_of_equip'];
			$type = $_POST['type'];
			$bill_no = $_POST['bill_no'];
			$query1 = "SELECT amount,lab_id from equipment, equip_lab WHERE name_of_equip = '$name' AND type = '$type' AND bill_no = '$bill_no' AND equipment.eqp_id = equip_lab.eqp_id LIMIT 1";
			$res1 = mysqli_query($link, $query1);
			if(mysqli_num_rows($res1) == 1){
				while($row=mysqli_fetch_assoc($res1)){
					$amount = $row['amount'];
					$lab_id = $row['lab_id'];
				}
				$query2 = "UPDATE lab SET lab_cost = lab_cost - $amount, lab_investment = lab_investment - $amount WHERE lab_id = $lab_id";
				$query3 = "DELETE FROM supplies WHERE euip_id IN (SELECT eqp_id FROM equipment WHERE name_of_equip = '$name' AND type = '$type' AND bill_no = '$bill_no')";
				$query4 = "DELETE FROM equip_lab WHERE eqp_id IN (SELECT eqp_id FROM equipment WHERE name_of_equip = '$name' AND type = '$type' AND bill_no = '$bill_no')";
				$query5 = "DELETE FROM equipment WHERE name_of_equip = '$name' AND type = '$type' AND bill_no = '$bill_no'";
				$res2 = mysqli_query($link, $query2);
				$res3 = mysqli_query($link, $query3);
				$res4 = mysqli_query($link, $query4);
				$res5 = mysqli_query($link, $query5);
				if($res2 && $res3 && $res4 && $res5){
					$_SESSION['res'] = "Data Entry Rolled Back";
					header("location: undo.php");
				}
				else{
					$_SESSION['res'] = "Data Entry Undo Unsuccessful";
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