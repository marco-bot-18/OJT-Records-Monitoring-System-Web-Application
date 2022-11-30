<?php 
//PHPMAILER
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
?>
<style type="text/css">
.button-save {
    background-color: #4CAF50; /* Green */
    border-radius: 5px;
    border: none;
    color: white;
    padding: 32px 32px;
    text-align: center;
    width: 10%;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
}

.zoom {
    padding: 0px;
    transition: transform .2s; /* Animation */
    margin: 0 auto;
}

.zoom:hover {
    transform: scale(3.5); /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
}

.image-preview {
    margin-left: 47px;
    width: 370px;
    height: 300px;
    border: 2px solid #dddddd;
    margin-top: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    color: #cccccc; 
}

.image-preview__image {
    display: none;
    height: 300px;
    width: 100%;
}
</style>

<?php
include('includes/session.php'); 
include('includes/header.php');?>
<!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion"  id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon">
                    <img src="../img/icon/ccs_logo.png" width="50px;" height="25px;" alt="" class="img-fluid">
                </div>
                <!-- <div class="sidebar-brand-text"> &nbsp;OJTRMS</div> -->
                <div class="sidebar-brand-text"> &nbsp;<span style="text-transform: lowercase;">e</span>-OJT <span style="text-transform: lowercase;">a<span style="text-transform: uppercase;">CC</span><span style="text-transform: lowercase;">e</span><span style="text-transform: uppercase;">S</span><span style="text-transform: lowercase;">s</span></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Manage
            </div>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                   
                    <i class="fas fa-fw fa-users"></i>
                    <span>My Students</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Manage</h6>
                        <a class="collapse-item" href="students_list.php">Master List</a>
                        <a class="collapse-item" href="students_category.php">Category</a>
                    </div>
                </div>  
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAnnouncements"
                    aria-expanded="true" aria-controls="collapseUtilities">
                     <i class="fas fa-fw fa-calendar"></i>
                    <span>My Announcement</span></a>
                </a>
                <div id="collapseAnnouncements" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Category</i></h6>
                        <a class="collapse-item" href="announcement_for_today.php">Today</a>
                        <a class="collapse-item" href="announcements_history.php">All</a>
                    </div>
                </div>
            </li>

            <li class="nav-item active">
                <a class="nav-link collapsed" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo" href="#">
                    <i class="fas fa-tasks"></i>
                    <span>Students' Requirements</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Manage</h6>
                        <a class="collapse-item" href="my_stud_requirements_completed.php">Submitted
                            <span class="badge badge bg-danger" style="color: white;">
                            <?php
                                date_default_timezone_set('Asia/Manila');
                                $work_stats = "semi-pending";
                                $stats = "not archived";
                                $submitted = "yes";
                                $count = 1;
                                $my_fullname_ = $_SESSION['coordinator_fullname_session'];
                                $sql = "SELECT * from tbl_students_work where name_of_teacher='$my_fullname_' and work_status='$work_stats' and submitted='$submitted' and status='$stats'";
                                $query = $conn->query($sql);
                                echo $query->num_rows;
                            ?>
                            </span>
                        </a>
                        <a class="collapse-item active" href="my_stud_requirements_pending.php">Not Yet Submitted
                            <span class="badge badge bg-danger" style="color: white;">
                            <?php
                                $myfullname_ = $_SESSION['coordinator_fullname_session'];
                                $work_stats = "pending";
                                $stats = "not archived";
                                $submitted = "no";
                                $count = 1;
                                $sql = "SELECT * from tbl_students_work where name_of_teacher='$myfullname_' and work_status='$work_stats' and submitted='$submitted' and status='$stats'";
                                $query = $conn->query($sql);
                                echo $query->num_rows;
                            ?>
                            </span>
                        </a>
                        <a class="collapse-item" href="my_stud_requirements_completed_sent_to_PH.php">Forwarded
                            <span class="badge badge bg-danger" style="color: white;">
                            <?php
                                $work_stats = "semi-pending2";
                                $work_stats2 = "semi-pending3";
                                $stats = "not archived";
                                $submitted = "yes";
                                $count = 1;
                                $my_fullname_ = $_SESSION['coordinator_fullname_session'];
                                $sql = "SELECT * from tbl_students_work where (name_of_teacher='$my_fullname_' and work_status='$work_stats' and submitted='$submitted' and status='$stats')
                                    OR
                                    (name_of_teacher='$my_fullname_' and work_status='$work_stats2' and submitted='$submitted' and status='$stats')
                                    ";
                                $query = $conn->query($sql);
                                echo $query->num_rows;
                            ?>
                            </span>
                        </a>
                        <a class="collapse-item" href="my_stud_requirements_already_completed.php">
                        Completed
                            <span class="badge badge bg-danger" style="color: white;">
                            <?php
                                $myfullname_ = $_SESSION['coordinator_fullname_session'];
                                $work_stats = "completed";
                                $stats = "not archived";
                                $submitted = "yes";
                                $count = 1;
                                $sql = "SELECT * from tbl_students_work where name_of_teacher='$myfullname_' and work_status='$work_stats' and submitted='$submitted' and status='$stats'";
                                $query = $conn->query($sql);
                                echo $query->num_rows;
                            ?>
                            </span>
                        </a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" data-toggle="collapse" data-target="#collapseThree"
                    aria-expanded="true" aria-controls="collapseTwo" href="#">
                    <i class="fas fa-folder"></i>
                    <span>My Requirements</span>
                </a>
                <div id="collapseThree" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Manage</h6>
                        <a class="collapse-item" href="my_requirements_for_students.php">Today</a>
                        <a class="collapse-item" href="my_requirements_for_students_history.php">All</a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="student_account.php">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Student Account Management</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            <!-- Sidebar Message -->
        
        </ul>
        <!-- End of Sidebar -->

        <?php 
        include('includes/topbar.php');
        ?>
 
