<?php
//Create student account
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

if (isset($_POST['save'])) {
    //generate password
    $number = uniqid();
    $varray = str_split($number);
    $len = sizeof($varray);
    $otp = array_slice($varray, $len - 6, $len);
    $otp = implode(",", $otp);
    $otp = str_replace(',', '', $otp);
    //
    $myfullname_ = $_SESSION['coordinator_fullname_session'];
    $stud_id = $_POST['stud_id'];
    $teacher_uniq_id = $_SESSION['uniq_id']; //my uniq id
    $get_password = $otp;
    $password = md5($otp);
    $fname = ucwords($_POST['fname']);
    $mname = ucwords($_POST['mname']);
    $lname = ucwords($_POST['lname']);
    $stud_fullname = $fname . " " . $mname . " " . $lname . " (" . $stud_id . ")";
    $address = ucwords($_POST['address']);
    $contact = $_POST['contact'];
    $gender = $_POST['gender'];
    $ojt_category = $_POST['ojt_category'];
    $coordinator = $_POST['stud_coordinator'];
    $course = $_POST['course'];
    $email = $_POST['stud_email'];
    $academic_yr_sem = $_POST['acad_yr_sem'];
    $img = "unknown.png";
    $status = "active";
    $program = $_SESSION['coordinator_course']; //BSIT OR BSCS
    $userType = "student";
    $in_off_campus = $_POST['off_in_campus'];
    $hrs_required = $_POST['hrs_required'];
    $civil_stats = $_POST['civil_stats'];
    $bday = $_POST['bday'];
    $uniq_id = uniqid('student');
    $remarks = "pending";

    $check_duplicate_email = "SELECT email FROM tbl_students WHERE email='$email'";
    $res = mysqli_query($conn, $check_duplicate_email);
    $count = mysqli_num_rows($res);

    $check_duplicate_stud_id = "SELECT stud_id FROM tbl_students WHERE stud_id='$stud_id'";
    $res1 = mysqli_query($conn, $check_duplicate_stud_id);
    $count1 = mysqli_num_rows($res1);

    if ($count > 0) {
        //$err_msg = "Email is Already Taken!";

    } else if ($count1 > 0) {
        //$err_msg1 = "Student ID is Already Taken!";
    } else {
        //if student is in campus
        if ($in_off_campus == "In-Campus") {
            $not_archived = "not archive";
            $not_submitted = "not submitted";
            $not_applicable = "not applicable";
            $sql = "INSERT INTO tbl_students(stud_id, stud_fullname, password, fname, mname, lname, bday, civil_status, address, gender, contact, course, email, academic_yr_semester, ojt_category, coordinator, image, status, userType, in_off_campus, hours_required, recommendation_letter, resume, moa, response_letter, performance_sheet, narrative, work_plan, accomplishment_report, endorsement_letter, uniq_id, archived, program, your_teacher_uniq_id, remarks) VALUES

            ('$stud_id', '$stud_fullname', '$password', '$fname', '$mname', '$lname', '$bday', '$civil_stats', '$address', '$gender', '$contact', '$course', '$email', '$academic_yr_sem', '$ojt_category', '$coordinator', '$img', '$status', '$userType', '$in_off_campus', '$hrs_required', '$not_submitted', '$not_submitted', '$not_applicable', '$not_submitted', '$not_submitted', '$not_submitted', '$not_submitted', '$not_submitted', '$not_submitted', '$uniq_id', '$not_archived', '$program', '$teacher_uniq_id', '$remarks')";

            $query_run = mysqli_query($conn, $sql);

            if ($query_run) {
                try {
                    require '../vendor/autoload.php';
                    $mail = new  PHPMailer(true);
                    $mail->SMTPDebug = 1;                      //Enable verbose debug output
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->Username   = 'websiteet18@gmail.com';                     //SMTP username
                    $mail->Password   = 'empowermenttechnology';                               //SMTP password
                    $mail->SMTPSecure = "tls"; //Enable implicit TLS encryption
                    $mail->Port       = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                    //Recipients
                    $mail->setFrom('websiteet18@gmail.com', $myfullname_);
                    $mail->addAddress($email); //Name is optional

                    //Content
                    $mail->isHTML(true); //Set email format to HTML
                    $mail->Subject = "e-OJT aCCeSs: You Have Now Your Account as a OJT Student";
                    $template    = "You have now your account in e-OJT aCCeSs Portal. Your student ID is <b> " . " " . $stud_id . "</b>. Your password is <b>" . $get_password . "</b><br> PLEASE DON'T SHARE YOUR PASSWORD TO ANYONE!.";
                    $mail->Body = $template;
                    $mail->send();
                    //echo 'Message has been sent';
                } catch (Exception $ex) {
                    //echo $ex;
                }
                $active = "active";
                $my_ID = $_SESSION['coordinator_id'];
                $session_log = "You created an account for " . $fname . " " . $mname . " " . $lname . " (" . $stud_id . ")";
                //log session
                $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_log', '$td', '$time', '$my_ID', '$active')";
                $query_log_run = mysqli_query($conn, $sql_log);
                if ($query_log_run) {
                    $get_name_id = $_SESSION['coordinator_fname'] . " " . $_SESSION['coordinator_mname'] . " " . $_SESSION['coordinator_lname'] . " (" . $_SESSION['coordinator_id'] . ")";

                    $userType = "Teacher";
                    $session_audit = $get_name_id . " created an account for his/her student; " . $fname . " " . $mname . " " . $lname . " (" . $stud_id . ")";
                    $sql_audit = "INSERT INTO tbl_audit_trail (activity, date_, time_, by_, status, userType) VALUES ('$session_audit', '$td', '$time', '$get_name_id', '$active', '$userType')";
                    $query_audit_run = mysqli_query($conn, $sql_audit);
                    if ($query_audit_run) {
                        $_SESSION['add_student_success'] = $fname . " " . $mname . " " . $lname;
                        header('location: student_account.php?StudentAccountCreatedSuccessfully');
                    }
                }
            } else {
                echo $conn->error;
            }
        }
        //if student is off campus
        else if ($in_off_campus == "Off-Campus") {
            $not_submitted = "not submitted";
            $not_archived = "not archive";

            $sql = "INSERT INTO tbl_students(stud_id, stud_fullname, password, fname, mname, lname, bday, civil_status, address, gender, contact, course, email, academic_yr_semester, ojt_category, coordinator, image, status, userType, in_off_campus, hours_required, recommendation_letter, resume, moa, response_letter, performance_sheet, narrative, work_plan, accomplishment_report, endorsement_letter, uniq_id, archived, program, your_teacher_uniq_id, remarks) VALUES

            ('$stud_id', '$stud_fullname', '$password', '$fname', '$mname', '$lname', '$bday', '$civil_stats', '$address', '$gender', '$contact', '$course', '$email', '$academic_yr_sem', '$ojt_category', '$coordinator', '$img', '$status', '$userType', '$in_off_campus', '$hrs_required', '$not_submitted', '$not_submitted', '$not_submitted', '$not_submitted', '$not_submitted', '$not_submitted', '$not_submitted', '$not_submitted', '$not_submitted', '$uniq_id', '$not_archived', '$program', '$teacher_uniq_id', '$remarks')";

            $query_run = mysqli_query($conn, $sql);

            if ($query_run) {
                try {
                    require '../vendor/autoload.php';
                    $mail = new  PHPMailer(true);
                    $mail->SMTPDebug = 1;                      //Enable verbose debug output
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->Username   = 'websiteet18@gmail.com';                     //SMTP username
                    $mail->Password   = 'empowermenttechnology';                               //SMTP password
                    $mail->SMTPSecure = "tls"; //Enable implicit TLS encryption
                    $mail->Port       = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                    //Recipients
                    $mail->setFrom('websiteet18@gmail.com', $myfullname_);
                    $mail->addAddress($email); //Name is optional

                    //Content
                    $mail->isHTML(true); //Set email format to HTML
                    $mail->Subject = "e-OJT aCCeSs: You Have Now Your Account as an OJT Student";
                    $template    = "You have now your account in e-OJT aCCeSs Portal. Your student ID is <b> " . $stud_id . "</b>. Your password is <b>" . $get_password . "</b><br> PLEASE DON'T SHARE YOUR PASSWORD TO ANYONE!.";
                    $mail->Body = $template;
                    $mail->send();
                    //echo 'Message has been sent';
                } catch (Exception $ex) {
                    //echo $ex;
                }
                // move_uploaded_file($_FILES['img']['tmp_name'], "../admin/uploaded_images/".$_FILES['img']['name']);
                $active = "active";
                $my_ID = $_SESSION['coordinator_id'];
                $session_log = "You created an account for " . $fname . " " . $mname . " " . $lname . " (" . $stud_id . ")";
                //log session
                $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_log', '$td', '$time', '$my_ID', '$active')";
                $query_log_run = mysqli_query($conn, $sql_log);
                if ($query_log_run) {
                    $get_name_id = $_SESSION['coordinator_fname'] . " " . $_SESSION['coordinator_mname'] . " " . $_SESSION['coordinator_lname'] . " (" . $_SESSION['coordinator_id'] . ")";

                    $userType = "Teacher";
                    $session_audit = $get_name_id . " created an account for his/her student; " . $fname . " " . $mname . " " . $lname . " (" . $stud_id . ")";
                    $sql_audit = "INSERT INTO tbl_audit_trail (activity, date_, time_, by_, status, userType) VALUES ('$session_audit', '$td', '$time', '$get_name_id', '$active', '$userType')";
                    $query_audit_run = mysqli_query($conn, $sql_audit);
                    if ($query_audit_run) {
                        $_SESSION['add_student_success'] = $fname . " " . $mname . " " . $lname;
                        header('location: student_account.php?StudentAccountCreatedSuccessfully');
                    }
                }
            } else {
                echo $conn->error;
            }
        }
    }
}

