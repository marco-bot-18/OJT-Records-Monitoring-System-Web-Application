<?php
require_once('includes/db_connect.php');

$get_id = $_GET['id']; //get the 'id' of student
$stats = "active";

$sql = "UPDATE tbl_students SET status='$stats' where stud_id = '$get_id'";
$res = $conn->query($sql);

if ($res) {
	header('location: student_account.php?setactive=1');
} else {
	"<script> alert('Error!'); window.location='students.php'</script>";
}
