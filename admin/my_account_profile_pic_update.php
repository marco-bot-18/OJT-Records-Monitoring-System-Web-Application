<?php
require_once('includes/session.php');

//date and time
date_default_timezone_set('Asia/Manila');
$timestamp = time();
$td = date("F d, Y");
$time = date("h:i:s A");

if (isset($_POST['btn_save_pic'])) 
{
	$id = $_SESSION['admin_id'];
	$file_ = date('YmdHis').$_FILES['my_profile_pic']['name']; 

	if(!empty($file_)){
		move_uploaded_file($_FILES['my_profile_pic']['tmp_name'], 'uploaded_images/'.$file_);	
	}

	$sql = "UPDATE tbl_admin SET image='$file_' WHERE id = '$id'";
	// $sql = "INSERT INTO tbl_admin_accounts (image) VALUES('$file_')  WHERE id = '$id'";

	if($conn->query($sql)){
		$active = "active";
        $my_ID = $_SESSION['admin_username'];
        $session_log = "You changed your profile picture";
        //log session
        $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_log', '$td', '$time', '$my_ID', '$active')";
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
