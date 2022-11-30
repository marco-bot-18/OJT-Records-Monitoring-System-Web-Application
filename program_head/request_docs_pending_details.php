<?php
    // code for update the read notification status
    include('includes/session.php');
    require_once('includes/db_connect_pdo.php'); 
    $isread=1;
    $completed = "completed";
    $did=intval($_GET['req_id']);
    date_default_timezone_set('Asia/Manila');
    $admremarkdate=date('Y-m-d G:i:s ', strtotime("now"));
    $sql="update tbl_students_work set isReadPH=:isread where id=:did";
    $query = $dbh->prepare($sql);
    $query->bindParam(':isread',$isread,PDO::PARAM_STR);
    $query->bindParam(':did',$did,PDO::PARAM_STR);
    $query->execute();
?>

<?php
    // code for update the read all notification status
    include('includes/session.php');
    require_once('includes/db_connect_pdo.php'); 
    $isread=1;
    if (isset($_POST['read_all'])) {
        date_default_timezone_set('Asia/Manila');
        $admremarkdate=date('Y-m-d G:i:s ', strtotime("now"));
        $sql="update tbl_students_work set isReadPH=:isread";
        $query = $dbh->prepare($sql);
        $query->bindParam(':isread',$isread,PDO::PARAM_STR);
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
                <a class="nav-link" href="students_list.php">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Students</span></a>
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
                            <span class="badge badge bg-danger" style="color: white;">
                                <?php
                                    $program_head_name = $_SESSION['coordinator_fullname_session'];
                                    $work_stats = "semi-pending2";
                                    $send_to_PH = "program head";
                                    $stats = "not archived";
                                    $submitted = "yes";
                                    $count = 1;
                                    $sql = "SELECT * from tbl_students_work where name_of_program_head='$program_head_name' and send_to_PH='$send_to_PH' and work_status='$work_stats' and submitted='$submitted' and status='$stats'";
                                    $query = $conn->query($sql);
                                    echo $query->num_rows;
                                ?>
                            </span>
                        </a>
                        <a class="collapse-item" href="request_docs_completed.php">Approved
                            <span class="badge badge bg-danger" style="color: white;">
                                <?php
                                    $name_of_program_head = $_SESSION['coordinator_fullname_session'];
                                    $work_stats = "semi-pending3";
                                    $work_stats1 = "completed";
                                    $send_to_dean = "dean";
                                    $stats = "not archived";
                                    $send_to_PH = "program head";
                                    $submitted = "yes";
                                    $count = 1;
                                    $sql = "SELECT * from tbl_students_work where (name_of_program_head='$name_of_program_head' and send_to_PH='$send_to_PH' and send_to_dean='$send_to_dean' and work_status='$work_stats' and submitted='$submitted' and status='$stats') 
                                        OR 
                                        (name_of_program_head='$name_of_program_head' and send_to_PH='$send_to_PH' and send_to_dean='$send_to_dean' and work_status='$work_stats1' and submitted='$submitted' and status='$stats')";
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
    <?php
        require_once('includes/db_connect.php');
        $work_stats = "semi-pending2";
        $send_to_PH = "program head";
        $stats = "not archived";
        $submitted = "yes";
        $count = 1;
        $did=intval($_GET['req_id']);
        $sql = "SELECT * from tbl_students_work where id='$did'";
        $query = $conn->query($sql);
        while($row = $query->fetch_assoc()){
            $id = $row['id'];
            $task_code = $row['task_code'];
            $_SESSION['task_id_22'] = $row['id'];
        ?>
<!-- Page Heading -->
    
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><span><a href="request_docs_pending.php" class="h3 mb-0 text-gray-800"><b>Documents For Signing</b></a> / Pending / <?php echo $row['title'];?>  </span></h1>
       <!--  <a href="my_stud_requirements_completed_for_today.php" class="btn btn-sm btn-success shadow-sm" title="Click Here To See The Students Who Submitted Their Requirements for Today"><i class="fas fa-calendar-day"></i> Today</a> -->
    </div>

    <style>
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
    </style>

    <!-- Show Table Area -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Click "Insert Signature" To Sign the Document Automatically.
            </h6>
        </div>
        <div class="card-header py-3" style="background: #595959;">
            <h6 class="m-0 font-weight-bold" style="color: ghostwhite;">
                <i class="fas fa-file-alt"></i> Document Details
            </h6>
        </div>
        <div class="card-header py-3">

            <?php 
            $file_pointer = "signed_docs/"."".$row['uploaded_file'];
            if(!file_exists($file_pointer)) { ?>
                <a href="request_docs_insert_signature_1.php?file_id=<?php echo $id;?>" class="btn btn-info" target="" title="Insert Signature">Insert Signature <i class="fas fa-signature"></i></a>
            <?php } else {?>
            <a href="#forward<?php echo $id;?>" title="Forward to Dean" data-toggle="modal" ><button class="btn btn-primary">Forward <i class="fas fa-share-square"></i></button></a>
            <a href="request_docs_insert_signature_1.php?file_id=<?php echo $id;?>" class="btn btn-info" target="" title="Insert Signature">Insert Signature <i class="fas fa-signature"></i></a>
            <?php }?>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table" id="dataTable" width="100%" cellspacing="10"  id="example" style="color:  #333333;">
                    <tr id="">
                        <td style="font-size:16px;"> <b>Submitted by :</b><br>
                         <?php echo $row['stud_name_and_id']; ?></td>
                    </tr>
                    <tr id="">
                        <td style="font-size:16px;"> <b>Title :</b>
                            <br><?php echo $row['title'];?></td>
                    </tr>
                    <!-- <tr id="tra">
                        <td style="font-size:16px;"> <b>Instructions :</b>
                            <br>
                        <textarea readonly="" style="background: ghostwhite;" name="instructions" class="form-control" id="instructions" rows="5"><?php echo $row['instructions'];?></textarea>
                    </tr> -->
                    <tr id="">
                        <td style="font-size:16px;"> <b>Document :</b>
                            <br>
                            <?php 
                                $file_pointer = "signed_docs/"."".$row['uploaded_file'];
                                if (!file_exists($file_pointer)) { echo "<b style='color: red;'>The document has not yet been signed.</b><br><br>";?>
                                    <div class="embed-responsive embed-responsive-1by1" style="width: 60%; margin-left: 20%; height: 140%;">
                                      <iframe class="embed-responsive-item" src="../students/upload_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                                    </div>
                                <?php } else { ?>
                                <b><a href="signed_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="View File">
                                <i class="fas fa-file-signature"></i><?php echo $row['uploaded_file'];?> - Signed</a>
                                </b><br><br>
                                <input type="text" value="<?php echo $row['uploaded_file'];?>" name="signed_document" hidden required>
                            </div>
                            
                            <div class="form-group">
                                <div class="embed-responsive embed-responsive-1by1" style="width: 60%; margin-left: 20%; height: 140%;">
                                  <iframe class="embed-responsive-item" src="signed_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                                </div>
                            </div>
                            <?php } ?>
                        </td>
                    </tr>

                    <!-- <tr id="tra">
                        <td>
                            <label><b>Comment/s :</b></label> <br>
                            <textarea readonly="" style="background: ghostwhite;" name="comments" class="form-control" id="comments" rows="5"><?php echo $row['student_comment']; ?></textarea>   
                        </td>
                    </tr> -->

                    <!-- <tr id="tra">
                        <td style="font-size:16px;"><b>Date of Submission :</b>
                            <br><?php echo $row['date_of_submission'];?> 
                        </td>
                    </tr> -->
                    <!-- <tr id="tra">
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
                    </tr> -->

                    <tr id="">
                        <td style="font-size:16px;"><b>Remarks :</b>
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

                    <tr id="">
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
                                        </div><b>PENDING 25%</b>";
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
                                          <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'>100%</div>
                                        </div><b>COMPLETED</b>";
                            }
                        ?>
                        </td>
                    </tr>

                    <tr id="">
                        <td style="font-size:16px;"><b>Forwarded by :</b><br>
                            <?php echo $row['name_of_teacher'];?>
                        </td>
                    </tr>

                    <tr id="">
                        <td>
                            <i style="color: #1a8cff;" class="fas fa-clock"></i>
                            <b title="DATE AND TIME SUBMITTED"> <?php echo  $row['program_head_forward_date'];?> </b><br>
                        </td>
                    </tr>

                      <!-- <td width="20%">
                          <a href="#forward<?php echo $id;?>" title="Forward to Dean" data-toggle="modal" ><button class="btn btn-primary"><i class="fas fa-share-square"></i></button></a>

                          <a href="request_docs_insert_signature.php?file_id=<?php echo $id;?>" class="btn btn-info" target="" title="Insert Signature"><i class="fas fa-signature"></i></a>
                      </td> -->

                       

                        <!-- Forward Modal -->
                        <div class="modal fade bd-example-modal-lg" data-backdrop="static" id="forward<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="update_place" aria-hidden="true">
                          <div class="modal-dialog modal-lg" role="document" style="color:  #333333;">
                            <div class="modal-content modal-lg">
                              <div class="modal-header modal-lg">
                                <h5 class="modal-title" id="exampleModalLabel"><h style="color: #0d6efd"><i class="fas fa-file-alt"></i> <?php echo $row['title']; ?> / Forward To Dean </h><span><?php //echo $row['edited']; ?></span></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
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
                                                <!-- <hr>
                                                <div class="form-group">
                                                    <label>Course, Year & Section: </label> <br>
                                                    <b> <?php echo $row['course']; ?> </b>
                                                    <input type="text" hidden="" name="course" value="<?php echo $row['course']; ?>">
                                                </div> -->
                                                <hr>
                                                <div class="form-group">
                                                    <label>Requirement: </label> <br>
                                                    <b> <?php echo $row['title']; ?> </b>
                                                    <input type="text" hidden="" name="requirement" value="<?php echo $row['title']; ?>">
                                                </div>
                                                <hr>
                                                <!-- <div class="form-group">
                                                    <label>Instructions: </label> <br>
                                                    <textarea style="background: ghostwhite;" rows="10" name="instructions" class="form-control" id="instructions" aria-describedby="" readonly required=""><?php echo $row['instructions'];?></textarea>
                                                </div> -->
                                            <!-- </div>
                                            <div class="col-md"> -->
                                                <div class="form-group">
                                                    <label>Signed Document</label>: <?php //echo $row['edited_by_student'];?><br>
                                                    <?php 
                                                    $file_pointer = "signed_docs/"."".$row['uploaded_file'];
                                                    if (!file_exists($file_pointer)) { echo "<b style='color: red;'>The document has not yet been signed.</b>"; } else { ?>
                                                    <b><a href="signed_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="View File">
                                                    <i class="fas fa-file-signature"></i>
                                                    <?php echo $row['uploaded_file'];?> - Signed</a>
                                                    </b>
                                                    <input type="text" value="<?php echo $row['uploaded_file'];?>" name="signed_document" hidden required>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <div class="embed-responsive embed-responsive-1by1">
                                                      <iframe class="embed-responsive-item" src="signed_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                                <!-- <div class="form-group">
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
                                                </div> -->
                                                <!-- selecting and concatenating the date and time from tbl_students_work -->
                                                <?php 
                                                    session_start();
                                                    $task_id = $_SESSION['t_id_works11'];
                                                    $sql1 = "SELECT program_head_forward_date AS dateTTime1 FROM tbl_students_work where id='$task_id'";
                                                    $query1 = $conn->query($sql1);
                                                    while($row1 = $query1->fetch_assoc()){
                                                        $_SESSION['datetime222'] = $row1['dateTTime1'];
                                                    }
                                                ?>
                                                <!-- <div class="form-group">
                                                    <label>OJT Teacher's Remarks :</label> <br>
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
                                                <hr> -->
                                                <!-- <div class="form-group">
                                                    <i style="color: #1a8cff;" class="fas fa-clock"></i>
                                                    <b title="DATE AND TIME FORWARDED"> <?php $date_time_posted = $_SESSION['datetime222']; echo $date_time_posted; ?> </b>
                                                </div> -->
                                                <!-- <hr>
                                                 <div class="form-group">
                                                    <label>Signed File : </label>
                                                    <input type="file" name="signed_document" id="signed_document" class="form-control" required="">
                                                </div>
 -->                                            <!-- /div>
                                           
                                        </div>
                                    </div> -->
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                                    <?php 
                                    $file_pointer = "signed_docs/"."".$row['uploaded_file'];
                                    if (!file_exists($file_pointer)) { ?>
                                    <button type="submit" id="forward_btn" name="forward_to_dean"  class="btn btn-primary" disabled="">Forward <i class="fas fa-share-square"></i></button><?php } else {?><button type="submit" id="forward_btn" name="forward_to_dean"  class="btn btn-primary">Forward <i class="fas fa-share-square"></i></button> <?php }?>
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
                    <?php $count++; } ?> 
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
    if (isset($_SESSION['signed'])) {?>
        <script>
            swal.fire({
             icon: 'success',
             type : 'success',
             title : 'Document is Signed!',
             text : '<?php echo $_SESSION['signed']?>'
         })
        </script>
    <?php unset($_SESSION['signed']);
    }

    if (isset($_SESSION['forwarded'])) {?>
        <script>
            swal.fire({
             icon: 'success',
             type : 'success',
             title : 'Document Successfully Forwarded to Dean!',
             text : '<?php echo $_SESSION['forwarded']?>'
         })
        </script>
    <?php unset($_SESSION['forwarded']);
    }
?>


<!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" style="text-decoration: none;" href="#page-top">
        <i class="fas fa-anglp"></i>
        <i class="fas fa-angle-up"></i>
        <i class="fas fa-"></i>
    </a>

<?php 
include('includes/logout-modal.php');
?>
<?php
include('includes/scripts.php');
include('includes/footer.php');
?>

