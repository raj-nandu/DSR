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
			      		<li ><a href="data_entry.php">Data Entry</a></li>
			        	<li ><a href="admin.php" class = "active-page">Edit Data</a></li>
			        	<li ><a href="delete.php">Write Off</a></li>
			        	<li class = "active"><a href="report.php">Generate Report</a></li>
			        	<li ><a href="transfer.php">Transfer</a></li>
			        	<li ><a href="newuser.php">Add new user</a></li>
			        	<li ><a href="lab_details.php">Lab Details</a></li>
			        	<li ><a href="undo.php">Roll Back Operations</a></li>
			        	<li ><a href="admin_labid.php">Change Lab</a></li>
			        	<li ><a href="adminchange.php">Change Admin</a></li>
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
			<div class="col-md-6 col-md-offset-3">
				<div class="panel panel-login">
					<div class="panel-heading">
<?php 
	session_start();
	if($_SESSION['auth'] && $_SESSION['role'] == 'admin'){
		
		include 'connection.php';
		$lab_id = $_SESSION['lab_id'];
		$query = $_SESSION['transfer_query']." FROM transfer, lab, equipment WHERE to_lab_id = lab_id AND equip_id = eqp_id AND from_lab_id = '$lab_id'";
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
				$output .= '<td>'.$row["amount"].'</td>';
			}
			if(isset($_POST['central_dsr_no'])){
				$output .= '<td>'.$row["central_dsr_no"].'</td>';
				$output .= '<td>'.$row["cdr"].'</td>';
			}
			if(isset($_POST['cdr'])){
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

		}
		$output .= '</table>'; 
		$_SESSION['output'] = $output;

		
	}
	else
	{
		header('location: login.php');
	}
	
?>
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





<?php 
	
 ?>