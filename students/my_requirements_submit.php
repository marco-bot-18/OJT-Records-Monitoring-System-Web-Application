<?php
include 'includes/db_connect.php';
session_start();

if(isset($_POST["resubmit"])){
	//for time and date
	date_default_timezone_set('Asia/Manila');
	$timestamp = time();

	$date_submission = date('Y-m-d');
	$td = date("F d, Y");
	$time = date("h:i:s A");

	$task_code = $_POST['task_code']; 
	$id = $_POST['id'];

	$work_stats ="completed";

	$student_comment = $_POST['student_comment'];
	$title = $_POST['title'];
	$file_location = "upload_docs/";
	$my_file = $_FILES['my_file']['name'];
	$file_temp = $_FILES['my_file']['tmp_name'];
	$file_size = $_FILES['my_file']['size'];
	$edited_by_stud = "(edited)";
	$remarks = "waiting";

	$get_teacher = $_SESSION['student_teacher'];//get teacher's fullname


	$sql = "UPDATE tbl_students_work SET uploaded_file='$my_file', edited_by_student='$edited_by_stud', student_comment='$student_comment', remarks='$remarks' WHERE id='$id' and task_code='$task_code'";

	$query_run = mysqli_query($conn, $sql);

	if($query_run)
	{
		$active = "active";
        $my_ID = $_SESSION['student_id'];
        $my_teacher = $_SESSION['student_teacher'];
        $session_login = "You resubmitted a requirement entitled ".$title;
        //log session
        $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_login', '$td', '$time', '$my_ID', '$active')";
        $query_log_run = mysqli_query($conn, $sql_log);
		if ($query_log_run) {
			$get_name_id = $_SESSION['stud_fullname'];
            $userType = "Student";
            $session_audit = $get_name_id. " resubmitted a requirement entitled ".$title." to ".$get_teacher;
            $sql_audit = "INSERT INTO tbl_audit_trail (activity, date_, time_, by_, status, userType) VALUES ('$session_audit', '$td', '$time', '$get_name_id', '$active', '$userType')";
            $query_audit_run = mysqli_query($conn, $sql_audit);
	        if($query_audit_run){
				move_uploaded_file($file_temp, $file_location.$_FILES['my_file']['name']);
				$_SESSION['resubmitted'] = "Your requirement (".$title.") resubmitted successfully! Wait for your OJT Teachers Remarks. Make sure that your Requirement status is COMPLETED";
		        header('location: my_requirements_ongoing.php?resubmit');
		    }
		}
	}
}

else if (isset($_POST["submit"])){
	date_default_timezone_set('Asia/Manila');
	$timestamp = time();
	$td = date("F d, Y");
	$date_submission = date('Y-m-d');
	$time = date("h:i:s A");

	$task_code = $_POST['task_code'];
	$id = $_POST['id'];
	$title = $_POST['title'];
	$student_comment = $_POST['student_comment'];
	$remarks = "waiting";
	$work_stats ="semi-pending";
	$submitted = "yes";

	$file_location = "upload_docs/";
	$my_file = $_FILES['my_file']['name'];
	$file_temp = $_FILES['my_file']['tmp_name'];
	$file_size = $_FILES['my_file']['size'];

	// if (file_exists("upload_docs/". $_FILES['my_file']['name'])) {
	//     echo "<script> alert('File Name is Already Exists!'); window.location='my_requirements_pending.php'; </script>";

	// }
	$isRead = 0;
	$isRead1 = 1;
	//else {
	$sql = "UPDATE tbl_students_work SET uploaded_file='$my_file', remarks='$remarks', date_submitted='$td', time_submitted='$time', work_status='$work_stats', student_comment='$student_comment', date_submitted_1='$date_submission', isReadStud='$isRead1', submitted='$submitted', isReadTeacher='$isRead' WHERE id='$id' and task_code='$task_code'";

	$query_run = mysqli_query($conn, $sql);

	if($query_run)
	{
		$active = "active";
        $my_ID = $_SESSION['student_id'];
        $my_teacher = $_SESSION['student_teacher'];
        $session_login = "You submitted a requirement entitled ".$title; //activity
        //log session
        $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_login', '$td', '$time', '$my_ID', '$active')";
        $query_log_run = mysqli_query($conn, $sql_log);
		if ($query_log_run) {
			$get_name_id = $_SESSION['stud_fullname'];

            $userType = "Student";
            $session_audit = $get_name_id. " submitted a requirement entitled ".$title." to ".$get_teacher;
            $sql_audit = "INSERT INTO tbl_audit_trail (activity, date_, time_, by_, status, userType) VALUES ('$session_audit', '$td', '$time', '$get_name_id', '$active', '$userType')";
            $query_audit_run = mysqli_query($conn, $sql_audit);
	        if($query_audit_run){
				move_uploaded_file($file_temp, $file_location.$_FILES['my_file']['name']);
				$_SESSION['submitted'] = "Your requirement (".$title. ") submitted successfully! Wait for your OJT Teacher Remarks and Comments. Make sure that your requirement status is completed. Proceed to the submitted requirements.";
		        header('location: my_requirements_pending.php?submitted');
		    }
	    }
	}
	else{
		echo $conn->error();
	}
	//}
}

else if (isset($_POST["comment"])){
	$task_code = $_POST['task_code'];
	$id = $_POST['id'];
	$title = $_POST['title'];
	$student_comment = $_POST['student_comment'];

		$sql = "UPDATE tbl_students_work SET student_comment='$student_comment' WHERE id='$id' and task_code='$task_code'";

		$query_run = mysqli_query($conn, $sql);

		if($query_run)
		{
			move_uploaded_file($file_temp, $file_location.$_FILES['my_file']['name']);
			$_SESSION['comment'] = $title;
	        header('location: my_requirements_ongoing.php');
		}
	//}
}
?>