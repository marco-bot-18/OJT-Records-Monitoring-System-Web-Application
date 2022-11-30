<?php
session_start();
require_once('includes/db_connect.php');

$get_id = $_GET['code'];

$_stats = "archived";

$sql = "UPDATE tbl_coordinator_save_works set status='$_stats' where task_code='$get_id'";

$res = $conn->query($sql);
$three = 3;

if($res){
	$sql1 = "UPDATE tbl_students_work set status='$_stats', isReadStud='$three' where task_code='$get_id'";
	$res1 = $conn->query($sql1);
	if ($res1) {
		$_SESSION['deleted'] = "Removed";
		header('location: my_requirements_for_students_history.php');
	}
	else{
		$conn->error;
	}		
}
else {
	echo $conn->error;
}
?>