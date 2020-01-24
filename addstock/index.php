<?php

	require 'db_connect.php';

	if(isset($_POST['name']) && isset($_POST['security_code']) && isset($_POST['security_id']))
	{
		$name = $_POST['name'];
		$security_code = $_POST['security_code'];
		$security_id = $_POST['security_id'];

		$sql = "SELECT * FROM stockname WHERE security_code = $security_code AND security_id = '$security_id'";
		$result = mysqli_query($conn, $sql);
		if(mysqli_num_rows($result)>0)
		{
			echo "<script>alert('This Stock Has Been Already Entered!');</script>";
		}
		else
		{
			$sql = "INSERT INTO stockname(security_code, security_id, name) VALUES($security_code,'$security_id','$name')";
			if(mysqli_query($conn, $sql))
			{
				echo "<script>alert('New Stock has been added to the database');</script>";
			}
			else
			{
				echo "<script>alert('Problem Occurred. Please try again!');</script>";
			}
		}
	}

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Stocker | Stock Info</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type = "image/png" href="/stocker/img/logo.png">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/snackbar.css">
<!--===============================================================================================-->
</head>
<body>


	<div class="container-contact100">
		<!--<div class="contact100-map" id="google_map" data-map-x="40.722047" data-map-y="-73.986422" data-pin="images/icons/map-marker.png" data-scrollwhell="0" data-draggable="1"></div> -->

		<div class="wrap-contact100">
			<div class="contact100-form-title" style="background-image: url(images/bg-01.jpg);">
				<span class="contact100-form-title-1">
				Add New Stock
				</span>

				<span class="contact100-form-title-2">
					Fill the details
				</span>
			</div>

			<form class="contact100-form validate-form" method = "POST" action = "#" enctype="multipart/form-data">
				<div class="wrap-input100">
					<span class="label-input100">Name:</span>
					<input class="input100" type="text" name="name" placeholder="Enter Stock Name">
					<span class="focus-input100"></span>
				</div>

				<div class="wrap-input100">
					<span class="label-input100">Code:</span>
					<input class="input100" type="text" name="security_code" placeholder="Enter Security Code">
					<span class="focus-input100"></span>
				</div>

				<div class="wrap-input100">
					<span class="label-input100">ID:</span>
					<input class="input100" type="text" name="security_id" placeholder="Enter Security ID">
					<span class="focus-input100"></span>
				</div>

	
				<div class="container-contact100-form-btn">
					<button class="contact100-form-btn">
						<span>
							Submit
							<i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
						</span>
					</button>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<button formaction = '/stocker/login.php' class="contact100-form-logout-btn">
						<span>
							Log out
							<i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
						</span>
					</button>

				</div>
			</form>
		</div>
	</div>



	<div id="dropDownSelect1"></div>

<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAKFWBqlKAGCeS1rMVoaNlwyayu0e0YRes"></script>
	<script src="js/map-custom.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-23581568-13');
	</script>


</body>
</html>