//update student info
else if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $current_stud_id = $_POST['current_stud_id'];
    $stud_uniq_id = $_POST['stud_uniq_id'];
    $stud_id = $_POST['stud_id1'];
    $fname = ucwords($_POST['fname']);
    $mname = ucwords($_POST['mname']);
    $lname = ucwords($_POST['lname']);
    $course = $_POST['select_section'];
    $current_course = $_POST['current_course'];
    $in_off_campus = $_POST['off_in_campus'];
    $ojt_category = $_POST['ojt_category'];
    $current_ojt_category = $_POST['current_ojt_category'];
    $hrs_required = $_POST['hrs_required'];

    if ($stud_id == "") {
        $stud_fullname = $fname . " " . $mname . " " . $lname . " (" . $current_stud_id . ")";
        if ($in_off_campus == "In-Campus") {
            $isMoaRequired = "not applicable";
            $sql2 = "UPDATE tbl_students SET stud_fullname='$stud_fullname', fname='$fname', mname='$mname', lname='$lname', course='$current_course', ojt_category='$current_ojt_category', hours_required='$hrs_required', in_off_campus='$in_off_campus', moa='$isMoaRequired' WHERE id='$id'";
            $query2 = $conn->query($sql2);
            if ($query2) {
                $sql3 = "UPDATE tbl_students_work SET stud_name_and_id='$stud_fullname', course='$current_course' WHERE stud_uniq_id='$stud_uniq_id' ";
                $query3 = $conn->query($sql3);
                if ($query3) {
                    $sql4 = "UPDATE tbl_announcement_receiver SET receiver_name='$stud_fullname' WHERE uniq_id='$stud_uniq_id'";
                    $query4 = $conn->query($sql4);
                    if ($query4) {
                        $active = "active";
                        $my_ID = $_SESSION['coordinator_id'];
                        $session_log = "You updated the OJT student account details of " . $stud_fullname;
                        //log session
                        $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_log', '$td', '$time', '$my_ID', '$active')";
                        $query_log_run = mysqli_query($conn, $sql_log);
                        if ($query_log_run) {
                            $get_name_id = $_SESSION['coordinator_fname'] . " " . $_SESSION['coordinator_mname'] . " " . $_SESSION['coordinator_lname'] . " (" . $_SESSION['coordinator_id'] . ")";

                            $userType = "Teacher";
                            $session_audit = $get_name_id . " updated the OJT student account details of " . $stud_fullname;
                            $sql_audit = "INSERT INTO tbl_audit_trail (activity, date_, time_, by_, status, userType) VALUES ('$session_audit', '$td', '$time', '$get_name_id', '$active', '$userType')";
                            $query_audit_run = mysqli_query($conn, $sql_audit);
                            if ($query_audit_run) {
                                $_SESSION['edit_student_success'] = $fname . " " . $mname . " " . $lname;
                                header('location: student_account.php?student_updated_info');
                            }
                        }
                    } else {
                        echo $conn->error;
                    }
                }
            }
        } else if ($in_off_campus == "Off-Campus") {
            $isMoaRequired = "not submitted";
            $sql2 = "UPDATE tbl_students SET stud_fullname='$stud_fullname', fname='$fname', mname='$mname', lname='$lname', course='$current_course', ojt_category='$current_ojt_category',  hours_required='$hrs_required', in_off_campus='$in_off_campus', moa='$isMoaRequired' WHERE id='$id'";
            $query2 = $conn->query($sql2);
            if ($query2) {
                $sql3 = "UPDATE tbl_students_work SET stud_name_and_id='$stud_fullname', course='$current_course' WHERE stud_uniq_id='$stud_uniq_id' ";
                $query3 = $conn->query($sql3);
                if ($query3) {
                    $sql4 = "UPDATE tbl_announcement_receiver SET receiver_name='$stud_fullname' WHERE uniq_id='$stud_uniq_id'";
                    $query4 = $conn->query($sql4);
                    if ($query4) {
                        $active = "active";
                        $my_ID = $_SESSION['coordinator_id'];
                        $session_log = "You updated the OJT student account details of " . $fname . " " . $mname . " " . $lname . " (" . $current_stud_id . ")";
                        //log session
                        $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_log', '$td', '$time', '$my_ID', '$active')";
                        $query_log_run = mysqli_query($conn, $sql_log);
                        if ($query_log_run) {
                            $get_name_id = $_SESSION['coordinator_fname'] . " " . $_SESSION['coordinator_mname'] . " " . $_SESSION['coordinator_lname'] . " (" . $_SESSION['coordinator_id'] . ")";

                            $userType = "Teacher";
                            $session_audit = $get_name_id . " updated the OJT student account details of " . $fname . " " . $mname . " " . $lname . " (" . $current_stud_id . ")";
                            $sql_audit = "INSERT INTO tbl_audit_trail (activity, date_, time_, by_, status, userType) VALUES ('$session_audit', '$td', '$time', '$get_name_id', '$active', '$userType')";
                            $query_audit_run = mysqli_query($conn, $sql_audit);
                            if ($query_audit_run) {
                                $_SESSION['edit_student_success'] = $fname . " " . $mname . " " . $lname;
                                header('location: student_account.php?student_updated_info');
                            }
                        }
                    } else {
                        echo $conn->error;
                    }
                }
            }
        }
    } else if ($stud_id != "") {
        $stud_fullname = $fname . " " . $mname . " " . $lname . " (" . $stud_id . ")";
        if ($in_off_campus == "In-Campus") {
            $isMoaRequired = "not applicable";
            $sql2 = "UPDATE tbl_students SET stud_id='$stud_id', stud_fullname='$stud_fullname', fname='$fname', mname='$mname', lname='$lname', ojt_category='$current_ojt_category',  course='$current_course', in_off_campus='$in_off_campus', hours_required='$hrs_required', moa='$isMoaRequired' WHERE id='$id'";
            $query2 = $conn->query($sql2);
            if ($query2) {
                $sql3 = "UPDATE tbl_students_work SET stud_name_and_id='$stud_fullname', course='$current_course' WHERE stud_uniq_id='$stud_uniq_id' ";
                $query3 = $conn->query($sql3);
                if ($query3) {
                    $sql4 = "UPDATE tbl_announcement_receiver SET receiver_name='$stud_fullname' WHERE uniq_id='$stud_uniq_id'";
                    $query4 = $conn->query($sql4);
                    if ($query4) {
                        $active = "active";
                        $my_ID = $_SESSION['coordinator_id'];
                        $session_log = "You updated the OJT student account details of " . $fname . " " . $mname . " " . $lname . " (" . $stud_id . ")";
                        //log session
                        $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_log', '$td', '$time', '$my_ID', '$active')";
                        $query_log_run = mysqli_query($conn, $sql_log);
                        if ($query_log_run) {
                            $get_name_id = $_SESSION['coordinator_fname'] . " " . $_SESSION['coordinator_mname'] . " " . $_SESSION['coordinator_lname'] . " (" . $_SESSION['coordinator_id'] . ")";

                            $userType = "Teacher";
                            $session_audit = $get_name_id . " updated the OJT student account details of " . $fname . " " . $mname . " " . $lname . " (" . $stud_id . ")";
                            $sql_audit = "INSERT INTO tbl_audit_trail (activity, date_, time_, by_, status, userType) VALUES ('$session_audit', '$td', '$time', '$get_name_id', '$active', '$userType')";
                            $query_audit_run = mysqli_query($conn, $sql_audit);
                            if ($query_audit_run) {
                                $_SESSION['edit_student_success'] = $fname . " " . $mname . " " . $lname;
                                header('location: student_account.php?student_updated_info');
                            }
                        }
                    } else {
                        echo $conn->error;
                    }
                }
            }
        } else if ($in_off_campus == "Off-Campus") {
            $isMoaRequired = "not submitted";
            $sql2 = "UPDATE tbl_students SET stud_id='$stud_id', stud_fullname='$stud_fullname', fname='$fname', mname='$mname', course='$current_course', lname='$lname', in_off_campus='$in_off_campus', hours_required='$hrs_required', ojt_category='$current_ojt_category',  moa='$isMoaRequired' WHERE id='$id'";
            $query2 = $conn->query($sql2);
            if ($query2) {
                $sql3 = "UPDATE tbl_students_work SET stud_name_and_id='$stud_fullname', course='$current_course' WHERE stud_uniq_id='$stud_uniq_id' ";
                $query3 = $conn->query($sql3);
                if ($query3) {
                    $sql4 = "UPDATE tbl_announcement_receiver SET receiver_name='$stud_fullname' WHERE uniq_id='$stud_uniq_id'";
                    $query4 = $conn->query($sql4);
                    if ($query4) {
                        $active = "active";
                        $my_ID = $_SESSION['coordinator_id'];
                        $session_log = "You updated the OJT student account details of " . $fname . " " . $mname . " " . $lname . " (" . $stud_id . ")";
                        //log session
                        $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_log', '$td', '$time', '$my_ID', '$active')";
                        $query_log_run = mysqli_query($conn, $sql_log);
                        if ($query_log_run) {
                            $get_name_id = $_SESSION['coordinator_fname'] . " " . $_SESSION['coordinator_mname'] . " " . $_SESSION['coordinator_lname'] . " (" . $_SESSION['coordinator_id'] . ")";

                            $userType = "Teacher";
                            $session_audit = $get_name_id . " updated the OJT student account details of " . $fname . " " . $mname . " " . $lname . " (" . $stud_id . ")";
                            $sql_audit = "INSERT INTO tbl_audit_trail (activity, date_, time_, by_, status, userType) VALUES ('$session_audit', '$td', '$time', '$get_name_id', '$active', '$userType')";
                            $query_audit_run = mysqli_query($conn, $sql_audit);
                            if ($query_audit_run) {
                                $_SESSION['edit_student_success'] = $fname . " " . $mname . " " . $lname;
                                header('location: student_account.php?student_updated_info');
                            }
                        }
                    } else {
                        echo $conn->error;
                    }
                }
            }
        }
    } else {
        echo $conn->error;
    }
}
?>

