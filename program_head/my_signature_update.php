<?php 
error_reporting(0);
session_start();
require_once('includes/db_connect.php');

date_default_timezone_set('Asia/Manila');
$timestamp = time();
$td = date("F d, Y");
$time = date("h:i:s A");

if (isset($_POST['btn_save_pic'])) 
{
	$owner = $_SESSION['coordinator_fullname_session'];
	$file_ = date('YmdHis').$_FILES['my_signature_img']['name']; 

	if(!empty($file_)){
		move_uploaded_file($_FILES['my_signature_img']['tmp_name'], 'uploaded_signature_imgs/'.$file_);	
	}

	$sql = "UPDATE tbl_signature SET image='$file_' WHERE owner_signature='$owner'";
	// $sql = "INSERT INTO tbl_admin_accounts (image) VALUES('$file_')  WHERE id = '$id'";

	if($conn->query($sql)){
		$active = "active";
		$session_login = "You updated your e-signature";
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
				$_SESSION['signature_update'] = "Your Signature is Updated Successfully!";
			}
		}
	}
	else
	{
		echo "".$conn->error;
	}
	header('location: my_signature.php');
}
?>