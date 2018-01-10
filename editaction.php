<?php 
	session_start();
	if($_SESSION['auth'] && $_SESSION['role'] == 'admin'){
		if ($_POST['sbmt']) {
				include 'connection.php';
                if(isset($_POST['name_of_equip']) && isset($_POST['central_dsr_no']) &&isset($_POST['cdr']) && isset($_POST['warranty']) && isset($_POST['type']) && isset($_POST['rate']) && isset($_POST['description']) && isset($_POST['name_of_vendor']) && isset($_POST['contact_no']) && isset($_POST['address']) && isset($_POST['purchase_date']) && isset($_POST['supply_date']) && isset($_POST['purchase_order_no']) && isset($_POST['bill_no']) && isset($_SESSION['prevRate'])){
                    $vendor_id = $_SESSION['vendor_id']; 
                    $eqp_id = $_SESSION['eqp_id'];
                    $cdn = $_SESSION['cdn'];
                    $name = $_POST['name_of_equip'];
                    $type = $_POST['type'];
                    $warranty = $_POST['warranty'];
                    $rate = $_POST['rate'];
                    // $amount = $_POST['amount'];
                    $amount = 1; //temporary
                    $cdr = $_POST['cdr'];
                    $description = $_POST['description'];
                    $name_of_vendor = $_POST['name_of_vendor'];
                    $contact_no = $_POST['contact_no'];
                    $address = $_POST['address'];
                    $purchase_date = $_POST['purchase_date'];
                    $supply_date = $_POST['supply_date'];
                    $purchase_order_no = $_POST['purchase_order_no'];
                    $bill_no = $_POST['bill_no'];
                    $prevRate = $_SESSION['prevRate'];
                    $diffRate = $rate - $prevRate;
                    $lab_id = $_SESSION['lab_id'];
                    $big =0;
                             
                    if (!preg_match("/^[a-zA-Z0-9 \s]*$/",$name)) {
			             $nameErr = "Only letters and white space are allowed in name"; 
			             $big++;
			        }
                    
                   
                    
                    if (!preg_match("/^[a-zA-Z0-9 \s]*$/",$type)) {
			             $nameErr = "Only letters and white space are allowed in type of equipment"; 
			             $big++;
			        }
                    
                    if (!preg_match("/^[0-9.]*$/",$warranty)) {
			             $nameErr = "Only numbers and decimal point allowed in warranty"; 
			             $big++;
			        }
                    
                    if (!preg_match("/^[0-9]*$/",$rate)) {
			             $nameErr = "Only numbers and decimal point allowed in rate"; 
			             $big++;
			        }
                    
                    if (!preg_match("/^[0-9]*$/",$amount)) {
			             $nameErr = "Only numbers and decimal point allowed in amount"; 
			             $big++;
			        }
                    if (!preg_match("/^[a-zA-Z0-9- \/ \s]*$/",$cdr)) {
                         $nameErr .= "<br>Only letters, slashes and numbers space are allowed in central_dsr_no"; 
                         $big++;
                    }
                    if (!preg_match("/^[ 0-9A-Za-z. \s]+$/",$description)) {
			             $nameErr = "Only letters,numbers and white space are allowed in description"; 
			             $big++;
			        }
                    if (!preg_match("/^[0-9a-zA-Z. \s]*$/",$name_of_vendor)) {
			             $nameErr = "Only letters and white space are allowed in name of vendor"; 
			             $big++;
			        }
                    
                    if (!preg_match("/^[0-9]*$/",$contact_no)) {
			             $nameErr = "Only numbers allowed in contact no"; 
			             $big++;
			        }
                    
                    if (!preg_match("/^[ 0-9A-Za-z \\-.,\s]+$/",$address)) {
			             $nameErr = "Only letters and white space are allowed in address"; 
			             $big++;
			        }
                    
                   
                    if (!preg_match("/^[0-9A-Za-z-]*$/",$purchase_order_no)) {
			             $nameErr = "Invalid purchase order number"; 
			             $big++;
			        }

                    if (!preg_match("/^[a-zA-Z0-9-]*$/",$bill_no)) {
			             $nameErr = "Invalid bill no"; 
			             $big++;
			        }

                    
                    if($big==0){
                        $query1 = "UPDATE equipment set name_of_equip = '$name', type = '$type', warranty = $warranty, rate = $rate, amount = amount + $diffRate, description = '$description' WHERE central_dsr_no = '$cdn'";
                        $result1 = mysqli_query($link, $query1);



                        $query0 = "SELECT vendor_id FROM vendor WHERE name_of_vendor ='$name_of_vendor' AND contact_no = $contact_no AND address = '$address' ";
                        $res0 = mysqli_query($link,$query0);
                        if(mysqli_num_rows($res0) == 0) { 
                            $query2 = "INSERT INTO vendor values ('null', '$name_of_vendor', '$contact_no','$address')";
                            $result2 = mysqli_query($link, $query2);
                            $ven_id = mysqli_insert_id($link);
                            $query3 = "UPDATE supplies SET purchase_date = '$purchase_date', supply_date = '$supply_date', purchase_order_no = '$purchase_order_no', bill_no = '$bill_no', vendor_id = $ven_id WHERE  euip_id = $eqp_id";
                            $result3 = mysqli_query($link, $query3);
                        }
                        else {
                            if($res0->num_rows > 0) {
                                while($row = $res0->fetch_assoc())
                                    $ven_id = $row['vendor_id'];
                            }
                            $query2 = "UPDATE vendor SET name_of_vendor = '$name_of_vendor', contact_no = '$contact_no',address = '$address' where vendor_id = $ven_id";
                            $result2 = mysqli_query($link, $query2);
                            $query3 = "UPDATE supplies SET purchase_date = '$purchase_date', supply_date = '$supply_date', purchase_order_no = '$purchase_order_no', bill_no = '$bill_no', vendor_id = $ven_id  WHERE euip_id = $eqp_id";
                            $result3 = mysqli_query($link, $query3);

                        }
                        $queri = "UPDATE lab SET lab_cost = lab_cost + $diffRate, lab_investment = lab_investment + $diffRate WHERE lab_id = $lab_id";
                        $result = mysqli_query($link, $queri);

                        $output =  "Edited Succesfully";
                        header('location: admin.php');
                        
                    }
                    else {
                        $_SESSION['err'] = $nameErr;
                        header('location: admin.php');
                    }
                    
                }
                else{
                    $output = 'All fields should be entered';
                    header('location: admin.php');
                }
		}
		
	}
	else
	{
		header('location: login.php');
	}

?>