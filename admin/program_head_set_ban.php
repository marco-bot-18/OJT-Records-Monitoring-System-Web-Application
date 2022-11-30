<?php
require_once('includes/db_connect.php');
session_start();
$get_id = $_GET['id'];
$stats = "not active";

// sql to delete a record
$sql = "UPDATE tbl_coordinators SET status='$stats' where id = '$get_id'";

$res = $conn->query($sql);
// use exec() because no results are returned
if($res){
	$_SESSION['set_not_active'] = "Account has been set to not active.";
	header('location: program_head_account.php');
}
else {
	"<script> alert('Error!'); window.location='program_head_account.php'</script>";
}
?>
