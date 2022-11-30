<?php
session_start();
require_once 'includes/session.php';
require_once('includes/db_connect.php');

//date and time
date_default_timezone_set('Asia/Manila');
$timestamp = time();
$td = date("F d, Y");
$time = date("h:i:s A");

$my_password = md5($_POST['my_password']); //my account's password
$_stats = "archived";

$correct_password = $_SESSION['admin_password'];

if($my_password == $correct_password){
	$teacher = "teacher";
	$sql = "UPDATE tbl_coordinators set isArchived='$_stats' where userType='$teacher'";
	$res = $conn->query($sql);
	$three = 3;
	if($res){
		$active = "active";
        $my_ID = $_SESSION['admin_username'];
        $session_log = "You archived all the user account of teachers";
        $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_log', '$td', '$time', '$my_ID', '$active')";
        $query_log_run = mysqli_query($conn, $sql_log);
        if ($query_log_run) {
        	// $get_name_id = $_SESSION['admin_fname']." ".$_SESSION['admin_mname']." ".$_SESSION['admin_lname']." (".$_SESSION['admin_username'].")";

         //    $userType = "Dean";

         //    $session_audit =  $get_name_id." archived all the user account of teachers";
         //    $sql_audit = "INSERT INTO tbl_audit_trail (activity, date_, time_, by_, status, userType) VALUES ('$session_audit', '$td', '$time', '$get_name_id', '$active', '$userType')";
         //    $query_audit_run = mysqli_query($conn, $sql_audit);
         //    if($query_audit_run){
				$_SESSION['archived_all'] = "Success!";
				header('location: coordinators_account.php');
			//}
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
	$_SESSION['wrong_password'] = "Your password is not correct!";
	header('location: coordinators_account.php');

}
?>