<?php
    // code for update the read notification status
    include('includes/session.php');
    require_once('includes/db_connect_pdo.php'); 
    $isread=1;
    $completed = "completed";
    $did=intval($_GET['req_id']);
    date_default_timezone_set('Asia/Manila');
    $admremarkdate=date('Y-m-d G:i:s ', strtotime("now"));
    $sql="update tbl_students_work set isReadStud1=:isread where id=:did and work_status=:completed";
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
        $stud_name_id = $_SESSION['stud_fullname'];
        $admremarkdate=date('Y-m-d G:i:s ', strtotime("now"));
        $sql="update tbl_students_work set isReadStud1=:isread where stud_name_and_id=:stud_name_id and work_status=:completed";
        $query = $dbh->prepare($sql);
        $query->bindParam(':isread',$isread,PDO::PARAM_STR);
        $query->bindParam(':stud_name_id',$stud_name_id,PDO::PARAM_STR);
        $query->bindParam(':completed',$completed,PDO::PARAM_STR);
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
                        <a class="collapse-item active" href="my_requirements_ongoing.php">Submitted
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

       

        <!-- Logout Modal-->
        <?php 
        include('includes/logout-modal.php');
        ?>

<?php 
include('includes/topbar.php');
?>
 
  <style>
        #instructions {
            border: 1px solid #006bb3;
            color: #333333;
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
            border: 1px solid #006bb3;
            color: #333333;
            resize: none;
            border-top: none;
            border-left: none;
            border-right: none;
            border-bottom: 4px solid #006bb3;
        }
        #student_comment:focus { 
            border-bottom: 4px solid #006bb3;
            box-shadow: none;
            outline-offset: 0px;
            outline: none;
            color: black;
        }

        #teacher_comment{
            border: 1px solid gray;
            color: #333333;
            resize: none;
            border-top: none;
            border-left: none;
            border-right: none;
            border-bottom: 4px solid gray;
        }
        #teacher_comment:focus{ 
            border-bottom: 4px solid black;
            box-shadow: none;
            outline-offset: 0px;
            outline: none;
            color: black;
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
<!-- Page Heading -->
   <?php
    $req_id=intval($_GET['req_id']); //requirement id
    $student_teacher = $_SESSION['student_teacher'];
    $work_stats = "completed";
    $submitted = "yes";
    $stats = "not archived";
    $count = 1;
    $myfullname_ = $_SESSION['student_fullname_session'];
    $sql = "SELECT * from tbl_students_work where stud_name_and_id='$myfullname_' and name_of_teacher='$student_teacher' and submitted='$submitted' and work_status='$work_stats' and status='$stats' and id='$req_id'";
    $query = $conn->query($sql);
    while($row = $query->fetch_assoc()){
        $id = $row['id'];
        $_SESSION['task_id_2_stud'] = $row['id'];
    ?>
    
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><span><a href="my_requirements_completed.php" class="h3 mb-0 text-gray-800"><b>My Requirements</b></a> / Submitted / Completed / <b style="color: #1a8cff"> <?php echo $row['title'];?></b> </span></h1>
        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
    </div>

    <!-- Show Table Area -->
    <div class="card shadow mb-4">
        <!-- <div class="card-header py-3">
            <a href="my_requirements_completed.php" class="btn btn-sm btn-dark shadow-sm" title="Back to List"><i class="fas fa-long-arrow-alt-left"></i> Back To List</a>
        </div> -->
        <div class="card-header py-3" style="background: #595959;">
        <?php ?>
            <h6 class="m-0 font-weight-bold text-light">
                <h><i class="fas fa-clipboard-check"></i> Completed Requirement Details</h><br>
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table" id="dataTable" width="100%" cellspacing="10" style="color:  #333333;">
                <tr id="">
                    <td style="font-size:16px;"> <b>Requirement : </b>
                    <br> <?php echo $row['title']; ?> <!-- <b><span><i style="color: #1a8cff;" class="fas fa-user-edit"></i> --></span></b> </td>
                </tr>
                <tr id="">
                    <td style="font-size:16px;"> <b>Status : </b>
                    <br> 
                        <?php 
                            if ($row['work_status'] == 'pending') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100'></div>
                                        </div><b>PENDING 15%</b>";
                            }

                            if ($row['work_status'] == 'semi-pending') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
                                        </div><b>STILL PENDING 25%</b>";
                            }

                            if ($row['work_status'] == 'semi-pending2') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                        </div><b>STILL PENDING 50%</b>";
                            }

                            if ($row['work_status'] == 'semi-pending3') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                        </div><b>STILL PENDING 75%</b>";
                            }

                            if ($row['work_status'] == 'completed') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-success' role='progressbar' style='width: 100%' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'>100%</div>
                                        </div><b>COMPLETED</b>";
                            }
                        ?>
                    </td>
                </tr>
                <tr id="">
                    <td style="font-size:16px;"> <b>Instructions : </b> 
                        <br>
                        <textarea readonly="" style="background: ghostwhite;" name="instructions" class="form-control" id="instructions" rows="5"><?php echo $row['instructions'];?></textarea>
                    </td>
                </tr>

                <tr id="">
                    <td style="font-size:16px;"> <b>Your Work : </b>
                        <br>
                        <?php if($row['title'] == "Recommendation Letter") {?><b><a href="../admin/signed_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File"><i class="fa fa-file"></i><?php echo $row['uploaded_file'];?></a></b>
                        <br><br>
                        <div class="form-group">
                            <div class="embed-responsive embed-responsive-4by3">
                              <iframe class="embed-responsive-item" style="width: 60%; height: 100%; margin-left: 20%;" src="../admin/signed_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                            </div>
                        </div>
                        <?php } else {?> <b><a href="upload_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File"><i class="fa fa-file"></i><?php echo $row['uploaded_file'];?></a></b>
                        <div class="form-group">
                            <div class="embed-responsive embed-responsive-4by3">
                              <iframe class="embed-responsive-item" style="width: 60%; height: 100%; margin-left: 20%;" src="upload_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                            </div>
                        </div>
                        <?php } ?> 
                    </td>
                </tr>
                <tr id="">
                    <td style="font-size:16px;"> <b>Remarks : </b>
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
                <tr id="">
                    <td style="font-size:16px;"> <b>Your OJT Teacher's Comments/Suggestions : </b>
                        <br>
                        <textarea readonly="" style="background: ghostwhite;" name="instructions" class="form-control" id="instructions" rows="5"><?php echo $row['comment'];?></textarea> 
                    </td>
                </tr>
                <tr id="">
                    <td style="font-size:16px;"> <b>Your Comment : </b>
                        <br> 
                        <textarea readonly="" style="background: ghostwhite;" name="instructions" class="form-control" id="instructions" rows="5"><?php echo $row['student_comment'];?></textarea> 
                    </td>
                </tr>
                 <tr id="">
                    <td style="font-size:16px;"> <b>Date of Submission : </b>
                        <br><?php
                        echo $row['date_of_submission'];?></b> <br>
                    <?php if ($row['edited']=="(edited)") {?>
                    <?php } else {
                        echo "";
                    }?> 
                    </td>
                </tr>
                <tr id="">
                    <td>
                        <i style="color: #1a8cff;" class="fas fa-clock"></i>
                        <b title="DATE AND TIME COMPLETED"> <?php //$date_time_posted = $_SESSION['datetime2']; 
                        echo $row['completed_date']; ?> </b> 
                    </td>
                </tr>
                </table>
            <?php } ?>
            </div>
        </div>
        </div>
    </div>
</div>

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
         title : 'Your Requirement Submitted Successfully',
         text : "Your requirement submitted successfully! Wait for your OJT Teacher's Remarks and Comments"
     })
 }

 const flashdata4 = $('.flash-data4').data('flashdata')
 if(flashdata4){
     swal.fire({
         icon: 'success',
         type : 'success',
         title : 'Record Successfully Unpublished',
         text : 'Record has been unpublished!'
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