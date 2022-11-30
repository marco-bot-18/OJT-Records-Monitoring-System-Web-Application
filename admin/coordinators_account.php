<?php
require_once('includes/session.php');

//PHPMAILER
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//date and time
date_default_timezone_set('Asia/Manila');
$timestamp = time();
$td = date("F d, Y");
$time = date("h:i:s A");

if(isset($_POST['save'])) {
    //generate otp
    $number = uniqid();
    $varray = str_split($number);
    $len = sizeof($varray);
    $otp = array_slice($varray, $len-6, $len);
    $otp = implode(",", $otp);
    $otp = str_replace(',', '', $otp);

    $coordinator_id = $_POST['coordinator_id'];
    $get_password = $otp;
    $password = md5($otp);
    $fname = ucwords($_POST['fname']);
    $mname = ucwords($_POST['mname']);
    $lname = ucwords($_POST['lname']);
    $address = ucwords($_POST['address']);
    $contact = $_POST['contact'];
    $civil_stats = $_POST['civil_stats'];
    $gender = $_POST['gender'];
    $course = $_POST['course'];
    $email = $_POST['coordinator_email'];
    $academic_yr_sem = $_POST['acad_yr_sem'];
    $img = "unknown.png";
    $status = "active";
    $usertype = "teacher";
    $uniq_id = uniqid('faculty');
    $isArchived = "not archived";

    // $check_duplicate_email = "SELECT email FROM tbl_coordinators WHERE email='$email'";
    //     $res = mysqli_query($conn, $check_duplicate_email);
    //     $count = mysqli_num_rows($res);

    $check_duplicate_coordinator_id = "SELECT coordinator_id FROM tbl_coordinators WHERE coordinator_id='$coordinator_id'";
    $res1 = mysqli_query($conn, $check_duplicate_coordinator_id);
    $count1 = mysqli_num_rows($res1);

    if($count > 0){
        //$err_msg = "Email is Already Taken!";
        //header('location: coordinators.php?warning1=1');
    }
    else if($count1 > 0){
        //$err_msg = "Teacher's ID is Already Taken!";
        //header('location: coordinators.php?warning2=1');
    }

    else {
        $sql = "INSERT INTO tbl_coordinators(coordinator_id, fname, mname, lname, contact, email, gender, address, password, status, image, academic_yr_sem, civil_stats, userType, course, uniq_id, isArchived) VALUES 
        ('$coordinator_id', '$fname', '$mname', '$lname', '$contact', '$email', '$gender', '$address', '$password', '$status', '$img', '$academic_yr_sem', '$civil_stats', '$usertype', '$course', '$uniq_id', '$isArchived')";

        $query_run = mysqli_query($conn, $sql);

        if($query_run) {
            try {
                require '../vendor/autoload.php';
                $mail = new  PHPMailer(true);
                //$mail->SMTPDebug = 1;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'websiteet18@gmail.com';                     //SMTP username
                $mail->Password   = 'empowermenttechnology';                               //SMTP password
                $mail->SMTPSecure = "tls"; //Enable implicit TLS encryption
                $mail->Port       = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom('websiteet18@gmail.com', 'Dean');
                $mail->addAddress($email);//Name is optional

                //Content
                $mail->isHTML(true);//Set email format to HTML
                $mail->Subject = "e-OJT aCCeSs: Your Have Now Your Account As a OJT Teacher";
                $template    = "You have now your account in e-OJT aCCeSs Portal. Your employee ID is <b>"." ".$coordinator_id."</b>. Your password is <b>".$get_password."</b><br> PLEASE DON'T SHARE YOUR PASSWORD TO ANYONE!.";
                $mail->Body = $template;
                $mail->send();
                //echo 'Message has been sent';
            }
            catch(Exception $ex){
                //echo $ex;
            }
            $active = "active";
            $my_ID = $_SESSION['admin_username'];
            $session_log = "You created an account for ".$fname." ".$mname." ".$lname." (".$stud_id.")";
            //log session
            $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_log', '$td', '$time', '$my_ID', '$active')";
            $query_log_run = mysqli_query($conn, $sql_log);
            if ($query_log_run) {
                $_SESSION['add_teacher_success'] = $fname." ".$mname." ".$lname;
                header('location: coordinators_account.php');
            }
        }
        else { 
            echo $conn->error; 
        }
    }
}

