<?php
include('includes/session.php');
require_once('includes/header.php');
require_once('includes/db_connect.php');
$my_uniq_id = $_SESSION['uniq_id'];
$my_fullname_id = $_SESSION['coordinator_fullname_session'];

$sql = "UPDATE tbl_students SET your_teacher_uniq_id='$my_uniq_id' where coordinator='$my_fullname_id'";
$query_run = mysqli_query($conn, $sql);
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
            <li class="nav-item active">
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

            <li class="nav-item">
                <a class="nav-link collapsed" data-toggle="collapse" data-target="#collapseThree"
                    aria-expanded="true" aria-controls="collapseTwo" href="#">
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

        
        <!-- Topbar  -->
        <?php 
        include('includes/topbar.php');
        ?>  
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <?php    
                    if(isset($_SESSION['coordinator_id_'])){
                        echo "<div class='alert alert-warning alert-dismissible fade show'><h4><i class='icon fa fa-exclamation'></i> Warning!</h4>".$_SESSION['coordinator_id_']."
                        
                        <button type='button' name='reset' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                        </button>
                        </div>";
                    }
                    unset($_SESSION['coordinator_id_']);
                    ?>

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"><B>Dashboard</B></h1>
              <!--           <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-success  shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <div class="col-xl-12 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                
                                <div class="card-body">
                                     <div class="text-xl font-weight-bold text-info text-uppercase mb-1">
                                        <a class="text-xl font-weight-bold text-info text-uppercase mb-1" href='my_account.php'>Great Day, <?php echo $_SESSION['coordinator_fname'];?>!
                                        </a>
                                     </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                            </div>
                                            <div class="h6 mb-0 font-weight-bold text-gray-800">
                                                <div title="">
                                                    <i class="fas fa-id-badge text-info" title="Employee ID"></i> &nbsp;My Employee ID is <?php echo $_SESSION['coordinator_id'];?><br>
                                                   <i class="fas fa-id-badge text-info" title="OJT Teacher Name and ID"></i> &nbsp;My Name is <?php echo "".$_SESSION['coordinator_fname']." ".$_SESSION['coordinator_mname']. " ".$_SESSION['coordinator_lname']; ?></b> <br>
                                                   <i class="fas fa-chalkboard-teacher text-info"></i>&nbsp; I am an OJT Teacher
                                                </div>
                                                <div title="Academic Year and Sem">
                                                    <i class="fas fa-book-reader text-info" title="Academic Year and Sem"></i>&nbsp;&nbsp;
                                                      <?php echo $_SESSION['coordinator_acad_yr_sem'];?>
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

                        <!-- <div class="col-xl-6 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div style="text-align: right; color: ghostwhite; font-size: 16px; padding-right: 5px;">
                                    <span class="badge">
                                        
                                    </span>
                                </div>
                                <div class="card-body">
                                     <div class="text-xl font-weight-bold text-primary text-uppercase mb-1">
                                        <a class="text-xl font-weight-bold text-primary text-uppercase mb-1" href='#'>Date and Time Today
                                        </a>
                                     </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                            </div>
                                            <div class="h6 mb-0 font-weight-bold text-gray-800">
                                                <div title="">
                                                   <i class="fas fa-calendar fa-fw" style="color: #0073e6;"></i>
                                                        <?php
                                                            date_default_timezone_set('Asia/Manila');
                                                            $td = date("F d, Y");
                                                            echo "Today is, ".$td;
                                                        ?>
                                                </div>
                                                <div title="">
                                                    <div id="txt"></div>
                                                   <script>
                                                       function startTime() {
                                                        var d=new Date();
                                                        var h=d.getHours();
                                                        var m=d.getMinutes();
                                                        var s=d.getSeconds();
                                                        m = checkTime(m);
                                                        s = checkTime(s);
                                                        document.getElementById('txt').innerHTML = "<i class='fas fa-clock fa-fw' style='color: #0073e6;'></i> Today's current time is: "+h+":"+m+":"+s;
                                                    }

                                                    function checkTime(i) {
                                                        var j = i;
                                                        if (i < 10) {
                                                            j = "0" + i;
                                                        }
                                                        return j;
                                                    }

                                                    setInterval(function() {
                                                        startTime();
                                                    }, 500);

                                                   </script>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar-day fa-2x text-black-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                        <!-- total students -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div style="text-align: right; color: ghostwhite; font-size: 16px; padding-right: 5px;">
                                    <span class="badge">
                                        
                                    </span>
                                </div>
                                <div class="card-body">
                                     <div class="text-xl font-weight-bold text-info text-uppercase mb-1">
                                        <a class="text-xl font-weight-bold text-info text-uppercase mb-1" href='students_list.php'>My Students
                                        </a>
                                     </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                    $isArchived = "not archive";
                                                    $active = "active";
                                                    $teacher_name = $_SESSION['coordinator_fullname_session'];
                                                    $sql = "SELECT * FROM tbl_students where archived='$isArchived' and status='$active' and coordinator='$teacher_name' ";
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

                        <!-- ANNOUNCEMENTS FROM ADMIN FOR TODAY -->
                        <!-- <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div style="text-align: right; color: ghostwhite; font-size: 16px; padding-right: 5px;">
                                    <span class="badge bg-danger">
                                        <?php
                                            date_default_timezone_set('Asia/Manila');
                                            $td = date("F d, Y");
                                            $receiver_name = $_SESSION['coordinator_fullname_session'];
                                            $pub_stats = "published";
                                            $posted_by_admin = "Dean";
                                            $posted_by_PH = "Program Head";
                                            $stats = "not archived";
                                            $sendTo = "Teachers";
                                            $sql = "SELECT * FROM tbl_announcement_receiver WHERE date_='$td' and status='$stats' and posted_by='$posted_by_admin' and publish_status='$pub_stats' and receiver_name='$receiver_name' and sendTo='$sendTo' 
                                            OR 
                                            date_='$td' and status='$stats' and posted_by='$posted_by_PH' and publish_status='$pub_stats' and receiver_name='$receiver_name' and sendTo='$sendTo'  ORDER BY id ASC";
                                            $query = $conn->query($sql);
                                            if($query->num_rows==0){
                                                echo $query->num_rows;
                                            }
                                            else{
                                                echo "<a style='color: ghostwhite' href='executive_announcement_for_today.php'>". $query->num_rows."+ </a>";
                                            }
                                        ?>    
                                    </span>
                                </div>
                                <div class="card-body">
                                <div class="text-xl font-weight-bold text-danger text-uppercase mb-1"><a class="text-xl font-weight-bold text-danger text-uppercase mb-1" href='executive_announcement_for_today.php'>Announcements For Today</a></div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                               <?php 
                                                    date_default_timezone_set('Asia/Manila');
                                                    $td = date("F d, Y");
                                                    echo $td;
                                                ?>        
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                    $receiver_name = $_SESSION['coordinator_fullname_session'];
                                                    $pub_stats = "published";
                                                    $posted_by_admin = "Dean";
                                                    $posted_by_PH = "Program Head";
                                                    $stats = "not archived";
                                                    $sendTo = "Teachers";
                                                    $sql = "SELECT * FROM tbl_announcement_receiver WHERE date_='$td' and status='$stats' and posted_by='$posted_by_admin' and publish_status='$pub_stats' and receiver_name='$receiver_name' and sendTo='$sendTo' 
                                                    OR 
                                                    date_='$td' and status='$stats' and posted_by='$posted_by_PH' and publish_status='$pub_stats' and receiver_name='$receiver_name' and sendTo='$sendTo'  ORDER BY id ASC";
                                                    $query = $conn->query($sql);
                                                    if($query->num_rows==0){
                                                        echo "<h6><b>There's No Announcement For Today</b><h6>";
                                                    }
                                                    else{
                                                        echo "<h6><b><a class='font-weight-bold text-gray-800' href='executive_announcement_for_today.php'> There's ".$query->num_rows." Announcement/s "."For Today! Please Click Here To View the Announcement!</a></b></h6>";
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar-day fa-2x text-black-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div style="text-align: right; color: ghostwhite; font-size: 16px; padding-right: 5px;">
                                    <span class="badge">
                                        
                                    </span>
                                </div>
                                <div class="card-body">
                                <div class="text-xl font-weight-bold text-danger text-uppercase mb-1">
                                <a class="text-xl font-weight-bold text-danger text-uppercase mb-1" href='executive_announcements_history.php'>Announcements</a>
                                </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                               All      
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                    $posted_by = "Dean";
                                                    $posted_by_PH = "Program Head";
                                                    $stats = "not archived";
                                                    $pub_stats = "published";
                                                    $sql = "SELECT * FROM tbl_announcement WHERE posted_by='$posted_by' and sendTo='$sendTo' and publish_status='$pub_stats' and status='$stats'
                                                        OR
                                                        posted_by='$posted_by_PH' and sendTo='$sendTo' and publish_status='$pub_stats' and status='$stats'";
                                                    $query = $conn->query($sql);
                                                    echo "<h6><b><a class='h5 mb-0 font-weight-bold text-gray-800' href='executive_announcement_for_today.php'> ".$query->num_rows. " </a></b></h6>";
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-black-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                        <!-- SUBMITTED REQUIREMENTS FOR TODAY (FROM MY STUDENTS) -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div style="text-align: right; color: ghostwhite; font-size: 16px; padding-right: 5px;">
                                    <span class="badge badge bg-danger">
                                        <?php
                                            date_default_timezone_set('Asia/Manila');
                                            $timestamp = time();
                                            $td = date("F d, Y");
                                            $work_stats = "semi-pending";
                                            $stats = "not archived";
                                            $submitted = "yes";
                                            $count = 1;
                                            $my_fullname_ = $_SESSION['coordinator_fullname_session'];
                                            $sql = "SELECT * from tbl_students_work where date_submitted='$td' and name_of_teacher='$my_fullname_' and work_status='$work_stats' and submitted='$submitted' and status='$stats'";
                                            $query = $conn->query($sql);
                                            if($query->num_rows==0){
                                                echo "<a style='color: ghostwhite' href='my_stud_requirements_completed_for_today.php'>".$query->num_rows."</a>";
                                            }
                                            else{
                                                echo "<a style='color: ghostwhite' href='my_stud_requirements_completed_for_today.php'>". $query->num_rows."+ </a>";
                                            }
                                        ?>  
                                    </span>
                                </div>
                                <div class="card-body">
                                    <div class="text-xl font-weight-bold text-primary text-uppercase mb-1">
                                        <a class="text-xl font-weight-bold text-primary text-uppercase mb-1" href='my_stud_requirements_completed_for_today.php'>Submitted Requirements Today (from my students)</a>
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                                <?php 
                                                    date_default_timezone_set('Asia/Manila');
                                                    $td = date("F d, Y");
                                                    echo $td;
                                                ?>
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                session_start();
                                                    $timestamp = time();
                                                    $td = date("F d, Y");
                                                    $work_stats = "semi-pending";
                                                    $stats = "not archived";
                                                    $submitted = "yes";
                                                    $count = 1;
                                                    $my_fullname_ = $_SESSION['coordinator_fullname_session'];
                                                    $sql = "SELECT * from tbl_students_work where date_submitted='$td' and name_of_teacher='$my_fullname_' and work_status='$work_stats' and submitted='$submitted' and status='$stats'";
                                                    $query = $conn->query($sql);
                                                    if($query->num_rows==0){
                                                        echo "<h6><b>There's No Requirements Submitted From My Students For Today</b><h6>";
                                                    }
                                                    else{
                                                        echo "<h6><b><a class='font-weight-bold text-gray-800' href='my_stud_requirements_completed_for_today.php'> There's ".$query->num_rows." "."Requirements Submitted From My Students For Today! Please Click Here To View!</a></b></h6>";
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-black-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SUBMITTED REQUIREMENTS ALL (FROM MY STUDENTS) -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div style="text-align: right; color: ghostwhite; font-size: 16px; padding-right: 5px;">
                                    <span class="badge badge bg-danger">
                                        <?php
                                            date_default_timezone_set('Asia/Manila');
                                            $work_stats = "semi-pending";
                                            $stats = "not archived";
                                            $submitted = "yes";
                                            $count = 1;
                                            $my_fullname_ = $_SESSION['coordinator_fullname_session'];
                                            $sql = "SELECT * from tbl_students_work where name_of_teacher='$my_fullname_' and work_status='$work_stats' and submitted='$submitted' and status='$stats'";
                                            $query = $conn->query($sql);
                                            if($query->num_rows==0){
                                                echo "<a style='color: ghostwhite' href='my_stud_requirements_completed.php'>".$query->num_rows."</a>";
                                            }
                                            else{
                                                echo "<a style='color: ghostwhite' href='my_stud_requirements_completed.php'>". $query->num_rows."+ </a>";
                                            }
                                        ?>  
                                    </span>
                                </div>
                                <div class="card-body">
                                    <div class="text-xl font-weight-bold text-primary text-uppercase mb-1">
                                        <a class="text-xl font-weight-bold text-primary text-uppercase mb-1" href='my_stud_requirements_completed.php'>Submitted Requirements (from my students)</a>
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                                All
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                session_start();
                                                    $timestamp = time();
                                                    $td = date("F d, Y");
                                                    $work_stats = "semi-pending";
                                                    $stats = "not archived";
                                                    $submitted = "yes";
                                                    $count = 1;
                                                    $my_fullname_ = $_SESSION['coordinator_fullname_session'];
                                                    $sql = "SELECT * from tbl_students_work where  name_of_teacher='$my_fullname_' and work_status='$work_stats' and submitted='$submitted' and status='$stats'";
                                                    $query = $conn->query($sql);
                                                    if($query->num_rows==0){
                                                        echo $query->num_rows;
                                                    }
                                                    else{
                                                        echo "<h6><b><a class='font-weight-bold text-gray-800' href='my_stud_requirements_completed.php'> There's ".$query->num_rows." "."Requirement/s Submitted From My Students For Today! Please Click Here To View!</a></b></h6>";
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-black-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- REQUIREMENTS THAT ARE NOT ALREADY SUBMITTED-->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div style="text-align: right; color: ghostwhite; font-size: 16px; padding-right: 5px;">
                                    <span class="badge badge bg-danger"><!-- badge badge bg-danger -->
                                        <?php
                                            $myfullname_ = $_SESSION['coordinator_fullname_session'];
                                            $work_stats = "pending";
                                            $stats = "not archived";
                                            $submitted = "no";
                                            $count = 1;
                                            $sql = "SELECT * from tbl_students_work where name_of_teacher='$myfullname_' and work_status='$work_stats' and submitted='$submitted' and status='$stats'";
                                            $query = $conn->query($sql);
                                            if($query->num_rows==0){
                                                echo "<a style='color: ghostwhite' href='my_stud_requirements_pending.php'>".$query->num_rows."</a>";
                                            }
                                            else{
                                                echo "<a style='color: ghostwhite' href='my_stud_requirements_pending.php'>". $query->num_rows."+ </a>";
                                            }
                                        ?>  
                                    </span>
                                </div>
                                <div class="card-body">
                                    <div class="text-xl font-weight-bold text-warning text-uppercase mb-1">
                                        <a class="text-xl font-weight-bold text-warning text-uppercase mb-1" href='my_stud_requirements_pending.php'>REQUIREMENTS THAT ARE NOT ALREADY SUBMITTED (from my students)</a>
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                                All
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                session_start();
                                                    $$work_stats = "pending";
                                            $stats = "not archived";
                                            $submitted = "no";
                                            $count = 1;
                                            $sql = "SELECT * from tbl_students_work where name_of_teacher='$myfullname_' and work_status='$work_stats' and submitted='$submitted' and status='$stats'";
                                            $query = $conn->query($sql);
                                                    echo "<a class='h5 mb-0 font-weight-bold text-gray-800' href='my_stud_requirements_pending.php'>".$query->num_rows."</a>";
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-black-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- SUBMITTED REQUIREMENTS THAT ARE STILL IN PENDING STATUS - ALL (FROM MY STUDENTS) -->
                        <!-- <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div style="text-align: right; color: ghostwhite; font-size: 16px; padding-right: 5px;">
                                    <span class="badge badge bg-danger">
                                        <?php
                                            $work_stats = "semi-pending";
                                            $stats = "not archived";
                                            $submitted = "yes";
                                            $count = 1;
                                            $my_fullname_ = $_SESSION['coordinator_fullname_session'];
                                            $sql = "SELECT * from tbl_students_work where name_of_teacher='$my_fullname_' and work_status='$work_stats' and submitted='$submitted' and status='$stats'";
                                            $query = $conn->query($sql);
                                            if($query->num_rows==0){
                                                echo "<a style='color: ghostwhite' href='my_stud_requirements_completed.php'>".$query->num_rows."</a>";
                                            }
                                            else{
                                                echo "<a style='color: ghostwhite' href='my_stud_requirements_completed.php'>". $query->num_rows."+ </a>";
                                            }
                                        ?>  
                                    </span>
                                </div>
                                <div class="card-body">
                                    <div class="text-xl font-weight-bold text-primary text-uppercase mb-1">
                                        <a class="text-xl font-weight-bold text-primary text-uppercase mb-1" href='my_stud_requirements_completed.php'>Submitted Requirements That Are Still In Pending Status (from my students)</a>
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                                All
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                session_start();
                                                    $timestamp = time();
                                                    $td = date("F d, Y");
                                                    $work_stats = "semi-pending";
                                                    $work_stats1 = "semi-pending";
                                                    $stats = "not archived";
                                                    $submitted = "yes";
                                                    $count = 1;
                                                    $my_fullname_ = $_SESSION['coordinator_fullname_session'];
                                                    $sql = "SELECT * from tbl_students_work where date_submitted='$td' and name_of_teacher='$my_fullname_' and work_status='$work_stats' and submitted='$submitted' and status='$stats'";
                                                    $query = $conn->query($sql);
                                                    if($query->num_rows==0){
                                                        echo "0";
                                                    }
                                                    else{
                                                        echo "<h6><b><a class='font-weight-bold text-gray-800' href='my_stud_requirements_completed.php'> There's ".$query->num_rows." Student/s "."Who Already Submitted Their Requirement/s! Please Click Here To View!</a></b></h6>";
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-black-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                        <!-- SUBMITTED REQUIREMENTS THAT ARE IN COMPLETED STATUS - ALL (FROM MY STUDENTS) -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div style="text-align: right; color: ghostwhite; font-size: 16px; padding-right: 5px;">
                                    <span class="badge badge bg-danger">
                                        <?php
                                            $work_stats1 = "completed";
                                            $stats = "not archived";
                                            $submitted = "yes";
                                            $count = 1;
                                            $my_fullname_ = $_SESSION['coordinator_fullname_session'];
                                            $sql = "SELECT * from tbl_students_work where 
                                                (name_of_teacher='$my_fullname_' and work_status='$work_stats1' and submitted='$submitted' and status='$stats')
                                                ";
                                            $query = $conn->query($sql);
                                            if($query->num_rows==0){
                                                echo "<a style='color: ghostwhite' href='my_stud_requirements_already_completed.php'>".$query->num_rows."</a>";
                                            }
                                            else{
                                                echo "<a style='color: ghostwhite' href='my_stud_requirements_already_completed.php'>". $query->num_rows."+ </a>";
                                            }
                                        ?>  
                                    </span>
                                </div>
                                <div class="card-body">
                                    <div class="text-xl font-weight-bold text-success text-uppercase mb-1">
                                        <a class="text-xl font-weight-bold text-success text-uppercase mb-1" href='my_stud_requirements_already_completed.php'>Submitted Requirements That Are In Completed Status (from my students)</a>
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
                                                    $stats = "not archived";
                                                    $submitted = "yes";
                                                    $count = 1;
                                                    $my_fullname_ = $_SESSION['coordinator_fullname_session'];
                                                    $sql = "SELECT * from tbl_students_work where 
                                                        (name_of_teacher='$my_fullname_' and work_status='$work_stats1' and submitted='$submitted' and status='$stats')
                                                        ORDER by id ASC";
                                                    $query = $conn->query($sql);
                                                    if($query->num_rows==0){
                                                        echo $query->num_rows;
                                                    }
                                                    else{
                                                        echo "<h6><b><a class='font-weight-bold text-gray-800' href='my_stud_requirements_already_completed.php'> There's ".$query->num_rows." Completed Requirements! Please Click Here To View!</a></b></h6>";
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-black-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-dark shadow h-100 py-2">
                                <div style="text-align: right; color: ghostwhite; font-size: 16px; padding-right: 5px;">
                                    <span class="badge bg-danger">
                                        <?php
                                            date_default_timezone_set('Asia/Manila');
                                            $td = date("F d, Y");
                                            $teacher_name1 = $_SESSION['coordinator_fullname_session'];
                                                    $stats = "not archived";
                                                    $sql = "SELECT * FROM tbl_announcement WHERE date_ ='$td' and posted_by='$teacher_name1' and status='$stats' ORDER BY id desc";
                                            $query = $conn->query($sql);
                                            if($query->num_rows==0){
                                                echo "<a style='color: ghostwhite' href='announcement_for_today.php'>".$query->num_rows."</a>";
                                            }
                                            else{
                                                echo "<a style='color: ghostwhite' href='announcement_for_today.php'>". $query->num_rows."+ </a>";
                                            }
                                        ?>    
                                    </span>
                                </div>
                                <div class="card-body">
                                    <div class="text-xl font-weight-bold text-dark text-uppercase mb-1">
                                        <a class="text-xl font-weight-bold text-dark text-uppercase mb-1" href='announcement_for_today.php'>
                                        My Announcements For Today </a>
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                                <?php 
                                                    date_default_timezone_set('Asia/Manila');
                                                    $td = date("F d, Y");
                                                    echo $td;
                                                ?></div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                    $teacher_name1 = $_SESSION['coordinator_fullname_session'];
                                                    $stats = "not archived";
                                                    $sql = "SELECT * FROM tbl_announcement WHERE date_ ='$td' and posted_by='$teacher_name1' and status='$stats' ORDER BY id desc";
                                                    $query = $conn->query($sql);
                                                    echo "<a class='h5 mb-0 font-weight-bold text-gray-800' href='announcement_for_today'>".$query->num_rows."</a>";
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-black-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-dark shadow h-100 py-2">
                                <div style="text-align: right; color: ghostwhite; font-size: 16px; padding-right: 5px;">
                                    <span class="badge bg-danger">
                                        <?php
                                            $teacher_name1 = $_SESSION['coordinator_fullname_session'];
                                            $stats = "not archived";
                                            $sql = "SELECT * FROM tbl_announcement WHERE posted_by='$teacher_name1' and status='$stats'";
                                            $query = $conn->query($sql);
                                            if($query->num_rows==0){
                                                echo "<a style='color: ghostwhite' href='announcement_for_today.php'>".$query->num_rows."</a>";
                                            }
                                            else{
                                                echo "<a style='color: ghostwhite' href='announcement_for_today.php'>". $query->num_rows."+ </a>";
                                            }
                                        ?>    
                                    </span>
                                </div>
                                <div class="card-body">
                                <div class="text-xl font-weight-bold text-dark text-uppercase mb-1">
                                     <a class="text-xl font-weight-bold text-dark text-uppercase mb-1" href='announcements_history.php'>My Announcements</a>
                                </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                               All
                                           </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                session_start();
                                                    $teacher_name2 = $_SESSION['coordinator_fullname_session'];
                                                    $stats = "not archived";
                                                    $sql = "SELECT * FROM tbl_announcement WHERE posted_by='$teacher_name2' and status='$stats' ORDER BY id desc";
                                                    $query = $conn->query($sql);
                                                    echo "<a class='h5 mb-0 font-weight-bold text-gray-800' href='announcements_history.php'>".$query->num_rows."</a>";
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-black-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        

                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div style="text-align: right; color: ghostwhite; font-size: 16px; padding-right: 5px;">
                                    <span class="badge bg-danger">
                                        <?php
                                            $teacher_name2 = $_SESSION['coordinator_fullname_session'];
                                            $work_stats = "pending";
                                            $stats = "not archived";
                                            $count = 1;
                                            $sql = "SELECT * FROM tbl_coordinator_save_works WHERE date_='$td' and status='$stats' and name_of_teacher='$teacher_name2'";
                                            $query = $conn->query($sql);
                                            if($query->num_rows==0){
                                                echo "<a style='color: ghostwhite' href='my_requirements_for_students.php'>".$query->num_rows."</a>";
                                            }
                                            else{
                                                echo "<a style='color: ghostwhite' href='my_requirements_for_students.php'>". $query->num_rows."+ </a>";
                                            }
                                        ?>    
                                    </span>
                                </div>
                                <div class="card-body">
                                <div class="text-xl font-weight-bold text-info text-uppercase mb-1">
                                    <a class="text-xl font-weight-bold text-info text-uppercase mb-1" href='my_requirements_for_students.php'>New Requirements Distributed For Today</a>
                                </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                                <?php 
                                                    date_default_timezone_set('Asia/Manila');
                                                    $td = date("F d, Y");
                                                    echo $td;
                                                ?>
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                    session_start();
                                                    $work_stats = "pending";
                                                    $stats = "not archived";
                                                    $count = 1;
                                                    $sql = "SELECT * FROM tbl_coordinator_save_works WHERE date_='$td' and status='$stats' and name_of_teacher='$teacher_name2'";
                                                    $query = $conn->query($sql);
                                                    echo $query->num_rows;
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="far fa-list-alt fa-2x text-black-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                         <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                 <div style="text-align: right; color: ghostwhite; font-size: 16px; padding-right: 5px;">
                                    <span class="badge bg-danger">
                                        <?php
                                            $teacher_name2 = $_SESSION['coordinator_fullname_session'];
                                            $work_stats = "pending";
                                            $stats = "not archived";
                                            $count = 1;
                                            $sql = "SELECT * FROM tbl_coordinator_save_works WHERE status='$stats' and name_of_teacher='$teacher_name2'";
                                            $query = $conn->query($sql);
                                            if($query->num_rows==0){
                                                echo "<a style='color: ghostwhite' href='my_requirements_for_students_history.php'>".$query->num_rows."</a>";
                                            }
                                            else{
                                                echo "<a style='color: ghostwhite' href='my_requirements_for_students_history.php'>". $query->num_rows."+ </a>";
                                            }
                                        ?>    
                                    </span>
                                </div>
                                <div class="card-body">
                                <div class="text-xl font-weight-bold text-info text-uppercase mb-1">
                                    <a class="text-xl font-weight-bold text-info text-uppercase mb-1" href='my_requirements_for_students_history.php'>Requirements Distributed</a>
                                </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                                All
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                session_start();
                                                    $work_stats = "pending";
                                                    $stats = "not archived";
                                                    $count = 1;
                                                    $sql = "SELECT * FROM tbl_coordinator_save_works WHERE status='$stats' and name_of_teacher='$teacher_name2'";
                                                    $query = $conn->query($sql);
                                                    echo $query->num_rows;
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="far fa-list-alt fa-2x text-black-300"></i>
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
                                                $my_fullname_ = $_SESSION['coordinator_fullname_session'];
                                                $sql = "select * from tbl_students_work where title ='$recommendation_letter' and submitted = '$not_submitted' and name_of_teacher='$my_fullname_' and status = '$stats'";
                                                $query = $conn->query($sql);
                                                // 
                                                $submitted = "yes";
                                                $semi_pending = "semi-pending";
                                                $semi_pending2 = "semi-pending2";
                                                $semi_pending3 = "semi-pending3";
                                                $sql1 = "select * from tbl_students_work where (title='$recommendation_letter' and submitted='$submitted' and name_of_teacher='$my_fullname_' and status = '$stats' and work_status = '$semi_pending') OR (title='$recommendation_letter' and submitted='$submitted' and name_of_teacher='$my_fullname_' and status = '$stats' and work_status = '$semi_pending2') OR (title='$recommendation_letter' and submitted='$submitted' and name_of_teacher='$my_fullname_' and status = '$stats' and work_status = '$semi_pending3')";
                                                $query1 = $conn->query($sql1);
                                                // 
                                                $submitted = "yes";
                                                $completed = "completed";
                                                $sql2 = "select * from tbl_students_work where title='$recommendation_letter' and submitted='$submitted' and name_of_teacher='$my_fullname_' and work_status='$completed' and status = '$stats'";
                                                $query2 = $conn->query($sql2);

                                              // ------------------------------------------------------------

                                                //resume
                                                //not yet submitted and pending
                                                $not_submitted = "no";
                                                $my_fullname_ = $_SESSION['coordinator_fullname_session'];
                                                $resume = "Resume";
                                                $sql3 = "select * from tbl_students_work where title = '$resume' and submitted = '$not_submitted' and name_of_teacher='$my_fullname_' and status = '$stats'";
                                                $query3 = $conn->query($sql3);
                                                
                                                // submitted but not completed
                                                $resume = "Resume";
                                                $my_fullname_ = $_SESSION['coordinator_fullname_session'];
                                                $submitted = "yes";
                                                $semi_pending = "semi-pending";
                                                $semi_pending2 = "semi-pending2";
                                                $semi_pending3 = "semi-pending3";
                                                $sql4 = "select * from tbl_students_work where (title='$resume' and submitted='$submitted' and name_of_teacher='$my_fullname_' and status = '$stats' and work_status = '$semi_pending') OR ( title='$resume' and submitted='$submitted' and name_of_teacher='$my_fullname_' and status = '$stats' and work_status = '$semi_pending2')";
                                                $query4 = $conn->query($sql4);
                                                
                                                // completed
                                                $completed = "completed";
                                                $resume = "Resume";
                                                $my_fullname_ = $_SESSION['coordinator_fullname_session'];
                                                $sql5 = "select * from tbl_students_work where title='$resume' and submitted='$submitted' and name_of_teacher='$my_fullname_' and work_status='$completed' and status = '$stats'";
                                                $query5 = $conn->query($sql5);


                                                // ------------------------------------------------------------

                                                //moa
                                                //not yet submitted and pending
                                                $not_submitted = "no";
                                                $my_fullname_ = $_SESSION['coordinator_fullname_session'];
                                                $moa = "Memorandum of Agreement";
                                                $sql6 = "select * from tbl_students_work where title = '$moa' and submitted = '$not_submitted' and name_of_teacher='$my_fullname_' and status = '$stats'";
                                                $query6 = $conn->query($sql6);
                                                
                                                // submitted but not completed
                                                $moa = "Memorandum of Agreement";
                                                $my_fullname_ = $_SESSION['coordinator_fullname_session'];
                                                $submitted = "yes";
                                                $semi_pending = "semi-pending";
                                                $semi_pending2 = "semi-pending2";
                                                $semi_pending3 = "semi-pending3";
                                                $sql7 = "select * from tbl_students_work where (title='$moa' and submitted='$submitted' and status = '$stats' and name_of_teacher='$my_fullname_' and work_status = '$semi_pending') OR (title='$moa' and submitted='$submitted' and status = '$stats' and name_of_teacher='$my_fullname_' and work_status = '$semi_pending2')";
                                                $query7 = $conn->query($sql7);
                                                
                                                // completed
                                                $completed = "completed";
                                                $moa = "Memorandum of Agreement";
                                                $my_fullname_ = $_SESSION['coordinator_fullname_session'];
                                                $sql8 = "select * from tbl_students_work where title='$moa' and submitted='$submitted' and name_of_teacher='$my_fullname_' and work_status='$completed' and status = '$stats'";
                                                $query8 = $conn->query($sql8);

                                                // ------------------------------------------------------------

                                                //work plan
                                                //not yet submitted and pending
                                                $not_submitted = "no";
                                                $my_fullname_ = $_SESSION['coordinator_fullname_session'];
                                                $work_plan = "Work Plan";
                                                $sql9 = "select * from tbl_students_work where title = '$work_plan' and submitted = '$not_submitted' and name_of_teacher='$my_fullname_' and status = '$stats'";
                                                $query9 = $conn->query($sql9);
                                                
                                                // submitted but not completed
                                                $work_plan = "Work Plan";
                                                $my_fullname_ = $_SESSION['coordinator_fullname_session'];
                                                $submitted = "yes";
                                                $semi_pending = "semi-pending";
                                                $semi_pending2 = "semi-pending2";
                                                $semi_pending3 = "semi-pending3";
                                                $sql10 = "select * from tbl_students_work where (title='$work_plan' and submitted='$submitted' and name_of_teacher='$my_fullname_' and status = '$stats' and work_status = '$semi_pending') OR (title='$work_plan' and submitted='$submitted' and name_of_teacher='$my_fullname_' and status = '$stats' and work_status = '$semi_pending2')";
                                                $query10 = $conn->query($sql10);
                                                
                                                // completed
                                                $completed = "completed";
                                                $work_plan = "Work Plan";
                                                $my_fullname_ = $_SESSION['coordinator_fullname_session'];
                                                $sql11 = "select * from tbl_students_work where title='$work_plan' and submitted='$submitted' and name_of_teacher='$my_fullname_' and work_status='$completed' and status = '$stats'";
                                                $query11 = $conn->query($sql11);

                                                // ------------------------------------------------------------

                                                //narrative
                                                //not yet submitted and pending
                                                $not_submitted = "no";
                                                $my_fullname_ = $_SESSION['coordinator_fullname_session'];
                                                $narrative = "Narrative";
                                                $sql12 = "select * from tbl_students_work where title = '$narrative' and submitted = '$not_submitted' and name_of_teacher='$my_fullname_' and status = '$stats'";
                                                $query12 = $conn->query($sql12);
                                                
                                                // submitted but not completed
                                                $narrative = "Narrative";
                                                $my_fullname_ = $_SESSION['coordinator_fullname_session'];
                                                $submitted = "yes";
                                                $semi_pending = "semi-pending";
                                                $semi_pending2 = "semi-pending2";
                                                $semi_pending3 = "semi-pending3";
                                                $sql13 = "select * from tbl_students_work where (title='$narrative' and submitted='$submitted' and status = '$stats' and name_of_teacher='$my_fullname_' and work_status = '$semi_pending') OR (title='$narrative' and submitted='$submitted' and status = '$stats' and name_of_teacher='$my_fullname_' and work_status = '$semi_pending2')";
                                                $query13 = $conn->query($sql13);
                                                
                                                // completed
                                                $completed = "completed";
                                                $narrative = "Narrative";
                                                $my_fullname_ = $_SESSION['coordinator_fullname_session'];
                                                $sql14 = "select * from tbl_students_work where title='$narrative' and submitted='$submitted' and name_of_teacher='$my_fullname_' and work_status='$completed' and status = '$stats'";
                                                $query14 = $conn->query($sql14);

                                                // ------------------------------------------------------------

                                                //accomplishment report
                                                //not yet submitted and pending
                                                $not_submitted = "no";
                                                $my_fullname_ = $_SESSION['coordinator_fullname_session'];
                                                $accomplishment_report = "Accomplishment Report";
                                                $sql15 = "select * from tbl_students_work where title = '$accomplishment_report' and submitted = '$not_submitted' and name_of_teacher='$my_fullname_' and status = '$stats'";
                                                $query15 = $conn->query($sql15);
                                                
                                                // submitted but not completed
                                                $accomplishment_report = "Accomplishment Report";
                                                $my_fullname_ = $_SESSION['coordinator_fullname_session'];
                                                $submitted = "yes";
                                                $semi_pending = "semi-pending";
                                                $semi_pending2 = "semi-pending2";
                                                $semi_pending3 = "semi-pending3";
                                                $sql16 = "select * from tbl_students_work where (title='$accomplishment_report' and submitted='$submitted' and status = '$stats' and name_of_teacher='$my_fullname_' and work_status = '$semi_pending') OR (title='$accomplishment_report' and submitted='$submitted' and status = '$stats' and name_of_teacher='$my_fullname_' and work_status = '$semi_pending2')";
                                                $query16 = $conn->query($sql16);
                                                
                                                // completed
                                                $completed = "completed";
                                                $accomplishment_report = "Accomplishment Report";
                                                $my_fullname_ = $_SESSION['coordinator_fullname_session'];
                                                $sql17 = "select * from tbl_students_work where title='$accomplishment_report' and submitted='$submitted' and name_of_teacher='$my_fullname_' and work_status='$completed' and status = '$stats'";
                                                $query17 = $conn->query($sql17);

                                                // ------------------------------------------------------------

                                                //response letter
                                                //not yet submitted and pending
                                                $not_submitted = "no";
                                                $my_fullname_ = $_SESSION['coordinator_fullname_session'];
                                                $response_letter = "Response Letter";
                                                $sql18 = "select * from tbl_students_work where title = '$response_letter' and submitted = '$not_submitted' and name_of_teacher='$my_fullname_' and status = '$stats'";
                                                $query18 = $conn->query($sql18);
                                                
                                                // submitted but not completed
                                                $response_letter = "Response Letter";
                                                $my_fullname_ = $_SESSION['coordinator_fullname_session'];
                                                $submitted = "yes";
                                                $semi_pending = "semi-pending";
                                                $semi_pending2 = "semi-pending2";
                                                $semi_pending3 = "semi-pending3";
                                                $sql19 = "select * from tbl_students_work where ( title='$response_letter' and submitted='$submitted' and status = '$stats' and name_of_teacher='$my_fullname_' and work_status = '$semi_pending') OR ( title='$response_letter' and submitted='$submitted' and status = '$stats' and name_of_teacher='$my_fullname_' and work_status = '$semi_pending2')";
                                                $query19 = $conn->query($sql19);
                                                
                                                // completed
                                                $completed = "completed";
                                                $response_letter = "Response Letter";
                                                $my_fullname_ = $_SESSION['coordinator_fullname_session'];
                                                $sql20 = "select * from tbl_students_work where title='$response_letter' and submitted='$submitted' and name_of_teacher='$my_fullname_' and work_status='$completed' and status = '$stats'";
                                                $query20 = $conn->query($sql20);

                                                // ------------------------------------------------------------

                                                //performance sheet
                                                //not yet submitted and pending
                                                $not_submitted = "no";
                                                $my_fullname_ = $_SESSION['coordinator_fullname_session'];
                                                $performance_sheet = "Performance Sheet";
                                                $sql21 = "select * from tbl_students_work where title = '$performance_sheet' and submitted = '$not_submitted' and name_of_teacher='$my_fullname_' and status = '$stats'";
                                                $query21 = $conn->query($sql21);
                                                
                                                // submitted but not completed
                                                $performance_sheet = "Performance Sheet";
                                                $my_fullname_ = $_SESSION['coordinator_fullname_session'];
                                                $submitted = "yes";
                                                $semi_pending = "semi-pending";
                                                $semi_pending2 = "semi-pending2";
                                                $semi_pending3 = "semi-pending3";
                                                $sql22 = "select * from tbl_students_work where (title='$performance_sheet' and submitted='$submitted' and status = '$stats' and name_of_teacher='$my_fullname_' and work_status = '$semi_pending') OR (title='$performance_sheet' and submitted='$submitted' and status = '$stats' and name_of_teacher='$my_fullname_' and work_status = '$semi_pending2')";
                                                $query22 = $conn->query($sql22);
                                                
                                                // completed
                                                $completed = "completed";
                                                $performance_sheet = "Performance Sheet";
                                                $my_fullname_ = $_SESSION['coordinator_fullname_session'];
                                                $sql23 = "select * from tbl_students_work where title='$performance_sheet' and submitted='$submitted' and name_of_teacher='$my_fullname_' and work_status='$completed' and status = '$stats'";
                                                $query23 = $conn->query($sql23);


                                                // ------------------------------------------------------------

                                                //endorsement letter
                                                //not yet submitted and pending
                                                $not_submitted = "no";
                                                $my_fullname_ = $_SESSION['coordinator_fullname_session'];
                                                $endorsement_letter = "Endorsement Letter";
                                                $sql24 = "select * from tbl_students_work where title = '$endorsement_letter' and submitted = '$not_submitted' and name_of_teacher='$my_fullname_' and status = '$stats'";
                                                $query24 = $conn->query($sql24);
                                                
                                                // submitted but not completed
                                                $endorsement_letter = "Endorsement Letter";
                                                $my_fullname_ = $_SESSION['coordinator_fullname_session'];
                                                $submitted = "yes";
                                                $semi_pending = "semi-pending";
                                                $semi_pending2 = "semi-pending2";
                                                $semi_pending3 = "semi-pending3";
                                                $sql25 = "select * from tbl_students_work where (title='$endorsement_letter' and submitted='$submitted' and status = '$stats' and name_of_teacher='$my_fullname_' and work_status = '$semi_pending') OR ( title='$endorsement_letter' and submitted='$submitted' and status = '$stats' and name_of_teacher='$my_fullname_' and work_status = '$semi_pending2')";
                                                $query25 = $conn->query($sql25);
                                                
                                                // completed
                                                $completed = "completed";
                                                $endorsement_letter = "Endorsement Letter";
                                                $my_fullname_ = $_SESSION['coordinator_fullname_session'];
                                                $sql26 = "select * from tbl_students_work where title='$endorsement_letter' and submitted='$submitted' and name_of_teacher='$my_fullname_' and work_status='$completed' and status = '$stats'";
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
                                        <div id="barchart_material" style="width: 1260px; height: 1100px;"></div>
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

                                            $my_fullname_ = $_SESSION['coordinator_fullname_session'];

                                            $in_campus = "In-Campus";
                                            $not_archived = "not archive";
                                            $sql = "SELECT * FROM tbl_students where in_off_campus ='$in_campus' and archived='$not_archived' and coordinator='$my_fullname_'";
                                            $query_in_campus = $conn->query($sql);

                                            $off_campus = "Off-Campus";
                                            $not_archived = "not archive";
                                            $sql = "SELECT * FROM tbl_students where in_off_campus ='$off_campus' and archived='$not_archived' and coordinator='$my_fullname_'";
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
                                    <h6 class="m-0 font-weight-bold" style="color: #990000;"><i class="fas fa-chart-bar"></i> Graphical Representation of Students' Status </h6>
                                </div>
                                    <div class="card-body" style="background-color: white;">
                                        <script type="text/javascript">
                                          google.charts.load('current', {'packages':['bar']});
                                          google.charts.setOnLoadCallback(drawChart);

                                          <?php
                                            $isArchived = "not archive";
                                            $active = "active";
                                            $teacher_name = $_SESSION['coordinator_fullname_session'];
                                            $sql_active = "SELECT * FROM tbl_students where archived='$isArchived' and status='$active' and coordinator='$teacher_name' ";
                                            $query_active = $conn->query($sql_active);
                                            
                                            $dropped = "dropped";
                                            $teacher_name = $_SESSION['coordinator_fullname_session'];
                                            $sql_dropped = "SELECT * FROM tbl_students where archived='$isArchived' and status='$dropped' and coordinator='$teacher_name' ";
                                            $query_dropped = $conn->query($sql_dropped); 

                                            $inc = "incomplete";
                                            $teacher_name = $_SESSION['coordinator_fullname_session'];
                                            $sql_inc = "SELECT * FROM tbl_students where archived='$isArchived' and status='$inc' and coordinator='$teacher_name' ";
                                            $query_inc = $conn->query($sql_inc);     
                                           ?>

                                          function drawChart() {
                                            var data = google.visualization.arrayToDataTable([
                                              ['', 'Active', 'Dropped', 'Incomplete'],
                                              ['My Students', <?php echo $query_active->num_rows; ?>, <?php echo $query_dropped->num_rows; ?>, <?php echo $query_inc->num_rows; ?>],
                                            ]);

                                            var options = {
                                              chart: {
                                                title: 'Students Status Bar Chart',
                                                subtitle: '',
                                              },
                                              bars: 'vertical' // Required for Material Bar Charts.
                                            };

                                            var chart = new google.charts.Bar(document.getElementById('barchart_material_student_stats'));

                                            chart.draw(data, google.charts.Bar.convertOptions(options));
                                          }
                                        </script>
                                        <div id="barchart_material_student_stats" style="width: 900px; height: 500px;"></div>
                                </div>
                            </div>
                        </div>


                        <div class="col-xl-4 col-md-6 mb-8">
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

                        

                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-8 col-lg-7">

                        </div>

                        <!-- Pie Chart -->
                        <div class="col-xl-4 col-lg-5">
                          
                        </div>
                    </div>

                   
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" style="text-decoration: none;" href="#page-top">
            <i class="fas fa-"></i>
            <i class="fas fa-angle-up"></i>
            <i class="fas fa-"></i>
        </a>

    <?php
    //logout modal 
    include('includes/logout-modal.php');
    ?>

    <?php
    include('includes/scripts.php');
    include('includes/footer.php');
    ?>
    

    
