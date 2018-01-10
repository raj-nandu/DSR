<?php 
	session_start();
	if($_SESSION['auth'] && $_SESSION['role'] == 'admin'){
		if($_POST){
			include 'connection.php';
			$count = 1;
			$_SESSION['type'] = $_POST['type'];
		} 
		else $count = 0;
	}
	else
	{
		header('location: login.php');
    }
?> 
<html>
<head>
	<title>Edit</title>
	<link rel="stylesheet" type="text/css" href="assets/css/lib/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="assets\javascript\lib\bootstrap-select-1.12.4\dist\css\bootstrap-select.css">
	<link rel="stylesheet" type="text/css" href="assets/css/data_entry_lab_assistant.css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300" rel="stylesheet">
	<script type="text/javascript" src = "assets/javascript/lib/jQuery.js"></script>
	<script type="text/javascript" src = "assets/javascript/lib/bootstrap.js"></script>
    <script type="text/javascript" src = "assets\javascript\lib\bootstrap-select-1.12.4\js\bootstrap-select.js"></script>
        <script type="text/javascript">
    $('.selectpicker').selectpicker({
      });
</script>

<style type="text/css">
	.bootstrap-select.btn-group .dropdown-toggle .filter-option{
		font-size: small;	
	}
</style>
	
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
				        	<li class = "active"><a href="admin.php" class = "active-page">Edit Data</a></li>
				        	<li ><a href="delete.php">Write Off</a></li>
				        	<li ><a href="report.php">Generate Report</a></li>
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
                            <div class="row">
							<div class="col-xs-4 col-xs-offset-4">
								<a href="#" class="active" id="product-form-link col-md-4 col-sm-offset-4">Edit Single Item</a>
							</div>
                            </div>
						<hr>
					</div>
	                    <div class="panel-heading">
	                    	<div class="form-group inputs">
	                     		<!-- Format here -->
								<?php
									echo "Current lab: ".$_SESSION['lab_name']."<br>";
									
								?>	
							</div>
	                        <form method = "post" name="form1" id="form1">
	                             <div class="form-group">    
	                             	 <div class="row">
	                                    <div class="form-group col-md-4 col-sm-offset-4 scontainer">
											<label>Bill No: <input type="text" class = "form-control inputs" name="bill_no"></label>
										</div>
	                                </div>
	                                <div class="row">
	                                    <div class="form-group col-md-4 col-sm-offset-4 scontainer">
											<label>Type: <select type = "text" style = "width:225px" class = " selectpicker" name = "type" id = "type" title = "Type of Equipment" onchange="this.form.submit()">
												<option disabled selected>Select</option>
												<option <?php if(isset($_SESSION['type']) && $_SESSION['type'] == 'Software') echo "selected"; ?>>Software</option>
												<option <?php if(isset($_SESSION['type']) && $_SESSION['type'] == 'Hardware') echo "selected"; ?>>Hardware</option>
												<option <?php if(isset($_SESSION['type']) && $_SESSION['type'] == 'Electrical Item') echo "selected"; ?>>Electrical Item</option>
												<option <?php if(isset($_SESSION['type']) && $_SESSION['type'] == 'Furniture') echo "selected"; ?>>Furniture</option>
												<option <?php if(isset($_SESSION['type']) && $_SESSION['type'] == 'Other') echo "selected"; ?>>Other</option>
												</select>
											</label>
										</div>
	                                </div>
	                               
	                                
	                            </div>
	                        </form>
	                        <form method = "post" enctype = "multipart/form-data" action="edit_part2.php">
		                        <div class="form-group">
		                        	<div class="row">
									<div class="col-md-4 col-sm-offset-4">
										<select name = "r1" class = "selectpicker" id="type" title = "items" required>
		                        	<?php
										if($count ==1) {
									         if(isset($_POST["type"]) && isset($_POST['bill_no'])) {  
									            $type = $_POST['type'];
									            $bill_no = $_POST['bill_no'];
									            $lab_id = $_SESSION['lab_id'];
									             $query = "SELECT central_dsr_no,count(name_of_equip) as c from equipment WHERE type = '$type' AND del_flag = 1 AND eqp_id in (SELECT eqp_id FROM equip_lab WHERE lab_id = $lab_id) AND bill_no = '$bill_no' GROUP BY bill_no HAVING c = 1";

									            $result = mysqli_query($link, $query);
									            if ($result->num_rows > 0) {

									                while($row = $result->fetch_assoc()) {
									                ?>	
														<option class="items" value=<?php echo $row["central_dsr_no"]; ?> required><?php echo $row["central_dsr_no"]; ?></option>
									                		
									                <?php
									                }
									                ?>
									            </select>
									            </div>
									       	</div><br>
									                <div class="row">
									                		<div class="col-sm-12">
									                			<input type="submit" name="final_submit" class="form-control btn btn-register inp">
									                		</div>
									                	</div>
									                
									                <?php
									            }
									         }
										}
									?>
		                        </div>
	                        </form>
	                    </div>
	                </div>
	            </div>
	        </div>
    	</div>

	<script>
		function checkFields()
		{
			var isvalid = true;
			var z=0;
			var x = document.forms["form1"]["type"].value;
			if(x.length==0){
				z++;
			}    			
		   	if(z!=0){
	    		alert('Please Select atleast one option');
				isvalid = false;
	    	}
			return isvalid;
		}	
	</script>	
</body>
</html>

