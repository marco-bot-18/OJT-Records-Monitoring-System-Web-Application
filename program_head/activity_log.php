<style type="text/css">
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
                    <span>Documents For Signing</span>
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
                        <a class="collapse-item" href="#">My Announcements</a>
                        <a class="collapse-item" href="#">Announcements</a>
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

        <!-- Logout Modal-->

<?php 
include('includes/topbar.php');
?>
 
<div class="container-fluid">
<!-- Page Heading -->
    
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><span><b>Activity Log</b></span></h1>
    </div>

    <!-- Show Table Area -->
    <div class="card shadow mb-4">
        <div class="card-header py-3" style="background: #595959;">
            <h6 class="m-0 font-weight-bold" style="color: ghostwhite;">
              <i class="fas fa-list"></i> My Logs
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="dataTable"  width="100%" cellspacing="10"  id="example1" style="color: #333333;">
                  <thead>
                    <tr>                      
                      <th>Activity</th>
                      <th>Date</th>
                      <th>Time</th>                      
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                    session_start();
                    require_once('includes/db_connect.php');
                    $coordinator_id = $_SESSION['coordinator_id'];
                    $sql = "SELECT * from tbl_activity_log WHERE by_='$coordinator_id' ORDER BY id DESC";
                    $query = $conn->query($sql);
                    while($row = $query->fetch_assoc()){
                  ?>
                    <tr id="tra">
                      <td width="50%"><?php echo $row['activity'];?></td>
                      <td><?php echo $row['date_'];?></td>
                      <td><?php echo $row['time_'];?></td>
                    </div> 
                    <!-- end tag modal -->
                    </tr>
                    <?php  } ?> 
                  </tbody>
                </table>
            </div>
        </div>
        </div>
    </div>
</div>

<?php 
include('includes/logout-modal.php');
?>
<?php
include('includes/scripts.php');
include('includes/footer.php');
?>
