<?php
session_start();
require_once 'includes/session.php';
require_once('includes/db_connect.php');

//date and time
date_default_timezone_set('Asia/Manila');
$timestamp = time();
$td = date("F d, Y");
$time = date("h:i:s A");

$full_name_and_id = $_POST['fullname_id'];
$stud_id = $_POST['stud_id'];
$teacher = $_POST['teacher'];
$section = $_POST['section'];
$acad_yr_sem = $_POST['acad_yr_sem'];
$my_password = md5($_POST['my_password']);
$isArchived = "not archive";
$not_submitted = "not submitted";
$not_applicable = "not applicable";
$correct_password = $_SESSION['admin_password'];
$blank = "";

if ($my_password == $correct_password) {
	$sql = "UPDATE tbl_students SET coordinator='$teacher', category_desc='$blank', remarks='$blank', course='$section', academic_yr_semester='$acad_yr_sem', recommendation_letter='$not_submitted', resume='$not_submitted', moa='$not_submitted', response_letter='$not_submitted', accomplishment_report='$not_submitted', performance_sheet='$not_submitted', narrative='$not_submitted', endorsement_letter='$not_submitted', work_plan='$not_submitted', archived='$isArchived', your_teacher_uniq_id='$blank' WHERE stud_id='$stud_id'";
	$query_run = mysqli_query($conn, $sql);

	if ($query_run) {
		$active = "active";
		$session_log = "You retrieved the student user account of <b>" . $full_name_and_id . "</b>. The OJT teacher you assigned is <b>" . $teacher . "</b> and course, year and section is " . $section;
		$my_ID = $_SESSION['admin_username'];
		$sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_log', '$td', '$time', '$my_ID', '$active')";
		$query_log_run = mysqli_query($conn, $sql_log);

		if ($query_log_run) {
			$get_name_id = $_SESSION['admin_fname'] . " " . $_SESSION['admin_mname'] . " " . $_SESSION['admin_lname'] . " (" . $_SESSION['admin_username'] . ")";

			$userType = "Dean";

			$session_audit =  $get_name_id . " retrieved the student user account of <b>" . $full_name_and_id . "</b>. The OJT teacher you assigned is <b>" . $teacher . "</b> and course, year and section is " . $section;
			$sql_audit = "INSERT INTO tbl_audit_trail (activity, date_, time_, by_, status, userType) VALUES ('$session_audit', '$td', '$time', '$get_name_id', '$active', '$userType')";
			$query_audit_run = mysqli_query($conn, $sql_audit);
			if ($query_audit_run) {
				$_SESSION['retrieved'] = $full_name_and_id;
				header('location: students_accounts_archives.php');
			}
		}
	} else {
		echo $conn->error;
	}
} else {
	$_SESSION['wrong_password'] = "Your Password is Incorrect!";
	header('location: students_accounts_archives.php');
}
