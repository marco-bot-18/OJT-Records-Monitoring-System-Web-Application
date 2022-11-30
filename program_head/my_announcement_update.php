<?php
// require_once('includes/db_connect.php');
// session_start();
// if (isset($_POST['update'])) 
// {	
// 	$ann_id = $_POST['ann_id'];
// 	$announcement_description = $_POST['announcement_description'];
// 	$announcement_title = $_POST['announcement_title'];
// 	$edited = "(edited)";

// 	$sql = "UPDATE tbl_announcement SET title='$announcement_title', description='$announcement_description', edited='$edited' WHERE id = '$ann_id' ";

// 	$query_run = mysqli_query($conn, $sql);

// 	if($query_run)
// 	{
//     	header('location: announcement_for_today.php?updated=1');
// 	}
// 	else
// 	{
// 		echo $conn->error;
// 	}
// }

?>

<?php
require_once('includes/db_connect.php');
session_start();
if (isset($_POST['update'])) 
{	
	//document
	$file_location = "../admin/upload_docs/";
	$file = $_FILES['sample_file']['name'];
	$file_temp = $_FILES['sample_file']['tmp_name'];
	$file_size = $_FILES['sample_file']['size'];

	$ann_id = $_POST['announcement_id_teacher'];
	$announcement_description = $_POST['announcement_description'];
	$announcement_title = $_POST['announcement_title'];
	$edited = "(edited)";

	$sql = "UPDATE tbl_announcement SET title='$announcement_title', description='$announcement_description', file='$file', edited='$edited' WHERE announcement_id = '$ann_id' ";

	$query_run = mysqli_query($conn, $sql);

	if($query_run)
	{
		$sql1 = "UPDATE tbl_announcement_receiver SET title='$announcement_title', description='$announcement_description', file='$file', edited='$edited' WHERE announcement_id = '$ann_id' ";

		$query_run1 = mysqli_query($conn, $sql1);

		if($query_run1){
			move_uploaded_file($file_temp, $file_location.$_FILES['sample_file']['name']);
			header('location: my_announcement_history.php?updated=1');
		}
		else { echo $conn->error; }
	}
	else
	{
		echo $conn->error;
	}
}

?>