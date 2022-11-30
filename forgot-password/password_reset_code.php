<?php
require_once '../includes/db_connect.php';
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


require '../vendor/autoload.php';

function send_password_reset($get_name, $get_email, $token)
{
	$mail = new PHPMailer(true);
	$mail->SMTPDebug = 3;                      //Enable verbose debug output
	$mail->isSMTP();                                            //Send using SMTP
	$mail->Host	= 'smtp.gmail.com';                     //Set the SMTP server to send through
	$mail->SMTPAuth = true;                                   //Enable SMTP authentication
	$mail->Username = 'websiteet18@gmail.com';                     //SMTP username
	$mail->Password = 'empowermenttechnology';                               //SMTP password
	$mail->SMTPSecure = "tls"; //Enable implicit TLS encryption
	$mail->Port = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

	//Recipients
	$mail->setFrom('websiteet18@gmail.com', "e-OJT aCCeSs");
	$mail->addAddress($get_email); //Name is optional

	//Content
	$mail->isHTML(true); //Set email format to HTML
	$mail->Subject = "Reset Password Message";
	$template    = "This is your password reset request link.</b><br>
    <a href='http://localhost/CCS-OJT-Records-Monitoring-System/forgot-password/password_change.php?token=$token&email=$get_email'>Click Here</a>. Please don't share this link to anyone!";
	$mail->Body = $template;
	$mail->send();
	echo 'Message has been sent';
}

if (isset($_POST['password_reset_link'])) {

	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$token = md5(rand());

	$check_email = "SELECT email FROM tbl_students WHERE email='$email' LIMIT 1 ";
	$check_email_run = 	mysqli_query($conn, $check_email);

	if (mysqli_num_rows($check_email_run) > 0) {
		$row = mysqli_fetch_array($check_email_run);
		$get_name = $row['fname'] . " " . $row['mname'] . " " . $row['lname'] . " " . $row['stud_id'];
		$get_email = $row['email'];

		$update_token = "UPDATE tbl_students set verify_token='$token' WHERE email='$email' LIMIT 1";
		$update_token_run = mysqli_query($conn, $update_token);

		if ($update_token_run) {
			send_password_reset($get_name, $get_email, $token);
			$_SESSION['email_sent_status'] = "Email verification for reset password has been sent!";
			header('location: forgot_password.php?=CheckYourEmailToResetYourPassword=Success!');
			exit(0);
		} else {
			echo $conn->error;
		}
	} else {
		$email = mysqli_real_escape_string($conn, $_POST['email']);
		$token = md5(rand());

		$check_email = "SELECT email FROM tbl_coordinators WHERE email='$email' LIMIT 1 ";
		$check_email_run = 	mysqli_query($conn, $check_email);

		if (mysqli_num_rows($check_email_run) > 0) {
			$row = mysqli_fetch_array($check_email_run);
			$get_name = $row['fname'] . " " . $row['mname'] . " " . $row['lname'] . " " . $row['coordinator_id'];
			$get_email = $row['email'];

			$update_token = "UPDATE tbl_coordinators set verify_token='$token' WHERE email='$email' LIMIT 1";
			$update_token_run = mysqli_query($conn, $update_token);

			if ($update_token_run) {
				send_password_reset($get_name, $get_email, $token);
				$_SESSION['email_sent_status'] = "Email verification for reset password has been sent!";
				header('location: forgot_password.php?=CheckYourEmailToResetYourPassword=Success!');
				exit(0);
			} else {
				echo $conn->error;
			}
		} else {
			$email = mysqli_real_escape_string($conn, $_POST['email']);
			$token = md5(rand());

			$check_email = "SELECT email FROM tbl_admin WHERE email='$email' LIMIT 1 ";
			$check_email_run = 	mysqli_query($conn, $check_email);

			if (mysqli_num_rows($check_email_run) > 0) {
				$row = mysqli_fetch_array($check_email_run);
				$get_name = $row['fname'] . " " . $row['mname'] . " " . $row['lname'] . " " . $row['username'];
				$get_email = $row['email'];

				$update_token = "UPDATE tbl_admin set verify_token='$token' WHERE email='$email' LIMIT 1";
				$update_token_run = mysqli_query($conn, $update_token);

				if ($update_token_run) {
					send_password_reset($get_name, $get_email, $token);
					$_SESSION['email_sent_status'] = "Email verification for reset password has been sent!";
					header('location: forgot_password.php?=CheckYourEmailToResetYourPassword=Success!');
					exit(0);
				} else {
					echo $conn->error;
				}
			} else {
				$_SESSION['invalid'] = "No Email Found!";
				header('location: forgot_password.php?=InvalidEmail');
				exit(0);
			}
		}
	}
}


