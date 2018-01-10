<?php 

	session_start();
	$amount = 0;
	$nameErr = ''; 
	if($_SESSION['auth']  && $_SESSION['role'] == 'admin'){
		include 'connection.php';
		$lab_id = $_SESSION['lab_id'];
		// $sql = "SELECT lab_name FROM lab WHERE lab_id = '$lab_id'";
		// $resql = mysqli_query($link,$sql);
		// if($resql->num_rows > 0) {
		// 	while($row = $resql->fetch_assoc())
		// 		$lab_name = $row['lab_name'];
		// }
		$lab_name = $_SESSION['lab_name'];
		if($_POST){
			if(isset($_POST['name_of_equip']) && isset($_POST['quantity']) && isset($_POST['type']) && isset($_POST['warranty']) && isset($_POST['cdr'])&& isset($_POST['rate']) && isset($_POST['central_dsr_no']) && isset($_POST['description']) && isset($_POST['name_of_vendor']) && isset($_POST['contact_no']) && isset($_POST['address']) &&  isset($_POST['purchase_date']) &&  isset($_POST['supply_date']) &&  isset($_POST['purchase_order_no']) && isset($_POST['bill_no'])){

				$cdr = $_POST['cdr'];
				$name = $_POST['name_of_equip'];
				$quantity = $_POST['quantity'];
				$type = $_POST['type'];
				$warranty = $_POST['warranty'];
				$rate = $_POST['rate'];
				$amount = $rate * $quantity;
				$central_dsr_no = $_POST['central_dsr_no'];
				$description = $_POST['description'];
				$name_of_vendor = $_POST['name_of_vendor'];
				$contact_no = $_POST['contact_no'];
				$address = $_POST['address'];
				$purchase_date = $_POST['purchase_date'];
				$supply_date = $_POST['supply_date'];
				$purchase_order_no = $_POST['purchase_order_no'];
				$bill_no = $_POST['bill_no'];
	            
				$big =0;                  
	            if (!preg_match("/^[ 0-9A-Za-z. \\- \s]+$/",$name)) {
		             $nameErr .= "<br>Only letters and white space are allowed in name"; 
		             $big++;
		        }
		        if(strtotime($supply_date) < strtotime($purchase_date)){
		        	$nameErr .= "<br>Supply Date should not be before purchase date";
		        }

		        if (!preg_match("/^[0-9]*$/",$quantity)) {
		             $nameErr .= "<br>Only numbers are allowed in quantity"; 
		             $big++;
		        }
	            if (!preg_match("/^[a-zA-Z0-9 \s]*$/",$type)) {
		             $nameErr .= "<br>Only letters and white space are allowed in type of equipment"; 
		             $big++;
		        }
	            
	            if (!preg_match("/^[0-9.]*$/",$warranty)) {
		             $nameErr .= "<br>Only numbers and decimal point allowed in warranty"; 
		             $big++;
		        }            
	            if (!preg_match("/^[0-9]*$/",$rate)) {
		             $nameErr .= "<br>Only numbers and decimal point allowed in rate"; 
		             $big++;
		        }            
		        if (!preg_match("/^[a-zA-Z0-9- \/ \s]*$/",$central_dsr_no)) {
		             $nameErr .= "<br>Only letters, slashes and numbers space are allowed in departmental_dsr_no"; 
		             $big++;
		        }
		        if (!preg_match("/^[a-zA-Z0-9- \/ \s]*$/",$cdr)) {
		             $nameErr .= "<br>Only letters, slashes and numbers space are allowed in central_dsr_no"; 
		             $big++;
		        }
	            if (!preg_match("/^[ 0-9A-Za-z. \\- \s]+$/",$description)) {
		             $nameErr .= "<br>Only letters,numbers and white space are allowed in description"; 
		             $big++;
		        }
	            if (!preg_match("/^[0-9a-zA-Z. \s]*$/",$name_of_vendor)) {
		             $nameErr .= "<br>Only letters and white space are allowed in name of vendor"; 
		             $big++;
		        }
	            
	            if (!preg_match("/^[0-9]*$/",$contact_no)) {
		             $nameErr .= "<br>Only numbers allowed in contact no"; 
		             $big++;
		        }
	            
	            if (!preg_match("/^[ 0-9A-Za-z \\-.,\s]+$/",$address)) {
		             $nameErr .= "<br>Only letters and white space are allowed in address"; 
		             $big++;
		        }
	            
	           
	            if (!preg_match("/^[0-9A-Za-z-]*$/",$purchase_order_no)) {
		             $nameErr .= "<br>Invalid purchase order number"; 
		             $big++;
		        }

	            if (!preg_match("/^[a-zA-Z0-9-]*$/",$bill_no)) {
		             $nameErr .= "<br>Invalid bill no"; 
		             $big++;
		        }

		        if($big == 0){
	                if($quantity > 1){
	                    $i=1;
	                    $dsr = $central_dsr_no.'('.$i.')';
	                    $query1 = "INSERT INTO equipment (eqp_id, name_of_equip, quantity, type, warranty, rate, amount, central_dsr_no, cdr, description,del_flag, bill_no) VALUES (null, '$name', 1, '$type', $warranty, $rate, $amount,'$dsr','$cdr','$description',1, '$bill_no')";
	                    $result1 = mysqli_query($link, $query1);
	                    $eqp_id = mysqli_insert_id($link);

	                    $query4 = "INSERT INTO equip_lab values ($eqp_id,$lab_id,0)";
	                    $result4 = mysqli_query($link, $query4);


	                    $query0 = "SELECT vendor_id FROM vendor WHERE name_of_vendor ='$name_of_vendor' AND contact_no = $contact_no AND address = '$address' ";
	                    $res0 = mysqli_query($link,$query0);
	                    if(mysqli_num_rows($res0) == 0) { 
	                        $query2 = "INSERT INTO vendor values (null, '$name_of_vendor', '$contact_no','$address')";
	                        $result2 = mysqli_query($link, $query2);
	                        $ven_id = mysqli_insert_id($link);
	                        $query3 = "INSERT INTO supplies values ($eqp_id,$ven_id,'$purchase_date','$supply_date','$bill_no','$purchase_order_no')";
	                        $result3 = mysqli_query($link, $query3);
	                    }
	                    else {
	                        if($res0->num_rows > 0) {
	                            while($row = $res0->fetch_assoc())
	                                $ven_id = $row['vendor_id'];
	                        }
	                        $query3 = "INSERT INTO supplies values ($eqp_id,$ven_id,'$purchase_date','$supply_date','$bill_no','$purchase_order_no')";
	                        $result3 = mysqli_query($link, $query3);

	                    }
	                    for($i=2;$i<=$quantity;$i++){
	                        $dsr = $central_dsr_no.'('.$i.')';
	                        $query1 = "INSERT INTO equipment (eqp_id, name_of_equip, quantity, type, warranty, rate, amount, central_dsr_no, cdr, description, del_flag, bill_no) VALUES (null, '$name', 1, '$type', $warranty, $rate, $amount,'$dsr','$cdr','$description',1, '$bill_no')";
	                        $result1 = mysqli_query($link, $query1);
	                        $eqp_id = mysqli_insert_id($link);

	                        $query4 = "INSERT INTO equip_lab values ($eqp_id,$lab_id,0)";
	                        $result4 = mysqli_query($link, $query4);

	                        $query3 = "INSERT INTO supplies values ($eqp_id,$ven_id,'$purchase_date','$supply_date','$bill_no','$purchase_order_no')";
	                        $result3 = mysqli_query($link, $query3);
	                    }

	                    $queri = "UPDATE lab SET lab_cost = lab_cost + $amount, lab_investment = lab_investment + $amount WHERE lab_id = $lab_id";
	                    $result = mysqli_query($link, $queri);
	                }
	                else{
	                    $query1 = "INSERT INTO equipment (eqp_id, name_of_equip, quantity, type, warranty, rate, amount, central_dsr_no, cdr, description, del_flag,bill_no) VALUES (null, '$name', 1, '$type', $warranty, $rate, $amount,'$central_dsr_no','$cdr','$description',1,'$bill_no')";
	                    $result1 = mysqli_query($link, $query1);
	                    $eqp_id = mysqli_insert_id($link);

	                    $query4 = "INSERT INTO equip_lab values ($eqp_id,$lab_id,0)";
	                    $result4 = mysqli_query($link, $query4);


	                    $query0 = "SELECT vendor_id FROM vendor WHERE name_of_vendor ='$name_of_vendor' AND contact_no = $contact_no AND address = '$address' ";
	                    $res0 = mysqli_query($link,$query0);
	                    if(mysqli_num_rows($res0) == 0) { 
	                        $query2 = "INSERT INTO vendor values (null, '$name_of_vendor', '$contact_no','$address')";
	                        $result2 = mysqli_query($link, $query2);
	                        $ven_id = mysqli_insert_id($link);
	                        $query3 = "INSERT INTO supplies values ($eqp_id,$ven_id,'$purchase_date','$supply_date','$bill_no','$purchase_order_no')";
	                        $result3 = mysqli_query($link, $query3);
	                    }
	                    else {
	                        if($res0->num_rows > 0) {
	                            while($row = $res0->fetch_assoc())
	                                $ven_id = $row['vendor_id'];
	                        }
	                        $query3 = "INSERT INTO supplies values ($eqp_id,$ven_id,'$purchase_date','$supply_date','$bill_no','$purchase_order_no')";
	                        $result3 = mysqli_query($link, $query3);

	                    }
	                    $queri = "UPDATE lab SET lab_cost = lab_cost + $amount, lab_investment = lab_investment + $amount WHERE lab_id = $lab_id";
	                    $result = mysqli_query($link, $queri);
	                }
	                if($result){
	                	$_SESSION['result'] = 'Data entered successfully';
	                }
	                else{
	                	$_SESSION['result'] = 'Data entry failed';
	                }
		        }

            }
            else{
            	$nameErr = 'All field should be entered';
            }
		}
	}
	else
	{
		header('location: login.php');
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
				        	<li class = "active"><a href="data_entry.php" class = "active-page">Data Entry</a></li>
				        	<li ><a href="admin.php">Edit Data</a></li>
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
										echo "Current lab = ".$lab_name."<br>";
										if($nameErr != ''){
											echo $nameErr;
										}
									?>	
								</div>
								
								<form method="post" role="form" action="" >
									<div class="tabcontent" id="product-form" style="display: block;">
										<div style="color: #68100d; text-align: center;">
											<?php 
											if(isset($_SESSION['result'])){
												echo $_SESSION['result'].'<br>';
												$_SESSION['result'] = null;
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
											<label>Warranty(in years): <select type = "text" style = "width:225px" class = " selectpicker" name = "warranty" title = "Warranty">
			  								<option>1</option>
			  								<option>2</option>
			  								<option>3</option>
			  								<option>4</option>
			  								<option>5</option>
											</select>
											</label>
										</div>
										<div class="form-group col-md-4 container">
											<label>Rate: <input type = "text" class = "form-control inputs" name = "rate"></label>
										</div>
										<div class="form-group col-md-4 container">
											<label>Quantity: <input type = "text" class = "form-control inputs" name = "quantity"></label>
										</div>
										<div class="form-group col-md-4 container">
											<label>Department DSR No: <input type = "text" class = "form-control inputs " value = "KJSCE/COMP/<?php echo $lab_name.'/'; ?>" name = "central_dsr_no"></label>
										</div>
										<div class="form-group col-md-3 container">
											<label>Central DSR No: <input type = "text" class = "form-control inputs " name = "cdr"></label>
										</div>
										<div class="form-group col-md-6 container">
											<label>Description:<textarea class = "form-control inputs imp" rows = "3" name = "description" style="width : 225px"></textarea></label>
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
	                                        <label>Name Of Supplier:<input type = "text" class = "form-control inputs" name = "name_of_vendor" id="suggest" list="nov" style="width : 300px"></label>
				  				               <datalist id="nov"></datalist>
	                                    </div>
										<div class="form-group col-md-6 inp2">
	                                        <label>Contact No:<input type = "text" class = "form-control inputs" name = "contact_no" id = "con" style="width : 300px"></label>
	                                    </div>
										<div class="form-group col-md-9">
											<label>Address:<textarea rows = "3" class = "form-control inputs imp" name = "address" id = "add" style="width : 480px"></textarea></label>
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
	                                        <label>Purchase Date:<input type = "date" class = "form-control inputs inp" name = "purchase_date" style="width : 300px"></label>
	                                    </div>
										<div class="form-group col-md-6 inp2">
	                                        <label>Supply Date:<input type = 'date' class = "form-control inputs inp" name = "supply_date" style="width : 300px"></label>
	                                    </div>
										<div class="form-group col-md-6">
											<label>Purchase Order No:<input type = "text" class = "form-control inputs" name = "purchase_order_no" style="width : 300px"></label>
										</div>
	                                    <div class="form-group col-md-6">
											<label>Bill_no:<input type = "text" class = "form-control inputs" name = "bill_no" style="width : 300px"></label>
										</div>
	                                    <div class="form-group">
											<div class="row">
												<div class="col-sm-6 col-sm-offset-3">
													<input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-register" value="Submit" style="width : 380px" onclick="return checkFields();">
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

