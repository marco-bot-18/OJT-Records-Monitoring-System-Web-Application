<?php
    include('includes/session.php');
    require_once('includes/db_connect_pdo.php');

    // code for update the read notification status
    $teacher_name = $_SESSION['coordinator_fname']." ".$_SESSION['coordinator_mname']." ".$_SESSION['coordinator_lname']." (".$_SESSION['coordinator_id'].")";
    $isread=1;
    $did=intval($_GET['req_id']);
    date_default_timezone_set('Asia/Manila');
    $admremarkdate=date('Y-m-d G:i:s ', strtotime("now"));
    $sql="update tbl_students_work set isReadTeacher=:isread where id=:did and name_of_teacher=:teacher_name";
    $query = $dbh->prepare($sql);
    $query->bindParam(':isread',$isread,PDO::PARAM_STR);
    $query->bindParam(':did',$did,PDO::PARAM_STR);
    $query->bindParam(':teacher_name',$teacher_name,PDO::PARAM_STR);
    $query->execute();

    // code for update the read all notification status
    $isread = 1;
    if (isset($_POST['read_all'])) {
        date_default_timezone_set('Asia/Manila');
        $completed = "completed";
        $teacher_name = $_SESSION['coordinator_fname']." ".$_SESSION['coordinator_mname']." ".$_SESSION['coordinator_lname']." (".$_SESSION['coordinator_id'].")";
        $admremarkdate=date('Y-m-d G:i:s ', strtotime("now"));
        $sql="update tbl_students_work set isReadTeacher=:isread where name_of_teacher=:teacher_name";
        $query = $dbh->prepare($sql);
        $query->bindParam(':isread',$isread,PDO::PARAM_STR);
        $query->bindParam(':teacher_name',$teacher_name,PDO::PARAM_STR);
        $query->execute();
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
                <div class="sidebar-brand-text"> &nbsp;OJTRMS</div>
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

             <!-- Nav Item - Collapse Menu -->
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
<?php
    require_once('includes/db_connect.php');
    $work_stats = "semi-pending";
    $stats = "not archived";
    $did=intval($_GET['req_id']);
    $submitted = "yes";
    $count = 1;
    $my_fullname_ = $_SESSION['coordinator_fullname_session'];
    $sql = "SELECT * from tbl_students_work where id='$did'";
    $query = $conn->query($sql);
    while($row = $query->fetch_assoc()){
        $id = $row['id'];
        $task_code = $row['task_code'];
        $_SESSION['task_id_22'] = $row['id'];
?>
    
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><span><a href="my_stud_requirements_completed.php" class="h3 mb-0 text-gray-800"><b>Student Requirements</b></a> / Submitted Requirements / <b style="color: #0d6efd"><?php echo $row['title'];?></b> </span></h1>
    </div>

    <style>
         #instructions {
            border: 1px solid gray;
            color: black;
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
            color: black;
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
            color:  #333333;
            background: white;
        }
        #my_comments:focus {
            border: 1px solid #006bb3;
            box-shadow: none;
            outline-offset: 0px;
            outline: none;
            color:  black;
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
        
    </style>

    <!-- Show Table Area -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
        <?php ?>
            <h6 class="m-0 font-weight-bold text-primary" >
                If necessary, you might forward this requirement to the PROGRAM HEAD for approval.
            </h6>
        </div>
        <div class="card-header py-3" style="background: #595959;">
            <h6 class="m-0 font-weight-bold" style="color: ghostwhite;">
                <i class="fas fa-file-alt"></i> Submitted Requirement Details
            </h6>
        </div>
        <div class="card-header py-3">
             <a href="#view<?php echo $id;?>" title="Check Submitted Requirement" data-toggle="modal" ><button class="btn btn-info"><i class="fas fa-check-square"></i> Check</button></a>
              <?php if($row['remarks']=="Approved"){ ?>
              <a href="#forward<?php echo $id;?>" title="Forward to Program Head" data-toggle="modal" ><button class="btn btn-primary"><i class="fas fa-share-square"></i> Forward</button></a>
               <?php } ?>
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
                        <textarea readonly="" style="background: ghostwhite;" name="instructions" class="form-control" id="instructions" rows="5"><?php echo $row['instructions'];?></textarea>
                    </tr>
                    <tr id="">
                        <td style="font-size:16px;"> <b>Submitted File :</b>
                        <br><?php if($row['uploaded_file'] != ""){?><b><a href="../students/upload_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File"><i class="fas fa-file"></i><?php echo $row['uploaded_file'];?></a></b><?php } else { echo "<font style='color: red;'>There's no attached file</font>"; }?>
                        <br><br>
                        <div class="embed-responsive embed-responsive-1by1" style="width: 60%; margin-left: 20%;">
                          <iframe class="embed-responsive-item" src="../students/upload_docs/<?php echo $row['uploaded_file'];?>"></iframe>
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
                                 echo "<span style='font-size: 15px; margin-left: 0px; color: gray;' class='badge badge-pill badge-warning'>ON REVIEW</span>";
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
                                          <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' title='25% on progress' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'>25%</div>
                                        </div><b>PENDING</b>";
                            }

                            if ($row['work_status'] == 'semi-pending2') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'>50%</div>
                                        </div><b>PENDING</b>";
                            }

                            if ($row['work_status'] == 'semi-pending3') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'>75%</div>
                                        </div><b>PENDING</b>";
                            }

                            if ($row['work_status'] == 'completed') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'></div>
                                        </div><b>COMPLETED 100%</b>";
                            }
                        ?>
                        </td>
                    </tr>
                    <tr id="">
                        <td>
                            <i style="color: #1a8cff;" class="fas fa-clock"></i>
                            <b title="DATE AND TIME SUBMITTED"> <?php echo  $row['date_submitted']." at ".$row['time_submitted']?> </b>
                            <?php if ($row['edited_by_student']=="(edited)") {?>
                            <?php echo $row['edited_by_student']; ?></span></b>
                            <?php } else {
                                echo "";
                            }?>
                        </td>
                    </tr>


                        <!-- View Modal -->
                        <div class="modal fade bd-example-modal-lg" data-backdrop="static" id="view<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="update_place" aria-hidden="true">
                          <div class="modal-dialog modal-lg" role="document" style="color:  #333333;">
                            <div class="modal-content modal-lg">
                              <div class="modal-header modal-lg">
                                <h5 class="modal-title" id="exampleModalLabel"><h style="color: #0d6efd"><i class="fas fa-file-alt"></i> <?php echo $row['title']; ?> </h><span><?php //echo $row['edited']; ?></span></h5>
                                   
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
                                                    <textarea style="background: white;" name="comments" class="form-control" onkeypress="return alpha(event)" rows="5" id="my_comments" placeholder="Write Your Comments and Suggestions Here (Optional)"><?php echo $row['comment']; ?></textarea>
                                                </div>
                                            <!-- </div>
                                        </div>
                                    </div> -->
                                </div>
                                <div class="modal-footer">
                                    <?php if($row['remarks']=="Approved"){ ?>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                                    <button type="submit" name="submit_1" class="btn btn-primary">Re-Submit
                                    <i class="fas fa-check-square"></i></button> 
                                    <button type="submit" name="set_as_completed_1" class="btn btn-success">Set As Completed <i class="fas fa-check-square"></i></button>
                                    <?php } else {?>
                                     <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                                    <button type="submit" name="submit_1" class="btn btn-primary">Submit
                                    <i class="fas fa-check-square"></i></button>
                                    <?php } ?>
                                </div>
                              </form> <!-- end of form -->
                            </div>
                          </div>
                        </div>

                        <!-- Forward Modal -->
                        <div class="modal fade bd-example-modal-lg" data-backdrop="static" id="forward<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="update_place" aria-hidden="true">
                          <div class="modal-dialog modal-lg" role="document" style="color:  #333333;">
                            <div class="modal-content modal-lg">
                              <div class="modal-header modal-lg">
                                <h5 class="modal-title" id="exampleModalLabel"><h style="color: #0d6efd"><i class="fas fa-file-export"></i> <?php echo $row['title']; ?> (Forward to Program Head) </h><span></span></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <form action="my_stud_requirements_completed_update.php" method="POST" enctype="multipart/form-data"><!-- form start -->
                              <input type="text" class="form-control" name="id" value="<?php echo $id;?>" hidden>
                              <!-- task code uniq id -->
                              <input type="text" name="task_code" value="<?php echo $task_code;?>" hidden>
                                <div class="modal-body modal-md">
                                    <!-- <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-md"> -->
                                                <div class="form-group">
                                                    <label>Submitted by : </label> <br>
                                                    <b><?php echo $row['stud_name_and_id']; ?> </b>
                                                    <input type="text" hidden="" name="stud_fullname" value="<?php echo $row['stud_name_and_id']; ?>">
                                                </div>
                                                <hr>
                                                <div class="form-group">
                                                    <label>Requirement : </label> <br>
                                                    <b> <?php echo $row['title']; ?> </b>
                                                    <input type="text" hidden="" name="requirement" value="<?php echo $row['title']; ?>">
                                                </div>
                                                <hr>
                                            <!-- </div>
                                            <div class="col-md"> -->
                                                <div class="form-group">
                                                    <label>Submitted File</label> : <?php //echo $row['edited_by_student'];?><br>
                                                    <b><a href="../students/upload_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File">
                                                        <i class="fa fa-file"></i><?php echo $row['uploaded_file'];?></a>
                                                    </b>
                                                </div>
                                                <div class="form-group">
                                                    <div class="embed-responsive embed-responsive-1by1">
                                                      <iframe class="embed-responsive-item" src="../students/upload_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                                                    </div>
                                                </div>
                                            <!-- </div>
                                           
                                        </div>
                                    </div> -->
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                                    <button type="submit" name="forward1" class="btn btn-primary">Forward <i class="fas fa-share-square"></i></button>
                                </div>
                              </form> <!-- end of form -->
                            </div>
                          </div>
                        </div>
                        <!-- </div> end tag of modal -->

                    </div> 
                    <!-- end tag modal -->
                    </tr>
                    <?php } ?> 
                  </tbody>
                </table>
            </div>
        </div>
        </div>
    </div>
