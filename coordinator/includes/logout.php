<?php
// Initialize the session
session_start();
require_once('db_connect.php');
date_default_timezone_set('Asia/Manila');
$timestamp = time();
$date_ = date("F d, Y");
$time_ = date("h:i:s A");

$active = "active";
$session_login = "You logged out at e-OJT aCCeSs";
$my_ID = $_SESSION['coordinator_id'];
$sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_login', '$date_', '$time_', '$my_ID', '$active')";
$query_log_run = mysqli_query($conn, $sql_log);
if($query_log_run){
    $get_name_id = $_SESSION['coordinator_fname']." ".$_SESSION['coordinator_mname']." ".$_SESSION['coordinator_lname']." (".$_SESSION['coordinator_id'].")";

    $userType = "Teacher";
    $session_audit = $get_name_id. " logged out in the system";
    $sql_audit = "INSERT INTO tbl_audit_trail (activity, date_, time_, by_, status, userType) VALUES ('$session_audit', '$date_', '$time_', '$get_name_id', '$active', '$userType')";
    $query_audit_run = mysqli_query($conn, $sql_audit);
    if($query_audit_run){
        // Finally, destroy the session.
        session_destroy();
        unset($_SESSION['coordinator_id']);
        header('location: ../../index.php');
    }        
}

?>