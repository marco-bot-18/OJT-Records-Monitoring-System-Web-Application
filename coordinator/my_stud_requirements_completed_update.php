
<!-- ayusin yung design neto tas gawin na yung user logs, archives (filtered by academic year and semester, archives) tas yung sa email notif kapag nagsend ng requirement, tapos yung dropdown filter by  -->

<?php
include 'includes/db_connect.php';
include 'includes/session.php';

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

$myfullname_ = $_SESSION['coordinator_fullname_session'];

$id = $_POST['id'];
$task_code = $_POST['task_code'];
$stud_fullname = $_POST['stud_fullname'];
$remarks = $_POST['remarks'];
$comments = $_POST['comments'];
$requirement = $_POST['requirement'];

if (isset($_POST["submit"])) {
	// code...
	$isRead1 = 1;
	$sql = "UPDATE tbl_students_work SET remarks='$remarks', comment='$comments', isReadTeacher='$isRead1' WHERE id='$id' and task_code='$task_code'";

	$query_run = mysqli_query($conn, $sql);

	if($query_run)
	{
		if($remarks == "Not Approved"){
			//magsend sa email
			$sql_get_stud_name = "SELECT email FROM tbl_students WHERE stud_fullname='$stud_fullname'";
			$query_get_stud_name = $conn->query($sql_get_stud_name);
	        while($row2 = $query_get_stud_name->fetch_assoc()){
	        	$get_email = $row2['email'];
	        	try {
	                require '../vendor/autoload.php';
	                $mail = new  PHPMailer(true);
	                $mail->SMTPDebug = 0;                      //Enable verbose debug output
	                $mail->isSMTP();                                            //Send using SMTP
	                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
	                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
	                $mail->Username   = 'websiteet18@gmail.com';                     //SMTP username
	                $mail->Password   = 'empowermenttechnology';                               //SMTP password
	                $mail->SMTPSecure = "tls"; //Enable implicit TLS encryption
	                $mail->Port       = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

	                //Recipients
	                $mail->setFrom('websiteet18@gmail.com', $myfullname_);
	                $mail->addAddress($get_email);//Name is optional

	                //Content
	                $mail->isHTML(true);//Set email format to HTML
	                $mail->Subject = "e-OJT aCCeSs: Requirement Update";
	                $template    = "<p style=''>Your OJT teacher's remarks in your requirement entitled <b>".$requirement."</b> are <b style='color: red;'>NOT APPROVED</b>. Please re-submit your requirement again. Thank you!</p>";
	                $mail->Body = $template;
	                $mail->send();
	                //echo 'Message has been sent';
	                //header('location: my_stud_requirements_completed.php?updated=1');
	            }
	            catch(Exception $ex){
	                //echo $ex;
	            }
	        }
	        $active = "active";
	        $my_ID = $_SESSION['coordinator_id'];
	        $session_log = "You set the remarks in the requirement of ".$stud_fullname." entitled ".$requirement." in <b>NOT APPROVED</b>.";
	        //log session
	        $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_log', '$td', '$time', '$my_ID', '$active')";
	        $query_log_run = mysqli_query($conn, $sql_log);
	        if ($query_log_run) {
	        	$get_name_id = $_SESSION['coordinator_fname']." ".$_SESSION['coordinator_mname']." ".$_SESSION['coordinator_lname']." (".$_SESSION['coordinator_id'].")";

                $userType = "Teacher";
                $session_audit = $get_name_id. " set the remarks in the requirement of ".$stud_fullname." entitled ".$requirement." in <b>NOT APPROVED</b>.";
                $sql_audit = "INSERT INTO tbl_audit_trail (activity, date_, time_, by_, status, userType) VALUES ('$session_audit', '$td', '$time', '$get_name_id', '$active', '$userType')";
                $query_audit_run = mysqli_query($conn, $sql_audit);
                if($query_audit_run){
					$_SESSION['submitted_1'] = "You already responsed to ".$stud_fullname." requirement (". $requirement .") ! Your remarks is NOT APPROVED.";
					header("Location: my_stud_requirements_completed.php");
					exit;
				}
			}
		}
		else{
			$active = "active";
	        $my_ID = $_SESSION['coordinator_id'];
	        $session_log = "You set the remarks in the requirement of ".$stud_fullname." entitled ".$requirement." in <b>APPROVED</b>.";
	        //log session
	        $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_log', '$td', '$time', '$my_ID', '$active')";
	        $query_log_run = mysqli_query($conn, $sql_log);
	        if ($query_log_run) {
	        	$get_name_id = $_SESSION['coordinator_fname']." ".$_SESSION['coordinator_mname']." ".$_SESSION['coordinator_lname']." (".$_SESSION['coordinator_id'].")";

                $userType = "Teacher";
                $session_audit = $get_name_id. " set the remarks in the requirement of ".$stud_fullname." entitled ".$requirement." in <b>APPROVED</b>.";
                $sql_audit = "INSERT INTO tbl_audit_trail (activity, date_, time_, by_, status, userType) VALUES ('$session_audit', '$td', '$time', '$get_name_id', '$active', '$userType')";
                $query_audit_run = mysqli_query($conn, $sql_audit);
                if($query_audit_run){
					$_SESSION['submitted_1'] = "You already responsed to ".$stud_fullname." requirement (". $requirement .") ! Your remarks is APPROVED. You can be able now to forward the document in PROGRAM HEAD or set the requirement as COMPLETED.";
					header("Location: my_stud_requirements_completed.php");
					exit;
				}
			}
		}
	}
}

//for details of submitted requirements
else if (isset($_POST["submit_1"])) {
	// code...
	$sql = "UPDATE tbl_students_work SET remarks='$remarks', comment='$comments', isReadTeacher='$isRead1' WHERE id='$id' and task_code='$task_code'";

	$query_run = mysqli_query($conn, $sql);

	if($query_run)
	{
		if($remarks == "Not Approved"){
			//magsend sa email
			$sql_get_stud_name = "SELECT email FROM tbl_students WHERE stud_fullname='$stud_fullname'";
			$query_get_stud_name = $conn->query($sql_get_stud_name);
	        while($row2 = $query_get_stud_name->fetch_assoc()){
	        	$get_email = $row2['email'];
	        	try {
	                require '../vendor/autoload.php';
	                $mail = new  PHPMailer(true);
	                $mail->SMTPDebug = 0;                      //Enable verbose debug output
	                $mail->isSMTP();                                            //Send using SMTP
	                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
	                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
	                $mail->Username   = 'websiteet18@gmail.com';                     //SMTP username
	                $mail->Password   = 'empowermenttechnology';                               //SMTP password
	                $mail->SMTPSecure = "tls"; //Enable implicit TLS encryption
	                $mail->Port       = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

	                //Recipients
	                $mail->setFrom('websiteet18@gmail.com', $myfullname_);
	                $mail->addAddress($get_email);//Name is optional

	                //Content
	                $mail->isHTML(true);//Set email format to HTML
	                $mail->Subject = "e-OJT aCCeSs: Requirement Update";
	                $template    = "<p style=''>Your OJT teacher's remarks in your requirement entitled <b>".$requirement."</b> are <b style='color: red;'>NOT APPROVED</b>. Please re-submit your requirement again. Thank you!</p>";
	                $mail->Body = $template;
	                $mail->send();
	                //echo 'Message has been sent';
	                //header('location: my_stud_requirements_completed.php?updated=1');
	            }
	            catch(Exception $ex){
	                //echo $ex;
	            }
	        }
	        $active = "active";
	        $my_ID = $_SESSION['coordinator_id'];
	        $session_log = "You set the remarks in the requirement of ".$stud_fullname." entitled ".$requirement." in <b>NOT APPROVED</b>.";
	        //log session
	        $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_log', '$td', '$time', '$my_ID', '$active')";
	        $query_log_run = mysqli_query($conn, $sql_log);
	        if ($query_log_run) {
	        	$get_name_id = $_SESSION['coordinator_fname']." ".$_SESSION['coordinator_mname']." ".$_SESSION['coordinator_lname']." (".$_SESSION['coordinator_id'].")";

                $userType = "Teacher";
                $session_audit = $get_name_id. " set the remarks in the requirement of ".$stud_fullname." entitled ".$requirement." in <b>NOT APPROVED</b>.";
                $sql_audit = "INSERT INTO tbl_audit_trail (activity, date_, time_, by_, status, userType) VALUES ('$session_audit', '$td', '$time', '$get_name_id', '$active', '$userType')";
                $query_audit_run = mysqli_query($conn, $sql_audit);
                if($query_audit_run){
			        $_SESSION['submitted_1'] = "Responsed to this Student Requirement! Your remarks is NOT APPROVED.";
					header("Location: my_stud_requirements_submitted_details.php?req_id=" . $id);
					exit;
				}
			}
		}
		else{
			$active = "active";
	        $my_ID = $_SESSION['coordinator_id'];
	        $session_log = "You set the remarks in the requirement of ".$stud_fullname." entitled ".$requirement." in APPROVED.";
	        //log session
	        $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_log', '$td', '$time', '$my_ID', '$active')";
	        $query_log_run = mysqli_query($conn, $sql_log);
	        if ($query_log_run) {
	        	$get_name_id = $_SESSION['coordinator_fname']." ".$_SESSION['coordinator_mname']." ".$_SESSION['coordinator_lname']." (".$_SESSION['coordinator_id'].")";

                $userType = "Teacher";
                $session_audit = $get_name_id. " set the remarks in the requirement of ".$stud_fullname." entitled ".$requirement." in <b>APPROVED</b>.";
                $sql_audit = "INSERT INTO tbl_audit_trail (activity, date_, time_, by_, status, userType) VALUES ('$session_audit', '$td', '$time', '$get_name_id', '$active', '$userType')";
                $query_audit_run = mysqli_query($conn, $sql_audit);
                if($query_audit_run){
					$_SESSION['submitted_1'] = "You already response to this student requirement! Your remarks is APPROVED. You can be able now to forward the document in PROGRAM HEAD or set the requirement as a COMPLETED.";
					header("Location: my_stud_requirements_submitted_details.php?req_id=" . $id);
					exit;
				}
				else{
					echo $conn->error;
				}
			}
		}
	}
}


