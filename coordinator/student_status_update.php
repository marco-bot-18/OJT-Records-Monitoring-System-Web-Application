<?php
require_once('includes/db_connect.php');
require_once('includes/session.php');

date_default_timezone_set('Asia/Manila');
$timestamp = time();
$td = date("F d, Y");
$time = date("h:i:s A");

if (isset($_POST['update_status'])) {
	$id = $_POST['id'];
	$stud_status = $_POST['stud_status'];
	$stud_fullname = $_POST['stud_fullname'];

	$sql = "UPDATE tbl_students SET status='$stud_status' WHERE id = '$id' ";

	$query_run = mysqli_query($conn, $sql);

	if ($query_run) {
		$my_ID = $_SESSION['coordinator_id'];

		$session_log = "You set the status of " . $stud_fullname . " as " . $stud_status . "";
		//log session
		$sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_log', '$td', '$time', '$my_ID', '$active')";
		$query_log_run = mysqli_query($conn, $sql_log);

		if ($query_log_run) {
			$get_name_id = $_SESSION['coordinator_fname'] . " " . $_SESSION['coordinator_mname'] . " " . $_SESSION['coordinator_lname'] . " (" . $_SESSION['coordinator_id'] . ")";
			$userType = "Teacher";
			$session_audit = $get_name_id . " set the status of " . $stud_fullname . " as " . $stud_status . "";
			$sql_audit = "INSERT INTO tbl_audit_trail (activity, date_, time_, by_, status, userType) VALUES ('$session_audit', '$td', '$time', '$get_name_id', '$active', '$userType')";
			$query_audit_run = mysqli_query($conn, $sql_audit);
			if ($query_audit_run) {
				$_SESSION['status_updated'] = $session_log;
				header('location: students_list.php?id=N' . $id);
			}
		}
	}
}
