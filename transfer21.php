
<html>
<head>
	<title>Transfer</title>
	<link rel="stylesheet" type="text/css" href="assets/css/lib/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="assets/css/data_entry_lab_assistant.css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300" rel="stylesheet">
	<script type="text/javascript" src = "assets/javascript/lib/jQuery.js"></script>
	<script type="text/javascript" src = "assets/javascript/lib/bootstrap.js"></script>
    </head>
<body>
	
		<h1 class = "header"><img src = "images/logo.png" style="width:40px;height:40px;"><span style="display:inline-block; width: 40px;"></span>Computer Department, K.J. Somaiya College Of Engineering</h1>

		<div>
			<nav class="navbar navbar-inverse">
			  	<div class="container-fluid">

				    <div class="navbar-header">
				      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				        <span class="sr-only">Toggle navigation</span>
				      </button>
				      <p class = "navbar-text">COMPS DSR</p>
				    </div>

				    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				      	<ul class="nav navbar-nav navbar-right">
                            <li><a href="data_entry.php">Data Entry</a></li>
				        	<li ><a href="transfer.php">Equipment Transfer</a></li>
				        	<li ><a href="report.php">Generate Report</a></li>
				        	<li ><a href="lab_details.php">Lab Details</a></li>
				        	<li><a href="logout.php">Log Out</a></li>
                            </ul>
			    	</div>
				</div>
			</nav>
		</div>
    <?php 
	session_start();
	if($_SESSION['auth'] && $_SESSION['role'] == 'lab'){
		if($_POST){
			include 'connection.php';
			$count = 1;
		} 
		else $count = 0;
	}
	else
	{
		header('location: login.php');
	}
?>

	<div class="container">
    	<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="panel panel-login">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-12">
								<a href="#" class="active" id="product-form-link">Equipment Detail</a>
							</div>
						</div>
						<hr>
					</div>
                    <div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
                                <form method = "post">
                                    <div class="form-group col-md-6">
                                    <label>Type: <select type = "text" style = "width:300px" class = "form-control inputs inp" name = "type">
											<option value = "" disabled selected>Type of Equipment</option>
											<option>Sotware</option>
											<option>Hardware</option>
											<option>Electrical Item</option>
											<option>Furniture</option>
											<option>Other</option>
									</select>
                                    </label>
                                    </div>
                                    <div class="form-group col-md-4 container">
										<label>Lab Name <input type = "text" class = "form-control inputs" style = "width:300px"  name = "lab_id"></label>
									</div>
		                            
                                   <div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
												<input type="submit" name="type" id="register-submit" tabindex="4" class="form-control btn btn-register" value="Submit">
											</div>
										</div>
									</div>
	                                </form>

   
    
<form method = "post" enctype = "multipart/form-data" action="transfer2.php">
	<label>To Lab Name:<input type = "text" name = 'lab_name'></label>                    
<?php
	if($count ==1) {
		$type = $_POST['type'];
		
		$lab_id = $_SESSION['lab_id'];
		 $query = "SELECT central_dsr_no from equipment WHERE type = '$type' AND eqp_id in (SELECT eqp_id FROM equip_lab WHERE lab_id = $lab_id)";

		$result = mysqli_query($link, $query);
		if($result)
			echo "success";
		if ($result->num_rows > 0) {

			while($row = $result->fetch_assoc()) {
			?>	
				
				<input type="radio" name="r1"  value= <?php echo $row["central_dsr_no"]; ?>> <?php echo $row["central_dsr_no"]; ?><br>
			<?php
			}
			?>
			<input type="submit" name="final_submit">
			<?php
		}
	}
?>
                                </form>                         
                            </div>
                        </div>
				    </div>
				</div>
			</div>
		</div>
	</div>	
    
    
   
    </body>
</html>
