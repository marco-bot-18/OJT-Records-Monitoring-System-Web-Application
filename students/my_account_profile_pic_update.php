<?php
require_once('includes/session.php');

date_default_timezone_set('Asia/Manila');
$timestamp = time();
$td = date("F d, Y");
$time = date("h:i:s A");

if (isset($_POST['btn_save_pic'])) 
{
	$id = $_SESSION['student_auto_id'];
	$stud_id = $_SESSION['student_id'];

	$file_ = date('YmdHis').$_FILES['my_profile_pic']['name']; 

	if(!empty($file_)){
		move_uploaded_file($_FILES['my_profile_pic']['tmp_name'], '../admin/uploaded_images/'.$file_);	
	}

	$sql = "UPDATE tbl_students SET image='$file_' WHERE id = '$id' and stud_id='$stud_id'";

	if($conn->query($sql)){
		$active = "active";
        $my_ID = $_SESSION['student_id'];
        $session_login = "You updated your profile picture";
        //log session
        $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_login', '$td', '$time', '$my_ID', '$active')";
        $query_log_run = mysqli_query($conn, $sql_log);
		if ($query_log_run) {
			$_SESSION['profile_pic_updated'] = "Profile Picture Updated Successfully!";
		}
	}
	else
	{
		echo "".$conn->error;
	}
	header('location: my_account.php');
}
?>