//set the requirement as completed
else if (isset($_POST["set_as_completed_1"])) {
	// application logic goes here
	$requirement = $_POST['requirement'];
	$stud_fullname = $_POST['stud_fullname'];

	$id = $_POST['id'];
	$task_code = $_POST['task_code'];

	$remarks = "Approved";
	$comments = $_POST['comments'];
	$completed = "completed";
	$date_time = $td." at ".$time;
	$isRead = 0;

	if($requirement == "Resume") {
		$sql = "UPDATE tbl_students_work SET work_status='$completed', remarks='$remarks', comment='$comments', completed_date='$date_time', isReadTeacher1='$isRead', isReadDean1='$isRead', isReadStud1='$isRead' WHERE id='$id' and task_code='$task_code'";

		$query_run = mysqli_query($conn, $sql);

		if($query_run)
		{
			$sql11 = "UPDATE tbl_students SET resume='submitted' where stud_fullname='$stud_fullname'";
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
		                $mail->SMTPDebug = 0;                      //Enable verbose debug output
		                $mail->isSMTP();                                            //Send using SMTP
		                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
		                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
		                $mail->Username   = 'websiteet18@gmail.com';                     //SMTP username
		                $mail->Password   = 'empowermenttechnology';                               //SMTP password
		                $mail->SMTPSecure = "tls"; //Enable implicit TLS encryption
		                $mail->Port       = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

		                //Recipients
		                $mail->setFrom('websiteet18@gmail.com', $myfullname_);
		                $mail->addAddress($get_email);//Name is optional

		                //Content
		                $mail->isHTML(true);//Set email format to HTML
		                $mail->Subject = "e-OJT aCCeSs: Requirement Update";
		                $template    = "Your requirement <b>".$requirement."</b> status is now <b style='color: green;'>COMPLETED</b>.";
		                $mail->Body = $template;
		                $mail->send();
		                //echo 'Message has been sent';
		            }
		            catch(Exception $ex){
		                //echo $ex;
		            }
		        }
		        $active = "active";
		        $my_ID = $_SESSION['coordinator_id'];
		        $session_log = "You set the requirement of ".$stud_fullname." entitled ".$requirement." in <b>COMPLETED</b> status.";
		        //log session
		        $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_log', '$td', '$time', '$my_ID', '$active')";
		        $query_log_run = mysqli_query($conn, $sql_log);
		        if ($query_log_run) {
		        	$get_name_id = $_SESSION['coordinator_fname']." ".$_SESSION['coordinator_mname']." ".$_SESSION['coordinator_lname']." (".$_SESSION['coordinator_id'].")";

	                $userType = "Teacher";
	                $session_audit = $get_name_id. " set the requirement of ".$stud_fullname." entitled ".$requirement." in <b>COMPLETED</b> status.";
	                $sql_audit = "INSERT INTO tbl_audit_trail (activity, date_, time_, by_, status, userType) VALUES ('$session_audit', '$td', '$time', '$get_name_id', '$active', '$userType')";
	                $query_audit_run = mysqli_query($conn, $sql_audit);
		                if($query_audit_run){
				    	$_SESSION['set_as_completed'] ="You set ".$stud_fullname." requirement(". $requirement .") in COMPLETED status!";
						header("Location: my_stud_requirements_completed.php?RequirementCompletedStatus");
						exit;
					}
				}
	    	}
		}
	}

	else if($requirement == "Work Plan") {
		$sql = "UPDATE tbl_students_work SET work_status='$completed', remarks='$remarks', comment='$comments', completed_date='$date_time', isReadTeacher1='$isRead', isReadDean1='$isRead', isReadStud1='$isRead' WHERE id='$id' and task_code='$task_code'";

		$query_run = mysqli_query($conn, $sql);

		if($query_run)
		{
			$sql11 = "UPDATE tbl_students SET work_plan='submitted' where stud_fullname='$stud_fullname'";
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
		                $mail->SMTPDebug = 0;                      //Enable verbose debug output
		                $mail->isSMTP();                                            //Send using SMTP
		                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
		                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
		                $mail->Username   = 'websiteet18@gmail.com';                     //SMTP username
		                $mail->Password   = 'empowermenttechnology';                               //SMTP password
		                $mail->SMTPSecure = "tls"; //Enable implicit TLS encryption
		                $mail->Port       = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

		                //Recipients
		                $mail->setFrom('websiteet18@gmail.com', $myfullname_);
		                $mail->addAddress($get_email);//Name is optional

		                //Content
		                $mail->isHTML(true);//Set email format to HTML
		                $mail->Subject = "e-OJT aCCeSs: Requirement Update";
		                $template    = "Your requirement <b>".$requirement."</b> status is now <b style='color: green;'>COMPLETED</b>.";
		                $mail->Body = $template;
		                $mail->send();
		                //echo 'Message has been sent';
		            }
		            catch(Exception $ex){
		                //echo $ex;
		            }
		        }
		        $active = "active";
		        $my_ID = $_SESSION['coordinator_id'];
		        $session_log = "You set the requirement of ".$stud_fullname." entitled ".$requirement." in <b>COMPLETED</b> status.";
		        //log session
		        $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_log', '$td', '$time', '$my_ID', '$active')";
		        $query_log_run = mysqli_query($conn, $sql_log);
			    if ($query_log_run) {
			    	$get_name_id = $_SESSION['coordinator_fname']." ".$_SESSION['coordinator_mname']." ".$_SESSION['coordinator_lname']." (".$_SESSION['coordinator_id'].")";

	                $userType = "Teacher";
	                $session_audit = $get_name_id. " set the requirement of ".$stud_fullname." entitled ".$requirement." in <b>COMPLETED</b> status.";
	                $sql_audit = "INSERT INTO tbl_audit_trail (activity, date_, time_, by_, status, userType) VALUES ('$session_audit', '$td', '$time', '$get_name_id', '$active', '$userType')";
	                $query_audit_run = mysqli_query($conn, $sql_audit);
		            if($query_audit_run){
				    	$_SESSION['set_as_completed'] ="You set ".$stud_fullname." requirement(". $requirement .") in COMPLETED status!";
						header("Location: my_stud_requirements_completed.php?RequirementCompletedStatus");
						exit;
					}
				}
	    	}
		}
	}

	else if($requirement == "Narrative") {
		$sql = "UPDATE tbl_students_work SET work_status='$completed', remarks='$remarks', comment='$comments', completed_date='$date_time', isReadTeacher1='$isRead', isReadDean1='$isRead', isReadStud1='$isRead' WHERE id='$id' and task_code='$task_code'";

		$query_run = mysqli_query($conn, $sql);

		if($query_run)
		{
			$sql11 = "UPDATE tbl_students SET narrative='submitted' where stud_fullname='$stud_fullname'";
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
		                $mail->SMTPDebug = 0;                      //Enable verbose debug output
		                $mail->isSMTP();                                            //Send using SMTP
		                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
		                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
		                $mail->Username   = 'websiteet18@gmail.com';                     //SMTP username
		                $mail->Password   = 'empowermenttechnology';                               //SMTP password
		                $mail->SMTPSecure = "tls"; //Enable implicit TLS encryption
		                $mail->Port       = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

		                //Recipients
		                $mail->setFrom('websiteet18@gmail.com', $myfullname_);
		                $mail->addAddress($get_email);//Name is optional

		                //Content
		                $mail->isHTML(true);//Set email format to HTML
		                $mail->Subject = "e-OJT aCCeSs: Requirement Update";
		                $template    = "Your requirement <b>".$requirement."</b> status is now <b style='color: green;'>COMPLETED</b>.";
		                $mail->Body = $template;
		                $mail->send();
		                //echo 'Message has been sent';
		                
		            }
		            catch(Exception $ex){
		                //echo $ex;
		            }
		        }
		        $active = "active";
		        $my_ID = $_SESSION['coordinator_id'];
		        $session_log = "You set the requirement of ".$stud_fullname." entitled ".$requirement." in <b>COMPLETED</b> status.";
		        //log session
		        $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_log', '$td', '$time', '$my_ID', '$active')";
		        $query_log_run = mysqli_query($conn, $sql_log);
			    if ($query_log_run) {
			    	$get_name_id = $_SESSION['coordinator_fname']." ".$_SESSION['coordinator_mname']." ".$_SESSION['coordinator_lname']." (".$_SESSION['coordinator_id'].")";

	                $userType = "Teacher";
	                $session_audit = $get_name_id. " set the requirement of ".$stud_fullname." entitled ".$requirement." in <b>COMPLETED</b> status.";
	                $sql_audit = "INSERT INTO tbl_audit_trail (activity, date_, time_, by_, status, userType) VALUES ('$session_audit', '$td', '$time', '$get_name_id', '$active', '$userType')";
	                $query_audit_run = mysqli_query($conn, $sql_audit);
		            if($query_audit_run){
				    	$_SESSION['set_as_completed'] ="You set ".$stud_fullname." requirement(". $requirement .") in COMPLETED status!";
						header("Location: my_stud_requirements_completed.php?RequirementCompletedStatus");
						exit;
					}
				}
	    	}
		}
	}

	else if($requirement == "Performance Sheet") {
		$sql = "UPDATE tbl_students_work SET work_status='$completed', remarks='$remarks', comment='$comments', completed_date='$date_time', isReadTeacher1='$isRead', isReadDean1='$isRead', isReadStud1='$isRead' WHERE id='$id' and task_code='$task_code'";

		$query_run = mysqli_query($conn, $sql);

		if($query_run)
		{
			$sql11 = "UPDATE tbl_students SET performance_sheet='submitted' where stud_fullname='$stud_fullname'";
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
		                $mail->SMTPDebug = 0;                      //Enable verbose debug output
		                $mail->isSMTP();                                            //Send using SMTP
		                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
		                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
		                $mail->Username   = 'websiteet18@gmail.com';                     //SMTP username
		                $mail->Password   = 'empowermenttechnology';                               //SMTP password
		                $mail->SMTPSecure = "tls"; //Enable implicit TLS encryption
		                $mail->Port       = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

		                //Recipients
		                $mail->setFrom('websiteet18@gmail.com', $myfullname_);
		                $mail->addAddress($get_email);//Name is optional

		                //Content
		                $mail->isHTML(true);//Set email format to HTML
		                $mail->Subject = "e-OJT aCCeSs: Requirement Update";
		                $template    = "Your requirement <b>".$requirement."</b> status is now <b style='color: green;'>COMPLETED</b>.";
		                $mail->Body = $template;
		                $mail->send();
		                //echo 'Message has been sent';

		            }
		            catch(Exception $ex){
		                //echo $ex;
		            }
		        }
		        $active = "active";
		        $my_ID = $_SESSION['coordinator_id'];
		        $session_log = "You set the requirement of ".$stud_fullname." entitled ".$requirement." in <b>COMPLETED</b> status.";
		        //log session
		        $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_log', '$td', '$time', '$my_ID', '$active')";
		        $query_log_run = mysqli_query($conn, $sql_log);
			    if ($query_log_run) {
			    	$get_name_id = $_SESSION['coordinator_fname']." ".$_SESSION['coordinator_mname']." ".$_SESSION['coordinator_lname']." (".$_SESSION['coordinator_id'].")";

	                $userType = "Teacher";
	                $session_audit = $get_name_id. " set the requirement of ".$stud_fullname." entitled ".$requirement." in <b>COMPLETED</b> status.";
	                $sql_audit = "INSERT INTO tbl_audit_trail (activity, date_, time_, by_, status, userType) VALUES ('$session_audit', '$td', '$time', '$get_name_id', '$active', '$userType')";
	                $query_audit_run = mysqli_query($conn, $sql_audit);
		            if($query_audit_run){
				    	$_SESSION['set_as_completed'] ="You set ".$stud_fullname." requirement(". $requirement .") in COMPLETED status!";
						header("Location: my_stud_requirements_completed.php?RequirementCompletedStatus");
						exit;
					}
				}
	    	}
		}
	}

	else if($requirement == "Memorandum of Agreement") {
		$sql = "UPDATE tbl_students_work SET work_status='$completed', remarks='$remarks', comment='$comments', completed_date='$date_time', isReadTeacher1='$isRead', isReadDean1='$isRead', isReadStud1='$isRead' WHERE id='$id' and task_code='$task_code'";

		$query_run = mysqli_query($conn, $sql);

		if($query_run)
		{
			$sql11 = "UPDATE tbl_students SET moa='submitted' where stud_fullname='$stud_fullname'";
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
		                $mail->SMTPDebug = 0;                      //Enable verbose debug output
		                $mail->isSMTP();                                            //Send using SMTP
		                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
		                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
		                $mail->Username   = 'websiteet18@gmail.com';                     //SMTP username
		                $mail->Password   = 'empowermenttechnology';                               //SMTP password
		                $mail->SMTPSecure = "tls"; //Enable implicit TLS encryption
		                $mail->Port       = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

		                //Recipients
		                $mail->setFrom('websiteet18@gmail.com', $myfullname_);
		                $mail->addAddress($get_email);//Name is optional

		                //Content
		                $mail->isHTML(true);//Set email format to HTML
		                $mail->Subject = "e-OJT aCCeSs: Requirement Update";
		                $template    = "Your requirement <b>".$requirement."</b> status is now <b style='color: green;'>COMPLETED</b>.";
		                $mail->Body = $template;
		                $mail->send();
		                //echo 'Message has been sent';
		                
		            }
		            catch(Exception $ex){
		                //echo $ex;
		            }
		        }
		        $active = "active";
		        $my_ID = $_SESSION['coordinator_id'];
		        $session_log = "You set the requirement of ".$stud_fullname." entitled ".$requirement." in <b>COMPLETED</b> status.";
		        //log session
		        $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_log', '$td', '$time', '$my_ID', '$active')";
		        $query_log_run = mysqli_query($conn, $sql_log);
			    if ($query_log_run) {
			    	$get_name_id = $_SESSION['coordinator_fname']." ".$_SESSION['coordinator_mname']." ".$_SESSION['coordinator_lname']." (".$_SESSION['coordinator_id'].")";

	                $userType = "Teacher";
	                $session_audit = $get_name_id. " set the requirement of ".$stud_fullname." entitled ".$requirement." in <b>COMPLETED</b> status.";
	                $sql_audit = "INSERT INTO tbl_audit_trail (activity, date_, time_, by_, status, userType) VALUES ('$session_audit', '$td', '$time', '$get_name_id', '$active', '$userType')";
	                $query_audit_run = mysqli_query($conn, $sql_audit);
		            if($query_audit_run){
				    	$_SESSION['set_as_completed'] ="You set ".$stud_fullname." requirement(". $requirement .") in COMPLETED status!";
						header("Location: my_stud_requirements_completed.php?RequirementCompletedStatus");
						exit;
					}
				}
	    	}
		}
	}	

	else if($requirement == "Accomplishment Report") {
		$sql = "UPDATE tbl_students_work SET work_status='$completed', remarks='$remarks', comment='$comments', completed_date='$date_time', isReadTeacher1='$isRead', isReadDean1='$isRead', isReadStud1='$isRead' WHERE id='$id' and task_code='$task_code'";

		$query_run = mysqli_query($conn, $sql);

		if($query_run)
		{
			$sql11 = "UPDATE tbl_students SET accomplishment_report='submitted' where stud_fullname='$stud_fullname'";
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
		                $mail->SMTPDebug = 0;                      //Enable verbose debug output
		                $mail->isSMTP();                                            //Send using SMTP
		                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
		                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
		                $mail->Username   = 'websiteet18@gmail.com';                     //SMTP username
		                $mail->Password   = 'empowermenttechnology';                               //SMTP password
		                $mail->SMTPSecure = "tls"; //Enable implicit TLS encryption
		                $mail->Port       = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

		                //Recipients
		                $mail->setFrom('websiteet18@gmail.com', $myfullname_);
		                $mail->addAddress($get_email);//Name is optional

		                //Content
		                $mail->isHTML(true);//Set email format to HTML
		                $mail->Subject = "e-OJT aCCeSs: Requirement Update";
		                $template    = "Your requirement <b>".$requirement."</b> status is now <b style='color: green;'>COMPLETED</b>.";
		                $mail->Body = $template;
		                $mail->send();
		                //echo 'Message has been sent';
		                
		            }
		            catch(Exception $ex){
		                //echo $ex;
		            }
		        }
		        $active = "active";
		        $my_ID = $_SESSION['coordinator_id'];
		        $session_log = "You set the requirement of ".$stud_fullname." entitled ".$requirement." in <b>COMPLETED</b> status.";
		        //log session
		        $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_log', '$td', '$time', '$my_ID', '$active')";
		        $query_log_run = mysqli_query($conn, $sql_log);
			    if ($query_log_run) {
			    	$get_name_id = $_SESSION['coordinator_fname']." ".$_SESSION['coordinator_mname']." ".$_SESSION['coordinator_lname']." (".$_SESSION['coordinator_id'].")";

	                $userType = "Teacher";
	                $session_audit = $get_name_id. " set the requirement of ".$stud_fullname." entitled ".$requirement." in <b>COMPLETED</b> status.";
	                $sql_audit = "INSERT INTO tbl_audit_trail (activity, date_, time_, by_, status, userType) VALUES ('$session_audit', '$td', '$time', '$get_name_id', '$active', '$userType')";
	                $query_audit_run = mysqli_query($conn, $sql_audit);
		            if($query_audit_run){
				    	$_SESSION['set_as_completed'] ="You set ".$stud_fullname." requirement(". $requirement .") in COMPLETED status!";
						header("Location: my_stud_requirements_completed.php?RequirementCompletedStatus");
						exit;
					}
				}
	    	}
		}
	}

	else if($requirement == "Response Letter") {
		$sql = "UPDATE tbl_students_work SET work_status='$completed', remarks='$remarks', comment='$comments', completed_date='$date_time', isReadTeacher1='$isRead', isReadDean1='$isRead', isReadStud1='$isRead' WHERE id='$id' and task_code='$task_code'";

		$query_run = mysqli_query($conn, $sql);

		if($query_run)
		{
			$sql11 = "UPDATE tbl_students SET response_letter='submitted' where stud_fullname='$stud_fullname'";
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
		                $mail->SMTPDebug = 0;                      //Enable verbose debug output
		                $mail->isSMTP();                                            //Send using SMTP
		                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
		                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
		                $mail->Username   = 'websiteet18@gmail.com';                     //SMTP username
		                $mail->Password   = 'empowermenttechnology';                               //SMTP password
		                $mail->SMTPSecure = "tls"; //Enable implicit TLS encryption
		                $mail->Port       = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

		                //Recipients
		                $mail->setFrom('websiteet18@gmail.com', $myfullname_);
		                $mail->addAddress($get_email);//Name is optional

		                //Content
		                $mail->isHTML(true);//Set email format to HTML
		                $mail->Subject = "e-OJT aCCeSs: Requirement Update";
		                $template    = "Your requirement <b>".$requirement."</b> status is now <b style='color: green;'>COMPLETED</b>.";
		                $mail->Body = $template;
		                $mail->send();
		                //echo 'Message has been sent';
		                
		            }
		            catch(Exception $ex){
		                //echo $ex;
		            }
		        }
		        $active = "active";
		        $my_ID = $_SESSION['coordinator_id'];
		        $session_log = "You set the requirement of ".$stud_fullname." entitled ".$requirement." in <b>COMPLETED</b> status.";
		        //log session
		        $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_log', '$td', '$time', '$my_ID', '$active')";
		        $query_log_run = mysqli_query($conn, $sql_log);
			    if ($query_log_run) {
			    	$get_name_id = $_SESSION['coordinator_fname']." ".$_SESSION['coordinator_mname']." ".$_SESSION['coordinator_lname']." (".$_SESSION['coordinator_id'].")";

	                $userType = "Teacher";
	                $session_audit = $get_name_id. " set the requirement of ".$stud_fullname." entitled ".$requirement." in <b>COMPLETED</b> status.";
	                $sql_audit = "INSERT INTO tbl_audit_trail (activity, date_, time_, by_, status, userType) VALUES ('$session_audit', '$td', '$time', '$get_name_id', '$active', '$userType')";
	                $query_audit_run = mysqli_query($conn, $sql_audit);
		            if($query_audit_run){
				    	$_SESSION['set_as_completed'] ="You set ".$stud_fullname." requirement(". $requirement .") in COMPLETED status!";
						header("Location: my_stud_requirements_completed.php?RequirementCompletedStatus");
						exit;
					}
				}
	    	}
		}
	}

	else if($requirement == "Endorsement Letter") {
		$sql = "UPDATE tbl_students_work SET work_status='$completed', remarks='$remarks', comment='$comments', completed_date='$date_time', isReadTeacher1='$isRead', isReadDean1='$isRead', isReadStud1='$isRead' WHERE id='$id' and task_code='$task_code'";

		$query_run = mysqli_query($conn, $sql);

		if($query_run)
		{
			$sql11 = "UPDATE tbl_students SET endorsement_letter='submitted' where stud_fullname='$stud_fullname'";
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
		                $mail->SMTPDebug = 0;                      //Enable verbose debug output
		                $mail->isSMTP();                                            //Send using SMTP
		                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
		                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
		                $mail->Username   = 'websiteet18@gmail.com';                     //SMTP username
		                $mail->Password   = 'empowermenttechnology';                               //SMTP password
		                $mail->SMTPSecure = "tls"; //Enable implicit TLS encryption
		                $mail->Port       = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

		                //Recipients
		                $mail->setFrom('websiteet18@gmail.com', $myfullname_);
		                $mail->addAddress($get_email);//Name is optional

		                //Content
		                $mail->isHTML(true);//Set email format to HTML
		                $mail->Subject = "e-OJT aCCeSs: Requirement Update";
		                $template    = "Your requirement <b>".$requirement."</b> status is now <b style='color: green;'>COMPLETED</b>.";
		                $mail->Body = $template;
		                $mail->send();
		                //echo 'Message has been sent';
		                $_SESSION['set_as_completed'] ="You set ".$stud_fullname." requirement(". $requirement .") in COMPLETED status!";
						header("Location: my_stud_requirements_completed.php?RequirementCompletedStatus");
						exit;
		            }
		            catch(Exception $ex){
		                //echo $ex;
		            }
		        }
		        $active = "active";
		        $my_ID = $_SESSION['coordinator_id'];
		        $session_log = "You set the requirement of ".$stud_fullname." entitled ".$requirement." in <b>COMPLETED</b> status.";
		        //log session
		        $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_log', '$td', '$time', '$my_ID', '$active')";
		        $query_log_run = mysqli_query($conn, $sql_log);
			    if ($query_log_run) {
			    	$get_name_id = $_SESSION['coordinator_fname']." ".$_SESSION['coordinator_mname']." ".$_SESSION['coordinator_lname']." (".$_SESSION['coordinator_id'].")";

	                $userType = "Teacher";
	                $session_audit = $get_name_id. " set the requirement of ".$stud_fullname." entitled ".$requirement." in <b>COMPLETED</b> status.";
	                $sql_audit = "INSERT INTO tbl_audit_trail (activity, date_, time_, by_, status, userType) VALUES ('$session_audit', '$td', '$time', '$get_name_id', '$active', '$userType')";
	                $query_audit_run = mysqli_query($conn, $sql_audit);
		            if($query_audit_run){
				    	$_SESSION['set_as_completed'] ="You set ".$stud_fullname." requirement(". $requirement .") in COMPLETED status!";
						header("Location: my_stud_requirements_completed.php?RequirementCompletedStatus");
						exit;
					}
				}
	    	}
		}
	}
	else if($requirement == "Recommendation Letter"){
		$_SESSION['completed_error'] = "You Are Not Be Able to Set the Requirement (Recommendation Letter) in Completed Status";
		header("Location: my_stud_requirements_submitted_details.php?req_id=" . $id);
		exit;
	}
}

