<style type="text/css">
.zoom {
    padding: 0px;
    transition: transform .2s; /* Animation */
    margin: 0 auto;
}

.zoom:hover {
    transform: scale(3.5); /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
}

.image-preview {
    margin-left: px;
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

            <li class="nav-item active">
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
                        <a class="collapse-item active" href="students_category.php">Category</a>
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
           <!--  <li class="nav-item">
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

        <?php include('includes/topbar.php'); ?>


<style>
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
    #category_desc {
        border: 1px solid gray;
        color: #333333;
    }
    #category_desc:focus { 
        border: 1px solid #006bb3;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
        color: black;
    }
</style>
 

<div class="container-fluid">
<!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><span><b>My Students</b> / Categories</span></h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3" style="background: #595959;">
            <h6 class="m-0 font-weight-bold" style="color: ghostwhite;"><i class="fas fa-user-tag"></i> List of Students Category</h6>
        </div>
            <!-- table -->
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="dataTable" width="100%" cellpadding="10"  id="example" style="color: #333333;">
                      <thead>
                        <tr>
                        <center>
                          <th hidden=""> </th>
                          <th>No.</th>
                          <th>Student</th>
                          <th>Category</th>
                          <th>Remarks</th>
                          <th>Action</th>
                        </center>
                        </tr>
                      </thead>
                      <tbody>

                        <?php  
                        //concatinating the name coordinator  
                        $id1 = $_SESSION[coordinator_id];         
                        $sql1 = "SELECT Concat(fname, ' ', mname,' ', lname, ' ', '(',coordinator_id,')') AS fullname FROM tbl_coordinators where coordinator_id = '$id1'";
                        $query1 = $conn->query($sql1);
                        while($row1 = $query1->fetch_assoc()){
                            $_SESSION['coordinator_fullname'] = $row1['fullname'];
                        } ?>

                        <?php
                            $count = 1;
                            $_coordinator = $_SESSION['coordinator_fullname'];
                            require_once('includes/db_connect.php');
                            $isArchived = "not archive";
                            $sql = "SELECT * FROM tbl_students where archived='$isArchived' and coordinator='$_coordinator' ORDER BY id ASC";
                            $query = $conn->query($sql);
                            while($row = $query->fetch_assoc()){
                                $id = $row['stud_id'];
                                $status = $row['status'];
                        ?>
                        <tr id="tra">
                          <td hidden=""><?php echo $row['uniq_id']; ?></td>
                          <td width="5%"><?php echo $count; ?> </td>
                          <td width="25%">
                            <i class="fas fa-id-card-alt" style="color: #dc3545;"></i> <b><?php echo $id;?></b>
                            <br>
                            <i class="fas fa-user-tie" style="color: #dc3545;"></i> <?php echo $row['lname'].", ".$row['fname']." ".$row['mname']; ?>
                            <br>
                            <i class="fas fa-graduation-cap" style="color: #dc3545;"></i> <?php echo $row ['course']; ?>
                          </td>
                          <td><?php echo $row ['ojt_category']; ?></td>
                          <td>
                              <?php 
                                if ($row['remarks'] == "pending") {
                                    echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-warning'>PENDING</span>";    
                                }
                                if ($row['remarks'] == "ongoing") {
                                    echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-info'>ON-GOING</span>";    
                                }
                                if ($row['remarks'] == "completed") {
                                    echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-success'>COMPLETED</span>"; 
                                }
                            ?>
                          </td>
                          <td>
                             <a href="#edit<?php echo $id;?>" title="Edit Student's Category Details" data-toggle="modal" data-id="" class="btn btn-dark"><i class="fas fa-edit"></i></a>
                          </td>
                        </tr>

                        <!-- Edit student category details -->
                        <div class="modal fade bd-example-modal-xl" id="edit<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                          <div class="modal-dialog modal-xl" role="document" style="color: #333333;">
                            <div class="modal-content modal-xl">
                              <div class="modal-header modal-xl">
                                <h5 class="modal-title" style="color: #0d6efd;"><h><i class="far fa-address-book"></i> Student's Category Details</h></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-header modal-xl">
                                  <h style="color: #333333">
                                    <i class="fas fa-id-card"></i> <?php echo $row['stud_id']?> <br>
                                    <i class="fas fa-user-graduate"></i> <?php echo $row['fname']." ".$row['mname']." ".$row['lname']?> <br>
                                    <i class="fas fa-graduation-cap"></i> <?php echo $row['course']?> <br>
                                    <i class="fas fa-university"></i> <?php echo $row['in_off_campus']?> <br>
                                    <i class="fas fa-user-clock"></i> <?php echo $row['hours_required']?> <br>
                                    <i class="fas fa-columns"></i> <?php echo $row['ojt_category']?>
                                   </h>
                              </div>
                              <div class="modal-body modal-xl">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md">
                                            <form class="" action="students_category_update.php" method="POST" enctype="multipart/form-data">
                                                <input type="text" name="stud_fullname" value="<?php echo $row['fname']." ".$row['mname']." ".$row['lname']?>" hidden>
                                            <div class="">
                                                <input type="text" name="id" value="<?php echo $row['id']; ?>" hidden>
                                                <input type="text" name="stud_uniq_id" value="<?php echo $row['uniq_id']; ?>" hidden>
                                            </div>   
                                            <div class="form-group">
                                                <label>Description : </label> <br>
                                                <textarea class="form-control" name="category_desc" id="category_desc" rows="10"><?php echo $row['category_desc']; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md">
                                             <div class="form-group">
                                                <label>Remarks: </label> <br>
                                                <select name="remarks" id="remarks" class="form-control">
                                                    <?php 
                                                        if ($row['remarks'] == "pending") {
                                                            echo "<option value='pending'>Pending</option>";
                                                            echo "<option value='ongoing'>On-going</option>";
                                                            echo "<option value='completed'>Completed</option>";      
                                                        }
                                                        if ($row['remarks'] == "ongoing") {
                                                            echo "<option value='ongoing'>On-going</option>";
                                                            echo "<option value='pending'>Pending</option>";
                                                            echo "<option value='completed'>Completed</option>";     
                                                        }
                                                        if ($row['remarks'] == "completed") {
                                                            echo "<option value='completed'>Completed</option>";     
                                                            echo "<option value='pending'>Pending</option>";
                                                            echo "<option value='ongoing'>On-going</option>";
                                                        }
                                                    ?>
                                                </select>
                                                <!-- <textarea class="form-control" name="remarks" id="remarks" rows="10"><?php echo $row['remarks']; ?></textarea> -->
                                            </div>  
                                        </div>
                                    </div>
                                </div>
                              </div>
                              <div class="modal-footer modal-xl">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                                <button type="submit" name="update" class="btn btn-primary">Save Changes <i class="fas fa-save"></i></button>
                              </div>
                              </form>
                            </div>
                          </div>
                        </div>
                        <!-- -->
                    
                        </div>
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
    if (isset($_SESSION['success'])) {?>
        <script>
            swal.fire({
             icon: 'success',
             type : 'success',
             title : 'Student Category Details Updated Successfully',
             text : '<?php echo $_SESSION['success']?>'
         })
        </script>
    <?php unset($_SESSION['success']);
    }
?>

<script>
$('.ban-btn').on('click',function(e){
    e.preventDefault();
    const href = $(this).attr('href') 
    Swal.fire({
        title: 'Are you sure to ban this account?',
        text: "You will be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, ban it!'
        }).then((result) => {
            if (result.value) {
                document.location.href = href;
                
            }
        })
 })

$('.active-btn').on('click',function(e){
    e.preventDefault();
    const href = $(this).attr('href') 
    Swal.fire({
        title: 'Are you sure to retrieve this account?',
        text: "You will be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, retrieve it!'
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
         title : 'Account is Now Already Active',
         text : 'Student Account has been set to active!'
     })
 }

const flashdata2 = $('.flash-data2').data('flashdata')
if(flashdata2){
 swal.fire({
     icon: 'success',
     type : 'success',
     title : 'Account is Now Inactive.',
     text : 'Student Account has been set to inactive!'
 })
}
 const flashdata3 = $('.flash-data3').data('flashdata')
 if(flashdata3){
     swal.fire({
         icon: 'success',
         type : 'success',
         title : 'Students Category Details Updated Successfully',
         text : 'Student category details was successfully updated!'
     })
 }

 const flashdata4 = $('.flash-data4').data('flashdata')
 if(flashdata4){
     swal.fire({
         icon: 'warning',
         type : 'warning',
         title : 'Email is already Taken',
         text : 'Student Email is Already Taken! Please use a new one.'
     })
 }

const flashdata5 = $('.flash-data5').data('flashdata')
 if(flashdata5){
     swal.fire({
         icon: 'warning',
         type : 'warning',
         title : 'Student ID is already Taken',
         text : 'Student ID is Already Taken! Please use a new one.'
     })
 }
</script>


<!-- end tag for the message box JS -->


  <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" style="text-decoration: none;" href="#page-top">
            <i class="fas fa-angle"></i>
            <i class="fas fa-angle-up"></i>
            <i class="fas fa-angle"></i>
        </a>

<?php
//logout modal 
include('includes/logout-modal.php');
?>

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>
