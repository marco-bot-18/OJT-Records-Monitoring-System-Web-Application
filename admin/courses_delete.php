<?php 
	session_start();
	include 'includes/db_connect.php';

	//date and time
	date_default_timezone_set('Asia/Manila');
	$timestamp = time();
	$td = date("F d, Y");
	$time = date("h:i:s A");

	$id = $_GET['id'];
	$archived = "archived";

	$sql = "UPDATE tbl_courses SET archived='$archived' WHERE id='$id'";
	$query_run = mysqli_query($conn, $sql);

	if($query_run) {
		$active = "active";
        $my_ID = $_SESSION['admin_username'];
        $session_log = "You SET a course, year and section to NOT ACTIVE";
        //log session
        $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_log', '$td', '$time', '$my_ID', '$active')";
        $query_log_run = mysqli_query($conn, $sql_log);
        if ($query_log_run) {
	        $_SESSION['success2'] = "Set as Not Active";
	        header('location: courses.php');
	    }
    }
    else {
    	echo $conn->error;
    }

?>