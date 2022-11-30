<?php
include 'includes/db_connect.php';
session_start();

if (isset($_POST["submit"])) {
    // code...
    $id = $_POST['id'];
    $task_code = $_POST['task_code'];

    $remarks = $_POST['remarks'];
    $comments = $_POST['comments'];

    $sql = "UPDATE tbl_students_work SET remarks='$remarks', comment='$comments' WHERE id='$id' and task_code='$task_code'";

    $query_run = mysqli_query($conn, $sql);

    if($query_run)
    {
        header('location: my_stud_requirements_completed_sent_to_PH.php');
    }
}
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
                        <a class="collapse-item active" href="my_stud_requirements_completed_sent_to_PH.php">Forwarded
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
        <h1 class="h3 mb-0 text-gray-800"><span><b>Student Requirements</b> / Submitted / Forwarded to Program Head </span></h1>
    </div>

    <style>
        #instructions {
            border: 1px solid gray;
            color: #333333;
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
        #stud_comment{
            border: 1px solid gray;
            color: #333333;
            /*resize: none;*/
            border-top: none;
            border-left: none;
            border-right: none;
            border-bottom: 4px solid #006bb3;
        }
        #stud_comment:focus {
            border-bottom: 4px solid #006bb3;
            box-shadow: none;
            outline-offset: 0px;
            outline: none;
            color: black;
        }
        #my_comments{
            border: 1px solid gray;
            color:  #333333;
            background: white;
        }
        #my_comments:focus {
            border: 1px solid #006bb3;
            box-shadow: none;
            outline-offset: 0px;
            outline: none;
            color:  #333333;
            background: white;
        }
        #remarks{
            border: 1px solid gray;
            color:  #333333;
        }
        #remarks:focus {
            border: 1px solid #006bb3;
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
    </style>

    <!-- Show Table Area -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="my_stud_requirements_already_completed.php" class="btn btn-sm btn-success shadow-sm " title="Completed Requirements"><i class="fas fa-check-circle"></i> Completed Requirements</a>

            <a href="my_stud_requirements_completed_sent_to_PH.php" class="btn btn-sm btn-primary shadow-sm active" title="Requirements Already Forwarded to Program Head"><i class="fas fa-file-export"></i> Requirements Forwarded to Program Head</a>

            <a href="my_stud_requirements_completed.php" class="btn btn-sm btn-info shadow-sm" title="Submitted Requirements"><i class="fas fa-file-alt"></i> Submitted Requirements</a>

            <a href="my_stud_requirements_pending.php" class="btn btn-sm btn-warning shadow-sm" title="Pending Requirements"><i class="fas fa-clipboard-list"></i> Not Yet Submitted Requirements</a>
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
        <div class="card-header py-3" style="background: #595959;">
        <?php ?>
            <h6 class="m-0 font-weight-bold" style="color: ghostwhite;">
                <i class="fas fa-file-export"></i> My Students' Requirements that are already forwarded to PROGRAM HEAD.
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table" id="dataTable" width="100%"  cellspacing="10"  id="example" style="color:  #333333;">
                  <thead>
                    <tr>
                      <th hidden=""> TASK CODE</th>
                      <th hidden="">ID</th>
                      <th>Student</th>
                      <th hidden>Course</th>
                      <th>Requirement</th>
                      <th>Submitted File</th>
                      <th hidden="">Due Date</th>
                      <th>Turned In</th>
                      <th>My Remarks</th>
                      <th>Status</th>
                      <th>Action</th>                      
                    </tr>
                  </thead>
                  <tbody>
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
                        ORDER by id ASC";
                    $query = $conn->query($sql);
                    while($row = $query->fetch_assoc()){
                        $id = $row['id'];
                        $task_code = $row['task_code'];
                        $_SESSION['task_id_22'] = $row['id'];
                    ?>
                    <tr id="tra">
                       <td hidden=""><?php echo $task_code;?> </td> 
                       <td hidden=""><?php 
                            $_SESSION['t_id_works11'] = $_SESSION['task_id_22'];
                            echo $_SESSION['t_id_works11'];
                        ?>  
                      </td>
                      <td width="20%"><?php echo $row['stud_name_and_id']; ?></td>
                      <td hidden><?php echo $row['course'];?> </td>
                      <td><?php echo $row['title'];?> </td>
                      <td width="20%"><b><a href="../students/upload_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File"><i class="fa fa-file"></i><?php echo $row['uploaded_file'];?></a></b></td>
                      <td width="10%" hidden=""><?php echo $row['date_of_submission'];?> </td>
                      <td width="10%">
                        <?php
                            //detect the due dates
                            date_default_timezone_set('Asia/Manila'); 
                            $date = date('Y-m-d');
                            $submission = $row['date_of_submission'];
                            if($row['date_submitted_1'] > $submission){
                                echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-danger'>LATE</span>";
                            }
                            else{
                                echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-success'>ON-TIME</span>";
                            }
                        ?> 
                        </td>
                        <td width="10%">
                        <?php 
                            if($row['remarks'] == 'waiting') {
                                echo "<span style='font-size: 15px; margin-left: 0px; color: gray;' class='badge badge-pill badge-warning'>WAITING</span>";
                            }

                            if($row['remarks'] == 'Not Approved') {
                                echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-danger'>NOT APPROVED</span>";
                            }

                            if($row['remarks'] == 'Approved') {
                                echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-success'>APPROVED</span>";
                            }
                        ?>
                      </td>
                      <td width="15%">
                        <?php 
                            if($row['work_status'] == 'pending') {
                                echo "<div class='progress'>
                                      <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' title='15% on progress'>15%</div>
                                    </div><b>PENDING</b>";
                            }

                            if($row['work_status'] == 'semi-pending') {
                                echo "<div class='progress'>
                                          <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' title='25% on progress' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'>25%</div>
                                        </div><b>PENDING</b>";
                            }

                            if($row['work_status'] == 'semi-pending2') {
                                echo "<div class='progress'>
                                          <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'>50%</div>
                                        </div><b>PENDING</b>";
                            }

                            if($row['work_status'] == 'semi-pending3') {
                                echo "<div class='progress'>
                                          <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'>75%</div>
                                        </div><b>PENDING</b>";
                            }

                            if ($row['work_status'] == 'completed') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'>100%</div>
                                        </div><b>COMPLETED</b>";
                            }
                        ?>
                      </td>
                      <td width="10%">
                          <a href="#view<?php echo $id;?>" title="View Submitted Requirement" data-toggle="modal"><button class="btn btn-info"><i class="fas fa-eye"></i></button></a>
                      </td>

                        <!-- View Modal -->
                        <div class="modal fade bd-example-modal-lg" data-backdrop="static" id="view<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="update_place" aria-hidden="true">
                          <div class="modal-dialog modal-lg" role="document" style="color:  #333333;">
                            <div class="modal-content modal-lg">
                              <div class="modal-header modal-lg">
                                <h5 class="modal-title" id="exampleModalLabel"><h style="color: #0d6efd"><i class="fas fa-user-check"></i>   Forwarded To Program Head / <?php echo $row['title']; ?> </h><span><?php //echo $row['edited']; ?></span></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-header modal-lg">
                                    <p class="modal-title" id="exampleModalLabel">
                                    <h title="Date and Time Forwarded"><i style="color: #1a8cff;" class="fas fa-clock"></i> <?php echo $row['program_head_forward_date']; ?> <?php echo $row['edited_by_student'];?></h></p> 
                                </div>
                              <form action="" method="POST" enctype="multipart/form-data"><!-- form start -->
                              <input type="text" class="form-control" name="id" value="<?php echo $id;?>" hidden>
                              <input type="text" name="task_code" value="<?php echo $task_code;?>" hidden>
                                <div class="modal-body modal-lg">
                                    <div class="form-group">
                                        <label>Submitted by: </label> <br>
                                        <b> <?php echo $row['stud_name_and_id']; ?> </b>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <label>Course, Year & Section: </label> <br>
                                        <b> <?php echo $row['course']; ?> </b>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <label>Instructions: </label> <br>
                                        <textarea style="background: ghostwhite;" rows="10" name="instructions" class="form-control" id="instructions" aria-describedby="" readonly required=""><?php echo $row['instructions'];?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Submitted File</label>: <?php //echo $row['edited_by_student'];?><br>
                                        <b><a href="../students/upload_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File">
                                            <i class="fa fa-file"></i><?php echo $row['uploaded_file'];?></a>
                                        </b>
                                    </div>
                                    <div class="form-group">
                                        <div class="embed-responsive embed-responsive-1by1">
                                            <iframe class="embed-responsive-item" src="../students/upload_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <label>Status: </label> <br>
                                        <?php 
                                            if ($row['work_status'] == 'pending') {
                                                echo "<div class='progress'>
                                                        <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' title='15% on progress'></div>
                                                    </div><b>PENDING 15%</b>";
                                            }

                                            if ($row['work_status'] == 'semi-pending') {
                                                    echo "<div class='progress'>
                                                            <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' title='25% on progress' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
                                                        </div><b>PENDING 25%</b>";
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
                                    </div>
                                    <hr>
                                    <!-- selecting and concatenating the date and time from tbl_students_work -->
                                    <?php 
                                        session_start();
                                        $task_id = $_SESSION['t_id_works11'];
                                        $sql1 = "SELECT Concat(date_submitted,' ',time_submitted) AS dateTTime1 FROM tbl_students_work where id='$task_id'";
                                        $query1 = $conn->query($sql1);
                                        while($row1 = $query1->fetch_assoc()){
                                            $_SESSION['datetime222'] = $row1['dateTTime1'];
                                        }
                                    ?>
                                    <div class="form-group">
                                        <label>My Remarks:</label> <br>
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
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <label>Comment: </label> <br>
                                        <textarea style="background: ghostwhite;" readonly="" id="stud_comment" name="comments" class="form-control" rows="5" placeholder=""><?php echo $row['student_comment']; ?></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                                   <!--  <button type="submit" name="submit" class="btn btn-primary">Submit Your Comment <i class="fas fa-comment"></i></button> -->
                                </div>
                              </form> <!-- end of form -->
                            </div>
                          </div>
                        </div>
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
    <a class="scroll-to-top rounded" style="text-decoration:none;" href="#page-top">
        <i class="fas fa-"></i>
        <i class="fas fa-angle-up"></i>
        <i class="fas fa-"></i>
    </a>

<!-- Message Box JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

<script>
$('.undo-btn').on('click',function(e){
    e.preventDefault();
    const href = $(this).attr('href') 
    Swal.fire({
        title: 'Are you sure to undo this forwarded requirement?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, undo it!'
        }).then((result) => {
            if (result.value) {
                document.location.href = href;
                
            }
        })
 })
</script>

<?php
include('includes/logout-modal.php');
include('includes/scripts.php');
include('includes/footer.php');
?>
