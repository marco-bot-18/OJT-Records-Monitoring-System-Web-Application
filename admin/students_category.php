<?php
session_start();
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
    color: #333333;
}
#tra:hover {
    color: black;
    background: #f2f2f2;
}
#fetchval2{
    border: 1px solid gray;
    color:  #333333;
}
#fetchval2:focus {
    border: 1px solid #006bb3;
    box-shadow: none;
    outline-offset: 0px;
    outline: none;
    color:  black;
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

            <li class="nav-item active">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReports" aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-file-alt"></i>
                    <span>Reports</span>
                </a>
                <div id="collapseReports" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Category</i></h6>
                        <a class="collapse-item" href="student_submittals.php">Students' Submittals</a>
                        <a class="collapse-item active" href="students_category.php">Students' Category</a>
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

<style>
    #remarks {
        border: 1px solid #006bb3;
        color: #333333;
        resize: none;
        border-top: none;
        border-left: none;
        border-right: none;
        border-bottom: 4px solid #006bb3;
    }
    #remarks:focus { 
        border-bottom: 4px solid #006bb3;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
        color: black;
    }
    #category_desc {
        border: 1px solid #006bb3;
        color: #333333;
        resize: none;
        border-top: none;
        border-left: none;
        border-right: none;
        border-bottom: 4px solid #006bb3;
    }
    #category_desc:focus { 
        border-bottom: 4px solid #006bb3;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
        color: black;
    }
</style>

<?php include('includes/topbar.php'); ?>

