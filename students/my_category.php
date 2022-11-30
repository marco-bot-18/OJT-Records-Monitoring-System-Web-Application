<?php
require_once('includes/db_connect.php');
session_start();

date_default_timezone_set('Asia/Manila');
$timestamp = time();

$date_submission = date('Y-m-d');
$td = date("F d, Y");
$time = date("h:i:s A");

if(isset($_POST['save'])){
    $category_desc = $_POST['description'];
    $remarks = $_POST['remarks'];
    $stud_id = $_SESSION['student_id'];
    $id = $_SESSION['student_auto_id'];

    $sql = "UPDATE tbl_students SET category_desc='$category_desc', remarks='$remarks' WHERE id='$id' and stud_id='$stud_id'";
    $query_run = mysqli_query($conn, $sql);

    if($query_run){
        $active = "active";
        $my_ID = $_SESSION['student_id'];
        $session_login = "You updated your category description in to: <b>".$category_desc."</b> and remarks: <b>".$remarks."</b>";
        //log session
        $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_login', '$td', '$time', '$my_ID', '$active')";
        $query_log_run = mysqli_query($conn, $sql_log);
        if ($query_log_run) {
            $get_name_id = $_SESSION['stud_fullname'];
            $userType = "Student";
            $session_audit = $get_name_id. " updated his/her category description in to <b>".$category_desc."</b> and remarks <b>".$remarks."</b>";
            $sql_audit = "INSERT INTO tbl_audit_trail (activity, date_, time_, by_, status, userType) VALUES ('$session_audit', '$td', '$time', '$get_name_id', '$active', '$userType')";
            $query_audit_run = mysqli_query($conn, $sql_audit);
            if($query_audit_run){
                $_SESSION['success'] = "Updated Successfully";
                header('location: my_category.php?=category_details_updated');
            }
        }
    }
    else{
        echo $conn->error."";
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

#description {
    border: 1px solid gray;
    color: #333333;
}
#description:focus { 
    border: 1px solid #006bb3;
    box-shadow: none;
    outline-offset: 0px;
    outline: none;
    color: black;
}

#remarks {
        border: 1px solid gray;
        color: #333333;
}
#remarks:focus { 
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

            <li class="nav-item active">
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

        <!-- Logout Modal-->
        <?php 
        include('includes/logout-modal.php');
        ?>

<?php 
include('includes/topbar.php');
?>
 
<div class="container-fluid">
<!-- Page Heading -->
    
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><span><B>My Category</B> </span></h1>
    </div>



    <!-- Show Table Area -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i>This section is about keeping track of your activities while on your on-the-job training course. It will be monitored by your OJT teacher and college dean. </i>
            </h6>
        </div>
        <div class="card-header py-3" style="background: #595959;">
            <h6 class="m-0 font-weight-bold" style="color: ghostwhite;">
            <i class="fas fa-user-tag"></i> <?php echo $_SESSION['student_ojt_category'];?>
            </h6>
        </div>
        <div class="card-body" style="color: #333333">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <form method="POST">
                        <div class="form-group">
                            <label>Your Description: </label>
                            <textarea name="description" placeholder="Enter Your Description Here" id="description" rows="5" class="form-control"><?php echo $_SESSION['category_desc'];?></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label>Your Remarks: </label>
                        <select name="remarks" id="remarks" class="form-control">
                            <?php 
                                if ($_SESSION['remarks'] == "pending") {
                                    echo "<option value='pending'>Pending</option>";
                                    echo "<option value='ongoing'>On-going</option>";
                                    echo "<option value='completed'>Completed</option>";      
                                }
                                if ($_SESSION['remarks'] == "ongoing") {
                                    echo "<option value='ongoing'>On-going</option>";
                                    echo "<option value='pending'>Pending</option>";
                                    echo "<option value='completed'>Completed</option>";     
                                }
                                if ($_SESSION['remarks'] == "completed") {
                                    echo "<option value='completed'>Completed</option>";     
                                    echo "<option value='pending'>Pending</option>";
                                    echo "<option value='ongoing'>On-going</option>";
                                }
                            ?>
                        </select>
                        <!-- <textarea name="remarks" placeholder="Enter Your Remarks Here" id="remarks" rows="5" class="form-control"><?php echo $_SESSION['remarks'];?></textarea> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="card-header py-3">
            <div style="margin-left: 1170px;">
                <button type="submit" class="btn btn-primary" name="save">Update <i class="fas fa-save"></i></button>
            </div>
            </form>
        </div>
        </div>
    </div>
</div>




<!-- Message Box JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

<?php
    if (isset($_SESSION['success'])) {?>
        <script>
            swal.fire({
             icon: 'success',
             type : 'success',
             title : 'Your Description and Remarks Updated Successfully!',
             text : '<?php echo $_SESSION['success']?>'
         })
        </script>
    <?php unset($_SESSION['success']);
    }
?>


<script>
</script>

<!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" style="text-decoration: none;" href="#page-top">
        <i class="fas fa-angle"></i>
        <i class="fas fa-angle-up"></i>
        <i class="fas fa-angle"></i>
    </a>

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>

