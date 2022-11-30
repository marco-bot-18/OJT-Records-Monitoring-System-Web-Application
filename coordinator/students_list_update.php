<?php
require_once('includes/db_connect.php');
session_start();
if (isset($_POST['update'])) 
{	
	$remarks = $_POST['remarks'];
	$stud_id = $_POST['stud_id'];
	//$hrs_required = $_POST['hrs_required'];
	//$off_in_campus = $_POST['off_in_campus'];
	//$stud_company = $_POST['stud_company'];

	$sql = "UPDATE tbl_students SET remarks='$remarks' WHERE stud_id = '$stud_id' ";
	//$sql = "UPDATE tbl_students SET remarks='$remarks', hours_required='$hrs_required', in_off_campus='$off_in_campus' WHERE stud_id = '$stud_id' ";
	$query_run = mysqli_query($conn, $sql);

	if($query_run)
	{
    	header('location: students_list.php?updated=1');
	}
	
	else
	{
		echo $conn->error;
	}
}

?>