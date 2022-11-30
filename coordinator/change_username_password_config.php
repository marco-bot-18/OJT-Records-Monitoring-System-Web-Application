<?php
require_once('includes/session.php');

$current_pword = md5($_POST['current_pword']);
$new_pword = md5($_POST['new_pword']);
$confirm_pword = md5($_POST['confirm_pword']);
$id = $_SESSION['coordinator_id'];

if($new_pword != $confirm_pword){
	$_SESSION['err_message'] = 'Password Does Not Matched!';
	header('location: my_account.php?=username&password=not-changed');
}
else {
	if ($current_pword == $_SESSION['coordinator_password']) {
		$sql = "UPDATE tbl_coordinators SET password='$new_pword' WHERE coordinator_id='$id' AND password='$current_pword'";

		if($conn->query($sql)){
			$active = "active";
            $my_ID = $_SESSION['coordinator_id'];
            $session_log = "You updated your password";
            //log session
            $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_log', '$td', '$time', '$my_ID', '$active')";
            $query_log_run = mysqli_query($conn, $sql_log);
            if ($query_log_run) {
				$_SESSION['success_msg'] = "Your Password has Been Changed! Please Login Again To Confirm Changes!";
				//session_destroy();
				unset($_SESSION['coordinator_id']);
				header('location: ../index.php?=passwordchanged');
			}
		}
		else{
			$conn->error;
		}
		//header('location: my_account.php?=username&password=changed');
	}

	else{
		$_SESSION['err_message'] = "Your Password is Incorrect!";
		header('location: my_account.php?=username&password=not-changed');
	}
}

?>