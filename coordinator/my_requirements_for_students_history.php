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
                        <a class="collapse-item" href="students_category.php">Category</a>
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

            <li class="nav-item active">
                <a class="nav-link collapsed" data-toggle="collapse" data-target="#collapseThree"
                    aria-expanded="true" aria-controls="collapseTwo" href="#">
                    <i class="fas fa-folder"></i>
                    <span>My Requirements</span>
                </a>
                <div id="collapseThree" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Manage</h6>
                        <a class="collapse-item" href="my_requirements_for_students.php">Today</a>
                        <a class="collapse-item active" href="my_requirements_for_students_history.php">All</a>
                    </div>
                </div>
            </li>

            <!-- <li class="nav-item">
                <a class="nav-link" href="tasks.php">
                    <i class="fas fa-thumbtack"></i>
                    <span>Task Titles</span></a>
            </li> -->

    
            <li class="nav-item">
                <a class="nav-link" href="student_account.php">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Student Account Management</span></a>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <!-- <li class="nav-item">
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

        <?php 
        include('includes/topbar.php');
        ?>
 
<style>
    #instructions{
        border: 1px solid gray;
        color:  #333333;
    }
    #instructions:focus {
        border: 1px solid #006bb3;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
        color:  black;
    }
    #sample_file{
        border: 1px solid gray;
        color:  #333333;
        padding: 3px;
    }
    #sample_file:focus {
        border: 1px solid #006bb3;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
        color:  black;
    }
    #duedate{
        border: 1px solid gray;
        color:  #333333;
        background: white;
    }
    #duedate:focus {
        border: 1px solid #006bb3;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
        color:  black;
        background: white;
    }
    #tasks_title{
        border: 1px solid gray;
        color:  #333333;
    }
    #tasks_title:focus {
        border: 1px solid #006bb3;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
        color:  black;
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
    
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><span><b>My Requirements</b> / All </span></h1>

    </div>

    <!-- Create task modal -->
    <div class="modal fade bd-example-modal-xl" id="createTasks" tabindex="-1" role="dialog" aria-labelledby="createAnnouncement" aria-hidden="true" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-xl" role="document" style="color:  #262626;">
        <div class="modal-content modal-xl">
          <div class="modal-header modal-xl">
            <h5 class="modal-title" id="exampleModalLabel" style="color: #0d6efd;"><i class="fas fa-folder"></i> Create Requirement For My Students</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
            <form class="" action="my_requirements_for_students_add.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body modal-xl">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Type of Requirement: </label> <span style="color: red">*</span><br>
                                    <select class="form-control" id="tasks_title" name="tasks_title" required="" autofocus="">
                                        <option value="Recommendation Letter">Recommendation Letter</option>
                                        <option value="Memorandum of Agreement">Memorandum of Agreement</option>
                                        <option value="Resume">Resume</option>
                                        <option value="Accomplishment Report">Accomplishment Report</option>
                                        <option value="Work Plan">Work Plan </option>
                                        <option value="Response Letter">Response Letter</option>
                                        <option value="Narrative">Narrative</option>
                                        <option value="Performance Sheet">Performance Sheet</option>
                                        <option value="Endorsement Letter">Endorsement Letter</option>
                                        <?php
                                        /*include 'includes/db_connect_pdo.php';
                                        //using pdo format
                                            //$teacher_name = $_SESSION['coordinator_fullname_session'];
                                            $sql = "SELECT task_title from tbl_task_titles";
                                            $query = $dbh -> prepare($sql);
                                           
                                            $query->execute();
                                            $results=$query->fetchAll(PDO::FETCH_OBJ);
                                            $cnt=1;
                                            if($query->rowCount() > 0) {
                                                foreach($results as $result){?>
                                                <option value="<?php echo $result->task_title; ?>">
                                                    <?php echo $result->task_title; ?>
                                                </option>
                                        <?php }} */ ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Instructions: <span style="color: red">*</span></label>
                                    <textarea class="form-control" placeholder="Write the Instructions Here" name="instructions" id="instructions" rows="20" required=""></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Due Date: <span style="color: red">*</span></label>
                                    <input type="date" id="duedate" name="duedate" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Upload Sample File:</label><br>
                                    <input type="file" name="sample_file" id="sample_file" class="form-control" id="sample_file" aria-describedby="" placeholder="">  <!-- <label class="input-group-text" for="sample_file">Upload Example File</label> -->
                                </div>
                                <div class="form-group">
                                   
                                    <select class="form-control" name="send_to" hidden="">
                                        <option value="student">My Students</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                <button class="btn btn-primary">Create <i class="fas fa-save"></i></button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- to avoid selecting the past dates in the calendar -->
    <script type="text/javascript">
        $(document).ready(function(){
            $(function(){
                var dtToday = new Date();

                var month = dtToday.getMonth() + 1;
                var day = dtToday.getDate();
                var year = dtToday.getFullYear();
                if(month < 10)
                    month = '0' + month.toString();
                if(day < 10)
                    day = '0' + day.toString();

                var maxDate = year + '-' + month + '-' + day;

                // or instead:
                // var maxDate = dtToday.toISOString().substr(0, 10);

                    //alert(maxDate);
                    $('#duedate').attr('min', maxDate);
                });
        })           
    </script>



    <!-- Show Table Area -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
        <?php ?>
            <h6 class="m-0 font-weight-bold text-primary">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createTasks">
                    Create Requirement for My Students <i class="fas fa-plus-square"></i>
                </button>
            </h6>
        </div>
        <div class="card-header py-3">
            <a href="my_requirements_for_students_history.php" class="btn btn-sm btn-primary shadow-sm active" title="Click Here To See All The Requirements You Provided"><i class="fas fa-reply-all"></i> All</a>

             <a href="my_requirements_for_students.php" class="btn btn-sm btn-warning shadow-sm" title="Click Here To See All The Requirements You Provided for Today"><i class="fas fa-calendar-day"></i> Today</a>
        </div>
        <div class="card-header py-3" style="background: #595959;">
        <?php ?>
            <h6 class="m-0 font-weight-bold" style="color: ghostwhite;">
                <i class="fas fa-folder"></i> List of All Distributed Requirement for My Students
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="dataTable" width="100%" cellspacing="10"  id="example" style="color:  #262626;">
                  <thead>
                    <tr>
                      <th hidden="">ID</th>
                      <th>No.</th>
                      <th width="30%">Requirement</th>
                      <th width="20%">Sample File</th>
                      <th>Date of Submission</th>
                      <th>Action</th>                      
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                    date_default_timezone_set('Asia/Manila');
                    $td = date("F d, Y");
                    require_once('includes/db_connect.php');
                    $stats = "not archived";
                    $count = 1;
                    $my_fullname_ = $_SESSION['coordinator_fullname_session'];
                    $sql = "SELECT * FROM tbl_coordinator_save_works WHERE name_of_teacher='$my_fullname_' and status='$stats' ORDER BY id ASC";
                    $query = $conn->query($sql);
                    while($row = $query->fetch_assoc()){
                        $id = $row['id'];
                        $code = $row['task_code'];
                        $_SESSION['task_id_1'] = $row['id'];
                    ?>
                    <tr id="tra">
                      <td hidden="">
                        <?php 
                            $_SESSION['t_id_works'] = $_SESSION['task_id_1'];
                            echo $_SESSION['t_id_works'];
                        ?> 
                      </td>
                      <td><?php echo $count;?> </td>
                      <td><?php echo $row['title'];?> </td>
                      <td><?php if($row['sample_file'] != ""){?><b><a href="../admin/upload_docs/<?php echo $row['sample_file'];?>" target="_blank" title="Download File"><i  class="fa fa-file"></i><?php echo $row['sample_file'];?></a> </b> <?php } else { echo "<font style='color: red;'>There's no attached file</font>"; }?> </td>
                      <td><?php echo $row['date_of_submission'];?></td>
                      <td>
                          <!-- <a href="#view//echo $id;" data-toggle="modal" ><button class="btn btn-primary"><i class="fas fa-eye" title="View"></i></button></a> -->
                          <a href="#edit<?php echo $id;?>" title="View/Edit Tasks Details" data-toggle="modal" data-id="" class="btn btn-dark"><i class="fas fa-edit"></i></a>

                          <a href="my_requirements_for_students_delete.php?code=<?php echo $code;?>" class='del-btn' ><button class="btn btn-danger" title="Delete"><i class="fas fa-trash-alt"></i></button></a>
                      </td>

                        <!-- Update  Modal -->
                        <div class="modal fade bd-example-modal-xl" data-backdrop="static" id="edit<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="update_place" aria-hidden="true">
                          <div class="modal-dialog modal-xl" role="document" style="color:  #262626;">
                            <div class="modal-content modal-xl">
                              <div class="modal-header modal-xl">
                                <h5 class="modal-title" id="exampleModalLabel"><h style="color: #0d6efd"><i class="fas fa-file-alt"></i> <?php echo $row['title']; ?> </h><span><?php //echo $row['edited']; ?></span></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-header modal-xl">
                                <p class="modal-title" id="exampleModalLabel">
                                    <h title="Date and Time Created">
                                    <i style="color: #1a8cff;" class="fas fa-clock"></i>
                                    <?php echo $row['date_']." at ".$row['time_']; ?> <?php echo $row['edited']; ?></h></p> 
                                    <!-- selecting and concatenating the date and time -->

                              </div>
                                <div class="modal-body modal-xl">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-md-6">
                                             <form class="" action="my_requirements_for_students_update.php" method="post" enctype="multipart/form-data">
                                                  <input  type="text" class="form-control" name="id" value="<?php echo $id;?>" hidden>
                                                   <input type="text" value="<?php echo $row['task_code']; ?>" name="task_code" hidden>
                                                <div class="form-group">
                                                    <label>Type of Requirement: <span style="color: red">*</span></label><br>
                                                    <?php ?>
                                                    <select class="form-control" name="tasks_title" required="" id="tasks_title" autofocus="">
                                                        <?php 
                                                            if($row['title'] == "Recommendation Letter") {
                                                                echo "<option value='Recommendation Letter'>Recommendation Letter</option>";
                                                                echo "<option value='Memorandum of Agreement'>Memorandum of Agreement</option>";
                                                                echo "<option value='Resume'>Resume</option>
                                                                    ";
                                                                echo "<option value='Accomplishment Report'>Accomplishment Report</option>";
                                                                echo " <option value='Work Plan>Work Plan </option>";
                                                                echo "<option value='Endorsement Letter'>Endorsement Letter</option>";
                                                                echo "<option value='Response Letter'>Response Letter</option>";
                                                                echo "<option value='Performance Sheet'>Performance Sheet</option>";
                                                                echo "<option value='Narrative'>Narrative</option>";

                                                            }
                                                            else if($row['title'] == "Resume") {
                                                                echo "<option value='Resume'>Resume</option>
                                                                    ";
                                                                echo "<option value='Recommendation Letter'>Recommendation Letter</option>";
                                                                echo "<option value='Memorandum of Agreement'>Memorandum of Agreement</option>";
                                                                echo "<option value='Accomplishment Report'>Accomplishment Report</option>";
                                                                echo " <option value='Work Plan>Work Plan </option>";
                                                                echo "<option value='Endorsement Letter'>Endorsement Letter</option>";
                                                                echo "<option value='Response Letter'>Response Letter</option>";
                                                                echo "<option value='Performance Sheet'>Performance Sheet</option>";
                                                                echo "<option value='Narrative'>Narrative</option>";
                                                            }
                                                            else if($row['title'] == "Memorandum of Agreement") {
                                                                echo "<option value='Memorandum of Agreement'>Memorandum of Agreement</option>";
                                                                echo "<option value='Recommendation Letter'>Recommendation Letter</option>";
                                                                echo "<option value='Resume'>Resume</option>
                                                                    ";
                                                                echo "<option value='Accomplishment Report'>Accomplishment Report</option>";
                                                                echo " <option value='Work Plan>Work Plan </option>";
                                                                echo "<option value='Endorsement Letter'>Endorsement Letter</option>";
                                                                echo "<option value='Response Letter'>Response Letter</option>";
                                                                echo "<option value='Performance Sheet'>Performance Sheet</option>";
                                                                echo "<option value='Narrative'>Narrative</option>";
                                                            }
                                                            else if($row['title'] == "Endorsement Letter") {
                                                                echo "<option value='Endorsement Letter'>Endorsement Letter</option>";
                                                                echo "<option value='Recommendation Letter'>Recommendation Letter</option>";
                                                                echo "<option value='Memorandum of Agreement'>Memorandum of Agreement</option>";
                                                                echo "<option value='Resume'>Resume</option>
                                                                    ";
                                                                echo "<option value='Accomplishment Report'>Accomplishment Report</option>";
                                                                echo " <option value='Work Plan>Work Plan </option>";
                                                                echo "<option value='Response Letter'>Response Letter</option>";
                                                                echo "<option value='Performance Sheet'>Performance Sheet</option>";
                                                                echo "<option value='Narrative'>Narrative</option>";
                                                            }
                                                            else if($row['title'] == "Accomplishment Report") {
                                                                echo "<option value='Accomplishment Report'>Accomplishment Report</option>";
                                                                echo "<option value='Recommendation Letter'>Recommendation Letter</option>";
                                                                echo "<option value='Memorandum of Agreement'>Memorandum of Agreement</option>";
                                                                echo "<option value='Resume'>Resume</option>
                                                                    ";
                                                                echo " <option value='Work Plan>Work Plan </option>";
                                                                echo "<option value='Endorsement Letter'>Endorsement Letter</option>";
                                                                echo "<option value='Response Letter'>Response Letter</option>";
                                                                echo "<option value='Performance Sheet'>Performance Sheet</option>";
                                                                echo "<option value='Narrative'>Narrative</option>";
                                                            }
                                                            else if($row['title'] == "Work Plan") {
                                                                echo " <option value='Work Plan>Work Plan </option>";
                                                                echo "<option value='Recommendation Letter'>Recommendation Letter</option>";
                                                                echo "<option value='Memorandum of Agreement'>Memorandum of Agreement</option>";
                                                                echo "<option value='Resume'>Resume</option>
                                                                    ";
                                                                echo "<option value='Accomplishment Report'>Accomplishment Report</option>";
                                                                echo "<option value='Endorsement Letter'>Endorsement Letter</option>";
                                                                echo "<option value='Response Letter'>Response Letter</option>";
                                                                echo "<option value='Performance Sheet'>Performance Sheet</option>";
                                                                echo "<option value='Narrative'>Narrative</option>";
                                                            }
                                                            
                                                            else if($row['title'] == "Performance Sheet"){
                                                                echo "<option value='Performance Sheet'>Performance Sheet</option>";
                                                                echo "<option value='Recommendation Letter'>Recommendation Letter</option>";
                                                                echo "<option value='Memorandum of Agreement'>Memorandum of Agreement</option>";
                                                                echo "<option value='Resume'>Resume</option>
                                                                    ";
                                                                echo "<option value='Accomplishment Report'>Accomplishment Report</option>";
                                                                echo " <option value='Work Plan>Work Plan </option>";
                                                                echo "<option value='Endorsement Letter'>Endorsement Letter</option>";
                                                                echo "<option value='Response Letter'>Response Letter</option>";
                                                                echo "<option value='Narrative'>Narrative</option>";
                                                            }
                                                            else if($row['title'] == "Response Letter") {
                                                                echo "<option value='Response Letter'>Response Letter</option>";
                                                                echo "<option value='Narrative'>Narrative</option>";
                                                                echo "<option value='Accomplishment Report'>Accomplishment Report</option>";
                                                                echo "<option value='Endorsement Letter'>Endorsement Letter</option>";
                                                                echo "<option value='Work Plan'>Work Plan</option>";
                                                                echo "<option value='Accomplishment Report'>Accomplishment Report</option>";
                                                                echo "<option value='Memorandum of Agreement'>Recommendation Letter</option>";
                                                                echo "<option value='Resume'>Resume</option>
                                                                    ";
                                                                echo "<option value='Recommendation Letter'>Recommendation Letter</option>
                                                                    ";
                                                            }
                                                            else if($row['title'] == "Narrative") {
                                                                echo "<option value='Narrative'>Narrative</option>";
                                                                echo "<option value='Recommendation Letter'>Recommendation Letter</option>";
                                                                echo "<option value='Memorandum of Agreement'>Memorandum of Agreement</option>";
                                                                echo "<option value='Resume'>Resume</option>
                                                                    ";
                                                                echo "<option value='Accomplishment Report'>Accomplishment Report</option>";
                                                                echo " <option value='Work Plan>Work Plan </option>";
                                                                echo "<option value='Endorsement Letter'>Endorsement Letter</option>";
                                                                echo "<option value='Response Letter'>Response Letter</option>";
                                                                echo "<option value='Performance Sheet'>Performance Sheet</option>";
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                                <hr>
                                                <div class="form-group">
                                                <label>Instructions: <span style="color: red">*</span></label>
                                                    <textarea name="instructions" class="form-control" id="instructions" rows="15" aria-describedby="" placeholder="Write the Instructions here" required=""><?php echo $row['instructions'];?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Attached File</label>: <br>
                                                    <?php if($row['sample_file'] != ""){?><b><a href="upload_docs/<?php echo $row['sample_file'];?>" title="Download File"><i  class="fa fa-file"></i> <?php echo $row['sample_file'];?></a> </b><?php } else { echo "<b style='color: red;'>There's no attached file</b>";}?>
                                                </div>
                                                <hr>
                                                <div class="form-group">
                                                    <label>Upload New Attachment File:</label>
                                                    <input style="" type="file" name="sample_file" class="form-control" id="sample_file" aria-describedby="" placeholder="">
                                                </div>
                                                <hr>
                                                <div class="form-group">
                                                <label>Date of Submission: <span style="color: red">*</span></label>
                                                    <input type="date" value="<?php
                                                        echo $row['date_of_submission'];?>"  id="duedate" name="duedate" class="form-control" required>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <b><span></span></b>
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

<?php
    if (isset($_SESSION['success'])) {?>
        <script>
            swal.fire({
             icon: 'success',
             type : 'success',
             title : 'Requirement Created Successfully for Students',
             text : '<?php echo $_SESSION['success']?>'
         })
        </script>
    <?php unset($_SESSION['success']);
    }
?>
<?php
    if (isset($_SESSION['updated'])) {?>
        <script>
            swal.fire({
             icon: 'success',
             type : 'success',
             title : 'Requirement Created Successfully',
             text : '<?php echo $_SESSION['updated']?>'
         })
        </script>
    <?php unset($_SESSION['updated']);
    }
?>

<?php
    if (isset($_SESSION['deleted'])) {?>
        <script>
            swal.fire({
             icon: 'success',
             type : 'success',
             title : 'Requirement Removed Successfully',
             text : '<?php echo $_SESSION['deleted']?>'
         })
        </script>
    <?php unset($_SESSION['deleted']);
    }
?>


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
    <a class="scroll-to-top rounded" style="text-decoration:none;" href="#page-top">
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

<script>
$('.del-btn').on('click',function(e){
    e.preventDefault();
    const href = $(this).attr('href') 
    Swal.fire({
        title: 'Are you sure to remove this?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, remove it!'
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
         title : 'Requirement Created Successfully for Your Students',
         text : 'Requirement has been created!'
     })
 }

 const flashdata3 = $('.flash-data3').data('flashdata')
 if(flashdata3){
     swal.fire({
         icon: 'success',
         type : 'success',
         title : 'Requirement Was Successfully Updated',
         text : 'Requirement has been updated!'
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
//logout modal 
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