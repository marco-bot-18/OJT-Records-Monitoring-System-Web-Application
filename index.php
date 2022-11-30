<!-- php script goes here for login -->
<?php
session_start();
if (isset($_SESSION['coordinator_id'])) {
	// header('location: index.php');    
}

if (isset($_SESSION['studentID'])) {
	// header('location: index.php');    
}

if (isset($_SESSION['username'])) {
	// header('location: index.php');    
} else {
	//header('location: index-coordinator.php');    
}
?>

<!doctype html>
<html lang="en">

<head>
	<title>e-OJT aCCeSs | Sign In</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Custom fonts for this template -->
	<link href="../coordinator/vendor1/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900&display=swap" rel="stylesheet">

	<link href="admin/vendor1/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	<link href="img/icon/ccs_logo.png" rel="icon">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="login-page-bootstrap-design/css/style.css">

</head>

<style>
	* {
		margin: 0;
	}

	.forgot_password:hover {
		color: #990000;
	}

	body {
		opacity: 100%;
		background-image: url('img/lspu_bg.jpg');
		height: 100%;
		background-position: center;
		background-repeat: no-repeat;
		background-size: cover;
	}

	.container-body {
		background-color: rgba(38, 38, 38, 0.6);
		height: 100%;
		padding-bottom: 10%;

	}

	.errorWrap {
		color: black;
		padding: 10px;
		margin: 0 0 20px 0;
		background: #fff;
		border-left: 4px solid #dd3d36;
		-webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
		box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
	}

	.succWrap {
		color: black;
		padding: 10px;
		margin: 0 0 20px 0;
		background: #fff;
		border-left: 4px solid #5cb85c;
		-webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
		box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
	}

	#ID {
		border: 2px solid gray;
		color: #333333;
		background: white;
		border-radius: 5px 5px 5px 5px;
	}

	#ID:focus {
		color: black;
		border: 1px solid #800000;
		box-shadow: none;
		outline-offset: 0px;
		outline: none;
	}

	#password {
		border: 2px solid gray;
		color: #333333;
		background: white;
	}

	#password:focus {
		color: black;
		border: 1px solid #800000;
		box-shadow: none;
		outline-offset: 0px;
		outline: none;
	}

	#signin {
		color: white;
		background: #800000;
	}

	#signin:hover {
		background: #990000;
	}

	#option_sign_in {
		background: #800000;
		border: 1px solid white;
		color: white;
	}

	#option_sign_in:hover {
		background: white;
		color: black;
	}

	.link_ {
		color: orange;
	}

	.link_:hover {
		color: orange;
		text-decoration: underline;
	}

	.sticky-footer,
	.fg-footer {
		background: rgba(128, 0, 0);
		padding: 29.5px;
		margin-top: 0px;
	}

	.fg-footer {
		margin-top: 1px;
	}

	.login__container {
		opacity: 200%;
	}
</style>

<body>
	<div class="container-body">
		<section class="ftco-section login__container">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-md-6 text-center mb-5">
						<!-- CONTENTS HERE -->
					</div>
				</div>
				<div class="row justify-content-center">
					<div class="col-md-12 col-lg-10">
						<div class="wrap d-md-flex">
							<div class="text-wrap p-4 p-lg-5 text-center d-flex align-items-center order-md-last" style="background: #800000; opacity: 100%;">
								<div class="text w-100">
									<img src="img/icon/ccs_logo.png" width="100px" height="100px;">
									<h2>Welcome to e-OJT aCCeSs Web Portal</h2>
									<hr style="background-color: ghostwhite;">
								</div>
							</div>
							<div class="login-wrap p-4 p-lg-5" style="opacity: 95%;">
								<div class="d-flex">
									<div class="w-100">
										<h3 class="mb-4" style="font-weight: bold;"><i class="fas fa-user"></i> Sign in</h3>
									</div>
								</div>
								<?php
								if (isset($_SESSION['err_message'])) {
									echo "<div class='errorWrap'><strong>ERROR</strong> : " . ($_SESSION['err_message']) . " </div>";
								}
								unset($_SESSION['err_message']);

								if (isset($_SESSION['success_msg'])) {
									echo "<div class='succWrap'><strong>SUCCESS</strong> : " . ($_SESSION['success_msg']) . " </div>";
								}
								unset($_SESSION['success_msg']);
								?>
								<form action="includes/login-config.php" class="signin-form" method="POST">
									<div class="form-group mb-3">
										<label class="label" for="name">Student/Employee ID</label>
										<input type="text" maxlength="20" id="ID" name="ID" class="form-control" placeholder="Enter Your Student or Employee ID" required>
									</div>
									<div class="form-group mb-3">
										<label class="label" for="password">Password</label>
										<input type="password" maxlength="20" style="border-radius: 5px 5px 5px 5px;" id="password" class="form-control" name="password" placeholder="Enter Your Password" required>
									</div>
									<div class="form-group">
										<button type="submit" style="border-radius: 5px 5px 5px 5px;" name="signin" id="signin" class="form-control btn btn-danger submit px-3">Sign In <i style="color: white;" class="fas fa-sign-in-alt"></i></button>
									</div>
									<div class="form-group d-md-flex">
										<div class="w-50 text-left">

										</div>
										<div class="w-50 text-md-right">
											<a href="forgot-password/forgot_password.php" class="forgot_password">Forgot Password?</a>
										</div>
									</div>
								</form>
							</div>
						</div>
						<footer class="sticky-footer bg fg-footer">
							<div class="container my-auto">
								<div class="copyright text-center my-auto" style="color: ghostwhite;">
									<span style="font-size: 14px; font-family: verdana;">e-OJT aCCeSs: OJT RECORDS MONITORING SYSTEM OF COLLEGE OF COMPUTER STUDIES - LSPU MAIN CAMPUS<br>© Copyright 2021. All Rights Reserved.</span><a class="link_" target="_blank" rel="" href="https://www.facebook.com/groups/1004436723245418/"> College of Computer Studies</a> - <a target="_blank" rel="" href="https://lspu.edu.ph/" class="link_"> LSPU-SCC</a>
								</div>
							</div>
						</footer>
					</div>
				</div>
			</div>
		</section>
	</div>

	<!-- jscript sources -->
	<script src="login-page-bootstrap-design/js/jquery.min.js"></script>
	<script src="login-page-bootstrap-design/js/popper.js"></script>
	<script src="login-page-bootstrap-design/js/bootstrap.min.js"></script>
	<script src="login-page-bootstrap-design/js/main.js"></script>

</body>

</html>