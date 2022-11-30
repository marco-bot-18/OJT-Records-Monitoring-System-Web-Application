<?php //header("Refresh:0");
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
        $_my_name = $_SESSION['student_fullname_session'];
        $sql = "INSERT INTO tbl_comments(get_announcement_id, comment, commented_by, date_, time_, archive) VALUES('$announcement_id', '$my_comment', '$_my_name', '$td', '$time', '$status')";
        $query_run = mysqli_query($conn, $sql);
        if ($query_run) {
            $active = "active";
            $my_ID = $_SESSION['student_id'];
            $my_teacher = $_SESSION['student_teacher'];
            $session_login = "You commented at announcement of ".$my_teacher." entitled ".$title_;
            //log session
            $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_login', '$td', '$time', '$my_ID', '$active')";
            $query_log_run = mysqli_query($conn, $sql_log);
            if ($query_log_run) {
                // $get_name_id = $_SESSION['stud_fullname'];

                // $userType = "Student";
                // $session_audit = $get_name_id. " commented at announcement of ".$my_teacher." entitled ".$title_;
                // $sql_audit = "INSERT INTO tbl_audit_trail (activity, date_, time_, by_, status, userType) VALUES ('$session_audit', '$date_', '$time_', '$get_name_id', '$active', '$userType')";
                // $query_audit_run = mysqli_query($conn, $sql_audit);
                // if($query_audit_run){
                    header('location: announcement_history.php');
                //}
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
#tra{
    color:  #333333;
}
#tra:hover {
    color: black;
    background: #f2f2f2;
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


            <li class="nav-item active">
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
                        <a class="collapse-item active" href="announcement_history.php">All
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


            <li class="nav-item">
                <a class="nav-link collapsed" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo" href="#">
                    <i class="fas fa-tasks"></i>
                    <span>My Requirements</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Manage</h6>
                        <a class="collapse-item" href="my_requirements_pending.php">To do's
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
        <h1 class="h3 mb-0 text-gray-800"><span><B>Announcements</B> / All </span></h1>
    </div>

    <!-- Show Table Area -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
             <a href="announcement_history.php" class="btn btn-sm btn-primary shadow-sm active" title="Click Here To See All The Announcements"><i class="fas fa-reply-all"></i> All
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
             <a href="announcement_for_today.php" class="btn btn-sm btn-warning shadow-sm" title="Click Here To See The New Announcements for Today"><i class="fas fa-calendar-day"></i> Today
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
        </div>
        <div class="card-header py-3" style="background: #595959;">
            <h6 class="m-0 font-weight-bold" style="color: ghostwhite;">
               <i class="fas fa-calendar-day"></i> All Announcements 
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" width="100%" cellspacing="10"  id="example1" style="color: #333333;">
                  <thead>
                    <tr>
                      <th hidden="">ID</th>
                      <th>Announcements</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                    require_once('includes/db_connect.php');
                    include 'includes/session.php';
                    $count = 1;
                    $receiver_name = $_SESSION['student_fullname_session']; //receiver name get from includes/session.php
                    $posted_by1 = "Dean";
                    $posted_by3 = "Program Head";
                    $posted_by2 = $_SESSION['student_teacher'];
                    $pub_stats = "published";
                    $stats = "not archived";
                    $sendTo = "Students";
                    $stats = "not archived";
                    $count = 1;
                    $sql = "SELECT * FROM tbl_announcement_receiver WHERE (posted_by='$posted_by1' and status='$stats' and publish_status='$pub_stats' and receiver_name='$receiver_name' and sendTo='$sendTo') 
                    OR 
                    (posted_by='$posted_by2' and status='$stats' and publish_status='$pub_stats' and receiver_name='$receiver_name' and sendTo='$sendTo') 
                    OR 
                    (posted_by='$posted_by3' and status='$stats' and publish_status='$pub_stats' and receiver_name='$receiver_name' and sendTo='$sendTo' )";
                    $query = $conn->query($sql);
                    while($row = $query->fetch_assoc()){
                        $_SESSION['announcement_id_cc'] = $row['id'];
                        $id = $row['announcement_id'];
                        $announcement_id = $row['announcement_id'];
                    ?>
                    <tr>
                      <td hidden="">
                        <?php 
                            $_SESSION['t_id_works1'] = $_SESSION['task_id_2_stud'];
                            echo $_SESSION['t_id_works1'];
                        ?>
                      </td>
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
                            <i style="color: #1a8cff;" class="fas fa-user"></i>
                            <b title="Posted By"> <?php echo $row['posted_by']; ?> </b>
                            
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
                                            <i style="color: #1a8cff;" class="fas fa-user"></i> <b style="color: #333333"><?php echo $row_comment1['commented_by'];?> •
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
    <i class="fas fa-angle"></i>
    <i class="fas fa-angle-up"></i>
    <i class="fas fa-angle"></i>
</a>

<!-- Logout Modal-->
<?php 
include('includes/logout-modal.php');
?>
<?php
include('includes/scripts.php');
include('includes/footer.php');
?>