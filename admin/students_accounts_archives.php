<?php
require_once('includes/session.php');
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
    color:  #333333;
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


            <li class="nav-item active">
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
                        <a class="collapse-item active" href="students_accounts_archives.php">Student Accounts</a>
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

        <?php include('includes/topbar.php'); ?>
        <!-- End of Sidebar -->


<script>
    function checkCorrectPassword() {
    $("#loaderIcon").show();
        jQuery.ajax({
            url: "includes/check_availability.php",
            data:'my_password='+$("#my_password").val(),
            type: "POST",
            success:function(data){
            $("#validate_password_correct").html(data);
            $("#loaderIcon").hide();
        },
        error:function (){}
        });
    }
</script>


<script>
    function checkAvailabilityStudId() {
    $("#loaderIcon").show();
        jQuery.ajax({
            url: "includes/check_availability.php",
            data:'stud_id='+$("#stud_id").val(),
            type: "POST",
            success:function(data){
            $("#stud_id-availability").html(data);
            $("#loaderIcon").hide();
        },
        error:function (){}
        });
    }
</script>

<script>
    function checkAvailabilityStudId1() {
    $("#loaderIcon").show();
        jQuery.ajax({
            url: "includes/check_availability.php",
            data:'stud_id1='+$("#stud_id1").val(),
            type: "POST",
            success:function(data){
            $("#stud_id-availability1").html(data);
            $("#loaderIcon").hide();
        },
        error:function (){}
        });
    }
</script>

<script>
    function checkAvailabilityStudEmail() {
    $("#loaderIcon").show();
        jQuery.ajax({
            url: "includes/check_availability.php",
            data:'stud_email='+$("#stud_email").val(),
            type: "POST",
            success:function(data){
            $("#stud_email-availability").html(data);
            $("#loaderIcon").hide();
        },
        error:function (){}
        });
    }
</script>

<style>
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
    #teacher{
        border: 1px solid gray;
        color: #333333;
    }
    #teacher:focus {
        border: 1px solid #006bb3;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
        color: black;
    }

    #section{
        border: 1px solid gray;
        color: #333333;
    }
    #section:focus {
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
    .errorWrap {
      font-style: italic;
      color: black;
      padding: 10px;
      margin: 0 0 20px 0;
      background: #fff;
      border-left: 4px solid #dd3d36;
      -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
      box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    }
    .succWrap{
      font-style: italic;
      color: black;
      padding: 10px;
      margin: 0 0 20px 0;
      background: #fff;
      border-left: 4px solid blue;
      -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
      box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    }
</style>



