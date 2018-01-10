<?php 

	session_start();
	if($_SESSION['auth']  && $_SESSION['role'] == 'admin'){
		include 'connection.php';
		if($_POST){
			$lab_name = $_POST['name_of_lab'];
			$_SESSION['lab_name'] = $lab_name;
			$sql = "SELECT lab_id FROM lab WHERE lab_name LIKE '$lab_name'";
			$resql = mysqli_query($link,$sql);
			if($resql->num_rows > 0) {
				while($row = $resql->fetch_assoc())
					$lab_id = $row['lab_id'];
			}
			$_SESSION['lab_id'] = $lab_id;
			header('location: lab_details.php');
		}

	}
	else
	{
		header('location: login.php');
	}
	
	
?>

<!DOCTYPE html>
<html>
<head>
	<title>admin lab id</title>
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
								<a href="#" class="active" id="product-form-link col-md-4 col-sm-offset-4">Lab Details</a>
							</div>
                            </div>
						<hr>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
	                        <form method = "post" name="form1" id="form1">
	                             <div class="tabcontent" id="product-form" style="display: block;">
										<div class="form-group col-md-4 col-sm-offset-4 container">
											<label>Lab info: <select type = "text" style = "width:225px" class = " selectpicker" name = "name_of_lab" id = "type" title = "Lab name" required>
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
											</label>
										</div>
										<div class="form-group">
											<div class="row">
												<div class="col-sm-4 col-sm-offset-4"><br>
													<input type="submit" name="register-submit" id="next1" tabindex="4" class="form-control btn btn-register inp" value="Submit" onclick="return checkFields();">
												</div>
											</div>
										</div>
									</div>
                                </form>
                            </div>    
	                    </div>
	                </div>
	            </div>
	        </div>
    	</div>
    </div>
	<script>
		// function checkFields()
		// {
		// 	var isvalid = true;
		// 	var z=0;
		// 	var x = document.forms["form1"]["type"].value;
		// 	if(x.length==0){
		// 		z++;
		// 	}    			
		//    	if(z!=0){
	 //    		alert('Please Select atleast one option');
		// 		isvalid = false;
	 //    	}
		// 	return isvalid;
		// }	
	</script>	
</body>
</html>