<style type="text/css">
    .zoom {
        padding: 0px;
        transition: transform .2s;
        /* Animation */
        margin: 0 auto;
    }

    .zoom:hover {
        transform: scale(3.5);
        /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
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

    #tra {
        color: #333333;
    }

    #tra:hover {
        color: black;
        background: #f2f2f2;
    }
</style>

<?php
include('includes/session.php');
include('includes/header.php'); ?>
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
    <li class="nav-item ">
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
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">

            <i class="fas fa-fw fa-users"></i>
            <span>My Students</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Manage</h6>
                <a class="collapse-item" href="students_list.php">Master List</a>
                <a class="collapse-item" href="students_category.php">Category</a>
            </div>
        </div>
    </li>

    <!-- <li class="nav-item">
                <a class="nav-link" href="my_subjects.php">
                    <i class="fas fa-book"></i>
                    <span>Subjects</span></a>
            </li> -->

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAnnouncements" aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-calendar"></i>
            <span>My Announcement</span></a>
        </a>
        <div id="collapseAnnouncements" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Category</i></h6>
                <a class="collapse-item" href="announcement_for_today.php">Today</a>
                <a class="collapse-item" href="announcements_history.php">All</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo" href="#">
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
                <a class="collapse-item" href="my_stud_requirements_pending.php">Not Yet Submitted
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

    <!--  <li class="nav-item">
                <a class="nav-link collapsed" data-toggle="collapse" data-target="#collapseFour"
                    aria-expanded="true" aria-controls="collapseTwo" href="#">
                    <i class="fas fa-file-alt"></i>
                    <span>Confidential Docs</span>
                </a>
                <div id="collapseFour" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Manage</h6>
                        <a class="collapse-item" href="#">Accepted Requests</a>
                        <a class="collapse-item" href="#">Pending Request</a>
                    </div>
                </div>
            </li> -->

    <li class="nav-item">
        <a class="nav-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseTwo" href="#">
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


    <!-- <li class="nav-item">
                <a class="nav-link" href="tasks.php">
                    <i class="fas fa-thumbtack"></i>
                    <span>Task Titles</span></a>
            </li> -->

    <!-- Nav Item - Dashboard -->
    <!--     <li class="nav-item">
                <a class="nav-link" href="organization.php">
                    <i class="fas fa-sitemap"></i>
                    <span>Reports</span></a>
            </li> -->
    <!-- Nav Item - Collapse Menu -->
    <li class="nav-item active">
        <a class="nav-link" href="student_account.php">
            <i class="fas fa-fw fa-users"></i>
            <span>Student Account Management</span></a>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <!-- <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-archive"></i>
                    <span>Archives</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Manage</h6>
                        <a class="collapse-item" href="#">DATA</a>
                        <a class="collapse-item" href="#">DATA</a>
                    </div>
                </div>  
            </li> -->

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    <!-- Sidebar Message -->


