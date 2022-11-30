<?php
require_once('includes/session.php');
//error_reporting(0);
session_start();


date_default_timezone_set('Asia/Manila');
$timestamp = time();
$td = date("F d, Y");
$time = date("h:i:s A");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$auto_id = $_SESSION['student_auto_id']; //auto generate id
	$stud_id = $_SESSION['student_id']; //student id
	$email = $_POST['email'];
	$contact = $_POST['contact'];
	$gender = $_POST['gender'];
	$civil_stats = $_POST['civil_status'];
	$bday = $_POST['bday'];
	$address = ucwords($_POST['address']);

	$pword = md5($_POST['pword']);

	$mypassword = $_SESSION['student_password'];

	if($pword==$my_password){

		$sql = "UPDATE tbl_students SET email='$email', gender='$gender', civil_status='$civil_stats', bday='$bday', contact='$contact', address='$address' WHERE id='$auto_id' AND stud_id='$stud_id' AND password='$pword'";
		if($conn->query($sql)){
			$active = "active";
	        $my_ID = $_SESSION['student_id'];
	        $session_login = "You updated your personal information";
	        //log session
	        $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_login', '$td', '$time', '$my_ID', '$active')";
	        $query_log_run = mysqli_query($conn, $sql_log);
			if ($query_log_run) {
				$_SESSION['success_msg'] = "Information Updated Successfully!";
			}
		}
	}
	else
	{
		$_SESSION['err_message'] = "Incorrect Password!";
		//echo "<script> alert('Wrong password!'); window.location='my_account.php'</script>";
	}
	header('location: my_account.php');
}

?>