else if(isset($_POST['update'])){
    //date and time
    date_default_timezone_set('Asia/Manila');
    $timestamp = time();
    $td = date("F d, Y");
    $time = date("h:i:s A");

    $id = $_POST['id'];
    $uniq_id = $_POST['uniq_id']; //uniq id caller
    $current_emp_id = $_POST['current_emp_id']; //current emp id
    $coordinator_id = $_POST['coordinator_id']; //new emp id
    $fname = ucwords($_POST['fname']);
    $mname = ucwords($_POST['mname']);
    $lname = ucwords($_POST['lname']);
    $program = $_POST['course'];
    $acad_yr_sem = $_POST['acad_yr_sem'];

    if($coordinator_id == ""){
        $fullname = $fname." ".$mname." ".$lname." (".$current_emp_id.")";
        $sql1 = "UPDATE tbl_coordinators SET fname='$fname', mname='$mname', lname='$lname', course='$program', academic_yr_sem='$acad_yr_sem' WHERE id='$id'";
        $query1 = $conn->query($sql1);
        if($query1){
            $sql2 = "UPDATE tbl_coordinator_save_works SET name_of_teacher='$fullname' WHERE teacher_uniq_id='$uniq_id'";
            $query2 = $conn->query($sql2);
            if($query2){
                $sql3 = "UPDATE tbl_students_work SET name_of_teacher='$fullname' WHERE teacher_uniq_id='$uniq_id'";
                $query3 = $conn->query($sql3);
                if($query3){
                    $sql4 = "UPDATE tbl_students SET coordinator='$fullname' WHERE your_teacher_uniq_id='$uniq_id'";
                    $query4 = $conn->query($sql4);
                    if($query4){
                        $active = "active";
                        $my_ID = $_SESSION['admin_username'];
                        $session_log = "You updated the account of ".$fname." ".$mname." ".$lname." (".$current_emp_id.")";
                        //log session
                        $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_log', '$td', '$time', '$my_ID', '$active')";
                        $query_log_run = mysqli_query($conn, $sql_log);
                        if ($query_log_run) {
                            $_SESSION['edit_teacher_success'] = $fname." ".$mname." ".$lname;
                            header('location: coordinators_account.php?=teacher_updated_info');
                        }
                    }
                }
            }
        }
    }

    else if($coordinator_id != ""){
        $fullname = $fname." ".$mname." ".$lname." (".$coordinator_id.")";
        $sql1 = "UPDATE tbl_coordinators SET fname='$fname', mname='$mname', lname='$lname', course='$program', academic_yr_sem='$acad_yr_sem' WHERE id='$id'";
        $query1 = $conn->query($sql1);
        if($query1){
            $sql2 = "UPDATE tbl_coordinator_save_works SET name_of_teacher='$fullname' WHERE teacher_uniq_id='$uniq_id'";
            $query2 = $conn->query($sql2);
            if($query2){
                $sql3 = "UPDATE tbl_students_work SET name_of_teacher='$fullname' WHERE teacher_uniq_id='$uniq_id'";
                $query3 = $conn->query($sql3);
                if($query3){
                    $sql4 = "UPDATE tbl_students SET coordinator='$fullname' WHERE your_teacher_uniq_id='$uniq_id'";
                    $query4 = $conn->query($sql4);
                    if($query4){
                        $active = "active";
                        $my_ID = $_SESSION['admin_username'];
                        $session_log = "You updated the account of ".$fname." ".$mname." ".$lname." (".$current_emp_id.")";
                        //log session
                        $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_log', '$td', '$time', '$my_ID', '$active')";
                        $query_log_run = mysqli_query($conn, $sql_log);
                        if ($query_log_run) {
                            $_SESSION['edit_teacher_success'] = $fname." ".$mname." ".$lname." (".$coordinator_id.")";
                            header('location: coordinators_account.php?=teacher_updated_info');
                        }
                    }
                }
            }
        }
    }
}
?>

<style type="text/css">
.zoom {
    padding: 0px;
    transition: transform .2s; /* Animation */
    margin: 0 auto;
}

.zoom:hover {
    transform: scale(3.5); /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
}

.image-preview {
    margin-left: px;
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
#tra{
    color: #333333;
}
#tra:hover {
    color: black;
    background: #f2f2f2;
}
</style>

<?php
include('includes/session.php'); 
include('includes/header.php');?>
<!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

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
                <a class="nav-link" href="students_list_all.php">
                    <i class="fas fa-user-graduate"></i>
                <span>Students</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="coordinators_list_all.php">
                    <i class="fas fa-user-tie"></i>
                <span>Teachers</span></a>
            </li>


            <li class="nav-item">
                <a class="nav-link" href="students_documents.php">
                    <i class="fas fa-file-download"></i>
                    <span>Students' Documents</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo" href="#">
                    <i class="fas fa-file-signature"></i>
                    <span>Documents for Signing</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Manage</h6>
                        <a class="collapse-item" href="request_docs_pending.php">Pending
                            <span class="badge badge bg-danger" style="color: white;"><!-- badge badge bg-danger -->
                                <?php
                                    $work_stats = "semi-pending3";
                                    $send_to_dean = "dean";
                                    $stats = "not archived";
                                    $submitted = "yes";
                                    $count = 1;
                                    $sql = "SELECT * from tbl_students_work where send_to_Dean='$send_to_dean' and work_status='$work_stats' and submitted='$submitted' and status='$stats'";
                                    $query = $conn->query($sql);
                                    echo $query->num_rows;
                                ?>  
                            </span>
                        </a>
                        <a class="collapse-item" href="request_docs_completed.php">Approved
                            <span class="badge badge bg-danger" style="color: white;">
                                <?php
                                    $work_stats1 = "completed";
                                    $send_to_dean = "dean";
                                    $stats = "not archived";
                                    $send_to_dean = "dean";
                                    $submitted = "yes";
                                    $count = 1;
                                    $sql = "SELECT * from tbl_students_work where (send_to_Dean='$send_to_dean' and work_status='$work_stats1' and submitted='$submitted' and status='$stats') order by id asc";
                                    $query = $conn->query($sql);
                                    echo $query->num_rows;
                                ?>  
                            </span>
                        </a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReports" aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-file-alt"></i>
                    <span>Reports</span>
                </a>
                <div id="collapseReports" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Category</i></h6>
                        <a class="collapse-item" href="student_submittals.php">Students' Submittals</a>
                        <a class="collapse-item" href="students_category.php">Students' Category</a>
                    </div>
                </div>
            </li>

            <!-- <li class="nav-item">
                <a class="nav-link" href="other_documents.php">
                    <i class="fas fa-folder"></i>
                    <span>Other Documents</span></a>
            </li> -->
            <li class="nav-item">
                <a class="nav-link" href="ojt_categories.php">
                    <i class="far fa-address-book"></i>
                    <span>OJT Categories</span></a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="courses.php">
                    <i class="fas fa-graduation-cap"></i>
                    <span>Courses</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="academic_year_sem.php">
                    <i class="fas fa-book-reader"></i>
                    <span>Academic Year and Semester</span></a>
            </li>

            <!-- Nav Item - Collapse Menu -->
            <li class="nav-item active">
                <a class="nav-link collapsed" href="accounts.php" data-toggle="collapse" data-target="#collapseAccounts"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Accounts</span>
                </a>
                <div id="collapseAccounts" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Category</i></h6>
                        <!-- <a class="collapse-item" href="student_account.php">Students</a> -->
                        <a class="collapse-item active" href="coordinators_account.php">OJT Teachers</a>
                        <a class="collapse-item" href="program_head_account.php">Program Head</a>
                    </div>
                </div>
            </li>


            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <!-- <i class="fas fa-fw fa-wrench"></i> -->
                    <i class="fas fa-archive"></i>
                    <span>Archives</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Manage</h6>
                        <a class="collapse-item" href="students_accounts_archives.php">Student Accounts</a>
                        <a class="collapse-item" href="teacher_accounts_archives.php">Teacher Accounts</a>
                        <a class="collapse-item" href="program_head_accounts_archives.php">Program Head Accounts</a>
                    </div>
                </div>  
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

