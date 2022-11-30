<?php
// Initialize the session.
// If you are using session_name("something"), don't forget it now!
session_start();

require_once('db_connect.php');
date_default_timezone_set('Asia/Manila');
$timestamp = time();
$date_ = date("F d, Y");
$time_ = date("h:i:s A");

// Unset all of the session variables.
//$_SESSION = array();

// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
// if (ini_get("session.use_cookies")) {
//     $params = session_get_cookie_params();
//     setcookie(session_name(), '', time() - 42000,
//         $params["path"], $params["domain"],
//         $params["secure"], $params["httponly"]
//     );
// }

$active = "active";
$session_login = "You logged out at e-OJT aCCeSs";
//log session
$my_ID = $_SESSION['coordinator_id'];
$sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_login', '$date_', '$time_', '$my_ID', '$active')";
$query_log_run = mysqli_query($conn, $sql_log);
if($query_log_run){
    $get_name_id = $_SESSION['coordinator_fname']." ".$_SESSION['coordinator_mname']." ".$_SESSION['coordinator_lname']." (".$_SESSION['coordinator_id'].")";

    $userType = "Program Head";
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