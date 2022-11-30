<?php
require_once('includes/db_connect.php');

$get_id = $_GET['id'];
$work_stats = "semi-pending";
$blank = "";
$isRead = "3";
// sql to delete a record
$sql = "UPDATE tbl_students_work SET work_status='$work_stats', send_to_PH='$blank', program_head_forward_date='$blank', isReadPH='$isRead' where id = '$get_id'";

$res = $conn->query($sql); 

if($res){
	header('location: my_stud_requirements_completed_sent_to_PH.php?undoforward=1');
}
else{
	echo $conn->error;
}		
?>