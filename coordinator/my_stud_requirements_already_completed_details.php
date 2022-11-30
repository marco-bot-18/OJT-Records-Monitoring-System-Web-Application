<?php
    // code for update the read notification status
    include('includes/session.php');
    require_once('includes/db_connect_pdo.php'); 
    $isread=1;
    $completed = "completed";
    $did=intval($_GET['req_id']);
    date_default_timezone_set('Asia/Manila');
    $admremarkdate=date('Y-m-d G:i:s ', strtotime("now"));
    $sql="update tbl_students_work set isReadTeacher1=:isread where id=:did and work_status=:completed";
    $query = $dbh->prepare($sql);
    $query->bindParam(':isread',$isread,PDO::PARAM_STR);
    $query->bindParam(':did',$did,PDO::PARAM_STR);
    $query->bindParam(':completed',$completed,PDO::PARAM_STR);
    $query->execute();
?>

<?php
    // code for update the read all notification status
    include('includes/session.php');
    require_once('includes/db_connect_pdo.php'); 
    $isread=1;
    if (isset($_POST['read_all'])) {
        date_default_timezone_set('Asia/Manila');
        $completed = "completed";
        $teacher_name = $_SESSION['coordinator_fname']." ".$_SESSION['coordinator_mname']." ".$_SESSION['coordinator_lname']." (".$_SESSION['coordinator_id'].")";
        $admremarkdate=date('Y-m-d G:i:s ', strtotime("now"));
        $sql="update tbl_students_work set isReadTeacher1=:isread where name_of_teacher=:teacher_name and work_status=:completed";
        $query = $dbh->prepare($sql);
        $query->bindParam(':isread',$isread,PDO::PARAM_STR);
        $query->bindParam(':teacher_name',$teacher_name,PDO::PARAM_STR);
        $query->bindParam(':completed',$completed,PDO::PARAM_STR);
        $query->execute();
    }
?>

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
        header('location: my_stud_requirements_completed_sent_to_PH.php?updated=1');
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
                        <a class="collapse-item" href="students_category.php">Categories</a>
                    </div>
                </div>  
            </li>

            <!-- <li class="nav-item">
                <a class="nav-link" href="my_subjects.php">
                    <i class="fas fa-book"></i>
                    <span>Subjects</span></a>
            </li> -->

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
                    <span>Student Requirements</span>
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
                                $myfullname_ = $_SESSION['coordinator_fullname_session'];
                                $work_stats = "semi-pending2";
                                $stats = "not archived";
                                $submitted = "yes";
                                $count = 1;
                                $sql = "SELECT * from tbl_students_work where name_of_teacher='$myfullname_' and work_status='$work_stats' and submitted='$submitted' and status='$stats'";
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
            <li class="nav-item">
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
        <!-- End of Sidebar -->
    
        <?php 
        include('includes/topbar.php');
        ?>

    <style>
        #instructions {
            border: 1px solid gray;
            color: #333333;
            resize: none;
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
            color: #333333;
            resize: none;
            border-top: none;
            border-left: none;
            border-right: none;
            border-bottom: 4px solid #006bb3;
        }
        #comments:focus {
            border-bottom: 4px solid #006bb3;
            box-shadow: none;
            outline-offset: 0px;
            outline: none;
            color: black;
        }
        #my_comments{
            border: 1px solid gray;
            color: #333333;
            resize: none;
            border-top: none;
            border-left: none;
            border-right: none;
            border-bottom: 4px solid #006bb3;
        }
        #my_comments:focus {
            border-bottom: 4px solid #006bb3;
            box-shadow: none;
            outline-offset: 0px;
            outline: none;
            color: black;
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
            color:  blacK;
        }
        #tra{
            color:  #333333;
        }
        #tra:hover {
            color: black;
            background: #f2f2f2;
        }
    </style>
 