if (isset($_POST['password_update'])) {
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$new_password = md5($_POST['new_password']);
	$confirm_password = md5($_POST['confirm_password']);

	$token = mysqli_real_escape_string($conn, $_POST['password_token']);

	if (!empty($token)) {
		if (!empty($email) && !empty($new_password) && !empty($confirm_password)) {
			//checking token is valid or not 
			$check_token = "SELECT verify_token FROM tbl_students WHERE verify_token='$token' LIMIT 1";
			$check_token_run = mysqli_query($conn, $check_token);

			if (mysqli_num_rows($check_token_run) > 0) {
				if ($new_password == $confirm_password) {
					$update_password = "UPDATE tbl_students SET password='$new_password' WHERE verify_token='$token' LIMIT 1";
					$update_password_run = mysqli_query($conn, $update_password);

					if ($update_password_run) {
						$_SESSION['success_msg'] = "Password Succesfully Recovered! Please Login To Validate Your Credentials.";
						//echo "<script>alert('Password Successfully change');</script>";
						header('location: ../index.php?=PasswordSuccessfullyReset');
						exit(0);
					} else {
						echo "<script>alert('Password did not update!');</script>";
						header('location: password_change.php?token=$token&email=$email');
						exit(0);
					}
				} else {
					$_SESSION['err'] = "Password Does Not Match!";
					header("location: password_change.php?token=$token&email=$email");
					exit(0);
				}
			} else {
				//checking token is valid or not 
				$check_token = "SELECT verify_token FROM tbl_coordinators WHERE verify_token='$token' LIMIT 1";
				$check_token_run = mysqli_query($conn, $check_token);

				if (mysqli_num_rows($check_token_run) > 0) {
					if ($new_password == $confirm_password) {
						$update_password = "UPDATE tbl_coordinators SET password='$new_password' WHERE verify_token='$token' LIMIT 1";
						$update_password_run = mysqli_query($conn, $update_password);

						if ($update_password_run) {
							$_SESSION['success_msg'] = "Password Succesfully Recovered! Please Login To Validate Your Credentials.";
							//echo "<script>alert('Password Successfully change');</script>";
							header('location: ../index.php?=PasswordSuccessfullyReset');
							exit(0);
						} else {
							echo "<script>alert('Password did not update!');</script>";
							header('location: password_change.php?token=$token&email=$email');
							exit(0);
						}
					} else {
						$_SESSION['err'] = "Password Does Not Match!";
						header("location: password_change.php?token=$token&email=$email");
						exit(0);
					}
				} else {
					//checking token is valid or not 
					$check_token = "SELECT verify_token FROM tbl_admin WHERE verify_token='$token' LIMIT 1";
					$check_token_run = mysqli_query($conn, $check_token);

					if (mysqli_num_rows($check_token_run) > 0) {
						if ($new_password == $confirm_password) {
							$update_password = "UPDATE tbl_admin SET password='$new_password' WHERE verify_token='$token' LIMIT 1";
							$update_password_run = mysqli_query($conn, $update_password);

							if ($update_password_run) {
								$_SESSION['success_msg'] = "Password Succesfully Recovered! Please Login To Validate Your Credentials.";
								//echo "<script>alert('Password Successfully change');</script>";
								header('location: ../index.php?=PasswordSuccessfullyReset');
								exit(0);
							} else {
								echo "<script>alert('Password did not update!');</script>";
								header('location: password_change.php?token=$token&email=$email');
								exit(0);
							}
						} else {
							$_SESSION['err'] = "Password Does Not Match!";
							header("location: password_change.php?token=$token&email=$email");
							exit(0);
						}
					} else {
						echo "<script>alert('invalid token');</script>";
						header("location: password_change.php?token=$token&email=$email");
						exit(0);
					}
				}
			}
		} else {
			echo "<script>alert('fill up all forms');</script>";
			header("location: password_change.php?token=$token&email=$email");
			exit(0);
		}
	} else {
		echo "<script>alert('no token available');</script>";
		header("location: password_change.php");
		exit(0);
	}
}