<?php include('includes/topbar.php'); ?>

<script>
    function checkAvailabilityCoordinatorId1() {
    $("#loaderIcon").show();
        jQuery.ajax({
            url: "includes/check_availability.php",
            data:'coordinator_id1='+$("#coordinator_id1").val(),
            type: "POST",
            success:function(data){
            $("#coordinator_id-availability1").html(data);
            $("#loaderIcon").hide();
        },
        error:function (){}
        });
    }
</script>

<script>
    function checkAvailabilityCoordinatorId() {
    $("#loaderIcon").show();
        jQuery.ajax({
            url: "includes/check_availability.php",
            data:'coordinator_id='+$("#coordinator_id").val(),
            type: "POST",
            success:function(data){
            $("#coordinator_id-availability").html(data);
            $("#loaderIcon").hide();
        },
        error:function (){}
        });
    }
</script>

<script>
    function checkAvailabilityCoordinatorEmail() {
    $("#loaderIcon").show();
        jQuery.ajax({
            url: "includes/check_availability.php",
            data:'coordinator_email='+$("#coordinator_email").val(),
            type: "POST",
            success:function(data){
            $("#coordinator_email-availability").html(data);
            $("#loaderIcon").hide();
        },
        error:function (){}
        });
    }
</script>

<script>
  function alpha(e) {
        var k;
        document.all ? k = e.keyCode : k = e.which;
        // UPDATED - is CHARCODE
        //allow - sign, but cannot allow any other special chars
        return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 || (k >= 48 && k <= 57) || k == 45);
    }
</script>


