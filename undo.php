<?php 

	session_start();
	$amount = 0;
	$nameErr = ''; 
	if($_SESSION['auth']  && $_SESSION['role'] == 'admin'){
		include 'connection.php';
	}
	
?>
 
<html>
<head>
	<title>Data Entry</title>
	<link rel="stylesheet" type="text/css" href="assets/css/lib/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="assets\javascript\lib\bootstrap-select-1.12.4\dist\css\bootstrap-select.css">
	<link rel="stylesheet" type="text/css" href="assets/css/data_entry_lab_assistant.css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300" rel="stylesheet">
	<script type="text/javascript" src = "assets/javascript/lib/jQuery.js"></script>
	<script type="text/javascript" src = "assets/javascript/lib/bootstrap.js"></script>
    <script type="text/javascript" src = "assets\javascript\lib\bootstrap-select-1.12.4\js\bootstrap-select.js"></script>
       


    <script type="text/javascript">
		// Get the element with id="defaultOpen" and click on it
		document.getElementById("defaultOpen").click();

		function openFormPart(evt, typename) {
		    // Declare all variables
		    var i, tabcontent, tablinks;

		    // Get all elements with class="tabcontent" and hide them
		    tabcontent = document.getElementsByClassName("tabcontent");
		    for (i = 0; i < tabcontent.length; i++) {
		        tabcontent[i].style.display = "none";
		    }

		    // Get all elements with class="tablinks" and remove the class "active"
		    tablinks = document.getElementsByClassName("tablinks");
		    for (i = 0; i < tablinks.length; i++) {
		        tablinks[i].className = tablinks[i].className.replace(" active", "");
		    }

		    // Show the current tab, and add an "active" class to the button that opened the tab
		    document.getElementById(typename).style.display = "block";
		    evt.currentTarget.className += " active";
		}

		
	</script>
	<style type="text/css">
		.sbm{
			text-align: center;
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
				        	<li><a href="data_entry.php">Data Entry</a></li>
				        	<li ><a href="admin.php">Edit Data</a></li>
				        	<li ><a href="delete.php">Write Off</a></li>
				        	<li ><a href="report.php">Generate Report</a></li>
				        	<li ><a href="transfer.php">Transfer</a></li>
				        	<li ><a href="newuser.php">Add new user</a></li>
				        	<li ><a href="lab_details.php">Lab Details</a></li>
				        	<li class = "active"><a href="undo.php" class = "active-page">Roll Back Operations</a></li>
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
    		<div class="row"></div>
			<div class="col-md-6 col-md-offset-3">
				<div class="panel panel-login">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-4">
								<a href="#" class="active" id="product-form-link">Undo Data Entry</a>
							</div>
							<div class="col-xs-4">
								<a href="#" id="vendor-form-link">Undo Delete</a>
							</div>
                            <div class="col-xs-4">
								<a href="#" id="bill-form-link">Undo Transfer</a>
							</div>
						</div>
						<hr>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<!-- Format the text shown here -->
								<div class="form-group inputs">
						
								</div>
								
								<form method="post" action="undo_entry.php" >
									<div class="tabcontent" id="product-form" style="display: block;">
										<div style="color: #68100d; text-align: center;">
											<?php 
											if(isset($_SESSION['res'])){
												echo $_SESSION['res'].'<br>';
												$_SESSION['res'] = null;
											}
											if(isset($_SESSION['un_error'])){
												echo $_SESSION['un_error'].'<br>';
												$_SESSION['un_error'] = null;
											}

										 ?>	
										</div>
										<br>
										<div class="form-group col-md-4 container">
											<label>Name of Equipment: <input type = "text" class = "form-control inputs" name = "name_of_equip" id = "name_of_equip"></label>
										</div>
										<div class="form-group col-md-4 container">
											<label>Type: <select type = "text" style = "width:225px" class = " selectpicker" name = "type" id = "type" title = "Type of Equipment">
												<option>Software</option>
												<option>Hardware</option>
												<option>Electrical Item</option>
												<option>Furniture</option>
												<option>Other</option>
												</select>
											</label>
										</div>
										
										<div class="form-group col-md-4 container">
											<label>Bill No: <input type = "text" class = "form-control inputs" name = "bill_no"></label>
										</div>
										
										<div class="form-group">
											<div class="row">
												<div class="col-md-12 sbm"><br><br>
													<input type="submit" name="register-submit" class="form-control btn btn-register" style="width : 150px;">
												</div>
											</div>
										</div>
										
									</div>
								</form>
								<form method="post" action="undo_delete.php">
									<div id="vendor-form" class="tabcontent" style="display: none;">
										<div class="form-group col-md-12 inp2 sbm">
	                                        <label>Departmental DSR No:<input type = "text" class = "form-control inputs" name = "dsr" style="width : 300px"></label>
				  				        </div>
										
										<div class="form-group">
											<div class="row">
												<div class="col-md-12 sbm"><br><br>
													<input type="submit" name="register-submit" class="form-control btn btn-register" style="width : 150px">
												</div>
											</div>
										</div>
									</div>
								</form>
								<form method="post" action="undo_transfer.php">
	                                <div id="bill-form" class="tabcontent" style="display: none;">
										<div class="form-group col-md-12 inp2 sbm">
	                                        <label>Departmental DSR No:<input type = "text" class = "form-control inputs" name = "dsr" style="width : 300px"></label>
				  				        </div>
										
										<div class="form-group">
											<div class="row">
												<div class="col-md-12 sbm"><br><br>
													<input type="submit" name="register-submit" class="form-control btn btn-register" style="width : 150px">
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
</body>
    	<script>
            $(function() {

    $('#product-form-link').click(function(e) {
		$("#product-form").delay(100).fadeIn(100);
 		$("#vendor-form").fadeOut(100);
		$('#vendor-form-link').removeClass('active');
        $("#bill-form").fadeOut(100);
		$('#bill-form-link').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
	});
    $('#next1').click(function(e) {
		$("#vendor-form").delay(100).fadeIn(100);
 		$("#product-form").fadeOut(100);
		$('#product-form-link').removeClass('active');
        $("#bill-form").fadeOut(100);
		$('#bill-form-link').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
	});
	$('#vendor-form-link').click(function(e) {
		$("#vendor-form").delay(100).fadeIn(100);
 		$("#product-form").fadeOut(100);
		$('#product-form-link').removeClass('active');
        $("#bill-form").fadeOut(100);
		$('#bill-form-link').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
	});
    $('#next2').click(function(e) {
		$("#bill-form").delay(100).fadeIn(100);
 		$("#product-form").fadeOut(100);
		$('#product-form-link').removeClass('active');
        $("#vendor-form").fadeOut(100);
		$('#vendor-form-link').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
	});
    $('#bill-form-link').click(function(e) {
		$("#bill-form").delay(100).fadeIn(100);
 		$("#product-form").fadeOut(100);
		$('#product-form-link').removeClass('active');
        $("#vendor-form").fadeOut(100);
		$('#vendor-form-link').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
	});
});
	</script>
</html>

