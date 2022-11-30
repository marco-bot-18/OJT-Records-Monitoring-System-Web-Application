<?php
include 'includes/db_connect.php';
include 'includes/session.php';

session_start();

//PHPMAILER
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php'; 

//for time and date
date_default_timezone_set('Asia/Manila');
$timestamp = time();
$td = date("F d, Y");
$time = date("h:i:s A");

$number = uniqid();
$varray = str_split($number);
$len = sizeof($varray);
$otp = array_slice($varray, $len-3, $len);
$otp = implode(",", $otp);
$otp = str_replace(',', '', $otp."-");

$tasks_title = $_POST['tasks_title'];
$instructions = $_POST['instructions'];
$duedate = $_POST['duedate'];

$myfullname_ = $_SESSION['coordinator_fullname_session'];
$uniq_id = $_SESSION['uniq_id']; //teacher uniq id

$sendTo = $_POST['send_to'];
$stats = "not archived";
$work_stats = "pending";
$isRead = 0;
$task_code = uniqid('task-');

$file_location = "../admin/upload_docs/";

$sample_file = $_FILES['sample_file']['name'];
if($_FILES['sample_file']['name'] != "") {
    $sample_file = $otp.basename($_FILES['sample_file']['name']);
}
else{
    $sample_file = basename($_FILES['sample_file']['name']);
}

