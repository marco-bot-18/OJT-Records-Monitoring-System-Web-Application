<?php
require_once('includes/db_connect.php');
session_start();

date_default_timezone_set('Asia/Manila');
$timestamp = time();
$td = date("F d, Y");
$time = date("h:i:s A");

if(isset($_POST['update'])){
    $id = $_POST['id'];
    $stud_fullname = $_POST['stud_fullname'];
    $stud_uniq_id = $_POST['stud_uniq_id'];
    $category_desc = $_POST['category_desc'];
    $remarks = $_POST['remarks'];
    
    $sql2 = "UPDATE tbl_students SET category_desc='$category_desc', remarks='$remarks' WHERE id='$id' and uniq_id='$stud_uniq_id'";
    $query_run1 = mysqli_query($conn, $sql2);

    if($query_run1){
        $active = "active";
        $my_ID = $_SESSION['coordinator_id'];
        $session_login = "You updated the category description and remarks of ".$stud_fullname;
        //log session
        $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_login', '$td', '$time', '$my_ID', '$active')";
        $query_log_run = mysqli_query($conn, $sql_log);
        if ($query_log_run) {
            $_SESSION['success'] = $stud_fullname;
            header('location: students_category.php?=category_details_updated');
        }
    }
    else{
        echo "".$conn->error."";
    }
}
?>