<?php
    // code for update the read notification status
    include('includes/session.php');
    require_once('includes/db_connect_pdo.php'); 
    $isread=1;
    $completed = "completed";
    $did=intval($_GET['req_id']);
    date_default_timezone_set('Asia/Manila');
    $admremarkdate=date('Y-m-d G:i:s ', strtotime("now"));
    $sql="update tbl_students_work set isReadDean1=:isread where id=:did and work_status=:completed";
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
        $admremarkdate=date('Y-m-d G:i:s ', strtotime("now"));
        $sql="update tbl_students_work set isReadDean1=:isread where work_status=:completed";
        $query = $dbh->prepare($sql);
        $query->bindParam(':isread',$isread,PDO::PARAM_STR);
        $query->bindParam(':completed',$completed,PDO::PARAM_STR);
        $query->execute();
    }
?>

<style type="text/css">
#fetchval{
    border: 1px solid gray;
    color:  #333333;
}
#fetchval:focus {
    border: 1px solid #006bb3;
    box-shadow: none;
    outline-offset: 0px;
    outline: none;
    color:  black;
}
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
        <ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

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

          <!--   <li class="nav-item">
                <a class="nav-link" href="enrollment_module.php">
                    <i class="fas fa-fw fa-map"></i>
                    <span>Enrollment Module</span></a>
            </li> -->

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Manage
            </div>

            <li class="nav-item">
                <a class="nav-link" href="students_list_all.php">
                    <i class="fas fa-user-graduate"></i>
                <span>Students</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="coordinators_list_all.php">
                    <i class="fas fa-user-tie"></i>
                <span>Teachers</span></a>
            </li>


            <li class="nav-item">
                <a class="nav-link" href="students_documents.php">
                    <i class="fas fa-file-download"></i>
                    <span>Students' Documents</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo" href="#">
                    <i class="fas fa-file-signature"></i>
                    <span>Documents for Signing</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Manage</h6>
                        <a class="collapse-item" href="request_docs_pending.php">Pending
                            <span class="badge badge bg-danger" style="color: white;"><!-- badge badge bg-danger -->
                                <?php
                                    $work_stats = "semi-pending3";
                                    $send_to_dean = "dean";
                                    $stats = "not archived";
                                    $submitted = "yes";
                                    $count = 1;
                                    $sql = "SELECT * from tbl_students_work where send_to_Dean='$send_to_dean' and work_status='$work_stats' and submitted='$submitted' and status='$stats'";
                                    $query = $conn->query($sql);
                                    echo $query->num_rows;
                                ?>  
                            </span>
                        </a>
                        <a class="collapse-item" href="request_docs_completed.php">Approved
                            <span class="badge badge bg-danger" style="color: white;">
                                <?php
                                    $work_stats1 = "completed";
                                    $send_to_dean = "dean";
                                    $stats = "not archived";
                                    $send_to_dean = "dean";
                                    $submitted = "yes";
                                    $count = 1;
                                    $sql = "SELECT * from tbl_students_work where (send_to_Dean='$send_to_dean' and work_status='$work_stats1' and submitted='$submitted' and status='$stats') order by id asc";
                                    $query = $conn->query($sql);
                                    echo $query->num_rows;
                                ?>  
                            </span>
                        </a>
                    </div>
                </div>
            </li>

            <li class="nav-item active">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReports" aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-file-alt"></i>
                    <span>Reports</span>
                </a>
                <div id="collapseReports" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Category</i></h6>
                        <a class="collapse-item active" href="student_submittals.php">Students' Submittals</a>
                        <a class="collapse-item" href="students_category.php">Students' Category</a>
                    </div>
                </div>
            </li>

            <!-- <li class="nav-item">
                <a class="nav-link" href="other_documents.php">
                    <i class="fas fa-folder"></i>
                    <span>Other Documents</span></a>
            </li> -->
            <li class="nav-item">
                <a class="nav-link" href="ojt_categories.php">
                    <i class="far fa-address-book"></i>
                    <span>OJT Categories</span></a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="courses.php">
                    <i class="fas fa-graduation-cap"></i>
                    <span>Courses</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="academic_year_sem.php">
                    <i class="fas fa-book-reader"></i>
                    <span>Academic Year and Semester</span></a>
            </li>

            <!-- Nav Item - Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="accounts.php" data-toggle="collapse" data-target="#collapseAccounts"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Accounts</span>
                </a>
                <div id="collapseAccounts" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Category</i></h6>
                        <!-- <a class="collapse-item" href="student_account.php">Students</a> -->
                        <a class="collapse-item" href="coordinators_account.php">OJT Teachers</a>
                        <a class="collapse-item" href="program_head_account.php">Program Head</a>
                    </div>
                </div>
            </li>


            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <!-- <i class="fas fa-fw fa-wrench"></i> -->
                    <i class="fas fa-archive"></i>
                    <span>Archives</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Manage</h6>
                        <a class="collapse-item" href="students_accounts_archives.php">Student Accounts</a>
                        <a class="collapse-item" href="teacher_accounts_archives.php">Teacher Accounts</a>
                        <a class="collapse-item" href="program_head_accounts_archives.php">Program Head Accounts</a>
                    </div>
                </div>  
            </li>

            <!-- <hr class="sidebar-divider">
            <div class="sidebar-heading">
                Maintenance
            </div>
             -->

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            <!-- Sidebar Message -->
           
        </ul>

        <!-- End of Sidebar -->

