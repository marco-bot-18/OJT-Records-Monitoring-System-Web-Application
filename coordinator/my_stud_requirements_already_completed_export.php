<?php
include('includes/db_connect.php');
include('includes/session.php');

	if(isset($_POST['excel'])){
		$not_archived = "not archive";
		header("Content-Type: application/xls");    
		header("Content-Disposition: attachment; filename=download.xls");  
		header("Content-Transfer-Encoding: BINARY");

		$requirement_ = $_POST['requirement_'];
		$output = "";
		if ($_POST['requirement_'] == "All") {
			$output .="
			<h2 align='center'>My Students' Requirement Report - All</h2>
				<th rowspan='8'> </th> 
				<table border='1' cellspacing='3'>
					<thead>
						<tr>
							<th>No.</th>
							<th>Student Name and ID</th>
							<th>Course, Year and Section</th>
		                	<th>Requirement</th>
		                    <th>Due Date</th>
		              	    <th>Turned In Status</th>
		                    <th>My Remarks</th>
		                    <th>Status</th>
						</tr>
					<tbody>
			";
			$count = 1;
			$work_stats1 = "completed";
            $stats = "not archived";
            $submitted = "yes";
            $count = 1;
            $my_fullname_ = $_SESSION['coordinator_fullname_session'];
			$query = $conn->query("SELECT * FROM tbl_students_work where name_of_teacher='$my_fullname_' and work_status='$work_stats1' and submitted='$submitted' and status='$stats' ORDER by stud_name_and_id ASC") or die(mysqli_errno());
			while($fetch = $query->fetch_array()){

				if ($fetch['remarks'] == "Approved") {
					$_SESSION['remarks_'] = "<b style='color: green'>APPROVED </b>";
				}
				//
				date_default_timezone_set('Asia/Manila'); 
	            $date = date('Y-m-d');
	            $submission = $fetch['date_of_submission'];
	            if($fetch['date_submitted_1'] > $submission){
	                $_SESSION['turned_in_stats'] = "<b style='color: red'>LATE</b>";
	            }
	            else if($fetch['date_submitted_1'] < $submission){
	                $_SESSION['turned_in_stats'] = "<b style='color: green'>ON-TIME</b>";
	            }
	            //
	            if ($fetch['work_status'] == "completed") {
					$_SESSION['work_status_'] = "<b style='color: green'>COMPLETED </b>";
				}
				$output .= "
							<tr>
								<td>".$count."</td>
								<td>".$fetch['stud_name_and_id']."</td>
								<td>".$fetch['course']."</td>
								<td>".$fetch['title']."</td>
								<td>".$fetch['date_of_submission']."</td>
								<td>".$_SESSION['turned_in_stats']."</td>
								<td>".$_SESSION['remarks_']."</td>
								<td>".$_SESSION['work_status_']."</td>
							</tr>
				";
				$count++; }
				
				$output .="
						</tbody>
						
					</table>
				";

			echo $output;
		}
		//------>
		else if($_POST['requirement_'] == "Recommendation Letter"){
			$title = "Recommendation Letter";
			$output .="
			<h2 align='center'>My Students' Requirement Report - Recommendation Letter</h2>
				<table border='1' cellspacing='3'>
					<thead>
						<tr>
							<th>No.</th>
							<th>Student Name and ID</th>
							<th>Course, Year and Section</th>
		                	<th>Requirement</th>
		                    <th>Due Date</th>
		              	    <th>Turned In Status</th>
		                    <th>My Remarks</th>
		                    <th>Status</th>
						</tr>
					<tbody>
			";
			$count = 1;
			$work_stats1 = "completed";
            $stats = "not archived";
            $submitted = "yes";
            $count = 1;
            $my_fullname_ = $_SESSION['coordinator_fullname_session'];
			$query = $conn->query("SELECT * FROM tbl_students_work where name_of_teacher='$my_fullname_' and work_status='$work_stats1' and submitted='$submitted' and title='$title' and status='$stats' ORDER by stud_name_and_id ASC") or die(mysqli_errno());
			while($fetch = $query->fetch_array()){

				if ($fetch['remarks'] == "Approved") {
					$_SESSION['remarks_'] = "<b style='color: green'>APPROVED </b>";
				}
				//
				date_default_timezone_set('Asia/Manila'); 
	            $date = date('Y-m-d');
	            $submission = $fetch['date_of_submission'];
	            if($fetch['date_submitted_1'] > $submission){
	                $_SESSION['turned_in_stats'] = "<b style='color: red'>LATE</b>";
	            }
	            else if($fetch['date_submitted_1'] < $submission){
	                $_SESSION['turned_in_stats'] = "<b style='color: green'>ON-TIME</b>";
	            }
	            //
	            if ($fetch['work_status'] == "completed") {
					$_SESSION['work_status_'] = "<b style='color: green'>COMPLETED </b>";
				}
				$output .= "
							<tr>
								<td>".$count."</td>
								<td>".$fetch['stud_name_and_id']."</td>
								<td>".$fetch['course']."</td>
								<td>".$fetch['title']."</td>
								<td>".$fetch['date_of_submission']."</td>
								<td>".$_SESSION['turned_in_stats']."</td>
								<td>".$_SESSION['remarks_']."</td>
								<td>".$_SESSION['work_status_']."</td>
							</tr>
				";
				$count++; }
				
				$output .="
						</tbody>
						
					</table>
				";

			echo $output;
		}
		//------>
		else if($_POST['requirement_'] == "Memorandum of Agreement"){
			$title = "Memorandum of Agreement";
			$output .="
			<h2 align='center'>My Students' Requirement Report - Memorandum of Agreement</h2>
				<table border='1' cellspacing='3'>
					<thead>
						<tr>
							<th>No.</th>
							<th>Student Name and ID</th>
							<th>Course, Year and Section</th>
		                	<th>Requirement</th>
		                    <th>Due Date</th>
		              	    <th>Turned In Status</th>
		                    <th>My Remarks</th>
		                    <th>Status</th>
						</tr>
					<tbody>
			";
			$count = 1;
			$work_stats1 = "completed";
            $stats = "not archived";
            $submitted = "yes";
            $count = 1;
            $my_fullname_ = $_SESSION['coordinator_fullname_session'];
			$query = $conn->query("SELECT * FROM tbl_students_work where name_of_teacher='$my_fullname_' and work_status='$work_stats1' and submitted='$submitted' and title='$title' and status='$stats' ORDER by stud_name_and_id ASC") or die(mysqli_errno());
			while($fetch = $query->fetch_array()){

				if ($fetch['remarks'] == "Approved") {
					$_SESSION['remarks_'] = "<b style='color: green'>APPROVED </b>";
				}
				//
				date_default_timezone_set('Asia/Manila'); 
	            $date = date('Y-m-d');
	            $submission = $fetch['date_of_submission'];
	            if($fetch['date_submitted_1'] > $submission){
	                $_SESSION['turned_in_stats'] = "<b style='color: red'>LATE</b>";
	            }
	            else if($fetch['date_submitted_1'] < $submission){
	                $_SESSION['turned_in_stats'] = "<b style='color: green'>ON-TIME</b>";
	            }
	            //
	            if ($fetch['work_status'] == "completed") {
					$_SESSION['work_status_'] = "<b style='color: green'>COMPLETED </b>";
				}
				$output .= "
							<tr>
								<td>".$count."</td>
								<td>".$fetch['stud_name_and_id']."</td>
								<td>".$fetch['course']."</td>
								<td>".$fetch['title']."</td>
								<td>".$fetch['date_of_submission']."</td>
								<td>".$_SESSION['turned_in_stats']."</td>
								<td>".$_SESSION['remarks_']."</td>
								<td>".$_SESSION['work_status_']."</td>
							</tr>
				";
				$count++; }
				
				$output .="
						</tbody>
						
					</table>
				";

			echo $output;
		}
		//------>
		else if($_POST['requirement_'] == "Resume"){
			$title = "Resume";
			$output .="
			<h2 align='center'>My Students' Requirement Report - Resume</h2>
				<table border='1' cellspacing='3'>
					<thead>
						<tr>
							<th>No.</th>
							<th>Student Name and ID</th>
							<th>Course, Year and Section</th>
		                	<th>Requirement</th>
		                    <th>Due Date</th>
		              	    <th>Turned In Status</th>
		                    <th>My Remarks</th>
		                    <th>Status</th>
						</tr>
					<tbody>
			";
			$count = 1;
			$work_stats1 = "completed";
            $stats = "not archived";
            $submitted = "yes";
            $count = 1;
            $my_fullname_ = $_SESSION['coordinator_fullname_session'];
			$query = $conn->query("SELECT * FROM tbl_students_work where name_of_teacher='$my_fullname_' and work_status='$work_stats1' and submitted='$submitted' and title='$title' and status='$stats' ORDER by stud_name_and_id ASC") or die(mysqli_errno());
			while($fetch = $query->fetch_array()){

				if ($fetch['remarks'] == "Approved") {
					$_SESSION['remarks_'] = "<b style='color: green'>APPROVED </b>";
				}
				//
				date_default_timezone_set('Asia/Manila'); 
	            $date = date('Y-m-d');
	            $submission = $fetch['date_of_submission'];
	            if($fetch['date_submitted_1'] > $submission){
	                $_SESSION['turned_in_stats'] = "<b style='color: red'>LATE</b>";
	            }
	            else if($fetch['date_submitted_1'] < $submission){
	                $_SESSION['turned_in_stats'] = "<b style='color: green'>ON-TIME</b>";
	            }
	            //
	            if ($fetch['work_status'] == "completed") {
					$_SESSION['work_status_'] = "<b style='color: green'>COMPLETED </b>";
				}
				$output .= "
							<tr>
								<td>".$count."</td>
								<td>".$fetch['stud_name_and_id']."</td>
								<td>".$fetch['course']."</td>
								<td>".$fetch['title']."</td>
								<td>".$fetch['date_of_submission']."</td>
								<td>".$_SESSION['turned_in_stats']."</td>
								<td>".$_SESSION['remarks_']."</td>
								<td>".$_SESSION['work_status_']."</td>
							</tr>
				";
				$count++; }
				
				$output .="
						</tbody>
						
					</table>
				";

			echo $output;
		}
		//------>
		else if($_POST['requirement_'] == "Accomplishment Report"){
			$title = "Accomplishment Report";
			$output .="
			<h2 align='center'>My Students' Requirement Report - Accomplishment Report</h2>
				<table border='1' cellspacing='3'>
					<thead>
						<tr>
							<th>No.</th>
							<th>Student Name and ID</th>
							<th>Course, Year and Section</th>
		                	<th>Requirement</th>
		                    <th>Due Date</th>
		              	    <th>Turned In Status</th>
		                    <th>My Remarks</th>
		                    <th>Status</th>
						</tr>
					<tbody>
			";
			$count = 1;
			$work_stats1 = "completed";
            $stats = "not archived";
            $submitted = "yes";
            $count = 1;
            $my_fullname_ = $_SESSION['coordinator_fullname_session'];
			$query = $conn->query("SELECT * FROM tbl_students_work where name_of_teacher='$my_fullname_' and work_status='$work_stats1' and submitted='$submitted' and title='$title' and status='$stats' ORDER by stud_name_and_id ASC") or die(mysqli_errno());
			while($fetch = $query->fetch_array()){

				if ($fetch['remarks'] == "Approved") {
					$_SESSION['remarks_'] = "<b style='color: green'>APPROVED </b>";
				}
				//
				date_default_timezone_set('Asia/Manila'); 
	            $date = date('Y-m-d');
	            $submission = $fetch['date_of_submission'];
	            if($fetch['date_submitted_1'] > $submission){
	                $_SESSION['turned_in_stats'] = "<b style='color: red'>LATE</b>";
	            }
	            else if($fetch['date_submitted_1'] < $submission){
	                $_SESSION['turned_in_stats'] = "<b style='color: green'>ON-TIME</b>";
	            }
	            //
	            if ($fetch['work_status'] == "completed") {
					$_SESSION['work_status_'] = "<b style='color: green'>COMPLETED </b>";
				}
				$output .= "
							<tr>
								<td>".$count."</td>
								<td>".$fetch['stud_name_and_id']."</td>
								<td>".$fetch['course']."</td>
								<td>".$fetch['title']."</td>
								<td>".$fetch['date_of_submission']."</td>
								<td>".$_SESSION['turned_in_stats']."</td>
								<td>".$_SESSION['remarks_']."</td>
								<td>".$_SESSION['work_status_']."</td>
							</tr>
				";
				$count++; }
				
				$output .="
						</tbody>
						
					</table>
				";

			echo $output;
		}
		//------>
		else if($_POST['requirement_'] == "Work Plan"){
			$title = "Work Plan";
			$output .="
			<h2 align='center'>My Students' Requirement Report - Work Plan</h2>
				<table border='1' cellspacing='3'>
					<thead>
						<tr>
							<th>No.</th>
							<th>Student Name and ID</th>
							<th>Course, Year and Section</th>
		                	<th>Requirement</th>
		                    <th>Due Date</th>
		              	    <th>Turned In Status</th>
		                    <th>My Remarks</th>
		                    <th>Status</th>
						</tr>
					<tbody>
			";
			$count = 1;
			$work_stats1 = "completed";
            $stats = "not archived";
            $submitted = "yes";
            $count = 1;
            $my_fullname_ = $_SESSION['coordinator_fullname_session'];
			$query = $conn->query("SELECT * FROM tbl_students_work where name_of_teacher='$my_fullname_' and work_status='$work_stats1' and submitted='$submitted' and title='$title' and status='$stats' ORDER by stud_name_and_id ASC") or die(mysqli_errno());
			while($fetch = $query->fetch_array()){

				if ($fetch['remarks'] == "Approved") {
					$_SESSION['remarks_'] = "<b style='color: green'>APPROVED </b>";
				}
				//
				date_default_timezone_set('Asia/Manila'); 
	            $date = date('Y-m-d');
	            $submission = $fetch['date_of_submission'];
	            if($fetch['date_submitted_1'] > $submission){
	                $_SESSION['turned_in_stats'] = "<b style='color: red'>LATE</b>";
	            }
	            else if($fetch['date_submitted_1'] < $submission){
	                $_SESSION['turned_in_stats'] = "<b style='color: green'>ON-TIME</b>";
	            }
	            //
	            if ($fetch['work_status'] == "completed") {
					$_SESSION['work_status_'] = "<b style='color: green'>COMPLETED </b>";
				}
				$output .= "
							<tr>
								<td>".$count."</td>
								<td>".$fetch['stud_name_and_id']."</td>
								<td>".$fetch['course']."</td>
								<td>".$fetch['title']."</td>
								<td>".$fetch['date_of_submission']."</td>
								<td>".$_SESSION['turned_in_stats']."</td>
								<td>".$_SESSION['remarks_']."</td>
								<td>".$_SESSION['work_status_']."</td>
							</tr>
				";
				$count++; }
				
				$output .="
						</tbody>
						
					</table>
				";

			echo $output;
		}
		//------>
		else if($_POST['requirement_'] == "Response Letter"){
			$title = "Response Letter";
			$output .="
			<h2 align='center'>My Students' Requirement Report - Response Letter</h2>
				<table border='1' cellspacing='3'>
					<thead>
						<tr>
							<th>No.</th>
							<th>Student Name and ID</th>
							<th>Course, Year and Section</th>
		                	<th>Requirement</th>
		                    <th>Due Date</th>
		              	    <th>Turned In Status</th>
		                    <th>My Remarks</th>
		                    <th>Status</th>
						</tr>
					<tbody>
			";
			$count = 1;
			$work_stats1 = "completed";
            $stats = "not archived";
            $submitted = "yes";
            $count = 1;
            $my_fullname_ = $_SESSION['coordinator_fullname_session'];
			$query = $conn->query("SELECT * FROM tbl_students_work where name_of_teacher='$my_fullname_' and work_status='$work_stats1' and submitted='$submitted' and title='$title' and status='$stats' ORDER by stud_name_and_id ASC") or die(mysqli_errno());
			while($fetch = $query->fetch_array()){

				if ($fetch['remarks'] == "Approved") {
					$_SESSION['remarks_'] = "<b style='color: green'>APPROVED </b>";
				}
				//
				date_default_timezone_set('Asia/Manila'); 
	            $date = date('Y-m-d');
	            $submission = $fetch['date_of_submission'];
	            if($fetch['date_submitted_1'] > $submission){
	                $_SESSION['turned_in_stats'] = "<b style='color: red'>LATE</b>";
	            }
	            else if($fetch['date_submitted_1'] < $submission){
	                $_SESSION['turned_in_stats'] = "<b style='color: green'>ON-TIME</b>";
	            }
	            //
	            if ($fetch['work_status'] == "completed") {
					$_SESSION['work_status_'] = "<b style='color: green'>COMPLETED </b>";
				}
				$output .= "
							<tr>
								<td>".$count."</td>
								<td>".$fetch['stud_name_and_id']."</td>
								<td>".$fetch['course']."</td>
								<td>".$fetch['title']."</td>
								<td>".$fetch['date_of_submission']."</td>
								<td>".$_SESSION['turned_in_stats']."</td>
								<td>".$_SESSION['remarks_']."</td>
								<td>".$_SESSION['work_status_']."</td>
							</tr>
				";
				$count++; }
				
				$output .="
						</tbody>
						
					</table>
				";

			echo $output;
		}
		//------>
		else if($_POST['requirement_'] == "Narrative"){
			$title = "Narrative";
			$output .="
			<h2 align='center'>My Students' Requirement Report - Narrative</h2>
				<table border='1' cellspacing='3'>
					<thead>
						<tr>
							<th>No.</th>
							<th>Student Name and ID</th>
							<th>Course, Year and Section</th>
		                	<th>Requirement</th>
		                    <th>Due Date</th>
		              	    <th>Turned In Status</th>
		                    <th>My Remarks</th>
		                    <th>Status</th>
						</tr>
					<tbody>
			";
			$count = 1;
			$work_stats1 = "completed";
            $stats = "not archived";
            $submitted = "yes";
            $count = 1;
            $my_fullname_ = $_SESSION['coordinator_fullname_session'];
			$query = $conn->query("SELECT * FROM tbl_students_work where name_of_teacher='$my_fullname_' and work_status='$work_stats1' and submitted='$submitted' and title='$title' and status='$stats' ORDER by stud_name_and_id ASC") or die(mysqli_errno());
			while($fetch = $query->fetch_array()){

				if ($fetch['remarks'] == "Approved") {
					$_SESSION['remarks_'] = "<b style='color: green'>APPROVED </b>";
				}
				//
				date_default_timezone_set('Asia/Manila'); 
	            $date = date('Y-m-d');
	            $submission = $fetch['date_of_submission'];
	            if($fetch['date_submitted_1'] > $submission){
	                $_SESSION['turned_in_stats'] = "<b style='color: red'>LATE</b>";
	            }
	            else if($fetch['date_submitted_1'] < $submission){
	                $_SESSION['turned_in_stats'] = "<b style='color: green'>ON-TIME</b>";
	            }
	            //
	            if ($fetch['work_status'] == "completed") {
					$_SESSION['work_status_'] = "<b style='color: green'>COMPLETED </b>";
				}
				$output .= "
							<tr>
								<td>".$count."</td>
								<td>".$fetch['stud_name_and_id']."</td>
								<td>".$fetch['course']."</td>
								<td>".$fetch['title']."</td>
								<td>".$fetch['date_of_submission']."</td>
								<td>".$_SESSION['turned_in_stats']."</td>
								<td>".$_SESSION['remarks_']."</td>
								<td>".$_SESSION['work_status_']."</td>
							</tr>
				";
				$count++; }
				
				$output .="
						</tbody>
						
					</table>
				";

			echo $output;
		}
		//------>
		else if($_POST['requirement_'] == "Performance Sheet"){
			//<img src='http://localhost/CCS-OJT-Records-Monitoring-System/img/icon/ccs_logo1.png' width='10px' height='10px' align='right'>
			$title = "Performance Sheet";
			$output .="
			<h2 align='center'>My Students' Requirement Report - Performance Sheet</h2>
				<table border='1' cellspacing='3'>
					<thead>
						<tr>
							<th>No.</th>
							<th>Student Name and ID</th>
							<th>Course, Year and Section</th>
		                	<th>Requirement</th>
		                    <th>Due Date</th>
		              	    <th>Turned In Status</th>
		                    <th>My Remarks</th>
		                    <th>Status</th>
						</tr>
					<tbody>
			";
			$count = 1;
			$work_stats1 = "completed";
            $stats = "not archived";
            $submitted = "yes";
            $count = 1;
            $my_fullname_ = $_SESSION['coordinator_fullname_session'];
			$query = $conn->query("SELECT * FROM tbl_students_work where name_of_teacher='$my_fullname_' and work_status='$work_stats1' and submitted='$submitted' and title='$title' and status='$stats' ORDER by stud_name_and_id ASC") or die(mysqli_errno());
			while($fetch = $query->fetch_array()){

				if ($fetch['remarks'] == "Approved") {
					$_SESSION['remarks_'] = "<b style='color: green'>APPROVED </b>";
				}
				//
				date_default_timezone_set('Asia/Manila'); 
	            $date = date('Y-m-d');
	            $submission = $fetch['date_of_submission'];
	            if($fetch['date_submitted_1'] > $submission){
	                $_SESSION['turned_in_stats'] = "<b style='color: red'>LATE</b>";
	            }
	            else if($fetch['date_submitted_1'] < $submission){
	                $_SESSION['turned_in_stats'] = "<b style='color: green'>ON-TIME</b>";
	            }
	            //
	            if ($fetch['work_status'] == "completed") {
					$_SESSION['work_status_'] = "<b style='color: green'>COMPLETED </b>";
				}
				$output .= "
							<tr>
								<td>".$count."</td>
								<td>".$fetch['stud_name_and_id']."</td>
								<td>".$fetch['course']."</td>
								<td>".$fetch['title']."</td>
								<td>".$fetch['date_of_submission']."</td>
								<td>".$_SESSION['turned_in_stats']."</td>
								<td>".$_SESSION['remarks_']."</td>
								<td>".$_SESSION['work_status_']."</td>
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

	if (ISSET($_POST['pdf'])) {
		if ($_POST['requirement_'] == "All") {
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
					$count = 1;
					$work_stats1 = "completed";
		            $stats = "not archived";
		            $submitted = "yes";
		            $my_fullname_ = $_SESSION['coordinator_fullname_session'];
					$sql = "SELECT * FROM tbl_students_work where name_of_teacher='$my_fullname_' and work_status='$work_stats1' and submitted='$submitted' and status='$stats' ORDER by stud_name_and_id ASC";
					$query = $conn->query($sql);
					while($row = $query->fetch_assoc()){
						if ($row['remarks'] == "Approved") {
							$_SESSION['remarks_'] = "<b style='color: green'>APPROVED </b>";
						}
						date_default_timezone_set('Asia/Manila'); 
			            $date = date('Y-m-d');
			            $submission = $row['date_of_submission'];
			            if($row['date_submitted_1'] > $submission){
			                $_SESSION['turned_in_stats'] = "<b style='color: red'>LATE</b>";
			            }
			            else if($row['date_submitted_1'] < $submission){
			                $_SESSION['turned_in_stats'] = "<b style='color: green'>ON-TIME</b>";
			            }
			            //
			            if ($row['work_status'] == "completed") {
							$_SESSION['work_status_'] = "<b style='color: green'>COMPLETED </b>";
						}
						$contents .= "
						<tr>
							<td>".$row['stud_name_and_id']."</td>
							<td>".$row['course']."</td>
							<td>".$row['title']."</td>
							<td>".$row['date_of_submission']."</td>
							<td>".$_SESSION['turned_in_stats']."</td>
							<td>".$_SESSION['remarks_']."</td>
							<td>".$_SESSION['work_status_']."</td>
						</tr>
						";
					$count++;}
				return $contents;
			}
			// $your_width = 210 ;
			// $your_height = 297;
			// $custom_layout = array($your_width, $your_height);
			
			$pdf = new PDF('L', 'mm', 'A4', true, 'UTF-8', false);  

			//set document information
			$pdf->SetCreator(PDF_CREATOR);  
			$pdf->SetTitle("Students Completed Requirements");
			$pdf->SetSubject('');
			$pdf->SetKeywords('');

			// set default header data
			$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
			$pdf->setFooterData(array(0,64,0), array(0,64,128));

			// set header and footer fonts
			$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

			// set margins
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
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
			  	<h2 align="center">Students Completed Requirements Report</h2>
			  	<h4 align="left"> Requirement: All</h4>
			  	<table border="1" cellspacing="0" cellpadding="3">  
			       <tr> 
						<th>Student Name and ID</th>
						<th>Course, Year and Section</th>
	                	<th>Requirement</th>
	                    <th>Due Date</th>
	              	    <th>Turned In Status</th>
	                    <th>My Remarks</th>
	                    <th>Status</th>
			       </tr>  
			  ';  
		    $content .= generateRow();  
		    $content .= '</table>';  
		    $pdf->writeHTML($content);  
		    $pdf->Output('student_completed_requirements_reports_all.pdf', 'I');
		}
		//
		else if($_POST['requirement_'] == "Recommendation Letter"){
			require_once('../tcpdf/tcpdf.php');
			$title = "Recommendation Letter";
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
					$title = "Recommendation Letter";
					$contents = '';
					$not_archived = "not archive";
					include('includes/db_connect.php');
					$count = 1;
					$work_stats1 = "completed";
		            $stats = "not archived";
		            $submitted = "yes";
		            $my_fullname_ = $_SESSION['coordinator_fullname_session'];
					$sql = "SELECT * FROM tbl_students_work where name_of_teacher='$my_fullname_' and work_status='$work_stats1' and submitted='$submitted' and title='$title' and status='$stats' ORDER by stud_name_and_id ASC";
					$query = $conn->query($sql);
					while($row = $query->fetch_assoc()){
						if ($row['remarks'] == "Approved") {
							$_SESSION['remarks_'] = "<b style='color: green'>APPROVED </b>";
						}
						date_default_timezone_set('Asia/Manila'); 
			            $date = date('Y-m-d');
			            $submission = $row['date_of_submission'];
			            if($row['date_submitted_1'] > $submission){
			                $_SESSION['turned_in_stats'] = "<b style='color: red'>LATE</b>";
			            }
			            else if($row['date_submitted_1'] < $submission){
			                $_SESSION['turned_in_stats'] = "<b style='color: green'>ON-TIME</b>";
			            }
			            //
			            if ($row['work_status'] == "completed") {
							$_SESSION['work_status_'] = "<b style='color: green'>COMPLETED </b>";
						}
						$contents .= "
						<tr>
							<td>".$row['stud_name_and_id']."</td>
							<td>".$row['course']."</td>
							<td>".$row['title']."</td>
							<td>".$row['date_of_submission']."</td>
							<td>".$_SESSION['turned_in_stats']."</td>
							<td>".$_SESSION['remarks_']."</td>
							<td>".$_SESSION['work_status_']."</td>
						</tr>
						";
					$count++;}
				return $contents;
			}
			// $your_width = 210 ;
			// $your_height = 297;
			// $custom_layout = array($your_width, $your_height);
			
			$pdf = new PDF('L', 'mm', 'A4', true, 'UTF-8', false);  

			//set document information
			$pdf->SetCreator(PDF_CREATOR);  
			$pdf->SetTitle("Students Completed Requirements");
			$pdf->SetSubject('');
			$pdf->SetKeywords('');

			// set default header data
			$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
			$pdf->setFooterData(array(0,64,0), array(0,64,128));

			// set header and footer fonts
			$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

			// set margins
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
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
			  	<h2 align="center">Students Completed Requirements Report</h2>
			  	<h4 align="left"> Requirement: '.$title.'</h4>
			  	<table border="1" cellspacing="0" cellpadding="3">  
			       <tr> 
						<th>Student Name and ID</th>
						<th>Course, Year and Section</th>
	                	<th>Requirement</th>
	                    <th>Due Date</th>
	              	    <th>Turned In Status</th>
	                    <th>My Remarks</th>
	                    <th>Status</th>
			       </tr>  
			  ';  
		    $content .= generateRow();  
		    $content .= '</table>';  
		    $pdf->writeHTML($content);  
		    $pdf->Output('student_completed_requirements_reports_all.pdf', 'I');
		}
		//
		else if($_POST['requirement_'] == "Memorandum of Agreement"){
			require_once('../tcpdf/tcpdf.php');
			$title = "Memorandum of Agreement";
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
					$title = "Memorandum of Agreement";
					$contents = '';
					$not_archived = "not archive";
					include('includes/db_connect.php');
					$count = 1;
					$work_stats1 = "completed";
		            $stats = "not archived";
		            $submitted = "yes";
		            $my_fullname_ = $_SESSION['coordinator_fullname_session'];
					$sql = "SELECT * FROM tbl_students_work where name_of_teacher='$my_fullname_' and work_status='$work_stats1' and submitted='$submitted' and title='$title' and status='$stats' ORDER by stud_name_and_id ASC";
					$query = $conn->query($sql);
					while($row = $query->fetch_assoc()){
						if ($row['remarks'] == "Approved") {
							$_SESSION['remarks_'] = "<b style='color: green'>APPROVED </b>";
						}
						date_default_timezone_set('Asia/Manila'); 
			            $date = date('Y-m-d');
			            $submission = $row['date_of_submission'];
			            if($row['date_submitted_1'] > $submission){
			                $_SESSION['turned_in_stats'] = "<b style='color: red'>LATE</b>";
			            }
			            else if($row['date_submitted_1'] < $submission){
			                $_SESSION['turned_in_stats'] = "<b style='color: green'>ON-TIME</b>";
			            }
			            //
			            if ($row['work_status'] == "completed") {
							$_SESSION['work_status_'] = "<b style='color: green'>COMPLETED </b>";
						}
						$contents .= "
						<tr>
							<td>".$row['stud_name_and_id']."</td>
							<td>".$row['course']."</td>
							<td>".$row['title']."</td>
							<td>".$row['date_of_submission']."</td>
							<td>".$_SESSION['turned_in_stats']."</td>
							<td>".$_SESSION['remarks_']."</td>
							<td>".$_SESSION['work_status_']."</td>
						</tr>
						";
					$count++;}
				return $contents;
			}
			// $your_width = 210 ;
			// $your_height = 297;
			// $custom_layout = array($your_width, $your_height);
			
			$pdf = new PDF('L', 'mm', 'A4', true, 'UTF-8', false);  

			//set document information
			$pdf->SetCreator(PDF_CREATOR);  
			$pdf->SetTitle("Students Completed Requirements");
			$pdf->SetSubject('');
			$pdf->SetKeywords('');

			// set default header data
			$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
			$pdf->setFooterData(array(0,64,0), array(0,64,128));

			// set header and footer fonts
			$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

			// set margins
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
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
			  	<h2 align="center">Students Completed Requirements Report</h2>
			  	<h4 align="left"> Requirement: '.$title.'</h4>
			  	<table border="1" cellspacing="0" cellpadding="3">  
			       <tr> 
						<th>Student Name and ID</th>
						<th>Course, Year and Section</th>
	                	<th>Requirement</th>
	                    <th>Due Date</th>
	              	    <th>Turned In Status</th>
	                    <th>My Remarks</th>
	                    <th>Status</th>
			       </tr>  
			  ';  
		    $content .= generateRow();  
		    $content .= '</table>';  
		    $pdf->writeHTML($content);  
		    $pdf->Output('student_completed_requirements_reports_all.pdf', 'I');
		}
		//
		else if($_POST['requirement_'] == "Memorandum of Agreement"){
			require_once('../tcpdf/tcpdf.php');
			$title = "Memorandum of Agreement";
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
					$title = "Memorandum of Agreement";
					$contents = '';
					$not_archived = "not archive";
					include('includes/db_connect.php');
					$count = 1;
					$work_stats1 = "completed";
		            $stats = "not archived";
		            $submitted = "yes";
		            $my_fullname_ = $_SESSION['coordinator_fullname_session'];
					$sql = "SELECT * FROM tbl_students_work where name_of_teacher='$my_fullname_' and work_status='$work_stats1' and submitted='$submitted' and title='$title' and status='$stats' ORDER by stud_name_and_id ASC";
					$query = $conn->query($sql);
					while($row = $query->fetch_assoc()){
						if ($row['remarks'] == "Approved") {
							$_SESSION['remarks_'] = "<b style='color: green'>APPROVED </b>";
						}
						date_default_timezone_set('Asia/Manila'); 
			            $date = date('Y-m-d');
			            $submission = $row['date_of_submission'];
			            if($row['date_submitted_1'] > $submission){
			                $_SESSION['turned_in_stats'] = "<b style='color: red'>LATE</b>";
			            }
			            else if($row['date_submitted_1'] < $submission){
			                $_SESSION['turned_in_stats'] = "<b style='color: green'>ON-TIME</b>";
			            }
			            //
			            if ($row['work_status'] == "completed") {
							$_SESSION['work_status_'] = "<b style='color: green'>COMPLETED </b>";
						}
						$contents .= "
						<tr>
							<td>".$row['stud_name_and_id']."</td>
							<td>".$row['course']."</td>
							<td>".$row['title']."</td>
							<td>".$row['date_of_submission']."</td>
							<td>".$_SESSION['turned_in_stats']."</td>
							<td>".$_SESSION['remarks_']."</td>
							<td>".$_SESSION['work_status_']."</td>
						</tr>
						";
					$count++;}
				return $contents;
			}
			// $your_width = 210 ;
			// $your_height = 297;
			// $custom_layout = array($your_width, $your_height);
			
			$pdf = new PDF('L', 'mm', 'A4', true, 'UTF-8', false);  

			//set document information
			$pdf->SetCreator(PDF_CREATOR);  
			$pdf->SetTitle("Students Completed Requirements");
			$pdf->SetSubject('');
			$pdf->SetKeywords('');

			// set default header data
			$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
			$pdf->setFooterData(array(0,64,0), array(0,64,128));

			// set header and footer fonts
			$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

			// set margins
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
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
			  	<h2 align="center">Students Completed Requirements Report</h2>
			  	<h4 align="left"> Requirement: '.$title.'</h4>
			  	<table border="1" cellspacing="0" cellpadding="3">  
			       <tr> 
						<th>Student Name and ID</th>
						<th>Course, Year and Section</th>
	                	<th>Requirement</th>
	                    <th>Due Date</th>
	              	    <th>Turned In Status</th>
	                    <th>My Remarks</th>
	                    <th>Status</th>
			       </tr>  
			  ';  
		    $content .= generateRow();  
		    $content .= '</table>';  
		    $pdf->writeHTML($content);  
		    $pdf->Output('student_completed_requirements_reports_all.pdf', 'I');
		}
		//
		else if($_POST['requirement_'] == "Memorandum of Agreement"){
			require_once('../tcpdf/tcpdf.php');
			$title = "Memorandum of Agreement";
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
					$title = "Memorandum of Agreement";
					$contents = '';
					$not_archived = "not archive";
					include('includes/db_connect.php');
					$count = 1;
					$work_stats1 = "completed";
		            $stats = "not archived";
		            $submitted = "yes";
		            $my_fullname_ = $_SESSION['coordinator_fullname_session'];
					$sql = "SELECT * FROM tbl_students_work where name_of_teacher='$my_fullname_' and work_status='$work_stats1' and submitted='$submitted' and title='$title' and status='$stats' ORDER by stud_name_and_id ASC";
					$query = $conn->query($sql);
					while($row = $query->fetch_assoc()){
						if ($row['remarks'] == "Approved") {
							$_SESSION['remarks_'] = "<b style='color: green'>APPROVED </b>";
						}
						date_default_timezone_set('Asia/Manila'); 
			            $date = date('Y-m-d');
			            $submission = $row['date_of_submission'];
			            if($row['date_submitted_1'] > $submission){
			                $_SESSION['turned_in_stats'] = "<b style='color: red'>LATE</b>";
			            }
			            else if($row['date_submitted_1'] < $submission){
			                $_SESSION['turned_in_stats'] = "<b style='color: green'>ON-TIME</b>";
			            }
			            //
			            if ($row['work_status'] == "completed") {
							$_SESSION['work_status_'] = "<b style='color: green'>COMPLETED </b>";
						}
						$contents .= "
						<tr>
							<td>".$row['stud_name_and_id']."</td>
							<td>".$row['course']."</td>
							<td>".$row['title']."</td>
							<td>".$row['date_of_submission']."</td>
							<td>".$_SESSION['turned_in_stats']."</td>
							<td>".$_SESSION['remarks_']."</td>
							<td>".$_SESSION['work_status_']."</td>
						</tr>
						";
					$count++;}
				return $contents;
			}
			// $your_width = 210 ;
			// $your_height = 297;
			// $custom_layout = array($your_width, $your_height);
			
			$pdf = new PDF('L', 'mm', 'A4', true, 'UTF-8', false);  

			//set document information
			$pdf->SetCreator(PDF_CREATOR);  
			$pdf->SetTitle("Students Completed Requirements");
			$pdf->SetSubject('');
			$pdf->SetKeywords('');

			// set default header data
			$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
			$pdf->setFooterData(array(0,64,0), array(0,64,128));

			// set header and footer fonts
			$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

			// set margins
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
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
			  	<h2 align="center">Students Completed Requirements Report</h2>
			  	<h4 align="left"> Requirement: '.$title.'</h4>
			  	<table border="1" cellspacing="0" cellpadding="3">  
			       <tr> 
						<th>Student Name and ID</th>
						<th>Course, Year and Section</th>
	                	<th>Requirement</th>
	                    <th>Due Date</th>
	              	    <th>Turned In Status</th>
	                    <th>My Remarks</th>
	                    <th>Status</th>
			       </tr>  
			  ';  
		    $content .= generateRow();  
		    $content .= '</table>';  
		    $pdf->writeHTML($content);  
		    $pdf->Output('student_completed_requirements_reports_all.pdf', 'I');
		}
		//
		else if($_POST['requirement_'] == "Resume"){
			require_once('../tcpdf/tcpdf.php');
			$title = "Resume";
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
					$title = "Resume";
					$contents = '';
					$not_archived = "not archive";
					include('includes/db_connect.php');
					$count = 1;
					$work_stats1 = "completed";
		            $stats = "not archived";
		            $submitted = "yes";
		            $my_fullname_ = $_SESSION['coordinator_fullname_session'];
					$sql = "SELECT * FROM tbl_students_work where name_of_teacher='$my_fullname_' and work_status='$work_stats1' and submitted='$submitted' and title='$title' and status='$stats' ORDER by stud_name_and_id ASC";
					$query = $conn->query($sql);
					while($row = $query->fetch_assoc()){
						if ($row['remarks'] == "Approved") {
							$_SESSION['remarks_'] = "<b style='color: green'>APPROVED </b>";
						}
						date_default_timezone_set('Asia/Manila'); 
			            $date = date('Y-m-d');
			            $submission = $row['date_of_submission'];
			            if($row['date_submitted_1'] > $submission){
			                $_SESSION['turned_in_stats'] = "<b style='color: red'>LATE</b>";
			            }
			            else if($row['date_submitted_1'] < $submission){
			                $_SESSION['turned_in_stats'] = "<b style='color: green'>ON-TIME</b>";
			            }
			            //
			            if ($row['work_status'] == "completed") {
							$_SESSION['work_status_'] = "<b style='color: green'>COMPLETED </b>";
						}
						$contents .= "
						<tr>
							<td>".$row['stud_name_and_id']."</td>
							<td>".$row['course']."</td>
							<td>".$row['title']."</td>
							<td>".$row['date_of_submission']."</td>
							<td>".$_SESSION['turned_in_stats']."</td>
							<td>".$_SESSION['remarks_']."</td>
							<td>".$_SESSION['work_status_']."</td>
						</tr>
						";
					$count++;}
				return $contents;
			}
			// $your_width = 210 ;
			// $your_height = 297;
			// $custom_layout = array($your_width, $your_height);
			
			$pdf = new PDF('L', 'mm', 'A4', true, 'UTF-8', false);  

			//set document information
			$pdf->SetCreator(PDF_CREATOR);  
			$pdf->SetTitle("Students Completed Requirements");
			$pdf->SetSubject('');
			$pdf->SetKeywords('');

			// set default header data
			$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
			$pdf->setFooterData(array(0,64,0), array(0,64,128));

			// set header and footer fonts
			$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

			// set margins
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
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
			  	<h2 align="center">Students Completed Requirements Report</h2>
			  	<h4 align="left"> Requirement: '.$title.'</h4>
			  	<table border="1" cellspacing="0" cellpadding="3">  
			       <tr> 
						<th>Student Name and ID</th>
						<th>Course, Year and Section</th>
	                	<th>Requirement</th>
	                    <th>Due Date</th>
	              	    <th>Turned In Status</th>
	                    <th>My Remarks</th>
	                    <th>Status</th>
			       </tr>  
			  ';  
		    $content .= generateRow();  
		    $content .= '</table>';  
		    $pdf->writeHTML($content);  
		    $pdf->Output('student_completed_requirements_reports_all.pdf', 'I');
		}
		//
		else if($_POST['requirement_'] == "Memorandum of Agreement"){
			require_once('../tcpdf/tcpdf.php');
			$title = "Memorandum of Agreement";
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
					$title = "Memorandum of Agreement";
					$contents = '';
					$not_archived = "not archive";
					include('includes/db_connect.php');
					$count = 1;
					$work_stats1 = "completed";
		            $stats = "not archived";
		            $submitted = "yes";
		            $my_fullname_ = $_SESSION['coordinator_fullname_session'];
					$sql = "SELECT * FROM tbl_students_work where name_of_teacher='$my_fullname_' and work_status='$work_stats1' and submitted='$submitted' and title='$title' and status='$stats' ORDER by stud_name_and_id ASC";
					$query = $conn->query($sql);
					while($row = $query->fetch_assoc()){
						if ($row['remarks'] == "Approved") {
							$_SESSION['remarks_'] = "<b style='color: green'>APPROVED </b>";
						}
						date_default_timezone_set('Asia/Manila'); 
			            $date = date('Y-m-d');
			            $submission = $row['date_of_submission'];
			            if($row['date_submitted_1'] > $submission){
			                $_SESSION['turned_in_stats'] = "<b style='color: red'>LATE</b>";
			            }
			            else if($row['date_submitted_1'] < $submission){
			                $_SESSION['turned_in_stats'] = "<b style='color: green'>ON-TIME</b>";
			            }
			            //
			            if ($row['work_status'] == "completed") {
							$_SESSION['work_status_'] = "<b style='color: green'>COMPLETED </b>";
						}
						$contents .= "
						<tr>
							<td>".$row['stud_name_and_id']."</td>
							<td>".$row['course']."</td>
							<td>".$row['title']."</td>
							<td>".$row['date_of_submission']."</td>
							<td>".$_SESSION['turned_in_stats']."</td>
							<td>".$_SESSION['remarks_']."</td>
							<td>".$_SESSION['work_status_']."</td>
						</tr>
						";
					$count++;}
				return $contents;
			}
			// $your_width = 210 ;
			// $your_height = 297;
			// $custom_layout = array($your_width, $your_height);
			
			$pdf = new PDF('L', 'mm', 'A4', true, 'UTF-8', false);  

			//set document information
			$pdf->SetCreator(PDF_CREATOR);  
			$pdf->SetTitle("Students Completed Requirements");
			$pdf->SetSubject('');
			$pdf->SetKeywords('');

			// set default header data
			$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
			$pdf->setFooterData(array(0,64,0), array(0,64,128));

			// set header and footer fonts
			$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

			// set margins
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
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
			  	<h2 align="center">Students Completed Requirements Report</h2>
			  	<h4 align="left"> Requirement: '.$title.'</h4>
			  	<table border="1" cellspacing="0" cellpadding="3">  
			       <tr> 
						<th>Student Name and ID</th>
						<th>Course, Year and Section</th>
	                	<th>Requirement</th>
	                    <th>Due Date</th>
	              	    <th>Turned In Status</th>
	                    <th>My Remarks</th>
	                    <th>Status</th>
			       </tr>  
			  ';  
		    $content .= generateRow();  
		    $content .= '</table>';  
		    $pdf->writeHTML($content);  
		    $pdf->Output('student_completed_requirements_reports_all.pdf', 'I');
		}
		//
		else if($_POST['requirement_'] == "Resume"){
			require_once('../tcpdf/tcpdf.php');
			$title = "Resume";
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
					$title = "Resume";
					$contents = '';
					$not_archived = "not archive";
					include('includes/db_connect.php');
					$count = 1;
					$work_stats1 = "completed";
		            $stats = "not archived";
		            $submitted = "yes";
		            $my_fullname_ = $_SESSION['coordinator_fullname_session'];
					$sql = "SELECT * FROM tbl_students_work where name_of_teacher='$my_fullname_' and work_status='$work_stats1' and submitted='$submitted' and title='$title' and status='$stats' ORDER by stud_name_and_id ASC";
					$query = $conn->query($sql);
					while($row = $query->fetch_assoc()){
						if ($row['remarks'] == "Approved") {
							$_SESSION['remarks_'] = "<b style='color: green'>APPROVED </b>";
						}
						date_default_timezone_set('Asia/Manila'); 
			            $date = date('Y-m-d');
			            $submission = $row['date_of_submission'];
			            if($row['date_submitted_1'] > $submission){
			                $_SESSION['turned_in_stats'] = "<b style='color: red'>LATE</b>";
			            }
			            else if($row['date_submitted_1'] < $submission){
			                $_SESSION['turned_in_stats'] = "<b style='color: green'>ON-TIME</b>";
			            }
			            //
			            if ($row['work_status'] == "completed") {
							$_SESSION['work_status_'] = "<b style='color: green'>COMPLETED </b>";
						}
						$contents .= "
						<tr>
							<td>".$row['stud_name_and_id']."</td>
							<td>".$row['course']."</td>
							<td>".$row['title']."</td>
							<td>".$row['date_of_submission']."</td>
							<td>".$_SESSION['turned_in_stats']."</td>
							<td>".$_SESSION['remarks_']."</td>
							<td>".$_SESSION['work_status_']."</td>
						</tr>
						";
					$count++;}
				return $contents;
			}
			// $your_width = 210 ;
			// $your_height = 297;
			// $custom_layout = array($your_width, $your_height);
			
			$pdf = new PDF('L', 'mm', 'A4', true, 'UTF-8', false);  

			//set document information
			$pdf->SetCreator(PDF_CREATOR);  
			$pdf->SetTitle("Students Completed Requirements");
			$pdf->SetSubject('');
			$pdf->SetKeywords('');

			// set default header data
			$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
			$pdf->setFooterData(array(0,64,0), array(0,64,128));

			// set header and footer fonts
			$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

			// set margins
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
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
			  	<h2 align="center">Students Completed Requirements Report</h2>
			  	<h4 align="left"> Requirement: '.$title.'</h4>
			  	<table border="1" cellspacing="0" cellpadding="3">  
			       <tr> 
						<th>Student Name and ID</th>
						<th>Course, Year and Section</th>
	                	<th>Requirement</th>
	                    <th>Due Date</th>
	              	    <th>Turned In Status</th>
	                    <th>My Remarks</th>
	                    <th>Status</th>
			       </tr>  
			  ';  
		    $content .= generateRow();  
		    $content .= '</table>';  
		    $pdf->writeHTML($content);  
		    $pdf->Output('student_completed_requirements_reports_all.pdf', 'I');
		}
		//
		else if($_POST['requirement_'] == "Accomplishment Report"){
			require_once('../tcpdf/tcpdf.php');
			$title = "Accomplishment Report";
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
					$title = "Accomplishment Report";
					$contents = '';
					$not_archived = "not archive";
					include('includes/db_connect.php');
					$count = 1;
					$work_stats1 = "completed";
		            $stats = "not archived";
		            $submitted = "yes";
		            $my_fullname_ = $_SESSION['coordinator_fullname_session'];
					$sql = "SELECT * FROM tbl_students_work where name_of_teacher='$my_fullname_' and work_status='$work_stats1' and submitted='$submitted' and title='$title' and status='$stats' ORDER by stud_name_and_id ASC";
					$query = $conn->query($sql);
					while($row = $query->fetch_assoc()){
						if ($row['remarks'] == "Approved") {
							$_SESSION['remarks_'] = "<b style='color: green'>APPROVED </b>";
						}
						date_default_timezone_set('Asia/Manila'); 
			            $date = date('Y-m-d');
			            $submission = $row['date_of_submission'];
			            if($row['date_submitted_1'] > $submission){
			                $_SESSION['turned_in_stats'] = "<b style='color: red'>LATE</b>";
			            }
			            else if($row['date_submitted_1'] < $submission){
			                $_SESSION['turned_in_stats'] = "<b style='color: green'>ON-TIME</b>";
			            }
			            //
			            if ($row['work_status'] == "completed") {
							$_SESSION['work_status_'] = "<b style='color: green'>COMPLETED </b>";
						}
						$contents .= "
						<tr>
							<td>".$row['stud_name_and_id']."</td>
							<td>".$row['course']."</td>
							<td>".$row['title']."</td>
							<td>".$row['date_of_submission']."</td>
							<td>".$_SESSION['turned_in_stats']."</td>
							<td>".$_SESSION['remarks_']."</td>
							<td>".$_SESSION['work_status_']."</td>
						</tr>
						";
					$count++;}
				return $contents;
			}
			// $your_width = 210 ;
			// $your_height = 297;
			// $custom_layout = array($your_width, $your_height);
			
			$pdf = new PDF('L', 'mm', 'A4', true, 'UTF-8', false);  

			//set document information
			$pdf->SetCreator(PDF_CREATOR);  
			$pdf->SetTitle("Students Completed Requirements");
			$pdf->SetSubject('');
			$pdf->SetKeywords('');

			// set default header data
			$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
			$pdf->setFooterData(array(0,64,0), array(0,64,128));

			// set header and footer fonts
			$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

			// set margins
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
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
			  	<h2 align="center">Students Completed Requirements Report</h2>
			  	<h4 align="left"> Requirement: '.$title.'</h4>
			  	<table border="1" cellspacing="0" cellpadding="3">  
			       <tr> 
						<th>Student Name and ID</th>
						<th>Course, Year and Section</th>
	                	<th>Requirement</th>
	                    <th>Due Date</th>
	              	    <th>Turned In Status</th>
	                    <th>My Remarks</th>
	                    <th>Status</th>
			       </tr>  
			  ';  
		    $content .= generateRow();  
		    $content .= '</table>';  
		    $pdf->writeHTML($content);  
		    $pdf->Output('student_completed_requirements_reports_all.pdf', 'I');
		}
		//
		else if($_POST['requirement_'] == "Work Plan"){
			require_once('../tcpdf/tcpdf.php');
			$title = "Work Plan";
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
					$title = "Work Plan";
					$contents = '';
					$not_archived = "not archive";
					include('includes/db_connect.php');
					$count = 1;
					$work_stats1 = "completed";
		            $stats = "not archived";
		            $submitted = "yes";
		            $my_fullname_ = $_SESSION['coordinator_fullname_session'];
					$sql = "SELECT * FROM tbl_students_work where name_of_teacher='$my_fullname_' and work_status='$work_stats1' and submitted='$submitted' and title='$title' and status='$stats' ORDER by stud_name_and_id ASC";
					$query = $conn->query($sql);
					while($row = $query->fetch_assoc()){
						if ($row['remarks'] == "Approved") {
							$_SESSION['remarks_'] = "<b style='color: green'>APPROVED </b>";
						}
						date_default_timezone_set('Asia/Manila'); 
			            $date = date('Y-m-d');
			            $submission = $row['date_of_submission'];
			            if($row['date_submitted_1'] > $submission){
			                $_SESSION['turned_in_stats'] = "<b style='color: red'>LATE</b>";
			            }
			            else if($row['date_submitted_1'] < $submission){
			                $_SESSION['turned_in_stats'] = "<b style='color: green'>ON-TIME</b>";
			            }
			            //
			            if ($row['work_status'] == "completed") {
							$_SESSION['work_status_'] = "<b style='color: green'>COMPLETED </b>";
						}
						$contents .= "
						<tr>
							<td>".$row['stud_name_and_id']."</td>
							<td>".$row['course']."</td>
							<td>".$row['title']."</td>
							<td>".$row['date_of_submission']."</td>
							<td>".$_SESSION['turned_in_stats']."</td>
							<td>".$_SESSION['remarks_']."</td>
							<td>".$_SESSION['work_status_']."</td>
						</tr>
						";
					$count++;}
				return $contents;
			}
			// $your_width = 210 ;
			// $your_height = 297;
			// $custom_layout = array($your_width, $your_height);
			
			$pdf = new PDF('L', 'mm', 'A4', true, 'UTF-8', false);  

			//set document information
			$pdf->SetCreator(PDF_CREATOR);  
			$pdf->SetTitle("Students Completed Requirements");
			$pdf->SetSubject('');
			$pdf->SetKeywords('');

			// set default header data
			$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
			$pdf->setFooterData(array(0,64,0), array(0,64,128));

			// set header and footer fonts
			$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

			// set margins
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
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
			  	<h2 align="center">Students Completed Requirements Report</h2>
			  	<h4 align="left"> Requirement: '.$title.'</h4>
			  	<table border="1" cellspacing="0" cellpadding="3">  
			       <tr> 
						<th>Student Name and ID</th>
						<th>Course, Year and Section</th>
	                	<th>Requirement</th>
	                    <th>Due Date</th>
	              	    <th>Turned In Status</th>
	                    <th>My Remarks</th>
	                    <th>Status</th>
			       </tr>  
			  ';  
		    $content .= generateRow();  
		    $content .= '</table>';  
		    $pdf->writeHTML($content);  
		    $pdf->Output('student_completed_requirements_reports_all.pdf', 'I');
		}
		//
		else if($_POST['requirement_'] == "Response Letter"){
			require_once('../tcpdf/tcpdf.php');
			$title = "Response Letter";
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
					$title = "Response Letter";
					$contents = '';
					$not_archived = "not archive";
					include('includes/db_connect.php');
					$count = 1;
					$work_stats1 = "completed";
		            $stats = "not archived";
		            $submitted = "yes";
		            $my_fullname_ = $_SESSION['coordinator_fullname_session'];
					$sql = "SELECT * FROM tbl_students_work where name_of_teacher='$my_fullname_' and work_status='$work_stats1' and submitted='$submitted' and title='$title' and status='$stats' ORDER by stud_name_and_id ASC";
					$query = $conn->query($sql);
					while($row = $query->fetch_assoc()){
						if ($row['remarks'] == "Approved") {
							$_SESSION['remarks_'] = "<b style='color: green'>APPROVED </b>";
						}
						date_default_timezone_set('Asia/Manila'); 
			            $date = date('Y-m-d');
			            $submission = $row['date_of_submission'];
			            if($row['date_submitted_1'] > $submission){
			                $_SESSION['turned_in_stats'] = "<b style='color: red'>LATE</b>";
			            }
			            else if($row['date_submitted_1'] < $submission){
			                $_SESSION['turned_in_stats'] = "<b style='color: green'>ON-TIME</b>";
			            }
			            //
			            if ($row['work_status'] == "completed") {
							$_SESSION['work_status_'] = "<b style='color: green'>COMPLETED </b>";
						}
						$contents .= "
						<tr>
							<td>".$row['stud_name_and_id']."</td>
							<td>".$row['course']."</td>
							<td>".$row['title']."</td>
							<td>".$row['date_of_submission']."</td>
							<td>".$_SESSION['turned_in_stats']."</td>
							<td>".$_SESSION['remarks_']."</td>
							<td>".$_SESSION['work_status_']."</td>
						</tr>
						";
					$count++;}
				return $contents;
			}
			// $your_width = 210 ;
			// $your_height = 297;
			// $custom_layout = array($your_width, $your_height);
			
			$pdf = new PDF('L', 'mm', 'A4', true, 'UTF-8', false);  

			//set document information
			$pdf->SetCreator(PDF_CREATOR);  
			$pdf->SetTitle("Students Completed Requirements");
			$pdf->SetSubject('');
			$pdf->SetKeywords('');

			// set default header data
			$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
			$pdf->setFooterData(array(0,64,0), array(0,64,128));

			// set header and footer fonts
			$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

			// set margins
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
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
			  	<h2 align="center">Students Completed Requirements Report</h2>
			  	<h4 align="left"> Requirement: '.$title.'</h4>
			  	<table border="1" cellspacing="0" cellpadding="3">  
			       <tr> 
						<th>Student Name and ID</th>
						<th>Course, Year and Section</th>
	                	<th>Requirement</th>
	                    <th>Due Date</th>
	              	    <th>Turned In Status</th>
	                    <th>My Remarks</th>
	                    <th>Status</th>
			       </tr>  
			  ';  
		    $content .= generateRow();  
		    $content .= '</table>';  
		    $pdf->writeHTML($content);  
		    $pdf->Output('student_completed_requirements_reports_all.pdf', 'I');
		}
		//
		else if($_POST['requirement_'] == "Narrative"){
			require_once('../tcpdf/tcpdf.php');
			$title = "Narrative";
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
					$title = "Narrative";
					$contents = '';
					$not_archived = "not archive";
					include('includes/db_connect.php');
					$count = 1;
					$work_stats1 = "completed";
		            $stats = "not archived";
		            $submitted = "yes";
		            $my_fullname_ = $_SESSION['coordinator_fullname_session'];
					$sql = "SELECT * FROM tbl_students_work where name_of_teacher='$my_fullname_' and work_status='$work_stats1' and submitted='$submitted' and title='$title' and status='$stats' ORDER by stud_name_and_id ASC";
					$query = $conn->query($sql);
					while($row = $query->fetch_assoc()){
						if ($row['remarks'] == "Approved") {
							$_SESSION['remarks_'] = "<b style='color: green'>APPROVED </b>";
						}
						date_default_timezone_set('Asia/Manila'); 
			            $date = date('Y-m-d');
			            $submission = $row['date_of_submission'];
			            if($row['date_submitted_1'] > $submission){
			                $_SESSION['turned_in_stats'] = "<b style='color: red'>LATE</b>";
			            }
			            else if($row['date_submitted_1'] < $submission){
			                $_SESSION['turned_in_stats'] = "<b style='color: green'>ON-TIME</b>";
			            }
			            //
			            if ($row['work_status'] == "completed") {
							$_SESSION['work_status_'] = "<b style='color: green'>COMPLETED </b>";
						}
						$contents .= "
						<tr>
							<td>".$row['stud_name_and_id']."</td>
							<td>".$row['course']."</td>
							<td>".$row['title']."</td>
							<td>".$row['date_of_submission']."</td>
							<td>".$_SESSION['turned_in_stats']."</td>
							<td>".$_SESSION['remarks_']."</td>
							<td>".$_SESSION['work_status_']."</td>
						</tr>
						";
					$count++;}
				return $contents;
			}
			// $your_width = 210 ;
			// $your_height = 297;
			// $custom_layout = array($your_width, $your_height);
			
			$pdf = new PDF('L', 'mm', 'A4', true, 'UTF-8', false);  

			//set document information
			$pdf->SetCreator(PDF_CREATOR);  
			$pdf->SetTitle("Students Completed Requirements");
			$pdf->SetSubject('');
			$pdf->SetKeywords('');

			// set default header data
			$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
			$pdf->setFooterData(array(0,64,0), array(0,64,128));

			// set header and footer fonts
			$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

			// set margins
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
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
			  	<h2 align="center">Students Completed Requirements Report</h2>
			  	<h4 align="left"> Requirement: '.$title.'</h4>
			  	<table border="1" cellspacing="0" cellpadding="3">  
			       <tr> 
						<th>Student Name and ID</th>
						<th>Course, Year and Section</th>
	                	<th>Requirement</th>
	                    <th>Due Date</th>
	              	    <th>Turned In Status</th>
	                    <th>My Remarks</th>
	                    <th>Status</th>
			       </tr>  
			  ';  
		    $content .= generateRow();  
		    $content .= '</table>';  
		    $pdf->writeHTML($content);  
		    $pdf->Output('student_completed_requirements_reports_all.pdf', 'I');
		}
		//
		else if($_POST['requirement_'] == "Performance Sheet"){
			require_once('../tcpdf/tcpdf.php');
			$title = "Performance Sheet";
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
					$title = "Performance Sheet";
					$contents = '';
					$not_archived = "not archive";
					include('includes/db_connect.php');
					$count = 1;
					$work_stats1 = "completed";
		            $stats = "not archived";
		            $submitted = "yes";
		            $my_fullname_ = $_SESSION['coordinator_fullname_session'];
					$sql = "SELECT * FROM tbl_students_work where name_of_teacher='$my_fullname_' and work_status='$work_stats1' and submitted='$submitted' and title='$title' and status='$stats' ORDER by stud_name_and_id ASC";
					$query = $conn->query($sql);
					while($row = $query->fetch_assoc()){
						if ($row['remarks'] == "Approved") {
							$_SESSION['remarks_'] = "<b style='color: green'>APPROVED </b>";
						}
						date_default_timezone_set('Asia/Manila'); 
			            $date = date('Y-m-d');
			            $submission = $row['date_of_submission'];
			            if($row['date_submitted_1'] > $submission){
			                $_SESSION['turned_in_stats'] = "<b style='color: red'>LATE</b>";
			            }
			            else if($row['date_submitted_1'] < $submission){
			                $_SESSION['turned_in_stats'] = "<b style='color: green'>ON-TIME</b>";
			            }
			            //
			            if ($row['work_status'] == "completed") {
							$_SESSION['work_status_'] = "<b style='color: green'>COMPLETED </b>";
						}
						$contents .= "
						<tr>
							<td>".$row['stud_name_and_id']."</td>
							<td>".$row['course']."</td>
							<td>".$row['title']."</td>
							<td>".$row['date_of_submission']."</td>
							<td>".$_SESSION['turned_in_stats']."</td>
							<td>".$_SESSION['remarks_']."</td>
							<td>".$_SESSION['work_status_']."</td>
						</tr>
						";
					$count++;}
				return $contents;
			}
			// $your_width = 210 ;
			// $your_height = 297;
			// $custom_layout = array($your_width, $your_height);
			
			$pdf = new PDF('L', 'mm', 'A4', true, 'UTF-8', false);  

			//set document information
			$pdf->SetCreator(PDF_CREATOR);  
			$pdf->SetTitle("Students Completed Requirements");
			$pdf->SetSubject('');
			$pdf->SetKeywords('');

			// set default header data
			$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
			$pdf->setFooterData(array(0,64,0), array(0,64,128));

			// set header and footer fonts
			$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

			// set margins
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
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
			  	<h2 align="center">Students Completed Requirements Report</h2>
			  	<h4 align="left"> Requirement: '.$title.'</h4>
			  	<table border="1" cellspacing="0" cellpadding="3">  
			       <tr> 
						<th>Student Name and ID</th>
						<th>Course, Year and Section</th>
	                	<th>Requirement</th>
	                    <th>Due Date</th>
	              	    <th>Turned In Status</th>
	                    <th>My Remarks</th>
	                    <th>Status</th>
			       </tr>  
			  ';  
		    $content .= generateRow();  
		    $content .= '</table>';  
		    $pdf->writeHTML($content);  
		    $pdf->Output('student_completed_requirements_reports_all.pdf', 'I');
		}
	}
?>