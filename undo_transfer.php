<?php 
	session_start();
	if($_SESSION['auth'] && $_SESSION['role'] == 'admin'){
		if ($_POST) {
			include("connection.php");
			$dsr = $_POST['dsr'].'(t)';
			$olddsr = $dsr;
			$query1 = "SELECT eqp_id,rate,quantity,from_lab_id,to_lab_id,from_lab_name,to_lab_name FROM equipment, transfer WHERE equipment.eqp_id = transfer.equip_id AND central_dsr_no LIKE '$dsr'";
			$res1 = mysqli_query($link, $query1);
			if(mysqli_num_rows($res1) == 1){
				while($row=mysqli_fetch_assoc($res1)){
					$amount = $row['rate'];
					$from_lab_id = $row['from_lab_id'];
					$to_lab_id = $row['to_lab_id'];
					$eqp_id = $row['eqp_id'];
					$from_lab_name = $row['from_lab_name'];
					$to_lab_name = $row['to_lab_name'];
					$quantity = $row['quantity'];
				}

				$olddsr = chop($olddsr,'(t)');
                $olddsr = strrev($olddsr);
                $to_remove = "KJSCE/COMP/".$to_lab_name."/";
                $to_remove = strrev($to_remove);

                $olddsr = chop($olddsr,$to_remove);
                $olddsr = strrev($olddsr);
                if($quantity == 1){
                    $olddsr = "KJSCE/COMP/".$from_lab_name."/".$olddsr;
                } else {
                    $olddsr = "KJSCE/COMP/".$from_lab_name."/".$olddsr.")";
                }


				$query2 = "UPDATE lab SET lab_cost = lab_cost + $amount WHERE lab_id = $from_lab_id";
				$query3 = "UPDATE lab SET lab_cost = lab_cost - $amount WHERE lab_id = $to_lab_id";
				$query4 = "UPDATE equipment SET central_dsr_no = '$olddsr' WHERE central_dsr_no = '$dsr'";
				$query5 = "DELETE FROM transfer WHERE equip_id = $eqp_id";
				$query6 = "UPDATE equip_lab SET lab_id = $from_lab_id WHERE eqp_id = $eqp_id";
				$res2 = mysqli_query($link, $query2);
				$res3 = mysqli_query($link, $query3);
				$res4 = mysqli_query($link, $query4);
				$res5 = mysqli_query($link, $query5);
				$res6 = mysqli_query($link, $query6);

				if($res2 && $res3 && $res4 && $res5 && $res6){
					$_SESSION['res'] = "Transfer Rolled Back";
					header("location: undo.php");
				}
				else{
					$_SESSION['res'] = "Undo Transfer Unsuccessful";
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