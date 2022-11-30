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
$coordinator_uniq_id = $_POST['coordinator_uniq_id']; //student auto generated uniq id
$coordinator_id = $_POST['coordinator_id']; //student id
$my_password = md5($_POST['my_password']); //my account's password
$_stats = "archived";

$correct_password = $_SESSION['admin_password'];

if($my_password == $correct_password){
	$sql = "UPDATE tbl_coordinators set isArchived='$_stats' where coordinator_id='$coordinator_id'";
	$res = $conn->query($sql);
	if($res){
		$active = "active";
        $my_ID = $_SESSION['admin_username'];
        $session_log = "You archived the account of ".$full_name_and_id;
        //log session
        $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_log', '$td', '$time', '$my_ID', '$active')";
        $query_log_run = mysqli_query($conn, $sql_log);
        if ($query_log_run) {
			$_SESSION['archived'] = $full_name_and_id;
			header('location: program_head_account.php');
		}		
	}
	else {
		echo $conn->error;
	}
}
else{
	$_SESSION['wrong_password'] = "Your Password is Incorrect!";
	header('location: program_head_account.php');

}
?>