<?php
require_once('includes/db_connect.php');
session_start();
$get_id = $_GET['id'];
$stats = "not active";

// sql to delete a record
$sql = "UPDATE tbl_academic_year_sem SET status='$stats' where id = '$get_id'";

$res = $conn->query($sql);

if($res){
	$_SESSION['success2'] = "Success";
	header('location: academic_year_sem.php');
}
else {
	
}
?>
