<?php
require_once('includes/session.php');

$current_uname = $_POST['uname'];
$current_pword = md5($_POST['current_pword']);
$new_pword = md5($_POST['new_pword']);
$confirm_pword = md5($_POST['confirm_pword']);
$id = $_SESSION['student_auto_id'];
$stud_id = $_SESSION['student_id'];

if($new_pword != $confirm_pword){
		$_SESSION['err_message'] = 'Password Does Not Matched!';
		header('location: my_account.php?=username&password=not-changed');
}
else {
	if ($current_pword == $_SESSION['student_password']) {
		$sql = "UPDATE tbl_students SET password='$new_pword' WHERE id='$id' AND stud_id='$stud_id' AND password='$current_pword'";
		if($conn->query($sql)){
			// header('location: my_account.php?updated=1');
			$_SESSION['success_msg'] = "Your Password has Been Changed! Please Login Again To Confirm Changes!";
			//session_destroy();
			unset($_SESSION['studentID']);
			header('location: ../index.php?=username&password=changed');
		}
		else{
		
		}
	}
	else{
		$_SESSION['err_message'] = "Current Password is Incorrect!";
		header('location: my_account.php?=incorrectCurrentPassword');
	}
}
?>