<?php
require_once('includes/db_connect.php');

$get_id = $_GET['id'];
$stats = "archive";

// sql to delete a record
$sql = "UPDATE tbl_ojt_categories SET status='$stats' where id = '$get_id'";

$res = $conn->query($sql); 
// use exec() because no results are returned

if($res){
	header('location: ojt_categories.php?deleted=$id');			
}
else {
	"<script> alert('Error!'); window.location='ojt_categories.php'</script>";
}
?>