<?php
require_once('includes/db_connect.php');
session_start();
$get_id = $_GET['id'];
$stats = "active";

// sql to delete a record
$sql = "UPDATE tbl_coordinators SET status='$stats' where id = '$get_id'";

$res = $conn->query($sql);
// use exec() because no results are returned
if($res){
	$_SESSION['set_active'] = "Account has been set to active.";
	header('location: coordinators_account.php');
}
else {
	"<script> alert('Error!'); window.location='coordinators_account.php'</script>";
}
?>
