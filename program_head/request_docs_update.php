<?php
include 'includes/db_connect.php';
session_start();
date_default_timezone_set('Asia/Manila');
$timestamp = time();
$td = date("F d, Y");
$time = date("h:i:s A");
$date_time = $td." ".$time;
$isRead = 0;
$isRead1 = 1;

if (isset($_POST["forward_to_dean"])) {
	// code...
	//$file_location = "../students/upload_docs/";
	$file = $_POST['signed_document'];

	// ['name'];
	// $file_temp = $_FILES['signed_document']['tmp_name'];
	// $file_size = $_FILES['signed_document']['size'];

	$work_status = "semi-pending3";
	$id = $_POST['id'];
	$task_code = $_POST['task_code'];
	$requirement = $_POST['requirement'];
	$stud_fullname = $_POST['stud_fullname'];

	$status = "not archived";

	$program_head = "program head";

	$dean = "dean";

	$sql1 = "UPDATE tbl_students_work SET work_status='$work_status', send_to_PH='$program_head', send_to_Dean='$dean', uploaded_file='$file', isReadPH='$isRead1', isReadDean='$isRead', dean_forward_date='$date_time' WHERE id='$id' and task_code='$task_code'";

	$query_run1 = mysqli_query($conn, $sql1);

	if($query_run1)
	{
		$active = "active";
		$session_login = "You validated and forwarded the document (".$requirement.") of ".$stud_fullname;
		//log session
		$my_ID = $_SESSION['coordinator_id'];
		$sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_login', '$td', '$time', '$my_ID', '$active')";
		$query_log_run = mysqli_query($conn, $sql_log);
		if($query_log_run){
			$get_name_id = $_SESSION['coordinator_fname']." ".$_SESSION['coordinator_mname']." ".$_SESSION['coordinator_lname']." (".$_SESSION['coordinator_id'].")";

		    $userType = "Program Head";
		    $session_audit =  $get_name_id." validated and forwarded the document (".$requirement.") of ".$stud_fullname;
		    $sql_audit = "INSERT INTO tbl_audit_trail (activity, date_, time_, by_, status, userType) VALUES ('$session_audit', '$td', '$time', '$get_name_id', '$active', '$userType')";
		    $query_audit_run = mysqli_query($conn, $sql_audit);
		    if($query_audit_run){
				$_SESSION['forwarded'] = $stud_fullname. " document (". $requirement .") successfully forwarded to Dean";
		        header('location: request_docs_pending.php?forwardedSuccessfully');
		    }
	    }
	}
}

// else if(isset($_POST["reforward_to_dean"])) {

// 	$file = $_POST['signed_document'];
// 	$work_status = "semi-pending3";
// 	$id = $_POST['id'];
// 	$task_code = $_POST['task_code'];

// 	$status = "not archived";

// 	$program_head = "program head";

// 	$dean = "dean";

// 	$sql2 = "UPDATE tbl_students_work SET work_status='$work_status', send_to_PH='$program_head', send_to_Dean='$dean', uploaded_file='$file', isReadDean='$isRead', dean_forward_date='$date_time' WHERE id='$id' and task_code='$task_code'";

// 	$query_run2 = mysqli_query($conn, $sql2);

// 	if($query_run2)
// 	{
// 		//move_uploaded_file($file_temp, $file_location.$_FILES['signed_document']['name']);
//         header('location: request_docs_completed.php?reforwarded=1');
// 	}
// }


?>