<div class="container-fluid">
<!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><span><b>Archives</b> / Students' Account</h1>
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
        <div class="card-header py-3" style="color: #333333; background: white; ">
            The use of this application is intended only to view or retrieve an account for OJT students.<br><br>
        </div>
        <div class="card-header py-3" style="background: #595959;">
            <h6 class="m-0 font-weight-bold" style="color: ghostwhite;"> 
               <i class="fas fa-user-graduate"></i> Student Accounts
        </div>
       <div class="card-header py-2">
            <select  class="form-control form-control-sm" name="acad_yr_sem" id="acad_yr_sem" style="width: 300px; color: #333333;">
                <?php
                include 'includes/db_connect_pdo.php';
                //using pdo format
                $active = "active";
                $sql = "SELECT * from tbl_academic_year_sem";
                    $query = $dbh -> prepare($sql);
                    $query->execute();
                    $results=$query->fetchAll(PDO::FETCH_OBJ);
                    $cnt=1;
                    if($query->rowCount() > 0) {
                        echo "<option value='' selected='' value=''>Filter Academic Year and Semester - All</option>";
                        foreach($results as $result){?>
                        <option value="<?php echo $result->academic_yr." - ".$result->semester; ?>">
                            <?php echo $result->academic_yr." - ".$result->semester;?>
                        </option>
                <?php }} ?>
            </select>
        </div>
            <!-- table -->
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="dataTable" width="100%"  cellpadding="10"  id="example" style="color: #333333;">
                      <thead>
                        <tr>
                        <center>
                          <th>No.</th>
                          <th>Photo</th>
                          <th>Student ID</th>
                          <th>Student Name</th>
                          <th>Course, Year & Section</th>
                          <th>Is Archived?</th>
                          <th>Action</th>
                        </center>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                            $count = 1;
                            require_once('includes/db_connect.php');
                            $isArchived = "archived";
                            $sql = "SELECT * FROM tbl_students where archived='$isArchived' ORDER BY id ASC";
                            $query = $conn->query($sql);
                            while($row = $query->fetch_assoc()){
                                $id = $row['stud_id'];
                                $status = $row['status'];
                        ?>
                        <tr id="tra">
                          <td><?php echo $count; ?> </td>
                          <td><img src="../admin/uploaded_images/<?php echo $row['image']; ?>" alt="" style="margin-right: 50px; border-radius: 50%;" id="image1" width="50px;" height="50px;">  </td>
                          <td><?php echo $id; ?></td>
                          <td><?php echo $row['lname'].", ".$row['fname']." ".$row['mname']; ?></td>
                          <td width="20%"><?php echo $row ['course']; ?></td>
                          <td>
                              <?php 
                                if($row['archived'] == "archived"){
                                    echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-danger'>ARCHIVED</span>";
                                }
                              ?>
                          </td>
                          <td>
                            <a href="#view<?php echo $id;?>" title="View Student's Info" data-toggle="modal" data-id="" class="btn btn-info"><i class="fas fa-eye"></i></a>
                             <a href="#retrieve<?php echo $id;?>" data-toggle="modal" title="Retrieve"><button class="btn btn-success"><i class="fas fa-retweet"></i></button></a>
                          </td>
                        </tr>

                        <!-- retrieve -->
                        <div class="modal fade bd-example-modal-lg" id="retrieve<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                          <div class="modal-dialog modal-lg">
                            <div class="modal-content modal-lg" style="color: #333333;">
                              <div class="modal-header modal-lg">
                                <h5 class="modal-title" id="exampleModalLabel" style="color: #0d6efd;"><i class="fas fa-retweet"></i> Are You Sure Do you Want To Retrieve The Account of <?php echo $row['fname']." ".$row['mname']." ".$row['lname']." (".$row['stud_id'].")";?> ?</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body modal-lg">
                                <form action="student_account_retrieve.php" method="POST" enctype="multipart/form-data">
                                    <input type="text" name="stud_id" value="<?php echo $id?>" hidden>
                                    <input type="text" name="stud_uniq_id" value="<?php echo $row['uniq_id'];?>" hidden>
                                    <input type="text" name="fullname_id" value="<?php echo $row['fname']." ".$row['mname']." ".$row['lname']." (".$row['stud_id'].")";?>" hidden>
                                    <div class="form-group">
                                        <label>Choose Academic Year and Semester:</label>
                                        <select  class="form-control" name="acad_yr_sem" id="acad_yr_sem" required="">
                                            <?php
                                            include 'includes/db_connect_pdo.php';
                                            //using pdo format
                                            $active = "active";
                                            $sql1 = "SELECT * from tbl_academic_year_sem WHERE status=:active";
                                                $query1 = $dbh -> prepare($sql1);
                                                $query1->bindParam(':active', $active, PDO::PARAM_STR);
                                                $query1->execute();
                                                $results1=$query1->fetchAll(PDO::FETCH_OBJ);
                                                $cnt=1;
                                                if($query1->rowCount() > 0) {
                                                    echo "<option value='' selected='' disabled=''>Choose Academic Year</option>";
                                                    foreach($results1 as $result1){?>
                                                    <option value="<?php echo $result1->academic_yr." - ".$result1->semester; ?>">
                                                        <?php echo $result1->academic_yr." - ".$result1->semester;?>
                                                    </option>
                                            <?php }} ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Assign OJT Teacher:</label>
                                        <select class="form-control" name="teacher" id="teacher">
                                            <?php
                                                include 'includes/db_connect_pdo.php';
                                                //using pdo format
                                                $isArchived = "not archived";
                                                $userType = "teacher";
                                                $course = $row['program'];
                                                $sql2 = "SELECT * from tbl_coordinators WHERE isArchived=:isArchived and userType=:userType and course=:course";
                                                $query2 = $dbh -> prepare($sql2);
                                                $query2->bindParam(':isArchived', $isArchived,PDO::PARAM_STR);
                                                $query2->bindParam(':userType', $userType,PDO::PARAM_STR);
                                                $query2->bindParam(':course', $course,PDO::PARAM_STR);
                                                $query2->execute();
                                                $results2=$query2->fetchAll(PDO::FETCH_OBJ);
                                                $cnt=1;
                                                if($query2->rowCount() > 0) {
                                                    echo "<option value='' selected='' disabled=''>Assign OJT Teacher</option>";
                                                    foreach($results2 as $result2){ ?>
                                                    <option value="<?php echo $result2->fname." ".$result2->mname." ".$result2->lname." (".$result2->coordinator_id.")";?>">
                                                        <?php echo $result2->fname." ".$result2->mname." ".$result2->lname." (".$result2->coordinator_id.")";?>
                                                    </option>
                                            <?php }} ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Choose Course, Year & Section</label>
                                        <select  class="form-control" name="section" id="section" required="">
                                            <?php
                                            include 'includes/db_connect_pdo.php';
                                            //using pdo format
                                            $sql3 = "SELECT * from tbl_courses";
                                                $query3 = $dbh -> prepare($sql3);
                                                $query3->execute();
                                                $results3=$query3->fetchAll(PDO::FETCH_OBJ);
                                                $cnt=1;
                                                if($query3->rowCount() > 0) {
                                                    echo "<option value='' selected='' value='' disabled>Choose Course, year & Section</option>";
                                                    foreach($results3 as $result3){?>
                                                    <option value="<?php echo $result3->course_title; ?>">
                                                        <?php echo $result3->course_title;?>
                                                    </option>
                                            <?php }} ?>
                                        </select>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <label>Confirm Your Password</label>
                                        <input type="password" name="my_password" placeholder="Enter Your Password" id="my_password" class="form-control">
                                    </div>
                              </div>
                              <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel <i class="fas fa-times-circle"></i></button>
                                    <button type="submit" name="retrieve" id="retrieve" class="btn btn-success">Retrieve <i class="fas fa-retweet"></i></button>
                                    <!-- <button class="btn btn-primary" name="update">Update</button> -->
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>

                        <!-- View Student Modal -->
                        <div class="modal fade bd-example-modal-lg" id="view<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                          <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content modal-lg">
                              <div class="modal-header modal-lg">
                                <h5 class="modal-title" style="color: #0d6efd;"><h><i class="fas fa-user-graduate"></i> View Archived Student's Account Details</h></h5>
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
                                       <font style="font-weight: bold; "><?php echo $row['fname']. " ".$row['mname']. " ".$row['lname']; ?></font>
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
                        <?php $count++; } ?>
                      </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- fetch data on the dropdown -->
<script type="text/javascript">
    $(document).ready(function(){
        $("#acad_yr_sem").on('change', function(){
            var value = $(this).val();
            $.ajax({
                url:"students_accounts_archives_fetch.php",
                type:"POST",
                data: 'request2=' + value,
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


<!-- Message Box JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

<!-- alert messages -->
<?php
    if (isset($_SESSION['retrieved'])) {?>
        <script>
            swal.fire({
             icon: 'success',
             type : 'success',
             title : 'Student Account was Retrieved Successfully!',
             text : '<?php echo $_SESSION['retrieved']?>'
         })
        </script>
    <?php unset($_SESSION['retrieved']);
    }
?>

<?php
    if (isset($_SESSION['wrong_password'])) {?>
        <script>
            swal.fire({
             icon: 'warning',
             type : 'warning',
             title : 'Invalid Password!',
             text : '<?php echo $_SESSION['wrong_password']?>'
         })
        </script>
    <?php unset($_SESSION['wrong_password']);
    }
?>


<script>
$('.del-btn').on('click',function(e){
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
