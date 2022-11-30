<style>
    #tra{
        color:  #333333;
    }
    #tra:hover {
        color: black;
        background: #f2f2f2;
    }
    #fetchval1{
    border: 1px solid gray;
    color: #333333;
    }
    #fetchval1:focus {
        border: 1px solid #006bb3;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
        color: black;
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
                <a class="nav-link" href="students_list.php">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Students</span></a>
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
 

<div class="container-fluid">
<!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><span><b>Students </b></span></h1>
    </div>


    <div class="card shadow mb-4">
        <!-- <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <h6 class="m-0 font-weight-bold text-primary">
                    <h style="color: #dc3545;">Want to create an account for student?</h><br>
                    <br>
                    <a class="btn btn-dark" href="student_account.php">
                    Click Here <i class="fas fa-plus-square"></i></a>
                </h6>
            </h6>
        </div> -->

        <div class="card-header py-3" style="background: #595959;">
            <h6 class="m-0 font-weight-bold" style="color: ghostwhite;">
                <i class="fas fa-user-graduate"></i> List of Students Under My Program:
                <?php
                    $active = "active";
                    $isArchived = "not archive";
                    $program = $_SESSION['program_head_of'];
                    $sql = "SELECT * FROM tbl_students where program='$program' and archived='$isArchived' and status='$active'";
                    $query = $conn->query($sql);
                    echo $query->num_rows;
                ?>
            </h6>
        </div>
        <div class="card-header py-3">
            <div class="form-group">
                <select class="form-control form-control-sm" id="fetchval1" name="acad_yr_sem" style="width: 700; color: #333333;">
                    <?php
                    include 'includes/db_connect_pdo.php';
                    //using pdo format
                    $program_head_of = $_SESSION['program_head_of'];
                    $sql = "SELECT * from tbl_courses where course_code=:program_head_of";
                        $query = $dbh -> prepare($sql);
                        $query->bindParam(':program_head_of', $program_head_of,PDO::PARAM_STR);
                        $query->execute();
                        $results=$query->fetchAll(PDO::FETCH_OBJ);
                        $cnt=1;
                        if($query->rowCount() > 0) {
                            echo "<option value='' selected=''>Filter Course, Year & Section - All</option>";
                            foreach($results as $result){?>
                            <option value="<?php $_SESSION['course_yr_sec'] =  $result->course_title;
                                    echo $_SESSION['course_yr_sec']; ?>">
                                <?php
                                    echo $_SESSION['course_yr_sec'];
                                ?>
                            </option>
                    <?php }} ?>
                </select>
            </div>
        </div>
        <div class="">
            <!-- table -->
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="dataTable"  cellpadding="20"  id="example" width="100%" style="color: #333333; ">
                      <thead>
                        <tr>
                        <center>
                          <th>No.</th>
                          <th>Photo</th>
                          <th>Student ID</th>
                          <th>Student Name</th>
                          <th>Course, Year & Section</th>
                          <th>Status</th>
                          <th>Action</th>
                        </center>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                            $count = 1;
                            require_once('includes/db_connect.php');
                            $program_head_of = $_SESSION['program_head_of'];
                            $not_archived = "not archive";
                            $sql = "SELECT * FROM tbl_students where program='$program_head_of' and archived='$not_archived' ORDER BY id ASC";
                            $query = $conn->query($sql);
                            while($row = $query->fetch_assoc()){
                                $id = $row['stud_id'];
                                $status = $row['status'];
                        ?>
                        <tr id="tra" href="#view<?php echo $id;?>" title="View Student's Info" data-toggle="modal">
                          <td><?php echo $count; ?></td>
                          <td><img src="../admin/uploaded_images/<?php echo $row['image']; ?>" alt="" style="margin-right: 50px;border-radius: 50%;" id="image1" width="50px;" height="50px;">  </td>
                          <td><?php echo $id; ?></td>
                          <td><?php echo $row ['lname'].", ".$row['fname']. " ".$row['mname']; ?></td>
                          <td><?php echo $row ['course']; ?></td>
                          <td>
                          <?php
                            if ($status == 'not active') {
                                echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-danger'>NOT ACTIVE</span>";
                            }
                            else if ($status == 'active') {
                                echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-success'>ACTIVE</span>";
                            }
                          ?> 
                          </td>
                          <td>
                            <a href="#view<?php echo $id;?>" data-toggle="modal" data-id="" class="btn btn-info" title="View Student's Info"><i class="fas fa-eye"></i></a>
                          </td>
                        </tr>

                      <!-- View Student Modal -->
                        <div class="modal fade bd-example-modal-lg" id="view<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                          <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content modal-lg">
                              <div class="modal-header modal-lg">
                                <h5 class="modal-title" style="color: #0d6efd;"><h><i class="fas fa-user-graduate"></i> View Student's Details</h></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body modal-lg">
                                <div style="padding: 20px; background: rgba(51, 51, 51, 0.9); color: ghostwhite;">
                                    <center>
                                        <img src="../admin/uploaded_images/<?php echo $row['image']; ?>" alt="" style="margin-right: 50px;border-radius: 5%;" id="image1" width="200px;" height="200px;"> 
                                    </center><br>
                                </div>
                                <div class="container" style="background: rgba(51, 51, 51, 0.9); color: ghostwhite; padding: 20px;">
                                     <hr style="background-color: ghostwhite;">
                                  <div class="row">
                                    <div class="col">
                                      <label>Student ID :</label>
                                    </div>
                                  
                                    <div class="col">
                                       <font style="font-weight: bold; "><?php echo $row['stud_id']; ?></font>
                                    </div>
                                  </div>
                                   <div class="row">
                                    <div class="col">
                                       <label>Student Name :</label>
                                    </div>
                                    <div class="col">
                                       <font style="font-weight: bold; "><?php echo $row['fname']. " ".$row['mname']. " ".$row['lname']; ?></font>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col">
                                       <label>Course, Year & Section :</label>
                                    </div>
                                    <div class="col">
                                       <font style="font-weight: bold; "><?php echo $row['course']; ?></font>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col">
                                       <label>Academic Year and Semester :</label>
                                    </div>
                                    <div class="col">
                                       <font style="font-weight: bold; "><?php echo $row['academic_yr_semester']; ?></font>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col">
                                       <label>Handle by :</label>
                                    </div>
                                    <div class="col">
                                       <font style="font-weight: bold; "><?php echo $row['coordinator']; ?></font>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col">
                                       <label>Category :</label>
                                    </div>
                                    <div class="col">
                                       <font style="font-weight: bold; "><?php echo $row['ojt_category']; ?></font>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col">
                                       <label>Hours Required :</label>
                                    </div>
                                    <div class="col">
                                       <font style="font-weight: bold; "><?php echo $row['hours_required']; ?></font>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col">
                                       <label>In or Off-Campus? :</label>
                                    </div>
                                    <div class="col">
                                       <font style="font-weight: bold; "><?php echo $row['in_off_campus']; ?></font>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col">
                                       <label>Status :</label>
                                    </div>
                                    <div class="col">
                                        <font style="font-weight:; "><?php
                                            if ($status == 'dropped') {
                                                echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-danger'>NOT ACTIVE</span>";
                                            }
                                            else if ($status == 'active') {
                                                echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-success'>ACTIVE</span>";
                                            }
                                            else if ($status == 'incomplete') {
                                                echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-warning'>INCOMPLETE</span>";
                                            }
                                          ?> 
                                      </font>
                                    </div>
                                  </div>
                                </div>
                                <br>

                                <div class="container" style="color: #333333;">
                                    <h5>Student's Additional Information</h5>
                                    <hr>
                                  <div class="row">
                                    <div class="col">
                                      <label>Email :</label>
                                    </div>
                                    <div class="col">
                                      <font style="font-weight: bold;"><?php echo $row['email']; ?></font>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col">
                                      <label>Civil Status :</label>
                                    </div>
                                    <div class="col">
                                      <font style="font-weight: bold;"><?php echo $row['civil_status']; ?></font>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col">
                                      <label>Date of Birth :</label>
                                    </div>
                                    <div class="col">
                                      <font style="font-weight: bold;"><?php echo $row['bday']; ?></font>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col">
                                      <label>Gender :</label>
                                    </div>
                                    <div class="col">
                                      <font style="font-weight: bold;"><?php echo $row['gender']; ?></font>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col">
                                      <label>Address :</label>
                                    </div>
                                    <div class="col">
                                      <font style="font-weight: bold;"><?php echo $row['address']; ?></font>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col">
                                      <label>Contact Number :</label>
                                    </div>
                                    <div class="col">
                                      <font style="font-weight: bold;"><?php echo $row['contact']; ?></font>
                                    </div>
                                  </div>
                                </div>

                              </div>
                                 <div class="modal-footer modal-lg">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                                    <!-- <button class="btn btn-primary" name="update">Update</button> -->
                                </div>
                                <!-- form end -->
                              </form>
                            </div>

                          <!--  -->
                        </div>
                        <?php $count++; } ?>
                      </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