<!-- Add teacher modal -->
    <div class="modal fade bd-example-modal-xl" id="addCoordinator" tabindex="-1" role="dialog" aria-labelledby="addStudent" aria-hidden="true" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-xl" role="document" style="color: #333333">
        <div class="modal-content modal-xl">
          <div class="modal-header modal-xl">
            <h5 class="modal-title" style="color: #0d6efd;"><h><i class="fas fa-user-tie"></i> Create Account for OJT Teacher</h></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body modal-xl">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">   
                    <form class="" method="POST" enctype="multipart/form-data">
                        <div class='errorWrap'><strong>This fields with red asterisk (<h style="color: red;">*</h>) are required </strong></div>
                        <div class="form-group">
                            <label for="">Employee ID: <span style="color: red;">*</span></label><br>
                            <input type="text" name="coordinator_id" onkeypress="return alpha(event)" class="form-control"  id="coordinator_id" aria-describedby="" onBlur="checkAvailabilityCoordinatorId()" placeholder="ex. 990879" required autofocus="">
                            <!-- stud id check avilability -->
                            <div style="padding-top: 5px;">
                                <span id="coordinator_id-availability" style="font-size:12px;"></span>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="">First Name: <span style="color: red;">*</span></label><br>
                            <input type="text" name="fname" class="form-control" id="fname" aria-describedby="" placeholder="ex. Juan" required="">
                        </div>
                        <div class="form-group">
                            <label for="">Middle Name: <span style="color: red;">*</span></label><br>
                            <input type="text" name="mname" class="form-control" id="mname" aria-describedby="" placeholder="ex. Santos" required="">
                        </div>
                        <div class="form-group">
                            <label for="">Last Name: <span style="color: red;">*</span></label><br>
                            <input type="text" name="lname" class="form-control" id="lname" aria-describedby="" placeholder="ex. Dela Cruz" required="">
                        </div>
                        <div class="form-group">
                            <label for="">Email Address: <span style="color: red;">*</span></label><br>
                            <input type="email" onkeypress="return event.charCode != 32" name="coordinator_email" class="form-control" id="coordinator_email" aria-describedby="" onblur="checkAvailabilityCoordinatorEmail()" placeholder="ex. juandelacruz09@gmail.com" required="">
                            <div style="padding-top: 8px;">
                                <span id="coordinator_email-availability" style="font-size:12px;"></span>
                            </div>  
                        </div>
                        <div class="form-group">
                            <label for="">Academic Year and Semester: <span style="color: red;">*</span></label><br>
                            <select class="form-control" name="acad_yr_sem" id="acad_yr_sem">
                                <?php
                                include 'includes/db_connect_pdo.php';
                                //using pdo format
                                $active = "active";
                                $sql = "SELECT * from tbl_academic_year_sem WHERE status=:active";
                                    $query = $dbh -> prepare($sql);
                                    $query->bindParam(':active',$active,PDO::PARAM_STR);
                                    $query->execute();
                                    $results=$query->fetchAll(PDO::FETCH_OBJ);
                                    $cnt=1;
                                    if($query->rowCount() > 0) {
                                        foreach($results as $result){?>
                                        <option value="<?php echo $result->academic_yr." - ".$result->semester; ?>">
                                            <?php echo $result->academic_yr." - ".$result->semester;?>
                                        </option>
                                <?php }} ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Program: <span style="color: red;">*</span></label><br>
                            <select class="form-control" name="course" id="course">
                                <?php
                                include 'includes/db_connect_pdo.php';
                                //using pdo format
                                $sql = "SELECT DISTINCT course_code from tbl_courses order by id ASC";
                                    $query = $dbh -> prepare($sql);
                                    $query->execute();
                                    $results=$query->fetchAll(PDO::FETCH_OBJ);
                                    $cnt=1;
                                    if($query->rowCount() > 0) {
                                        foreach($results as $result){?>
                                        <option value="<?php echo $result->course_code; ?>">
                                            <?php echo $result->course_code; ?>
                                        </option>
                                <?php }} ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class='succWrap'><strong>Additional Information </strong></div>
                        <div class="form-group">
                            <label for="">Civil Status: </label><br>
                            <select class="form-control" name="civil_stats" id="civil_stats">
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                                <option value="Widowed">Widowed</option>
                                <option value="Seperated">Seperated</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Contact Number: </label><br>
                            <input type="number" name="contact" class="form-control" id="contact" aria-describedby="" placeholder="ex. 099999999">
                        </div>
                        <div class="form-group">
                            <label for="">Gender: <span style="color: blue;">*</span></label><br>
                            <select class="form-control" name="gender" id="gender">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Address: </label><br>
                            <textarea class="form-control" id="address" placeholder="ex. Brgy. Bubukal, Santa Cruz, Laguna" name="address" rows="5"></textarea>
                        </div>

                        <!-- <div class="form-group">
                            <label>Upload Image</label><br>
                            <input type="file" class="form-control" id="image_" name="img" required="" autofocus="">
                        </div> -->
                        <!-- to display image -->
                <!--         <div class="image-preview" id="imgPreview">
                            <img height="300px"  class="image-preview__image">
                            <span class="image-preview__default-text"></span>
                        </div> -->
                        </div>
                </div>
            </div>
          </div>
            
             <div class="modal-footer modal-xl">
                <button type="button" id="btnUpdate" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                <button type="submit" class="btn btn-primary" name="save" id="add">Create Account <i class="fas fa-save"></i></button>
            </div>
            <!-- form end -->
          </form>
        </div>
      </div>
    </div>
 

<div class="container-fluid">
<!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><span><b>Accounts</b></span> / OJT Teachers</h1>
    </div>

<style>
    .errorWrap {
        color: black;
        padding: 10px;
        margin: 0 0 20px 0;
        background: #fff;
        border-left: 4px solid #dd3d36;
        -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    }
    .succWrap{
        color: black;
        padding: 10px;
        margin: 0 0 20px 0;
        background: #fff;
        border-left: 4px solid blue;
        -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    }
    #coordinator_id1 {
        border: 1px solid gray;
        color: #333333;
    }
    #coordinator_id1:focus { 
        border: 1px solid #006bb3;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
        color: black;
    }
    #coordinator_id {
        border: 1px solid gray;
        color: #333333;
    }
    #coordinator_id:focus { 
        border: 1px solid #006bb3;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
        color: black;
    }
    #fname {
        border: 1px solid gray;
        color: #333333;
        text-transform: capitalize;
    }
    #fname:focus {
        border: 1px solid #006bb3;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
        color: black;
        text-transform: capitalize;
    }

    #mname {
        border: 1px solid gray;
        color: #333333;
         text-transform: capitalize;
    }
    #mname:focus {
        border: 1px solid #006bb3;
        box-shadow: none;
        outline-offset: 0px;
        outline: none; 
        color: black;
        text-transform: capitalize;
    }

    #lname {
        border: 1px solid gray;
        color: #333333;
         text-transform: capitalize;
    }
    #lname:focus {
        border: 1px solid #006bb3;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
        color: black;
         text-transform: capitalize;
    }
    #address{
        border: 1px solid gray;
        color: #333333;
         text-transform: capitalize;
    }
    #address:focus {
        border: 1px solid #006bb3;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
        color: black;
         text-transform: capitalize;
    }

    #coordinator_email{
       border: 1px solid gray; 
       color: #333333;
    }
    #coordinator_email:focus {
        border: 1px solid #006bb3;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
        color: black;
    }

    #course{
        border: 1px solid gray;
        color: #333333;
    }
    #course:focus {
        border: 1px solid #006bb3;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
        color: black;
    }

    #contact{
        border: 1px solid gray;
        color: #333333;
    }
    #contact:focus {
        border: 1px solid #006bb3;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
        color: black;
    }

    #gender{
        border: 1px solid gray;
        color: #333333;
    }
    #gender:focus {
        border: 1px solid #006bb3;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
        color: black;
    }

    #bday{
        border: 1px solid gray;
        color: #333333;
    }
    #bday:focus {
        border: 1px solid #006bb3;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
        color: black;
    }

    #civil_stats{
        border: 1px solid gray;
        color: #333333;
    }
    #civil_stats:focus {
        border: 1px solid #006bb3;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
        color: black;
    }
    #acad_yr_sem{
        border: 1px solid gray;
        color: #333333;
    }
    #acad_yr_sem:focus {
        border: 1px solid #006bb3;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
        color: black;
    }
    #acad_yr{
        border: 1px solid gray;
        color: #333333;
    }
    #acad_yr:focus {
        border: 1px solid #006bb3;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
        color: black;
    }
    #my_password{
        border: 1px solid gray;
        color: #333333;
    }
    #my_password:focus {
        border: 1px solid #006bb3;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
        color: black;
    }
