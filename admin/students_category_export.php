<?php
include('includes/db_connect.php');
error_reporting();
session_start();

//date and time
date_default_timezone_set('Asia/Manila');
$timestamp = time();
$date_ = date("F d, Y");
$time_ = date("h:i:s A");

$not_archived = "not archive";

if (isset($_POST['excel'])) {

	$active = "active";
	$session_log = "You generated a report of students category in excel format";
	$my_ID = $_SESSION['admin_username'];
	$sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_log', '$date_', '$time_', '$my_ID', '$active')";
	$query_log_run = mysqli_query($conn, $sql_log);
	if ($query_log_run) {
		$get_name_id = $_SESSION['admin_fname'] . " " . $_SESSION['admin_mname'] . " " . $_SESSION['admin_lname'] . " (" . $_SESSION['admin_username'] . ")";

		$userType = "Dean";

		$session_audit =  $get_name_id . " generated a report of students submittals excel format";
		$sql_audit = "INSERT INTO tbl_audit_trail (activity, date_, time_, by_, status, userType) VALUES ('$session_audit', '$date_', '$time_', '$get_name_id', '$active', '$userType')";
		$query_audit_run = mysqli_query($conn, $sql_audit);
	}

	$section = $_POST['section'];

	header("Content-Type: application/xls");
	header("Content-Disposition: attachment; filename=students_category_reports.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	$output = "";

	if ($_POST['section'] == "") {
		$output .= "
			<h2 align='center'>Students Category Report</h2>
			<h4>Course, Year and Section: All CCS 4th Years</h4>
				<table border='1' cellspacing='4'>
					<thead>
						<tr>
						  <th>No.</th>
                          <th>Student ID</th>
                          <th>Student Name</th>
                          <th>Course, Yr & Section</th>
                          <th>Category</th>
                          <th>Category Description</th>
                          <th>Remarks</th>
						</tr>
					<tbody>
			";

		$count = 1;
		$query = $conn->query("SELECT * FROM tbl_students WHERE archived='$not_archived' ORDER by lname ASC") or die(mysqli_errno());
		while ($fetch = $query->fetch_array()) {
			$output .= "
						<tr>
							<td>" . $count . "</td>
							<td>" . $fetch['stud_id'] . "</td>
							<td>" . $fetch['lname'] . ", " . $fetch['fname'] . " " . $fetch['mname'] . "</td>
							<td>" . $fetch['course'] . "</td>
							<td>" . $fetch['ojt_category'] . "</td>
							<td>" . $fetch['category_desc'] . "</td>
							<td>" . $fetch['remarks'] . "</td>
						</tr>
			";
			$count++;
		}

		$output .= "
					</tbody>
					
				</table>
			";

		echo $output;
	}
	//
	else {
		$output .= "
			<h2 align='center'>Students Category Report</h2>
			<h4>Course, Year and Section: " . $section . "</h4>
				<table border='1' cellspacing='4'>
					<thead>
						<tr>
						  <th>No.</th>
                          <th>Student ID</th>
                          <th>Student Name</th>
                          <th>Course, Yr & Section</th>
                          <th>Category</th>
                          <th>Category Description</th>
                          <th>Remarks</th>
						</tr>
					<tbody>
			";
		$count = 1;
		$query = $conn->query("SELECT * FROM tbl_students WHERE course='$section' and archived='$not_archived' ORDER by lname ASC") or die(mysqli_error(self));
		while ($fetch = $query->fetch_array()) {
			$output .= "
						<tr>
						    <td>" . $count . "</td>
							<td>" . $fetch['stud_id'] . "</td>
							<td>" . $fetch['lname'] . ", " . $fetch['fname'] . " " . $fetch['mname'] . "</td>
							<td>" . $fetch['course'] . "</td>
							<td>" . $fetch['ojt_category'] . "</td>
							<td>" . $fetch['category_desc'] . "</td>
							<td>" . $fetch['remarks'] . "</td>
						</tr>
			";
			$count++;
		}

		$output .= "
					</tbody>
					
				</table>
			";

		echo $output;
	}
}

//export in pdf
else if (isset($_POST['pdf'])) {

	$active = "active";
	$session_log = "You generated a report of students submittals in pdf format";
	$my_ID = $_SESSION['admin_username'];
	$sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_log', '$date_', '$time_', '$my_ID', '$active')";
	$query_log_run = mysqli_query($conn, $sql_log);
	if ($query_log_run) {
		$get_name_id = $_SESSION['admin_fname'] . " " . $_SESSION['admin_mname'] . " " . $_SESSION['admin_lname'] . " (" . $_SESSION['admin_username'] . ")";

		$userType = "Dean";

		$session_audit =  $get_name_id . " generated a report of students category in pdf format";
		$sql_audit = "INSERT INTO tbl_audit_trail (activity, date_, time_, by_, status, userType) VALUES ('$session_audit', '$date_', '$time_', '$get_name_id', '$active', '$userType')";
		$query_audit_run = mysqli_query($conn, $sql_audit);
	}

	if ($_POST['section'] == "") {
		require_once('../tcpdf/tcpdf.php');
		class PDF extends TCPDF
		{
			//Page header
			public function Header()
			{
				// Logo
				$image_file = 'img/icon/ccs_logo.png';
				$this->Image($image_file, 250, 4, 30, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
				$this->Ln(5);
				$this->SetFont('helvetica', 'B', 10);
				$this->Cell(260, 5, 'College of Computer Studies', 0, 1, 'C');
				$this->Cell(260, 5, 'Laguna State Polytechnic University', 0, 1, 'C');
				$this->Cell(260, 5, 'Santa Cruz Campus', 0, 1, 'C');
				$this->SetFont('helvetica', 'B', 15);
				$this->Cell(260, 8, 'Students Category Report', 0, 1, 'C');
			}

			// Page footer
			public function Footer()
			{
				// Position at 15 mm from bottom
				$this->SetY(-15);
				// Set font
				$this->SetFont('helvetica', 'I', 8);
				// Page number
				$this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
			}
		}
		function generateRow()
		{
			$contents = '';
			$count = 1;
			$not_archived = "not archive";
			include('includes/db_connect.php');
			$sql = "SELECT * FROM tbl_students WHERE archived='$not_archived' ORDER by lname ASC";
			$query = $conn->query($sql);
			while ($row = $query->fetch_assoc()) {
				$contents .= "
				<tr>
					<td width='5%'>" . $count . "</td>
					<td>" . $row['stud_id'] . "</td>
					<td>" . $row['lname'] . ", " . $row['fname'] . " " . $row['mname'] . "</td>
					<td>" . $row['course'] . "</td>
					<td>" . $row['ojt_category'] . "</td>
					<td>" . $row['category_desc'] . "</td>
					<td>" . $row['remarks'] . "</td>
				</tr>
				";
				$count++;
			}
			return $contents;
		}
		// $your_width = 210 ;
		// $your_height = 297;
		// $custom_layout = array($your_width, $your_height);

		$pdf = new PDF('L', 'mm', 'A4', true, 'UTF-8', false);

		//set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetTitle("Students Category Report");
		$pdf->SetSubject('');
		$pdf->SetKeywords('');
		// $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);  
		// $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
		// $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
		// $pdf->SetDefaultMonospacedFont('helvetica');  
		// $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
		// $pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);  
		// $pdf->setPrintFooter(false);  
		// $pdf->SetAutoPageBreak(TRUE, 10);

		// set default header data
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 001', PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
		$pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));

		// set header and footer fonts
		$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, 40, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
			require_once(dirname(__FILE__) . '/lang/eng.php');
			$pdf->setLanguageArray($l);
		}
		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		$pdf->SetFont('helvetica', '', 10);
		$pdf->AddPage();
		$content = '';
		$content .= '
			<h4>Course, Year and Section: All CCS 4th Years</h4>
			<h4 align="left"> Prepared by: ' . $_SESSION['admin_fname'] . ' ' . $_SESSION['admin_mname'] . ' ' . $_SESSION['admin_lname'] . '</h4>
				<table border="1" cellspacing="0" cellpadding="3">
					<thead>
						<tr>
						  <th style="font-style: bold;">No.</th>
                          <th>Student ID</th>
                          <th>Student Name</th>
                          <th>Course, Yr & Section</th>
                          <th>Category</th>
                          <th>Category Description</th>
                          <th>Remarks</th>
						</tr>
					</thead>
		  ';
		$content .= generateRow();
		$content .= '</table>';
		$pdf->writeHTML($content);
		$pdf->Output('All-students_category.pdf');
	}
	//
	else {
		$section = $_POST['section'];
		require_once('../tcpdf/tcpdf.php');
		class PDF extends TCPDF
		{
			//Page header
			public function Header()
			{
				// Logo
				$image_file = 'img/icon/ccs_logo.png';
				$this->Image($image_file, 250, 4, 30, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
				$this->Ln(5);
				$this->SetFont('helvetica', 'B', 10);
				$this->Cell(260, 5, 'College of Computer Studies', 0, 1, 'C');
				$this->Cell(260, 5, 'Laguna State Polytechnic University', 0, 1, 'C');
				$this->Cell(260, 5, 'Santa Cruz Campus', 0, 1, 'C');
				$this->SetFont('helvetica', 'B', 15);
				$this->Cell(260, 8, 'Students Category Report', 0, 1, 'C');
			}

			// Page footer
			public function Footer()
			{
				// Position at 15 mm from bottom
				$this->SetY(-15);
				// Set font
				$this->SetFont('helvetica', 'I', 8);
				// Page number
				$this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
			}
		}
		function generateRow()
		{
			$contents = '';
			$count = 1;
			$not_archived = "not archive";
			$section = $_POST['section'];
			include('includes/db_connect.php');
			$sql = "SELECT * FROM tbl_students WHERE course='$section' and archived='$not_archived' ORDER by lname ASC";
			$query = $conn->query($sql);
			while ($row = $query->fetch_assoc()) {
				$contents .= "
				<tr>
					<td width='5%'>" . $count . "</td>
					<td>" . $row['stud_id'] . "</td>
					<td>" . $row['lname'] . ", " . $row['fname'] . " " . $row['mname'] . "</td>
					
					<td>" . $row['ojt_category'] . "</td>
					<td>" . $row['category_desc'] . "</td>
					<td>" . $row['remarks'] . "</td>
				</tr>
				"; //<td>".$row['course']."</td>
				$count++;
			}
			return $contents;
		}
		// $your_width = 210 ;
		// $your_height = 297;
		// $custom_layout = array($your_width, $your_height);

		$pdf = new PDF('L', 'mm', 'A4', true, 'UTF-8', false);

		//set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetTitle("Students Category Report");
		$pdf->SetSubject('');
		$pdf->SetKeywords('');
		// $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);  
		// $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
		// $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
		// $pdf->SetDefaultMonospacedFont('helvetica');  
		// $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
		// $pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);  
		// $pdf->setPrintFooter(false);  
		// $pdf->SetAutoPageBreak(TRUE, 10);

		// set default header data
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 001', PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
		$pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));

		// set header and footer fonts
		$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, 40, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
			require_once(dirname(__FILE__) . '/lang/eng.php');
			$pdf->setLanguageArray($l);
		}
		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		$pdf->SetFont('helvetica', '', 10);
		$pdf->AddPage();
		$content = '';
		$content .= '
		  	<h4 align="left"> Course, Year and Section: ' . $section . '</h4>
		  	<h4 align="left"> Prepared by: ' . $_SESSION['admin_fname'] . ' ' . $_SESSION['admin_mname'] . ' ' . $_SESSION['admin_lname'] . '</h4>
		  	<table border="1" cellspacing="0" cellpadding="3">  
		       <tr>  
					<th style="font-style: bold;">No.</th>
	                <th>Student ID</th>
	                <th>Student Name</th>
	                
	                <th>Category</th>
	                <th>Category Description</th>
	                <th>Remarks</th>
		       </tr>  
		  ';  //<th>Course, Yr & Section</th>
		$content .= generateRow();
		$content .= '</table>';
		$pdf->writeHTML($content);
		$pdf->Output('student_submittals_reports.pdf');

		//    $filename= "sample.pdf"; 
		// $filelocation = "C:";//windows

		// $fileNL = $filelocation."\\".$filename;//Windows

		// $this->pdf->Output($fileNL, 'F');
	}
}
