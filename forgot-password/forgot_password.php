<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
  	<title>e-OJT aCCeSs | Forgot Password</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Custom fonts for this template -->
		<link href="../coordinator/vendor1/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
		<link
			href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
			rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900&display=swap" rel="stylesheet">
		<link href="../img/icon/ccs_logo.png" rel="icon">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="../login-page-bootstrap-design/css/style.css">

	</head>

	<style>
	.want_to_sign_in:hover{
		text-decoration: underline;
		color: #800000;
	}
	.link_{
		color: orange;
	}
	.link_:hover{
		color: orange;
		text-decoration: underline;
	}
	.mystyle{
		opacity: 98%;
		background: url('../img/lspu_bg.jpg');
		background-repeat: no-repeat;
		background-size: cover;
		background-position: center;
		
	}
	.errorWrap {
		color: black;
        padding: 10px;
        margin: 0 0 20px 0;
        background: #fff;
        border-left: 4px solid #dd3d36;
        -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    }
    .succWrap{
    	color: black;
        padding: 10px;
        margin: 0 0 20px 0;
        background: #fff;
        border-left: 4px solid #5cb85c;
        -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    }

    #email {
        border: 2px solid gray;
        color: #333333;
        background: white;
    }
    #email:focus {
    	color: black;
        border: 1px solid #800000;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
    }

    #signin{
    	background: #800000;
    }
    #signin:hover{
    	background: #990000;
    }
	</style>

	<body class="mystyle">

	<script>
		function preback(){
			window.history.forward();
		}
		setTimeout("preback()", 0);
		
		window.onunload=function() { 
			null;
		}
	</script>

	

	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 text-center mb-5">
					<!-- <h2 class="heading-section" style="font-family: Sans-serif; font-weight: bold; color: orange; text-shadow: 2px 2px 5px black;">CCS OJT Web Portal - Student</h2> -->
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-12 col-lg-10">
					<div class="wrap d-md-flex">
						<div class="text-wrap p-4 p-lg-7 text-center d-flex align-items-center order-md-last" style="background: #800000;">
							<div class="text w-100">
								<img src="../img/icon/ccs_logo.png" width="100px" height="100px;">
								<h2>Welcome to e-OJT aCCeSs Web Portal</h2>
								<hr style="background: white;">
							</div>
			      		</div>
					<div class="login-wrap p-2 p-lg-5" style="opacity: 95%">
						<div class="d-flex">
							<div class="w-100">
								<h3 class="mb-4" style="font-weight: bold;"><i class="fas fa-question-circle"></i> Forgot Your Password?</h3>
							</div>								
						</div>
						<?php
							if(isset($_SESSION['invalid'])){
								echo "<div class='errorWrap'><strong>ERROR</strong> : ".($_SESSION['invalid'])." </div>";
							}
							unset($_SESSION['invalid']);

							if(isset($_SESSION['email_sent_status'])){
								echo "<div class='succWrap'><strong>SUCCESS</strong> : ".($_SESSION['email_sent_status'])." </div>";
							}
							unset($_SESSION['email_sent_status']);
						?>
						<form action="password_reset_code.php" class="signin-form"  method="post">
							<div class="form-group mb-3">
								<label class="label" for="name">Your Email Address</label>
								<input type="text" style="border-radius: 5px 5px 5px 5px;" maxlength="" id="email" name="email" class="form-control" placeholder="Enter Email Address" required>
							</div>
					
							<div class="form-group">
								<button type="submit" name="password_reset_link" id="signin" class="form-control btn btn-primary submit px-3" style="border-radius: 5px 5px 5px 5px;">Send Password Recovery Link  <i class="fas fa-envelope"></i></button>
							</div>
							<div class="form-group d-md-flex">
								<div class="w-50 text-left">

								</div>
								<div class="w-50 text-md-right">
								<a href="../index.php" class="want_to_sign_in">Want to Sign In?</a>
								</div>
							</div>
							<div class="form-group" style="margin-top: 15px;">
						<!--  -->
							</div>
						</form>
					</div>
		     </div>
			 <footer class="sticky-footer bg" style="background: rgba(128, 0, 0); padding: 29.5px; margin-top: 1px; ">
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

	<!-- script sources -->
	<script src="login-page-bootstrap-design/js/jquery.min.js"></script>
	<script src="login-page-bootstrap-design/js/popper.js"></script>
	<script src="login-page-bootstrap-design/js/bootstrap.min.js"></script>
	<script src="login-page-bootstrap-design/js/main.js"></script>
</body>
</html>