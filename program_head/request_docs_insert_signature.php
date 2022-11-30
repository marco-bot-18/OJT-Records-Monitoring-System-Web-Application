<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';

require_once('includes/db_connect.php');

date_default_timezone_set('Asia/Manila');
$timestamp = time();
$date_ = date("F d, Y");
$time_ = date("h:i:s A");

//calling mpdf function
$mpdf = new \Mpdf\Mpdf();
$mpdf->showImageErrors = true;

$fileID = intval($_GET['file_id']);
$sql = "SELECT * from tbl_students_work WHERE id='$fileID'";
$query = $conn->query($sql);
while($row = $query->fetch_assoc()){
	$_SESSION['get_filename1'] = $row['uploaded_file'];
	$_SESSION['get_name'] = $row['stud_name_and_id'];
	$_SESSION['get_title'] = $row['title'];
}

$userType = $_SESSION['coordinator_fullname_session']; //owner ng signature
$ses_sql = mysqli_query($conn, "SELECT * FROM tbl_signature WHERE owner_signature='$userType'");
$row1 = mysqli_fetch_array($ses_sql, MYSQLI_ASSOC);

$pagecount = $mpdf->SetSourceFile('../students/upload_docs/'.$_SESSION['get_filename1']);

$signature = $_SESSION['my_signature_program_head'];

// Define the Headers before writing anything so they appear on the first page
$mpdf->SetHTMLHeader(
		'<div style=""></div>','O'
	);
	
$mpdf->SetHTMLHeader('<div style="border-bottom: 1px solid #000000;"></div>','E');

//insert the signature
$mpdf->SetHTMLFooter(
	'<div style="position: absolute; left:130; right: 22; top: 710; bottom: 0;">
		<img src="uploaded_signature_imgs/'.$row['image'].'" width="110" height="50"> 
	</div>'
);

$mpdf->SetHTMLFooter('', 'E');

$tplId = $mpdf->ImportPage($pagecount);
$mpdf->UseTemplate($tplId);
$mpdf->SetTitle('With Signature');
$mpdf->WriteHTML('');

$stud_fullname = $_SESSION['get_name'];
$filename = $_SESSION['get_title'];

$active = "active";
$session_login = "You signed the document (".$filename.") of ".$stud_fullname;
//log session
$my_ID = $_SESSION['coordinator_id'];
$sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_login', '$date_', '$time_', '$my_ID', '$active')";
$query_log_run = mysqli_query($conn, $sql_log);
if($query_log_run){
	$get_name_id = $_SESSION['coordinator_fname']." ".$_SESSION['coordinator_mname']." ".$_SESSION['coordinator_lname']." (".$_SESSION['coordinator_id'].")";

    $userType = "Program Head";
    $session_audit =  $get_name_id." signed the document (".$filename.") of ".$stud_fullname;
    $sql_audit = "INSERT INTO tbl_audit_trail (activity, date_, time_, by_, status, userType) VALUES ('$session_audit', '$date_', '$time_', '$get_name_id', '$active', '$userType')";
    $query_audit_run = mysqli_query($conn, $sql_audit);
    if($query_audit_run){
		$_SESSION['signed'] = $stud_fullname. " document has been signed. The requirement (". $filename .") is now enable to forward to Dean";
		header("location: request_docs_pending.php?signed");
	}
}

//$mpdf->Output($_SESSION['get_filename1'], 'D');
// ob_clean();

//save in specific folder
$mpdf->Output("D:/xampp/htdocs/CCS-OJT-Records-Monitoring-System/program_head/signed_docs/".$_SESSION['get_filename1'], "F");
//download file
$mpdf->Output($_SESSION['get_filename1'], "D");
?>