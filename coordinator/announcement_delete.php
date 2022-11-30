<?php
session_start();
require_once('includes/db_connect.php');

$get_id = $_GET['id'];

$_stats = "archived";

$sql = "UPDATE tbl_announcement set status='$_stats' where announcement_id = '$get_id'";
$res = $conn->query($sql); 

if($res){
	$sql1 = "UPDATE tbl_announcement_receiver set status='$_stats' where announcement_id = '$get_id'";
	$res1 = $conn->query($sql1);
	if ($res1) {
		$_SESSION['deleted'] = "Announcement was removed!";
		header('location: announcements_history.php');
	}
	else{

	}		
}
else {
	echo $conn->error;
}
?>