</style>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-danger">
                INSTRUCTIONS
            </h6>
        </div>
        <div class="card-body" style="color: #333333; ">
            The use of this application is intended only to create an account for OJT teachers.<br><br>
            All fields marked with red asterisk ( <span style="color: red">*</span> ) are required fields. These fields must not be leaved blank.
            <br><br>
            All fields with no asterisks ( * ) are optional  fields. These fields must okay to be leaved blank.
        </div>
        <br>
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <h6 class="m-0 font-weight-bold text-primary">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCoordinator">
                    Create Account for OJT Teacher <i class="fas fa-plus-square"></i>
                </button>
                </h6>
            </h6>
        </div>
        <div class="card-header py-3" style="background: #595959;">
            <h6 class="m-0 font-weight-bold" style="color: ghostwhite;">
                <i class="fas fa-user-tie"></i> User Account of OJT Teachers
            </h6>
        </div>
            <!-- table -->
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="dataTable"  cellpadding="20"  id="example" width="100%" style="color: #333333">
                      <thead>
                        <tr>
                        <center>
                          <th hidden=""> ID</th>
                          <th>No.</th>
                          <th>Employee ID No.</th>
                          <th>Full Name</th>
                          <th>Status</th>
                          <th>Action</th>
                        </center>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                            require_once('includes/db_connect.php');
                            //$stats = "active";
                            $count = 1;
                            $isArchived = "not archived";
                            $usertype = "teacher";
                            $sql = "SELECT * FROM tbl_coordinators where isArchived='$isArchived' and userType='$usertype' ORDER BY id ASC";
                            $query = $conn->query($sql);
                            while($row = $query->fetch_assoc()){
                                $coordinator_id = $row['coordinator_id'];
                                $id = $row['id'];
                                $status = $row['status'];
                        ?>
                        <tr id="tra">
                          <td hidden=""><?php echo $id ?> </td>
                          <td><?php echo $count; ?></td>
                          <td><?php echo $coordinator_id; ?></td>
                          <td><?php echo $row['lname'].", ".$row['fname']." ".$row['mname']; ?></td>
                          <td>
                          <?php
                            if ($status == 'not active') {
                                echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-danger'>NOT ACTIVE</span>";
                            }
                            else if ($status == 'active') {
                                echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-success'>ACTIVE</span>";
                            }
                          ?> 
                          </td>
                          <td>
                            <a href="#view<?php echo $id;?>" data-toggle="modal" data-id="" class="btn btn-info" title="View Teacher's Account Info"><i class="fas fa-eye"></i></a>
                            
                            <a href="#edit<?php echo $id;?>" data-toggle="modal" data-id="" class="btn btn-dark" title="Edit Teacher's Account Info"><i class="fas fa-edit"></i></a>
                            <?php if ($status == 'not active') {?>
                                <a href='coordinators_set_active.php?id=<?php echo $id;?>' title="Set Teacher's Account to Active" class='active-btn'><button class='btn btn-success'><i class="fas fa-check-square"></i></button></a>
                            <?php } else if ($status == 'active') { ?>
                                <a href='coordinators_set_ban.php?id=<?php echo $id;?>' title="Set the Teacher's Account to Not Active" class='ban-btn'><button class='btn btn-warning'><i class="fas fa-ban"></i></button></a>
                            <?php } ?>
                            <a href="#archive<?php echo $id;?>" data-toggle="modal" title="Archive"><button class="btn btn-danger"><i class="fas fa-archive"></i></button></a>
                          </td>
                        </tr>

                        <div class="modal fade bd-example-modal-lg" id="edit<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                          <div class="modal-dialog modal-lg" role="document" style="color:  #333333;">
                            <div class="modal-content modal-lg">
                              <div class="modal-header modal-lg">
                                <h5 class="modal-title" style="color: #0d6efd;"><h><i class="fas fa-user-tie"></i> Edit OJT Teacher's Details</h></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-header modal-lg">
                                <h style="color: #333333">
                                <i class="fas fa-id-card"></i> <?php echo $row['coordinator_id']?> <br>
                                <i class="fas fa-user-tie"></i> <?php echo $row['fname']." ".$row['mname']." ".$row['lname']?> <br>
                                <i class="fas fa-graduation-cap"></i> <?php echo $row['course']?> <br>
                                <i class="fas fa-book-reader"></i> <?php echo $row['academic_yr_sem']?>
                                </h>
                              </div>
                              <div class="modal-body modal-lg">
                                <form action="" method="POST" enctype="multipart/form-data">
                                    <!-- <div class="form-group"> -->
                                        <input type="text" hidden="" name="id" value="<?php echo $row['id'];?>">
                                        <input type="text" hidden="" name="current_emp_id" value="<?php echo $row['coordinator_id'];?>">
                                        <input type="text" hidden="" name="uniq_id" value="<?php echo $row['uniq_id'];?>">
                                        <!-- <label for="">Employee ID: </label> <br> -->
                                        <input type="text" name="coordinator_id" onkeypress="return event.charCode" class="form-control" id="coordinator_id1" aria-describedby="" onBlur="checkAvailabilityCoordinatorId1()" placeholder="ex. 990879" hidden="">
                                        <div style="padding-top: 5px;">
                                            <span id="coordinator_id-availability1" style="font-size:12px;"></span>
                                        </div> 
                                       <!--  <i class="text-primary">*If you do not want to change the employee ID, leave this textfield with blank</i> -->
                                        <!-- stud id check avilability -->
                                    <!-- </div> -->
                                    <div class="form-group">
                                        <label for="">First Name: <span style="color: red;">*</span></label><br>
                                        <input type="text" name="fname" value="<?php echo $row['fname'];?>" class="form-control" id="fname" aria-describedby="" placeholder="ex. Juan" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Middle Name: <span style="color: red;">*</span></label><br>
                                        <input type="text" name="mname" value="<?php echo $row['mname'];?>"  class="form-control" id="mname" aria-describedby="" placeholder="ex. Santos" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Last Name: <span style="color: red;">*</span></label><br>
                                        <input type="text" value="<?php echo $row['lname'];?>"  name="lname" class="form-control" id="lname" aria-describedby="" placeholder="ex. Dela Cruz" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Program: </label><br>
                                        <select class="form-control" name="course" id="course">
                                            <option value='<?php echo $row['course'];?>' selected=''>Default Program</option>
                                            <?php
                                            include 'includes/db_connect_pdo.php';
                                            //using pdo format
                                            $sql11 = "SELECT DISTINCT course_code from tbl_courses order by id ASC";
                                                $query11 = $dbh -> prepare($sql11);
                                                $query11->execute();
                                                $results11=$query11->fetchAll(PDO::FETCH_OBJ);
                                                $cnt=1;
                                                if($query11->rowCount() > 0) {
                                                    foreach($results11 as $result1){?>
                                                    <option value="<?php echo $result1->course_code; ?>">
                                                        <?php echo $result1->course_code; ?>
                                                    </option>
                                            <?php }} ?>
                                        </select>
                                        <i class="text-primary">*If you do not want to change the program, choose default</i>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Academic Year and Semester: <span style="color: red;">*</span></label><br>
                                        <select class="form-control" name="acad_yr_sem" id="acad_yr_sem">
                                            <option value='<?php echo $row['academic_yr_sem'];?>' selected=''>Default Academic Year and Semester</option>
                                            <?php
                                            include 'includes/db_connect_pdo.php';
                                            //using pdo format
                                            $active = "active";
                                            $sql1 = "SELECT * from tbl_academic_year_sem WHERE status=:active";
                                                $query1 = $dbh -> prepare($sql1);
                                                $query1->bindParam(':active',$active,PDO::PARAM_STR);
                                                $query1->execute();
                                                $results1=$query1->fetchAll(PDO::FETCH_OBJ);
                                                $cnt=1;
                                                if($query1->rowCount() > 0) {
                                                    foreach($results1 as $result1){?>
                                                    <option value="<?php echo $result1->academic_yr." - ".$result1->semester; ?>">
                                                        <?php echo $result1->academic_yr." - ".$result1->semester;?>
                                                    </option>
                                            <?php }} ?>
                                        </select>
                                        <i class="text-primary">*If you do not want to change the academic year and semester, choose default</i>
                                    </div>
                              </div>
                                <div class="modal-footer modal-lg">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel <i class="fas fa-times-circle"></i></button>
                                    <button type="submit" class="btn btn-primary" name="update" id="update">Update <i class="fas fa-save"></i></button>
                                    <!-- <button class="btn btn-primary" name="update">Update</button> -->
                                </div>
                                </form>
                            </div>
                          </div>
                        </div>

                        <!-- archive -->
                        <div class="modal fade" id="archive<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                          <div class="modal-dialog">
                            <div class="modal-content" style="color: #333333;">
                              <div class="modal-header">
                                <h6 class="modal-title" id="exampleModalLabel" style="color: #0d6efd;"><i class="fas fa-archive"></i> Are You Sure Do you Want To Archive The Account of <?php echo $row['fname']." ".$row['mname']." ".$row['lname']." (".$row['coordinator_id'].")";?> ?</h6>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <form action="coordinators_account_archive.php" method="POST" enctype="multipart/form-data">
                                    <input type="text" name="coordinator_id" value="<?php echo $coordinator_id?>" hidden>
                                    <input type="text" name="coordinator_uniq_id" value="<?php echo $row['uniq_id'];?>" hidden>
                                    <input type="text" name="fullname_id" value="<?php echo $row['fname']." ".$row['mname']." ".$row['lname']." (".$row['coordinator_id'].")";?>" hidden>
                                    <div class="form-group">
                                        <label>Confirm Your Password</label>
                                        <input type="password" name="my_password" placeholder="Enter Your Password" id="my_password" class="form-control">
                                        <div style="padding-top: 8px;">
                                            <span id="validate_password_correct" style="font-size:12px;"></span>
                                        </div> 
                                    </div>
                              </div>
                              <div class="modal-footer">
                                    <button type="button" class="btn btn-dark" data-dismiss="modal">Cancel <i class="fas fa-times-circle"></i></button>
                                    <button type="submit" name="archive" id="archive" class="btn btn-danger">Yes, Archive It! <i class="fas fa-archive"></i></button>
                                    <!-- <button class="btn btn-primary" name="update">Update</button> -->
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>

                        <!-- archive all-->
                        <div class="modal fade" id="archive_all" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                          <div class="modal-dialog">
                            <div class="modal-content" style="color: #333333;">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel" style="color: #0d6efd;"><i class="fas fa-archive"></i> Are You Sure Do you Want To Archive All The Account of OJT Teachers ?</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <form action="coordinators_account_archive_all.php" method="POST" enctype="multipart/form-data">
                                    <input type="text" name="coordinator_id" value="<?php echo $coordinator_id?>" hidden>
                                    <input type="text" name="coordinator_uniq_id" value="<?php echo $row['uniq_id'];?>" hidden>
                                    <input type="text" name="fullname_id" value="<?php echo $row['fname']." ".$row['mname']." ".$row['lname']." (".$row['coordinator_id'].")";?>" hidden>
                                    <div class="form-group">
                                        <label>Confirm Your Password</label>
                                        <input type="password" name="my_password" placeholder="Enter Your Password" id="my_password" class="form-control">
                                        <div style="padding-top: 8px;">
                                            <span id="validate_password_correct" style="font-size:12px;"></span>
                                        </div> 
                                    </div>
                              </div>
                              <div class="modal-footer">
                                    <button type="button" class="btn btn-dark" data-dismiss="modal">Cancel <i class="fas fa-times-circle"></i></button>
                                    <button type="submit" name="archive" id="archive" class="btn btn-danger">Yes, Archive All! <i class="fas fa-archive"></i></button>
                                    <!-- <button class="btn btn-primary" name="update">Update</button> -->
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>

                        <!-- View Coordinator Modal -->
                        <div class="modal fade bd-example-modal-lg" id="view<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                          <div class="modal-dialog modal-lg" role="document" style="color:  #333333;">
                            <div class="modal-content modal-lg">
                              <div class="modal-header modal-lg">
                                <h5 class="modal-title" style="color: #0d6efd;"><h><i class="fas fa-user-tie"></i> View OJT Teacher's Details</h></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body modal-lg">
                                <div style="padding: 20px; background: rgba(51, 51, 51, 0.9); color: ghostwhite;">
                                    <center>
                                        <img src="uploaded_images/<?php echo $row['image']; ?>" alt="" style="margin-right: 60px;border-radius: 5%;" id="image1" width="200px;" height="200px;">
                                    </center>
                                </div>
                                <div class="container" style="background: rgba(51, 51, 51, 0.9); color: ghostwhite; padding: 20px;">
                                     <hr style="background-color: ghostwhite;">
                                  <div class="row">
                                    <div class="col">
                                      <label>Employee ID Number:</label>
                                    </div>
                                  
                                    <div class="col">
                                       <font style="font-weight: bold; "><?php echo $row['coordinator_id']; ?></font>
                                    </div>
                                  </div>
                                   <div class="row">
                                    <div class="col">
                                       <label>Name of OJT Teacher :</label>
                                    </div>
                                    <div class="col">
                                       <font style="font-weight: bold; "><?php echo $row['fname']. " ".$row['mname']. " ".$row['lname']; ?></font>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col">
                                       <label>Academic Year and Semester :</label>
                                    </div>
                                    <div class="col">
                                       <font style="font-weight: bold; "><?php echo $row['academic_yr_sem']; ?></font>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col">
                                       <label>Number of Students :</label>
                                    </div>
                                    <div class="col">
                                       <?php  
                                            //concatinating the name coordinator  
                                            $id1 = $row['coordinator_id'];         
                                            $sql1 = "SELECT Concat(fname, ' ', mname,' ', lname, ' ', '(',coordinator_id,')') AS fullname FROM tbl_coordinators where coordinator_id = '$id1'";
                                            $query1 = $conn->query($sql1);
                                            while($row1 = $query1->fetch_assoc()){
                                                $_SESSION['coordinator_fullname'] = $row1['fullname'];
                                            }
                                            //to display the total students that she/he handled
                                            $coordinator_fullname = $_SESSION['coordinator_fullname'];
                                            $sql2 = "SELECT * FROM tbl_students WHERE coordinator='$coordinator_fullname'";
                                            $query2 = $conn->query($sql2);

                                            echo $query2->num_rows;
                                        ?>
                                    </div>
                                  </div>
                                </div>
                                <br>

                                <div class="container" style="color: #333333;">
                                    <h5>OJT Teacher's Additional Information</h5>
                                    <hr>
                                  <div class="row">
                                    <div class="col">
                                      <label>Email :</label>
                                    </div>
                                    <div class="col">
                                      <font style="font-weight: bold;"><?php echo $row['email']; ?></font>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col">
                                      <label>Civil Status :</label>
                                    </div>
                                    <div class="col">
                                      <font style="font-weight: bold;"><?php echo $row['civil_stats']; ?></font>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col">
                                      <label>Date of Birth :</label>
                                    </div>
                                    <div class="col">
                                      <font style="font-weight: bold;"><?php echo $row['bday']; ?></font>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col">
                                      <label>Gender :</label>
                                    </div>
                                    <div class="col">
                                      <font style="font-weight: bold;"><?php echo $row['gender']; ?></font>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col">
                                      <label>Address :</label>
                                    </div>
                                    <div class="col">
                                      <font style="font-weight: bold;"><?php echo $row['address']; ?></font>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col">
                                      <label>Contact Number :</label>
                                    </div>
                                    <div class="col">
                                      <font style="font-weight: bold;"><?php echo $row['contact']; ?></font>
                                    </div>
                                  </div>
                                </div>
                                <div class="modal-footer modal-lg">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                                    <!-- <button class="btn btn-primary" name="update">Update</button> -->
                                </div>
                              </div>
                        </div>
                        <?php $count++; } ?>
                      </tbody>
                    </table>
                    <a href="#archive_all" data-toggle="modal" class="btn btn-sm btn-danger shadow-sm" title="Archive All"><i class="fas fa-archive"></i> Archive All</a>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Message Box JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

