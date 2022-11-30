<?php
require_once('includes/db_connect.php');

$get_id = $_GET['id'];
$pub_stats = "published";

//table tbl_announcement and tbl_announcement_receiver are connected, I normalize table by creating a seperate tables that is have a match-unique id for both tables

$sql = "UPDATE tbl_announcement SET publish_status='$pub_stats' where announcement_id = '$get_id'";

$res = $conn->query($sql); 
// use exec() because no results are returned
if($res){
	$sql1 = "UPDATE tbl_announcement_receiver SET publish_status='$pub_stats' where announcement_id = '$get_id'";
	$res1 = $conn->query($sql1);
	if($res){
		header('location: my_announcement_history.php?published=1');
	}
	else{
		echo $conn->error;
	}		
}
else {
	echo " ".$conn->error;
}
?>