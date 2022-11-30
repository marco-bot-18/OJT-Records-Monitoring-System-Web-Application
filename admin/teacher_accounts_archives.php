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
                        <a class="collapse-item" href="students_accounts_archives.php">Student Accounts</a>
                        <a class="collapse-item active" href="teacher_accounts_archives.php">Teacher Accounts</a>
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

<div class="container-fluid">
<!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><span><b>Archives</b> / OJT Teachers' Account</h1>
    </div>

<style>
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
        <div class="card-header py-3" style="color: #333333; background: white;">
            The use of this application is intended only to view or retrieve an account of OJT teachers.<br><br>
        </div>
        <div class="card-header py-3" style="background: #595959;">
            <h6 class="m-0 font-weight-bold" style="color: ghostwhite;">
                <i class="fas fa-user-tie"></i> Archived User Account of OJT Teachers
            </h6>
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
                    <table class="table table-hover" id="dataTable"  cellpadding="20"  id="example" width="100%" style="color: #333333">
                      <thead>
                        <tr>
                        <center>
                          <th hidden=""> ID</th>
                          <th>No.</th>
                          <th>Employee ID No.</th>
                          <th>Full Name</th>
                          <th>Is Archived?</th>
                          <th>Action</th>
                        </center>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                            require_once('includes/db_connect.php');
                            $count = 1;
                            $isArchived = "archived";
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
                            if ($row['isArchived'] == 'archived') {
                                echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-danger'> ARCHIVED</span>";
                            }
                          ?> 
                          </td>
                          <td>
                            <a href="#view<?php echo $id;?>" data-toggle="modal" data-id="" class="btn btn-info" title="View Teacher's Account Info"><i class="fas fa-eye"></i></a>
                            <a href="#retrieve<?php echo $id;?>" data-toggle="modal" title="Retrieve"><button class="btn btn-success"><i class="fas fa-retweet"></i></button></a>
                          </td>
                        </tr>

                        <!-- retrieve -->
                        <div class="modal fade" id="retrieve<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                          <div class="modal-dialog">
                            <div class="modal-content" style="color: #333333;">
                              <div class="modal-header">
                                <h6 class="modal-title" id="exampleModalLabel" style="color: #0d6efd;"><i class="fas fa-archive"></i> Are You Sure Do you Want To Retrieve the Account of <?php echo $row['fname']." ".$row['mname']." ".$row['lname']." (".$row['coordinator_id'].")";?> ?</h6>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <form action="teacher_account_retrieve.php" method="POST" enctype="multipart/form-data">
                                    <input type="text" name="coordinator_id" value="<?php echo $coordinator_id?>" hidden>
                                    <input type="text" name="coordinator_uniq_id" value="<?php echo $row['uniq_id'];?>" hidden>
                                    <input type="text" name="fullname_id" value="<?php echo $row['fname']." ".$row['mname']." ".$row['lname']." (".$row['coordinator_id'].")";?>" hidden>
                                    <div class="form-group">
                                        <label for="">Assign Program: <span style="color: red;">*</span></label><br>
                                        <select class="form-control" name="course" id="course">
                                            <?php
                                            include 'includes/db_connect_pdo.php';
                                            //using pdo format
                                            $sql2 = "SELECT DISTINCT course_code from tbl_courses order by id ASC";
                                            $query2 = $dbh -> prepare($sql2);
                                            $query2->execute();
                                            $results2=$query2->fetchAll(PDO::FETCH_OBJ);
                                            $cnt=1;
                                            if($query2->rowCount() > 0) {
                                                foreach($results2 as $result2){?>
                                                <option value="<?php echo $result2->course_code; ?>">
                                                    <?php echo $result2->course_code; ?>
                                                </option>
                                            <?php }} ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Academic Year and Semester: <span style="color: red;">*</span></label><br>
                                        <select class="form-control" name="acad_yr_sem" id="acad_yr_sem">
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
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <label>Confirm Your Password: <span style="color: red;">*</span></label>
                                        <input type="password" name="my_password" placeholder="Enter Your Password" id="my_password" class="form-control">
                                        <div style="padding-top: 8px;">
                                            <span id="validate_password_correct" style="font-size:12px;"></span>
                                        </div> 
                                    </div>
                              </div>
                              <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel <i class="fas fa-times-circle"></i></button>
                                    <button type="submit" name="retrieve" id="retrieve" class="btn btn-success">Archive <i class="fas fa-retweet"></i></button>
                                    <!-- <button class="btn btn-primary" name="update">Update</button> -->
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>


                        <!-- View OJT Teacher Modal -->
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
                url:"teacher_accounts_archives_fetch.php",
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

<?php
    if (isset($_SESSION['retrieved'])) {?>
        <script>
            swal.fire({
             icon: 'success',
             type : 'success',
             title : 'Teacher Account was Retrieved Successfully!',
             text : '<?php echo $_SESSION['retrieved']?>'
         })
        </script>
    <?php unset($_SESSION['retrieved']);
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