<!-- alert messages -->
<?php
    if (isset($_SESSION['add_teacher_success'])) {?>
        <script>
            swal.fire({
             icon: 'success',
             type : 'success',
             title : 'Teacher Account was Created Successfully!',
             text : '<?php echo $_SESSION['add_teacher_success']?>'
         })
        </script>
    <?php unset($_SESSION['add_teacher_success']);
    }
?>

<?php
    if (isset($_SESSION['set_active'])) {?>
        <script>
            swal.fire({
             icon: 'success',
             type : 'success',
             title : 'Teacher Account is Now Set to Active!',
             text : '<?php echo $_SESSION['set_active']?>'
         })
        </script>
    <?php unset($_SESSION['set_active']);
    }
?>

<?php
    if (isset($_SESSION['set_not_active'])) {?>
        <script>
            swal.fire({
             icon: 'success',
             type : 'success',
             title : 'Teacher Account is Now Set to Not Active',
             text : '<?php echo $_SESSION['set_not_active']?>'
         })
        </script>
    <?php unset($_SESSION['set_not_active']);
    }
?>

<?php
    if (isset($_SESSION['wrong_password'])) {?>
        <script>
            swal.fire({
             icon: 'warning',
             type : 'warning',
             title : 'Invalid Password',
             text : '<?php echo $_SESSION['wrong_password']?>'
         })
        </script>
    <?php unset($_SESSION['wrong_password']);
    }
