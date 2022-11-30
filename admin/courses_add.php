<?php
require_once('includes/db_connect.php');
session_start();

//date and time
date_default_timezone_set('Asia/Manila');
$timestamp = time();
$td = date("F d, Y");
$time = date("h:i:s A");

$course_acronym = $_POST['course_acronym'];
$course_title = $_POST['course_title'];
$year = $_POST['year'];
$section = $_POST['section'];
$specialization = $_POST['specialization'];
$course_description = $_POST['course_description'];

$not_archived = "not archived";

$full_description = $course_title." ".$year."".$section." - ".$specialization;

$sql = "INSERT INTO tbl_courses(course_code, course_title, course_description, archived) VALUES ('$course_acronym', '$full_description', '$course_description', '$not_archived')";

$query_run = mysqli_query($conn, $sql);

    if($query_run) {
        $active = "active";
        $my_ID = $_SESSION['admin_username'];
        $session_log = "You created a course, year and section ".$full_description;
        //log session
        $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_log', '$td', '$time', '$my_ID', '$active')";
        $query_log_run = mysqli_query($conn, $sql_log);
        if ($query_log_run) {
            $_SESSION['success'] = $full_description;
            header('location: courses.php?CourseSuccessfullyCreated');
        }
    }
    else {
        echo "<script> alert('Error: Record Not Inserted!'); window.location='news.php'</script>";
    }

//header('location: news.php?=successfullyadded');
?>