<style type="text/css">


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
}

.image-preview_edit {
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

          <!--   <li class="nav-item">
                <a class="nav-link" href="enrollment_module.php">
                    <i class="fas fa-fw fa-map"></i>
                    <span>Enrollment Module</span></a>
            </li> -->

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
            <li class="nav-item">
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
                        <a class="collapse-item" href="coordinators_account.php">OJT Teachers</a>
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


<?php 
include('includes/topbar.php');
?>
 
<script>
    function checkAvailabilityEmpId() {
    $("#loaderIcon").show();
        jQuery.ajax({
            url: "includes/check_availability.php",
            data:'my_emp_id='+$("#my_emp_id").val(),
            type: "POST",
            success:function(data){
            $("#emp_id-availability").html(data);
            $("#loaderIcon").hide();
        },
        error:function (){}
        });
    }
</script>

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
                    <img src="" alt="Image Preview" style="border: solid 1px #333333;" class="image-preview__image">
                    <span class="image-preview__default-text"></span>
                </div>
                <br>
              </center>
                <div class="form-group">
                    <input type="file" accept="image/png, image/gif, image/jpeg" class="form-control" id="my_profile_pic" name="my_profile_pic" onchange="validateFileType()" required>
                </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel <i class="fas fa-window-close"></i></button>
            <button class="btn btn-primary" name="btn_save_pic">Update Profile Picture<i class="fas fa-save"></i></button>
          </div>
        </form>
    </div>
  </div>
</div>

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


<div class="container-fluid">
<!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><b>My Profile</b></h1>
        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
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
    #my_emp_id {
        border: 1px solid gray;
        color: #333333;
    }
    #my_emp_id:focus { 
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
        background: ghostwhite;
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
    #address{
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

    #my_email{
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
    #uname{
       border: 1px solid gray; 
       color: #333333;
       background: ghostwhite;
    }
    #uname:focus {
        border: 1px solid #006bb3;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
        color: black;
        background: ghostwhite;
    }
    #pword{
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

    <div class="card shadow mb-4" style="color: #333333;">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-danger">
                TERMS AND CONDITIONS
            </h6>
        </div>

        <div class="card-body" style="color: #333333;">
            The use of this application is intended only to help you in viewing and updating your information.<br><br>
        </div>
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                My User Account
            </h6>
        </div>
        <div class="card-body">
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
                            <img src="uploaded_images/<?php echo $_SESSION['admin_image']; ?>" class="rounded" alt="" id="image1" width="300px;" height="300px" style="border: 1px solid gray">
                            <div class="image__overlay">
                                <div class="image__title">
                                <br><br><br><br><br>
                                    <u>Upload New Profile Picture</u><br>
                                    <br><br><br><br>
                                        <i class="fas fa-camera fa-3x"></i>
                                </div>
                            </div></a>
                        </div>
                    </div>
                    <div class="col">
                      <form action="my_account_update.php" method="post" enctype="multipart/form-data"><!-- form started -->
                        <input type="text" name="id" value="<?php echo $_SESSION['id'];?>" hidden>
                        <div class="form-group">
                            <label for="">Employee ID <span style="color: red;">*</span></label><br>
                            <input type="text" name="employee_id" id="my_emp_id" class="form-control" aria-describedby="" onBlur="checkAvailabilityEmpId()" onkeypress="return alpha(event)" placeholder="ex. 9999" value="<?php echo "".$_SESSION['username']; ?>">
                            <div style="padding-top: 5px;">
                                <span id="emp_id-availability" style="font-size:12px;"></span>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="">First Name <span style="color: red;">*</span></label><br>
                            <input type="text" name="fname" class="form-control" id="fname" aria-describedby="" placeholder="ex. Juan" style="text-transform: capitalize;" value="<?php echo "".$_SESSION['admin_fname']; ?>" required="">
                        </div>
                        <div class="form-group">
                            <label for="">Middle Name <span style="color: red;">*</span></label><br>
                            <input type="text" name="mname" style="text-transform: capitalize;" class="form-control" id="mname" aria-describedby="" placeholder="ex. Santos" value="<?php echo "".$_SESSION['admin_mname']; ?>" required="">
                        </div>
                        <div class="form-group">
                            <label for="">Last Name <span style="color: red;">*</span></label><br>
                            <input type="text" style="text-transform: capitalize;" name="lname" class="form-control" id="lname" aria-describedby="" placeholder="ex. Dela Cruz" value="<?php echo "".$_SESSION['admin_lname']; ?>" required="">
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
                        <div class="col-lg">
                            <div class="form-group">
                        <label for="">Email <span style="color: red;">*</span></label><br>
                        <input type="email" name="email" class="form-control" id="my_email" aria-describedby="" onblur="checkAvailabilityMyEmail()" placeholder="ex. juandelacruz09@gmail.com" value="<?php echo "".$_SESSION['admin_email']; ?>" onkeypress="return event.charCode != 32" required="">
                        <div style="padding-top: 8px;">
                            <span id="my_email-availability" style="font-size:12px;"></span>
                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender</label><br>
                        <select name="gender" id="gender" class="form-control">
                          <?php 
                            if ($_SESSION['admin_gender'] == "Male"){
                                echo "<option value='Male'>Male</option>";
                                echo "<option value='Female'>Female</option>";
                            }
                            else if($_SESSION['admin_gender'] == "Female"){
                                echo "<option value='Female'>Female</option>";
                                echo "<option value='Male'>Male</option>";   
                            } 
                        ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="civil-status">Civil Status</label><br>
                        <select name="civil_status" id="civil_stats" class="form-control">
                        <?php 
                            if ($_SESSION['civil_stats'] == "Single"){
                                echo "<option value='Single'>Single</option>";
                                echo "<option value='Married'>Married</option>";
                                echo "<option value='Seperated'>Seperated</option>";
                                echo "<option value='Widowed'>Widowed</option>";
                            }
                            else if($_SESSION['civil_stats'] == "Married"){
                                echo "<option value='Married'>Married</option>";
                                echo "<option value='Single'>Single</option>";
                                echo "<option value='Seperated'>Seperated</option>";
                                echo "<option value='Widowed'>Widowed</option>";  
                            }
                            else if($_SESSION['civil_stats'] == "Seperated"){
                                echo "<option value='Seperated'>Seperated</option>";
                                echo "<option value='Married'>Married</option>";
                                echo "<option value='Single'>Single</option>";
                                echo "<option value='Widowed'>Widowed</option>";  
                            }
                            else if($_SESSION['civil_stats'] == "Widowed"){
                                echo "<option value='Widowed'>Widowed</option>";
                                echo "<option value='Seperated'>Seperated</option>";
                                echo "<option value='Married'>Married</option>";
                                echo "<option value='Single'>Single</option>";  
                            }
                        ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="bday">Birthday</label></label><br>
                        <input type="date" value="<?php echo $_SESSION['bday']; ?>" name="bday" class="form-control" id="bday" aria-describedby="" required>
                    </div>
                        </div>
                        <div class="col-lg">
                            <div class="form-group">
                                <label for="">Address</label><br>
                                <textarea name="address" style="text-transform: capitalize;" id="address" placeholder="ex. Brgy. Bubukal, Santa Cruz, Laguna" class="form-control" name="address" rows="12"><?php echo $_SESSION['admin_address']; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
                                <label for="">Username</label><br>
                                <input type="text" name="uname" class="form-control" id="uname" aria-describedby="" placeholder="" value="<?php echo $_SESSION['admin_username'] ?>" readonly="">
                            </div>
                             <div class="form-group">
                                <label for="">Password</label><br>
                                <input type="password" name="pword" class="form-control" id="pword" aria-describedby="" placeholder="ex. YourPassword" required="">
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

    <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" style="text-decoration;" href="#page-top">
            <i class="fas fa-"></i>
            <i class="fas fa-angle-up"></i>
            <i class="fas fa-"></i>
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

<?php 
include('includes/logout-modal.php');
?>
<?php
include('includes/scripts.php');
include('includes/footer.php');
?>