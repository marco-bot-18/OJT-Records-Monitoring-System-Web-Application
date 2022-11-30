<?php
require_once('includes/db_connect.php');
session_start();
if (isset($_POST['update'])) 
{
	date_default_timezone_set('Asia/Manila');
	$timestamp = time();
	$td = date("F d, Y");
	$time = date("h:i:s A");

	$number = uniqid();
    $varray = str_split($number);
    $len = sizeof($varray);
    $otp = array_slice($varray, $len-3, $len);
    $otp = implode(",", $otp);
    $otp = str_replace(',', '', $otp."-");

	$task_code = $_POST['task_code'];
	$title = $_POST['tasks_title'];
	$instructions = $_POST['instructions'];
	$duedate = $_POST['duedate'];
	$edited = "(edited)";
	
	$sample_file = $_FILES['sample_file']['name'];
	if($_FILES['sample_file']['name'] != "") {
		$sample_file = $otp.basename($_FILES['sample_file']['name']);
	}
	else{
		$sample_file = basename($_FILES['sample_file']['name']);
	}

		$sql = "UPDATE tbl_coordinator_save_works SET title='$title', instructions='$instructions', date_of_submission='$duedate', edited='$edited', sample_file='$sample_file' WHERE task_code = '$task_code' ";

		$query_run = mysqli_query($conn, $sql);

		if($query_run)
		{
			$sql1 = "UPDATE tbl_students_work SET title='$title', instructions='$instructions', date_of_submission='$duedate', edited='$edited', sample_file='$sample_file' WHERE task_code = '$task_code' ";

			$query_run1 = mysqli_query($conn, $sql1);

			if($query_run1)
			{
				$active = "active";
		        $my_ID = $_SESSION['coordinator_id'];
		        $session_log = "You modified the details of the requirement entitled ".$requirement;
		        //log session
		        $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_log', '$td', '$time', '$my_ID', '$active')";
		        $query_log_run = mysqli_query($conn, $sql_log);
		        if ($query_log_run) {
		        	$get_name_id = $_SESSION['coordinator_fname']." ".$_SESSION['coordinator_mname']." ".$_SESSION['coordinator_lname']." (".$_SESSION['coordinator_id'].")";

                    $userType = "Teacher";
                    $session_audit = $get_name_id. " modified the details of the requirement entitled ".$requirement;
                    $sql_audit = "INSERT INTO tbl_audit_trail (activity, date_, time_, by_, status, userType) VALUES ('$session_audit', '$td', '$time', '$get_name_id', '$active', '$userType')";
                    $query_audit_run = mysqli_query($conn, $sql_audit);
                    if($query_audit_run){
						move_uploaded_file($_FILES['sample_file']['tmp_name'], "../admin/upload_docs/".$sample_file);
						$_SESSION['updated'] = $title;
						header('location: my_requirements_for_students_history.php');
					}
				}
			}
		}
		else
		{
			echo $conn->error;
		}
	//}
}

?>