<div class="container-fluid">
<!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><span><b>Reports </b> / Students' Category</span></h1>
    </div>


    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="student_submittals.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-file-alt"></i> Submittals</a>
            <a href="students_category.php" class="d-none d-sm-inline-block btn btn-sm btn-info shadow-sm active"><i class="far fa-address-book"></i> Categories</a>
        </div>
        <div class="card-header py-3" style="background: #595959;">
            <h6 class="m-0 font-weight-bold" style="color: ghostwhite;">
                <i class="far fa-address-book"></i> Students' Category
            </h6>
        </div>
        <div class="card-header py-3">
            <form action="students_category_export.php" method="POST">
                <button formtarget="_blank" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm" name="excel"><i class="fas fa-file-excel"></i> Export to Excel</button>
                <button formtarget="_blank" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm" name="pdf"><i class="fas fa-file-pdf"></i> Export to PDF</button>
                <!-- <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-file-word"></i> Export to Word</button> -->
            <form>
        </div>
        <div class="card-header py-2">
            <div class="form-group">
                <select class="form-control form-control-sm" id="fetchval2" name="section" style="width: 700px; color: #333333;">
                    <?php
                    include 'includes/db_connect_pdo.php';
                    //using pdo format
                    $sql = "SELECT * from tbl_courses";
                        $query = $dbh -> prepare($sql);
                        $query->execute();
                        $results=$query->fetchAll(PDO::FETCH_OBJ);
                        $cnt=1;
                        if($query->rowCount() > 0) {
                            echo "<option value='' selected='' value=''>Filter Course, Year & Section - All</option>";
                            foreach($results as $result){?>
                            <option value="<?php $_SESSION['course_yr_sec'] =  $result->course_title;
                                    echo $_SESSION['course_yr_sec']; ?>">
                                <?php
                                    echo $_SESSION['course_yr_sec'];
                                ?>
                            </option>
                    <?php }} ?>
                </select>
            </div>
        </div>
            <!-- table -->
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="dataTable" width="100%" cellpadding="10"  id="example" style="color: #333333;">
                      <thead>
                        <tr>
                        <center>
                          <th hidden=""> </th>
                          <th>No.</th>
                          <th hidden="">Student ID</th>
                          <th hidden="">Student Name</th>
                          <th hidden="">Course, Yr & Section</th>
                          <th>Student</th>
                          <th>Category</th>
                          <th>Remarks</th>
                          <th>Action</th>
                        </center>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                            $count = 1;
                            $_coordinator = $_SESSION['coordinator_fullname'];
                            require_once('includes/db_connect.php');
                            $stats = "active";
                            $sql = "SELECT * FROM tbl_students ORDER BY id ASC";
                            $query = $conn->query($sql);
                            while($row = $query->fetch_assoc()){
                                $id = $row['stud_id'];
                                $status = $row['status'];
                        ?>
                        <tr id="tra">
                          <td hidden=""><?php echo $row['uniq_id']; ?></td>
                          <td width="5%"><?php echo $count; ?> </td>
                          <td hidden=""><?php echo $id; ?></td>
                          <td width="30%">
                            <div>
                               <i class="fas fa-id-card-alt" style="color: #dc3545;"></i> <?php echo $id; ?>
                            </div>
                            <div>
                                <i class="fas fa-user-graduate" style="color: #dc3545;"></i> <?php echo $row ['stud_fullname']; ?>
                            </div>
                            <div>
                                <i class="fas fa-graduation-cap" style="color: #dc3545;"></i> <?php echo $row ['course']; ?>  
                            </div>
                          </td>
                          <td hidden=""><?php echo $row['lname'].", ".$row['fname']." ".$row['mname']; ?></td>
                          <td hidden=""><?php echo $row ['course']; ?></td>
                          <td><?php echo $row ['ojt_category']; ?></td>
                          <td>
                              <?php 
                                if ($row['remarks'] == "pending") {
                                    echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-warning'>PENDING</span>";    
                                }
                                if ($row['remarks'] == "ongoing") {
                                    echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-info'>ON-GOING</span>";    
                                }
                                if ($row['remarks'] == "completed") {
                                    echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-success'>COMPLETED</span>"; 
                                }
                            ?>
                          </td>
                          <td>
                             <a href="#view<?php echo $id;?>" title="View Student's Category Details" data-toggle="modal" data-id="" class="btn btn-info"><i class="fas fa-eye"></i></a>
                          </td>
                        </tr>

                        <!-- View student category details -->
                        <div class="modal fade bd-example-modal-xl" id="view<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                          <div class="modal-dialog modal-xl" role="document" style="color: #333333;">
                            <div class="modal-content modal-xl">
                              <div class="modal-header modal-xl">
                                <h5 class="modal-title" style="color: #0d6efd;"><h><i class="far fa-address-book"></i> Student's Category Details</h></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-header modal-xl">
                                  <h style="color: #333333">
                                    <i class="fas fa-id-card"></i> <?php echo $row['stud_id']?> <br>
                                    <i class="fas fa-user-graduate"></i> <?php echo $row['fname']." ".$row['mname']." ".$row['lname']?> <br>
                                    <i class="fas fa-graduation-cap"></i> <?php echo $row['course']?> <br>
                                    <i class="fas fa-university"></i> <?php echo $row['in_off_campus']?> <br>
                                    <i class="fas fa-user-clock"></i> <?php echo $row['hours_required']?> <br>
                                    <i class="fas fa-columns"></i> <?php echo $row['ojt_category']?>
                                   </h>
                              </div>
                              <div class="modal-body modal-xl">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md">
                                            <form class="" action="students_category_update.php" method="POST" enctype="multipart/form-data">
                                                <input type="text" name="stud_fullname" value="<?php echo $row['fname']." ".$row['mname']." ".$row['lname']?>" hidden>
                                            <div class="">
                                                <input type="text" name="id" value="<?php echo $row['id']; ?>" hidden>
                                                <input type="text" name="stud_uniq_id" value="<?php echo $row['uniq_id']; ?>" hidden>
                                            </div>   
                                            <div class="form-group">
                                                <label>Description : </label> <br>
                                                <textarea readonly="" class="form-control" name="category_desc" id="category_desc" rows="10" style="background: ghostwhite;"><?php echo $row['category_desc']; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md">
                                             <div class="form-group">
                                                <label>Remarks: </label> <br>
                                                <?php 
                                                    if ($row['remarks'] == "pending") {
                                                        echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-warning'>PENDING</span>";    
                                                    }
                                                    if ($row['remarks'] == "ongoing") {
                                                        echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-info'>ON-GOING</span>";    
                                                    }
                                                    if ($row['remarks'] == "completed") {
                                                        echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-success'>COMPLETED</span>"; 
                                                    }
                                                ?>
                                                <!-- <textarea readonly="" class="form-control" name="remarks" id="remarks" rows="10"><?php echo $row['remarks']; ?></textarea> -->
                                            </div>  
                                        </div>
                                    </div>
                                </div>
                              </div>
                              <div class="modal-footer modal-xl">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                              </div>
                              </form>
                            </div>
                          </div>
                        </div>
                        <!-- -->
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
        $("#fetchval2").on('change', function(){
            var value = $(this).val();
            
            $.ajax({
                url:"students_category_fetch.php",
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

<!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" style="text-decoration: none;" href="#page-top">
        <i class="fas fa"></i>
        <i class="fas fa-angle-up"></i>
        <i class="fas fa"></i>
    </a>

<!-- Logout Modal-->
<?php 
include('includes/logout-modal.php');
?>
<?php
include('includes/scripts.php');
include('includes/footer.php');
?>
