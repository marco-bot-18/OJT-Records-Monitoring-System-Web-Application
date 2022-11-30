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
    color: #333333;
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

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReports" aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-file-alt"></i>
                    <span>Reports</span>
                </a>
                <div id="collapseReports" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Category</i></h6>
                        <a class="collapse-item" href="student_submittals.php">Students' Submittals</a>
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
            
            <li class="nav-item active">
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
        <h1 class="h3 mb-0 text-gray-800"><span><b>Courses</b></span></h1>
    </div>


    <script>
        function checkAvailabilityCourseCode() {
        $("#loaderIcon").show();
            jQuery.ajax({
                url: "includes/check_availability.php",
                data:'course_code='+$("#course_code").val(),
                type: "POST",
                success:function(data){
                $("#coursecode-availability").html(data);
                $("#loaderIcon").hide();
            },
            error:function (){}
            });
        }
    </script>

    <script>
        function checkAvailabilityCourseCode1() {
            $("#loaderIcon").show();
                jQuery.ajax({
                url: "includes/check_availability.php",
                data:'course_code1='+$("#course_code1").val(),
                type: "POST",
                success:function(data){
                $("#coursecode-availability1").html(data);
                $("#loaderIcon").hide();
            },
            error:function (){}
            });
        }
    </script>

    <style>
        #course_acronym{
            border: 1px solid gray;
            color:  #333333;
        }
        #course_acronym:focus {
            border: 1px solid #006bb3;
            box-shadow: none;
            outline-offset: 0px;
            outline: none;
            color:  black;
        }
        #course_code{
            border: 1px solid gray;
            color:  #333333;
        }
        #course_code:focus {
            border: 1px solid #006bb3;
            box-shadow: none;
            outline-offset: 0px;
            outline: none;
            color:  black;
        }

        #specialization{
            border: 1px solid gray;
            color:  #333333;
        }
        #specialization:focus {
            border: 1px solid #006bb3;
            box-shadow: none;
            outline-offset: 0px;
            outline: none;
            color:  black;
        }
        #course_title{
            border: 1px solid gray;
            color:  #333333;
        }
        #course_title:focus {
            border: 1px solid #006bb3;
            box-shadow: none;
            outline-offset: 0px;
            outline: none;
            color:  black;
        }
        #course_description{
            border: 1px solid gray;
            color:  #333333;
        }
        #course_description:focus {
            border: 1px solid #006bb3;
            box-shadow: none;
            outline-offset: 0px;
            outline: none;
            color:  black;
        }

        #year{
            border: 1px solid gray;
            color:  #333333;
        }
        #year:focus {
            border: 1px solid #006bb3;
            box-shadow: none;
            outline-offset: 0px;
            outline: none;
            color:  black;
        }
        #section{
            border: 1px solid gray;
            color:  #333333;
        }
        #section:focus {
            border: 1px solid #006bb3;
            box-shadow: none;
            outline-offset: 0px;
            outline: none;
            color:  black;
        }
    </style>

    <script>
        // var subjectObject = {
        //   "BSIT": {
        //     "Bachelor of Science in Information Technology": ["Service Management Program", "Web and Mobile Application Development Program", "Networking", "Multimedia"]    
        //   },
        //   "BSCS": {
        //     "Bachelor of Science in Computer Science": ["Graphics and Visualization Track", "Artificial Intelligence and Machine Learning", "Information Science", "Data Science and Analytics"],
        //   }
        // }
        // window.onload = function() {
        //   var subjectSel = document.getElementById("course_acronym");
        //   var topicSel = document.getElementById("course_title");
        //   var chapterSel = document.getElementById("specialization");
        //   for (var x in subjectObject) {
        //     subjectSel.options[subjectSel.options.length] = new Option(x, x);
        //   }
        //   subjectSel.onchange = function() {
        // //empty Chapters- and Topics- dropdowns
        //  chapterSel.length = 1;
        //  topicSel.length = 1;
        //     //display correct values
        //     for (var y in subjectObject[this.value]) {
        //       topicSel.options[topicSel.options.length] = new Option(y, y);
        //     }
        //   }
        //   topicSel.onchange = function() {
        //     //empty Chapters dropdown
        //     chapterSel.length = 1;
        //     //display correct values
        //     fvar z = subjectObject[subjectSel.value][this.value];
        //     for (var i = 0; i < z.length; i++) {
        //       chapterSel.options[chapterSel.options.length] = new Option(z[i], z[i]);
        //     }
        //   }
        // }
    </script>

    <script>
        var subjectObject = {
          "BSIT": {
            "Bachelor of Science in Information Technology": ["Service Management Program", "Web and Mobile Application Development Program", "Networking", "Multimedia"]    
          },
          "BSCS": {
            "Bachelor of Science in Computer Science": ["Graphics and Visualization Track", "Artificial Intelligence and Machine Learning", "Information Science", "Data Science and Analytics"],
          }
        }
        window.onload = function() {
          var subjectSel = document.getElementById("course_acronym");
          var topicSel = document.getElementById("course_title");
          var chapterSel = document.getElementById("specialization");
          for (var x in subjectObject) {
            subjectSel.options[subjectSel.options.length] = new Option(x, x);
          }
          subjectSel.onchange = function() {
            //empty Chapters- and Topics- dropdowns
            chapterSel.length = 1;
            topicSel.length = 1;
            //display correct values
            for (var y in subjectObject[this.value]) {
              topicSel.options[topicSel.options.length] = new Option(y, y);
            }
          }
          topicSel.onchange = function() {
            //empty Chapters dropdown
            chapterSel.length = 1;
            //display correct values
            var z = subjectObject[subjectSel.value][this.value];
            for (var i = 0; i < z.length; i++) {
              chapterSel.options[chapterSel.options.length] = new Option(z[i], z[i]);
            }
          }
        }
    </script>

    <!-- Add course modal -->
    <div class="modal fade bd-example-modal-lg" id="addCourse" tabindex="-1" role="dialog" aria-labelledby="createEvent" aria-hidden="true" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-lg" role="document" style="color: #333333;">
        <div class="modal-content modal-lg">
          <div class="modal-header modal-lg">
            <h5 class="modal-title" style="color: #0d6efd;"><h><i class="fas fa-graduation-cap"></i> Create Course, Year & Section</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

            <form class="" action="courses_add.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body modal-lg">
                    <div class="form-group">
                    <label>Course Acronym: <span style="color: red;">*</span></label>
                        <!-- <input type="text" style="text-transform: uppercase;" name="course_code" class="form-control" id="course_code" aria-describedby="" onBlur=""  placeholder="ex. BSIT" required autofocus=""> -->
                        <select class="form-control" id="course_acronym" name="course_acronym" required="">
                            <option value="" selected="selected" disabled="">Please select acronym first</option>
                        </select>
                    </div>
                    <div class="form-group">
                    <label>Course: <span style="color: red;">*</span></label>
                        <select class="form-control" id="course_title" name="course_title" required="">
                            <!-- <option value="BSIT">Bachelor of Science in Information Technology (BSIT)</option>
                            <option value="BSCS">Bachelor of Science in Computer Science (BSCS)</option>
                            <option value="BSIS">Bachelor of Science in Information Systems (BSIS)</option> -->
                            <option value="" selected="selected" disabled="">Please select title first</option>
                        </select>
                    </div>
                    <div class="form-group">
                    <label>Specialization: <span style="color: red;">*</span></label>
                        <select class="form-control" id="specialization" name="specialization" required="">
                            <option value="" selected="selected" disabled="">Please select specialization first</option>
                            <!-- <option value="WAM">Web and Mobile Application Development Program (WAM)</option>
                            <option value="SMP">Service Management Program (SMP)</option>
                            <option value="Networking">Networking (NW)</option>
                            <option value="IntSci">Intelligent Science (IntSci)</option> -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Year: <span style="color: red;">*</span></label>
                        <select class="form-control" id="year" name="year">
                            <option value="1">1st</option>
                            <option value="2">2nd</option>
                            <option value="3">3rd</option>
                            <option value="4">4th</option>
                        </select>
                    </div>
                    <div class="form-group">
                    <label>Section: <span style="color: red;">*</span></label>
                        <select class="form-control" id="section" name="section">
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <option value="E">E</option>
                            <option value="F">F</option>
                            <option value="G">G</option>
                        </select>
                    </div>
                    <div class="form-group">
                    <label>Course Description: <span style="color: red;">*</span></label>
                        <textarea class="form-control" placeholder="ex. Bachelor oF Science in Information Technology - Service Management Program" name="course_description" id="course_description" rows="4" required=""></textarea>
                    </div>
                </div>
            <div class="modal-footer modal-lg">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                <button class="btn btn-primary">Create <i class="fas fa-save"></i></button>
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
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCourse">
                    Create Course <i class="fas fa-plus-square"></i>
                </button>
            </h6>
        </div>
        <div class="card-header py-3" style="background: #595959;">
            <h6 class="m-0 font-weight-bold" style="color: ghostwhite;">
                List of Course, Year and Sections 
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="dataTable" width="100%"  cellspacing="20"  id="example" style="color: #333333;">
                  <thead>
                    <tr>
                      <th hidden="">No.</th>  
                      <th>No.</th>
                      <th>Course Acronym</th>
                      <th>Course, Year, Section and Specialization</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                    require_once('includes/db_connect.php');
                    $stats = "not archived";
                    $count = 1;
                    $sql = "SELECT * FROM tbl_courses ORDER BY id ASC";
                    $query = $conn->query($sql);
                    while($row = $query->fetch_assoc()){
                        $id = $row['id'];
                    ?>
                    <tr id="tra">
                      <td hidden=""><?php echo $id; ?></td>
                      <td><?php echo $count; ?></td>
                      <td width=""><?php echo $row['course_code'];?></td>
                      <td width="">
                        <?php echo $row['course_title'];?><br>
                        <font class="m-0 font-weight-bold text-primary"> <?php echo $row['course_description'];?>  </font>
                      </td>
                      <td>
                          <?php
                            if ($row['archived'] == 'archived') {
                                echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-danger'>NOT ACTIVE</span>";
                            }
                            else if ($row['archived'] == 'not archived') {
                                echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-success'>ACTIVE</span>";
                            }
                          ?> 
                      </td>
                      <td width="10%">
                          <a href="#edit<?php echo $id;?>" data-toggle="modal" data-id="" class="btn btn-dark"><i class="fas fa-edit" title="Edit"></i></a>

                          <?php if ($row['archived'] == 'archived') { ?>
                          <a href='courses_retrieve.php?id=<?php echo $id;?>' title="Set to Active" class='active-btn'><button class='btn btn-success'><i class="fas fa-check-square"></i></button></a>

                          <?php } else if ($row['archived'] == 'not archived') { ?>
                          <a href="courses_delete.php?id=<?php echo $id;?>" class='del-btn'><button class="btn btn-warning" title="Set as Not Active"><i class="fas fa-ban"></i></button></a>
                           <?php } ?>
                      </td>

                        <!-- Update Course Modal -->
                        <div class="modal fade bd-example-modal-lg" id="edit<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="update_place" aria-hidden="true" data-backdrop='static'>
                          <div class="modal-dialog modal-lg" role="document" style="color: #333333;">
                            <div class="modal-content modal-lg">
                              <div class="modal-header modal-lg">
                                <h5 class="modal-title" style="color: #0d6efd;"><h><i class="fas fa-graduation-cap"></i> Update Description</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>

                              <form class="" action="courses_edit.php" method="POST" enctype="multipart/form-data">
                                <input type="text" value="<?php echo $row['id'];?>" name="id" hidden>
                                <div class="modal-body modal-lg">
                                    <div class="form-group">
                                    <label>Course Description: <span style="color: red;">*</span></label>
                                        <textarea class="form-control" placeholder="ex. Bachelor oF Science in Information Technology - Service Management Program" name="course_description" id="course_description" rows="4" required=""><?php echo $row['course_description']; ?></textarea>
                                    </div>
                                </div>
                            <div class="modal-footer modal-lg">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                                <button class="btn btn-primary">Save <i class="fas fa-save"></i></button>
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


<!-- Message Box JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

<!-- alert boxes with session set and unset -->
<!-- alert messages -->
<?php
    if (isset($_SESSION['success'])) {?>
        <script>
            swal.fire({
             icon: 'success',
             type : 'success',
             title : 'Course, Year & Section Created Successfully!',
             text : '<?php echo $_SESSION['success']; ?>'
         })
        </script>
    <?php unset($_SESSION['success']);
    }
?>

<?php
    if (isset($_SESSION['success1'])) {?>
        <script>
            swal.fire({
             icon: 'success',
             type : 'success',
             title : 'Description Updated Successfully!',
             text : '<?php echo $_SESSION['success1']; ?>'
         })
        </script>
    <?php unset($_SESSION['success1']);
    }
?>

<?php
    if (isset($_SESSION['success2'])) {?>
        <script>
            swal.fire({
             icon: 'success',
             type : 'success',
             title : 'Course, Year and Section Set To Not Active!',
             text : '<?php echo $_SESSION['success2']; ?>'
         })
        </script>
    <?php unset($_SESSION['success2']);
    }
?>


<!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" style="text-decoration: none;" href="#page-top">
        <i class="fas fa-"></i>
        <i class="fas fa-angle-up"></i>
        <i class="fas fa-"></i>
    </a>

<script>
$('.del-btn').on('click',function(e){
    e.preventDefault();
    const href = $(this).attr('href') 
    Swal.fire({
        title: 'Are you sure to set this in not active?',
        text: "You will be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, set it!'
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
        title: 'Are you sure to set this in active?',
        text: "You will be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, set it!'
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
?>
<?php
include('includes/scripts.php');
include('includes/footer.php');
?>
