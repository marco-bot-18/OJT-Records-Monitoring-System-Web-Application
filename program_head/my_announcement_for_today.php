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


            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAnnouncements"
                    aria-expanded="true" aria-controls="collapseUtilities">
                     <i class="fas fa-fw fa-calendar"></i>
                    <span>Announcement</span></a>
                </a>
                <div id="collapseAnnouncements" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Category</i></h6>
                        <a class="collapse-item" href="announcements_for_today.php">Today</a>
                        <a class="collapse-item" href="announcements_history.php">All</a>
                    </div>
                </div>
            </li>

            <li class="nav-item active">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMyAnnouncements"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-bullhorn fa-2x text-black-300"></i>
                    <span>My Announcement</span></a>
                </a>
                <div id="collapseMyAnnouncements" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Category</i></h6>
                        <a class="collapse-item active" href="my_announcement_for_today.php">Today</a>
                        <a class="collapse-item" href="my_announcement_history.php">All</a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo" href="#">
                    <i class="fas fa-tasks"></i>
                    <span>Requested Documents</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Manage</h6>
                        <a class="collapse-item" href="request_docs_completed.php">Approved</a>
                        <a class="collapse-item" href="request_docs_pending.php">Not Yet Approved</a>
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

            


            <!-- Nav Item - Utilities Collapse Menu -->
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
                        <a class="collapse-item" href="#">DATA</a>
                        <a class="collapse-item" href="#">DATA</a>
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

<?php 
include('includes/topbar.php');
?>
 