//set the requirement as completed
else if (isset($_POST["set_as_completed"])) {
	$requirement = $_POST['requirement'];
	$stud_fullname = $_POST['stud_fullname'];

	$id = $_POST['id'];
	$task_code = $_POST['task_code'];

	$remarks = "Approved";
	$comments = $_POST['comments'];
	$completed = "completed";
	$date_time = $td." ".$time;
	$isRead = 0;

	if($requirement == "Resume") {
		$sql = "UPDATE tbl_students_work SET work_status='$completed', remarks='$remarks', comment='$comments', completed_date='$date_time', isReadTeacher1='$isRead', isReadDean1='$isRead', isReadStud1='$isRead' WHERE id='$id' and task_code='$task_code'";

		$query_run = mysqli_query($conn, $sql);

		if($query_run)
		{
			$sql11 = "UPDATE tbl_students SET resume='submitted' where stud_fullname='$stud_fullname'";
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
		                $mail->SMTPDebug = 0;                      //Enable verbose debug output
		                $mail->isSMTP();                                            //Send using SMTP
		                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
		                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
		                $mail->Username   = 'websiteet18@gmail.com';                     //SMTP username
		                $mail->Password   = 'empowermenttechnology';                               //SMTP password
		                $mail->SMTPSecure = "tls"; //Enable implicit TLS encryption
		                $mail->Port       = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

		                //Recipients
		                $mail->setFrom('websiteet18@gmail.com', $myfullname_);
		                $mail->addAddress($get_email);//Name is optional

		                //Content
		                $mail->isHTML(true);//Set email format to HTML
		                $mail->Subject = "e-OJT aCCeSs: Requirement Update";
		                $template    = "Your requirement <b>".$requirement."</b> status is now <b style='color: green;'>COMPLETED</b>.";
		                $mail->Body = $template;
		                $mail->send();
		                //echo 'Message has been sent';
		                
		            }
		            catch(Exception $ex){
		                //echo $ex;
		            }
		        }
		        $active = "active";
		        $my_ID = $_SESSION['coordinator_id'];
		        $session_log = "You set the requirement of ".$stud_fullname." entitled ".$requirement." in <b>COMPLETED</b> status.";
		        //log session
		        $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_log', '$td', '$time', '$my_ID', '$active')";
		        $query_log_run = mysqli_query($conn, $sql_log);
			    if ($query_log_run) {
			    	$get_name_id = $_SESSION['coordinator_fname']." ".$_SESSION['coordinator_mname']." ".$_SESSION['coordinator_lname']." (".$_SESSION['coordinator_id'].")";

	                $userType = "Teacher";
	                $session_audit = $get_name_id. " set the requirement of ".$stud_fullname." entitled ".$requirement." in <b>COMPLETED</b> status.";
	                $sql_audit = "INSERT INTO tbl_audit_trail (activity, date_, time_, by_, status, userType) VALUES ('$session_audit', '$td', '$time', '$get_name_id', '$active', '$userType')";
	                $query_audit_run = mysqli_query($conn, $sql_audit);
		            if($query_audit_run){
				    	$_SESSION['set_as_completed'] ="You set ".$stud_fullname." requirement(". $requirement .") in COMPLETED status!";
						header("Location: my_stud_requirements_completed.php?RequirementCompletedStatus");
						exit;
					}
				}
	    	}
		}
	}

	else if($requirement == "Work Plan") {
		$sql = "UPDATE tbl_students_work SET work_status='$completed', remarks='$remarks', comment='$comments', completed_date='$date_time', isReadTeacher1='$isRead', isReadDean1='$isRead', isReadStud1='$isRead' WHERE id='$id' and task_code='$task_code'";

		$query_run = mysqli_query($conn, $sql);

		if($query_run)
		{
			$sql11 = "UPDATE tbl_students SET work_plan='submitted' where stud_fullname='$stud_fullname'";
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
		                $mail->SMTPDebug = 0;                      //Enable verbose debug output
		                $mail->isSMTP();                                            //Send using SMTP
		                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
		                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
		                $mail->Username   = 'websiteet18@gmail.com';                     //SMTP username
		                $mail->Password   = 'empowermenttechnology';                               //SMTP password
		                $mail->SMTPSecure = "tls"; //Enable implicit TLS encryption
		                $mail->Port       = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

		                //Recipients
		                $mail->setFrom('websiteet18@gmail.com', $myfullname_);
		                $mail->addAddress($get_email);//Name is optional

		                //Content
		                $mail->isHTML(true);//Set email format to HTML
		                $mail->Subject = "e-OJT aCCeSs: Requirement Update";
		                $template    = "Your requirement <b>".$requirement."</b> status is now <b style='color: green;'>COMPLETED</b>.";
		                $mail->Body = $template;
		                $mail->send();
		                //echo 'Message has been sent';
		                //header('location: my_stud_requirements_completed.php?updated=1');
		            }
		            catch(Exception $ex){
		                //echo $ex;
		            }
		        }
		        $active = "active";
		        $my_ID = $_SESSION['coordinator_id'];
		        $session_log = "You set the requirement of ".$stud_fullname." entitled ".$requirement." in <b>COMPLETED</b> status.";
		        //log session
		        $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_log', '$td', '$time', '$my_ID', '$active')";
		        $query_log_run = mysqli_query($conn, $sql_log);
			    if ($query_log_run) {
			    	$get_name_id = $_SESSION['coordinator_fname']." ".$_SESSION['coordinator_mname']." ".$_SESSION['coordinator_lname']." (".$_SESSION['coordinator_id'].")";

	                $userType = "Teacher";
	                $session_audit = $get_name_id. " set the requirement of ".$stud_fullname." entitled ".$requirement." in <b>COMPLETED</b> status.";
	                $sql_audit = "INSERT INTO tbl_audit_trail (activity, date_, time_, by_, status, userType) VALUES ('$session_audit', '$td', '$time', '$get_name_id', '$active', '$userType')";
	                $query_audit_run = mysqli_query($conn, $sql_audit);
		            if($query_audit_run){
				    	$_SESSION['set_as_completed'] ="You set ".$stud_fullname." requirement(". $requirement .") in COMPLETED status!";
						header("Location: my_stud_requirements_completed.php?RequirementCompletedStatus");
						exit;
					}
				}
	    	}
		}
	}

	else if($requirement == "Narrative") {
		$sql = "UPDATE tbl_students_work SET work_status='$completed', remarks='$remarks', comment='$comments', completed_date='$date_time', isReadTeacher1='$isRead', isReadDean1='$isRead', isReadStud1='$isRead' WHERE id='$id' and task_code='$task_code'";

		$query_run = mysqli_query($conn, $sql);

		if($query_run)
		{
			$sql11 = "UPDATE tbl_students SET narrative='submitted' where stud_fullname='$stud_fullname'";
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
		                $mail->SMTPDebug = 0;                      //Enable verbose debug output
		                $mail->isSMTP();                                            //Send using SMTP
		                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
		                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
		                $mail->Username   = 'websiteet18@gmail.com';                     //SMTP username
		                $mail->Password   = 'empowermenttechnology';                               //SMTP password
		                $mail->SMTPSecure = "tls"; //Enable implicit TLS encryption
		                $mail->Port       = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

		                //Recipients
		                $mail->setFrom('websiteet18@gmail.com', $myfullname_);
		                $mail->addAddress($get_email);//Name is optional

		                //Content
		                $mail->isHTML(true);//Set email format to HTML
		                $mail->Subject = "e-OJT aCCeSs: Requirement Update";
		                $template    = "Your requirement <b>".$requirement."</b> status is now <b style='color: green;'>COMPLETED</b>.";
		                $mail->Body = $template;
		                $mail->send();
		                //echo 'Message has been sent';
		                //header('location: my_stud_requirements_completed.php?updated=1');
		            }
		            catch(Exception $ex){
		                //echo $ex;
		            }
		        }
		        $active = "active";
		        $my_ID = $_SESSION['coordinator_id'];
		        $session_log = "You set the requirement of ".$stud_fullname." entitled ".$requirement." in <b>COMPLETED</b> status.";
		        //log session
		        $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_log', '$td', '$time', '$my_ID', '$active')";
		        $query_log_run = mysqli_query($conn, $sql_log);
			    if ($query_log_run) {
			    	$get_name_id = $_SESSION['coordinator_fname']." ".$_SESSION['coordinator_mname']." ".$_SESSION['coordinator_lname']." (".$_SESSION['coordinator_id'].")";

	                $userType = "Teacher";
	                $session_audit = $get_name_id. " set the requirement of ".$stud_fullname." entitled ".$requirement." in <b>COMPLETED</b> status.";
	                $sql_audit = "INSERT INTO tbl_audit_trail (activity, date_, time_, by_, status, userType) VALUES ('$session_audit', '$td', '$time', '$get_name_id', '$active', '$userType')";
	                $query_audit_run = mysqli_query($conn, $sql_audit);
		            if($query_audit_run){
				    	$_SESSION['set_as_completed'] ="You set ".$stud_fullname." requirement(". $requirement .") in COMPLETED status!";
						header("Location: my_stud_requirements_completed.php?RequirementCompletedStatus");
						exit;
					}
				}
	    	}
		}
	}

	else if($requirement == "Performance Sheet") {
		$sql = "UPDATE tbl_students_work SET work_status='$completed', remarks='$remarks', comment='$comments', completed_date='$date_time', isReadTeacher1='$isRead', isReadDean1='$isRead', isReadStud1='$isRead' WHERE id='$id' and task_code='$task_code'";

		$query_run = mysqli_query($conn, $sql);

		if($query_run)
		{
			$sql11 = "UPDATE tbl_students SET performance_sheet='submitted' where stud_fullname='$stud_fullname'";
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
		                $mail->setFrom('websiteet18@gmail.com', $myfullname_);
		                $mail->addAddress($get_email);//Name is optional

		                //Content
		                $mail->isHTML(true);//Set email format to HTML
		                $mail->Subject = "e-OJT aCCeSs: Requirement Update";
		                $template    = "Your requirement <b>".$requirement."</b> status is now <b style='color: green;'>COMPLETED</b>.";
		                $mail->Body = $template;
		                $mail->send();
		                //echo 'Message has been sent';
		                //header('location: my_stud_requirements_completed.php?updated=1');
		            }
		            catch(Exception $ex){
		                //echo $ex;
		            }
		        }
		        $active = "active";
		        $my_ID = $_SESSION['coordinator_id'];
		        $session_log = "You set the requirement of ".$stud_fullname." entitled ".$requirement." in <b>COMPLETED</b> status.";
		        //log session
		        $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_log', '$td', '$time', '$my_ID', '$active')";
		        $query_log_run = mysqli_query($conn, $sql_log);
			    if ($query_log_run) {
			    	$get_name_id = $_SESSION['coordinator_fname']." ".$_SESSION['coordinator_mname']." ".$_SESSION['coordinator_lname']." (".$_SESSION['coordinator_id'].")";

	                $userType = "Teacher";
	                $session_audit = $get_name_id. " set the requirement of ".$stud_fullname." entitled ".$requirement." in <b>COMPLETED</b> status.";
	                $sql_audit = "INSERT INTO tbl_audit_trail (activity, date_, time_, by_, status, userType) VALUES ('$session_audit', '$td', '$time', '$get_name_id', '$active', '$userType')";
	                $query_audit_run = mysqli_query($conn, $sql_audit);
		            if($query_audit_run){
				    	$_SESSION['set_as_completed'] ="You set ".$stud_fullname." requirement(". $requirement .") in COMPLETED status!";
						header("Location: my_stud_requirements_completed.php?RequirementCompletedStatus");
						exit;
					}
				}
	    	}
		}
	}

	else if($requirement == "Memorandum of Agreement") {
		$sql = "UPDATE tbl_students_work SET work_status='$completed', remarks='$remarks', comment='$comments', completed_date='$date_time', isReadTeacher1='$isRead', isReadDean1='$isRead', isReadStud1='$isRead' WHERE id='$id' and task_code='$task_code'";

		$query_run = mysqli_query($conn, $sql);

		if($query_run)
		{
			$sql11 = "UPDATE tbl_students SET moa='submitted' where stud_fullname='$stud_fullname'";
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
		                $mail->SMTPDebug = 0;                      //Enable verbose debug output
		                $mail->isSMTP();                                            //Send using SMTP
		                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
		                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
		                $mail->Username   = 'websiteet18@gmail.com';                     //SMTP username
		                $mail->Password   = 'empowermenttechnology';                               //SMTP password
		                $mail->SMTPSecure = "tls"; //Enable implicit TLS encryption
		                $mail->Port       = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

		                //Recipients
		                $mail->setFrom('websiteet18@gmail.com', $myfullname_);
		                $mail->addAddress($get_email);//Name is optional

		                //Content
		                $mail->isHTML(true);//Set email format to HTML
		                $mail->Subject = "e-OJT aCCeSs: Requirement Update";
		                $template    = "Your requirement <b>".$requirement."</b> status is now <b style='color: green;'>COMPLETED</b>.";
		                $mail->Body = $template;
		                $mail->send();
		                //echo 'Message has been sent';
		            }
		            catch(Exception $ex){
		                //echo $ex;
		            }
		        }
		        $active = "active";
		        $my_ID = $_SESSION['coordinator_id'];
		        $session_log = "You set the requirement of ".$stud_fullname." entitled ".$requirement." in <b>COMPLETED</b> status.";
		        //log session
		        $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_log', '$td', '$time', '$my_ID', '$active')";
		        $query_log_run = mysqli_query($conn, $sql_log);
			    if ($query_log_run) {
			    	$get_name_id = $_SESSION['coordinator_fname']." ".$_SESSION['coordinator_mname']." ".$_SESSION['coordinator_lname']." (".$_SESSION['coordinator_id'].")";

	                $userType = "Teacher";
	                $session_audit = $get_name_id. " set the requirement of ".$stud_fullname." entitled ".$requirement." in <b>COMPLETED</b> status.";
	                $sql_audit = "INSERT INTO tbl_audit_trail (activity, date_, time_, by_, status, userType) VALUES ('$session_audit', '$td', '$time', '$get_name_id', '$active', '$userType')";
	                $query_audit_run = mysqli_query($conn, $sql_audit);
		            if($query_audit_run){
				    	$_SESSION['set_as_completed'] ="You set ".$stud_fullname." requirement(". $requirement .") in COMPLETED status!";
						header("Location: my_stud_requirements_completed.php?RequirementCompletedStatus");
						exit;
					}
				}
	    	}
		}
	}	

	else if($requirement == "Accomplishment Report") {
		$sql = "UPDATE tbl_students_work SET work_status='$completed', remarks='$remarks', comment='$comments', completed_date='$date_time', isReadTeacher1='$isRead', isReadDean1='$isRead', isReadStud1='$isRead' WHERE id='$id' and task_code='$task_code'";

		$query_run = mysqli_query($conn, $sql);

		if($query_run)
		{
			$sql11 = "UPDATE tbl_students SET accomplishment_report='submitted' where stud_fullname='$stud_fullname'";
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
		                $mail->SMTPDebug = 0;                      //Enable verbose debug output
		                $mail->isSMTP();                                            //Send using SMTP
		                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
		                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
		                $mail->Username   = 'websiteet18@gmail.com';                     //SMTP username
		                $mail->Password   = 'empowermenttechnology';                               //SMTP password
		                $mail->SMTPSecure = "tls"; //Enable implicit TLS encryption
		                $mail->Port       = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

		                //Recipients
		                $mail->setFrom('websiteet18@gmail.com', $myfullname_);
		                $mail->addAddress($get_email);//Name is optional

		                //Content
		                $mail->isHTML(true);//Set email format to HTML
		                $mail->Subject = "e-OJT aCCeSs: Requirement Update";
		                $template    = "Your requirement <b>".$requirement."</b> status is now <b style='color: green;'>COMPLETED</b>.";
		                $mail->Body = $template;
		                $mail->send();
		                //echo 'Message has been sent';
		                //header('location: my_stud_requirements_completed.php?updated=1');
		            }
		            catch(Exception $ex){
		                //echo $ex;
		            }
		        }
		        $active = "active";
		        $my_ID = $_SESSION['coordinator_id'];
		        $session_log = "You set the requirement of ".$stud_fullname." entitled ".$requirement." in <b>COMPLETED</b> status.";
		        //log session
		        $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_log', '$td', '$time', '$my_ID', '$active')";
		        $query_log_run = mysqli_query($conn, $sql_log);
			    if ($query_log_run) {
			    	$get_name_id = $_SESSION['coordinator_fname']." ".$_SESSION['coordinator_mname']." ".$_SESSION['coordinator_lname']." (".$_SESSION['coordinator_id'].")";

	                $userType = "Teacher";
	                $session_audit = $get_name_id. " set the requirement of ".$stud_fullname." entitled ".$requirement." in <b>COMPLETED</b> status.";
	                $sql_audit = "INSERT INTO tbl_audit_trail (activity, date_, time_, by_, status, userType) VALUES ('$session_audit', '$td', '$time', '$get_name_id', '$active', '$userType')";
	                $query_audit_run = mysqli_query($conn, $sql_audit);
		            if($query_audit_run){
				    	$_SESSION['set_as_completed'] ="You set ".$stud_fullname." requirement(". $requirement .") in COMPLETED status!";
						header("Location: my_stud_requirements_completed.php?RequirementCompletedStatus");
						exit;
					}
				}
	    	}
		}
	}

	else if($requirement == "Response Letter") {
		$sql = "UPDATE tbl_students_work SET work_status='$completed', remarks='$remarks', comment='$comments', completed_date='$date_time', isReadTeacher1='$isRead', isReadDean1='$isRead', isReadStud1='$isRead' WHERE id='$id' and task_code='$task_code'";

		$query_run = mysqli_query($conn, $sql);

		if($query_run)
		{
			$sql11 = "UPDATE tbl_students SET response_letter='submitted' where stud_fullname='$stud_fullname'";
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
		                $mail->SMTPDebug = 0;                      //Enable verbose debug output
		                $mail->isSMTP();                                            //Send using SMTP
		                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
		                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
		                $mail->Username   = 'websiteet18@gmail.com';                     //SMTP username
		                $mail->Password   = 'empowermenttechnology';                               //SMTP password
		                $mail->SMTPSecure = "tls"; //Enable implicit TLS encryption
		                $mail->Port       = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

		                //Recipients
		                $mail->setFrom('websiteet18@gmail.com', $myfullname_);
		                $mail->addAddress($get_email);//Name is optional

		                //Content
		                $mail->isHTML(true);//Set email format to HTML
		                $mail->Subject = "e-OJT aCCeSs: Requirement Update";
		                $template    = "Your requirement <b>".$requirement."</b> status is now <b style='color: green;'>COMPLETED</b>.";
		                $mail->Body = $template;
		                $mail->send();
		                //echo 'Message has been sent';
		                //header('location: my_stud_requirements_completed.php?updated=1');
		            }
		            catch(Exception $ex){
		                //echo $ex;
		            }
		        }
		        $active = "active";
		        $my_ID = $_SESSION['coordinator_id'];
		        $session_log = "You set the requirement of ".$stud_fullname." entitled ".$requirement." in <b>COMPLETED</b> status.";
		        //log session
		        $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_log', '$td', '$time', '$my_ID', '$active')";
		        $query_log_run = mysqli_query($conn, $sql_log);
			    if ($query_log_run) {
			    	$get_name_id = $_SESSION['coordinator_fname']." ".$_SESSION['coordinator_mname']." ".$_SESSION['coordinator_lname']." (".$_SESSION['coordinator_id'].")";

	                $userType = "Teacher";
	                $session_audit = $get_name_id. " set the requirement of ".$stud_fullname." entitled ".$requirement." in <b>COMPLETED</b> status.";
	                $sql_audit = "INSERT INTO tbl_audit_trail (activity, date_, time_, by_, status, userType) VALUES ('$session_audit', '$td', '$time', '$get_name_id', '$active', '$userType')";
	                $query_audit_run = mysqli_query($conn, $sql_audit);
		            if($query_audit_run){
				    	$_SESSION['set_as_completed'] ="You set ".$stud_fullname." requirement(". $requirement .") in COMPLETED status!";
						header("Location: my_stud_requirements_completed.php?RequirementCompletedStatus");
						exit;
					}
				}
	    	}
		}
	}

	else if($requirement == "Endorsement Letter") {
		$sql = "UPDATE tbl_students_work SET work_status='$completed', remarks='$remarks', comment='$comments', completed_date='$date_time', isReadTeacher1='$isRead', isReadDean1='$isRead', isReadStud1='$isRead' WHERE id='$id' and task_code='$task_code'";

		$query_run = mysqli_query($conn, $sql);

		if($query_run)
		{
			$sql11 = "UPDATE tbl_students SET endorsement_letter='submitted' where stud_fullname='$stud_fullname'";
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
		                $mail->SMTPDebug = 0;                      //Enable verbose debug output
		                $mail->isSMTP();                                            //Send using SMTP
		                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
		                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
		                $mail->Username   = 'websiteet18@gmail.com';                     //SMTP username
		                $mail->Password   = 'empowermenttechnology';                               //SMTP password
		                $mail->SMTPSecure = "tls"; //Enable implicit TLS encryption
		                $mail->Port       = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

		                //Recipients
		                $mail->setFrom('websiteet18@gmail.com', $myfullname_);
		                $mail->addAddress($get_email);//Name is optional

		                //Content
		                $mail->isHTML(true);//Set email format to HTML
		                $mail->Subject = "e-OJT aCCeSs: Requirement Update";
		                $template    = "Your requirement <b>".$requirement."</b> status is now <b style='color: green;'>COMPLETED</b>.";
		                $mail->Body = $template;
		                $mail->send();
		                //echo 'Message has been sent';
		                //header('location: my_stud_requirements_completed.php?updated=1');
		            }
		            catch(Exception $ex){
		                //echo $ex;
		            }
		        }
		        $active = "active";
		        $my_ID = $_SESSION['coordinator_id'];
		        $session_log = "You set the requirement of ".$stud_fullname." entitled ".$requirement." in <b>COMPLETED</b> status.";
		        //log session
		        $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_log', '$td', '$time', '$my_ID', '$active')";
		        $query_log_run = mysqli_query($conn, $sql_log);
			    if ($query_log_run) {
			    	$get_name_id = $_SESSION['coordinator_fname']." ".$_SESSION['coordinator_mname']." ".$_SESSION['coordinator_lname']." (".$_SESSION['coordinator_id'].")";

	                $userType = "Teacher";
	                $session_audit = $get_name_id. " set the requirement of ".$stud_fullname." entitled ".$requirement." in <b>COMPLETED</b> status.";
	                $sql_audit = "INSERT INTO tbl_audit_trail (activity, date_, time_, by_, status, userType) VALUES ('$session_audit', '$td', '$time', '$get_name_id', '$active', '$userType')";
	                $query_audit_run = mysqli_query($conn, $sql_audit);
		            if($query_audit_run){
				    	$_SESSION['set_as_completed'] ="You set ".$stud_fullname." requirement(". $requirement .") in COMPLETED status!";
						header("Location: my_stud_requirements_completed.php?RequirementCompletedStatus");
						exit;
					}
				}
	    	}
		}
	}
	else if($requirement == "Recommendation Letter"){
		$_SESSION['completed_error'] = "You Are Not Be Able to Set the Requirement (Recommendation Letter) in Completed Status";
		header("Location: my_stud_requirements_completed.php");
		exit;
	}
}

