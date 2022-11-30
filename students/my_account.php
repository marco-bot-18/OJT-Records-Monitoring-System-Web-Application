
<style type="text/css">
.image {
    position: relative;
    width: 400px;
}

.image__img {
    display: block;
    width: 100%;
}

.image__overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 75%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6);
    color: #ffffff;
    font-family: 'Quicksand', sans-serif;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: left;
    opacity: 0;
    transition: opacity 0.25s;
}

.image__overlay--blur {
    backdrop-filter: blur(5px);
    border-radius: 4px;
}

.image__overlay--primary {
    background: #009578;
}

.image__overlay > * {
    transform: translateY(10px);
    transition: transform 0.25s;
    border-radius: 4px;
}

.image__overlay:hover {
    opacity: 1;
    border-radius: 4px;
}

.image__overlay:hover > * {
    transform: translateX(0);
    border-radius: 4px;
}

.image__title {
    font-size: 1em;
    font-weight: bold;
}

.image__description {
    font-size: 1.25em;
    margin-top: 0.25em;
}


.image-preview {
    margin-left: 10px;
    height: 400px;
    width: 400px;
    min-height: 100px;
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
    width: 100%;
    height: 100%;
    border: solid 1px black;
}
</style>

<script>
    function checkAvailabilityMyEmail() {
    $("#loaderIcon").show();
        jQuery.ajax({
            url: "includes/check_availability.php",
            data:'my_email='+$("#my_email").val(),
            type: "POST",
            success:function(data){
            $("#my_email-availability").html(data);
            $("#loaderIcon").hide();
        },
        error:function (){}
        });
    }
</script>

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
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAnnouncements"
                    aria-expanded="true" aria-controls="collapseUtilities">
                     <i class="fas fa-fw fa-calendar"></i>
                    <span>Announcements</span></a>
                </a>
                <div id="collapseAnnouncements" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Category</i></h6>
                        <a class="collapse-item" href="announcement_for_today.php">Today
                            <span class="badge bg-danger" style="color: white;">
                                <?php
                                    date_default_timezone_set('Asia/Manila');
                                    $td = date("F d, Y");
                                    $receiver_name = $_SESSION['student_fullname_session']; //receiver name get from includes/session.php
                                    $posted_by1 = "Dean";
                                    $posted_by2 = $_SESSION['student_teacher'];
                                    $posted_by3 = "Program Head";
                                    $pub_stats = "published";
                                    $sendTo = "Students";
                                    require_once('includes/db_connect.php');
                                    $stats = "not archived";
                                    $count = 1;
                                    $sql = "SELECT * FROM tbl_announcement_receiver WHERE (posted_by='$posted_by1' and date_='$td' and status='$stats' and publish_status='$pub_stats' and receiver_name='$receiver_name' and sendTo='$sendTo') 
                                        OR 
                                        (posted_by='$posted_by2' and date_='$td' and status='$stats' and publish_status='$pub_stats' and receiver_name='$receiver_name' and sendTo='$sendTo')
                                        OR 
                                        (posted_by='$posted_by3' and date_='$td'  and status='$stats' and publish_status='$pub_stats' and receiver_name='$receiver_name' and sendTo='$sendTo') ORDER BY id DESC";
                                    $query = $conn->query($sql);
                                    echo "".$query->num_rows;
                                ?>
                            </span>
                        </a>
                        <a class="collapse-item" href="announcement_history.php">All
                            <span class="badge bg-danger" style="color: white;">
                                <?php
                                    $receiver_name = $_SESSION['student_fullname_session']; //receiver name get from includes/session.php
                                    $posted_by1 = "Dean";
                                    $posted_by3 = "Program Head";
                                    $posted_by2 = $_SESSION['student_teacher'];
                                    $pub_stats = "published";
                                    $stats = "not archived";
                                    $sendTo = "Students";
                                    require_once('includes/db_connect.php');
                                    $stats = "not archived";
                                    $count = 1;
                                    $sql = "SELECT * FROM tbl_announcement_receiver WHERE (posted_by='$posted_by1' and status='$stats' and publish_status='$pub_stats' and receiver_name='$receiver_name' and sendTo='$sendTo') 
                                        OR 
                                        (posted_by='$posted_by2'  and status='$stats' and publish_status='$pub_stats' and receiver_name='$receiver_name' and sendTo='$sendTo') 
                                        OR 
                                        (posted_by='$posted_by3'  and status='$stats' and publish_status='$pub_stats' and receiver_name='$receiver_name' and sendTo='$sendTo')";
                                    $query = $conn->query($sql);
                                        echo $query->num_rows;
                                ?>
                            </span>
                        </a>
                    </div>
                </div>
            </li>


            <li class="nav-item">
                <a class="nav-link collapsed" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo" href="#">
                    <i class="fas fa-tasks"></i>
                    <span>My Requirements</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Manage</h6>
                        <a class="collapse-item" href="my_requirements_pending.php">To do's
                            <span class="badge bg-danger" style="color: white;">
                                <?php
                                    $student_teacher = $_SESSION['student_teacher'];
                                    $work_stats = "pending";
                                    $stats = "not archived";
                                    $submitted = "no";
                                    $count = 1;
                                    $myfullname_ = $_SESSION['student_fullname_session'];
                                    $sql = "SELECT * from tbl_students_work where stud_name_and_id='$myfullname_' and name_of_teacher='$student_teacher' and work_status='$work_stats' and status='$stats' and submitted='$submitted'";
                                            $query = $conn->query($sql);
                                    echo $query->num_rows;
                                   
                                ?>    
                            </span>
                        </a>
                        <a class="collapse-item" href="my_requirements_ongoing.php">Submitted
                            <span class="badge bg-danger" style="color: white;">
                                <?php
                                    $student_teacher = $_SESSION['student_teacher'];
                                    $work_stats = "semi-pending";
                                    $work_stats1 = "semi-pending2";
                                    $work_stats2 = "semi-pending3";
                                    $stats = "not archived";
                                    $submitted = "yes";
                                    $count = 1;
                                    $myfullname_ = $_SESSION['student_fullname_session'];
                                    $sql = "SELECT * from tbl_students_work where stud_name_and_id='$myfullname_' and name_of_teacher='$student_teacher' and submitted='$submitted' and status='$stats'";
                                    $query = $conn->query($sql);
                                    echo $query->num_rows;
                                ?>
                            </span>
                        </a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="my_category.php">
                    <i class="fas fa-address-book"></i>
                    <span>My Category</span></a>
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
        <!-- End of Sidebar -->

        <!-- Logout Modal-->
    

