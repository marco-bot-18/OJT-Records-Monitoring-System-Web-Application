<?php
require 'db_connect.php';
$isread = 1;
$stats = "active";

// sql to delete a record
$sql = "UPDATE tbl_students_work SET isRead='$isread'";

$res = $conn->query($sql);
// use exec() because no results are returned
if($res){
    header('location: ../stud_requirements_complete.php');
}
else {
    echo $conn->error;
}
?>


?>