<?php
include('includes/db_connect.php');
error_reporting();
session_start();

//date and time
date_default_timezone_set('Asia/Manila');
$timestamp = time();
$date_ = date("F d, Y");
$time_ = date("h:i:s A");

	//export in excel
	if(isset($_POST['excel'])){

		$active = "active";
		$session_log = "You generated a report of students submittals in excel format";
		$my_ID = $_SESSION['admin_username'];
		$sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_log', '$date_', '$time_', '$my_ID', '$active')";
		$query_log_run = mysqli_query($conn, $sql_log);
		if($query_log_run){
			$get_name_id = $_SESSION['admin_fname']." ".$_SESSION['admin_mname']." ".$_SESSION['admin_lname']." (".$_SESSION['admin_username'].")";

		    $userType = "Dean";

		    $session_audit =  $get_name_id." generated a report of students submittals in excel format";
		    $sql_audit = "INSERT INTO tbl_audit_trail (activity, date_, time_, by_, status, userType) VALUES ('$session_audit', '$date_', '$time_', '$get_name_id', '$active', '$userType')";
		    $query_audit_run = mysqli_query($conn, $sql_audit);
		}

		$not_archived = "not archive";
		header("Content-Type: application/xls");    
		header("Content-Disposition: attachment; filename=student_submittals_reports.xls");  
		header("Pragma: no-cache"); 
		header("Expires: 0");
		$output = "";

		$section = $_POST['section'];
		if ($_POST['section'] == "") {
			$output .="
			<h2 align='center'>Students Submittals Report</h2>
			<h4>Course, Year and Section: All 4th Years</h4>
				<table border='1' cellspacing='3'>
					<thead>
						<tr>
							<th>No.</th>
							<th>Student ID</th>
		                	<th>Student Name</th>
		                    <th>Course, Year, and Section</th>
		              	    <th>Recommendation Letter</th>
		                    <th>Resume</th>
		                    <th>MOA</th>
		                    <th>Response Letter</th>
		                    <th>Work Plan</th>
		                    <th>Narrative</th>
		                    <th>Performance Sheet</th>
						</tr>
					<tbody>
			";
			
			$count = 1;
			$query = $conn->query("SELECT * FROM tbl_students where archived='$not_archived' ORDER by lname ASC") or die(mysqli_errno());
			while($fetch = $query->fetch_array()){

				if ($fetch['recommendation_letter'] == "submitted") {
					$_SESSION['recom_letter'] = "<b style='color: green'>SUBMITTED </b>";
				}
				else if($fetch['recommendation_letter'] == "not submitted"){
					$_SESSION['recom_letter'] = "<b style='color: orange'>NOT YET SUBMITTED</b>";
				}
				//
				if ($fetch['resume'] == "submitted") {
					$_fetchSESSION['resu'] = "<b style='color: green'>SUBMITTED</b>";
				}
				else if($fetch['resume'] == "not submitted"){
					$_SESSION['resu'] = "<b style='color: orange'>NOT YET SUBMITTED</b>";
				}
				//
				if ($fetch['moa'] == "submitted") {
						$_SESSION['memo'] = "<b style='color: green'>SUBMITTED</b>";
				}
				else if($fetch['moa'] == "not submitted"){
					$_SESSION['memo'] = "<b style='color: orange'>NOT YET SUBMITTED</b>";
				}
				else if($fetch['moa'] == "not applicable"){
					$_SESSION['memo'] = "<b style='color: black'>NOT APPLICABLE</b>";
				}
				//
				if ($fetch['response_letter'] == "submitted") {
					$_SESSION['respo_letter'] = "<b style='color: green'>SUBMITTED</b>";
				}
				else if($fetch['response_letter'] == "not submitted"){
					$_SESSION['respo_letter'] = "<b style='color: orange'>NOT YET SUBMITTED</b>";
				}
				//
				if ($fetch['work_plan'] == "submitted") {
					$_SESSION['w_plan'] = "<b style='color: green'>SUBMITTED</b>";
				}
				else if($fetch['work_plan'] == "not submitted"){
					$_SESSION['w_plan'] = "<b style='color: orange'>NOT YET SUBMITTED</b>";
				}
				//
				if ($fetch['narrative'] == "submitted") {
					$_SESSION['narrative_'] = "<b style='color: green'>SUBMITTED</b>";
				}
				else if($fetch['narrative'] == "not submitted"){
					$_SESSION['narrative_'] = "<b style='color: orange'>NOT YET SUBMITTED</b>";
				}
				//
				if ($fetch['performance_sheet'] == "submitted") {
					$_SESSION['performance_sheet_'] = "<b style='color: green'>SUBMITTED</b>";
				}
				else if($fetch['performance_sheet'] == "not submitted"){
					$_SESSION['performance_sheet_'] = "<b style='color: orange'>NOT YET SUBMITTED</b>";
				}
				//
				// if ($fetch['performance_sheet'] == "submitted") {
				// 	$_SESSION['performance_sheet_'] = "<b style='color: green'>SUBMITTED</b>";
				// }
				// else if($fetch['performance_sheet'] == "not submitted"){
				// 	$_SESSION['performance_sheet_'] = "<b style='color: orange'>NOT YET SUBMITTED</b>";
				// }
			$output .= "
						<tr>
							<td>".$count."</td>
							<td>".$fetch['stud_id']."</td>
							<td>".$fetch['lname'].", ".$fetch['fname']." ".$fetch['mname']."</td>
							<td>".$fetch['course']."</td>
							<td>".$_SESSION['recom_letter']."</td>
							<td>".$_SESSION['resu']."</td>
							<td>".$_SESSION['memo']."</td>
							<td>".$_SESSION['respo_letter']."</td>
							<td>".$_SESSION['w_plan']."</td>
							<td>".$_SESSION['narrative_']."</td>
							<td>".$_SESSION['performance_sheet_']."</td>
						</tr>
			";
			$count++; }
			
			$output .="
					</tbody>
					
				</table>
			";
			
			echo $output;
		}
		//
		else {
			$output .="
			<h2 align='center'>Students Submittals Report</h2>
			<h4> Course, Year and Section: ".$section."</h4>
				<table border='1' cellpadding='3'>
					<thead>
						<tr>
							<th>No.</th>
							<th>Student ID</th>
		                	<th>Student Name</th>
		                    <th>Course, Year, and Section</th>
		              	    <th>Recommendation Letter</th>
		                    <th>Resume</th>
		                    <th>MOA</th>
		                    <th>Response Letter</th>
		                    <th>Work Plan</th>
		                    <th>Narrative</th>
		                    <th>Performance Sheet</th>
						</tr>
					</thead>
			";
			$count = 1;
			$query = $conn->query("SELECT * FROM tbl_students where course='$section' and archived='$not_archived' ORDER by lname ASC") or die(mysqli_errno());
			while($fetch = $query->fetch_array()){

				if ($fetch['recommendation_letter'] == "submitted") {
					$_SESSION['recom_letter'] = "<b style='color: green'>SUBMITTED </b>";
				}
				else if($fetch['recommendation_letter'] == "not submitted"){
					$_SESSION['recom_letter'] = "<b style='color: orange'>NOT YET SUBMITTED</b>";
				}
				//
				if ($fetch['resume'] == "submitted") {
					$_SESSION['resu'] = "<b style='color: green'>SUBMITTED</b>";
				}
				else if($fetch['resume'] == "not submitted"){
					$_SESSION['resu'] = "<b style='color: orange'>NOT YET SUBMITTED</b>";
				}
				//
				if ($fetch['moa'] == "submitted") {
						$_SESSION['memo'] = "<b style='color: green'>SUBMITTED</b>";
				}
				else if($fetch['moa'] == "not submitted"){
					$_SESSION['memo'] = "<b style='color: orange'>NOT YET SUBMITTED</b>";
				}
				else if($fetch['moa'] == "not applicable"){
					$_SESSION['memo'] = "<b style='color: black'>NOT APPLICABLE</b>";
				}
				//
				if ($fetch['response_letter'] == "submitted") {
					$_SESSION['respo_letter'] = "<b style='color: green'>SUBMITTED</b>";
				}
				else if($fetch['response_letter'] == "not submitted"){
					$_SESSION['respo_letter'] = "<b style='color: orange'>NOT YET SUBMITTED</b>";
				}
				//
				if ($fetch['work_plan'] == "submitted") {
					$_SESSION['w_plan'] = "<b style='color: green'>SUBMITTED</b>";
				}
				else if($fetch['work_plan'] == "not submitted"){
					$_SESSION['w_plan'] = "<b style='color: orange'>NOT YET SUBMITTED</b>";
				}
				//
				if ($fetch['narrative'] == "submitted") {
					$_SESSION['narrative_'] = "<b style='color: green'>SUBMITTED</b>";
				}
				else if($fetch['narrative'] == "not submitted"){
					$_SESSION['narrative_'] = "<b style='color: orange'>NOT YET SUBMITTED</b>";
				}
				//
				if ($fetch['performance_sheet'] == "submitted") {
					$_SESSION['performance_sheet_'] = "<b style='color: green'>SUBMITTED</b>";
				}
				else if($fetch['performance_sheet'] == "not submitted"){
					$_SESSION['performance_sheet_'] = "<b style='color: orange'>NOT YET SUBMITTED</b>";
				}
			$output .= "
						<tr>
							<td>".$count."</td>
							<td>".$fetch['stud_id']."</td>
							<td>".$fetch['lname'].", ".$fetch['fname']." ".$fetch['mname']."</td>
							<td>".$fetch['course']."</td>
							<td>".$_SESSION['recom_letter']."</td>
							<td>".$_SESSION['resu']."</td>
							<td>".$_SESSION['memo']."</td>
							<td>".$_SESSION['respo_letter']."</td>
							<td>".$_SESSION['w_plan']."</td>
							<td>".$_SESSION['narrative_']."</td>
							<td>".$_SESSION['performance_sheet_']."</td>
						</tr>
			";
			$count++; }
			
			$output .="
					</tbody>
					
				</table>
			";
			
			echo $output;
		}
	}


	//export in pdf
	else if(isset($_POST['pdf'])){
		$active = "active";
		$session_log = "You generated a report of students submittals in pdf format";
		$my_ID = $_SESSION['admin_username'];
		$sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_log', '$date_', '$time_', '$my_ID', '$active')";
		$query_log_run = mysqli_query($conn, $sql_log);
		if($query_log_run){
			$get_name_id = $_SESSION['admin_fname']." ".$_SESSION['admin_mname']." ".$_SESSION['admin_lname']." (".$_SESSION['admin_username'].")";

		    $userType = "Dean";

		    $session_audit =  $get_name_id." generated a report of students submittals in pdf format";
		    $sql_audit = "INSERT INTO tbl_audit_trail (activity, date_, time_, by_, status, userType) VALUES ('$session_audit', '$date_', '$time_', '$get_name_id', '$active', '$userType')";
		    $query_audit_run = mysqli_query($conn, $sql_audit);
		}
		if ($_POST['section'] == "") {
		require_once('../tcpdf/tcpdf.php');
			class PDF extends TCPDF {
			    //Page header
			    public function Header() {
			        // Logo
			        $image_file = 'img/icon/ccs_logo.png';
			        $this->Image($image_file, 250, 4, 30, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
			        $this->Ln(5);
			        $this->SetFont('helvetica', 'B', 10);
			        $this->Cell(260, 5, 'College of Computer Studies', 0, 1, 'C');
			        $this->Cell(260, 5, 'Laguna State Polytechnic University', 0, 1, 'C');
			        $this->Cell(260, 5, 'Santa Cruz Campus', 0, 1, 'C');
			        $this->SetFont('helvetica', 'B', 15);
			        $this->Cell(260, 8, 'Students Submittals Report', 0, 1, 'C');
			    }

			    // Page footer
			    public function Footer() {
			        // Position at 15 mm from bottom
			        $this->SetY(-15);
			        // Set font
			        $this->SetFont('helvetica', 'I', 8);
			        // Page number
			        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
			    }
			}
			function generateRow(){
			$contents = '';
			$not_archived = "not archive";
			include('includes/db_connect.php');
			$sql = "SELECT * FROM tbl_students WHERE archived='$not_archived' ORDER by lname ASC";
			$query = $conn->query($sql);
			while($row = $query->fetch_assoc()){
				if ($row['recommendation_letter'] == "submitted") {
						$_SESSION['recom_letter'] = "<b style='color: green'>SUBMITTED </b>";
					}
					else if($row['recommendation_letter'] == "not submitted"){
						$_SESSION['recom_letter'] = "<b style='color: orange'>NOT YET SUBMITTED</b>";
					}
					//
					if ($row['resume'] == "submitted") {
						$_SESSION['resu'] = "<b style='color: green'>SUBMITTED</b>";
					}
					else if($row['resume'] == "not submitted"){
						$_SESSION['resu'] = "<b style='color: orange'>NOT YET SUBMITTED</b>";
					}
					//
					if ($row['moa'] == "submitted") {
							$_SESSION['memo'] = "<b style='color: green'>SUBMITTED</b>";
					}
					else if($row['moa'] == "not submitted"){
						$_SESSION['memo'] = "<b style='color: orange'>NOT YET SUBMITTED</b>";
					}
					else if($row['moa'] == "not applicable"){
						$_SESSION['memo'] = "<b style='color: black'>NOT APPLICABLE</b>";
					}
					//
					if ($row['response_letter'] == "submitted") {
						$_SESSION['respo_letter'] = "<b style='color: green'>SUBMITTED</b>";
					}
					else if($row['response_letter'] == "not submitted"){
						$_SESSION['respo_letter'] = "<b style='color: orange'>NOT YET SUBMITTED</b>";
					}
					//
					if ($row['work_plan'] == "submitted") {
						$_SESSION['w_plan'] = "<b style='color: green'>SUBMITTED</b>";
					}
					else if($row['work_plan'] == "not submitted"){
						$_SESSION['w_plan'] = "<b style='color: orange'>NOT YET SUBMITTED</b>";
					}
					//
					if ($row['narrative'] == "submitted") {
						$_SESSION['narrative_'] = "<b style='color: green'>SUBMITTED</b>";
					}
					else if($row['narrative'] == "not submitted"){
						$_SESSION['narrative_'] = "<b style='color: orange'>NOT YET SUBMITTED</b>";
					}
					//
					if ($row['performance_sheet'] == "submitted") {
						$_SESSION['performance_sheet_'] = "<b style='color: green'>SUBMITTED</b>";
					}
					else if($row['performance_sheet'] == "not submitted"){
						$_SESSION['performance_sheet_'] = "<b style='color: orange'>NOT YET SUBMITTED</b>";
					}
				$contents .= "
				<tr>
					<td>".$row['stud_id']."</td>
					<td>".$row['lname'].", ".$row['fname']." ".$row['mname']."</td>
					<td>".$row['course']."</td>
					<td>".$_SESSION['recom_letter']."</td>
					<td>".$_SESSION['resu']."</td>
					<td>".$_SESSION['memo']."</td>
					<td>".$_SESSION['respo_letter']."</td>
					<td>".$_SESSION['w_plan']."</td>
					<td>".$_SESSION['narrative_']."</td>
					<td>".$_SESSION['performance_sheet_']."</td>
				</tr>
				";
				}
			return $contents;
		}
		// $your_width = 210 ;
		// $your_height = 297;
		// $custom_layout = array($your_width, $your_height);
		
		$pdf = new PDF('L', 'mm', 'A4', true, 'UTF-8', false);  

		//set document information
		$pdf->SetCreator(PDF_CREATOR);  
		$pdf->SetTitle("Students' Submittals Report");
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
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
		$pdf->setFooterData(array(0,64,0), array(0,64,128));

		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, 45, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
		    require_once(dirname(__FILE__).'/lang/eng.php');
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
			<h4 align="left"> Course, Year and Section: All CCS 4th Years</h4>
			<h4 align="left"> Prepared by: '.$_SESSION['admin_fname'].' '.$_SESSION['admin_mname'].' '.$_SESSION['admin_lname'].'</h4>
		  	<table border="1" cellspacing="" cellpadding="5">  
		       <thead><tr>  
					<th>Student ID</th>
		        	<th>Student Name</th>
		            <th>Course, Year, and Section</th>
		      	    <th>Recommendation Letter</th>
		            <th>Resume</th>
		            <th>MOA</th>
		            <th>Response Letter</th>
		            <th>Work Plan</th>
		            <th>Narrative</th>
		            <th>Performance Sheet</th> 
		       </tr> </thead>
		  ';  
	    $content .= generateRow();  
	    $content .= '</table>';  
	    $pdf->writeHTML($content);  
	    $pdf->Output('All-students_submittals_report.pdf');
	}
	//
	else{
		require_once('../tcpdf/tcpdf.php');
		$section = $_POST['section'];
			class PDF extends TCPDF {
			    //Page header
			    public function Header() {
			        // Logo
			        $image_file = 'img/icon/ccs_logo.png';
			        $this->Image($image_file, 200, 4, 30, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
			        $this->Ln(5);
			        $this->SetFont('helvetica', 'B', 10);
			        $this->Cell(260, 5, 'College of Computer Studies', 0, 1, 'C');
			        $this->Cell(260, 5, 'Laguna State Polytechnic University', 0, 1, 'C');
			        $this->Cell(260, 5, 'Santa Cruz Campus', 0, 1, 'C');
			        $this->SetFont('helvetica', 'B', 15);
			    	$this->Cell(260, 8, 'Students Submittals Report', 0, 1, 'C');

			    	$image_file = 'img/icon/lspu_logo.png';
			        $this->Image($image_file, 60, 4, 30, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
			        $this->Ln(5);
			    }

			    // Page footer
			    public function Footer() {
			        // Position at 15 mm from bottom
			        $this->SetY(-15);
			        // Set font
			        $this->SetFont('helvetica', 'I', 8);
			        // Page number
			        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
			    }
			}
		function generateRow(){
			$contents = '';
			$not_archived = "not archive";
			$section = $_POST['section'];
			include('includes/db_connect.php');
			$sql = "SELECT * FROM tbl_students WHERE course='$section' and archived='$not_archived' ORDER by lname ASC";
			$query = $conn->query($sql);
			while($row = $query->fetch_assoc()){
				if ($row['recommendation_letter'] == "submitted") {
						$_SESSION['recom_letter'] = "<b style='color: green'>SUBMITTED </b>";
					}
					else if($row['recommendation_letter'] == "not submitted"){
						$_SESSION['recom_letter'] = "<b style='color: orange'>NOT YET SUBMITTED</b>";
					}
					//
					if ($row['resume'] == "submitted") {
						$_SESSION['resu'] = "<b style='color: green'>SUBMITTED</b>";
					}
					else if($row['resume'] == "not submitted"){
						$_SESSION['resu'] = "<b style='color: orange'>NOT YET SUBMITTED</b>";
					}
					//
					if ($row['moa'] == "submitted") {
							$_SESSION['memo'] = "<b style='color: green'>SUBMITTED</b>";
					}
					else if($row['moa'] == "not submitted"){
						$_SESSION['memo'] = "<b style='color: orange'>NOT YET SUBMITTED</b>";
					}
					else if($row['moa'] == "not applicable"){
						$_SESSION['memo'] = "<b style='color: black'>NOT APPLICABLE</b>";
					}
					//
					if ($row['response_letter'] == "submitted") {
						$_SESSION['respo_letter'] = "<b style='color: green'>SUBMITTED</b>";
					}
					else if($row['response_letter'] == "not submitted"){
						$_SESSION['respo_letter'] = "<b style='color: orange'>NOT YET SUBMITTED</b>";
					}
					//
					if ($row['work_plan'] == "submitted") {
						$_SESSION['w_plan'] = "<b style='color: green'>SUBMITTED</b>";
					}
					else if($row['work_plan'] == "not submitted"){
						$_SESSION['w_plan'] = "<b style='color: orange'>NOT YET SUBMITTED</b>";
					}
					//
					if ($row['narrative'] == "submitted") {
						$_SESSION['narrative_'] = "<b style='color: green'>SUBMITTED</b>";
					}
					else if($row['narrative'] == "not submitted"){
						$_SESSION['narrative_'] = "<b style='color: orange'>NOT YET SUBMITTED</b>";
					}
					//
					if ($row['performance_sheet'] == "submitted") {
						$_SESSION['performance_sheet_'] = "<b style='color: green'>SUBMITTED</b>";
					}
					else if($row['performance_sheet'] == "not submitted"){
						$_SESSION['performance_sheet_'] = "<b style='color: orange'>NOT YET SUBMITTED</b>";
					}
				$contents .= "
				<tr>
					<td>".$row['stud_id']."</td>
					<td>".$row['lname'].", ".$row['fname']." ".$row['mname']."</td>
					<td>".$_SESSION['recom_letter']."</td>
					<td>".$_SESSION['resu']."</td>
					<td>".$_SESSION['memo']."</td>
					<td>".$_SESSION['respo_letter']."</td>
					<td>".$_SESSION['w_plan']."</td>
					<td>".$_SESSION['narrative_']."</td>
					<td>".$_SESSION['performance_sheet_']."</td>
				</tr>
				";
			}
			return $contents;
		}
		// $your_width = 210 ;
		// $your_height = 297;
		// $custom_layout = array($your_width, $your_height);
		
		$pdf = new PDF('L', 'mm', 'A4', true, 'UTF-8', false);  

		//set document information
		$pdf->SetCreator(PDF_CREATOR);  
		$pdf->SetTitle("Students Submittals Report");
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
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
		$pdf->setFooterData(array(0,64,0), array(0,64,128));

		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, 45, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
		    require_once(dirname(__FILE__).'/lang/eng.php');
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
			<h4 align="left"> Course, Year and Section: '. $section .'</h4>
			<h4 align="left"> Prepared by: '.$_SESSION['admin_fname'].' '.$_SESSION['admin_mname'].' '.$_SESSION['admin_lname'].'</h4>
		  	<table border="1" cellspacing="" cellpadding="5">  
		       <thead><tr>  
					<th>Student ID</th>
		        	<th>Student Name</th>
		      	    <th>Recommendation Letter</th>
		            <th>Resume</th>
		            <th>MOA</th>
		            <th>Response Letter</th>
		            <th>Work Plan</th>
		            <th>Narrative</th>
		            <th>Performance Sheet</th> 
		       </tr> </thead>
		  ';  
	    $content .= generateRow();  
	    $content .= '</table>';  
	    $pdf->writeHTML($content);  
	    $pdf->Output($section. '-student_submittals_report.pdf');

		 //    $filename= "sample.pdf"; 
			// $filelocation = "C:";//windows

			// $fileNL = $filelocation."\\".$filename;//Windows

			// $this->pdf->Output($fileNL, 'F');
		}
	}

	// else if(isset($_POST['pdf1'])){
	// 	require_once('../tcpdf/tcpdf.php');
	// 	// create new PDF document
	// 	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

	// 	// set document information
	// 	$pdf->SetCreator(PDF_CREATOR);
	// 	$pdf->SetAuthor('Nicola Asuni');
	// 	$pdf->SetTitle('TCPDF Example 001');
	// 	$pdf->SetSubject('TCPDF Tutorial');
	// 	$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

	// 	// set default header data
	// 	$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
	// 	$pdf->setFooterData(array(0,64,0), array(0,64,128));

	// 	// set header and footer fonts
	// 	$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	// 	$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

	// 	// set default monospaced font
	// 	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

	// 	// set margins
	// 	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	// 	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	// 	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

	// 	// set auto page breaks
	// 	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

	// 	// set image scale factor
	// 	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

	// 	// ---------------------------------------------------------

	// 	// set default font subsetting mode
	// 	$pdf->setFontSubsetting(true);

	// 	// Set font
	// 	// dejavusans is a UTF-8 Unicode font, if you only need to
	// 	// print standard ASCII chars, you can use core fonts like
	// 	// helvetica or times to reduce file size.
	// 	$pdf->SetFont('dejavusans', '', 14, '', true);

	// 	// Add a page
	// 	// This method has several options, check the source code documentation for more information.
	// 	$pdf->AddPage();

	// 	// set text shadow effect
	// 	$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

	// 	// Set some content to print
	// 	$html = '
	// 	<h1>Welcome to <a href="http://www.tcpdf.org" style="text-decoration:none;background-color:#CC0000;color:black;">&nbsp;<span style="color:black;">TC</span><span style="color:white;">PDF</span>&nbsp;</a>!</h1>
	// 	<i>This is the first example of TCPDF library.</i>
	// 	<p>This text is printed using the <i>writeHTMLCell()</i> method but you can also use: <i>Multicell(), writeHTML(), Write(), Cell() and Text()</i>.</p>
	// 	<p>Please check the source code documentation and other examples for further information.</p>
	// 	<p style="color:#CC0000;">TO IMPROVE AND EXPAND TCPDF I NEED YOUR SUPPORT, PLEASE <a href="http://sourceforge.net/donate/index.php?group_id=128076">MAKE A DONATION!</a></p>
	// 	';

	// 	// Print text using writeHTMLCell()
	// 	$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

	// 	// ---------------------------------------------------------

	// 	// Close and output PDF document
	// 	// This method has several options, check the source code documentation for more information.
	// 	$pdf->Output('example_001.pdf');

	// 	//============================================================+
	// 	// END OF FILE
	// 	//============================================================+  
	// }
?>