<div class="container-fluid">
<!-- Page Heading -->
    
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><span><b>Student Requirements</b> / Not Yet Submitted </span></h1>
    </div>

    <style>
         #instructions {
            border: 1px solid #006bb3;
            color: black;
            /*resize: none;*/
            border-top: none;
            border-left: none;
            border-right: none;
            border-bottom: 4px solid #006bb3;
        }
        #instructions:focus { 
            border-bottom: 4px solid #006bb3;
            box-shadow: none;
            outline-offset: 0px;
            outline: none;
            color: black;
        }
        #comments{
            border: 1px solid gray;
            color:  #333333;
        }
        #comments:focus {
            border: 1px solid black;
            box-shadow: none;
            outline-offset: 0px;
            outline: none;
            color:  black;
        }
        #my_comments{
            border: 1px solid gray;
            color:  #333333;
            background: white;
        }
        #my_comments:focus {
            border: 1px solid black;
            box-shadow: none;
            outline-offset: 0px;
            outline: none;
            color:  black;
            background: white;
        }
        #remarks{
            border: 1px solid gray;
            color:  #333333;
        }
        #remarks:focus {
            border: 1px solid black;
            box-shadow: none;
            outline-offset: 0px;
            outline: none;
            color:  black;
        }
        #tra{
            color:  #333333;
        }
        #tra:hover {
            color: black;
            background: #f2f2f2;
        }
        #fetchval{
            border: 1px solid gray;
            color: #333333;
        }
        #fetchval:focus {
            border: 1px solid #006bb3;
            box-shadow: none;
            outline-offset: 0px;
            outline: none;
            color: black;
        }
    </style>

    <!-- to avoid selecting the past dates in the calendar -->
    <script type="text/javascript">
    $(document).ready(function(){
        $(function(){
            var dtToday = new Date();

            var month = dtToday.getMonth() + 1;
            var day = dtToday.getDate();
            var year = dtToday.getFullYear();
            if(month < 10)
                month = '0' + month.toString();
            if(day < 10)
                day = '0' + day.toString();

            var maxDate = year + '-' + month + '-' + day;

            // or instead:
            // var maxDate = dtToday.toISOString().substr(0, 10);

                //alert(maxDate);
                $('#duedate').attr('min', maxDate);
            });
        })           
    </script>



    <!-- Show Table Area -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="my_stud_requirements_already_completed.php" class="btn btn-sm btn-success shadow-sm" title="Completed Requirements"><i class="fas fa-check-circle"></i> Completed Requirements</a>

            <a href="my_stud_requirements_completed_sent_to_PH.php" class="btn btn-sm btn-primary shadow-sm" title="Requirements Already Forwarded to Program Head"><i class="fas fa-file-export"></i> Requirements Forwarded to Program Head</a>

            <a href="my_stud_requirements_completed.php" class="btn btn-sm btn-info shadow-sm" title="Submitted Requirements"><i class="fas fa-file-alt"></i> Submitted Requirements</a>

            <a href="my_stud_requirements_pending.php" class="btn btn-sm btn-warning shadow-sm active" title="Pending Requirements"><i class="fas fa-clipboard-list"></i> Not Yet Submitted Requirements</a>
        </div>
        <div class="card-header py-3">
        <?php ?>
            <h6 class="m-0 font-weight-bold text-primary">
                <h style="color: #333333; font-size: 18px;">Want to create a requirement?</h><br><br>
                <a class="btn btn-primary" href="my_requirements_for_students.php">
                    Click Here <i class="fas fa-plus-square"></i>
                </a>
            </h6>
        </div>
        <!-- <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-danger">
            My Students' Requirements That Are Not Already Submitted
        </h6>
        </div> -->
        <div class="card-header py-3" style="background: #595959;">
            <h6 class="m-0 font-weight-bold" style="color: ghostwhite;">
                <i class="fas fa-clipboard-list"></i> My Students' Requirements That Are Not Yet Submitted
            </h6>
        </div>
        <div class="card-header py-3">
            <div class="form-group">
                <select class="form-control form-control-sm" id="fetchval" name="requirement_" style="width: 260px; color: #333333;">
                    <option value="All">Filter Requirement - All</option>
                    <option value="Recommendation Letter">Recommendation Letter</option>
                    <option value="Memorandum of Agreement">Memorandum of Agreement</option>
                    <option value="Resume">Resume</option>
                    <option value="Accomplishment Report">Accomplishment Report</option>
                    <option value="Work Plan">Work Plan </option>
                    <option value="Response Letter">Response Letter</option>
                    <option value="Narrative">Narrative</option>
                    <option value="Performance Sheet">Performance Sheet</option>
                    <option value="Endorsement Letter">Endorsement Letter</option>
                </select>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table" id="dataTable" width="100%" cellspacing="10"  id="example" style="color:  #333333;">
                  <thead>
                    <tr>
                      <th hidden="">ID</th>
                      <th>Student</th>
                      <th>Requirement</th>
                      <th>Attached File</th>
                      <th>Due Date</th>
                      <th>Turned In</th>
                      <th>Status</th>
                      <th>Action</th>                      
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                    require_once('includes/db_connect.php');
                    $myfullname_ = $_SESSION['coordinator_fullname_session'];
                    $work_stats = "pending";
                    $stats = "not archived";
                    $submitted = "no";
                    $count = 1;
                    $sql = "SELECT * from tbl_students_work where name_of_teacher='$myfullname_' and work_status='$work_stats' and submitted='$submitted' and status='$stats'";
                    $query = $conn->query($sql);

                    require '../vendor/autoload.php';
                    $mail = new  PHPMailer(true);
                    $mail->SMTPDebug = 0;
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
                    $mail->Username   = 'websiteet18@gmail.com';                     //SMTP username
                    $mail->Password   = 'empowermenttechnology';                               //SMTP password
                    $mail->SMTPSecure = "tls"; //Enable implicit TLS encryption
                    $mail->Port       = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                    while($row = $query->fetch_assoc()){
                        $id = $row['id'];
                        $requirement_title = $row['title'];
                        $stud_fullname = $row['stud_name_and_id'];
                        $_SESSION['task_id_2'] = $row['id'];
                    ?>
                    <tr id="tra">
                      <td hidden=""><?php 
                            $_SESSION['t_id_works1'] = $_SESSION['task_id_2'];
                            echo $_SESSION['t_id_works1'];
                        ?>
                      </td>
                      <td><?php echo $row['stud_name_and_id']; ?></td>
                      <td><?php echo $row['title'];?> </td>
                      <td><?php if($row['sample_file'] != "") {?><b><a href="../admin/upload_docs/<?php echo $row['sample_file'];?>" target="_blank" title="Download File"><i class="fa fa-file"></i><?php echo $row['sample_file'];?></a> </b> <?php } else { echo "<font style='color: red;'>There's no attached file</font>"; } ?></td>
                      <td width="10%"><?php echo $row['date_of_submission']?></td>
                      <td>
                        <?php
                            $sql2 = "SELECT email from tbl_students where stud_fullname='$stud_fullname'";
                            $query2 = $conn->query($sql2);
                             //this lines of code will insert multiple data in rows in tbl_students_work
                            while($row2 = $query2->fetch_assoc()){
                                $get_email = $row2['email'];
                            }
                            //detect the dates
                            date_default_timezone_set('Asia/Manila'); 
                            $date = date('Y-m-d');
                            if($row['date_of_submission'] < $date){
                                //in this part, magnonotify sa email ng students kapag late na yung requirement nila(di pa napapasa), imbes na mag-spam sa email, ginawan ko ng update email late notify para isang beses lang magsend yung sa gmail nila kapag late na yung requirement nila
                                //if yung email notify late ay = sa unsent magnonotify sa email; else kapag hindi
                                if ($row['email_notify_late'] == "unsent") {
                                    //Recipients
                                    $mail->setFrom('websiteet18@gmail.com', $myfullname_);
                                    $mail->addAddress($get_email);//Name is optional

                                    //Content
                                    $mail->isHTML(true);//Set email format to HTML
                                    $mail->Subject = "e-OJT aCCeSs: Requirement Update";
                                    $template    = "Late Requirement: <b>".$requirement_title."</b><br>You are <b style='color: red;'>LATE</b>. Please submit your requirement.";
                                    $mail->Body = $template;
                                    $mail->send();
                                }
                                else if($row['email_notify_late'] == "sent"){
                                    echo "";//OKAY na
                                }
                                date_default_timezone_set('Asia/Manila'); 
                                $date = date('Y-m-d');

                                $no = "no";
                                $sent="sent";
                                $sql_update_late_sent = "UPDATE tbl_students_work set email_notify_late='$sent' WHERE date_of_submission<'$date' and submitted='$no'";
                                $query_run_late_sent = mysqli_query($conn, $sql_update_late_sent);

                                echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-danger'><font style='color: ghostwhite;'>LATE</span>";
                            }
                            //$counter = 0;
                            else if($row['date_of_submission'] == $date){
                                //in this part, magnonotify sa email ng students kapag due date na yung requirement nila(di pa napapasa), imbes na mag-spam sa email, ginawan ko ng update email due notify para isang beses lang magsend yung sa gmail nila kapag late na yung requirement nila
                                //if yung email notify due ay = sa unsent magnonotify sa email; else kapag hindi
                                if ($row['email_notify_due'] == "unsent") {

                                    //Recipients
                                    $mail->setFrom('websiteet18@gmail.com', $myfullname_);
                                    $mail->addAddress($get_email);//Name is optional

                                    //Content
                                    $mail->isHTML(true);//Set email format to HTML
                                    $mail->Subject = "e-OJT aCCeSs: Requirement Update";
                                    $template    = "Requirement: <b>".$requirement_title."</b><br> Your requirement is <b style='color: orange;'>DUE TODAY</b>. Please submit your requirement.";
                                    $mail->Body = $template;
                                    $mail->send();
                                }
                                else if($row['email_notify_due'] == "sent"){
                                    echo "";//OKAY na
                                }
                                date_default_timezone_set('Asia/Manila'); 
                                $date = date('Y-m-d');
                                
                                $no = "no";
                                $sent="sent";
                                $sql_update_due_sent = "UPDATE tbl_students_work set email_notify_due='$sent' WHERE date_of_submission='$date' and submitted='$no'";
                                $query_run_due_sent = mysqli_query($conn, $sql_update_due_sent);

                                echo "<span style='font-size: 15px; margin-left: 0px; color: #262626;' class='badge badge-pill badge-warning'>DUE TODAY</span>";
                            }
                            else{
                                echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite; background: orange;' class='badge badge-pill badge-success'>ON-GOING</span>";
                            }
                        ?> 
                      </td>
                      <td width="15%">
                        <?php 
                            if ($row['work_status'] == 'pending') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' title='15% on progress'>15%</div>
                                        </div><b>PENDING</b>";
                            }

                            if ($row['work_status'] == 'semi-pending') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' title='25% on progress' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'>25%</div>
                                        </div><b>PENDING</b>";
                            }

                            if ($row['work_status'] == 'semi-pending2') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'></div>
                                        </div><b>PENDING 50%</b>";
                            }

                            if ($row['work_status'] == 'semi-pending3') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                        </div><b>PENDING 75%</b>";
                            }

                            if ($row['work_status'] == 'completed') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'></div>
                                        </div><b>COMPLETED 100%</b>";
                            }
                        ?>
                          
                      </td>
                      <td>
                          <a href="#view<?php echo $id;?>"  class="btn btn-info" data-toggle="modal" > <i class="fas fa-eye" title="View"></i></a>
                      </td>

                        <!-- View Modal -->
                        <div class="modal fade bd-example-modal-xl" data-backdrop="static" id="view<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="update_place" aria-hidden="true">
                          <div class="modal-dialog modal-xl" role="document" style="color:  #333333;">
                            <div class="modal-content modal-xl">
                              <div class="modal-header modal-xl">
                                <h5 class="modal-title" id="exampleModalLabel"><h style="color: #0d6efd"><i class="fas fa-file-alt"></i> <?php echo $row['title']; ?> </h><span><?php //echo $row['edited']; ?></span></h5>
                                   
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                                <div class="modal-header modal-xl">
                                    <p class="modal-title" id="exampleModalLabel">
                                        <h title="Date and Time Given"><i style="color: #1a8cff;" class="fas fa-clock"></i> <?php echo $row['date_']." at ".$row['time_'];  ?> <?php echo $row['edited'];?></h>  
                                    </p> 
                                </div>
                              <input type="text" class="form-control" name="id" value="<?php echo $id;?>" hidden>
                                <div class="modal-body modal-xl">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Student: </label> <br>
                                                    <b> <?php echo $row['stud_name_and_id']; ?> </b>
                                                </div>
                                                <hr>
                                                <div class="form-group">
                                                    <label>Course, Year & Section: </label> <br>
                                                    <b> <?php echo $row['course']; ?> </b>
                                                </div>
                                                <!-- <hr>
                                                <div class="form-group">
                                                    <label>Requirement: </label> <br>
                                                    <b> <?php echo $row['title']; ?> </b>
                                                </div> -->
                                                <hr>
                                                <div class="form-group">
                                                    <label>Instructions: </label> <br>
                                                    <textarea style="background: ghostwhite;" rows="15" name="instructions" class="form-control" id="instructions" aria-describedby="" readonly required=""><?php echo $row['instructions'];?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Attached File</label>: <br>
                                                    <?php if($row['sample_file'] != "") { ?>
                                                    <b><a href="../admin/upload_docs/<?php echo $row['sample_file'];?>" target="_blank" title="Download File"><i class="fa fa-file"></i><?php echo $row['sample_file'];?></a> </b></a>
                                                    <?php } else { echo "<b style='color: red;'>There's no attached file</b>"; } ?>
                                                </div>
                                                <hr>
                                                <!-- selecting and concatenating the date and time from tbl_students_work -->
                                                <?php 
                                                    session_start();
                                                    $task_id = $_SESSION['t_id_works1'];
                                                    $sql1 = "SELECT Concat(date_,' ',time_) AS dateTTime1 FROM tbl_students_work where id='$task_id'";
                                                    $query1 = $conn->query($sql1);
                                                    while($row1 = $query1->fetch_assoc()){
                                                        $_SESSION['datetime2'] = $row1['dateTTime1'];
                                                    }
                                                ?>
                                                <div class="form-group">
                                                    <label>Status: </label> <br>
                                                    <?php 
                                                    if ($row['work_status'] == 'pending') {
                                                         echo "<div class='progress'>
                                                                  <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' title='15% on progress'>15%</div>
                                                                </div><b>PENDING</b>";
                                                    }

                                                    if ($row['work_status'] == 'semi-pending') {
                                                         echo "<div class='progress'>
                                                                  <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' title='25% on progress' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
                                                                </div><b>STILL PENDING 25%</b>";
                                                    }

                                                    if ($row['work_status'] == 'semi-pending2') {
                                                         echo "<div class='progress'>
                                                                  <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'></div>
                                                                </div><b>STILL PENDING 50%</b>";
                                                    }

                                                    if ($row['work_status'] == 'semi-pending3') {
                                                         echo "<div class='progress'>
                                                                  <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                                                </div><b>STILL PENDING 75%</b>";
                                                    }

                                                    if ($row['work_status'] == 'completed') {
                                                         echo "<div class='progress'>
                                                                  <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'></div>
                                                                </div><b>COMPLETED 100%</b>";
                                                    }
                                                ?>
                                                </div>
                                                <hr>
                                                <div class="form-group">
                                                    <label>Due Date:</label> <br>
                                                    <b><?php
                                                        echo $row['date_of_submission'];?></b>
                                                </div>
                                                <!-- <hr>
                                                <div class="form-group" >
                                                    <label>Turned In?:</label> <br>
                                                    <?php
                                                        date_default_timezone_set('Asia/Manila'); 
                                                        $date = date('Y-m-d');
                                                        if($row['date_of_submission'] < $date){
                                                            echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-danger'>LATE</span>";
                                                        }
                                                        else{
                                                            echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite; background: orange;' class='badge badge-pill badge-success'>ON-GOING</span>";
                                                        }
                                                    ?> 
                                                </div> -->
                                                <div class="form-group">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                        <!-- </div> end tag of modal -->

                        <!-- Delete place modal -->
                        <!-- <div class="modal fade" id="delete<?php //echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        Are you Sure you want to delete this data?</p>
                                    </div>
                                    <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                    <a href="events_delete.php<?php  ?>" class="btn btn-danger">Yes</a>
                                </div>
                            </div>
                        </div> -->
                    </div> 
                    <!-- end tag modal -->
                    </tr>
                    <?php $count++; } ?> 
                  </tbody>
                </table>
            </div>
        </div>
        </div>
    </div>