$unsent = "unsent";
$isRead = 0;

    if($tasks_title == "Memorandum of Agreement"){
        $off_campus = "Off-Campus";
        $id1 = $_SESSION['coordinator_id'];         
        $sql1 = "SELECT Concat(fname, ' ', mname,' ', lname, ' ', '(', coordinator_id, ')') AS fullname FROM tbl_coordinators where coordinator_id = '$id1'";
        $query1 = $conn->query($sql1);

        //while ang student's teacher (students handle by this teacher) = sa mismong teacher account na to
        while($row1 = $query1->fetch_assoc()){
            $_SESSION['coordinator_fullname'] = $row1['fullname'];
        }

        //get the coordinator's name and id para makuha nya yung student's teacher/coordinator na mageequal sa tbl_students
        $coordinator_fullname = $_SESSION['coordinator_fullname']; //from includes/session.php 
        $stats = "not archived";

        //insert to my works bukod yung sa mismong students; to have my copy
        $sql3 = "INSERT INTO tbl_coordinator_save_works (title, instructions, date_of_submission, isRead, date_, time_, name_of_teacher, status, sendTo, task_code, sample_file, teacher_uniq_id) VALUES ('$tasks_title', '$instructions', '$duedate', '$isRead', '$td', '$time', '$coordinator_fullname', '$stats', '$sendTo', '$task_code', '$sample_file', '$uniq_id')";
        $query_run3 = mysqli_query($conn, $sql3);
        
        $sql2 = "SELECT Concat(fname,' ',mname, ' ', lname,' ','(', stud_id,')') AS stud_fullname, course AS COURSE_, uniq_id, email FROM tbl_students where coordinator='$coordinator_fullname' and in_off_campus='$off_campus'";
        $query2 = $conn->query($sql2);

        $mail = new PHPMailer(true);
        $mail->SMTPDebug = 1;                      
        $mail->isSMTP();                                           
        $mail->Host       = 'smtp.gmail.com';                     
        $mail->SMTPAuth   = true;                                   
        $mail->Username   = 'websiteet18@gmail.com';                     
        $mail->Password   = 'empowermenttechnology';                               
        $mail->SMTPSecure = "tls"; 
        $mail->Port       = 587; 

        //this lines of code will insert multiple data in rows in tbl_students_work
        while($row2 = $query2->fetch_assoc()){
            $student_fullname_id = $row2['stud_fullname'];//selecting the student names which is handled by this coordinators account
            $course = $row2['COURSE_'];
            $stud_uniq_id = $row2['uniq_id'];
            $submitted = "no";
            $get_email = $row2['email'];

            //Recipients
            $mail->setFrom('websiteet18@gmail.com',  $myfullname_);
            $mail->addAddress($get_email); //Name is optional
            
            //Content
            $mail->isHTML(true);//Set email format to HTML
            $mail->Subject = "e-OJT aCCeSs: New Requirement";
            $template = "This is your requirement: <b>".$tasks_title."</b><br> Due date is in ".$duedate.". Please submit the requirement before or during the due date. <br> Instructions: ".$instructions."";
            $mail->Body = $template;

            //while the students name = coordinator name the loop will continue to insert datas 
            $sql = "INSERT INTO tbl_students_work(stud_name_and_id, course, title, instructions, date_of_submission, date_, time_, name_of_teacher, isRead, work_status, send_to, status, task_code, sample_file, submitted, stud_uniq_id, isReadStud, email_notify_late, email_notify_due, teacher_uniq_id) VALUES 
            ('$student_fullname_id', '$course', '$tasks_title', '$instructions', '$duedate', '$td', '$time', '$coordinator_fullname', '$isRead','$work_stats', '$sendTo', '$stats', '$task_code', '$sample_file', '$submitted', '$stud_uniq_id', '$isRead', '$unsent', '$unsent', '$uniq_id')";

            $query_run = mysqli_query($conn, $sql);
                
            if($query_run){
                $active = "active";
                $my_ID = $_SESSION['coordinator_id'];
                $session_log = "You created a submittal for your students entitled ".$tasks_title;
                //log session
                $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_log', '$td', '$time', '$my_ID', '$active')";
                $query_log_run = mysqli_query($conn, $sql_log);
                if ($query_log_run) {
                    $get_name_id = $_SESSION['coordinator_fname']." ".$_SESSION['coordinator_mname']." ".$_SESSION['coordinator_lname']." (".$_SESSION['coordinator_id'].")";

                    $userType = "Teacher";
                    $session_audit = $get_name_id. " created a submittal for his/her students entitled ".$tasks_title;
                    $sql_audit = "INSERT INTO tbl_audit_trail (activity, date_, time_, by_, status, userType) VALUES ('$session_audit', '$td', '$time', '$get_name_id', '$active', '$userType')";
                    $query_audit_run = mysqli_query($conn, $sql_audit);
                    if($query_audit_run){
                        move_uploaded_file($file_temp, $file_location.$sample_file);
                        $_SESSION['success'] = $tasks_title;
                        header('location: my_requirements_for_students.php?createdSuccessFully');
                    }
                }
            }
            else {
                echo " ".$conn->error;
            }
        }
        $mail->send();
        $_SESSION['success'] = $tasks_title;
        header('location: my_requirements_for_students.php?createdSuccessFully');
    }

    // else statement
    else {
        $id1 = $_SESSION['coordinator_id'];         
        $sql1 = "SELECT Concat(fname, ' ', mname,' ', lname, ' ', '(', coordinator_id, ')') AS fullname FROM tbl_coordinators where coordinator_id = '$id1'";
        $query1 = $conn->query($sql1);

        //while ang student's teacher (students handle by this teacher) = sa mismong teacher account na to
        while($row1 = $query1->fetch_assoc()){
            $_SESSION['coordinator_fullname'] = $row1['fullname'];
        }

        //get the coordinator's name and id para makuha nya yung student's teacher/coordinator na mageequal sa tbl_students
        $coordinator_fullname = $_SESSION['coordinator_fullname']; //from includes/session.php 
        $stats = "not archived";

        //insert to my works bukod yung sa mismong students and company
        $sql3 =  "INSERT INTO tbl_coordinator_save_works (title, instructions, date_of_submission, isRead, date_, time_, name_of_teacher, status, sendTo, task_code, sample_file, teacher_uniq_id) VALUES ('$tasks_title', '$instructions', '$duedate', '$isRead', '$td', '$time', '$coordinator_fullname', '$stats', '$sendTo', '$task_code', '$sample_file', '$uniq_id')";

        $query_run3 = mysqli_query($conn, $sql3);

        $sql2 = "SELECT Concat(fname,' ',mname, ' ', lname,' ','(', stud_id,')') AS stud_fullname, course AS COURSE_, uniq_id, email FROM tbl_students where coordinator='$coordinator_fullname'";

        $query2 = $conn->query($sql2);
        
        $mail = new PHPMailer(true);
        $mail->SMTPDebug = 1;                      
        $mail->isSMTP();                                            
        $mail->Host       = 'smtp.gmail.com';                     
        $mail->SMTPAuth   = true;                                  
        $mail->Username   = 'websiteet18@gmail.com';                     
        $mail->Password   = 'empowermenttechnology';                               
        $mail->SMTPSecure = "tls"; 
        $mail->Port       = 587; 

        //this lines of code will insert multiple data in rows in tbl_students_work
        while($row2 = $query2->fetch_assoc()){
            $student_fullname_id = $row2['stud_fullname'];//selecting the student names which is handled by this coordinators account
            $course = $row2['COURSE_'];
            $stud_uniq_id = $row2['uniq_id'];
            $submitted = "no";
            $get_email = $row2['email'];

            //Recipients
            $mail->setFrom('websiteet18@gmail.com',  $myfullname_);
            $mail->addAddress($get_email);//Name is optional
            //Content
            $mail->isHTML(true);//Set email format to HTML
            $mail->Subject = "e-OJT aCCeSs: New Requirement";
            $template    = "This is your requirement: <b>".$tasks_title."</b><br> Due date is in ".$duedate.". Please submit the requirement before or during the due date. <br> Instructions: ".$instructions."";
            $mail->Body = $template;


            //while the students name = coordinator name the loop will continue to insert datas 
            $sql = "INSERT INTO tbl_students_work(stud_name_and_id, course, title, instructions, date_of_submission, date_, time_, name_of_teacher, isRead, work_status, send_to, status, task_code, sample_file, submitted, stud_uniq_id, isReadStud, email_notify_late, email_notify_due, teacher_uniq_id) VALUES 
            ('$student_fullname_id', '$course', '$tasks_title', '$instructions', '$duedate', '$td', '$time', '$coordinator_fullname', '$isRead','$work_stats', '$sendTo', '$stats', '$task_code', '$sample_file', '$submitted', '$stud_uniq_id', '$isRead', '$unsent', '$unsent', '$uniq_id')";

            $query_run = mysqli_query($conn, $sql);
                
            if($query_run){
                $active = "active";
                $my_ID = $_SESSION['coordinator_id'];
                $session_log = "You created a submittal for your students entitled ".$tasks_title;
                //log session
                $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_log', '$td', '$time', '$my_ID', '$active')";
                $query_log_run = mysqli_query($conn, $sql_log);
                if ($query_log_run) {
                    $get_name_id = $_SESSION['coordinator_fname']." ".$_SESSION['coordinator_mname']." ".$_SESSION['coordinator_lname']." (".$_SESSION['coordinator_id'].")";

                    $userType = "Teacher";
                    $session_audit = $get_name_id. " created a submittal for his/her students entitled ".$tasks_title;
                    $sql_audit = "INSERT INTO tbl_audit_trail (activity, date_, time_, by_, status, userType) VALUES ('$session_audit', '$td', '$time', '$get_name_id', '$active', '$userType')";
                    $query_audit_run = mysqli_query($conn, $sql_audit);
                    if($query_audit_run){
                        move_uploaded_file($file_temp, $file_location.$sample_file);
                        $_SESSION['success'] = $tasks_title;
                        header('location: my_requirements_for_students.php?createdSuccessFully');
                    }
                }
            }
            else
            {
                echo " ".$conn->error;
            }
        }
        $mail->send();
        $_SESSION['success'] = $tasks_title;
        header('location: my_requirements_for_students.php?createdSuccessFully');
    }
?>