<!-- gawin yung audit trail/user logs at archives and retrieve, ayusin ang design, -->
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

            <li class="nav-item active">
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
                        <a class="collapse-item active" href="request_docs_completed.php">Approved
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
 
<div class="container-fluid">
<!-- Page Heading -->
    
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><span><b>Documents for Signing</b> / Approved </span></h1>
       <!--  <a href="my_stud_requirements_completed_for_today.php" class="btn btn-sm btn-success shadow-sm" title="Click Here To See The Students Who Submitted Their Requirements for Today"><i class="fas fa-calendar-day"></i> Today</a> -->
    </div>

    <style>
        
        #signed_document{
            border: 1px solid gray;
            color:  #333333;
        }
        #signed_document:focus {
            border: 1px solid black;
            box-shadow: none;
            outline-offset: 0px;
            outline: none;
            color:  black;
        }
        #instructions {
            border: 1px solid gray;
            color: #333333;
            resize: none;
            border-top: none;
            border-left: none;
            border-right: none;
            border-bottom: 4px solid gray;
        }
        #instructions:focus { 
            border-bottom: 4px solid black;
            box-shadow: none;
            outline-offset: 0px;
            outline: none;
            color: black;
        }
    </style>

    <!-- Show Table Area -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="request_docs_completed.php" class="btn btn-sm btn-success shadow-sm active" title="Approved Documents"><i class="fas fa-check-circle"></i> Signed as Completed 
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
                </span></a>
            <a href="request_docs_pending.php" class="btn btn-sm btn-warning shadow-sm" title="Pending Documents That Are Not Yet Approved"><i class="fas fa-file-alt"></i> Pending Documents
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
        </div>
        <div class="card-header py-3">
        <?php ?>
            <h6 class="m-0 font-weight-bold text-primary">
                Approved Requirements. All the requirements here is now in COMPLETED status.
            </h6>
        </div>
        <div class="card-header py-3" style="background: #595959;">
            <h6 class="m-0 font-weight-bold" style="color: ghostwhite;">
                <i class="fas fa-check-circle"></i> Documents That Have Been Signed and Completed
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="dataTable" width="100%" cellspacing="10"  id="example" style="color: #333333;">
                  <thead>
                    <tr>
                      <th hidden=""> TASK CODE</th>
                      <th hidden="">ID</th>
                      <th>Submitted by</th>
                      <th hidden>Course</th>
                      <th>Requirement</th>
                      <th>Signed Document</th>
                      <th>Remarks</th>
                      <th>Status</th>
                      <th>Action</th>                      
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                    require_once('includes/db_connect.php');
                    $work_stats1 = "completed";
                    $send_to_dean = "dean";
                    $stats = "not archived";
                    $send_to_dean = "dean";
                    $submitted = "yes";
                    $count = 1;
                    $sql = "SELECT * from tbl_students_work where (send_to_Dean='$send_to_dean' and work_status='$work_stats1' and submitted='$submitted' and status='$stats') order by id asc";
                    $query = $conn->query($sql);
                    while($row = $query->fetch_assoc()){
                        $id = $row['id'];
                        $task_code = $row['task_code'];
                        $_SESSION['task_id_22'] = $row['id'];
                    ?>
                    <tr id="tra">
                       <td hidden=""> <?php echo $task_code;?> </td> 
                       <td hidden=""><?php 
                            $_SESSION['t_id_works11'] = $_SESSION['task_id_22'];
                            echo $_SESSION['t_id_works11'];
                        ?>  
                      </td>
                      <td width="20%">
                        <div>
                            <i class="fas fa-user-graduation" style="color: #dc3545;"></i> <?php echo $row['stud_name_and_id']; ?>
                        </div>
                        <div>
                            <i class="fas fa-graduation-cap" style="color: #dc3545;"></i> <?php echo $row['course'];?>
                        </div>
                      </td>
                      <td hidden><?php echo $row['course'];?> </td>
                      <td>
                      <?php echo $row['title'];?> 
                      </td>
                      <td width="20%"><b><a href="signed_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File"><i class="fas fa-file"></i> <?php echo $row['uploaded_file'];?></a> </b></td>
          
                        <td width="20%">
                        <?php 
                            if ($row['remarks'] == 'waiting') {
                                 echo "<span style='font-size: 15px; margin-left: 0px; color: gray;' class='badge badge-pill badge-warning'>WAITING</span>";
                            }

                            if ($row['remarks'] == 'Not Approved') {
                                 echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-danger'>NOT APPROVED</span>";
                            }

                            if ($row['remarks'] == 'Approved') {
                                 echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-success'>APPROVED</span>";
                            }
                        ?>
                      </td>
                      <td>
                        <?php 
                            if ($row['work_status'] == 'pending') {
                             echo "<div class='progress'>
                                      <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' title='15% on progress'></div>
                                    </div><b>PENDING 15%</b>";
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
                                          <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'>100%</div>
                                        </div><b>COMPLETED</b>";
                            }
                        ?>
                      </td>
                      <td width="10%">
                          <!-- <a href="#view<?php echo $id;?>" title="View Submitted Requirement" data-toggle="modal" ><button class="btn btn-success"><i class="fas fa-check-square"></i></button></a> -->

                          <a href="#view<?php echo $id;?>" title="View Requirement" data-toggle="modal" ><button class="btn btn-info"><i class="fas fa-eye"></i></button></a>

                          <!-- <a href="" class='del-btn'><button class="btn btn-danger" title="Delete"><i class="fas fa-trash-alt"></i></button></a> -->
                      </td>

                        <!-- Completed Requirement Modal -->
                        <div class="modal fade bd-example-modal-lg" data-backdrop="static" id="view<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="update_place" aria-hidden="true">
                          <div class="modal-dialog modal-lg" role="document" style="color:  #333333;">
                            <div class="modal-content modal-lg">
                              <div class="modal-header modal-lg">
                                <h5 class="modal-title" id="exampleModalLabel"><h style="color: #0d6efd"><i class="fas fa-file-signature"></i> <?php echo $row['title']; ?> (Approved) </h><span><?php //echo $row['edited']; ?></span></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-header modal-lg">
                                <p class="modal-title" id="exampleModalLabel">
                                <h title="Date and Time Forwarded"><i style="color: #1a8cff;" class="fas fa-clock"></i> <?php  echo $row['completed_date']; ?></h> • <h title="Approved By"><i class="fas fa-user-check" style="color: #1a8cff;"></i> Me </h></p> 
                              </div>
                              <form action="request_docs_update.php" method="POST" enctype="multipart/form-data"><!-- form start -->
                              <input type="text" class="form-control" name="id" value="<?php echo $id;?>" hidden>
                              <!-- task code uniq id -->
                              <input type="text" name="task_code" value="<?php echo $task_code;?>" hidden>
                                <div class="modal-body modal-lg">
                                    <!-- <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-md"> -->
                                    <div class="form-group">
                                        <label>Submitted by: </label> <br>
                                        <b><?php echo $row['stud_name_and_id']; ?> </b>
                                        <input type="text" hidden="" name="stud_fullname" value="<?php echo $row['stud_name_and_id']; ?>">
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <label>Course, Year & Section: </label> <br>
                                        <b> <?php echo $row['course']; ?> </b>
                                        <input type="text" hidden="" name="course" value="<?php echo $row['course']; ?>">
                                    </div>
                                    <hr>
                                    <!-- GET REQUIREMENT -->
                                        <input type="text" hidden="" name="requirement" value="<?php echo $row['title']; ?>">
                                    <div class="form-group">
                                        <label>Signed Document</label>: <?php //echo $row['edited_by_student'];?><br>
                                        <b><a href="signed_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File">
                                            <i class="fas fa-file-signature"></i><?php echo $row['uploaded_file'];?></a>
                                        </b>
                                        <input type="text" value="<?php echo $row['uploaded_file'];?>" name="signed_document" hidden required>
                                    </div>
                                    <div class="form-group">
                                        <div class="embed-responsive embed-responsive-1by1">
                                          <iframe class="embed-responsive-item" src="signed_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <label>Status: </label> <br>
                                        <input hidden type="text" name="status" value="<?php echo $row['work_status']; ?>">
                                        <?php 
                                            if ($row['work_status'] == 'pending') {
                                             echo "<div class='progress'>
                                                      <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' title='15% on progress'></div>
                                                    </div><b>PENDING 15%</b>";
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
                                                          <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'>100%</div>
                                                        </div><b>COMPLETED</b>";
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                                    <!-- <button type="submit" name="resubmit" class="btn btn-success">Update <i class="fas fa-check-circle"></i></button> -->
                                </div>
                              </form> <!-- end of form -->
                            </div>
                          </div>
                        </div>
                        <!-- </div> end tag of modal -->

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


<!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" style="text-decoration: none;" href="#page-top">
        <i class="fas fa-"></i>
        <i class="fas fa-angle-up"></i>
        <i class="fas fa-"></i>
    </a>


</script> -->

<!-- Message Box JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

<script>

</script>


<!-- Logout Modal-->
<?php 
include('includes/logout-modal.php');
?>
<?php
include('includes/scripts.php');
include('includes/footer.php');
?>