</div>

<script type="text/javascript">
    $(document).ready(function(){
        $("#fetchval1").on('change', function(){
            var value = $(this).val();
            
            $.ajax({
                url:"students_list_fetch.php",
                type:"POST",
                data: 'request1=' + value,
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

<!-- to display image (edit image) -->
<script>
function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#img')
                    .attr('src', e.target.result)
                    .width(320)
                    .height(300);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<!-- flash data for save -->
<?php 
if(isset($_GET['warning2'])){ ?>
    <div class="flash-data5" data-flashdata="<?php echo $_GET['warning2'];?>"></div>
<?php } 
    unset($_GET['warning']);
?>

<?php 
if(isset($_GET['warning'])){ ?>
    <div class="flash-data4" data-flashdata="<?php echo $_GET['warning'];?>"></div>
<?php } 
    unset($_GET['warning']);
?>

<!-- flash data for save -->
<?php 
if(isset($_GET['created'])){ ?>
    <div class="flash-data3" data-flashdata="<?php echo $_GET['created'];?>"></div>
<?php } 
    unset($_GET['created']);
?>

<!-- flash data for set active user -->
<?php 
if(isset($_GET['setactive'])){ ?>
    <div class="flash-data1" data-flashdata="<?php echo $_GET['setactive'];?>"></div>
<?php  }
    unset($_GET['setactive']);
?>

<!-- flash data for set ban user -->
<?php 
if(isset($_GET['setbanned'])){ ?>
    <div class="flash-data2" data-flashdata="<?php echo $_GET['setbanned'];?>"></div>
<?php }
    unset($_GET['setbanned']);
?>


<!-- Message Box JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

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
         type : 'success',
         title : 'This Student Account is Now Already Active',
         text : 'Account has been authorized!'
     })
 }

const flashdata2 = $('.flash-data2').data('flashdata')
if(flashdata2){
 swal.fire({
     type : 'success',
     title : 'This Student Account is Now Inactive',
     text : 'Account has been banned'
 })
}
 const flashdata3 = $('.flash-data3').data('flashdata')
 if(flashdata3){
     swal.fire({
         icon: 'success',
         type : 'success',
         title : 'Student Information Created Successfully',
         text : 'Record has been inserted!'
     })
 }

 const flashdata4 = $('.flash-data4').data('flashdata')
 if(flashdata4){
     swal.fire({
         icon: 'warning',
         type : 'warning',
         title : 'Email is already Taken',
         text : 'Email is Already Taken! Please use a new one.'
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
            <i class="fas fa-aup"></i>
            <i class="fas fa-angle-up"></i>
            <i class="fas fa-anp"></i>
        </a>

<!-- Logout Modal-->
<?php 
include('includes/logout-modal.php');
?>

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>