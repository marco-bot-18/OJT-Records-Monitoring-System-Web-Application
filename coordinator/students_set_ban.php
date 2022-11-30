<?php
require_once('includes/db_connect.php');

$get_id = $_GET['id'];
$stats = "not active";

// sql to delete a record
$sql = "UPDATE tbl_students SET status='$stats' where stud_id = '$get_id'";

$res = $conn->query($sql); 
// use exec() because no results are returned
if($res){
	header('location: student_account.php?setbanned=1');			
}
else {
	"<script> alert('Error!'); window.location='students.php'</script>";
}
?>