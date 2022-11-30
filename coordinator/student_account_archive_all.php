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
$stud_uniq_id = $_POST['stud_uniq_id']; //student auto generated uniq id
$stud_id = $_POST['stud_id']; //student id
$my_password = md5($_POST['my_password']); //my accpunt's password
$_stats = "archived";

$correct_password = $_SESSION['coordinator_password'];
$term = $_SESSION['coordinator_acad_yr_sem'];
if($my_password == $correct_password){
	$sql = "UPDATE tbl_students set archived='$_stats' where academic_yr_semester='$term'";
	$res = $conn->query($sql);
	$three = 3;
	if($res){
		$sql1 = "UPDATE tbl_students_work set status='$_stats', isReadStud='$three'";
		$res1 = $conn->query($sql1);
		if ($res1) {
			$active = "active";
            $my_ID = $_SESSION['coordinator_id'];
            $session_log = "You archive all the accounts of your students";
            //log session
            $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_log', '$td', '$time', '$my_ID', '$active')";
            $query_log_run = mysqli_query($conn, $sql_log);
            if ($query_log_run) {
            	$get_name_id = $_SESSION['coordinator_fname']." ".$_SESSION['coordinator_mname']." ".$_SESSION['coordinator_lname']." (".$_SESSION['coordinator_id'].")";

			    $userType = "Teacher";
			    $session_audit = $get_name_id. " archived all the accounts of his/her students";
			    $sql_audit = "INSERT INTO tbl_audit_trail (activity, date_, time_, by_, status, userType) VALUES ('$session_audit', '$td', '$time', '$get_name_id', '$active', '$userType')";
			    $query_audit_run = mysqli_query($conn, $sql_audit);
			    if($query_audit_run){
					$_SESSION['archived'] = $full_name_and_id;
					header('location: student_account.php');
				}
			}
		}
		else{
			$conn->error;
		}		
	}
	else {
		echo $conn->error;
	}
}
else{
	$_SESSION['wrong_password'] = "Your Password is Incorrect!";
	header('location: student_account.php');

}
?>