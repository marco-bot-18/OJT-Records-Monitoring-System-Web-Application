<?php
session_start();
require_once 'includes/session.php';
require_once('includes/db_connect.php');

//date and time
date_default_timezone_set('Asia/Manila');
$timestamp = time();
$td = date("F d, Y");
$time = date("h:i:s A");

$full_name_and_id = $_POST['fullname_id'];
$coordinator_id = $_POST['coordinator_id'];
$my_password = md5($_POST['my_password']);
$course = $_POST['course'];
$acad_yr_sem = $_POST['acad_yr_sem'];
$isArchived = "not archived";
$userType = "program_head";
$correct_password = $_SESSION['admin_password'];

if (isset($_POST['retrieve'])) {
    if($my_password == $correct_password){
        $sql = "UPDATE tbl_coordinators SET course='$course', academic_yr_sem='$acad_yr_sem', isArchived='$isArchived' WHERE userType='$userType' and coordinator_id='$coordinator_id'";
        $query_run = mysqli_query($conn, $sql);
        if($query_run){
            $active = "active";
            $session_log = "You retrieved the program head user account of <b>".$full_name_and_id."</b>";
            $my_ID = $_SESSION['admin_username'];
            $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_log', '$td', '$time', '$my_ID', '$active')";
            $query_log_run = mysqli_query($conn, $sql_log);
            if($query_log_run){
                $get_name_id = $_SESSION['admin_fname']." ".$_SESSION['admin_mname']." ".$_SESSION['admin_lname']." (".$_SESSION['admin_username'].")";

                $userType = "Dean";

                $session_audit =  $get_name_id." retrieved the program head user account of <b>".$full_name_and_id."</b>";
                $sql_audit = "INSERT INTO tbl_audit_trail (activity, date_, time_, by_, status, userType) VALUES ('$session_audit', '$td', '$time', '$get_name_id', '$active', '$userType')";
                $query_audit_run = mysqli_query($conn, $sql_audit);
                if($query_audit_run){
                    $_SESSION['retrieved'] = $full_name_and_id;
                    header('location: program_head_accounts_archives.php');
                }
            }
        }
    }
    else{
        $_SESSION['wrong_password'] = "Your Password is Incorrect!";
        header('location: program_head_accounts_archives.php');
    }
}
?>