<?php 
	session_start();
	if($_SESSION['auth'] && $_SESSION['role'] == 'admin'){
		if($_POST['final_submit']){
			if(!isset($_POST['r1'])){
				header('location: admin.php');
			}
			include 'connection.php';
			$cdn = $_POST['r1'];
			$_SESSION['cdn'] = $cdn;
			$query0 = "SELECT * FROM equipment WHERE central_dsr_no LIKE '$cdn'";
			$result0 = mysqli_query($link, $query0);

			if($result0){
				//echo "Successful";
			}
			
			if ($result0->num_rows > 0) {
	
				while($row = $result0->fetch_assoc()) {
					$eqp_id = $row['eqp_id'];
					$name = $row['name_of_equip'];
					$quantity = $row['quantity'];
					$type = $row['type'];
					$warranty = $row['warranty'];
					$rate = $row['rate'];
					$cdr = $row['cdr'];
					$amount = $row['amount'];
					$description = $row['description'];
				}

			}

			$query01 = "SELECT * FROM supplies WHERE euip_id = $eqp_id ";
			$result01 = mysqli_query($link, $query01);

			if ($result01->num_rows > 0) {
	
				while($row = $result01->fetch_assoc()) {
					$vendor_id = $row['vendor_id'];
					$purchase_date = $row['purchase_date'];
					$supply_date = $row['supply_date'];
					$purchase_order_no = $row['purchase_order_no'];
					$bill_no = $row['bill_no'];
				}
			}

			$query02 = "SELECT * FROM vendor WHERE vendor_id = $vendor_id";
			$result02 = mysqli_query($link, $query02);

			if ($result02->num_rows > 0) {
	
				while($row = $result02->fetch_assoc()) {

					$name_of_vendor = $row['name_of_vendor'];
					$contact_no = $row['contact_no'];
					$address = $row['address'];
				}
			}
			$_SESSION['vendor_id'] = $vendor_id;
			$_SESSION['eqp_id'] = $eqp_id;
			$_SESSION['prevRate'] = $rate;
			
		}

	}
	else
	{
		header('location: login.php');
	}
	
	
?>
 