<?php
include('includes/logout-modal.php'); 
include('includes/topbar.php');
?>
 
<script type="text/javascript">
    function validateFileType(){
        var fileName = document.getElementById("my_profile_pic").value;
        var idxDot = fileName.lastIndexOf(".") + 1;
        var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
        if (extFile=="jpg" || extFile=="jpeg" || extFile=="png"){
            //TO DO
        }else{
            alert("Only jpg/jpeg and png files are allowed!");
            document.getElementById("my_profile_pic").value = "";
        }   
    }
</script>

<!--Upload New Image-->
<div class="modal fade" id="upload_new_image" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document" style="color: #333333;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Upload New Profile Picture</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="my_account_profile_pic_update.php" method="post" enctype="multipart/form-data">
          <div class="modal-body">
            <center>
                <div class="image-preview" id="imgPreview">
                    <img src="" alt="Image Preview" class="image-preview__image">
                    <span class="image-preview__default-text"></span>
                </div>
                <br>
              </center>
                <div class="form-group">
                    <input type="file" accept="image/png, image/gif, image/jpeg" class="form-control" id="my_profile_pic" onchange="validateFileType()" name="my_profile_pic" required>
                </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
            <button class="btn btn-primary" name="btn_save_pic">Update Profile Picture <i class="fas fa-save"></i></button>
          </div>
        </form>
    </div>
  </div>
</div>