</ul>

<?php include('includes/topbar.php'); ?>
<!-- End of Sidebar -->


<script>
    function checkCorrectPassword() {
        $("#loaderIcon").show();
        jQuery.ajax({
            url: "includes/check_availability.php",
            data: 'my_password=' + $("#my_password").val(),
            type: "POST",
            success: function(data) {
                $("#validate_password_correct").html(data);
                $("#loaderIcon").hide();
            },
            error: function() {}
        });
    }
</script>


<script>
    function checkAvailabilityStudId() {
        $("#loaderIcon").show();
        jQuery.ajax({
            url: "includes/check_availability.php",
            data: 'stud_id=' + $("#stud_id").val(),
            type: "POST",
            success: function(data) {
                $("#stud_id-availability").html(data);
                $("#loaderIcon").hide();
            },
            error: function() {}
        });
    }
</script>

<script>
    function checkAvailabilityStudId1() {
        $("#loaderIcon").show();
        jQuery.ajax({
            url: "includes/check_availability.php",
            data: 'stud_id1=' + $("#stud_id1").val(),
            type: "POST",
            success: function(data) {
                $("#stud_id-availability1").html(data);
                $("#loaderIcon").hide();
            },
            error: function() {}
        });
    }
</script>

<script>
    function checkAvailabilityStudEmail() {
        $("#loaderIcon").show();
        jQuery.ajax({
            url: "includes/check_availability.php",
            data: 'stud_email=' + $("#stud_email").val(),
            type: "POST",
            success: function(data) {
                $("#stud_email-availability").html(data);
                $("#loaderIcon").hide();
            },
            error: function() {}
        });
    }
</script>

<style>
    #ojt_category1 {
        border: 1px solid gray;
        color: #333333;
    }

    #ojt_category1:focus {
        border: 1px solid #006bb3;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
        color: black;
    }

    #stud_id1 {
        border: 1px solid gray;
        color: #333333;
    }

    #stud_id1:focus {
        border: 1px solid #006bb3;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
        color: black;
    }

    #stud_id {
        border: 1px solid gray;
        color: #333333;
    }

    #stud_id:focus {
        border: 1px solid #006bb3;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
        color: black;
    }

    #fname {
        border: 1px solid gray;
        color: #333333;
    }

    #fname:focus {
        border: 1px solid #006bb3;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
        color: black;
    }

    #mname {
        border: 1px solid gray;
        color: #333333;
    }

    #mname:focus {
        border: 1px solid #006bb3;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
        color: black;
    }

    #lname {
        border: 1px solid gray;
        color: #333333;
    }

    #lname:focus {
        border: 1px solid #006bb3;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
        color: black;
    }

    #my_password {
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

    #address {
        border: 1px solid gray;
        color: #333333;
    }

    #address:focus {
        border: 1px solid #006bb3;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
        color: black;
    }

    #stud_email {
        border: 1px solid gray;
        color: #333333;
    }

    #stud_email:focus {
        border: 1px solid #006bb3;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
        color: black;
    }

    #contact {
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

    #gender {
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

    #bday {
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

    #civil_stats {
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

    #course {
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

    #course_ {
        border: 1px solid gray;
        color: #333333;
    }

    #course_:focus {
        border: 1px solid #006bb3;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
        color: black;
    }

    #acad_yr_sem {
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

    #off_in_campus {
        border: 1px solid gray;
        color: #333333;
    }

    #off_in_campus:focus {
        border: 1px solid #006bb3;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
        color: black;
    }

    #ojt_category {
        border: 1px solid gray;
        color: #333333;
    }

    #ojt_category:focus {
        border: 1px solid #006bb3;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
        color: black;
    }

    #hrs_required {
        border: 1px solid gray;
        color: black;
    }

    #hrs_required:focus {
        border: 1px solid #006bb3;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
        color: black;
    }

    #stud_coordinator {
        border: 1px solid gray;
        color: #333333;
    }

    #stud_coordinator:focus {
        border: 1px solid #006bb3;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
        color: black;
    }

    #acad_yr {
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

    #select_section {
        border: 1px solid #006bb3;
        color: #333333;
    }

    #select_section:focus {
        border: 1px solid black;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
        color: black;
    }

    .errorWrap {
        color: #333333;
        padding: 10px;
        margin: 0 0 20px 0;
        background: #fff;
        border-left: 4px solid #dd3d36;
        -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
    }

    .succWrap {
        color: #333333;
        padding: 10px;
        margin: 0 0 20px 0;
        background: #fff;
        border-left: 4px solid blue;
        -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
    }
</style>

<script>
    function alpha(e) {
        var k;
        document.all ? k = e.keyCode : k = e.which;
        // UPDATED - is CHARCODE
        //allow - sign, but cannot allow any other special chars
        return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 || (k >= 48 && k <= 57) || k == 45);
    }
</script>

