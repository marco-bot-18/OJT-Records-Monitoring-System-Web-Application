<?php
require_once('includes/db_connect.php');
session_start();

date_default_timezone_set('Asia/Manila');
$timestamp = time();
$td = date("F d, Y");
$time = date("h:i:s A");

if (isset($_POST['update'])) 
{	
	$id = $_POST['id'];
	$category = $_POST['category'];
	$description = $_POST['description'];
	$remarks = $_POST['remarks'];

	$sql = "UPDATE tbl_ojt_categories SET categories='$category', description='$description', remarks='$remarks' WHERE id = '$id'";

	$query_run = mysqli_query($conn, $sql);

	if($query_run)
	{
		$active = "active";
	    $my_ID = $_SESSION['admin_username'];
	    $session_log = "You updated an OJT category details";
	    //log session
	    $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_log', '$td', '$time', '$my_ID', '$active')";
	    $query_log_run = mysqli_query($conn, $sql_log);
	    if ($query_log_run) {
	    	$_SESSION['updated'] = "Updated!";
			header('location: ojt_categories.php?=CategoryUpdated');
		}
	}
	else
	{
		echo $conn->error;
	}
}

?>