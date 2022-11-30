<?php
require_once('includes/session.php');
date_default_timezone_set('Asia/Manila');
$timestamp = time();
$date_ = date("F d, Y");
$time_ = date("h:i:s A");

if (isset($_POST['btn_save_pic'])) 
{
	$id = $_SESSION['coordinator_id'];
	$file_ = date('YmdHis').$_FILES['my_profile_pic']['name']; 

	if(!empty($file_)){
		move_uploaded_file($_FILES['my_profile_pic']['tmp_name'], '../admin/uploaded_images/'.$file_);	
	}

	$sql = "UPDATE tbl_coordinators SET image='$file_' WHERE coordinator_id = '$id'";
	// $sql = "INSERT INTO tbl_admin_accounts (image) VALUES('$file_')  WHERE id = '$id'";

	if($conn->query($sql)){
		$active = "active";
		$session_login = "You changed your profile picture";
		//log session
		$my_ID = $_SESSION['coordinator_id'];
		$sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_login', '$date_', '$time_', '$my_ID', '$active')";
		$query_log_run = mysqli_query($conn, $sql_log);
		if($query_log_run){
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