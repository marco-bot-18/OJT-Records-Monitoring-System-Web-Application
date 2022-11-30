<?php 
require_once('includes/session.php');
//error_reporting(0);
session_start();

//date and time
date_default_timezone_set('Asia/Manila');
$timestamp = time();
$td = date("F d, Y");
$time = date("h:i:s A");

if (isset($_POST['btn_save_pic'])) 
{
	$userType = "Dean";
	$file_ = date('YmdHis').$_FILES['my_signature_img']['name']; 

	if(!empty($file_)){
		move_uploaded_file($_FILES['my_signature_img']['tmp_name'], 'uploaded_signature_imgs/'.$file_);
	}

	$sql = "UPDATE tbl_signature SET image='$file_' WHERE owner_signature='$userType'";
	// $sql = "INSERT INTO tbl_admin_accounts (image) VALUES('$file_')  WHERE id = '$id'";

	if($conn->query($sql)){
		$active = "active";
        $my_ID = $_SESSION['admin_username'];
        $session_log = "You updated your e-signature";
        //log session
        $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_log', '$td', '$time', '$my_ID', '$active')";
        $query_log_run = mysqli_query($conn, $sql_log);
        if ($query_log_run) {
			$_SESSION['signature_update'] = "Your Signature is Updated Successfully!";
			header('location: my_signature.php');
		}
	}
	else{
		echo "".$conn->error;
	}
}
?>