<!-- topbar -->
<?php 
include('includes/topbar.php');
?>

<div class="container-fluid">
<!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><span><b>Reports</b> / Students' Submittals</span></h1>
    </div>


    <!-- Show Table Area -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="student_submittals.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm active"><i class="fas fa-file-alt"></i> Submittals</a>
            <a href="students_category.php" class="d-none d-sm-inline-block btn btn-sm btn-info shadow-sm"><i class="far fa-address-book"></i> Categories</a>
        </div>
        <div class="card-header py-3" style="background: #595959;">
            <h6 class="m-0 font-weight-bold" style="color: ghostwhite;">
               <i class="fas fa-file-alt"></i> Students' Submittals
            </h6>
        </div>
        <div class="card-header py-3">
            <form action="student_submittals_export.php" method="POST">
            <button type="submit" formtarget="_blank" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm" name="excel"><i class="fas fa-file-excel"></i> Export to Excel</button>

            <button formtarget="_blank" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm" name="pdf"><i class="fas fa-file-pdf"></i> Export to PDF</button>

             <!-- <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" name="pdf1"><i class="fas fa-file-word"></i> Export to Word</button> -->
        </div>
        <div class="card-header py-3" style="background: ghostwhite;">
            <div class="form-group">
                <select class="form-control form-control-sm" id="fetchval" name="section" style="width: 700px; color: #333333;">
                    <?php
                    include 'includes/db_connect_pdo.php';
                    //using pdo format
                    $sql = "SELECT * from tbl_courses";
                        $query = $dbh -> prepare($sql);
                        $query->execute();
                        $results=$query->fetchAll(PDO::FETCH_OBJ);
                        $cnt=1;
                        if($query->rowCount() > 0) {
                            echo "<option value='' selected='' value='All'>Filter Course, Year & Section - All</option>";
                            foreach($results as $result){?>
                            <option value="<?php $_SESSION['course_yr_sec'] =  $result->course_title;
                                    echo $_SESSION['course_yr_sec']; ?>">
                                <?php
                                    echo $_SESSION['course_yr_sec'];
                                ?>
                            </option>
                    <?php }} ?>
                </select>
                </form>
            </div>
        </div>
            <!-- table -->
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="dataTable" width="100%" cellpadding="10"  id="example" style="color: #333333;">
                      <thead>
                        <tr>
                        <center>
                          <th>No.</th>
                          <th>Student ID, Name, <br>Course & Section</th>
                          <!-- <th>Student Name</th>
                          <th>Section</th> -->
                          <th>Recommendation Letter</th>
                          <th>Resume</th>
                          <th>MOA</th>
                          <th>Response Letter</th>
                          <!-- <th>Accomplishment Report</th> -->
                          <th>Work Plan</th>
                          <th>Narrative</th>
                          <th>Performance Sheet</th>
                          <!-- <th>Endorsement Letter</th> -->
                        </center>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                            $count = 1;
                            require_once('includes/db_connect.php');
                            $stats = "active";
                            $not_archived = "not archive";
                            $course_yr = $_SESSION['course_yr_sec'];
                            $sql = "SELECT Concat(lname,', ',fname, ' ', mname) AS stud_fullname, stud_id, course, in_off_campus, recommendation_letter, resume, moa, response_letter, work_plan, narrative, performance_sheet, endorsement_letter, accomplishment_report FROM tbl_students where archived='$not_archived' ORDER BY id ASC"; //where deleted='$not_archived'
                            $query = $conn->query($sql);
                            while($row = $query->fetch_assoc()){
                                $id = $row['stud_id'];
                                $status = $row['status'];
                        ?>
                        <tr id="tra">
                        <center>
                          <td><?php echo $count; ?></td>
                          <td width="">
                            <div>
                               <i class="fas fa-id-card-alt" style="color: #dc3545;"></i> <?php echo $id; ?>
                            </div>
                            <div>
                                <i class="fas fa-user-graduate" style="color: #dc3545;"></i> <?php echo $row ['stud_fullname']; ?>
                            </div>
                            <div>
                                <i class="fas fa-graduation-cap" style="color: #dc3545;"></i> <?php echo $row ['course']; ?>  
                            </div>
                          </td>
                          <td>
                            <?php
                            $rc = $row['recommendation_letter'];
                                if($rc=="not submitted"){
                                    echo "<center><i style='color: red;' class='fas fa-times'></i><center>";
                                }
                                if($rc=="submitted"){
                                    echo "<center><i style='color: #006622;' class='fas fa-check-square'></i></center>";
                                } 
                            ?>    
                          </td>
                          <td><?php
                            $resume = $row['resume'];
                                if($resume=="not submitted"){
                                    echo "<center><i style='color: red;' class='fas fa-times'></i><center>";
                                }
                                if($resume=="submitted"){
                                    echo "<center><i style='color: #006622;' class='fas fa-check-square'></i></center>";
                                } 
                            ?>
                          </td>
                          <td>
                            <?php
                                $moa = $row['moa'];
                                if($moa=="not submitted"){
                                    echo "<center><i style='color: red;' class='fas fa-times'></i><center>";
                                }
                                if($moa=="submitted"){
                                    echo "<center><i style='color: #006622;' class='fas fa-check-square'></i></center>";
                                }
                                if($moa=="not applicable"){
                                    echo "<span style='font-size: 15px; margin-left: 0px; color: #333333;' class='badge badge-pill badge-warning'>N/A</span>";
                                } 
                            ?>
                          </td>
                          <td>
                            <?php $response_letter = $row['response_letter'];
                                if($response_letter=="not submitted"){
                                    echo "<center><i style='color: red;' class='fas fa-times'></i><center>";
                                }
                                if($response_letter=="submitted"){
                                    echo "<center><i style='color: #006622;' class='fas fa-check-square'></i></center>";
                                }?>    
                            </td>
                           <!--  <td>
                                <?php $accomplishment_report = $row['accomplishment_report'];
                                if($accomplishment_report=="not submitted"){
                                    echo "<center><i style='color: red;' class='fas fa-times'></i><center>";
                                }
                                if($accomplishment_report=="submitted"){
                                    echo "<center><i style='color: #006622;' class='fas fa-check-square'></i></center>";
                                }?>    
                            </td> -->
                            <td>
                            <?php
                            $rc = $row['work_plan'];
                                if($rc=="not submitted"){
                                    echo "<center><i style='color: red;' class='fas fa-times'></i><center>";
                                }
                                if($rc=="submitted"){
                                    echo "<center><i style='color: #006622;' class='fas fa-check-square'></i></center>";
                                } 
                            ?>    
                          </td>
                          <td><?php
                            $narrative = $row['narrative'];
                                if($narrative=="not submitted"){
                                    echo "<center><i style='color: red;' class='fas fa-times'></i><center>";
                                }
                                if($narrative=="submitted"){
                                    echo "<center><i style='color: #006622;' class='fas fa-check-square'></i></center>";
                                } 
                            ?>
                          </td>
                          <td><?php
                            $performance_sheet = $row['performance_sheet'];
                                if($performance_sheet=="not submitted"){
                                    echo "<center><i style='color: red;' class='fas fa-times'></i><center>";
                                }
                                if($performance_sheet=="submitted"){
                                    echo "<center><i style='color: #006622;' class='fas fa-check-square'></i></center>";
                                } 
                            ?>
                          </td>
<!--                           <td><?php
                            // $performance_sheet = $row['endorsement_letter'];
                            //     if($performance_sheet=="not submitted"){
                            //         echo "<center><i style='color: red;' class='fas fa-times'></i><center>";
                            //     }
                            //     if($performance_sheet=="submitted"){
                            //         echo "<center><i style='color: #006622;' class='fas fa-check-square'></i></center>";
                            //     } 
                            ?>
                          </td> -->
                        </center>
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

<!-- fetch data on the dropdown -->
<script type="text/javascript">
    $(document).ready(function(){
        $("#fetchval").on('change', function(){
            var value = $(this).val();
            $.ajax({
                url:"student_submittals_fetch.php",
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


<!-- to display image -->
<script>
    const file = document.getElementById("image_");
    const previewContainer =  document.getElementById("imgPreview");
    const previewImg = previewContainer.querySelector(".image-preview__image");
    const previewDefaultText = previewContainer.querySelector("image-preview__default-text");

    file.addEventListener("change", function(){
        const file_this = this.files[0];

        if(file_this){
            const reader = new FileReader();

            //previewDefaultText.style.display = "none";
            previewImg.style.display = "block";

            reader.addEventListener("load", function(){
                console.log(this);
                previewImg.setAttribute("src", this.result);
            });                          
            reader.readAsDataURL(file_this);
        }                        
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
         title : 'Course Program Inserted Successfully',
         text : 'Record has been inserted!'
     })
 }

 const flashdata3 = $('.flash-data3').data('flashdata')
 if(flashdata3){
     swal.fire({
         icon: 'success',
         type : 'success',
         title : 'Record Successfully Updated',
         text : 'Record has been updated!'
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
include('includes/logout-modal.php');
include('includes/scripts.php');
include('includes/footer.php');
?>

