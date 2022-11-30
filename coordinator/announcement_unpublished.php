<?php
require_once('includes/db_connect.php');
session_start();

$get_id = $_GET['id'];
$pub_stats = "unpublished";

// sql to delete a record
$sql = "UPDATE tbl_announcement SET publish_status='$pub_stats' where announcement_id = '$get_id'";

$res = $conn->query($sql); 
// use exec() because no results are returned
if($res){
	$sql1 = "UPDATE tbl_announcement_receiver SET publish_status='$pub_stats' where announcement_id = '$get_id'";
	$res1 = $conn->query($sql1);
	if($res){
		$_SESSION['unpublished'] = "Announcement has been set in private!";
		header('location: announcements_history.php');
	}
	else{
		echo $conn->error;
	}		
}
else {
	echo " ".$conn->error;
}
?>