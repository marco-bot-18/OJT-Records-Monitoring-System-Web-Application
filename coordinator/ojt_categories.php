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
        <ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon">
                    <img src="../img/icon/ccs_logo.png" width="50px;" height="25px;" alt="" class="img-fluid">
                </div>
                <div class="sidebar-brand-text"> &nbsp;OJTRMS</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="enrollment_module.php">
                    <i class="fas fa-fw fa-map"></i>
                    <span>Enrollment Module</span></a>
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
                <a class="nav-link" href="announcement.php">
                    <i class="fas fa-fw fa-calendar"></i>
                    <span>Announcement</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo" href="#">
                    <i class="fas fa-fw fa-file"></i>
                    <span>OJT Student Files</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Manage</h6>
                        <a class="collapse-item" href="requirements.php">Requirements</a>
                        <a class="collapse-item" href="#">Tasks</a>
                    </div>
                </div>
            </li>

            <li class="nav-item active">
                <a class="nav-link" href="ojt_categories.php">
                    <i class="far fa-address-book"></i></i>
                    <span>OJT Categories</span></a>
            </li>


            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="organization.php">
                    <i class="fas fa-sitemap"></i>
                    <span>Organization</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="courses.php">
                    <i class="far fa-address-book"></i></i>
                    <span>Program</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="academic_year_sem.php">
                    <i class="fas fa-book-reader"></i>
                    <span>Academic Year and Semester</span></a>
            </li>

            <!-- Nav Item - Accounts -->
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
                        <a class="collapse-item" href="students.php">Students</a>
                        <a class="collapse-item" href="coordinators.php">Coordinators</a>
                    </div>
                </div>
            </li>


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
                        <a class="collapse-item" href="events_archives.php">Events</a>
                        <a class="collapse-item" href="log_acts_archives.php">Activities</a>
                        <a class="collapse-item" href="news_archives.php">News</a>
                        <a class="collapse-item" href="gallery_archives.php">Gallery</a>
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

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

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
        <h1 class="h3 mb-0 text-gray-800"><span>OJT Categories</span></h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>



    <!-- Create event modal -->
    <div class="modal fade" id="createCategory" tabindex="-1" role="dialog" aria-labelledby="createAnnouncement" aria-hidden="true" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Create Announcement</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
            <form class="" action="ojt_categories_add.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                    <label>Category</label>
                        <input type="text" name="category" class="form-control" id="category" aria-describedby="" placeholder="Enter Category" required autofocus="">
                    </div>
                    <div class="form-group">
                    <label>Description</label>
                        <textarea class="form-control" placeholder="Enter Description" name="description" style="width: 100%; height: 300%;" required=""></textarea>
                    </div>
                    <div class="form-group">
                        <label>Remarks</label>
                        <textarea class="form-control" placeholder="Enter Remarks" name="remarks" style="width: 100%; height: 300%;" required=""></textarea>
                    </div>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                <button class="btn btn-primary">Save<i class="fas fa-save"></i></button>
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
                <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#createCategory">
                    Create Category <i class="fas fa-plus-square"></i>
                </button>
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="dataTable"  cellspacing="10"  id="example">
                  <thead>
                    <tr>
                      <th hidden="">ID</th>
                      <th>No.</th>
                      <th>Categories</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                    require_once('includes/db_connect.php');
                    $stats = "not archive";
                    $count = 1;
                    $sql = "SELECT * FROM tbl_ojt_categories WHERE status='$stats' ORDER BY id DESC";
                    $query = $conn->query($sql);
                    while($row = $query->fetch_assoc()){
                        $id = $row['id'];
                    ?>
                    <tr>
                      <td hidden=""><?php echo $id; ?> </td>
                      <td><?php echo $count; ?></td>
                      <td><?php echo $row['categories'];?></td>
                      <td>
                          <a href="#edit<?php echo $id;?>" data-toggle="modal" data-id="" class="btn btn-info"><i class="fas fa-edit"></i></a>

                          <a href="ojt_categories_delete.php?id=<?php echo $id;?>" class='del-btn'><button class="btn btn-danger"><i class="fas fa-trash-alt"></i></button></a>
                      </td>

                        <!-- Update Category Modal -->
                        <div class="modal fade" id="edit<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="update_place" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">View Category</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>

                              <form class="" action="ojt_categories_update.php" method="post" enctype="multipart/form-data">
                              <input type="text" class="form-control" name="id" value="<?php echo $id;?>" hidden>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Category </label>
                                        <input type="text" name="confirm" class="form-control" id="confirm" aria-describedby="" value="<?php echo $row['categories']; ?>" placeholder="Enter Category" required autofocus="">
                                    </div>
                                    <div class="form-group">
                                    <label>Description </label>
                                        <textarea name="description" class="form-control" id="description" aria-describedby="" placeholder="Enter Desciption" required=""><?php echo $row['description'];?></textarea>
                                    </div>
                                    <div class="form-group">
                                    <label>Remarks </label>
                                        <textarea name="remarks" class="form-control" id="remarks" aria-describedby="" placeholder="Enter Remarks" required=""><?php echo $row['remarks']; ?></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
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
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
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