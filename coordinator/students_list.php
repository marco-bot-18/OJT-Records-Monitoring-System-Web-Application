<style>
  #tra {
    color: #333333;
  }

  #tra:hover {
    color: black;
    background: #f2f2f2;
  }

  #stud_status {
    border: 1px solid gray;
    color: #333333;
  }

  #stud_status:focus {
    border: 1px solid #006bb3;
    box-shadow: none;
    outline-offset: 0px;
    outline: none;
    color: black;
  }
</style>

<?php
include('includes/session.php');
include('includes/header.php'); ?>
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

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Heading -->
  <div class="sidebar-heading">
    Manage
  </div>

  <li class="nav-item active">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">

      <i class="fas fa-fw fa-users"></i>
      <span>My Students</span>
    </a>
    <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Manage</h6>
        <a class="collapse-item active" href="students_list.php">Master List</a>
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
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAnnouncements" aria-expanded="true" aria-controls="collapseUtilities">
      <i class="fas fa-fw fa-calendar"></i>
      <span>My Announcement</span></a>
    </a>
    <div id="collapseAnnouncements" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Category</i></h6>
        <a class="collapse-item" href="announcement_for_today.php">Today</a>
        <a class="collapse-item" href="announcements_history.php">All</a>
      </div>
    </div>
  </li>

  <li class="nav-item">
    <a class="nav-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo" href="#">
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
    <a class="nav-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseTwo" href="#">
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


  <!-- Nav Item - Collapse Menu -->
  <li class="nav-item">
    <a class="nav-link" href="student_account.php">
      <i class="fas fa-fw fa-users"></i>
      <span>Student Account Management</span></a>
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
    <h1 class="h3 mb-0 text-gray-800"><span><b>My Students</b> / Master List</span></h1>
  </div>

  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">
        <h6 class="m-0 font-weight-bold text-primary">
          <h style="color: #333333; font-size: 18px;">Want to create an account for student?</h><br>
          <br>
          <a class="btn btn-primary" href="student_account.php">
            Click Here <i class="fas fa-plus-square"></i></a>
        </h6>
      </h6>
    </div>
    <div class="card-header py-3" style="background: #595959;">
      <h6 class="m-0 font-weight-bold" style="color: ghostwhite;">
        <i class="fas fa-user-graduate"></i> List of Students :
        <?php
        $isArchive = "not archive";
        $active = "active";
        $teacher_name = $_SESSION['coordinator_fullname_session'];
        $sql = "SELECT * FROM tbl_students where status='$active' and archived='$isArchive' and coordinator='$teacher_name' ";
        $query = $conn->query($sql);
        echo $query->num_rows;
        ?>
      </h6>
    </div>
    <!-- table -->
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover" id="example1" width="100%" cellpadding="10" style="color:  #333333;">
          <thead>
            <tr>
              <center>
                <th>No.</th>
                <th>Photo</th>
                <th>Student ID</th>
                <th>Student Name</th>
                <th>Course, Yr & Section</th>
                <th>Status</th>
                <th>Action</th>
              </center>
            </tr>
          </thead>
          <tbody>

            <?php
            //concatinating the name of instructor
            $count = 1;
            $id1 = $_SESSION['coordinator_id'];
            $sql1 = "SELECT Concat(fname, ' ', mname,' ', lname, ' ', '(',coordinator_id,')') AS fullname FROM tbl_coordinators where coordinator_id = '$id1'";
            $query1 = $conn->query($sql1);

            while ($row1 = $query1->fetch_assoc()) {
              $_SESSION['coordinator_fullname'] = $row1['fullname'];
            }

            $_coordinator = $_SESSION['coordinator_fullname'];
            require_once('includes/db_connect.php');
            $isArchived = "not archive";
            $sql = "SELECT * FROM tbl_students where archived='$isArchived' and coordinator='$_coordinator' ORDER BY id ASC";
            $query = $conn->query($sql);
            while ($row = $query->fetch_assoc()) {
              $id = $row['stud_id'];
              $status = $row['status'];
            ?>
              <tr id="tra">
                <td><?php echo $count; ?> </td>
                <td><img src="../admin/uploaded_images/<?php echo $row['image']; ?>" alt="" style="margin-right: 50px;border-radius: 50%;" id="image1" width="50px;" height="50px;"> </td>
                <td><?php echo $id; ?></td>
                <td><?php echo $row['lname'] . ", " . $row['fname'] . " " . $row['mname']; ?></td>
                <td width="20%"><?php echo $row['course']; ?></td>
                <td>
                  <?php
                  if ($status == 'dropped') {
                    echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-danger'>DROPPED</span>";
                  } else if ($status == 'active') {
                    echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-success'>ACTIVE</span>";
                  } else if ($status == 'incomplete') {
                    echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-warning'>INCOMPLETE</span>";
                  }
                  ?>
                </td>
                <td>
                  <a href="#edit<?= $id; ?>" title="Update Student's Status" data-toggle="modal" data-id="" class="btn btn-dark"><i class="fas fa-user-edit"></i></a>
                  <a href="#view<?= $id; ?>" title="View Student's Info" data-toggle="modal" data-id="" class="btn btn-info"><i class="fas fa-eye"></i></a>
                </td>
              </tr>

              <div class="modal fade " id="edit<?= $id; ?>" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" style="color: #0d6efd;">
                        <h><i class="fas fa-user-edit"></i> Update the Status of <?php echo $row['lname'] . ", " . $row['fname'] . " " . $row['mname'] . " (" . $row['stud_id'] . ")"; ?> </h>
                      </h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <form action="student_status_update.php" method="POST">
                        <input type="text" name="stud_fullname" value="<?php echo $row['lname'] . ", " . $row['fname'] . " " . $row['mname']; ?>" hidden>
                        <input type="text" name="id" value="<?php echo $row['id'] ?>" hidden>
                        <div class="form-group">
                          <select name="stud_status" class="form-control" id="stud_status">
                            <?php
                            if ($row['status'] == "dropped") {
                              echo "<option value='dropped'>Dropped</option>";
                              echo "<option value='active'>Active</option>";
                              echo "<option value='incomplete'>Incomplete</option>";
                            }
                            if ($row['status'] == "active") {
                              echo "<option value='active'>Active</option>";
                              echo "<option value='dropped'>Dropped</option>";
                              echo "<option value='incomplete'>Incomplete</option>";
                            }
                            if ($row['status'] == "incomplete") {
                              echo "<option value='incomplete'>Incomplete</option>";
                              echo "<option value='active'>Active</option>";
                              echo "<option value='dropped'>Dropped</option>";
                            }
                            ?>
                          </select>
                        </div>
                    </div>
                    <div class="modal-footer modal-lg">
                      <button type="submit" name="update_status" class="btn btn-primary">
                        Update Status <i class="fas fa-user-edit"></i>
                      </button>
                      <button type="button" class="btn btn-danger" data-dismiss="modal">
                        Close <i class="fas fa-times-circle"></i>
                      </button>
                    </div>
                    </form>
                  </div>
                </div>
              </div>

              <!-- View Student Modal -->
              <div class="modal fade bd-example-modal-lg" id="view<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content modal-lg">
                    <div class="modal-header modal-lg">
                      <h5 class="modal-title" style="color: #0d6efd;">
                        <h><i class="fas fa-user-graduate"></i> View Student's Details</h>
                      </h5>
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
                            <font style="font-weight: bold; "><?php echo $row['fname'] . " " . $row['mname'] . " " . $row['lname']; ?></font>
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
                            <label>OJT Teacher :</label>
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
                            <font>
                              <?php
                              if ($status == 'dropped') {
                                echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-danger'>NOT ACTIVE</span>";
                              } else if ($status == 'active') {
                                echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-success'>ACTIVE</span>";
                              } else if ($status == 'incomplete') {
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
                    </div>
                    <!-- form end -->
                    </form>
                  </div>
                </div>
              </div>

            <?php
              $count++;
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</div>



<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" style="text-decoration: none;" href="#page-top">
  <i class="fas fa"></i>
  <i class="fas fa-angle-up"></i>
  <i class="fas fa"></i>
</a>


<!-- Message Box JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

<?php
if (isset($_SESSION['status_updated'])) { ?>
  <script>
    swal.fire({
      icon: 'success',
      type: 'success',
      title: 'Student Status Update Successfully!',
      text: '<?php echo $_SESSION['status_updated'] ?>'
    })
  </script>
<?php unset($_SESSION['status_updated']);
}
?>


</script>

<?php
//logout modal 
include('includes/logout-modal.php');
?>

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>