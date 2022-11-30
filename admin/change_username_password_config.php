<!-- gawin yung archives (filtered by academic year, with retreive), audit logs, ayusin ang design, tas gawin na yung forgot password -->

<?php
require_once('includes/session.php');

date_default_timezone_set('Asia/Manila');
$timestamp = time();
$date_ = date("F d, Y");
$time_ = date("h:i:s A");

$current_uname = $_POST['uname'];
$new_uname = $_POST['new_uname'];
$current_pword = md5($_POST['current_pword']);
$new_pword = md5($_POST['new_pword']);
$confirm_pword = md5($_POST['confirm_pword']);
$id = $_SESSION['admin_id'];

$check_duplicate_username = "SELECT username FROM tbl_admin WHERE username='$new_uname'";
$res = mysqli_query($conn, $check_duplicate_username);
$count = mysqli_num_rows($res);

if($new_pword != $confirm_pword){
	$_SESSION['err_message'] = 'Password Does Not Matched!';
	header('location: my_account.php?=username&password=not-changed');
}
else {
	if ($current_pword == $_SESSION['admin_password']) {
		$sql = "UPDATE tbl_admin SET password='$new_pword' WHERE id='$id' AND password='$current_pword'";

		if($conn->query($sql)){
			$active = "active";
	        $session_log = "You changed your password";
	        $my_ID = $_SESSION['admin_username'];
	        $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_log', '$date_', '$time_', '$my_ID', '$active')";
	        $query_log_run = mysqli_query($conn, $sql_log);
	        if($query_log_run){
				$_SESSION['success_msg'] = "Your Password has Been Changed! Please Login Again To Confirm Changes!";
				//session_destroy();
				unset($_SESSION['admin_username']);
				header('location: ../index.php?=username&password=changed');
			}
		}
		//header('location: my_account.php?=username&password=changed');
	}
	else{
		$_SESSION['err_message'] = "Please Confirm Your Current Password!";
		header('location: my_account.php?=username&password=not-changed');
	}
}

?>