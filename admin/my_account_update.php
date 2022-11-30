<?php
require_once('includes/session.php');
//error_reporting(0);
session_start();

//date and time
date_default_timezone_set('Asia/Manila');
$timestamp = time();
$td = date("F d, Y");
$time = date("h:i:s A");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$id = $_POST['id'];
	$emp_id = $_POST['employee_id'];
	$fname = ucwords($_POST['fname']);
	$mname = ucwords($_POST['mname']);
	$lname = ucwords($_POST['lname']);
	$email = $_POST['email'];
	$gender = $_POST['gender'];
	$address = ucwords($_POST['address']);
	$civil_status = $_POST['civil_status'];
	$bday = $_POST['bday'];
	$uname = $_POST['uname'];
	$pword = md5($_POST['pword']);
	$id = $_SESSION['admin_id'];
	$my_password = $_SESSION['admin_password'];

	if($pword==$my_password){
		// if($pword == $mypassword){
		// 	$pword = $mypassword;
		// }
		// else{
		// 	$pword = password_hash($pword, PASSWORD_DEFAULT);
		// }

		$sql = "UPDATE tbl_admin SET username='$emp_id', fname='$fname', mname='$mname', lname='$lname', email='$email', gender='$gender', civil_stats='$civil_status', bday='$bday', address='$address' WHERE  id='$id' AND username='$uname' AND password='$pword'";

		if($conn->query($sql)){
			$active = "active";
	        $my_ID = $_SESSION['admin_username'];
	        $session_log = "You updated your account and personal information";
	        //log session
	        $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_log', '$td', '$time', '$my_ID', '$active')";
	        $query_log_run = mysqli_query($conn, $sql_log);
	        if ($query_log_run) {
				$_SESSION['success_msg'] = "Your ID updated successfully as the SUPER-USER. Please Login Again To Confirm Changes!";
				//session_destroy();
				unset($_SESSION['admin_username']);
				header('location: ../index.php?=username&password=changed');
			}
		}
		else{
			echo $conn->error;
		}
	}
	else
	{
		$_SESSION['err_message'] = "Incorrect Password!";
		header('location: my_account.php');
		//echo "<script> alert('Wrong password!'); window.location='my_account.php'</script>";
	}
}

?>
