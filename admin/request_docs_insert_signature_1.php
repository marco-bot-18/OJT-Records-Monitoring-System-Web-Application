<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';

require_once('includes/db_connect.php');

//date and time
date_default_timezone_set('Asia/Manila');
$timestamp = time();
$date_ = date("F d, Y");
$time_ = date("h:i:s A");

//calling mpdf function
$mpdf = new \Mpdf\Mpdf();

$fileID = intval($_GET['file_id']);
$sql = "SELECT * from tbl_students_work where id='$fileID'"; //get the ID of the file (pdf document) 
$query = $conn->query($sql);
while($row = $query->fetch_assoc()){
	$_SESSION['get_filename'] = $row['uploaded_file'];
	$_SESSION['get_name'] = $row['stud_name_and_id'];
	$_SESSION['get_title'] = $row['title'];
}

$userType = "Dean";

//get the e-signature of dean in 'tbl_signature'
$ses_sql = mysqli_query($conn,"SELECT * FROM tbl_signature where owner_signature='$userType'"); 
$row = mysqli_fetch_array($ses_sql, MYSQLI_ASSOC);

$pagecount = $mpdf->SetSourceFile('../program_head/signed_docs/'.$_SESSION['get_filename']);

$signature = $_SESSION['my_signature'];

$filename = $_SESSION['get_filename'];

$stud_fullname = $_SESSION['get_name'];
$title = $_SESSION['get_title'];

// Define the Headers before writing anything so they appear on the first page
$mpdf->SetHTMLHeader(
	'<div style=""></div>','O'
);
$mpdf->SetHTMLHeader('<div style="border-bottom: 1px solid #000000;"></div>','E');

//ATTACHED THE E-SIGNATURE
$mpdf->SetHTMLFooter(
	'<div style="position: absolute; left:240; right: 22; bottom: 270;">
 		<img src="uploaded_signature_imgs/'.$row['image'].'" width="110" height="50"> 
	</div>'
);


$tplId = $mpdf->ImportPage($pagecount);
$mpdf->UseTemplate($tplId);
$mpdf->SetTitle('With Signature');
$mpdf->WriteHTML('');
//$mpdf->Output($_SESSION['get_filename'], 'I');

$active = "active";
$session_log = "You signed the document (".$filename.") of ".$stud_fullname;
$my_ID = $_SESSION['admin_username'];
$sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) 
			VALUES ('$session_log', '$date_', '$time_', '$my_ID', '$active')";
$query_log_run = mysqli_query($conn, $sql_log);
if($query_log_run){
	$get_name_id = $_SESSION['admin_fname']." ".$_SESSION['admin_mname']." ".$_SESSION['admin_lname']." (".$_SESSION['admin_username'].")";

    $userType = "Dean";

    $session_audit =  $get_name_id." signed the document (".$filename.") of ".$stud_fullname;
    $sql_audit = "INSERT INTO tbl_audit_trail (activity, date_, time_, by_, status, userType) 
				VALUES ('$session_audit', '$date_', '$time_', '$get_name_id', '$active', '$userType')";
    $query_audit_run = mysqli_query($conn, $sql_audit);
    if($query_audit_run){
		$_SESSION['signed_docs_success'] = $stud_fullname. " document has been signed. You are now be able to set the requirement (" . $title .") in completed status.";
		header("Location: request_docs_pending_details.php?req_id=" . $fileID);
	}
}

//save in specific folder
$mpdf->Output("D:/xampp/htdocs/CCS-OJT-Records-Monitoring-System/admin/signed_docs/".$_SESSION['get_filename'], "F");

//preview and download the PDF file
$mpdf->Output($_SESSION['get_filename'], "D");

?>