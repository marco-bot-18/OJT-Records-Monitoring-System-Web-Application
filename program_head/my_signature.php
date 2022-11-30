<style type="text/css">
.image {
    position: relative;
    width: 400px;
}

.image__img {
    display: block;
    width: 100%;
}

.image__overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 75%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6);
    color: #ffffff;
    font-family: 'Quicksand', sans-serif;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: left;
    opacity: 0;
    transition: opacity 0.25s;
}

.image__overlay--blur {
    backdrop-filter: blur(5px);
    border-radius: 4px;
}

.image__overlay--primary {
    background: #009578;
}

.image__overlay > * {
    transform: translateY(10px);
    transition: transform 0.25s;
    border-radius: 4px;
}

.image__overlay:hover {
    opacity: 1;
    border-radius: 4px;
}

.image__overlay:hover > * {
    transform: translateX(0);
    border-radius: 4px;
}

.image__title {
    font-size: 1em;
    font-weight: bold;
}

.image__description {
    font-size: 1.25em;
    margin-top: 0.25em;
}


.image-preview {
    margin-left: 10px;
    height: 400px;
    width: 400px;
    min-height: 100px;
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
    width: 100%;
    height: 100%;
}
</style>

<?php
include('includes/session.php'); 
include('includes/header.php');
//<!-- Sidebar -->

include('includes/session.php');
require_once('includes/header.php');
require_once('includes/db_connect.php');
?>
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


            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            <!-- Sidebar Message -->
           

        </ul>
        <!-- End of Sidebar -->
        
        <!-- Topbar  -->
        <?php 
        include('includes/topbar.php');
        ?>  
 
<script type="text/javascript">
    function validateFileType(){
        var fileName = document.getElementById("my_signature_img").value;
        var idxDot = fileName.lastIndexOf(".") + 1;
        var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
        if (extFile=="png"){
            //TO DO
        }else{
            alert("Only png files are allowed!");
            document.getElementById("my_signature_img").value = "";
        }   
    }
</script>

<!--Upload New Image-->
<div class="modal fade" id="upload_new_signature" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document" style="color: #333333;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" style="color: #0d6efd;"><i class="fas fa-signature"></i> Upload Your Signature</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="my_signature_update.php" method="post" enctype="multipart/form-data">
          <div class="modal-body">
            <center>
                <div class="image-preview" id="imgPreview">
                    <img src="" alt="Image Preview" style="border: solid 1px #333333;" class="image-preview__image">
                    <span class="image-preview__default-text"></span>
                </div>
                <br>
              </center>
                <div class="form-group">
                    <input type="file" accept="image/png" onchange="validateFileType()" class="form-control" id="my_signature_img" name="my_signature_img" required>
                </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel <i class="fas fa-window-close"></i></button>
            <button class="btn btn-primary" name="btn_save_pic">Save Your Signature <i class="fas fa-save"></i></button>
          </div>
        </form>
    </div>
  </div>
</div>

<div class="container-fluid">
<!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><b>My Signature</b></h1>
        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
    </div>

    <style>
    #my_signature_img {
        border: 1px solid gray;
        color: #333333;
        padding: 3px;
    }
    #my_signature_img:focus { 
        border: 1px solid #006bb3;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
        color: black;
    }
    #signature {
        border: 1px solid gray;
        color: #333333;
        background: ghostwhite;
    }
    #signature:focus { 
        border: 1px solid black;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
        color: black;
        background: ghostwhite;
    }
</style>

<script>
    $(function () {
        $("#chk").click(function () {
            if ($(this).is(":checked")) {
                $("#dvSign").show();
                $("#dvSign1").hide();
            } else {
                $("#dvSign").hide();
                $("#dvSign1").show();
            }
        });
    });
</script>

    <div class="card shadow mb-4" style="color: #333333;">

        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-danger">
                TERMS AND CONDITIONS
            </h6>
        </div>
        <div class="card-body" style="color: #333333;">
            The use of this application is intended for you to update your e-signature. Make sure your signature is legit before uploading.<br><br>
            <div class="form-group">
                <input type="checkbox" id="chk" name="checkbox" value=""> <i>I agree that the signature that I upload in this section is my legit signature.</i>
            </div>
        </div>
        <div class="card-header py-3" style="background: #595959;">
            <h6 class="m-0 font-weight-bold" style="color: ghostwhite;">
                <i class="fas fa-signature"></i> Upload/Update Your e-Signature
            </h6>
        </div>
            <div class="card-body">
                <div class="container">
                    <?php    
                        if(isset($_SESSION['signature_update'])){
                            echo "<div class='alert alert-success alert-dismissible fade show'><h4><i class='icon fa fa-check'></i> Success!</h4>".$_SESSION['signature_update']."
                            
                            <button type='button' name='reset' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                            </button>
                            </div>";
                        }
                        unset($_SESSION['signature_update']);
                    ?>
                  <div class="row">
                     <div class="col-sm">
               
                    </div>
                    <div class="col-sm">
                        <div class="form-group">
                            <div id="dvSign" style="display: none;">
                                <a style="text-decoration: none; color: ghostwhite;" href="" data-toggle="modal" data-target="#upload_new_signature">
                                    <div class="image">
                                    <?php //calling the signature of program head
                                        $userType = $_SESSION['coordinator_fullname_session'];
                                        $ses_sql = mysqli_query($conn,"SELECT * FROM tbl_signature where owner_signature='$userType'");
                                        $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
                                        $_SESSION['my_signature_program_head'] = $row['image'];
                                    ?>
                                    <img src="uploaded_signature_imgs/<?php echo $_SESSION['my_signature_program_head']; ?>" class="rounded" alt="" id="image1" width="300px;" height="300px" style="border: 1px solid gray">
                                    <div class="image__overlay">
                                        <div class="image__title">
                                            <br><br><br><br><br>
                                        <u>Upload New Signature</u><br>
                                        <br><br><br><br>
                                            <i class="fas fa-camera fa-3x"></i>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
                            <div id="dvSign1" >
                                <div class="image">
                                <?php 
                                    //calling the signature of program head
                                    $userType = $_SESSION['coordinator_fullname_session'];
                                    $ses_sql = mysqli_query($conn,"SELECT * FROM tbl_signature where owner_signature='$userType'");
                                    $row = mysqli_fetch_array($ses_sql, MYSQLI_ASSOC);
                                    $_SESSION['my_signature_program_head'] = $row['image'];
                                ?>
                                    <img src="uploaded_signature_imgs/<?php echo $_SESSION['my_signature_program_head']; ?>" class="rounded" alt="" id="image1" width="300px;" height="300px" style="border: 1px solid gray">
                                </div>
                            </div>
                        </div>
                        </div>
                            <div class="col-sm">
               
                            </div>
                        </div>
                    </div>
                   
                </div>
            </div>
        </div>
        </div>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" style="text-decoration: none;" href="#page-top">
        <i class="fas fa-"></i>
        <i class="fas fa-angle-up"></i>
        <i class="fas fa-"></i>
    </a>

<!-- to display image (insert image input type) -->
<script>
    const file = document.getElementById("my_signature_img");
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

<?php
include('includes/logout-modal.php');
include('includes/scripts.php');
include('includes/footer.php');
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

<script>

</script>