else if(isset($_POST["forward"])){
	if($requirement == "Recommendation Letter"){
		$stud_fullname = $_POST['stud_fullname'];
		// $course = $_POST['course'];
		// $requirement = $_POST['requirement'];
		// $instructions = $_POST['instructions'];
		// $file = $_POST['file'];
		//for time and date
		$my_course = $_SESSION['coordinator_course'];
		if($my_course == $my_course){
			$sql_get_PH = "SELECT * from tbl_coordinators where program_head_of='$my_course'";
			$query_get_PH = $conn->query($sql_get_PH);
	        while($row_PH = $query_get_PH->fetch_assoc()){
	        	$program_head_name = $row_PH['fname']." ".$row_PH['mname']." ".$row_PH['lname']." (".$row_PH['coordinator_id'].")"; 
	        }
			$date_time = $td." at ".$time;
			$work_status = "semi-pending2";
			$id = $_POST['id'];
			$task_code = $_POST['task_code'];
			$isRead = 0;
			$status = "not archived";
			$date_time = $td." ".$time;
			$program_head = "program head";

			$sql1 = "UPDATE tbl_students_work SET work_status='$work_status', name_of_program_head='$program_head_name', send_to_PH='$program_head', program_head_forward_date='$date_time', isReadPH='$isRead' WHERE id='$id' and task_code='$task_code'";

			$query_run1 = mysqli_query($conn, $sql1);

			if($query_run1)
			{
				$active = "active";
		        $my_ID = $_SESSION['coordinator_id'];
		        $session_log = "You validated and forwarded the requirement of ".$stud_fullname." entitled ".$requirement." to ".$program_head_name." (Program Head of ".$my_course.")";
		        //log session
		        $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_log', '$td', '$time', '$my_ID', '$active')";
		        $query_log_run = mysqli_query($conn, $sql_log);
			    if ($query_log_run) {
			    	$get_name_id = $_SESSION['coordinator_fname']." ".$_SESSION['coordinator_mname']." ".$_SESSION['coordinator_lname']." (".$_SESSION['coordinator_id'].")";

	                $userType = "Teacher";
	                $session_audit = $get_name_id. " validated and forwarded the requirement of ".$stud_fullname." entitled ".$requirement." to ".$program_head_name." (Program Head of ".$my_course.")";
	                $sql_audit = "INSERT INTO tbl_audit_trail (activity, date_, time_, by_, status, userType) VALUES ('$session_audit', '$td', '$time', '$get_name_id', '$active', '$userType')";
	                $query_audit_run = mysqli_query($conn, $sql_audit);
		            if($query_audit_run){
						$_SESSION['forwarded'] = $stud_fullname." requirement has been forwarded!";
				        header('location: my_stud_requirements_completed.php?forwardedSuccessfully');
						exit;
					}
				}
			}
		}
		else{

		}
	}
	else{
		$_SESSION['completed_error'] = "You Are Not Be Able to Forward This Document to Program Head!";
		header("Location: my_stud_requirements_completed.php");
		exit;
	}
}