?>

<?php
    if (isset($_SESSION['edit_teacher_success'])) {?>
        <script>
            swal.fire({
             icon: 'success',
             type : 'success',
             title : 'Teacher Account was Updated Successfully',
             text : '<?php echo $_SESSION['edit_teacher_success']?>'
         })
        </script>
    <?php unset($_SESSION['edit_teacher_success']);
    }
?>

<?php
    if (isset($_SESSION['archived'])) {?>
        <script>
            swal.fire({
             icon: 'success',
             type : 'success',
             title : 'Teacher Account was Archived Successfully',
             text : '<?php echo $_SESSION['archived']?>'
         })
        </script>
    <?php unset($_SESSION['archived']);
    }
?>

<?php
    if (isset($_SESSION['archived_all'])) {?>
        <script>
            swal.fire({
             icon: 'success',
             type : 'success',
             title : 'All Teacher Accounts was Archived Successfully',
             text : '<?php echo $_SESSION['archived_all']?>'
         })
        </script>
    <?php unset($_SESSION['archived_all']);
    }
?>


<script type="text/javascript">
    $('.ban-btn').on('click',function(e){
    e.preventDefault();
    const href = $(this).attr('href') 
    Swal.fire({
        title: 'Are you sure to set this account to not active?',
        text: "You will be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, set it!'
        }).then((result) => {
            if (result.value) {
                document.location.href = href;
                
            }
        })
 })

$('.active-btn').on('click',function(e){
    e.preventDefault();
    const href = $(this).attr('href') 
    Swal.fire({
        title: 'Are you sure to set this account in active?',
        text: "You will be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, set it!'
        }).then((result) => {
            if (result.value) {
                document.location.href = href;
            }
        })
 })
</script>

<!-- end tag for the message box JS -->

    <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" style="text-decoration: none;" href="#page-top">
            <i class="fas fa-"></i>
            <i class="fas fa-angle-up"></i>
            <i class="fas fa-"></i>
        </a>


<!-- Logout Modal-->
<?php 
include('includes/logout-modal.php');
?>
<?php
include('includes/scripts.php');
include('includes/footer.php');
?>
