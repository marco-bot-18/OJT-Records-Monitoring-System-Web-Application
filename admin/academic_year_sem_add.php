<?php
require_once('includes/db_connect.php');
session_start();

date_default_timezone_set('Asia/Manila');
$timestamp = time();
$date_ = date("F d, Y");
$time_ = date("h:i:s A");

$from = $_POST['from'];
$to = $_POST['to'];
$acad_yr = $from."-".$to;
$semester = $_POST['semester'];
$active = "active";

$sql = "INSERT INTO tbl_academic_year_sem(academic_yr, semester, status) VALUES ('$acad_yr', '$semester', '$active')";

$query_run = mysqli_query($conn, $sql);

    if($query_run) {
        $active = "active";
        $session_log = "You created a new academic year <b>".$acad_yr."</b> and semester <b>".$semester."</b>";
        $my_ID = $_SESSION['admin_username'];
        $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_log', '$date_', '$time_', '$my_ID', '$active')";
        $query_log_run = mysqli_query($conn, $sql_log);
        if($query_log_run){
            $get_name_id = $_SESSION['admin_fname']." ".$_SESSION['admin_mname']." ".$_SESSION['admin_lname']." (".$_SESSION['admin_username'].")";

            $userType = "Dean";

            $session_audit =  $get_name_id." created a new academic year <b>".$acad_yr."</b> and semester <b>".$semester."</b>";
            $sql_audit = "INSERT INTO tbl_audit_trail (activity, date_, time_, by_, status, userType) VALUES ('$session_audit', '$date_', '$time_', '$get_name_id', '$active', '$userType')";
            $query_audit_run = mysqli_query($conn, $sql_audit);
            if($query_audit_run){
                $_SESSION['success'] = $acad_yr." ".$semester;
                header('location: academic_year_sem.php?=AcademicYear&SemSuccessfullyCreated');
            }
        }
    }
    else {
        echo "<script> alert('Error: Record Not Inserted!'); window.location='academic_year_sem.php'</script>";
    }