<!-- Add student modal -->
<div class="modal fade bd-example-modal-lg" id="addStudent" tabindex="-1" role="dialog" aria-labelledby="addStudent" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document" style="color:  #333333;">
        <div class="modal-content modal-lg">
            <div class="modal-header modal-lg">
                <h5 class="modal-title" id="exampleModalLabel" style="color: #0d6efd;"><i class="fas fa-user-graduate"></i> Create Account for Student</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body modal-lg">
                <!--             <div class="container-fluid">
                <div class="row">
                    <div class="col-md"> -->
                <form class="" method="POST" enctype="multipart/form-data">
                    <div class='errorWrap'><strong>This fields with red asterisk (<h style="color: red;">*</h>) are required and others are optional.</strong></div>
                    <div class="form-group">
                        <label for="">Student ID: <span style="color: red;">*</span></label><br>
                        <input type="text" name="stud_id" onkeypress="return alpha(event)" class="form-control" id="stud_id" aria-describedby="" onBlur="checkAvailabilityStudId()" placeholder="ex. 0118-2897" required autofocus="">
                        <!-- stud id check avilability -->
                        <div style="padding-top: 5px;">
                            <span id="stud_id-availability" style="font-size:12px;"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">First Name: <span style="color: red;">*</span></label><br>
                        <input type="text" onkeypress="return alpha(event)" style="text-transform:capitalize" name="fname" class="form-control" id="fname" aria-describedby="" placeholder="ex. Juan" required="">
                    </div>
                    <div class="form-group">
                        <label for="">Middle Name: <span style="color: red;">*</span></label><br>
                        <input type="text" style="text-transform:capitalize" name="mname" class="form-control" id="mname" onkeypress="return alpha(event)" aria-describedby="" placeholder="ex. Santos" required="">
                    </div>
                    <div class="form-group">
                        <label for="">Last Name: <span style="color: red;">*</span></label><br>
                        <input type="text" onkeypress="return alpha(event)" style="text-transform:capitalize" name="lname" class="form-control" id="lname" aria-describedby="" placeholder="ex. Dela Cruz" required="">
                    </div>
                    <div class="form-group" style="height: 120%;">
                        <label for="">Course, Year, & Section: <span style="color: red;">*</span></label><br>
                        <select class="form-control" name="course" id="course">
                            <?php
                            include 'includes/db_connect_pdo.php';
                            //using pdo format
                            $course_acronym = $_SESSION['coordinator_course'];
                            $sql = "SELECT course_title from tbl_courses where course_code=:course_acronym";
                            $query = $dbh->prepare($sql);
                            $query->bindParam(':course_acronym', $course_acronym, PDO::PARAM_STR);
                            $query->execute();
                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                            $cnt = 1;
                            if ($query->rowCount() > 0) {
                                foreach ($results as $result) { ?>
                                    <option value="<?php echo $result->course_title; ?>">
                                        <?php echo $result->course_title; ?>
                                    </option>
                            <?php }
                            } ?>
                        </select>
                    </div>
                    <!-- </div>
                    <div class="col-md"> -->
                    <!--  <div style="margin-top: 66px;">
                        </div> -->
                    <div class="form-group">
                        <label for="">Academic Year and Semester: <span style="color: red;">*</span></label><br>
                        <select class="form-control" name="acad_yr_sem" id="acad_yr_sem">
                            <?php
                            include 'includes/db_connect_pdo.php';
                            //using pdo format
                            $active = "active";
                            $sql = "SELECT * from tbl_academic_year_sem WHERE status=:active";
                            $query = $dbh->prepare($sql);
                            $query->bindParam(':active', $active, PDO::PARAM_STR);
                            $query->execute();
                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                            $cnt = 1;
                            if ($query->rowCount() > 0) {
                                foreach ($results as $result) { ?>
                                    <option value="<?php echo $result->academic_yr . " - " . $result->semester; ?>">
                                        <?php echo $result->academic_yr . " - " . $result->semester; ?>
                                    </option>
                            <?php }
                            } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">In-Campus or Off-Campus?: <span style="color: red;">*</span></label><br>
                        <select class="form-control" name="off_in_campus" id="off_in_campus">
                            <option value="In-Campus">In-Campus</option>
                            <option value="Off-Campus">Off-Campus</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Hours Required: <span style="color: red;">*</span></label><br>
                        <select name="hrs_required" class="form-control" id="hrs_required">
                            <option value="600"> 600 hours</option>
                            <option value="400"> 400 hours</option>
                            <option value="300"> 300 hours</option>
                            <option value="500"> 500 hours</option>
                            <option value="100"> 100 hours</option>
                            <option value="200"> 200 hours</option>
                        </select>
                        <!-- <input type="number" name="hrs_required" class="form-control" id="hrs_required" aria-describedby="" placeholder="ex. 400" required=""> -->
                        <!--     <span style="color: green;"> The ojt teacher will input his ojt required hours </span> -->
                    </div>

                    <div class="form-group">
                        <label for="">Category: <span style="color: red;">*</span></label><br>
                        <select class="form-control" name="ojt_category" id="ojt_category">
                            <?php
                            include 'includes/db_connect_pdo.php';
                            //using pdo format
                            $sql = "SELECT * from tbl_ojt_categories";
                            $query = $dbh->prepare($sql);
                            $query->execute();
                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                            $cnt = 1;
                            if ($query->rowCount() > 0) {
                                foreach ($results as $result) { ?>
                                    <option value="<?php echo $result->categories; ?>">
                                        <?php echo $result->categories; ?>
                                    </option>
                            <?php }
                            } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="form-group">
                            <label for="">Email: <span style="color: red;">*</span></label><br>
                            <input type="email" onkeypress="return event.charCode != 32" name="stud_email" class="form-control" id="stud_email" aria-describedby="" onblur="checkAvailabilityStudEmail()" placeholder="ex. juandelacruz09@gmail.com" required>
                            <div style="padding-top: 8px;">
                                <span id="stud_email-availability" style="font-size:12px;"></span>
                            </div>
                        </div>
                    </div>
                    <!-- </div>
                    <div class="col-md"> -->
                    <div class='succWrap'><strong>Additional Information</strong></div>
                    <div class="form-group">
                        <label for="">Address: </label><br>
                        <textarea style="text-transform:capitalize" onkeypress="return alpha(event)" class="form-control" placeholder="ex. Brgy. Bubukal, Santa Cruz, Laguna" id="address" name="address" rows="5"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Contact Number: </label><br>
                        <input type="number" name="contact" class="form-control" id="contact" aria-describedby="" placeholder="ex. 0998761567">
                    </div>
                    <div class="form-group">
                        <label for="">Gender: </label><br>
                        <select class="form-control" name="gender" id="gender">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Birthday: </label><br>
                        <input type="date" name="bday" id="bday" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Civil Status: </label><br>
                        <select class="form-control" name="civil_stats" id="civil_stats">
                            <option value="Single">Single</option>
                            <option value='Married'>Married</option>
                            <option value='Seperated'>Seperated</option>
                            <option value='Widowed'>Widowed</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <!-- <label for="">OJT Teacher  <span style="color: red;">*</span></label><br> -->
                        <input style="color: #333333;" type="text" hidden class="form-control" id="stud_coordinator" name="stud_coordinator" value="<?php echo $_SESSION['coordinator_fullname_session']; ?>" readonly>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                <?php

                ?>
                <button type="submit" id="add" class="btn btn-primary" name="save" onclick="return valid();">Create Account <i class="fas fa-save"></i></button>
            </div>
            <!-- form end -->
            </form>

        </div>
    </div>