<div class="container-fluid">
<!-- Page Heading -->
    
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><span><b>My Announcements</b> / Today </span></h1>
    </div>

    <style>
        #announcement_title{
            border: 1px solid gray;
            color:  #333333;
        }
        #announcement_title:focus {
            border: 1px solid black;
            box-shadow: none;
            outline-offset: 0px;
            outline: none;
            color:  black;
        }
        #announcement_description{
            border: 1px solid gray;
            color:  #333333;
        }
        #announcement_description:focus {
            border: 1px solid black;
            box-shadow: none;
            outline-offset: 0px;
            outline: none;
            color:  black;
        }
        #sample_file{
            border: 1px solid gray;
            color:  #333333;
        }
        #sample_file:focus {
            border: 1px solid black;
            box-shadow: none;
            outline-offset: 0px;
            outline: none;
            color:  black;
        }
        #send_announcement_to{
            border: 1px solid gray;
            color:  #333333;
        }
        #send_announcement_to:focus {
            border: 1px solid black;
            box-shadow: none;
            outline-offset: 0px;
            outline: none;
            color:  black;
    </style>


    <!-- Create announcement modal -->
    <div class="modal fade bd-example-modal-lg" id="createAnnouncement" tabindex="-1" role="dialog" aria-labelledby="createAnnouncement" aria-hidden="true" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-lg" role="document" style="color:  #333333;">
        <div class="modal-content modal-lg">
          <div class="modal-header modal-lg">
            <h5 class="modal-title" id="exampleModalLabel">Create Announcement</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
            <form class="" action="my_announcement_add.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body modal-lg">
                    <div class="form-group">
                    <label>Title <span style="color: red">*</span></label>
                        <input type="text" name="announcement_title" class="form-control" id="announcement_title" aria-describedby="" placeholder="Enter Announcement Title" required autofocus="">
                    </div>
                    <div class="form-group">
                    <label>Description <span style="color: red">*</span></label>
                        <textarea rows="10" class="form-control" placeholder="Announcement Description/Message" name="announcement_description" id="announcement_description" style="height: 500%;" required=""></textarea>
                    </div>
                    <div class="form-group">
                        <label>Upload File</label>
                        <input type="file" name="sample_file" class="form-control" id="sample_file" aria-describedby="" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="">Send the Announcement to <span style="color: red">*</span></label><br>
                        <select class="form-control" name="send_announcement_to" id="send_announcement_to">
                            <option value="student">Students</option>
                            <option value="teacher">Teachers</option>
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
            <a href="my_announcement_history.php" class="btn btn-sm btn-primary shadow-sm" title="Click Here To See All Your Announcements"><i class="fas fa-reply-all"></i> All</a>
            <a href="my_announcement_for_today.php" class="btn btn-sm btn-warning shadow-sm active" title="Click Here To See Your New Announcements for Today"><i class="fas fa-calendar-day"></i> Today</a>
        </div>
        <div class="card-header py-3">
        <?php ?>
            <h6 class="m-0 font-weight-bold" style="color: #333333">
                Announcements that I Posted for Today
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="dataTable" width="100%"  cellspacing="10"  id="example" style="color:  #333333;">
                  <thead>
                    <tr>
                      <th hidden=""> </th>
                      <th>Announcement</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                    // CONTENTS
                  ?>
                  <?php
                    session_start();
                    $_posted_by = "Program Head";
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
                    ?>
                    <tr id="tra">
                      <td hidden=""><?php
                      $_SESSION['ANN_ID_C'] = $_SESSION['announcement_id'];
                       echo $_SESSION['ANN_ID_C'];?></td>
                      <td><b><?php echo $row['title'];?></b> <br> <?php echo $row['description'];?><br>
                      <?php if($row['file'] != ""){?><b><a href="../admin/upload_docs/<?php echo $row['file'];?>" target="_blank" title="Download File"><i class="fa fa-folder"></i> <?php echo $row['file'];?></a></b><?php } else { echo "<font style='color: red;'>There's no attached file</font>"; }?>
                      <br>
                      <br>
                      <div title="Sent to">
                            <i class="fas fa-share-square" style="color: #1a8cff;"></i> <b>My <?php echo $row['sendTo'];?></b>
                          </div>
                          <div title="Date and Time Posted">
                                <i style="color: #1a8cff;" class="fas fa-clock"></i>
                                <b> <?php echo $row['date_'] ." at ". $row['time_']; ?> </b>
                            </div>
                            <?php
                            if ($status == 'unpublished') {
                                echo "<span style='font-size: 15px; margin-left: 0px; color: gray;' class='badge badge-pill badge-warning'>UNPUBLISHED</span>";
                            }
                            else if ($status == 'published') {
                                 echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-success'>PUBLISHED</span>";
                            }
                          ?> 
                      </td>
                      <td width="20%">
                          <a href="#edit<?php echo $id;?>" title="View/Edit Announcement Details" data-toggle="modal" data-id="" class="btn btn-info"><i class="fas fa-edit"></i></a>
                          <?php if ($status == 'unpublished') {?>
                          <a href='my_announcement_published.php?id=<?php echo $id;?>' title="Set the Announcement to Published" class='published'><button class='btn btn-success'>
                          <i class='fa fa-upload'></i></button></a>
                            <?php } ?>
                            <?php if ($status == 'published') {?>
                          <a href='my_announcement_unpublished.php?id=<?php echo $id;?>' title="Set the Announcement to Unpublished" class='unpublished'><button class='btn btn-warning'><i class='fas fa-window-close'></i></button></a>
                          <?php } ?>
                          <a href="announcement_delete.php?id=<?php echo $id;?>" title="Delete Announcement" class='del-btn'><button class="btn btn-danger"><i class="fas fa-trash-alt"></i></button></a>
                      </td>


                        <!-- Update Announcement Modal -->
                        <div class="modal fade bd-example-modal-xl" id="edit<?php echo $id;?>" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="update_place" aria-hidden="true">
                          <div class="modal-dialog modal-xl" role="document" style="color: #333333;">
                            <div class="modal-content modal-xl">
                              <div class="modal-header modal-xl">
                                <h5 class="modal-title" id="exampleModalLabel">My Announcement</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>

                              <form class="" action="announcement_update.php" method="post" enctype="multipart/form-data">
                                <!-- get the announcement unique code/id -->
                               <input type="text" name="announcement_id_teacher" value="<?php echo $id;?>" hidden>
                                <div class="modal-body modal-xl">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-md">
                                                <div class="form-group">
                                                    <label>Title: <span style="color: red">*</span></label>
                                                    <input type="text" name="announcement_title" class="form-control" id="announcement_title" aria-describedby="" value="<?php echo $row['title']; ?>" placeholder="Enter Announcement Title" required autofocus="">
                                                </div>
                                                <div class="form-group">
                                                <label>Description/Message <span style="color: red">*</span></label>
                                                    <textarea rows="10" required="" placeholder="Announcement Desciption/Message" id="announcement_description" class="form-control" name="announcement_description"><?php echo $row['description']; ?></textarea>
                                                </div>
                                                <hr>
                                                 <div class="form-group">
                                                    <label>File:</label> <br>
                                                    <b><?php if($row['file'] != ""){?><a href="../admin/upload_docs//<?php echo $row['file'];?>" target="_blank" title="Download File"><?php echo $row['file'];?></a><?php } else { echo "<font style='color: red;'>There's no attached file</font>"; }?></b>
                                                </div>
                                            </div>
                                            <div class="col-md">
                                                <div class="form-group">
                                                    <label>Upload New File: </label>
                                                    <input type="file" name="sample_file" class="form-control" id="sample_file" aria-describedby="" placeholder="">
                                                </div>
                                                <hr>
                                                <div class="form-group">
                                                    <label>Received by: </label> <br>
                                                    <b><?php echo $row['sendTo'];?></b>
                                                </div>
                                                <hr>
                                                <div class="form-group">
                                                    <i style="color: #1a8cff;" class="fas fa-clock"></i>
                                                    <b> <?php $date_time_posted = $_SESSION['dt_c']; echo $date_time_posted; ?> </b>
                                                </div>
                                                <div class="form-group">
                                                    <b> <?php
                                                        if ($status == 'unpublished') {
                                                            echo "<span style='font-size: 15px; margin-left: 0px; color: gray;' class='badge badge-pill badge-warning'>UNPUBLISHED</span>";
                                                        }
                                                        else if ($status == 'published') {
                                                             echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-success'>PUBLISHED</span>";
                                                        }
                                                      ?>  </b>
                                                </div>
                                                <div class="form-group">
                                                    <b><span><?php echo $row['edited']; ?></span></b>
                                                </div>
                                            </div>
                                        </div>
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
?>
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