</div>

<div id="autoload">
    
</div>


<!-- fetch data form dropdown list of requirements -->
<script type="text/javascript">
    $(document).ready(function(){
        $("#fetchval").on('change', function(){
            var value = $(this).val();
            $.ajax({
                url:"my_stud_requirements_pending_fetch.php",
                type:"POST",
                data: 'request=' + value,
                beforeSend:function(){
                    $(".card-body").html("<span>Working....</span>");
                },
                success:function(data){
                    $(".card-body").html(data);
                }
            });
        });
    });
</script>



    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" style="text-decoration: none;" href="#page-top">
        <i class="fas fa-angle"></i>
        <i class="fas fa-angle-up"></i>
        <i class="fas fa-angle"></i>
    </a>



<!-- Message Box JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

<script>
$('.del-btn').on('click',function(e){
    e.preventDefault();
    const href = $(this).attr('href') 
    Swal.fire({
        title: 'Are you sure to delete?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                document.location.href = href;
                
            }
        })
 })

$('.unpublished').on('click',function(e){
    e.preventDefault();
    const href = $(this).attr('href') 
    Swal.fire({
        title: 'Are you sure to unpublished this?',
        text: "You will be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, unpublished it!'
        }).then((result) => {
            if (result.value) {
                document.location.href = href;
                
            }
        })
 })