<style>
    #my_profile_pic {
        border: 1px solid gray;
        color: #333333;
        padding: 3px;
    }
    #my_profile_pic:focus { 
        border: 1px solid #006bb3;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
        color: black;
    }
    #acc_id {
        border: 1px solid gray;
        color: #333333;
        background: ghostwhite;
    }
    #acc_id:focus { 
        border: 1px solid #006bb3;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
        color: black;
    }
    #fname {
        border: 1px solid gray;
        color: #333333;
        background: ghostwhite;
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
        background: ghostwhite;
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
        background: ghostwhite;
    }
    #lname:focus { 
        border: 1px solid #006bb3;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
        color: black;
    }

    #my_email {
        border: 1px solid gray;
        color: #333333;
    }
    #my_email:focus { 
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

    #civil_status {
        border: 1px solid gray;
        color: #333333;
    }
    #civil_status:focus { 
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

    #bday {
        border: 1px solid gray;
        color: black;
    }
    #bday:focus { 
        border: 1px solid #006bb3;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
        color: black;
    }

    #course{
        border: 1px solid gray;
        color: #333333;
        background: ghostwhite;
    }
    #course:focus {
        border: 1px solid #006bb3;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
        color: black
    }

    #academic_yr_semester{
        border: 1px solid gray;
        color: #333333;
        background: ghostwhite;
    }
    #academic_yr_semester:focus {
        border: 1px solid #006bb3;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
        color: black;
    }
    
    #ojt_category{
        border: 1px solid gray;
        color: #333333;
        background: ghostwhite;
    }
    #ojt_category:focus {
        border: 1px solid #006bb3;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
        color: black;
    }

    #teacher{
        border: 1px solid gray;
        color: #333333;
        background: ghostwhite;
    }
    #teacher:focus {
        border: 1px solid #006bb3;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
        color: black;
    }

    #in_off_campus{
        border: 1px solid gray;
        color: #333333;
        background: ghostwhite;
    }
    #in_off_campus:focus {
        border: 1px solid #006bb3;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
        color: black;
    }

    #ojt_hrs{
        border: 1px solid gray;
        color: #333333;
        background: ghostwhite;
    }
    #ojt_hrs:focus {
        border: 1px solid #006bb3;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
        color: black;
    }

    #uname {
        border: 1px solid gray;
        color: #333333;
    }
    #uname:focus { 
        border: 1px solid #006bb3;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
        color: black;
    }

    #pword {
        border: 1px solid gray;
        color: #333333;
    }
    #pword:focus { 
        border: 1px solid #006bb3;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
        color: black;
    }

    #confirm_pword{
        border: 1px solid gray;
        color: #333333;
        background: ghostwhite;
    }
    #confirm_pword:focus {
        border: 1px solid #006bb3;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
        color: black;
    }
</style>

