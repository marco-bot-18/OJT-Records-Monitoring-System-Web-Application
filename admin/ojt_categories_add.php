<?php
include 'includes/db_connect.php';
session_start();

//date and time
date_default_timezone_set('Asia/Manila');
$timestamp = time();
$td = date("F d, Y");
$time = date("h:i:s A");

$category = $_POST['category'];
$description = $_POST['description'];
$remarks = $_POST['remarks'];
$stats = "not archive";

$sql = "INSERT INTO tbl_ojt_categories(categories, description, remarks, status) VALUES ('$category', '$description', '$remarks', '$stats')";

$query_run = mysqli_query($conn, $sql);

if($query_run)	{
	$active = "active";
    $my_ID = $_SESSION['admin_username'];
    $session_log = "You created an OJT category: <b>".$category."</b>";
    //log session
    $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_log', '$td', '$time', '$my_ID', '$active')";
    $query_log_run = mysqli_query($conn, $sql_log);
    if ($query_log_run) {
    	$_SESSION['success'] = $category;
		header('location: ojt_categories.php');
	}
}

else {
	$conn->error;	
}
?>