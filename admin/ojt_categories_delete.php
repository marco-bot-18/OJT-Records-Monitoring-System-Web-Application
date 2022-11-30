<?php
require_once('includes/db_connect.php');
session_start();

//date and time
date_default_timezone_set('Asia/Manila');
$timestamp = time();
$td = date("F d, Y");
$time = date("h:i:s A");

$get_id = $_GET['id'];
$stats = "archive";

// sql to delete a record
$sql = "UPDATE tbl_ojt_categories SET status='$stats' where id = '$get_id'";

$res = $conn->query($sql); 
// use exec() because no results are returned

if($res){
	$active = "active";
    $my_ID = $_SESSION['admin_username'];
    $session_log = "You removed an OJT category";
    //log session
    $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_log', '$td', '$time', '$my_ID', '$active')";
    $query_log_run = mysqli_query($conn, $sql_log);
    if ($query_log_run) {
		$_SESSION['deleted'] = "Deleted!";
		header('location: ojt_categories.php?deleted=$id');
	}			
}
else {
	"<script> alert('Error!'); window.location='ojt_categories.php'</script>";
}
?>