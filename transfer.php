<?php 
	session_start();
	if($_SESSION['auth'] && $_SESSION['role'] == 'admin'){
		if($_POST){
			include 'connection.php';
			$_SESSION['typet'] = $_POST['type'];
			$_SESSION['fl'] = $_POST['from_lab_name'];
			$count = 1;
		} 
		else $count = 0;
	}
	else
	{
		header('location: login.php');
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Transfer</title>
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
			        	<li ><a href="admin.php" class = "active-page">Edit Data</a></li>
			        	<li ><a href="delete.php">Write Off</a></li>
			        	<li ><a href="report.php">Generate Report</a></li>
			        	<li class = "active"><a href="transfer.php">Transfer</a></li>
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
	                	<div class="form-group inputs">
                     		<!-- Format here -->
							<?php
								echo "Current lab: ".$_SESSION['lab_name']."<br>";
								
							?>	
						</div>
	                    <form method="post" action=''>
	                         <div class="form-group"> 
	                         	<div class = 'row'>
	                    			<div class = 'col-md-4 col-sm-offset-4'>
	                    				<br>
	                    				<label>From Lab Name :</label>
										<select name = "from_lab_name" class = "selectpicker" id="type" title = "Lab name" required>
											<option disabled selected>Select</option>
											<option <?php if(isset($_SESSION['fl']) && $_SESSION['fl'] == 'DCA') echo "selected"; ?> value = 'DCA' required>DCA</option>
											<option <?php if(isset($_SESSION['fl']) && $_SESSION['fl'] == 'OOAD') echo "selected"; ?> value = 'OOAD' required>OOAD</option>
											<option <?php if(isset($_SESSION['fl']) && $_SESSION['fl'] == 'CP') echo "selected"; ?> value = 'CP' required>CP</option>
											<option <?php if(isset($_SESSION['fl']) && $_SESSION['fl'] == 'WT') echo "selected"; ?> value = 'WT' required>WT</option>
											<option <?php if(isset($_SESSION['fl']) && $_SESSION['fl'] == 'DBMS') echo "selected"; ?> value = 'DBMS' required>DBMS</option>
											<option <?php if(isset($_SESSION['fl']) && $_SESSION['fl'] == 'MMS') echo "selected"; ?> value = 'MMS' required>MMS</option>
											<option <?php if(isset($_SESSION['fl']) && $_SESSION['fl'] == 'MP') echo "selected"; ?> value = 'MP' required>MP</option>
											<option <?php if(isset($_SESSION['fl']) && $_SESSION['fl'] == 'SS') echo "selected"; ?> value = 'SS' required>SS</option>
											<option <?php if(isset($_SESSION['fl']) && $_SESSION['fl'] == 'PRJ') echo "selected"; ?> value = 'PRJ' required>PRJ</option>
											<option <?php if(isset($_SESSION['fl']) && $_SESSION['fl'] == 'PGCF') echo "selected"; ?> value = 'PGCF' required>PGCF</option>
											<option <?php if(isset($_SESSION['fl']) && $_SESSION['fl'] == 'AOA') echo "selected"; ?> value = 'AOA' required>AOA</option>
											<option <?php if(isset($_SESSION['fl']) && $_SESSION['fl'] == 'ROB') echo "selected"; ?> value = 'ROB' required>ROB</option>
											<option <?php if(isset($_SESSION['fl']) && $_SESSION['fl'] == 'CCN') echo "selected"; ?> value = 'CCN' required>CCN</option>
											<option <?php if(isset($_SESSION['fl']) && $_SESSION['fl'] == 'CCF') echo "selected"; ?> value = 'CCF' required>CCF</option>
											<option <?php if(isset($_SESSION['fl']) && $_SESSION['fl'] == 'DCR') echo "selected"; ?> value = 'DCR' required>DCR</option>
											<option <?php if(isset($_SESSION['fl']) && $_SESSION['fl'] == 'ADM') echo "selected"; ?> value = 'ADM' required>ADM</option>

											
											
											
										</select>
	                    			</div>
	                    		</div>  
	                            <div class="row">
	                                <div class="col-md-4 col-sm-offset-4 ">
	                                    <label>Type: <select type = "text" style = "width:225px" class = " selectpicker" name = "type" id = "type" title = "Type of Equipment" onchange="this.form.submit()">
											<option disabled selected>Select</option>
											<option <?php if(isset($_SESSION['typet']) && $_SESSION['typet'] == 'Software') echo "selected"; ?>>Software</option>
											<option <?php if(isset($_SESSION['typet']) && $_SESSION['typet'] == 'Hardware') echo "selected"; ?>>Hardware</option>
											<option <?php if(isset($_SESSION['typet']) && $_SESSION['typet'] == 'Electrical Item') echo "selected"; ?>>Electrical Item</option>
											<option <?php if(isset($_SESSION['typet']) && $_SESSION['typet'] == 'Furniture') echo "selected"; ?>>Furniture</option>
											<option <?php if(isset($_SESSION['typet']) && $_SESSION['typet'] == 'Other') echo "selected"; ?>>Other</option>
											</select>
										</label>
	                                </div>
	                            </div>
	                            
	                            
	                        </div>
	                    </form>
	                    <form method = "post" enctype = "multipart/form-data" action="transfer2.php">
	                    	<div class="form-group abc">
	                    		
	                    		<div class = 'row'>
	                    			<div class = 'col-md-4 col-sm-offset-4'>
	                    				<label>To Lab Name :</label>
										<select name = "lab_name" class = "selectpicker" id="type" title = "Lab name" required>
											<option value = 'DCA' required>DCA</option>
                                            <option value = 'OOAD' required>OOAD</option>
                                            <option value = 'CP' required>CP</option>
                                            <option value = 'WT' required>WT</option>
                                            <option value = 'DBMS' required>DBMS</option>
                                            <option value = 'MMS' required>MMS</option>
                                            <option value = 'MP' required>MP</option>
                                            <option value = 'SS' required>SS</option>
                                            <option value = 'PRJ' required>PRJ</option>
                                            <option value = 'PGCF' required>PGCF</option>
                                            <option value = 'AOA' required>AOA</option>
                                            <option value = 'ROB' required>ROB</option>
                                            <option value = 'CCN' required>CCN</option>
                                            <option value = 'CCF' required>CCF</option>
                                            <option value = 'DCR' required>DCR</option>
                                            <option value = 'ADM' required>ADM</option>
											
										</select>
	                    			</div>
	                    		</div>
	                    		<br />
	                    		<div class="row">
									<div class="col-md-4 col-sm-offset-4">
										<select name = "r1" class = "selectpicker" id="type" title = "items" required>
											
			                    		<?php
											if($count ==1 && isset($_POST['type']) && isset($_POST['from_lab_name'])) {
												$type = $_POST['type'];
												$from_lab_name = $_POST['from_lab_name'];
												$sql = "SELECT lab_id FROM lab WHERE lab_name = '$from_lab_name'";
												$res = mysqli_query($link, $sql);
												while($row = $res->fetch_assoc()){
													$lab_id = $row['lab_id'];
												}
												$_SESSION['from_lab_id'] = $lab_id;
												$query = "SELECT central_dsr_no from equipment WHERE type = '$type' AND del_flag = 1 AND eqp_id in (SELECT eqp_id FROM equip_lab WHERE lab_id = $lab_id)";

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
									</div>
									<br>
										<div class="form-group">
											<div class="row">
												<div class="col-sm-4 col-sm-offset-4"><br>
													<input type="submit" name="final_submit" id="submit" tabindex="4" class="form-control btn btn-register inp" value="Submit" onclick="return checkFields();">
												</div>
											</div>
										</div>
											
											<?php
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
	
</body>
</html>
		





