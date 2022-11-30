<?php
    require_once('includes/db_connect.php');
    include('includes/session.php');
    require_once('includes/db_connect_pdo.php');

    // code for update the read notification status 
    $isread = 1;
    $did=intval($_GET['req_id']);
    date_default_timezone_set('Asia/Manila');
    $admremarkdate=date('Y-m-d G:i:s ', strtotime("now"));
    $sql="update tbl_students_work set isReadStud=:isread where id=:did";
    $query = $dbh->prepare($sql);
    $query->bindParam(':isread',$isread,PDO::PARAM_STR);
    $query->bindParam(':did',$did,PDO::PARAM_STR);
    $query->execute();

    // code for update the read all notification status 
    $isread = 1;
    if (isset($_POST['read_all'])) {
        date_default_timezone_set('Asia/Manila');
        $stud_name_id = $_SESSION['stud_fullname'];
        $admremarkdate=date('Y-m-d G:i:s ', strtotime("now"));
        $sql="UPDATE tbl_students_work SET isReadStud=:isread WHERE stud_name_and_id=:stud_name_id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':isread',$isread,PDO::PARAM_STR);
        $query->bindParam(':stud_name_id',$stud_name_id,PDO::PARAM_STR);
        $query->execute();
    }
?>

<style type="text/css">
.button-save {
    background-color: #4CAF50;
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
#dataTable{
    color: black;
}
#dataTable:hover{
    color: black;
}

#instructions {
    border: 1px solid gray;
    color: black;
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

#student_comment {
    border: 1px solid gray;
    background: white;
    color: #333333;
    resize: none;
}
#student_comment:focus { 
    border: 1px solid #006bb3;
    box-shadow: none;
    outline-offset: 0px;
    outline: none;
    background: white;
    color: black;
}

