<?php 
	session_start();
	
	if($_SESSION['auth'] && ($_SESSION['role'] == 'lab' || $_SESSION['role'] == 'incharge')){
		if($_POST){
			$count = 0;
				if(isset($_POST['select_all'])){
					$count+=1;
				}
				if(isset($_POST['name_of_equip'])){
					$count+=1;
				}
				if(isset($_POST['quantity'])){
					$count+=1;
				}
				if(isset($_POST['type'])){
					$count+=1;
				}
				if(isset($_POST['warranty'])){
					$count+=1;
				}
				if(isset($_POST['rate'])){
					$count+=1;
				}
				if(isset($_POST['amount'])){
					$count+=1;
				}
				if(isset($_POST['central_dsr_no'])){
					$count+=1;
				}
				if(isset($_POST['description'])){
					$count+=1;
				}
				if(isset($_POST['purchase_date'])){
					$count+=1;
				}
				if(isset($_POST['supply_date'])){
					$count+=1;
				}
				if(isset($_POST['bill_no'])){
					$count+=1;
				}
				if(isset($_POST['purchase_order_no'])){
					$count+=1;
				}
				if(isset($_POST['name_of_vendor'])){
					$count+=1;
				}
				if(isset($_POST['contact_no'])){
					$count+=1;
				}
				if(isset($_POST['address'])){
					$count+=1;
				}
				if((empty($_POST['from_date']) || empty($_POST['to_date'])) || !(strtotime($_POST['from_date']) < strtotime($_POST['to_date']))){
					$_SESSION['error'] = "Please Select atleast one Checkbox and from date should be greater before to date";
					header('location: report.php');
				}
				if($count==0){
					$_SESSION['error'] = "Please Select atleast one Checkbox";
					header('location: report_lab.php');
				}

			include 'connection.php';
			$lab_id = $_SESSION['lab_id'];
			$typo = $_POST['typo'];
			$from_date = $_POST['from_date'];
			$to_date = $_POST['to_date'];
			if(!isset($_POST['select_all'])){

				$query = "SELECT ";
				if(isset($_POST['name_of_equip'])){
					$query = $query." name_of_equip,";
				}
				if(isset($_POST['quantity']) && $typo != 'summary'){
					$query = $query." quantity,";
				}
				if(isset($_POST['type'])){
					$query = $query." type,";
				}
				if(isset($_POST['warranty'])){
					$query = $query." warranty,";
				}
				if(isset($_POST['rate'])){
					$query = $query." rate,";
				}
				if(isset($_POST['amount']) && $typo == 'summary'){
					$query = $query." amount,";
				}
				if(isset($_POST['central_dsr_no'])){
					$query = $query." central_dsr_no, cdr,";
				}
				if(isset($_POST['description'])){
					$query = $query." description,";
				}
				if(isset($_POST['purchase_date'])){
					$query = $query." purchase_date,";
				}
				if(isset($_POST['supply_date'])){
					$query = $query." supply_date,";
				}
				if(isset($_POST['bill_no'])){
					$query = $query." equipment.bill_no,";
				}
				if(isset($_POST['purchase_order_no'])){
					$query = $query." purchase_order_no,";
				}
				if(isset($_POST['name_of_vendor'])){
					$query = $query." name_of_vendor,";
				}
				if(isset($_POST['contact_no'])){
					$query = $query." contact_no,";
				}
				if(isset($_POST['address'])){
					$query = $query." address,";
				}
				$query = chop($query,',');

				if($typo == 'regular'){
					$query = $query.",lab_full_name FROM equip_lab,equipment,supplies,vendor,lab WHERE equip_lab.lab_id = $lab_id AND equip_lab.eqp_id = equipment.eqp_id AND equipment.eqp_id = supplies.euip_id AND supplies.vendor_id = vendor.vendor_id AND equipment.del_flag = 1 AND purchase_date BETWEEN '$from_date' AND '$to_date'";
				} else if($typo == 'write_off'){
					$query = $query.",lab_full_name FROM equip_lab,equipment,supplies,vendor,lab WHERE equip_lab.lab_id = $lab_id AND equip_lab.eqp_id = equipment.eqp_id AND equipment.eqp_id = supplies.euip_id AND supplies.vendor_id = vendor.vendor_id AND equipment.del_flag = 0 AND purchase_date BETWEEN '$from_date' AND '$to_date'";
				} 
				else if($typo == 'summary'){
						$query = $query.",lab_full_name, count(name_of_equip) as quantity FROM vendor, supplies, equipment, lab, equip_lab where equip_lab.lab_id = $lab_id AND equip_lab.eqp_id = equipment.eqp_id AND vendor.vendor_id = supplies.vendor_id AND equipment.eqp_id = supplies.euip_id AND equipment.del_flag = 1 AND equip_lab.lab_id = lab.lab_id AND lab.lab_id = $lab_id AND purchase_date BETWEEN '$from_date' AND '$to_date' GROUP BY name_of_equip, supplies.bill_no";
					}

				else{
					$query = $query.",lab_full_name,from_lab_name,to_lab_name,transfer_date FROM transfer,equipment,supplies,vendor,lab WHERE from_lab_id = $lab_id AND equip_id = eqp_id AND eqp_id = euip_id AND vendor.vendor_id = supplies.vendor_id AND del_flag = 1 AND purchase_date BETWEEN '$from_date' AND '$to_date'";
				}

				$result = mysqli_query($link,$query);
				$output = '<table border="1px solid #990000"><thead><tr>';
				if(isset($_POST['name_of_equip'])){
					
					$output .= '<th>Name of equipment</th>';
				}
				if(isset($_POST['quantity'])){
					$output .= '<th>Quantity</th>';
				}
				if(isset($_POST['type'])){
					$output .= '<th>Type Of Equipment</th>';
				}
				if(isset($_POST['warranty'])){
					$output .= '<th>Warranty</th>';
				}
				if(isset($_POST['rate'])){
					$output .= '<th>Rate</th>';
				}
				if(isset($_POST['amount'])){
					$output .= '<th>Amount</th>';
				}
				if(isset($_POST['central_dsr_no'])){
					$output .= '<th>Departmental DSR Number</th>';
					$output .= '<th>Central DSR Number</th>';	
				}
				if(isset($_POST['description'])){
					$output .= '<th>Description</th>';
				}
				if(isset($_POST['purchase_date'])){
					$output .= '<th>Date of Purchase</th>';
				}
				if(isset($_POST['supply_date'])){
					$output .= '<th>Supply Date</th>';
				}
				if(isset($_POST['bill_no'])){
					$output .= '<th>Bill Number</th>';
				}
				if(isset($_POST['purchase_order_no'])){
					$output .= '<th>Purchase Order Number</th>';
				}
				if(isset($_POST['name_of_vendor'])){
					$output .= '<th>Name of Vendor</th>';
				}
				if(isset($_POST['contact_no'])){
					$output .= '<th>Vendor Contact Number</th>';
				}
				if(isset($_POST['address'])){
					$output .= '<th>Address of Vendor</th>';
				}
				$output .= '<th>Lab Full Name</th>';
				if($typo == 'transfer'){
					$output .= '<th>From Lab</th>';
					$output .= '<th>To Lab</th>';
					$output .= '<th>Transfer Date</th>';
				}
				$output .= '</thead></tr>';
				while($row = $result->fetch_assoc()){
					if(isset($_POST['name_of_equip'])){
						
						$output .= '<tr><td>'.$row["name_of_equip"].'</td>';
					}
					if(isset($_POST['quantity'])){
						$output .= '<td>'.$row["quantity"].'</td>';
					}
					if(isset($_POST['type'])){
						$output .= '<td>'.$row["type"].'</td>';
					}
					if(isset($_POST['warranty'])){
						$output .= '<td>'.$row["warranty"].'</td>';
					}
					if(isset($_POST['rate'])){
						$output .= '<td>'.$row["rate"].'</td>';
					}
					if(isset($_POST['amount'])){
						if($typo == 'regular' || $typo == 'write_off' || $typo == 'transfer'){
							$output .= '<td>'.$row["rate"].'</td>';
						}
						else{
							$output .= '<td>'.$row["rate"]*$row['quantity'].'</td>';
						}
					}
					if(isset($_POST['central_dsr_no'])){
						$output .= '<td>'.$row["central_dsr_no"].'</td>';
						$output .= '<td>'.$row["cdr"].'</td>';
					}
					if(isset($_POST['description'])){
						$output .= '<td>'.$row["description"].'</td>';
					}
					if(isset($_POST['purchase_date'])){
						$output .= '<td>'.$row["purchase_date"].'</td>';
					}
					if(isset($_POST['supply_date'])){
						$output .= '<td>'.$row["supply_date"].'</td>';
					}
					if(isset($_POST['bill_no'])){
						$output .= '<td>'.$row["bill_no"].'</td>';
					}
					if(isset($_POST['purchase_order_no'])){
						$output .= '<td>'.$row["purchase_order_no"].'</td>';
					}
					if(isset($_POST['name_of_vendor'])){
						$output .= '<td>'.$row["name_of_vendor"].'</td>';
					}
					if(isset($_POST['contact_no'])){
						$output .= '<td>'.$row["contact_no"].'</td>';
					}
					if(isset($_POST['address'])){
						$output .= '<td>'.$row["address"].'</td>';
					}
					$output .= '<td>'.$row["lab_full_name"].'</td>';
					if($typo == 'transfer'){
						$output .= '<td>'.$row["from_lab_name"].'</td>';
						$output .= '<td>'.$row["to_lab_name"].'</td>';
						$output .= '<td>'.$row["transfer_date"].'</td>';
					}

				}
				$output .= '</table>';
			}
			else{
	
				if($typo == 'regular'){
					$query = "SELECT name_of_equip,quantity,type,lab_full_name,warranty,rate,amount,central_dsr_no,cdr,description,purchase_date,supply_date,equipment.bill_no,purchase_order_no,name_of_vendor,contact_no,address FROM equip_lab,equipment,supplies,vendor,lab WHERE equip_lab.lab_id = $lab_id AND equip_lab.eqp_id = equipment.eqp_id AND equipment.eqp_id = supplies.euip_id AND supplies.vendor_id = vendor.vendor_id AND equipment.del_flag = 1 AND purchase_date BETWEEN '$from_date' AND '$to_date'";
				} else if($typo == 'write_off'){
					$query = "SELECT name_of_equip,quantity,type,lab_full_name,warranty,rate,amount,central_dsr_no,cdr,description,purchase_date,supply_date,equipment.bill_no,purchase_order_no,name_of_vendor,contact_no,address FROM equip_lab,equipment,supplies,vendor,lab WHERE equip_lab.lab_id = $lab_id AND equip_lab.eqp_id = equipment.eqp_id AND equipment.eqp_id = supplies.euip_id AND supplies.vendor_id = vendor.vendor_id AND equipment.del_flag = 0 AND purchase_date BETWEEN '$from_date' AND '$to_date'";
				} 
				else if($typo = 'summary'){
						$query = "select name_of_equip,type,warranty,rate,amount,central_dsr_no,cdr,description,equipment.bill_no,supplies.purchase_date,supplies.supply_date,supplies.bill_no,name_of_vendor,contact_no,address,lab_full_name, count(name_of_equip) as quantity, purchase_order_no FROM vendor, supplies, equipment, lab, equip_lab where equip_lab.lab_id = $lab_id AND equip_lab.eqp_id = equipment.eqp_id AND vendor.vendor_id = supplies.vendor_id AND equipment.eqp_id = supplies.euip_id AND equipment.del_flag = 1 AND equip_lab.lab_id = lab.lab_id AND lab.lab_id = $lab_id AND purchase_date BETWEEN '$from_date' AND '$to_date' GROUP BY name_of_equip, supplies.bill_no";
					}
				else{
					$query = "SELECT name_of_equip,quantity,type,lab_full_name,warranty,rate,amount,central_dsr_no,cdr,description,purchase_date,supply_date,equipment.bill_no,purchase_order_no,name_of_vendor,contact_no,address,from_lab_name,to_lab_name,transfer_date FROM transfer,equipment,supplies,vendor,lab WHERE from_lab_id = $lab_id AND equip_id = eqp_id AND eqp_id = euip_id AND vendor.vendor_id = supplies.vendor_id AND del_flag = 1 AND purchase_date BETWEEN '$from_date' AND '$to_date'";
				}

				
				$result = mysqli_query($link,$query);
				$output = '
					<table border="1px solid #990000"><thead><tr>
								<th>Name of equipment</th>
								<th>Quantity</th>
								<th>Type Of Equipment</th>
								<th>Warranty</th>
								<th>Rate</th>
								<th>Amount</th>
								<th>Departmental DSR Number</th>
								<th>Central DSR Number</th>
								<th>Description</th>
								<th>Date Of Purchase</th>
								<th>Supply Date</th>
								<th>Bill Number</th>
								<th>Purchase Order Number</th>
								<th>Name Of Vendor</th>
								<th>Vendor Contact Number</th>
								<th>Address Of vendor</th>
								<th>Lab Full Name</th>';
							if($typo == 'transfer'){
								$output .= '<th>From Lab</th>
								<th>To Lab</th>
								<th>Transfer Date</th></tr></thead>';
							}
				while($row = $result->fetch_assoc()) {
					$output .= '<tr><td>'.$row["name_of_equip"].'</td>';
					$output .= '<td>'.$row["quantity"].'</td>';
					$output .= '<td>'.$row["type"].'</td>';
					$output .= '<td>'.$row["warranty"].'</td>';
					$output .= '<td>'.$row["rate"].'</td>';
					if($typo == 'regular' || $typo == 'write_off' || $typo == 'transfer'){
						$output .= '<td>'.$row["rate"].'</td>';
					}
					else{
						$output .= '<td>'.$row["rate"]*$row['quantity'].'</td>';
					}
					$output .= '<td>'.$row["central_dsr_no"].'</td>';
					$output .= '<td>'.$row["cdr"].'</td>';
					$output .= '<td>'.$row["description"].'</td>';
					$output .= '<td>'.$row["purchase_date"].'</td>';
					$output .= '<td>'.$row["supply_date"].'</td>';
					$output .= '<td>'.$row["bill_no"].'</td>';
					$output .= '<td>'.$row["purchase_order_no"].'</td>';
					$output .= '<td>'.$row["name_of_vendor"].'</td>';
					$output .= '<td>'.$row["contact_no"].'</td>';
					$output .= '<td>'.$row["address"].'</td>';
					$output .= '<td>'.$row["lab_full_name"].'</td>';
					if($typo == 'transfer'){
						$output .= '<td>'.$row["from_lab_name"].'</td>';
						$output .= '<td>'.$row["to_lab_name"].'</td>';
						$output .= '<td>'.$row["transfer_date"].'</td>';
					}

					$output .= '</tr>';
				}
				$output .= '</table>'; 

			}
			

			
			$_SESSION['output'] = $output;
		}
	}
	else
	{
		header('location: login.php');
	}
	
?>
<html>
<head>
	<title>Generate Report</title>
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
			        	<li ><a href="report_lab.php" class = "active-page">Generate Report</a></li>
			        	<li ><a href="lab_details_lab.php">Lab Details</a></li>
			        	<li><a href="change_password.php">Update User Details</a></li>
			      	</ul>
			      	<ul class="nav navbar-nav navbar-right">
			        	<li><a href="logout.php">Log Out</a></li>
			    	</ul>
		    	</div>
			</div>
		</nav>
	</div>
	<div class="container" >
		<div class="row">
			<div class="col-md-12" style="overflow: scroll; border: 2px solid white;">
				<?php echo $output; ?>		
			</div>
		</div>
	</div>
	<br>
	<br>
    <div class="container">
    	<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="panel panel-login">
					<div class="panel-heading">

						<form method="post" action='report2.php'>
						     <div class="form-group">    
						        <div class="row">
						            <div class="col-sm-6 ">
						                <input type="submit" name="submit" id="register-submit"  class="form-control btn btn-register" value="Download">
						            </div>


						            <div class="col-sm-6 ">
						                <input type="submit" name="home" id="register-submit" class="form-control btn btn-register" value="home">
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
