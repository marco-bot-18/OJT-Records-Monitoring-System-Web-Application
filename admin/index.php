<?php
//header('location: index.php');
include('includes/session.php');
require_once('includes/header.php');
require_once('includes/db_connect.php');
?>
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
            <li class="nav-item active">
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

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"><b>Dashboard</b></h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <div class="col-xl-12 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div style="text-align: right; color: ghostwhite; font-size: 16px; padding-right: 5px;">
                                    <span class="badge">
                                        
                                    </span>
                                </div>
                                <div class="card-body">
                                     <div class="text-xl font-weight-bold text-info text-uppercase mb-1">
                                        <a class="text-xl font-weight-bold text-info text-uppercase mb-1" href='my_account.php'>Welcome Back, <?php echo $_SESSION['admin_fname'];?>
                                        </a>
                                     </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                            </div>
                                            <div class="h6 mb-0 font-weight-bold text-gray-800">
                                                <div title="OJT Teacher Name and ID">
                                                   <i class="fas fa-id-card-alt text-info"></i>&nbsp;My Employee ID is <?php echo $_SESSION['admin_username'];?>
                                                </div>
                                                <div title="Name and ID">
                                                   <i class="fas fa-user-tie text-info"></i>&nbsp;<?php echo "My Name is ".$_SESSION['admin_fname']." ".$_SESSION['admin_mname']. " ".$_SESSION['admin_lname']; ?></b>
                                                </div>
                                                <div title="Position">
                                                    <i class="fas fa-book-reader text-info"></i>&nbsp;&nbsp;I am the College Dean
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <!-- <i class="fas fa-user fa-2x text-black-300"></i> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        <!-- DOCUMENTS THAT ARE NOT YET APPROVED -->
                        <div class="col-xl-6 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div style="text-align: right; color: ghostwhite; font-size: 16px; padding-right: 5px;">
                                    <span class="badge badge bg-danger"><!-- badge badge bg-danger -->
                                        <?php
                                            $work_stats = "semi-pending3";
                                            $send_to_dean = "dean";
                                            $stats = "not archived";
                                            $submitted = "yes";
                                            $count = 1;
                                            $sql = "SELECT * from tbl_students_work where send_to_Dean='$send_to_dean' and work_status='$work_stats' and submitted='$submitted' and status='$stats'";
                                            $query = $conn->query($sql);
                                            if($query->num_rows==0){
                                                echo "<a style='color: ghostwhite' href='request_docs_pending.php'>".$query->num_rows."</a>";
                                            }
                                            else{
                                                echo "<a style='color: ghostwhite' href='request_docs_pending.php'>". $query->num_rows."+ </a>";
                                            }
                                        ?>  
                                    </span>
                                </div>
                                <div class="card-body">
                                    <div class="text-xl font-weight-bold text-warning text-uppercase mb-1">
                                        <a class="text-xl font-weight-bold text-warning text-uppercase mb-1" href='request_docs_pending.php'>Pending Documents for signature</a>
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                                All
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                session_start();
                                                  $work_stats = "semi-pending3";
                                                    $send_to_dean = "dean";
                                                    $stats = "not archived";
                                                    $submitted = "yes";
                                                    $count = 1;
                                                    $sql = "SELECT * from tbl_students_work where send_to_Dean='$send_to_dean' and work_status='$work_stats' and submitted='$submitted' and status='$stats'";
                                                    $query = $conn->query($sql);
                                                    if($query->num_rows==0){
                                                        echo "<h6><b>Congrats! There's No Pending Documents That Are Not Yet Approved.</b><h6>";
                                                    }
                                                    else{
                                                        echo "<h6><b><a class='font-weight-bold text-gray-800' href='request_docs_completed.php'> There's ".$query->num_rows." Pending Documents! Please Click Here To View!</a></b></h6>";
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-file-alt fa-2x text-black-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div style="text-align: right; color: ghostwhite; font-size: 16px; padding-right: 5px;">
                                    <span class="badge badge bg-danger">
                                        <?php
                                            $work_stats1 = "completed";
                                            $send_to_dean = "dean";
                                            $stats = "not archived";
                                            $send_to_dean = "dean";
                                            $submitted = "yes";
                                            $count = 1;
                                            $sql = "SELECT * from tbl_students_work where (send_to_Dean='$send_to_dean' and work_status='$work_stats1' and submitted='$submitted' and status='$stats') order by id asc";
                                            $query = $conn->query($sql);
                                            if($query->num_rows==0){
                                                echo "<a style='color: ghostwhite' href='request_docs_completed.php'>".$query->num_rows."</a>";
                                            }
                                            else{
                                                echo "<a style='color: ghostwhite' href='request_docs_completed.php'>". $query->num_rows."+ </a>";
                                            }
                                        ?>  
                                    </span>
                                </div>
                                <div class="card-body">
                                    <div class="text-xl font-weight-bold text-success text-uppercase mb-1">
                                        <a class="text-xl font-weight-bold text-success text-uppercase mb-1" href='request_docs_completed.php'>Signed and Approved Documents</a>
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                                All
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                    session_start();
                                                    $work_stats1 = "completed";
                                                    $send_to_dean = "dean";
                                                    $stats = "not archived";
                                                    $send_to_dean = "dean";
                                                    $submitted = "yes";
                                                    $count = 1;
                                                    $sql = "SELECT * from tbl_students_work where (send_to_Dean='$send_to_dean' and work_status='$work_stats1' and submitted='$submitted' and status='$stats') order by id asc";
                                                    $query = $conn->query($sql);
                                                    if($query->num_rows==0){
                                                        echo $query->num_rows;
                                                    }
                                                    else{
                                                        echo "<h6><b><a class='font-weight-bold text-gray-800' href='request_docs_completed.php'> There's ".$query->num_rows." Documents "."That Are Already Signed and Approved! Click Here To View!</a></b></h6>";
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-file-signature fa-2x text-black-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    

                         <!-- total students -->
                        <div class="col-xl-6 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div style="text-align: right; color: ghostwhite; font-size: 16px; padding-right: 5px;">
                                    <span class="badge">
                                        
                                    </span>
                                </div>
                                <div class="card-body">
                                     <div class="text-xl font-weight-bold text-primary text-uppercase mb-1">
                                        <a class="text-xl font-weight-bold text-primary text-uppercase mb-1" href='students_list_all.php'>OJT Students
                                        </a>
                                     </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                                All
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                    $active = "active";
                                                    $not_archived = "not archive";
                                                    $sql = "SELECT * FROM tbl_students where archived='$not_archived'";
                                                    $query = $conn->query($sql);
                                                    echo $query->num_rows;
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-2x text-black-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                 <div style="text-align: right; color: ghostwhite; font-size: 16px; padding-right: 5px;">
                                    <span class="badge">
                                        
                                    </span>
                                </div>
                                <div class="card-body">
                                     <div class="text-xl font-weight-bold text-warning text-uppercase mb-1"> <a class="text-xl font-weight-bold text-warning text-uppercase mb-1" href='students_list_active.php'>Students</a></div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                                Active
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                    $active = "active";
                                                    $sql = "SELECT * FROM tbl_students where status='$active'";
                                                    $query = $conn->query($sql);
                                                    echo $query->num_rows;
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-2x text-black-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                       <!--  <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                 <div style="text-align: right; color: ghostwhite; font-size: 16px; padding-right: 5px;">
                                    <span class="badge"> 
                                    </span>
                                </div>
                                <div class="card-body">
                                     <div class="text-xl font-weight-bold text-warning text-uppercase mb-1"> <a class="text-xl font-weight-bold text-warning text-uppercase mb-1" href='students_list_active.php'>Students</a></div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                                Not Active
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                    $not_active = "not active";
                                                    $sql = "SELECT * FROM tbl_students where status='$not_active' and archived='$not_archived'";
                                                    $query = $conn->query($sql);
                                                    echo $query->num_rows;
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-2x text-black-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
 -->
                        <div class="col-xl-6 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div style="text-align: right; color: ghostwhite; font-size: 16px; padding-right: 5px;">
                                    <span class="badge"> 
                                    </span>
                                </div>
                                <div class="card-body">
                                    <div class="text-xl font-weight-bold text-primary text-uppercase mb-1"> <a class="text-xl font-weight-bold text-primary text-uppercase mb-1" href='coordinators_list_all.php'>OJT Teachers</a></div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                                </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                    $sql = "SELECT * FROM tbl_coordinators where status='$active'";
                                                    $query = $conn->query($sql);

                                                    echo $query->num_rows;
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-2x text-black-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-12 col-md-6 mb-4">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold" style="color: #990000;"><i class="fas fa-chart-bar"></i> Graphical Representation of OJT Students' Requirements</h6>
                                </div>
                                    <div class="card-body" style="background-color: white;">
                                        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                                        <script type="text/javascript">
                                               <?php
                                                $stats = "not archived";

                                                //recommendation letter
                                                include 'includes/session.php';
                                                $recommendation_letter = "Recommendation Letter";
                                                $not_submitted = "no";
                                                $sql = "select * from tbl_students_work where title ='$recommendation_letter' and submitted = '$not_submitted' and status = '$stats'";
                                                $query = $conn->query($sql);
                                                // 
                                                $submitted = "yes";
                                                $semi_pending = "semi-pending";
                                                $semi_pending2 = "semi-pending2";
                                                $semi_pending3 = "semi-pending3";
                                                $sql1 = "select * from tbl_students_work where (title='$recommendation_letter' and submitted='$submitted' and status = '$stats' and work_status = '$semi_pending') OR (title='$recommendation_letter' and submitted='$submitted' and status = '$stats' and work_status = '$semi_pending2') OR (title='$recommendation_letter' and submitted='$submitted' and status = '$stats' and work_status = '$semi_pending3')";
                                                $query1 = $conn->query($sql1);
                                                // 
                                                $submitted = "yes";
                                                $completed = "completed";
                                                $sql2 = "select * from tbl_students_work where title='$recommendation_letter' and submitted='$submitted' and work_status='$completed' and status = '$stats'";
                                                $query2 = $conn->query($sql2);

                                              // ------------------------------------------------------------

                                                //resume
                                                //not yet submitted and pending
                                                $not_submitted = "no";
                                                $resume = "Resume";
                                                $sql3 = "select * from tbl_students_work where title = '$resume' and submitted = '$not_submitted' and status = '$stats'";
                                                $query3 = $conn->query($sql3);
                                                
                                                // submitted but not completed
                                                $resume = "Resume";
                                                $submitted = "yes";
                                                $semi_pending = "semi-pending";
                                                $semi_pending2 = "semi-pending2";
                                                $semi_pending3 = "semi-pending3";
                                                $sql4 = "select * from tbl_students_work where (title='$resume' and submitted='$submitted' and status = '$stats' and work_status = '$semi_pending') OR (title='$resume' and submitted='$submitted' and status = '$stats' and work_status = '$semi_pending2')";
                                                $query4 = $conn->query($sql4);
                                                
                                                // completed
                                                $completed = "completed";
                                                $resume = "Resume";
                                                $sql5 = "select * from tbl_students_work where title='$resume' and submitted='$submitted' and work_status='$completed' and status = '$stats'";
                                                $query5 = $conn->query($sql5);


                                                // ------------------------------------------------------------

                                                //moa
                                                //not yet submitted and pending
                                                $not_submitted = "no";
                                                $moa = "Memorandum of Agreement";
                                                $sql6 = "select * from tbl_students_work where title = '$moa' and submitted = '$not_submitted' and status = '$stats'";
                                                $query6 = $conn->query($sql6);
                                                
                                                // submitted but not completed
                                                $moa = "Memorandum of Agreement";
                                                $submitted = "yes";
                                                $semi_pending = "semi-pending";
                                                $semi_pending2 = "semi-pending2";
                                                $semi_pending3 = "semi-pending3";
                                                $sql7 = "select * from tbl_students_work where (title='$moa' and submitted='$submitted' and status = '$stats'  and work_status = '$semi_pending') OR (title='$moa' and submitted='$submitted' and status = '$stats'  and work_status = '$semi_pending2')";
                                                $query7 = $conn->query($sql7);
                                                
                                                // completed
                                                $completed = "completed";
                                                $moa = "Memorandum of Agreement";
                                                $sql8 = "select * from tbl_students_work where title='$moa' and submitted='$submitted' and work_status='$completed' and status = '$stats'";
                                                $query8 = $conn->query($sql8);

                                                // ------------------------------------------------------------

                                                //work plan
                                                //not yet submitted and pending
                                                $not_submitted = "no";
                                                $work_plan = "Work Plan";
                                                $sql9 = "select * from tbl_students_work where title = '$work_plan' and submitted = '$not_submitted' and status = '$stats'";
                                                $query9 = $conn->query($sql9);
                                                
                                                // submitted but not completed
                                                $work_plan = "Work Plan";
                                                $submitted = "yes";
                                                $semi_pending = "semi-pending";
                                                $semi_pending2 = "semi-pending2";
                                                $semi_pending3 = "semi-pending3";
                                                $sql10 = "select * from tbl_students_work where (title='$work_plan' and submitted='$submitted' and status = '$stats' and work_status = '$semi_pending') OR (title='$work_plan' and submitted='$submitted' and status = '$stats' and work_status = '$semi_pending2')";
                                                $query10 = $conn->query($sql10);
                                                
                                                // completed
                                                $completed = "completed";
                                                $work_plan = "Work Plan";
                                                $sql11 = "select * from tbl_students_work where title='$work_plan' and submitted='$submitted' and work_status='$completed' and status = '$stats'";
                                                $query11 = $conn->query($sql11);

                                                // ------------------------------------------------------------

                                                //narrative
                                                //not yet submitted and pending
                                                $not_submitted = "no";
                                                $narrative = "Narrative";
                                                $sql12 = "select * from tbl_students_work where title = '$narrative' and submitted = '$not_submitted' and status = '$stats'";
                                                $query12 = $conn->query($sql12);
                                                
                                                // submitted but not completed
                                                $narrative = "Narrative";
                                                $submitted = "yes";
                                                $semi_pending = "semi-pending";
                                                $semi_pending2 = "semi-pending2";
                                                $semi_pending3 = "semi-pending3";
                                                $sql13 = "select * from tbl_students_work where (title='$narrative' and submitted='$submitted' and status = '$stats' and work_status = '$semi_pending') OR (title='$narrative' and submitted='$submitted' and status = '$stats' and work_status = '$semi_pending2')";
                                                $query13 = $conn->query($sql13);
                                                
                                                // completed
                                                $completed = "completed";
                                                $narrative = "Narrative";
                                                $sql14 = "select * from tbl_students_work where title='$narrative' and submitted='$submitted' and work_status='$completed' and status = '$stats'";
                                                $query14 = $conn->query($sql14);

                                                // ------------------------------------------------------------

                                                //accomplishment report
                                                //not yet submitted and pending
                                                $not_submitted = "no";
                                                $accomplishment_report = "Accomplishment Report";
                                                $sql15 = "select * from tbl_students_work where title = '$accomplishment_report' and submitted = '$not_submitted' and status = '$stats'";
                                                $query15 = $conn->query($sql15);
                                                
                                                // submitted but not completed
                                                $accomplishment_report = "Accomplishment Report";
                                                $submitted = "yes";
                                                $semi_pending = "semi-pending";
                                                $semi_pending2 = "semi-pending2";
                                                $semi_pending3 = "semi-pending3";
                                                $sql16 = "select * from tbl_students_work where (title='$accomplishment_report' and submitted='$submitted' and status = '$stats' and work_status = '$semi_pending') OR (title='$accomplishment_report' and submitted='$submitted' and status = '$stats' and work_status = '$semi_pending2')";
                                                $query16 = $conn->query($sql16);
                                                
                                                // completed
                                                $completed = "completed";
                                                $accomplishment_report = "Accomplishment Report";
                                                $sql17 = "select * from tbl_students_work where title='$accomplishment_report' and submitted='$submitted' and work_status='$completed' and status = '$stats'";
                                                $query17 = $conn->query($sql17);

                                                // ------------------------------------------------------------

                                                //response letter
                                                //not yet submitted and pending
                                                $not_submitted = "no";
                                                $response_letter = "Response Letter";
                                                $sql18 = "select * from tbl_students_work where title = '$response_letter' and submitted = '$not_submitted' and status = '$stats'";
                                                $query18 = $conn->query($sql18);
                                                
                                                // submitted but not completed
                                                $response_letter = "Response Letter";
                                                $submitted = "yes";
                                                $semi_pending = "semi-pending";
                                                $semi_pending2 = "semi-pending2";
                                                $semi_pending3 = "semi-pending3";
                                                $sql19 = "select * from tbl_students_work where (title='$response_letter' and submitted='$submitted' and status = '$stats' and work_status = '$semi_pending') OR (title='$response_letter' and submitted='$submitted' and status = '$stats' and work_status = '$semi_pending2')";
                                                $query19 = $conn->query($sql19);
                                                
                                                // completed
                                                $completed = "completed";
                                                $response_letter = "Response Letter";
                                                $sql20 = "select * from tbl_students_work where title='$response_letter' and submitted='$submitted' and work_status='$completed' and status = '$stats'";
                                                $query20 = $conn->query($sql20);

                                                // ------------------------------------------------------------

                                                //performance sheet
                                                //not yet submitted and pending
                                                $not_submitted = "no";
                                                $performance_sheet = "Performance Sheet";
                                                $sql21 = "select * from tbl_students_work where title = '$performance_sheet' and submitted = '$not_submitted' and status = '$stats'";
                                                $query21 = $conn->query($sql21);
                                                
                                                // submitted but not completed
                                                $performance_sheet = "Performance Sheet";
                                                $submitted = "yes";
                                                $semi_pending = "semi-pending";
                                                $semi_pending2 = "semi-pending2";
                                                $semi_pending3 = "semi-pending3";
                                                $sql22 = "select * from tbl_students_work where (title='$performance_sheet' and submitted='$submitted' and status = '$stats' and work_status = '$semi_pending') OR (title='$performance_sheet' and submitted='$submitted' and status = '$stats' and work_status = '$semi_pending2')";
                                                $query22 = $conn->query($sql22);
                                                
                                                // completed
                                                $completed = "completed";
                                                $performance_sheet = "Performance Sheet";
                                                $sql23 = "select * from tbl_students_work where title='$performance_sheet' and submitted='$submitted' and work_status='$completed' and status = '$stats'";
                                                $query23 = $conn->query($sql23);


                                                // ------------------------------------------------------------

                                                //endorsement letter
                                                //not yet submitted and pending
                                                $not_submitted = "no";
                                                $endorsement_letter = "Endorsement Letter";
                                                $sql24 = "select * from tbl_students_work where title = '$endorsement_letter' and submitted = '$not_submitted' and status = '$stats'";
                                                $query24 = $conn->query($sql24);
                                                
                                                // submitted but not completed
                                                $endorsement_letter = "Endorsement Letter";
                                                $submitted = "yes";
                                                $semi_pending = "semi-pending";
                                                $semi_pending2 = "semi-pending2";
                                                $semi_pending3 = "semi-pending3";
                                                $sql25 = "select * from tbl_students_work where title='$endorsement_letter' and submitted='$submitted' and status = '$stats' and (work_status = '$semi_pending') OR (work_status = '$semi_pending2')";
                                                $query25 = $conn->query($sql25);
                                                
                                                // completed
                                                $completed = "completed";
                                                $endorsement_letter = "Endorsement Letter";
                                                $sql26 = "select * from tbl_students_work where title='$endorsement_letter' and submitted='$submitted' and work_status='$completed' and status = '$stats'";
                                                $query26 = $conn->query($sql26);

                                               ?>

                                          google.charts.load('current', {'packages':['bar']});
                                          google.charts.setOnLoadCallback(drawChart);

                                          function drawChart() {
                                            var data = google.visualization.arrayToDataTable([
                                              ['Requirements', 'Completed', 'Not Yet Submitted', 'Submitted (Pending Status)'],
                                              ['Recommendation Letter', <?php echo $query2->num_rows;?>, <?php echo $query->num_rows;?>, <?php echo $query1->num_rows; ?>],
                                              
                                              ['Resume', <?php echo $query5->num_rows;?>, <?php echo $query3->num_rows;?>, <?php echo $query4->num_rows;?>],

                                              ['MOA (for off campus)', <?php echo $query8->num_rows;?>, <?php echo $query6->num_rows;?>, <?php echo $query7->num_rows;?>],
                                              ['Work Plan', <?php echo $query11->num_rows;?>, <?php echo $query9->num_rows;?>, <?php echo $query10->num_rows;?>],

                                              ['Narrative', <?php echo $query14->num_rows;?>, <?php echo $query12->num_rows;?>, <?php echo $query13->num_rows;?>],

                                              ['Accomplishment Report', <?php echo $query17->num_rows;?>, <?php echo $query15->num_rows;?>, <?php echo $query16->num_rows;?>],

                                              ['Response Letter', <?php echo $query20->num_rows;?>, <?php echo $query18->num_rows;?>, <?php echo $query19->num_rows;?>],

                                              ['Performance Sheet', <?php echo $query23->num_rows;?>, <?php echo $query21->num_rows;?>, <?php echo $query22->num_rows;?>],
                                              ['Endorsement Letter', <?php echo $query26->num_rows;?>, <?php echo $query24->num_rows;?>, <?php echo $query25->num_rows;?>]
                                            ]);

                                            var options = {
                                              chart: {
                                                title: 'OJT Students Requirements Bar Chart',
                                                subtitle: '',
                                              },
                                              bars: 'horizontal' // Required for Material Bar Charts.
                                            };

                                            var chart = new google.charts.Bar(document.getElementById('barchart_material'));

                                            chart.draw(data, google.charts.Bar.convertOptions(options));
                                          }
                                        </script>
                                        <div id="barchart_material" style="width: 1200px; height: 1200px;"></div>
                                </div>
                            </div>
                        </div>


                        <div class="col-xl-12 col-md-6 mb-4">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold" style="color: #990000;"><i class="fas fa-chart-bar"></i> Graphical Representation of In-Campus and Off-Campus OJT Students</h6>
                                </div>
                                    <div class="card-body" style="background-color: white;">
                                        <script type="text/javascript">
                                          google.charts.load('current', {'packages':['bar']});
                                          google.charts.setOnLoadCallback(drawStuff);

                                          <?php
                                            $in_campus = "In-Campus";
                                            $not_archived = "not archive";
                                            $sql = "SELECT * FROM tbl_students where in_off_campus ='$in_campus' and archived='$not_archived'";
                                            $query_in_campus = $conn->query($sql);

                                            $off_campus = "Off-Campus";
                                            $not_archived = "not archive";
                                            $sql = "SELECT * FROM tbl_students where in_off_campus ='$off_campus' and archived='$not_archived'";
                                            $query_off_campus = $conn->query($sql);
                                          ?>

                                          function drawStuff() {
                                            var data = new google.visualization.arrayToDataTable([
                                              ['Students', 'Total'],
                                              ["In-Campus", <?php echo $query_in_campus->num_rows; ?>],
                                              ["Off-Campus", <?php echo $query_off_campus->num_rows; ?>]
                                            ]);

                                            var options = {
                                              title: 'OJT Students',
                                              width: 900,
                                              legend: { position: 'none' },
                                              chart: { title: 'In-Campus and Off-Campus OJT Students Bar Chart',
                                                       subtitle: '' },
                                              bars: 'vertical', // Required for Material Bar Charts.
                                              axes: {
                                                x: {
                                                  0: { side: 'top', label: 'OJT Students'} // Top x-axis.
                                                }
                                              },
                                              bar: { groupWidth: "90%" }
                                            };

                                            var chart = new google.charts.Bar(document.getElementById('top_x_div'));
                                            chart.draw(data, options);
                                          };
                                        </script>
                                        <div id="top_x_div" style="width: 900px; height: 500px;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-12 col-md-6 mb-4">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold" style="color: #990000;"><i class="fas fa-chart-bar"></i> Graphical Representation of Sections and Specializations in College of Computer Studies </h6>
                                </div>
                                <div class="card-body" style="background-color: white;">
                                    <script type="text/javascript">
                                        google.charts.load('current', {'packages':['bar']});
                                        google.charts.setOnLoadCallback(drawStuff);

                                        function drawStuff() {
                                        var data = new google.visualization.arrayToDataTable([
                                            ['Sections & Specialization', 'Total'],
                                            <?php
                                            $not_archived = "not archived";
                                            $query="select * from tbl_courses where archived='$not_archived'";
                                            $res=mysqli_query($conn,$query);
                                            while($row=mysqli_fetch_array($res)){
                                                $course=$row['course_title'];

                                                $not_archived = "not archive";
                                                $sql = "SELECT * FROM tbl_students where archived='$not_archived' and course ='$course'";
                                                $query_students_section = $conn->query($sql);
                                            ?>
                                            ['<?php echo $course;?>',<?php echo $query_students_section->num_rows;?>],   
                                            <?php   
                                            }
                                            ?> 
                                        ]);

                                        var options = {
                                            title: '',
                                            width: 900,
                                            legend: { position: 'none' },
                                            chart: { title: ' Sections and Specializations in College in Computer Studies Bar Chart',
                                                    subtitle: ' ' },
                                            bars: 'horizontal', // Required for Material Bar Charts.
                                            axes: {
                                            x: {
                                                0: { side: 'top', label: ''} // Top x-axis.
                                            }
                                            },
                                            bar: { groupWidth: "90%" }
                                        };

                                        var chart = new google.charts.Bar(document.getElementById('top_x_div11'));
                                        chart.draw(data, options);
                                        };
                                    </script>
                                    <div id="top_x_div11" style="width: 900px; height: 500px;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-12 col-md-6 mb-4">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold" style="color: #990000;"><i class="fas fa-chart-bar"></i> Graphical Representation of Total Number of Students Handle by Each OJT Teacher</h6>
                                </div>
                                    <div class="card-body" style="background-color: white;">
                                        <script type="text/javascript">
                                          google.charts.load('current', {'packages':['bar']});
                                          google.charts.setOnLoadCallback(drawStuff);


                                          function drawStuff() {
                                            var data = new google.visualization.arrayToDataTable([
                                              ['Students', 'Total'],
                                              <?php
                                                $userType = "teacher";
                                                $query = "SELECT * from tbl_coordinators WHERE userType='$userType' ORDER BY id DESC";
                                                $res = mysqli_query($conn,$query);
                                                while($row = mysqli_fetch_array($res)){
                                                  $fullname = $row['fname']." ".$row['mname']." ".$row['lname']." (".$row['coordinator_id'].")";

                                                    $not_archived = "not archive";
                                                    $sql = "SELECT * FROM tbl_students WHERE archived='$not_archived' AND coordinator='$fullname' ORDER BY id ASC";
                                                    $query_students = $conn->query($sql);

                                               ?>
                                              ["<?php echo $fullname;?>", <?php echo $query_students->num_rows;?>],
                                              <?php   
                                                }
                                               ?> 
                                            ]);

                                            var options = {
                                              title: 'OJT Students',
                                              width: 900,
                                              legend: { position: 'none' },
                                              chart: { title: 'Total Number of Students Handled by Each OJT Teacher Bar Chart',
                                                       subtitle: '' },
                                              bars: 'vertical', // Required for Material Bar Charts.
                                              axes: {
                                                x: {
                                                  0: { side: 'top', label: 'OJT Teachers'} // Top x-axis.
                                                }
                                              },
                                              bar: { groupWidth: "90%" }
                                            };

                                            var chart = new google.charts.Bar(document.getElementById('top_x_div1'));
                                            chart.draw(data, options);
                                          };
                                        </script>
                                        <div id="top_x_div1" style="width: 900px; height: 500px;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-12 col-md-6 mb-4">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold" style="color: #990000;"><i class="fas fa-chart-bar"></i> Graphical Representation of Total Number of OJT Students per Program</h6>
                                </div>
                                    <div class="card-body" style="background-color: white;">
                                         <script type="text/javascript">
                                          google.charts.load('current', {'packages':['bar']});
                                          google.charts.setOnLoadCallback(drawStuff);

                                           <?php
                                                $bsit = "BSIT";
                                                $not_archived = "not archive";
                                                $sql = "SELECT * FROM tbl_students where archived='$not_archived' and program = '$bsit'";
                                                $query_students_BSIT = $conn->query($sql);

                                                $bscs = "BSCS";
                                                $not_archived = "not archive";
                                                $sql1 = "SELECT * FROM tbl_students where archived='$not_archived' and program = '$bscs'";
                                                $query_students_BSCS = $conn->query($sql1);
                                           ?>

                                          function drawStuff() {
                                            var data = new google.visualization.arrayToDataTable([
                                              ['', 'BSIT', 'BSCS'],
                                              ['Program', <?php echo $query_students_BSIT->num_rows;?>, <?php echo $query_students_BSCS->num_rows;?>],
                                            ]);

                                            var options = {
                                              width: 800,
                                              chart: {
                                                title: 'Total Number of OJT Students per Program Bar Chart',
                                                subtitle: ''
                                              },
                                              bars: 'vertical', // Required for Material Bar Charts.
                                              
                                             
                                            };

                                          var chart = new google.charts.Bar(document.getElementById('dual_x_div'));
                                          chart.draw(data, options);
                                        };
                                        </script>
                                        <div id="dual_x_div" style="width: 900px; height: 400px;"></div>
                                        <!-- <div id="top_x_div2" style="width: 900px; height: 500px;"></div> -->
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-12 col-md-6 mb-4">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold" style="color: #990000;"><i class="fas fa-chart-bar"></i> Graphical Representation of Students' Status Per Course, Year and Section</h6>
                                </div>
                                    <div class="card-body" style="background-color: white;">
                                        <script type="text/javascript">
                                          google.charts.load('current', {'packages':['bar']});
                                          google.charts.setOnLoadCallback(drawChart);

                                          <?php
                                            $isArchived = "not archive";
                                            $active = "active";
                                            $sql_active = "SELECT * FROM tbl_students where archived='$isArchived' and status='$active'";
                                            $query_active = $conn->query($sql_active);
                                            
                                            $dropped = "dropped";
                                            $sql_dropped = "SELECT * FROM tbl_students where archived='$isArchived' and status='$dropped' ";
                                            $query_dropped = $conn->query($sql_dropped); 

                                            $inc = "incomplete";
                                            $sql_inc = "SELECT * FROM tbl_students where archived='$isArchived' and status='$inc'";
                                            $query_inc = $conn->query($sql_inc); 
                                           ?>

                                          function drawChart() {
                                            var data = google.visualization.arrayToDataTable([
                                            ['<?php echo "Sections and Specializations"?>', 'Active', 'Dropped', 'Incomplete'],
                                             <?php
                                                $query1="select * from tbl_courses";
                                                $res1=mysqli_query($conn,$query1);
                                                while($row=mysqli_fetch_array($res1)){
                                                    $course=$row['course_title'];

                                                    $isArchived = "not archive";
                                                    $active = "active";
                                                    $sql_active = "SELECT * FROM tbl_students where archived='$isArchived' and status='$active' and course='$course'";
                                                    $query_active = $conn->query($sql_active);
                                                    
                                                    $dropped = "dropped";
                                                    $sql_dropped = "SELECT * FROM tbl_students where archived='$isArchived' and status='$dropped' and course='$course' ";
                                                    $query_dropped = $conn->query($sql_dropped); 

                                                    $inc = "incomplete";
                                                    $sql_inc = "SELECT * FROM tbl_students where archived='$isArchived' and status='$inc' and course='$course'";
                                                    $query_inc = $conn->query($sql_inc); 
                                             ?>
                                              ['<?php echo $course; ?>', <?php echo $query_active->num_rows; ?>, <?php echo $query_dropped->num_rows; ?>, <?php echo $query_inc->num_rows; ?>],
                                                <?php } ?>
                                            ]);

                                            var options = {
                                              chart: {
                                                title: 'Students Status Per Section Bar Chart',
                                                subtitle: '',
                                              },
                                              bars: 'horizontal' // Required for Material Bar Charts.
                                            };

                                            var chart = new google.charts.Bar(document.getElementById('barchart_material_student_stats'));

                                            chart.draw(data, google.charts.Bar.convertOptions(options));
                                          }
                                        </script>
                                        <div id="barchart_material_student_stats" style="width: 1200px; height: 500px;"></div>
                                </div>
                            </div>
                        </div>

                        

                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold" style="color: #990000;"><i class="fas fa-bullseye"></i>
                                     College Goal</h6>
                                </div>
                                <div class="card-body">
                                    <div class="text-center">
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col mr-2">
                                            <p style="text-align: justify; text-justify: inter-word; color: #333333;">The College of Computer Studies graduates are expected to become globally competitive and innovative computing professionals imbued with utmost integrity, contributing to the country's national development goals.</p>
                                            <!-- <hr> -->
                                          <!-- <img src="../img/icon/ccs_logo.png" width="50px;" height="25px;" alt="" class="img-fluid">  <a target="_blank" rel="" href="https://www.facebook.com/groups/1004436723245418/" style="color: orange;"> College of Computer Studies</a>
                                          <br><br>
                                          <img src="../img/icon/ccs_logo.png" width="50px;" height="25px;" alt="" class="img-fluid">  <a target="_blank" rel="" href="https://www.facebook.com/groups/1004436723245418/" style="color: orange;"> College of Computer Studies</a> -->
                                        </div>
                                  
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-8 col-md-6 mb-4">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold" style="color: #990000;"><i class="fas fa-list-ol"></i> Objectives</h6>
                                </div>
                                <div class="card-body">
                                    <div class="text-center">
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col mr-2">
                                            <p style="text-align: justify; text-justify: inter-word; color: #333333;">1. Produce globally competitive graduates in the field of Information Technology and Business Process Management.</p>
                                            <p style="text-align: justify; text-justify: inter-word; color: #333333;">2. Equip students with knowledge that are well-grounded in analysis, design, practical application and implementation of Information Technology as catalyst for their professional development.</p>
                                            <p style="text-align: justify; text-justify: inter-word; color: #333333;">3. Empower students learning through distinctive research and extension services enforce intechnology development.</p>
                                            <p style="text-align: justify; text-justify: inter-word; color: #333333;">4. Strengthen the Information Technology Program through Faculty and Students development, established linkages, improved facilities and curriculum development.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-8 col-md-6 mb-6">
                            
                        </div>

                        <!-- Pending Requests Card Example -->
                        <!-- <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Pending Messages</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    </div>




                    <!-- Content Row -->
                    <div class="row">

                        <!-- Area Chart -->
                       <!--  <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">

                             
                                <div class="card-body">
                                    <div class="chart-area">
                                        <canvas id="myAreaChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                        <!-- Pie Chart -->
                        <div class="col-xl-4 col-lg-5">
                            <!-- <div class="card shadow mb-4"> -->
                                <!-- Card Header - Dropdown -->
                                <!-- <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary"></h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Dropdown Header:</div>
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div> -->
                                <!-- Card Body -->
                                <!-- <div class="card-body">
                                    <div class="chart-pie pt-4 pb-2">
                                        <canvas id="myPieChart"></canvas>
                                    </div>
                                    <div class="mt-4 text-center small">
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-primary"></i> Direct
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-success"></i> Social
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-info"></i> Referral
                                        </span>
                                    </div>
                                </div> -->
                            </div>
                        <!-- </div> -->
                    </div>
                   

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
  <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" style="text-decoration: none;" href="#page-top">
            <i class="fas fa"></i>
            <i class="fas fa-angle-up"></i>
            <i class="fas fa"></i>
        </a>
    <?php
    include('includes/logout-modal.php');
    include('includes/scripts.php');
    include('includes/footer.php');
    ?>
    

    
