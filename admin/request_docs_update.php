
<?php
include 'includes/db_connect.php';
session_start();

//PHPMAILER
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//date and time
date_default_timezone_set('Asia/Manila');
$timestamp = time();
$td = date("F d, Y");
$time = date("h:i:s A");
$date_time = $td." at ".$time;
$isRead = 0;
$isRead1 = 1;

$_myfullname = $_SESSION['MY_FULLNAME_AS_DEAN'];

$requirement = $_POST['requirement'];
$stud_fullname = $_POST['stud_fullname'];

if (isset($_POST["set_as_completed"])) {

	if($requirement == "Recommendation Letter") {

		$file = $_POST['signed_document'];
		$work_status = "completed";
		$id = $_POST['id'];
		$task_code = $_POST['task_code'];
		$status = "not archived";
		$program_head = "program head";
		$submitted = "Submitted";
		$dean = "dean";

		$sql1 = "UPDATE tbl_students_work SET work_status='$work_status', send_to_PH='$program_head', send_to_Dean='$dean', uploaded_file='$file', completed_date='$date_time', isReadTeacher1='$isRead', isReadStud1='$isRead', isReadDean='$isRead1', isReadDean1='$isRead' WHERE id='$id' and task_code='$task_code'";

		$query_run1 = mysqli_query($conn, $sql1);

		if($query_run1)
		{
			$sql11 = "UPDATE tbl_students SET recommendation_letter='submitted' where stud_fullname='$stud_fullname'";
			$query_run11 = mysqli_query($conn, $sql11);
			if($query_run11)
			{
				$sql_get_stud_name = "SELECT email FROM tbl_students WHERE stud_fullname='$stud_fullname'";
				$query_get_stud_name = $conn->query($sql_get_stud_name);
		        while($row2 = $query_get_stud_name->fetch_assoc()){
		        	$get_email = $row2['email'];
		        	try {
		                require '../vendor/autoload.php';
		                $mail = new  PHPMailer(true);
		                $mail->SMTPDebug = 1;                      //Enable verbose debug output
		                $mail->isSMTP();                                            //Send using SMTP
		                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
		                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
		                $mail->Username   = 'websiteet18@gmail.com';                     //SMTP username
		                $mail->Password   = 'empowermenttechnology';                               //SMTP password
		                $mail->SMTPSecure = "tls"; //Enable implicit TLS encryption
		                $mail->Port       = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

		                //Recipients
		                $mail->setFrom('websiteet18@gmail.com', $_myfullname);
		                $mail->addAddress($get_email);//Name is optional

		                //Content
		                $mail->isHTML(true);//Set email format to HTML
		                $mail->Subject = "e-OJT aCCeSs: Requirement Update";
		                $template    = "Your requirement <b>".$requirement."</b> status is now <b style='color: green;'>COMPLETED</b>. It is approved and signed by Program Head and Dean.</b>";
		                $mail->Body = $template;
		                $mail->send();
		                //echo 'Message has been sent';
		                header('location: my_stud_requirements_completed.php?updated=1');
		            }
		            catch(Exception $ex){
		                //echo $ex;
		            }
		        }
		        $active = "active";
				$session_log = "You approved the requirement of ".$stud_fullname." entitled ".$requirement." It is now in <b>COMPLETED</b> status";
				$my_ID = $_SESSION['admin_username'];
				$sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_log', '$td', '$time', '$my_ID', '$active')";
				$query_log_run = mysqli_query($conn, $sql_log);
				if($query_log_run){
					$get_name_id = $_SESSION['admin_fname']." ".$_SESSION['admin_mname']." ".$_SESSION['admin_lname']." (".$_SESSION['admin_username'].")";

				    $userType = "Dean";

				    $session_audit =  $get_name_id." approved the requirement of ".$stud_fullname." entitled ".$requirement." It is now in <b>COMPLETED</b> status";
				    $sql_audit = "INSERT INTO tbl_audit_trail (activity, date_, time_, by_, status, userType) VALUES ('$session_audit', '$td', '$time', '$get_name_id', '$active', '$userType')";
				    $query_audit_run = mysqli_query($conn, $sql_audit);
				    if($query_audit_run){
						$_SESSION['set_as_completed'] ="You set ".$stud_fullname." requirement (". $requirement .") COMPLETED in status!";
				        header('location: request_docs_pending.php');
				    }
			    }
	    	}
		}
		else{
			echo $conn->error;
		}
	}

	//restricted
	else if($requirement == "Resume") {

		$file_location = "../students/upload_docs/";
		$file = $_FILES['signed_document']['name'];
		$file_temp = $_FILES['signed_document']['tmp_name'];
		$file_size = $_FILES['signed_document']['size'];
		$work_status = "completed";
		$id = $_POST['id'];
		$task_code = $_POST['task_code'];
		$status = "not archived";
		$program_head = "program head";
		$submitted = "submitted";
		$dean = "dean";

		$sql2 = "UPDATE tbl_students_work SET work_status='$work_status', send_to_PH='$program_head', send_to_Dean='$dean', uploaded_file='$file', completed_date='$date_time', isReadTeacher1='$isRead', isReadStud1='$isRead' WHERE id='$id' and task_code='$task_code'";

		$query_run2 = mysqli_query($conn, $sql2);

		if($query_run2)
		{
			$sql22 = "UPDATE tbl_students SET resume='submitted' where stud_fullname='$stud_fullname'";
			$query_run22 = mysqli_query($conn, $sql22);
			if($query_run22)
			{
				$_SESSION['set_as_completed'] ="You set ".$stud_fullname." requirement (". $requirement .") status is now COMPLETED!";
				move_uploaded_file($file_temp, $file_location.$_FILES['signed_document']['name']);
		        header('location: request_docs_pending.php');
	    	}
		}
	}

	else if($requirement == "Memorandum of Agreement") {

		$file_location = "../students/upload_docs/";
		$file = $_FILES['signed_document']['name'];
		$file_temp = $_FILES['signed_document']['tmp_name'];
		$file_size = $_FILES['signed_document']['size'];
		$work_status = "completed";
		$id = $_POST['id'];
		$task_code = $_POST['task_code'];
		$status = "not archived";
		$program_head = "program head";
		$submitted = "submitted";
		$dean = "dean";

		$sql2 = "UPDATE tbl_students_work SET work_status='$work_status', send_to_PH='$program_head', send_to_Dean='$dean', uploaded_file='$file', completed_date='$date_time', isReadTeacher1='$isRead', isReadStud1='$isRead' WHERE id='$id' and task_code='$task_code'";

		$query_run2 = mysqli_query($conn, $sql2);

		if($query_run2)
		{
			$_SESSION['set_as_completed'] ="You set ".$stud_fullname." requirement (". $requirement .") status is now COMPLETED!";
			move_uploaded_file($file_temp, $file_location.$_FILES['signed_document']['name']);
	        header('location: request_docs_pending.php');
		}
	}

	else if($requirement == "Performance Sheet") {

		$file_location = "../students/upload_docs/";
		$file = $_FILES['signed_document']['name'];
		$file_temp = $_FILES['signed_document']['tmp_name'];
		$file_size = $_FILES['signed_document']['size'];
		$work_status = "completed";
		$id = $_POST['id'];
		$task_code = $_POST['task_code'];
		$status = "not archived";
		$program_head = "program head";
		$submitted = "submitted";
		$dean = "dean";

		$sql3 = "UPDATE tbl_students_work SET work_status='$work_status', send_to_PH='$program_head', send_to_Dean='$dean', uploaded_file='$file', completed_date='$date_time', isReadTeacher1='$isRead', isReadStud1='$isRead' WHERE id='$id' and task_code='$task_code'";

		$query_run3 = mysqli_query($conn, $sql3);

		if($query_run3)
		{
			$sql33 = "UPDATE tbl_students SET performance_sheet='submitted' where stud_fullname='$stud_fullname'";
			$query_run33 = mysqli_query($conn, $sql33);
			if($query_run33)
			{
				$_SESSION['set_as_completed'] ="You set ".$stud_fullname." requirement (". $requirement .") status is now COMPLETED!";
				move_uploaded_file($file_temp, $file_location.$_FILES['signed_document']['name']);
		        header('location: request_docs_pending.php');
	    	}
		}
	}

	else if($requirement == "Response Letter") {

		$file_location = "../students/upload_docs/";
		$file = $_FILES['signed_document']['name'];
		$file_temp = $_FILES['signed_document']['tmp_name'];
		$file_size = $_FILES['signed_document']['size'];
		$work_status = "completed";
		$id = $_POST['id'];
		$task_code = $_POST['task_code'];
		$status = "not archived";
		$program_head = "program head";
		$submitted = "submitted";
		$dean = "dean";

		$sql4 = "UPDATE tbl_students_work SET work_status='$work_status', send_to_PH='$program_head', send_to_Dean='$dean', response_letter='$submitted', uploaded_file='$file', completed_date='$date_time', isReadTeacher1='$isRead', isReadStud1='$isRead' WHERE id='$id' and task_code='$task_code'";

		$query_run4 = mysqli_query($conn, $sql4);

		if($query_run4)
		{
			$sql44 = "UPDATE tbl_students SET response_letter='submitted' where stud_fullname='$stud_fullname'";
			$query_run44 = mysqli_query($conn, $sql44);
			if($query_run44)
			{
				$_SESSION['set_as_completed'] ="You set ".$stud_fullname." requirement (". $requirement .") status is now COMPLETED!";
				move_uploaded_file($file_temp, $file_location.$_FILES['signed_document']['name']);
		        header('location: request_docs_pending.php');
	    	}
		}
	}

	else if($requirement == "Work Plan"){
		$file_location = "../students/upload_docs/";
		$file = $_FILES['signed_document']['name'];
		$file_temp = $_FILES['signed_document']['tmp_name'];
		$file_size = $_FILES['signed_document']['size'];
		$work_status = "completed";
		$id = $_POST['id'];
		$task_code = $_POST['task_code'];
		$status = "not archived";
		$program_head = "program head";
		$submitted = "submitted";
		$dean = "dean";

		$sql5 = "UPDATE tbl_students_work SET work_status='$work_status', send_to_PH='$program_head', send_to_Dean='$dean', uploaded_file='$file', completed_date='$date_time', isReadTeacher1='$isRead', isReadStud1='$isRead' WHERE id='$id' and task_code='$task_code'";

		$query_run5 = mysqli_query($conn, $sql5);

		if($query_run5)
		{
			$sql55 = "UPDATE tbl_students SET work_plan='submitted' where stud_fullname='$stud_fullname'";
			$query_run55 = mysqli_query($conn, $sql55);
			if($query_run55)
			{
				$_SESSION['set_as_completed'] ="You set ".$stud_fullname." requirement (". $requirement .") status is now COMPLETED!";
				move_uploaded_file($file_temp, $file_location.$_FILES['signed_document']['name']);
		        header('location: request_docs_pending.php');
	    	}
	    	else{
	    		echo $conn->error;
	    	}
		}
	}

	else if($requirement == "Narrative Report"){
		$file_location = "../students/upload_docs/";
		$file = $_FILES['signed_document']['name'];
		$file_temp = $_FILES['signed_document']['tmp_name'];
		$file_size = $_FILES['signed_document']['size'];
		$work_status = "completed";
		$id = $_POST['id'];
		$task_code = $_POST['task_code'];
		$status = "not archived";
		$program_head = "program head";
		$submitted = "submitted";
		$dean = "dean";

		$sql5 = "UPDATE tbl_students_work SET work_status='$work_status', send_to_PH='$program_head', send_to_Dean='$dean', uploaded_file='$file', completed_date='$date_time', isReadTeacher1='$isRead', isReadStud1='$isRead' WHERE id='$id' and task_code='$task_code'";

		$query_run5 = mysqli_query($conn, $sql5);

		if($query_run5)
		{
			$sql55 = "UPDATE tbl_students SET narrative='submitted' where stud_fullname='$stud_fullname'";
			$query_run55 = mysqli_query($conn, $sql55);
			if($query_run55)
			{
				$_SESSION['set_as_completed'] ="You set ".$stud_fullname." requirement (". $requirement .") status is now COMPLETED!";
				move_uploaded_file($file_temp, $file_location.$_FILES['signed_document']['name']);
		        header('location: request_docs_pending.php');
	    	}
	    	else{
	    		echo $conn->error;
	    	}
		}
	}
}

?>