</div>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><span><b>Student Account Management</b></h1>
        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
    </div>

    <div class="card shadow mb-4">
        <!-- <div class="card-header py-3">
            <a href="student_account.php" class="btn btn-sm btn-success shadow-sm" title="Archive All"><i class="fas fa-user-check"></i> Active</a>
            <a href="#" class="btn btn-sm btn-warning shadow-sm" title="Archive All"><i class="fas fa-archive"></i> Archives</a>
        </div> -->
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-danger">
                INSTRUCTIONS
            </h6>
        </div>
        <div class="card-body" style="color: #333333; ">
            The use of this application is intended only to create an account for OJT students (also to modified their OJT related information).<br><br>
            All fields marked with red asterisk ( <span style="color: blue">*</span> ) are optional fields. These fields must okay to be leaved blank.<br><br>
            All fields marked with red asterisk ( <span style="color: red">*</span> ) are required fields. These fields must not be leaved blank.
        </div>
        <br>
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <h6 class="m-0 font-weight-bold text-primary">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addStudent">
                        Create Account for My Student <i class="fas fa-plus-square"></i>
                    </button>
                </h6>
            </h6>
        </div>
        <div class="card-header py-3" style="background: #595959;">
            <h6 class="m-0 font-weight-bold" style="color: ghostwhite;">
                <i class="fas fa-user-graduate"></i> Students' Accounts
            </h6>
        </div>
        <!-- table -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="dataTable" width="100%" cellpadding="10" id="example" style="color: #333333;">
                    <thead>
                        <tr>
                            <center>
                                <th>No.</th>
                                <th>Photo</th>
                                <th>Student ID</th>
                                <th>Student Name</th>
                                <th>Course, Year & Section</th>
                                <th>Action</th>
                            </center>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        //concatinating the name coordinator  
                        $id1 = $_SESSION['coordinator_id'];
                        $sql1 = "SELECT Concat(fname, ' ', mname,' ', lname, ' ', '(',coordinator_id,')') AS fullname FROM tbl_coordinators where coordinator_id = '$id1'";
                        $query1 = $conn->query($sql1);
                        while ($row1 = $query1->fetch_assoc()) {
                            $_SESSION['coordinator_fullname'] = $row1['fullname'];
                        } ?>

                        <?php
                        $count = 1;
                        $_coordinator = $_SESSION['coordinator_fullname'];
                        require_once('includes/db_connect.php');
                        $isArchived = "not archive";
                        $sql = "SELECT * FROM tbl_students where archived='$isArchived' and coordinator='$_coordinator' ORDER BY id ASC";
                        $query = $conn->query($sql);
                        while ($row = $query->fetch_assoc()) {
                            $id = $row['stud_id'];
                            $status = $row['status'];
                        ?>
                            <tr id="tra">
                                <td><?php echo $count; ?> </td>
                                <td><img src="../admin/uploaded_images/<?php echo $row['image']; ?>" alt="" style="margin-right: 50px; border-radius: 50%;" id="image1" width="50px;" height="50px;"> </td>
                                <td><?php echo $id; ?></td>
                                <td><?php echo $row['lname'] . ", " . $row['fname'] . " " . $row['mname']; ?></td>
                                <td width="20%"><?php echo $row['course']; ?></td>
                                <td>
                                    <a href="#view<?php echo $id; ?>" title="View Student's Info" data-toggle="modal" data-id="" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                    <a href="#edit<?php echo $id; ?>" title="Edit Student's Info" data-toggle="modal" data-id="" class="btn btn-dark"><i class="fas fa-edit"></i></a>
                                    <a href="#archive<?php echo $id; ?>" data-toggle="modal" title="Archive"><button class="btn btn-danger"><i class="fas fa-archive"></i></button></a>
                                </td>
                            </tr>

                            <!-- Edit student details -->
                            <div class="modal fade bd-example-modal-md" id="edit<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                                <div class="modal-dialog modal-lg" role="document" style="color: #333333;">
                                    <div class="modal-content modal-lg">
                                        <div class="modal-header modal-lg">
                                            <h5 class="modal-title" style="color: #0d6efd;"><i class="fas fa-user-edit"></i> Edit OJT Student Details</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-header modal-lg">
                                            <h style="color: #333333">
                                                <i class="fas fa-id-card"></i> <?php echo $row['stud_id'] ?> <br>
                                                <i class="fas fa-user-graduate"></i> <?php echo $row['fname'] . " " . $row['mname'] . " " . $row['lname'] ?> <br>
                                                <i class="fas fa-graduation-cap"></i> <?php echo $row['course'] ?> <br>
                                                <i class="fas fa-university"></i> <?php echo $row['in_off_campus'] ?> <br>
                                                <i class="fas fa-user-clock"></i> <?php echo $row['hours_required'] ?> <br>
                                                <i class="fas fa-columns"></i> <?php echo $row['ojt_category'] ?>
                                            </h>
                                        </div>
                                        <div class="modal-body modal-lg">
                                            <!-- <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md"> -->
                                            <!-- form start -->
                                            <form class="" method="POST" enctype="multipart/form-data">
                                                <div class="">
                                                    <input type="text" name="id" value="<?php echo $row['id']; ?>" hidden>
                                                    <input type="text" name="stud_uniq_id" value="<?php echo $row['uniq_id']; ?>" hidden>
                                                </div>
                                                <!-- <div class="form-group">  -->
                                                <input type="text" name="current_stud_id" value="<?php echo $row['stud_id']; ?>" hidden>
                                                <!-- <label for="">Student ID : <span style="color: blue;">*</span></label> <h style="color: green;"></h><br> -->
                                                <input type="text" style="" name="stud_id1" class="form-control" id="stud_id1" aria-describedby="" onBlur="checkAvailabilityStudId1()" placeholder="ex. 0118-2989" hidden="">
                                                <!-- <i class="text-primary">*If you do not want to change the student's ID Number, leave this textfield with blank</i> -->
                                                <!-- stud id check avilability -->
                                                <!-- <div style="padding-top: 5px;">
                                                    <span id="stud_id-availability1" style="font-size:12px;"></span>
                                                </div>  -->

                                                <!-- </div> -->
                                                <div class="form-group">
                                                    <label for="">First Name : <span style="color: red;">*</span></label><br>
                                                    <input type="text" onkeypress="return alpha(event)" style="text-transform:capitalize;" name="fname" value="<?php echo $row['fname']; ?>" class="form-control" id="fname" aria-describedby="" placeholder="ex. Juan" required="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Middle Name : <span style="color: red;">*</span></label><br>
                                                    <input type="text" onkeypress="return alpha(event)" name="mname" value="<?php echo $row['mname']; ?>" class="form-control" id="mname" aria-describedby="" placeholder="ex. Santos" required="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Last Name : <span style="color: red;">*</span></label><br>
                                                    <input type="text" onkeypress="return alpha(event)" style="text-transform: capitalize;" name="lname" value="<?php echo $row['lname']; ?>" class="form-control" id="lname" aria-describedby="" placeholder="Enter Last Name" required="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Course, Year, & Section : <span style="color: blue;">*</span></label><br>
                                                    <input type="text" name="current_course" value="<?php echo $row['course']; ?>" id="course_" style="background: ghostwhite;" class="form-control" hidden>
                                                    <select class="form-control" onchange="copyTextValue()" name="select_section" id="select_section">
                                                        <option value='<?php echo $row['course']; ?>' selected=''>Default Course, Year & Section</option>
                                                        <?php
                                                        include 'includes/db_connect_pdo.php';
                                                        //using pdo format
                                                        $course_acronym = $_SESSION['coordinator_course'];
                                                        $course = $row['course'];
                                                        $sql1 = "SELECT course_title from tbl_courses where course_code=:course_acronym order by id ASC";
                                                        $query1 = $dbh->prepare($sql1);
                                                        $query1->bindParam(':course_acronym', $course_acronym, PDO::PARAM_STR);
                                                        $query1->execute();
                                                        $results1 = $query1->fetchAll(PDO::FETCH_OBJ);
                                                        $cnt1 = 1;
                                                        if ($query1->rowCount() > 0) {
                                                            foreach ($results1 as $result1) { ?>
                                                                <option value="<?php echo $result1->course_title; ?>">
                                                                    <?php echo $result1->course_title; ?>
                                                                </option>
                                                        <?php }
                                                        } ?>
                                                    </select>
                                                    <i class="text-primary">*If you do not want to change the student's section, choose default</i>
                                                </div>
                                                <!-- </div>
                                        <div class="col-md"> -->
                                                <div class="form-group">
                                                    <label for="">In-Campus or Off-Campus? : <span style="color: red;">*</span></label><br>
                                                    <select class="form-control" name="off_in_campus" id="off_in_campus">
                                                        <?php
                                                        if ($row['in_off_campus'] == "In-Campus") {
                                                            echo "<option value='In-Campus'>In-Campus</option>";
                                                            echo "<option value='Off-Campus'>Off-Campus</option>";
                                                        }
                                                        if ($row['in_off_campus'] == "Off-Campus") {
                                                            echo "<option value='Off-Campus'>Off-Campus</option>";
                                                            echo "<option value='In-Campus'>In-Campus</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Hours Required : <span style="color: red;">*</span></label><br>
                                                    <select name="hrs_required" class="form-control" id="hrs_required">
                                                        <?php
                                                        if ($row['hours_required'] == "100") {
                                                            echo "<option value='100'> 100 hours</option>";
                                                            echo "<option value='600'> 600 hours</option>";
                                                            echo "<option value='400'> 400 hours</option>";
                                                            echo "<option value='300'> 300 hours</option>";
                                                            echo "<option value='200'> 200 hours</option>";
                                                            echo "<option value='500'> 500 hours</option>";
                                                        }
                                                        if ($row['hours_required'] == "200") {
                                                            echo "<option value='200'> 200 hours</option>";
                                                            echo "<option value='600'> 600 hours</option>";
                                                            echo "<option value='400'> 400 hours</option>";
                                                            echo "<option value='300'> 300 hours</option>";
                                                            echo "<option value='100'> 100 hours</option>";
                                                            echo "<option value='500'> 500 hours</option>";
                                                        }
                                                        if ($row['hours_required'] == "300") {
                                                            echo "<option value='300'> 300 hours</option>";
                                                            echo "<option value='600'> 600 hours</option>";
                                                            echo "<option value='400'> 400 hours</option>";
                                                            echo "<option value='100'> 100 hours</option>";
                                                            echo "<option value='200'> 200 hours</option>";
                                                            echo "<option value='500'> 500 hours</option>";
                                                        }
                                                        if ($row['hours_required'] == "400") {
                                                            echo "<option value='400'> 400 hours</option>";
                                                            echo "<option value='600'> 600 hours</option>";
                                                            echo "<option value='300'> 300 hours</option>";
                                                            echo "<option value='100'> 100 hours</option>";
                                                            echo "<option value='200'> 200 hours</option>";
                                                            echo "<option value='500'> 500 hours</option>";
                                                        }
                                                        if ($row['hours_required'] == "500") {
                                                            echo "<option value='500'> 500 hours</option>";
                                                            echo "<option value='600'> 600 hours</option>";
                                                            echo "<option value='400'> 400 hours</option>";
                                                            echo "<option value='300'> 300 hours</option>";
                                                            echo "<option value='100'> 100 hours</option>";
                                                            echo "<option value='200'> 200 hours</option>";
                                                        }
                                                        if ($row['hours_required'] == "600") {
                                                            echo "<option value='600'> 600 hours</option>";
                                                            echo "<option value='400'> 400 hours</option>";
                                                            echo "<option value='300'> 300 hours</option>";
                                                            echo "<option value='100'> 100 hours</option>";
                                                            echo "<option value='200'> 200 hours</option>";
                                                            echo "<option value='500'> 500 hours</option>";
                                                        }
                                                        ?>
                                                    </select>

                                                    <!-- <input  type="number" name="hrs_required" class="form-control" value="<?php echo $row['hours_required']; ?>" id="hrs_required" aria-describedby="" placeholder="ex. 400" required=""> -->
                                                    <!--     <span style="color: green;"> The ojt teacher will input his ojt required hours </span> -->
                                                </div>

                                                <div class="form-group">
                                                    <input type="text" name="current_ojt_category" id="current_ojt_category" value="<?php echo $row['ojt_category']; ?>" hidden>
                                                    <label for="">Category : <span style="color: blue;">*</span></label><br>
                                                    <select class="form-control" name="ojt_category" onchange="copyTextValue1()" id="ojt_category1">
                                                        <option value='<?php echo $row['ojt_category']; ?>' selected=''>Default OJT Category</option>
                                                        <?php
                                                        include 'includes/db_connect_pdo.php';
                                                        //using pdo format
                                                        $sql1 = "SELECT * from tbl_ojt_categories";
                                                        $query1 = $dbh->prepare($sql1);
                                                        $query1->execute();
                                                        $results1 = $query1->fetchAll(PDO::FETCH_OBJ);
                                                        $cnt = 1;
                                                        if ($query1->rowCount() > 0) {
                                                            foreach ($results1 as $result1) { ?>
                                                                <option value="<?php echo $result1->categories; ?>">
                                                                    <?php echo $result1->categories; ?>
                                                                </option>
                                                        <?php }
                                                        } ?>
                                                    </select>
                                                    <i class="text-primary">*If you do not want to change the student's OJT category, choose default</i>
                                                </div>
                                                <!-- </div>
                                    </div>
                                </div> -->
                                        </div>
                                        <div class="modal-footer modal-lg">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                                            <button type="submit" name="update" id="edit" class="btn btn-primary">Save Changes <i class="fas fa-save"></i></button>
                                        </div>
                                        </form>
                                        <!-- form end -->
                                    </div>
                                </div>
                            </div>

                            <!-- archive -->
                            <div class="modal fade" id="archive<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                                <div class="modal-dialog">
                                    <div class="modal-content" style="color: #333333;">
                                        <div class="modal-header">
                                            <h6 class="modal-title" id="exampleModalLabel" style="color: #0d6efd;"><i class="fas fa-archive"></i> Are You Sure Do you Want To Archive The Account of <?php echo $row['fname'] . " " . $row['mname'] . " " . $row['lname'] . " (" . $row['stud_id'] . ")"; ?> ?</h6>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="student_account_archive.php" method="POST" enctype="multipart/form-data">
                                                <input type="text" name="stud_id" value="<?php echo $id ?>" hidden>
                                                <input type="text" name="stud_uniq_id" value="<?php echo $row['uniq_id']; ?>" hidden>
                                                <input type="text" name="fullname_id" value="<?php echo $row['fname'] . " " . $row['mname'] . " " . $row['lname'] . " (" . $row['stud_id'] . ")"; ?>" hidden>
                                                <div class="form-group">
                                                    <label>Confirm Your Password</label>
                                                    <input type="password" name="my_password" placeholder="Enter Your Password" id="my_password" class="form-control" required="">
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

                            <!-- View Student Modal -->
                            <div class="modal fade bd-example-modal-lg" id="view<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content modal-lg">
                                        <div class="modal-header modal-lg">
                                            <h5 class="modal-title" style="color: #0d6efd;">
                                                <h><i class="fas fa-user-graduate"></i> View Student Details</h>
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body modal-lg">
                                            <div style="padding: 20px; background: rgba(51, 51, 51, 0.9); color: ghostwhite;">
                                                <center>
                                                    <img src="../admin/uploaded_images/<?php echo $row['image']; ?>" alt="" style="margin-right: 50px;border-radius: 5%;" id="image1" width="200px;" height="200px;">
                                                </center><br>
                                            </div>
                                            <div class="container" style="background: rgba(51, 51, 51, 0.9); color: ghostwhite; padding: 20px;">
                                                <hr style="background-color: ghostwhite;">
                                                <div class="row">
                                                    <div class="col">
                                                        <label>Student ID :</label>
                                                    </div>

                                                    <div class="col">
                                                        <font style="font-weight: bold; "><?php echo $row['stud_id']; ?></font>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <label>Student Name :</label>
                                                    </div>
                                                    <div class="col">
                                                        <font style="font-weight: bold; "><?php echo $row['fname'] . " " . $row['mname'] . " " . $row['lname']; ?></font>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <label>Course, Year & Section :</label>
                                                    </div>
                                                    <div class="col">
                                                        <font style="font-weight: bold; "><?php echo $row['course']; ?></font>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <label>Academic Year and Semester :</label>
                                                    </div>
                                                    <div class="col">
                                                        <font style="font-weight: bold; "><?php echo $row['academic_yr_semester']; ?></font>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <label>OJT Teacher :</label>
                                                    </div>
                                                    <div class="col">
                                                        <font style="font-weight: bold; "><?php echo $row['coordinator']; ?></font>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <label>Category :</label>
                                                    </div>
                                                    <div class="col">
                                                        <font style="font-weight: bold; "><?php echo $row['ojt_category']; ?></font>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <label>Hours Required :</label>
                                                    </div>
                                                    <div class="col">
                                                        <font style="font-weight: bold; "><?php echo $row['hours_required']; ?></font>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <label>In or Off-Campus? :</label>
                                                    </div>
                                                    <div class="col">
                                                        <font style="font-weight: bold; "><?php echo $row['in_off_campus']; ?></font>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <label>Status :</label>
                                                    </div>
                                                    <div class="col">
                                                        <font style="font-weight:; "><?php
                                                                                        if ($status == 'dropped') {
                                                                                            echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-danger'>NOT ACTIVE</span>";
                                                                                        } else if ($status == 'active') {
                                                                                            echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-success'>ACTIVE</span>";
                                                                                        } else if ($status == 'incomplete') {
                                                                                            echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-warning'>INCOMPLETE</span>";
                                                                                        }
                                                                                        ?>
                                                        </font>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>

                                            <div class="container" style="color: #333333;">
                                                <h5>Student Additional Information</h5>
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
                                                        <font style="font-weight: bold;"><?php echo $row['civil_status']; ?></font>
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

                                        </div>
                                        <div class="modal-footer modal-lg">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                                            <!-- <button class="btn btn-primary" name="update">Update</button> -->
                                        </div>
                                        <!-- form end -->
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php $count++;
                        } ?>
                    </tbody>
                </table>
                <a href="#archive_all" data-toggle="modal" class="btn btn-sm btn-danger shadow-sm" title="Archive All"><i class="fas fa-archive"></i> Archive All</a>
            </div>
        </div>
    </div>
</div>
</div>


<!-- archive all-->
<div class="modal fade" id="archive_all" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content" style="color: #333333;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" style="color: #0d6efd;"><i class="fas fa-archive"></i> Are Your Sure Do you Want To Archive All?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="student_account_archive_all.php" method="POST" enctype="multipart/form-data">
                    <input type="text" name="stud_id" value="<?php echo $id ?>" hidden>
                    <input type="text" name="stud_uniq_id" value="<?php echo $row['uniq_id']; ?>" hidden>
                    <input type="text" name="fullname_id" value="<?php echo $row['fname'] . " " . $row['mname'] . " " . $row['lname'] . " (" . $row['lname'] . ")"; ?>" hidden>
                    <div class="form-group">
                        <label>Confirm Your Password</label>
                        <input type="password" name="my_password" placeholder="Enter Your Password" id="my_password" class="form-control" required="">
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


<!-- to display image -->
<!-- <script>
    const file = document.getElementById("image_");
    const previewContainer =  document.getElementById("imgPreview");
    const previewImg = previewContainer.querySelector(".image-preview__image");
    const previewDefaultText = previewContainer.querySelector("image-preview__default-text");

    file.addEventListener("change", function(){
        const file_this = this.files[0];

        if(file_this){
            const reader = new FileReader();

            //previewDefaultText.style.display = "none";
            previewImg.style.display = "block";

            reader.addEventListener("load", function(){
                console.log(this);
                previewImg.setAttribute("src", this.result);
            });                          
            reader.readAsDataURL(file_this);
        }                        
    });
</script> -->

<!-- Message Box JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

<!-- alert messages -->
<?php
if (isset($_SESSION['add_student_success'])) { ?>
    <script>
        swal.fire({
            icon: 'success',
            type: 'success',
            title: 'Student Account was Created Successfully',
            text: '<?php echo $_SESSION['add_student_success'] ?>'
        })
    </script>
<?php unset($_SESSION['add_student_success']);
}
?>
<?php
if (isset($_SESSION['edit_student_success'])) { ?>
    <script>
        swal.fire({
            icon: 'success',
            type: 'success',
            title: 'Student Account was Updated Successfully',
            text: '<?php echo $_SESSION['edit_student_success'] ?>'
        })
    </script>
<?php unset($_SESSION['edit_student_success']);
}
?>

<?php
if (isset($_SESSION['archived'])) { ?>
    <script>
        swal.fire({
            icon: 'success',
            type: 'success',
            title: 'Student Account was Archived Successfully',
            text: '<?php echo $_SESSION['archived'] ?>'
        })
    </script>
<?php unset($_SESSION['archived']);
}
?>

<?php
if (isset($_SESSION['wrong_password'])) { ?>
    <script>
        swal.fire({
            icon: 'warning',
            type: 'warning',
            title: 'Invalid Password',
            text: '<?php echo $_SESSION['wrong_password'] ?>'
        })
    </script>
<?php unset($_SESSION['wrong_password']);
}
?>


<script>
    $('.del-btn').on('click', function(e) {
        e.preventDefault();
        const href = $(this).attr('href')
        Swal.fire({
            title: 'Are you sure to archive the account of this student?',
            text: "You will be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, archive it!'
        }).then((result) => {
            if (result.value) {
                document.location.href = href;

            }
        })
    })
</script>


<script>
    $('.ban-btn').on('click', function(e) {
        e.preventDefault();
        const href = $(this).attr('href')
        Swal.fire({
            title: 'Are you sure to ban this account?',
            text: "You will be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, ban it!'
        }).then((result) => {
            if (result.value) {
                document.location.href = href;

            }
        })
    })

    $('.active-btn').on('click', function(e) {
        e.preventDefault();
        const href = $(this).attr('href')
        Swal.fire({
            title: 'Are you sure to retrieve this account?',
            text: "You will be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, retrieve it!'
        }).then((result) => {
            if (result.value) {
                document.location.href = href;
            }
        })
    })

    const flashdata6 = $('.flash-data6').data('flashdata')
    if (flashdata6) {
        swal.fire({
            icon: 'success',
            type: 'success',
            title: 'Student Account Was Updated',
            text: 'Student Account Was Updated Successfully.'
        })
    }

    const flashdata1 = $('.flash-data1').data('flashdata')
    if (flashdata1) {
        swal.fire({
            icon: 'success',
            type: 'success',
            title: 'Student Account is Now Already Active',
            text: 'Student Account has been set to active!'
        })
    }

    const flashdata2 = $('.flash-data2').data('flashdata')
    if (flashdata2) {
        swal.fire({
            icon: 'success',
            type: 'success',
            title: 'Account is Now Inactive.',
            text: 'Student Account has been set to inactive!'
        })
    }
    const flashdata3 = $('.flash-data3').data('flashdata')
    if (flashdata3) {
        swal.fire({
            icon: 'success',
            type: 'success',
            title: 'Account Created Successfully',
            text: 'Student account created successfully!'
        })
    }

    const flashdata4 = $('.flash-data4').data('flashdata')
    if (flashdata4) {
        swal.fire({
            icon: 'warning',
            type: 'warning',
            title: 'Email is already Taken',
            text: 'Student Email is Already Taken! Please use a new one.'
        })
    }

    const flashdata5 = $('.flash-data5').data('flashdata')
    if (flashdata5) {
        swal.fire({
            icon: 'warning',
            type: 'warning',
            title: 'Student ID is already Taken',
            text: 'Student ID is Already Taken! Please use a new one.'
        })
    }
</script>


<!-- end tag for the message box JS -->
<script>
    function copyTextValue() {
        var e = document.getElementById("select_section");
        var val = e.options[e.selectedIndex].value;
        document.getElementById("course_").value = val;
    }

    function copyTextValue1() {
        var i = document.getElementById("ojt_category1");
        var val1 = i.options[i.selectedIndex].value;
        document.getElementById("current_ojt_category").value = val1;
    }
</script>

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" style="text-decoration: none;" href="#page-top">
    <i class="fas fa-angle"></i>
    <i class="fas fa-angle-up"></i>
    <i class="fas fa-angle"></i>
</a>

<?php
//logout modal 
include('includes/logout-modal.php');
?>
<?php
include('includes/scripts.php');
include('includes/footer.php');
?>