</div>

<!-- Message Box JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

<?php
    if (isset($_SESSION['submitted_1'])) {?>
        <script>
            swal.fire({
             icon: 'success',
             type : 'success',
             title : 'Responsed to this Student Requirement',
             text : '<?php echo $_SESSION['submitted_1']?>'
         })
        </script>
    <?php unset($_SESSION['submitted_1']);
    }

    if (isset($_SESSION['completed_error'])) {?>
        <script>
            swal.fire({
             icon: 'warning',
             type : 'warning',
             title : 'Responsed to this Student Requirement',
             text : '<?php echo $_SESSION['completed_error']?>'
         })
        </script>
    <?php unset($_SESSION['completed_error']);
    }

    if (isset($_SESSION['forwarded'])) {?>
        <script>
            swal.fire({
             icon: 'warning',
             type : 'warning',
             title : 'Requirement Successfully Forwarded to Program Head',
             text : '<?php echo $_SESSION['forwarded']?>'
         })
        </script>
    <?php unset($_SESSION['forwarded']);
    }
?>


    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" style="text-decoration:none;" href="#page-top">
        <i class="fas fa-"></i>
        <i class="fas fa-angle-up"></i>
        <i class="fas fa-"></i>
    </a>


<script>
    function alpha(e) {
        var k;
        document.all ? k = e.keyCode : k = e.which;
        // UPDATED - is CHARCODE
        //allow - sign, but cannot allow any other special chars
        return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 || (k >= 48 && k <= 57) || k == 45);
    }
</script>

<?php
    include('includes/logout-modal.php');
    include('includes/scripts.php');
    include('includes/footer.php');
?>