#my_file {
    border: 1px solid gray;
    padding: 3px;
}
#my_file:focus { 
    border: 1px solid #006bb3;
    box-shadow: none;
    outline-offset: 0px;
    outline: none;
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


            <li class="nav-item active">
                <a class="nav-link collapsed" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo" href="#">
                    <i class="fas fa-tasks"></i>
                    <span>My Requirements</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Manage</h6>
                        <a class="collapse-item active" href="my_requirements_pending.php">To do's
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
        <h1 class="h3 mb-0 text-gray-800"><span><b>My Requirements</b> / To-Do's</span></h1>
    </div>

    <!-- Show Table Area -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="my_requirements_pending.php" class="btn btn-sm btn-primary shadow-sm active" title="Click Here To See All Your Requirements That Are Not Yet Submitted"><i class="fas fa-reply-all"></i> All
                <span class="badge bg-danger">
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
            <a href="my_requirements_pending_for_today.php" class="btn btn-sm btn-warning shadow-sm" title="Click Here To See The New Requirements for Today"><i class="fas fa-calendar-day"></i> Today
                <span class="badge badge-danger">
                    <?php
                        date_default_timezone_set('Asia/Manila');
                        $td = date("F d, Y");
                        $student_teacher = $_SESSION['student_teacher'];
                        $work_stats = "pending";
                        $stats = "not archived";
                        $count = 1;
                        $submitted = "no";
                        $myfullname_ = $_SESSION['student_fullname_session'];
                        $sql = "SELECT * from tbl_students_work where date_='$td' and stud_name_and_id='$myfullname_' and name_of_teacher='$student_teacher' and work_status='$work_stats' and status='$stats' and submitted='$submitted'";
                        $query = $conn->query($sql);
                        echo $query->num_rows;
                    ?>        
                </span>
            </a>
        </div>
        <div class="card-header py-3" style="background: #595959;">
            <h6 class="m-0 font-weight-bold" style="color: ghostwhite;">
                <i class="fas fa-list-alt"></i> List of All Your Requirements That Are Not Yet Submitted
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover"  width="100%" cellspacing="10"  id="example1" style="color: #333333;">
                  <thead>
                    <tr>
                      <th hidden="">ID</th>
                      <th hidden="">Name of Teacher</th>
                      <th>Requirement</th>
                      <th>Due Date</th>
                      <th hidden="">Date</th>
                      <th>Turned In</th>
                      <th>Status</th>
                      <th>Action</th>  
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                    require_once('includes/db_connect.php');
                    $student_teacher = $_SESSION['student_teacher'];
                    $work_stats = "pending";
                    $stats = "not archived";
                    $submitted = "no";
                    $count = 1;
                    $myfullname_ = $_SESSION['student_fullname_session'];
                    $sql = "SELECT * from tbl_students_work where stud_name_and_id='$myfullname_' and name_of_teacher='$student_teacher' and work_status='$work_stats' and status='$stats' and submitted='$submitted' ORDER by date_ and time_ DESC";
                    $query = $conn->query($sql);
                    while($row = $query->fetch_assoc()){
                        $id = $row['id'];
                        $_SESSION['task_id_2_stud'] = $row['id'];
                    ?>
                    <tr id="tra">
                      <td hidden="">
                        <?php 
                            $_SESSION['t_id_works1'] = $_SESSION['task_id_2_stud'];
                            echo $_SESSION['t_id_works1'];
                        ?>
                      </td>
                      <td hidden=""><?php echo $row['name_of_teacher'];?> </td>
                      <td><?php echo $row['title'];?> </td>
                      <td><?php echo $row['date_of_submission'];?> </td>
                      <td hidden="">
                        <?php echo $row['date_'];?> 
                      </td>
                      <td>
                        <?php
                        //detect the due dates
                            $date = date('Y-m-d');
                            if($row['date_of_submission'] < $date){
                                echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-danger'>LATE</span>";
                            }
                            else if($row['date_of_submission'] == $date){
                                echo "<span style='font-size: 15px; margin-left: 0px; color: #262626;' class='badge badge-pill badge-warning'>Due Today</span>";
                            }
                            else{
                                echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite; background: orange;' class='badge badge-pill badge-success'>ON-GOING</span>";
                            }
                        ?> 
                      </td>
                      <td>
                        <?php 
                            if($row['work_status'] == 'pending') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' title='15% on progress'>15%</div>
                                        </div><b>PENDING</b>";
                            }

                            if($row['work_status'] == 'semi-pending') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' title='25% on progress' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
                                        </div><b>PENDING 25%</b>";
                            }

                            if($row['work_status'] == 'semi-pending2') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'></div>
                                        </div><b>PENDING 50%</b>";
                            }

                            if($row['work_status'] == 'semi-pending3') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                        </div><b>PENDING 75%</b>";
                            }

                            if($row['work_status'] == 'completed') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'></div>
                                        </div><b>COMPLETED 100%</b>";
                            }
                        ?>
                      </td>
                      <td>
                          <a href="#view<?php echo $id;?>" data-toggle="modal" data-bs-toggle="tooltip" data-bs-placement="top" title="Want to Submit? Click Here!"><button class="btn btn-success"><i class="fas fa-check-square"></i></button></a>
                      </td>

                        <!-- View Modal -->
                        <div class="modal fade bd-example-modal-xl" data-backdrop="static" id="view<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="update_place" aria-hidden="true">
                          <div class="modal-dialog modal-xl" role="document" style="color:  #333333;">
                            <div class="modal-content modal-xl">
                              <div class="modal-header modal-xl">
                                <h5 class="modal-title" id="exampleModalLabel"><h style="color: #0d6efd"><i class="fas fa-file-alt"></i> <?php echo $row['title']; ?> </h><span><?php //echo $row['edited']; ?></span></h5> 

                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-header modal-xl">
                                <p class="modal-title" id="exampleModalLabel">
                                    <h title="Posted by - Date and Time Given"><i style="color: #1a8cff;" class="fas fa-user"></i> <?php echo $row['name_of_teacher'];?> • <i style="color: #1a8cff;" class="fas fa-clock"></i> <?php echo $row['date_']." at ".$row['time_']; ?> <?php echo $row['edited'];?></h></p> 
                              </div>
                              <form action="my_requirements_submit.php" method="POST" enctype="multipart/form-data">
                              <input type="text" class="form-control" name="id" value="<?php echo $id;?>" hidden>
                                <div class="modal-body modal-xl">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="">
                                                    <input hidden type="text" name="title" value="<?php echo $row['title'];?>">
                                                    <input hidden type="text" name="id" value="<?php echo $row['id'];?>"> </div>
                                                    <input hidden type="text" name="task_code" value="<?php echo $row['task_code'];?>"> 
                                                <!-- <div class="form-group">
                                                    <label>Requirement: </label> <br>
                                                    <b> <?php echo $row['title']; ?> </b>
                                                </div> -->
                                                <div class="form-group" >
                                                    <label>Instructions: </label> <br>
                                                    <textarea style="background: ghostwhite;" rows="18" name="instructions" class="form-control" id="instructions" aria-describedby="" readonly required=""><?php echo $row['instructions'];?></textarea>
                                                </div>
                                                <hr>
                                                <div class="form-group">
                                                    <label>Attached File</label>: <br>
                                                    <?php if($row['sample_file'] != ""){?><b><a href="../admin/upload_docs/<?php echo $row['sample_file'];?>" target="_blank" download title="Download File"><i class="fa fa-file"></i> <?php echo $row['sample_file'];?></a> </b><?php } else { echo "<b style='color: red;'>There's No Attached File</b>"; } ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Status:</label>
                                                    <?php 
                                                        if ($row['work_status'] == 'pending') {
                                                             echo "<div class='progress'>
                                                                      <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' title='15% on progress'>15%</div>
                                                                    </div><b>PENDING</b>";
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
                                                    $task_id = $_SESSION['t_id_works1'];
                                                    $sql1 = "SELECT Concat(date_,' ',time_) AS dateTTime1 FROM tbl_students_work where id='$task_id'";
                                                    $query1 = $conn->query($sql1);
                                                    while($row1 = $query1->fetch_assoc()){
                                                        $_SESSION['datetime2'] = $row1['dateTTime1'];
                                                    }
                                                ?>
                                                <div class="form-group">
                                                    <label>Date of Submission:</label> <br>
                                                    <b><?php
                                                        echo $row['date_of_submission'];?></b>
                                                </div>
                                                <hr>
                                                <div class="form-group" >
                                                    <label>Turned In:</label> <br>
                                                    <?php
                                                    //detect the due dates
                                                        $date = date('Y-m-d');
                                                        if($row['date_of_submission'] < $date){
                                                            echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-danger'>LATE</span>";
                                                        }
                                                        else if($row['date_of_submission'] == $date){
                                                            echo "<span style='font-size: 15px; margin-left: 0px; color: #262626;' class='badge badge-pill badge-warning'>Due Today</span>";
                                                        }
                                                        else{
                                                            echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite; background: orange;' class='badge badge-pill badge-success'>ON-GOING</span>";
                                                        }
                                                    ?> 
                                                </div>

                                                <hr>

                                                <div class="form-group">
                                                    <label>Attached Your File :</label> <br>
                                                    <input type="file" class="form-control" accept="application/pdf"  id="my_file" name="my_file" required="">
                                                  
                                                </div>
                                                <div class="form-group">
                                                    <label>Your Comment :</label> <br>
                                                    <textarea rows="7" style="background: white;" name="student_comment" class="form-control" placeholder="Write Your Comment Here (Optional)" onkeypress="return alpha(event)"  id="student_comment" aria-describedby=""></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>

                                     <button type="submit" name="submit"  class="btn btn-primary">Submit Your Work <i class="fas fa-check-square"></i></button>
                                </div>
                              </form>
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

<script language="javascript">
    var myFile="";

    //only accept pdf file
    $('#my_file').on('change',function(){
        myFile = $("#my_file").val();
            console.log(myFile);
        var upld = myFile.split('.').pop();
        if(upld=='pdf'){
            //alert("File uploaded is pdf!")
        }
        else{
            alert("Only PDF are allowed")
            document.getElementById('my_file').value = "";
        } 
     
    })
</script>

<!-- Message Box JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

<?php
    if (isset($_SESSION['submitted'])) {?>
        <script>
            swal.fire({
             icon: 'success',
             type : 'success',
             title : 'You Submitted the Requirement Successfully.',
             text : '<?php echo $_SESSION['submitted']?>'
         })
        </script>
    <?php unset($_SESSION['submitted']);
    }
?>


<!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" style="text-decoration: none;" href="#page-top">
        <i class="fas fa--up"></i>
        <i class="fas fa-angle-up"></i>
        <i class="fas fa--up"></i>
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

<!-- Logout Modal-->
<?php 
include('includes/logout-modal.php');
?>
<?php
include('includes/scripts.php');
include('includes/footer.php');
?>

