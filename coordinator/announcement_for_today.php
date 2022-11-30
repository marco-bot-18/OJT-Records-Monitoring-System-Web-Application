<?php
    if (isset($_POST['send'])) {
        session_start();
        require_once('includes/db_connect.php');
        date_default_timezone_set('Asia/Manila');
        $timestamp = time();
        $td = date("F d, Y");
        $time = date("h:i:s A");
        
        $title_ = $_POST['title_'];
        $my_comment = $_POST['my_comment'];
        $status = "not archived";
        $announcement_id = $_POST['announcement_id'];
        $_my_name = $_SESSION['coordinator_fullname_session'];
        $sql = "INSERT INTO tbl_comments(get_announcement_id, comment, commented_by, date_, time_, archive) VALUES('$announcement_id', '$my_comment', '$_my_name', '$td', '$time', '$status')";
        $query_run = mysqli_query($conn, $sql);
        if ($query_run) {
            $active = "active";
            $my_ID = $_SESSION['coordinator_id'];
            $my_teacher = $_SESSION['student_teacher'];
            $session_login = "You commented <i>".$my_comment."</i> at announcement entitled ".$title_;
            //log session
            $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_login', '$td', '$time', '$my_ID', '$active')";
            $query_log_run = mysqli_query($conn, $sql_log);
            if ($query_log_run) {
                header('location: announcement_for_today.php');
            }
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
                        <a class="collapse-item" href="students_category.php">Category</a>
                    </div>
                </div>  
            </li>

            <!-- <li class="nav-item">
                <a class="nav-link" href="my_subjects.php">
                    <i class="fas fa-book"></i>
                    <span>Subjects</span></a>
            </li> -->

            <li class="nav-item active">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAnnouncements"
                    aria-expanded="true" aria-controls="collapseUtilities">
                     <i class="fas fa-fw fa-calendar"></i>
                    <span>My Announcement</span></a>
                </a>
                <div id="collapseAnnouncements" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Category</i></h6>
                        <a class="collapse-item active" href="announcement_for_today.php">Today</a>
                        <a class="collapse-item" href="announcements_history.php">All</a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
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
        
<div class="container-fluid">
<!-- Page Heading -->
    
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><span><b>My Announcements</b> / Today</span></h1>
    </div>

    <style>
    .textarea-container { 
        position: relative; 
    } 
    .textarea-container textarea { 
      width: 100%; 
      height: 60%;
      border-radius: 10px;
      
    } 
    .textarea-container button { 
      position: absolute; 
      top: 0; 
      right: 0;
      padding: 10px; 
    }
    #comment {
        border: 1px solid gray;
        color: #333333;
    }
    #comment:focus { 
        border: 1px solid #006bb3;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
        color: black;
    }
    #announcement_description{
        border: 1px solid gray;
        color:  #333333;
    }
    #announcement_description:focus {
        border: 1px solid #006bb3;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
        color:  black;
    }
    #announcement_title{
        border: 1px solid gray;
        color:  #333333;
    }
    #announcement_title:focus {
        border: 1px solid #006bb3;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
        color:  black;
    }
    #sample_file{
        border: 1px solid gray;
        color:  #333333;
        padding: 3px;
    }
    #sample_file:focus {
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


    <!-- Create announcement modal -->
    <div class="modal fade bd-example-modal-lg" id="createAnnouncement" tabindex="-1" role="dialog" aria-labelledby="createAnnouncement" aria-hidden="true" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-lg" role="document" style="color:  #333333;">
        <div class="modal-content modal-lg">
          <div class="modal-header modal-lg">
            <h5 class="modal-title" id="exampleModalLabel" style="color: #0d6efd;"><i class="fas fa-calendar"></i> Create Announcement</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
            <form class="" action="announcement_add.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body modal-lg">
                    <div class="form-group">
                    <label>Title: <span style="color: red">*</span></label>
                        <input type="text" name="announcement_title" class="form-control" id="announcement_title" aria-describedby="" placeholder="Enter Announcement Title" required autofocus="">
                    </div>
                    <div class="form-group">
                    <label>Description: <span style="color: red">*</span></label>
                        <textarea rows="10" class="form-control" placeholder="Announcement Description/Message" name="announcement_description" id="announcement_description" required=""></textarea>
                    </div>
                    <div class="form-group">
                        <label>Upload File:</label>
                        <input type="file" name="sample_file" class="form-control" id="sample_file" aria-describedby="" placeholder="">
                    </div>
                    <div class="form-group">
                        <!-- <label for="">Send the Announcement to <span style="color: red">*</span></label><br> -->
                        <select class="form-control" name="send_announcement_to" hidden>
                            <option value="student">Students</option>
                            <!-- <option value="company">Company</option> -->
                        </select>
                    </div>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                <button class="btn btn-primary">Post <i class="fas fa-save"></i></button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Show Table Area -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
        <?php ?>
            <h6 class="m-0 font-weight-bold text-primary">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createAnnouncement"> <!-- style="background: #dc3545;" -->
                    Create Announcement for Today <i class="fas fa-plus-square"></i>
                </button>
            </h6>
        </div>
        <div class="card-header py-3">
            <a href="announcements_history.php" class="btn btn-sm btn-primary shadow-sm" title="Click Here To See All Your Announcements"><i class="fas fa-reply-all"></i> All</a>

            <a href="announcement_for_today.php" class="btn btn-sm btn-warning shadow-sm active" title="Click Here To See The Your New Announcements for Today"><i class="fas fa-calendar-day"></i> Today</a>
        </div>
        <div class="card-header py-3" style="background: #595959;">
        <?php ?>
            <h6 class="m-0 font-weight-bold" style="color: ghostwhite;">
                <i class="fas fa-calendar-day"></i> Announcements that I Posted For Today (<?php echo date("F d, Y");?>)
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table" id="dataTable" width="100%"  cellspacing="10"  id="example" style="color:  #333333;">
                  <thead>
                    <tr>
                      <th hidden=""> </th>
                      <th>Announcements</th>
                      <th>Action</th> 
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                    session_start();
                    $c_id = $_SESSION['coordinator_id'];//<----CURRENT SESSION LOGIN ID 
                    $sql2 = "SELECT Concat(fname,' ',mname,' ', lname,' ','(', coordinator_id,')') AS c_fullname FROM tbl_coordinators where coordinator_id='$c_id'";
                    $query2 = $conn->query($sql2);
                    while($row2 = $query2->fetch_assoc()){
                        $_SESSION['c_fullname'] = $row2['c_fullname'];
                    }

                    $_posted_by = $_SESSION['c_fullname'];
                    date_default_timezone_set('Asia/Manila');
                    $td = date("F d, Y");
                    require_once('includes/db_connect.php');
                    $stats = "not archived";
                    $count = 1;
                    $sql = "SELECT * FROM tbl_announcement WHERE date_ ='$td' and status='$stats' and posted_by='$_posted_by' ORDER BY id ASC";
                    $query = $conn->query($sql);
                    while($row = $query->fetch_assoc()){
                        $id = $row['announcement_id'];
                        $_SESSION['announcement_id'] = $row['id'];
                        $status = $row['publish_status'];
                        $announcement_id = $row['announcement_id'];
                    ?>
                    <tr id="">
                      <td hidden="">
                        <?php
                          $_SESSION['ANN_ID_C'] = $_SESSION['announcement_id'];
                           echo $_SESSION['ANN_ID_C'];?></td>
                          <td style="border-bottom: 1px solid gray; padding-bottom: 20px;">
                            <b><?php echo $row['title'];?></b><br><?php echo $row['description'];?><br>
                            <?php if($row['file'] != ""){?><b><a href="../admin/upload_docs/<?php echo $row['file'];?>" target="_blank" title="Download File"><i class="fas fa-file"></i><?php echo $row['file'];?></a> </b> <?php } else { echo "<font style='color: red;'>There's no attachment file</font>"; }?>

                            <br>
                            <br>
                            <!-- <i class="fas fa-share-square" style="color: #1a8cff;"></i> <b title="Posted To">My <?php echo $row['sendTo'];?></b>
                            / -->
                            <i style="color: #1a8cff;" class="fas fa-clock"></i>
                            <b title="Date and Time Posted"> <?php echo $row['date_'] ." at ". $row['time_']; ?> </b>
                            •
                            <?php
                                if ($status == 'unpublished') {
                                    echo "<b><i class='fas fa-user-lock' style='color: #1a8cff;'></i> Only Me </b>";
                                }
                                else if ($status == 'published') {
                                     echo "<b><i class='fas fa-users' style='color: #1a8cff;'></i> Public</b>";
                                }
                            ?>
                            <?php 
                                if($row['edited'] == "edited"){
                            ?>•<b title="Edited"> <?php echo $row['edited']; ?> </b>
                            <?php } ?>

                          <hr>
                           <b><a href="#viewComments<?php echo $id;?>" data-toggle="modal" data-id="" class="text-primary"><i class="fas fa-comments"></i>
                            <?php
                                $sql_comment = "SELECT * FROM tbl_comments where get_announcement_id='$announcement_id'";
                                $query_comment = $conn->query($sql_comment);
                                echo $query_comment->num_rows;
                            ?> Comments</a></b>
                          <br>
                         

                            <?php 
                            $sql_comment = "SELECT * FROM tbl_comments where get_announcement_id='$announcement_id' order by id desc LIMIT 1";
                            $query_comment = $conn->query($sql_comment);
                            while($row_comment = $query_comment->fetch_assoc()){
                                //$announcement_id = $row_comment['announcement_id'];
                                $id = $row_comment['get_announcement_id'];
                            ?>

                                <!-- Modal -->
                                <div class="modal fade bd-example-modal-lg" id="viewComments<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                    <div class="modal-content modal-lg">
                                      <div class="modal-header modal-lg">
                                        <h5 class="modal-title" id="exampleModalLongTitle" style="color: #0d6efd"><i class="fas fa-comments"></i> All Comments in <?php echo $row['title'];?></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body modal-lg">
                                        <?php 
                                            $sql_comment1 = "SELECT * FROM tbl_comments where get_announcement_id='$announcement_id' ORDER by id DESC";
                                            $query_comment1 = $conn->query($sql_comment1);
                                            while($row_comment1 = $query_comment1->fetch_assoc()){
                                                //$announcement_id = $row_comment['announcement_id'];
                                                $id = $row_comment1['get_announcement_id'];
                                            ?>
                                        <div class="form-group">
                                            <i style="color: #1a8cff;" class="fas fa-user"></i> <b style="color: #333333"><?php echo $row_comment1['commented_by'];?>
                                            •
                                            <i style="color: #1a8cff;" class="fas fa-clock"></i> <?php echo $row_comment1['date_']." at ".$row_comment1['time_'];?></b>
                                            <p><?php echo $row_comment1['comment'];?></p>
                                        </div>
                                        <hr>
                                        <?php 
                                            }
                                        ?>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                                      </div>
                                    </div>
                                  </div>
                                </div>

                                <hr>
                                <div class="form-group">
                                    <b><i style="color: #1a8cff;" class="fas fa-user"></i> <?php echo $row_comment['commented_by'];?> •
                                    <i style="color: #1a8cff;" class="fas fa-clock"></i> <?php echo $row_comment['date_']." at ".$row_comment['time_'];?></b>
                                    <p><?php echo $row_comment['comment'];?></p>
                                </div>
                                <div class="form-group">
                                    <b><span><?php //echo $row['edited']; ?></span></b>
                                </div>
                            <?php 
                                }
                            ?>
                            <form action="" method="POST">
                                <div class="textarea-container">
                                    <input type="text" name="announcement_id" value="<?php echo $announcement_id;?>" hidden>
                                    <input type="text" name="title_" value="<?php echo $row['title'];?>" hidden>
                                    <textarea id="comment" required="" rows="1" class="form-control" name="my_comment" placeholder="Write a comment..."></textarea>
                                    <button class="btn btn-primary" name="send"><i class="fas fa-paper-plane"></i></button>
                                </div>
                            </form>
                      </td>
                      <td width="20%" style="border-bottom: 1px solid gray; padding-bottom: 20px;">
                        <div class="dropdown no-arrow">
                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-dark-400"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                    aria-labelledby="dropdownMenuLink">
                                    <a class="dropdown-item" href="#edit<?php echo $id;?>" data-toggle="modal"><i class="fas fa-edit"></i> Edit</a>
                                    <?php
                                    if ($status == 'unpublished') {
                                    ?>
                                        <a class="dropdown-item" href="announcement_published.php?id=<?php echo $id;?>" class='published'><i class="fas fa-unlock-alt"></i> Published</a>
                                    <?php }
                                    else if ($status == 'published') {?>
                                        <a class="dropdown-item" href="announcement_unpublished.php?id=<?php echo $id;?>" class='unpublished'><i class="fas fa-lock"></i> Set As Private</a>
                                    <?php } ?> 
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="announcement_delete.php?id=<?php echo $id;?>"><i class="fas fa-trash-alt"></i> Delete</a>
                                </div>
                            </div>
                      </td>

                        <!-- Update Announcement Modal -->
                        <div class="modal fade bd-example-modal-lg" id="edit<?php echo $id;?>" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="update_place" aria-hidden="true">
                          <div class="modal-dialog modal-lg" role="document" style="color: #333333;">
                            <div class="modal-content modal-lg">
                              <div class="modal-header modal-lg">
                                <h5 class="modal-title" id="exampleModalLabel" style="color: #0d6efd;"><i class="fas fa-edit"></i> Edit Announcement</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                               <div class="modal-header modal-lg">
                                 <h title="Date and Time Posted"><i style="color: #1a8cff;" class="fas fa-clock"></i> <?php echo $row['date_'] ." at ". $row['time_']; ?> <?php echo $row['edited'];?> - 
                                <?php
                                    if ($status == 'unpublished') {
                                        echo "<i class='fas fa-user-lock' style='color: #1a8cff;'></i> Only Me";
                                    }
                                    else if ($status == 'published') {
                                         echo "<i class='fas fa-users' style='color: #1a8cff;'></i> Public";
                                    }
                                ?></h><br>
                               </div>
                              <form class="" action="announcement_update.php" method="post" enctype="multipart/form-data">
                                <!-- get the announcement unique code/id -->
                               <input type="text" name="announcement_id_teacher" value="<?php echo $id;?>" hidden>
                                <div class="modal-body modal-lg">
                                    <div class="form-group">
                                        <label>Title: <span style="color: red">*</span></label>
                                        <input type="text" name="announcement_title" class="form-control" id="announcement_title" aria-describedby="" value="<?php echo $row['title']; ?>" placeholder="Enter Announcement Title" required autofocus="">
                                    </div>
                                    <div class="form-group">
                                    <label>Description/Message: <span style="color: red">*</span></label>
                                        <textarea rows="6" required="" placeholder="Announcement Desciption/Message" id="announcement_description" class="form-control" name="announcement_description"><?php echo $row['description']; ?></textarea>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <label>Upload New Attachment File: </label>
                                        <input type="file" name="sample_file" class="form-control" id="sample_file" aria-describedby="" placeholder="">
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                       
                                    </div>
                                            
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                                    <button class="btn btn-primary" name="update">Update <i class="fas fa-save"></i></button>
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


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

<?php
    if (isset($_SESSION['deleted'])) {?>
        <script>
            swal.fire({
             icon: 'success',
             type : 'success',
             title : 'You Remove This Annoucement Successfully',
             text : '<?php echo $_SESSION['deleted']?>'
         })
        </script>
    <?php unset($_SESSION['deleted']);
    }
?>

<?php
    if (isset($_SESSION['published'])) {?>
        <script>
            swal.fire({
             icon: 'success',
             type : 'success',
             title : 'Announcement Set As Public',
             text : '<?php echo $_SESSION['published']?>'
         })
        </script>
    <?php unset($_SESSION['published']);
    }
?>

<?php
    if (isset($_SESSION['unpublished'])) {?>
        <script>
            swal.fire({
             icon: 'success',
             type : 'success',
             title : 'Announcement Set As Private',
             text : '<?php echo $_SESSION['unpublished']?>'
         })
        </script>
    <?php unset($_SESSION['unpublished']);
    }
?>

<?php
    if (isset($_SESSION['posted'])) {?>
        <script>
            swal.fire({
             icon: 'success',
             type : 'success',
             title : 'Announcement Was Posted Successfully',
             text : '<?php echo $_SESSION['posted']?>'
         })
        </script>
    <?php unset($_SESSION['posted']);
    }
?>



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
if(isset($_GET['unpublished'])){ ?>
    <div class="flash-data4" data-flashdata="<?php echo $_GET['unpublished'];?>"></div>
<?php } 
    unset($_GET['unpublished']);
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
        <i class="fas fa-angle"></i>
        <i class="fas fa-angle-up"></i>
        <i class="fas fa-angle"></i>
    </a>


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
         title : 'Annoucement Deleted Successfully',
         text : 'Announcement was deleted!'
     })
 }

 const flashdata2 = $('.flash-data2').data('flashdata')
 if(flashdata2){
     swal.fire({
         icon: 'success',
         type : 'success',
         title : 'Announcement Created Successfully',
         text : 'Announcement was posted!'
     })
 }

 const flashdata3 = $('.flash-data3').data('flashdata')
 if(flashdata3){
     swal.fire({
         icon: 'success',
         type : 'success',
         title : 'Announcement Updated Successfully',
         text : 'Announcement was edited!'
     })
 }

 const flashdata4 = $('.flash-data4').data('flashdata')
 if(flashdata4){
     swal.fire({
         icon: 'success',
         type : 'success',
         title : 'Announcement Successfully Unpublished',
         text : 'Announcement has been unpublished!'
     })
 }

 const flashdata5 = $('.flash-data5').data('flashdata')
 if(flashdata5){
     swal.fire({
         icon: 'success',
         type : 'success',
         title : 'Announcement Successfully Published',
         text : 'Announcement has been published!'
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