<html>
<head>
	<title>Data Edit</title>
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

	 <script>
        $(document).ready(function(){
        	var suggest = $("#suggest");
			suggest.keyup(function(){
				$.get("name_of_vendor.php", {name: suggest.val()}, function(data){
					$("datalist").empty();
					$("datalist").html(data);

				});
			});
			$("#add").click(function(){
				$.get("add.php", {add: suggest.val()}, function(data){
					$("#add").empty();
					$("#add").val(data);

				});
		    	
			});
			$("#con").click(function(){
		   		$.get("contact.php", {con: suggest.val()}, function(data){
					$("#con").empty();
					$("#con").val(data);

				});
			});
			$("#amount").click(function(){
		   		$("#amount").val(<?php echo $amount; ?>);
			});
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
							<div class="col-xs-4">
								<a href="#" class="active" id="product-form-link">Equipment Detail</a>
							</div>
							<div class="col-xs-4">
								<a href="#" id="vendor-form-link">Vendor Detail</a>
							</div>
                            <div class="col-xs-4">
								<a href="#" id="bill-form-link">Purchase Detail</a>
							</div>
						</div>
						<hr>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<!-- Format the text shown here -->
								<div class="form-group inputs">
									<?php
										echo "Current lab = ".$_SESSION['lab_name']."<br>";
										// if(isset($_SESSION['nameErr']) && $nameErr != ''){
										// 	echo $nameErr;
										// 	$_SESSION['nameErr'] = '';
										// }
									?>	
								</div>
								<form method="post" role="form" action="editaction.php" >
									<div class="tabcontent" id="product-form" style="display: block;">
										<div class="form-group col-md-4 container">
											<label>Name of Equipment: <input type = "text" class = "form-control inputs" name = "name_of_equip" id = "name_of_equip" value=<?php echo $name; ?>></label>
										</div>
										<div class="form-group col-md-4 container">
											<label>Type: <select type = "text" style = "width:225px" class = " selectpicker" name = "type" id = "type" title = "Type of Equipment">
											<option <?php if($type == "Software") echo "selected"; ?>>Software</option>
											<option <?php if($type == "Hardware") echo "selected"; ?>>Hardware</option>
											<option <?php if($type == "Electrical Item") echo "selected"; ?>>Electrical Item</option>
											<option <?php if($type == "Furniture") echo "selected"; ?>>Furniture</option>
											<option <?php if($type == "Other") echo "selected"; ?>>Other</option>
												</select>
											</label>
										</div>
										<div class="form-group col-md-4 container">
											<label>Warranty(in years): <select type = "text" style = "width:225px" class = " selectpicker" name = "warranty" title = "Warranty">
			  								<option <?php if($warranty == 1) echo "selected"; ?>>1</option>
		  								<option <?php if($warranty == 2) echo "selected"; ?>>2</option>
		  								<option <?php if($warranty == 3) echo "selected"; ?>>3</option>
		  								<option <?php if($warranty == 4) echo "selected"; ?>>4</option>
		  								<option <?php if($warranty == 5) echo "selected"; ?>>5</option>
											</select>
											</label>
										</div>
										<div class="form-group col-md-4 container">
											<label>Rate: <input type = "text" class = "form-control inputs" name = "rate" id = "rate" value=<?php echo $rate; ?>></label>
										</div>
										<div class="form-group col-md-4 container">
											<label>Quantity: <input type = "text" class = "form-control inputs" name = "quantity" id = "quantity" value=<?php echo $quantity; ?>></label>
										</div>
										<div class="form-group col-md-4 container">
											<label>Department DSR No: <input type = "text" class = "form-control inputs" name = "central_dsr_no" id = "central_dsr_no" value = <?php echo $cdn; ?> readonly ></label>
										</div>
										<div class="form-group col-md-3 container">
											<label>Central DSR No: <input type = "text" class = "form-control inputs " disabled readonly name = "cdr" value=<?php echo $cdr; ?>></label>
										</div>
										<div class="form-group col-md-6 container">
		  					               <label>Description:<textarea class = "form-control inputs" rows = "3" name = "description" id = "description"  style="width : 225px"><?php echo $description; ?></textarea></label>
										</div>
										<div class="form-group">
											<div class="row">
												<div class="col-sm-2"><br><br>
													<input type="button" name="register-submit" id="next1" tabindex="4" class="form-control btn btn-register" value="Next" style="width : 150px">
												</div>
											</div>
										</div>
									</div>
								
									<div id="vendor-form" class="tabcontent" style="display: none;">
										<div class="form-group col-md-6 inp2">
                                            <label>Name Of Supplier:<input type = "text" class = "form-control inputs" name = "name_of_vendor" id="suggest" list="nov" value=<?php echo $name_of_vendor; ?>></label>
				  				               <datalist id="nov"></datalist>
	                                    </div>
										<div class="form-group col-md-6 inp2">
                                            <label>Contact No:<input type = "text" class = "form-control inputs" name = "contact_no" id="con" value=<?php echo $contact_no; ?>></label>
	                                    </div>
										<div class="form-group col-md-9">
                                            <label>Address:<textarea rows = "3" class = "form-control inputs" name = "address" id="add"  style="width : 480px"><?php echo $address; ?></textarea></label>
										</div>
										<div class="form-group">
											<div class="row">
												<div class="col-sm-2"><br><br>
													<input type="button" name="register-submit" id="next2" tabindex="4" class="form-control btn btn-register" value="Next" style="width : 150px">
												</div>
											</div>
										</div>
									</div>
								
	                                <div id="bill-form" class="tabcontent" style="display: none;">
										<div class="form-group col-md-6 inp2">
                                            <label>Purchase Date:<input type = "date" class = "form-control inputs" name = "purchase_date" id = "purchase_date" style="width : 300px" value=<?php echo $purchase_date; ?>></label>
	                                    </div>
										<div class="form-group col-md-6 inp2">
                                            <label>Supply Date:<input type = 'date' class = "form-control inputs" name = "supply_date" id = "supply_date" style="width : 300px" value=<?php echo $supply_date; ?>></label>
	                                    </div>
										<div class="form-group col-md-6">
                                            <label>Purchase Order No:<input type = "text" class = "form-control inputs" name = "purchase_order_no" id = "purchase_order_no" style="width : 300px" value=<?php echo $purchase_order_no; ?>></label>
										</div>
	                                    <div class="form-group col-md-6">
                                            <label>Bill No:<input type = "text" class = "form-control inputs" name = "bill_no" id = "bill_no" style="width : 300px" value=<?php echo $bill_no; ?>></label>
										</div>
	                                    <div class="form-group">
											<div class="row">
												<div class="col-sm-6 col-sm-offset-3">
													<input type="submit" name="sbmt" id="register-submit" tabindex="4" class="form-control btn btn-register" value="Submit" style="width : 380px">
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
	<script>
        function checkFields()
	{
		var isvalid = true;
		var text ="";
		var z=0;
		var x = document.forms["form1"]["name_of_equip"].value;
		if(x.length==0){
			text += "First Name, ";
			z++;
		}
		var x1 = document.forms["form1"]["quantity"].value;
		if(x1.length==0){
			text += "Middle Name, ";
			z++;
		}
		var x2 = document.forms["form1"]["type"].value;
		if(x2.length==0){
			text += "Last Name, ";
			z++;
		}
		var x3 = document.forms["form1"]["warranty"].value;
		if(x3.length==0){
			text += "Staff ID, ";
			z++;
		}
		var x4 = document.forms["form1"]["rate"].value;
		if(x4.length==0){
			text += "Phone No., ";
			z++;
		}
		var x5 = document.forms["form1"]["amount"].value;
		if(x5.length==0){
			text += "Somaiya Mail ID, ";
			z++;
		}
		var x6 = document.forms["form1"]["central_dsr_no"].value;
		if(x6.length==0){
			text += "Enter Password, ";
			z++;
		}
		var x7 = document.forms["form1"]["description"].value;
		if(x7.length==0){
			text += "Confirm Password, ";
			z++;
		}
		var x8 = document.forms["form1"]["suggest"].value;
		if(x8.length==0){
			text += "Lab ID, ";
			z++;
		}
		var x9 = document.forms["form1"]["con"].value;
		if(x9.length==0){
			text += "Post, ";
			z++;
		}
        var x10 = document.forms["form1"]["add"].value;
		if(x10.length==0){
			text += "Post, ";
			z++;
		}
        var x11 = document.forms["form1"]["purchase_date"].value;
		if(x11.length==0){
			text += "Post, ";
			z++;
		}
        var x12 = document.forms["form1"]["supply_date"].value;
		if(x12.length==0){
			text += "Post, ";
			z++;
		}
        var x13 = document.forms["form1"]["purchase_order_no"].value;
		if(x13.length==0){
			text += "Post, ";
			z++;
		}
        var x14 = document.forms["form1"]["bill_no"].value;
		if(x14.length==0){
			text += "Post, ";
			z++;
		}
	   	text += ".";
	   	if(z!=0){
    		alert('Please fill '+ text);
			isvalid = false;
    	}
		var letters = /^[ A-Za-z]+$/ ;
		var letters2 = /^[ 0-9A-Za-z]+$/;
		var letters3 = /^[ 0-9 ]+$/;
        var letters4 =/^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/|-|\.)(?:0?[1,3-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$/;
		if(x.match(letters) || x==""){}
		else{	alert('Enter only alphabets in First Name.');
			isvalid = false;
		}
		if(x1.match(letters3) || x1==""){}
		else{	alert('Enter only alphabets in Middle Name.');
			isvalid = false;
		}
		if(x4.match(letters3) || x4==""){}
		else{	alert('Enter only alphabets in Last Name.');
			isvalid = false;
		}
		if(x5.match(letters3) || x5==""){}
		else{	alert('Enter only alphanumeric characters in Staff ID.');
			isvalid = false;
		}
		if(x7.match(letters2) || x7==""){}
		else{	alert('Enter only numeric data in Phone No..');
			isvalid = false;
		}
		if(x8.match(letters) || x8==""){}
		else{	alert('Enter only alphanumeric characters in Lab ID.');
			isvalid = false;
		}
        if(x9.match(letters3) || x9==""){}
		else{	alert('Enter only alphanumeric characters in Lab ID.');
			isvalid = false;
		}
        if(x10.match(letters2) || x10==""){}
		else{	alert('Enter only alphanumeric characters in Lab ID.');
			isvalid = false;
		}
        if(x11.match(letters4) || x11==""){}
		else{	alert('Enter only alphanumeric characters in Lab ID.');
			isvalid = false;
		}
        if(x12.match(letters4) || x12==""){}
		else{	alert('Enter only alphanumeric characters in Lab ID.');
			isvalid = false;
		}
        if(x13.match(letters3) || x13==""){}
		else{	alert('Enter only alphanumeric characters in Lab ID.');
			isvalid = false;
		}
        if(x14.match(letters3) || x14==""){}
		else{	alert('Enter only alphanumeric characters in Lab ID.');
			isvalid = false;
		}
		

		return isvalid;
	}
    </script>
	
	

</body>
</html>
