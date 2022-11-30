<?php 
	session_start();
	include 'includes/db_connect.php';

	$id = $_POST['id'];
	$description = $_POST['course_description'];

	$sql = "UPDATE tbl_courses SET course_description='$description' WHERE id='$id'";
	$query_run = mysqli_query($conn, $sql);

	if($query_run) {
		$active = "active";
        $my_ID = $_SESSION['admin_username'];
        $session_log = "You updated a course, year and section <b>".$description."</b>";
        //log session
        $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_log', '$td', '$time', '$my_ID', '$active')";
        $query_log_run = mysqli_query($conn, $sql_log);
        if ($query_log_run) {
	        $_SESSION['success1'] = $description;
	        header('location: courses.php');
	    }
    }
    else {
    	echo $conn->error;
    }

?>