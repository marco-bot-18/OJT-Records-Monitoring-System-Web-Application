<?php
include('includes/session.php');

session_start();
error_reporting(0);

date_default_timezone_set('Asia/Manila');
$timestamp = time();
$date_ = date("F d, Y");
$time_ = date("h:i:s A");

if (isset($_POST['update_account'])) {
	$uniq_id = $_POST['uniq_id'];
	$id1 = $_POST['acc_id'];
	$fname = $_POST['fname'];
	$mname = $_POST['mname'];
	$lname = $_POST['lname'];
	$email = $_POST['email'];
	$contact = $_POST['contact'];
	$gender = $_POST['gender'];
	$civil_status = $_POST['civil_status'];
	$bday = $_POST['bday'];
	$address = $_POST['address'];

	$pword = md5($_POST['pword']);

	$id = $_SESSION['coordinator_id'];

	$mypassword = $_SESSION['coordinator_password'];

	if($pword==$mypassword){

		$sql = "UPDATE tbl_coordinators SET email='$email', contact='$contact', gender='$gender', civil_stats='$civil_status', bday='$bday', address='$address' WHERE coordinator_id='$id'and password='$pword' and id='$uniq_id'";

		if($conn->query($sql)){
			$active = "active";
			$session_login = "You updated your personal information";
			//log session
			$my_ID = $_SESSION['coordinator_id'];
			$sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_login', '$date_', '$time_', '$my_ID', '$active')";
			$query_log_run = mysqli_query($conn, $sql_log);
			if($query_log_run){
				$_SESSION['success_msg'] = "Information Updated Successfully!";
				header('location: my_account.php');
			}
		}
		else {
			echo $conn->error;
		}
	}
	else
	{
		$_SESSION['err_message'] = "Incorrect Password!";
		header('location: my_account.php');
		//$conn->error;
		//echo "<script> alert('Wrong password!'); window.location='my_account.php'</script>";
	}
	
}

?>