<div class="container-fluid">
<?php
    require_once('includes/db_connect.php');
    $work_stats1 = "completed";
    $stats = "not archived";
    $submitted = "yes";
    $did=intval($_GET['req_id']);//uniq id of requirement
    $my_fullname_ = $_SESSION['coordinator_fullname_session'];
    $sql = "SELECT * from tbl_students_work where id='$did'";
    $query = $conn->query($sql);
    while($row = $query->fetch_assoc()){
        $id = $row['id'];
        $task_code = $row['task_code'];
        $_SESSION['task_id_22'] = $row['id'];
    ?>
<!-- Page Heading -->
    
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><span><a class="h3 mb-0 text-gray-800" href="my_stud_requirements_already_completed.php"><b>Student Submittals</b></a> / Submitted Requirements / Completed / <b style="color: #1a8cff;"><?php echo $row['title']; ?></b> </span></h1>
    </div>

    
    <!-- Show Table Area -->
    <div class="card shadow mb-4">

       <!--  <div class="card-header py-3">
        <?php ?>
            <h6 class="m-0 font-weight-bold text-primary">
                Filter 
            </h6>
        </div> -->
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <h style="color: #333333; font-size: 18px;">Want to create a requirement?</h><br><br>
                <a class="btn btn-primary" title="Click Here to Create A Requirement for Your Students" href="my_requirements_for_students.php">
                    Click Here <i class="fas fa-plus-square"></i>
                </a>
            </h6>
        </div>
        <!-- <div class="card-header py-3">
            <a href="my_stud_requirements_already_completed.php" class="btn btn-sm btn-dark shadow-sm" title="Back to List"><i class="fas fa-long-arrow-alt-left"></i> Back To List</a>
        </div> -->
        <div class="card-header py-3" style="background: #595959;">
            <h6 class="m-0 font-weight-bold" style="color: ghostwhite;">
                <i class="fas fa-check-circle"></i> Requirement Details
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table" id="dataTable" width="100%" cellspacing="10"  id="example" style="color:  #333333;">
                    <tr id="tra">
                        <td style="font-size:16px;"> <b>Submitted by :</b><br>
                         <?php echo $row['stud_name_and_id']; ?></td>
                    </tr>
                    <tr id="tra">
                        <td style="font-size:16px;"> <b>Title :</b>
                            <br><?php echo $row['title'];?></td>
                    </tr>
                    <tr id="tra">
                        <td style="font-size:16px;"> <b>Instructions :</b>
                            <br>
                        <textarea readonly="" style="background: ghostwhite;" name="comments" class="form-control" id="comments" rows="5"><?php echo $row['instructions'];?></textarea>
                    </tr>
                    <tr id="tra">
                        <td style="font-size:16px;"> <b>Submitted File :</b>
                        <br> <?php if($row['title'] == "Recommendation Letter") {?><b><a href="../admin/signed_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File"> <i class="fa fa-file"></i><?php echo $row['uploaded_file'];?></a></b> <br><br>
                            <div class="embed-responsive embed-responsive-1by1">
                              <iframe style="width: 70%; margin-left: 15%;" class="embed-responsive-item" src="../admin/signed_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                            </div>
                            <?php } else {?> <b><a href="../students/upload_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File"><?php echo $row['uploaded_file'];?></a></b>
                            <div class="embed-responsive embed-responsive-1by1">
                              <iframe class="embed-responsive-item" style="width: 60%; margin-left: 20%;" src="../students/upload_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                            </div>
                            <?php } ?>
                        </div>
                        </td>
                    </tr>

                    <tr id="tra">
                        <td>
                            <label><b>Comment :</b></label> <br>
                            <textarea readonly="" style="background: ghostwhite;" name="comments" class="form-control" id="comments" rows="5"><?php echo $row['student_comment']; ?></textarea>   
                        </td>
                    </tr>

                    <tr id="tra">
                        <td style="font-size:16px;"><b>Date of Submission :</b>
                            <br><?php echo $row['date_of_submission'];?> 
                        </td>
                    </tr>
                    <tr id="tra">
                        <td style="font-size:16px;">
                            <b>Turned In:</b> <br>
                            <?php
                            //detect the due dates
                                date_default_timezone_set('Asia/Manila'); 
                                $date = date('Y-m-d');
                                $submission = $row['date_of_submission'];
                                if($row['date_submitted_1'] > $submission){
                                    echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-danger'>LATE</span>";
                                }
                                else{
                                    echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-success'>ON-TIME</span>";;
                                }
                            ?> 
                        </td>
                    </tr>

                    <tr id="tra">
                        <td style="font-size:16px;"><b>My Remarks :</b>
                            <br><?php 
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
                    </tr>

                    <tr id="tra">
                        <td style="font-size:16px;"><b>Status :</b>
                            <br>
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
                    </tr>

                    <tr id="tra">
                        <td>
                            <i style="color: #1a8cff;" class="fas fa-clock"></i>
                            <h title="DATE AND TIME COMPLETED"> <?php echo  $row['completed_date'];?> </h><br>
                        </td>
                    </tr>

                        <!-- View Modal -->
                        <div class="modal fade bd-example-modal-lg" data-backdrop="static" id="view<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="update_place" aria-hidden="true">
                          <div class="modal-dialog modal-lg" role="document" style="color:  #333333;">
                            <div class="modal-content modal-lg">
                              <div class="modal-header modal-lg">
                                <h5 class="modal-title" id="exampleModalLabel"><?php echo $row['title'];?> </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <form action="my_stud_requirements_completed_update.php" method="POST" enctype="multipart/form-data"><!-- form start -->
                              <input type="text" class="form-control" name="id" value="<?php echo $id;?>" hidden>
                              <input type="text" name="task_code" value="<?php echo $task_code;?>" hidden>
                                <div class="modal-body modal-lg">
                                    <!-- <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-md"> -->
                                                <div class="form-group">
                                                    <label>Submitted by : </label> <br>
                                                    <b> <?php echo $row['stud_name_and_id']; ?> </b>
                                                    <input type="text" name="stud_fullname" value="<?php echo $row['stud_name_and_id']; ?>" hidden>
                                                    <input type="text" name="requirement" value="<?php echo $row['title']; ?>" hidden>
                                                </div> 
                                                
                                                <hr>
                                                <div class="form-group">
                                                    <label>Comment :</label> <br>
                                                    <textarea style="background: ghostwhite;" readonly="" name="comments" class="form-control" id="comments" rows="5"><?php echo $row['student_comment']; ?></textarea>
                                                </div>
                                            <!-- </div> -->
                                            <!-- <div class="col-md"> -->
                                                <div class="form-group">
                                                    <label>My Remarks : </label> <br>
                                                    <select style="background: white;" name="remarks" id="remarks" class="form-control">
                                                        <?php
                                                            if($row['remarks']=="Approved"){
                                                                echo "<option name='approved'>Approved</option>";
                                                                echo "<option name='not approved'>Not Approved</option>";
                                                            }

                                                            if($row['remarks']=="Not Approved"){
                                                                 echo "<option name='not approved'>Not Approved</option>";
                                                                echo "<option name='approved'>Approved</option>";
                                                            }
                                                            if($row['remarks']=="waiting"){
                                                                echo "<option name='approved'>Approved</option>";
                                                                echo "<option name='not approved'>Not Approved</option>";
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                                <hr>
                                                <div class="form-group">
                                                    <label>My Comments and Suggestions :</label> <br>
                                                    <textarea style="background: white;" name="comments" class="form-control" rows="5" id="my_comments" placeholder="Enter Your Comments and Suggestions Here"><?php echo $row['comment']; ?></textarea>
                                                </div>
                                            <!-- </div>
                                        </div>
                                    </div> -->
                                </div>
                                <div class="modal-footer">
                                     <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                                </div>
                              </form> <!-- end of form -->
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
                    <?php  } ?> 
                  </tbody>
                </table>
            </div>
        </div>
        </div>
    </div>
</div>

<!-- fetch data form dropdown list of requirements -->
<script type="text/javascript">
    $(document).ready(function(){
        $("#fetchval").on('change', function(){
            var value = $(this).val();
            $.ajax({
                url:"my_stud_requirements_already_completed_fetch.php",
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



<!-- flash data for update -->
<?php 
if(isset($_GET['updated'])){ ?>
    <div class="flash-data3" data-flashdata="<?php echo $_GET['updated'];?>"></div>
<?php } 
    unset($_GET['updated']);
?>

<!-- flash data for save -->
<?php 
if(isset($_GET['created'])){ ?>
    <div class="flash-data2" data-flashdata="<?php echo $_GET['created'];?>"></div>
<?php } 
    unset($_GET['created']);
?>

<!-- flash data for delete -->
<?php 
if(isset($_GET['deleted'])){ ?>
    <div class="flash-data1" data-flashdata="<?php echo $_GET['deleted'];?>"></div>
<?php } 
    unset($_GET['deleted']);
?>

<!-- flash data for unpublished -->
<?php 
if(isset($_GET['forwarded'])){ ?>
    <div class="flash-data4" data-flashdata="<?php echo $_GET['forwarded'];?>"></div>
<?php } 
    unset($_GET['forwarded']);
?>

<!-- flash data for unpublished -->
<?php 
if(isset($_GET['published'])){ ?>
    <div class="flash-data5" data-flashdata="<?php echo $_GET['published'];?>"></div>
<?php } 
    unset($_GET['published']);
?>

    <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" style="text-decoration: none;" href="#page-top">
            <i class="fas fa-"></i>
            <i class="fas fa-angle-up"></i>
            <i class="fas fa-"></i>
        </a>


<!-- <script type="text/javascript">
  function showmsg()
  {
    var a = document.getElementById('event_title').value;
    var b = document.getElementById('event_description').value;
    var c = document.getElementById('event_date').value;
    var d = document.getElementById('image_').value;
    if (a != '' && b != '' && c != '' && d != '') {}
        swal("Good job!", "Login Success!", "success");
  }
</script> -->

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
         title : 'Student Requirement is Now Set as Completed',
         text : 'Requirement is now completed!'
     })
 }

 const flashdata4 = $('.flash-data4').data('flashdata')
 if(flashdata4){
     swal.fire({
         icon: 'success',
         type : 'success',
         title : 'Requirement Successfully Forwarded to Program Head',
         text : 'Requirement has been forwarded! Go to the documents that are sent to PROGRAM HEAD'
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
?>
<?php
include('includes/scripts.php');
include('includes/footer.php');
?>

<script type="text/javascript">
$(document).ready(function(){
    $('#insert').click(function){
        var img_name = $('#image').val();
        if (img_name == '') {
            alert('Please Select an Image!');
            return false;
        }
        else {
            var extension = $('#image').val().split('.').pop().toLowerCase();
            if (jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
                alert('Invalid Image File');
                $('$image').val('');
                return false;
            }
        }
    }
});
</script>