else if(isset($_POST["forward1"])){
	if($requirement == "Recommendation Letter"){
		$stud_fullname = $_POST['stud_fullname'];
		// $course = $_POST['course'];
		// $requirement = $_POST['requirement'];
		// $instructions = $_POST['instructions'];
		// $file = $_POST['file'];
		//for time and date
		$my_course = $_SESSION['coordinator_course'];
		if($my_course == $my_course){
			$sql_get_PH = "SELECT * from tbl_coordinators where program_head_of='$my_course'";
			$query_get_PH = $conn->query($sql_get_PH);
	        while($row_PH = $query_get_PH->fetch_assoc()){
	        	$program_head_name = $row_PH['fname']." ".$row_PH['mname']." ".$row_PH['lname']." (".$row_PH['coordinator_id'].")"; 
	        }
			$date_time = $td." at ".$time;
			$work_status = "semi-pending2";
			$id = $_POST['id'];
			$task_code = $_POST['task_code'];
			$isRead = 0;
			$status = "not archived";
			$date_time = $td." ".$time;
			$program_head = "program head";

			$sql1 = "UPDATE tbl_students_work SET work_status='$work_status', name_of_program_head='$program_head_name', send_to_PH='$program_head', program_head_forward_date='$date_time', isReadPH='$isRead' WHERE id='$id' and task_code='$task_code'";

			$query_run1 = mysqli_query($conn, $sql1);

			if($query_run1)
			{
				$active = "active";
		        $my_ID = $_SESSION['coordinator_id'];
		        $session_log = "You validated and forwarded the requirement of ".$stud_fullname." entitled ".$requirement." to ".$program_head_name." (Program Head of ".$my_course.")";
		        //log session
		        $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_log', '$td', '$time', '$my_ID', '$active')";
		        $query_log_run = mysqli_query($conn, $sql_log);
			    if ($query_log_run) {
			    	$get_name_id = $_SESSION['coordinator_fname']." ".$_SESSION['coordinator_mname']." ".$_SESSION['coordinator_lname']." (".$_SESSION['coordinator_id'].")";

	                $userType = "Teacher";
	                $session_audit = $get_name_id. " validated and forwarded the requirement of ".$stud_fullname." entitled ".$requirement." to ".$program_head_name." (Program Head of ".$my_course.")";
	                $sql_audit = "INSERT INTO tbl_audit_trail (activity, date_, time_, by_, status, userType) VALUES ('$session_audit', '$td', '$time', '$get_name_id', '$active', '$userType')";
	                $query_audit_run = mysqli_query($conn, $sql_audit);
		            if($query_audit_run){
						$_SESSION['forwarded'] = $stud_fullname." requirement has been forwarded!";
				        header('location: my_stud_requirements_completed.php?forwardedSuccessfully');
						exit;
					}
				}
			}
		}
		else{

		}
	}
	else{
		$_SESSION['completed_error'] = "You Are Not Be Able to Forward This Document to Program Head!";
		header("Location: my_stud_requirements_submitted_details.php?req_id=" . $id);
		exit;
	}
} ///end

?>