$('.published').on('click',function(e){
    e.preventDefault();
    const href = $(this).attr('href') 
    Swal.fire({
        title: 'Are you sure to published this?',
        text: "You will be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, unpublished it!'
        }).then((result) => {
            if (result.value) {
                document.location.href = href;
                
            }
        })
 })

 const flashdata1 = $('.flash-data1').data('flashdata')
 if(flashdata1){
     swal.fire({
         icon: 'success',
         type : 'success',
         title : 'Record Deleted Successfully',
         text : 'Record has been deleted!'
     })
 }

 const flashdata2 = $('.flash-data2').data('flashdata')
 if(flashdata2){
     swal.fire({
         icon: 'success',
         type : 'success',
         title : 'Record Inserted Successfully',
         text : 'Record has been inserted!'
     })
 }

 const flashdata3 = $('.flash-data3').data('flashdata')
 if(flashdata3){
     swal.fire({
         icon: 'success',
         type : 'success',
         title : 'Record Successfully Updated',
         text : 'Record has been updated!'
     })
 }

 const flashdata4 = $('.flash-data4').data('flashdata')
 if(flashdata4){
     swal.fire({
         icon: 'success',
         type : 'success',
         title : 'Record Successfully Unpublished',
         text : 'Record has been unpublished!'
     })
 }

 const flashdata5 = $('.flash-data5').data('flashdata')
 if(flashdata5){
     swal.fire({
         icon: 'success',
         type : 'success',
         title : 'Record Successfully Published',
         text : 'Record has been published!'
     })
 }
</script>


<?php
//logout modal 
include('includes/logout-modal.php');
include('includes/scripts.php');
include('includes/footer.php');
?>