<div class="container-fluid">
<!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><b>My Profile</b></h1>
        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
    </div>

    <!-- terms and condition -->
    <div class="card shadow mb-4" style="color: #333333;">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-danger">
                INSTRUCTIONS
            </h6>
        </div>
        <div class="card-body">
            The use of this application is intended only to help the students in viewing and updating their information related to their OJT period.<br><br>
            All fields marked with blue asterisk ( <span style="color: blue">*</span> ) are fields that unavailable for editing (such as Student ID and Name). Changing these information can be done by your OJT Teacher only.<br><br>
            All fields marked with red asterisk ( <span style="color: red">*</span> ) are required fields. These fields must not be leaved blank.
        </div>
        <br>

        <!-- student details -->
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                My User Account
            </h6>
        </div>
            <div class="card-body" style="background-color: white;">
                <?php    
                    if(isset($_SESSION['profile_pic_updated'])){
                        echo "<div class='alert alert-success alert-dismissible fade show'><h4><i class='icon fa fa-check'></i> Success!</h4>".$_SESSION['profile_pic_updated']."
                        
                        <button type='button' name='reset' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                        </button>
                        </div>";
                    }
                    unset($_SESSION['profile_pic_updated']);
                ?>
                <?php
                    if(isset($_SESSION['success_msg'])){
                            echo "<div class='alert alert-success alert-dismissible fade show'> <h4><i class='icon fa fa-check'></i> Success!</h4>".$_SESSION['success_msg']."
                                    <button type='button' name='reset' class='close' data-dismiss='alert' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                  </button>
                                </div>";
                        }
                        unset($_SESSION['success_msg']);

                        if(isset($_SESSION['err_message'])){
                            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'><h4><i class='fa fa-exclamation'></i> Warning!</h4>".$_SESSION['err_message']."
                                    <button type='button' name='reset' class='close' data-dismiss='alert' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                  </button>
                                </div>";
                        }
                        unset($_SESSION['err_message']);
                    ?>
                    <div class="container" style="color: #333333;">
                      <div class="row">
                        <div class="col">
                          <a style="text-decoration: none; color: ghostwhite;" href="" data-toggle="modal" data-target="#upload_new_image">
                            <div class="image">
                                <img src="../admin/uploaded_images/<?php echo $_SESSION['student_image']; ?>" class="rounded" alt="" id="image1" width="300px;" height="300px" style="border: 1px solid gray">
                                <div class="image__overlay">
                                    <div class="image__title">
                                    <br><br><br><br><br>
                                        <u>Upload New Profile Picture</u><br>
                                        <br><br><br><br>
                                            <i class="fas fa-camera fa-3x"></i>
                                    </div>
                                </div></a>
                            </div>
                            <br>
                        </div>

                        <div class="col">
                          <form action="my_account_update.php" method="post" enctype="multipart/form-data"><!-- form started -->
                        <div class="form-group">
                            <label for="">Student ID <span style="color: blue">*</span></label><br>
                            <input type="text" style="" name="acc_id" class="form-control" id="acc_id" aria-describedby="" placeholder="" value="<?php echo "".$_SESSION['student_id']; ?>" readonly="">
                        </div>
                        <div class="form-group">
                            <label for="">First Name <span style="color: blue">*</span></label><br>
                            <input type="text" name="fname" class="form-control" style="" id="fname" aria-describedby="" placeholder="Enter First Name" value="<?php echo "".$_SESSION['student_fname']; ?>" readonly required="">
                        </div>
                        <div class="form-group">
                            <label for="">Middle Name <span style="color: blue">*</span></label><br>
                            <input type="text" style="" name="mname" class="form-control" id="mname" aria-describedby="" placeholder="Enter Middle Name" value="<?php echo "".$_SESSION['student_mname']; ?>" readonly required="">
                        </div>
                        <div class="form-group">
                            <label for="">Last Name <span style="color: blue">*</span></label><br>
                            <input type="text" name="lname" style="" class="form-control" id="lname" aria-describedby="" placeholder="Enter Last Name" value="<?php echo "".$_SESSION['student_lname']; ?>" readonly required="">
                        </div>
                        </div>
                      </div>
                    </div>
                </div>

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        My OJT Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="container" style="color: #333333;">
                        <div class="row">
                            <div class="col-lg">
                                <div class="form-group">
                                    <label for="">Course, Year & Section <span style="color: blue">*</span> </label><br>
                                    <textarea id="course" name="course" class="form-control" aria-describedby="" style="" placeholder="" readonly><?php echo "".$_SESSION['student_course']; ?>
                                    </textarea>
                                </div>
                                <div class="form-group">
                                    <label for="">Academic Year and Semester <span style="color: blue">*</span></label><br>
                                    <input type="text" id="academic_yr_semester" name="academic_yr_semester" class="form-control" style="" id="academic_yr_semester" aria-describedby="" placeholder="" value="<?php echo "".$_SESSION['student_academic_yr_semester']; ?>" readonly required="">
                                </div>
                                <div class="form-group">
                                    <label for="">OJT Teacher <span style="color: blue">*</span></label><br>
                                    <input type="text" style="" id="teacher" name="teacher" class="form-control" id="teacher" aria-describedby="" placeholder="" value="<?php echo "".$_SESSION['student_teacher']; ?>" readonly required="">
                                </div>
                            </div>
                            <div class="col-lg">
                                <div class="form-group">
                                    <label for="">Category <span style="color: blue">*</span></label><br>
                                    <input type="text" id="in_off_campus" name="category" class="form-control" id="in_off_campus" style="" aria-describedby="" placeholder="" value="<?php echo "".$_SESSION['student_ojt_category']; ?>" readonly required="">
                                </div>
                                <div class="form-group">
                                    <label for="">In or Off Campus? <span style="color: blue">*</span></label><br>
                                    <input type="text" id="in_off_campus" name="in_off_campus" class="form-control" style="" id="in_off_campus" aria-describedby="" placeholder="" value="<?php echo "".$_SESSION['student_in_off_campus']; ?>" readonly required="">
                                </div>
                                
                                <div class="form-group">
                                    <label for="">OJT Work Hours Required <span style="color: blue">*</span></label><br>
                                    <input type="text" id="ojt_hrs" name="ojt_hrs" class="form-control" aria-describedby="" style="" placeholder="" value="<?php echo "".$_SESSION['student_hours_required']; ?>" readonly required="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        My Personal Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="container" style="color: #333333;">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Email <span style="color: red">*</span></label><br>
                                    <input type="email" name="email" class="form-control" id="my_email" aria-describedby="" onblur="checkAvailabilityMyEmail()" placeholder="Enter Email" value="<?php echo "".$_SESSION['student_email']; ?>" onkeypress="return event.charCode != 32" required="">
                                    <div style="padding-top: 8px;">
                                        <span id="my_email-availability" style="font-size:12px;"></span>
                                    </div> 
                                </div>
                                <div class="form-group">
                                    <label for="">Contact Number <span style="color: red">*</span></label><br>
                                    <input type="number" name="contact" class="form-control" id="contact" aria-describedby="" placeholder="Enter Your Contact Number" value="<?php echo "".$_SESSION['student_contact']; ?>" required="">
                                </div>
                                <div class="form-group">
                                    <label for="gender">Gender <span style="color: red">*</span></label><br>
                                    <select name="gender" id="gender" class="form-control">
                                      <?php 
                                        if ($_SESSION['student_gender'] == "Male"){
                                            echo "<option value='Male'>Male</option>";
                                            echo "<option value='Female'>Female</option>";
                                        }
                                        else if($_SESSION['student_gender'] == "Female"){
                                            echo "<option value='Female'>Female</option>";
                                            echo "<option value='Male'>Male</option>";   
                                        } 
                                    ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="civil-status">Civil Status <span style="color: red">*</span></label><br>
                                    <select name="civil_status" id="civil_status" class="form-control">
                                    <?php 
                                        if ($_SESSION['student_civil_stats'] == "Single"){
                                            echo "<option value='Single'>Single</option>";
                                            echo "<option value='Married'>Married</option>";
                                            echo "<option value='Seperated'>Seperated</option>";
                                            echo "<option value='Widowed'>Widowed</option>";
                                        }
                                        else if($_SESSION['student_civil_stats'] == "Married"){
                                            echo "<option value='Married'>Married</option>";
                                            echo "<option value='Single'>Single</option>";
                                            echo "<option value='Seperated'>Seperated</option>";
                                            echo "<option value='Widowed'>Widowed</option>";  
                                        }
                                        else if($_SESSION['student_civil_stats'] == "Seperated"){
                                            echo "<option value='Seperated'>Seperated</option>";
                                            echo "<option value='Married'>Married</option>";
                                            echo "<option value='Single'>Single</option>";
                                            echo "<option value='Widowed'>Widowed</option>";  
                                        }
                                        else if($_SESSION['student_civil_stats'] == "Widowed"){
                                            echo "<option value='Widowed'>Widowed</option>";
                                            echo "<option value='Seperated'>Seperated</option>";
                                            echo "<option value='Married'>Married</option>";
                                            echo "<option value='Single'>Single</option>";  
                                        }
                                    ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="bday">Birthday <span style="color: red">*</span></label><br>
                                    <input type="date" value="<?php echo $_SESSION['student_bday']; ?>" name="bday" class="form-control" id="bday" aria-describedby="" required>
                                </div>
                                <div class="form-group">
                                    <label for="bday">Address <span style="color: red">*</span></label><br>
                                    <textarea name="address" style="color: black; text-transform: capitalize;" id="address" class="form-control" placeholder="Enter Your Address" rows="5" required=""><?php echo $_SESSION['student_address'];?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                    <!--  -->
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Confirm the Following to Save Changes
                    </h6>
                </div>
                <div class="card-body">
                    <div class="container" style="color: #333333;">
                        <div class="row">
                            <div class="col-sm">
                                 <div class="form-group">
                                    <label for="">Student ID <span style="color: blue">*</span></label><br>
                                    <input type="text" style="background: ghostwhite;" name="uname" class="form-control" id="uname" aria-describedby="" placeholder="" value="<?php echo $_SESSION['student_id'] ?>" readonly="">
                                </div>
                                 <div class="form-group">
                                    <label for="">Password <span style="color: red">*</span></label><br>
                                    <input type="password" style="color: #333333;" name="pword" class="form-control" id="pword" aria-describedby="" placeholder="Enter Your Password to Confirm" required="">
                                </div>
                                <div class="form-group">
                                    <div class="footer">
                                        <div style="margin-left: ;">
                                            <button class="btn btn-primary" id="update_account" name="update_account">Save Changes <i class="fas fa-save"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                            </div>

                            </form><!-- form end --> 
                
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- container fluid end tag -->
<?php
include('includes/scripts.php');
include('includes/footer.php');
?>
</div>


    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" style="text-decoration: none;" href="#page-top">
        <i class="fas fa-angle"></i>
        <i class="fas fa-angle-up"></i>
        <i class="fas fa-angle"></i>
    </a>

<!-- to display image (insert image input type) -->
<script>
    const file = document.getElementById("my_profile_pic");
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
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

<script>

</script>


