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
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAnnouncements"
                    aria-expanded="true" aria-controls="collapseUtilities">
                     <i class="fas fa-fw fa-calendar"></i>
                    <span>Announcements</span></a>
                </a>
                <div id="collapseAnnouncements" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Category</i></h6>
                        <a class="collapse-item" href="announcement_for_today.php">Today
                            <span class="badge bg-danger" style="color: white;">
                                <?php
                                    date_default_timezone_set('Asia/Manila');
                                    $td = date("F d, Y");
                                    $receiver_name = $_SESSION['student_fullname_session']; //receiver name get from includes/session.php
                                    $posted_by1 = "Dean";
                                    $posted_by2 = $_SESSION['student_teacher'];
                                    $posted_by3 = "Program Head";
                                    $pub_stats = "published";
                                    $sendTo = "Students";
                                    require_once('includes/db_connect.php');
                                    $stats = "not archived";
                                    $count = 1;
                                    $sql = "SELECT * FROM tbl_announcement_receiver WHERE (posted_by='$posted_by1' and date_='$td' and status='$stats' and publish_status='$pub_stats' and receiver_name='$receiver_name' and sendTo='$sendTo') 
                                        OR 
                                        (posted_by='$posted_by2' and date_='$td' and status='$stats' and publish_status='$pub_stats' and receiver_name='$receiver_name' and sendTo='$sendTo')
                                        OR 
                                        (posted_by='$posted_by3' and date_='$td'  and status='$stats' and publish_status='$pub_stats' and receiver_name='$receiver_name' and sendTo='$sendTo') ORDER BY id DESC";
                                    $query = $conn->query($sql);
                                    echo "".$query->num_rows;
                                ?>
                            </span>
                        </a>
                        <a class="collapse-item" href="announcement_history.php">All
                            <span class="badge bg-danger" style="color: white;">
                                <?php
                                    $receiver_name = $_SESSION['student_fullname_session']; //receiver name get from includes/session.php
                                    $posted_by1 = "Dean";
                                    $posted_by3 = "Program Head";
                                    $posted_by2 = $_SESSION['student_teacher'];
                                    $pub_stats = "published";
                                    $stats = "not archived";
                                    $sendTo = "Students";
                                    require_once('includes/db_connect.php');
                                    $stats = "not archived";
                                    $count = 1;
                                    $sql = "SELECT * FROM tbl_announcement_receiver WHERE (posted_by='$posted_by1' and status='$stats' and publish_status='$pub_stats' and receiver_name='$receiver_name' and sendTo='$sendTo') 
                                        OR 
                                        (posted_by='$posted_by2'  and status='$stats' and publish_status='$pub_stats' and receiver_name='$receiver_name' and sendTo='$sendTo') 
                                        OR 
                                        (posted_by='$posted_by3'  and status='$stats' and publish_status='$pub_stats' and receiver_name='$receiver_name' and sendTo='$sendTo')";
                                    $query = $conn->query($sql);
                                        echo $query->num_rows;
                                ?>
                            </span>
                        </a>
                    </div>
                </div>
            </li>


            <li class="nav-item">
                <a class="nav-link collapsed" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo" href="#">
                    <i class="fas fa-tasks"></i>
                    <span>My Requirements</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Manage</h6>
                        <a class="collapse-item" href="my_requirements_pending.php">To do's
                            <span class="badge bg-danger" style="color: white;">
                                <?php
                                    $student_teacher = $_SESSION['student_teacher'];
                                    $work_stats = "pending";
                                    $stats = "not archived";
                                    $submitted = "no";
                                    $count = 1;
                                    $myfullname_ = $_SESSION['student_fullname_session'];
                                    $sql = "SELECT * from tbl_students_work where stud_name_and_id='$myfullname_' and name_of_teacher='$student_teacher' and work_status='$work_stats' and status='$stats' and submitted='$submitted'";
                                            $query = $conn->query($sql);
                                    echo $query->num_rows;
                                   
                                ?>    
                            </span>
                        </a>
                        <a class="collapse-item" href="my_requirements_ongoing.php">Submitted
                            <span class="badge bg-danger" style="color: white;">
                                <?php
                                    $student_teacher = $_SESSION['student_teacher'];
                                    $work_stats = "semi-pending";
                                    $work_stats1 = "semi-pending2";
                                    $work_stats2 = "semi-pending3";
                                    $stats = "not archived";
                                    $submitted = "yes";
                                    $count = 1;
                                    $myfullname_ = $_SESSION['student_fullname_session'];
                                    $sql = "SELECT * from tbl_students_work where stud_name_and_id='$myfullname_' and name_of_teacher='$student_teacher' and submitted='$submitted' and status='$stats'";
                                    $query = $conn->query($sql);
                                    echo $query->num_rows;
                                ?>
                            </span>
                        </a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="my_category.php">
                    <i class="fas fa-address-book"></i>
                    <span>My Category</span></a>
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

        

        <!-- Logout Modal-->
        <?php 
        include('includes/logout-modal.php');
        ?>
        
        <!-- Topbar  -->
        <?php 
        include('includes/topbar.php');
        ?>  


                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <?php    
                    if(isset($_SESSION['studentID_'])){
                        echo
                        "<div class='alert alert-warning alert-dismissible fade show'><h4><i class='icon fa fa-exclamation'></i> Warning!</h4>".$_SESSION['studentID_']."
                            <button type='button' name='reset' class='close' data-dismiss='alert' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>";
                    }
                    unset($_SESSION['studentID_']);
                    ?>
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"><b>Dashboard</b></h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <div class="col-xl-12 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div style="text-align: right; color: ghostwhite; font-size: 16px; padding-right: 5px;">
                                    <span class="badge">
                                        
                                    </span>
                                </div>
                                <div class="card-body">
                                     <div class="text-xl font-weight-bold text-primary text-uppercase mb-1">
                                        <a class="text-xl font-weight-bold text-primary text-uppercase mb-1" href='my_account.php'>Welcome, <?php echo $_SESSION['student_fname']; ?>
                                        </a>
                                     </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                            </div>
                                            <div class="h6 mb-0 font-weight-bold text-gray-800">
                                                <div title="">
                                                    <i class="fas fa-id-badge" title="Student Name and ID" style="color: #0d6efd;"></i> &nbsp; <?php echo "".$_SESSION['student_fname']." ".$_SESSION['student_mname']. " ".$_SESSION['student_lname']; ?> (<?php echo $_SESSION['student_id'];?>)
                                                </div>

                                                <div title="Course, Year and Section">
                                                    <i class="fas fa-university" title="Course/Program" style="color: #0d6efd;"></i>&nbsp;
                                                    <?php echo "".$_SESSION['student_course']."</b>";?>
                                                </div>
                                                <div title="My OJT Teacher">
                                                    <i class="fas fa-chalkboard-teacher" title="My OJT Teacher" style="color: #0d6efd;"></i>&nbsp;
                                                    <?php echo "".$_SESSION['student_teacher']."</b>";?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user fa-2x text-black-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- MY NEW REQUIREMENTS FOR TODAY -->
                        <div class="col-xl-6 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div style="text-align: right; color: ghostwhite; font-size: 16px; padding-right: 5px;">
                                    <span class="badge bg-danger">
                                        <?php
                                            require_once('includes/db_connect.php');
                                            date_default_timezone_set('Asia/Manila');
                                            $td = date("F d, Y");
                                            $student_teacher = $_SESSION['student_teacher'];
                                            $work_stats = "pending";
                                            $stats = "not archived";
                                            $count = 1;
                                            $submitted = "no";
                                            $myfullname_ = $_SESSION['student_fullname_session'];
                                            $sql = "SELECT * from tbl_students_work where date_='$td' and stud_name_and_id='$myfullname_' and name_of_teacher='$student_teacher' and work_status='$work_stats' and status='$stats' and submitted='$submitted'";
                                            $query = $conn->query($sql);
                                            if($query->num_rows==0){
                                                echo "<a style='color: ghostwhite' href='my_requirements_pending_for_today.php'>".$query->num_rows."</a>";
                                            }
                                            else{
                                                echo "<a style='color: ghostwhite' href='my_requirements_pending_for_today.php'>". $query->num_rows."+ </a>";
                                            }
                                        ?>    
                                    </span>
                                </div>
                                <div class="card-body">
                                <div class="text-xl font-weight-bold text-primary text-uppercase mb-1">
                                <a class="text-xl font-weight-bold text-primary text-uppercase mb-1" href='my_requirements_pending_for_today.php'>TO-DO'S
                                </a></div>
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
                                                include 'db_connect.php';
                                                include 'session.php';
                                                session_start();
                                                date_default_timezone_set('Asia/Manila');
                                                $td = date("F d, Y");
                                                $student_teacher = $_SESSION['student_teacher'];
                                                $work_stats = "pending";
                                                $stats = "not archived";
                                                $count = 1;
                                                $submitted = "no";
                                                $myfullname_ = $_SESSION['student_fullname_session'];
                                                $sql = "SELECT * from tbl_students_work where date_='$td' and stud_name_and_id='$myfullname_' and name_of_teacher='$student_teacher' and work_status='$work_stats' and status='$stats' and submitted='$submitted'";
                                                    $query = $conn->query($sql);
                                                    if($query->num_rows==0){
                                                        echo "<h6><b>There's No New Requirements For Today</b><h6>";
                                                    }
                                                    else{
                                                        echo "<h6><b><a class='font-weight-bold text-gray-800' href='my_requirements_pending_for_today.php'> There's ".$query->num_rows." Submittals "."New For Today! Please Click Here To See Your New Requirements!</a></b></h6>";
                                                    }
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

                        <div class="col-xl-6 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div style="text-align: right; color: ghostwhite; font-size: 16px; padding-right: 5px;">
                                    <span class="badge bg-danger">
                                        <?php
                                            $student_teacher = $_SESSION['student_teacher'];
                                            $work_stats = "pending";
                                            $stats = "not archived";
                                            $submitted = "no";
                                            $count = 1;
                                            $myfullname_ = $_SESSION['student_fullname_session'];
                                            $sql = "SELECT * from tbl_students_work where stud_name_and_id='$myfullname_' and name_of_teacher='$student_teacher' and work_status='$work_stats' and status='$stats' and submitted='$submitted'";
                                                    $query = $conn->query($sql);
                                            if($query->num_rows==0){
                                                echo $query->num_rows;
                                            }
                                            else{
                                                echo "<a style='color: ghostwhite' href='my_requirements_pending.php'>". $query->num_rows."+ </a>";
                                            }
                                        ?>    
                                    </span>
                                </div>
                                <div class="card-body">
                                <div class="text-xl font-weight-bold text-primary text-uppercase mb-1">
                                <a class="text-xl font-weight-bold text-primary text-uppercase mb-1" href='my_requirements_pending.php'>TO-DO'S
                                </a></div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                                All
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                include 'db_connect.php';
                                                include 'session.php';
                                                session_start();
                                                $student_teacher = $_SESSION['student_teacher'];
                                                $work_stats = "pending";
                                                $stats = "not archived";
                                                $submitted = "no";
                                                $count = 1;
                                                $myfullname_ = $_SESSION['student_fullname_session'];
                                                $sql = "SELECT * from tbl_students_work where stud_name_and_id='$myfullname_' and name_of_teacher='$student_teacher' and work_status='$work_stats' and status='$stats' and submitted='$submitted'";
                                                    $query = $conn->query($sql);
                                                    if($query->num_rows==0){
                                                        echo "<h6><b>Congrats, You Have No Pending Requirements.</b><h6>";
                                                    }
                                                    else{
                                                        echo "<h5><b><a class='font-weight-bold text-gray-800' href='my_requirements_pending_for_today.php'>".$query->num_rows."</a></b></h5>";
                                                    }
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

                        <!-- SUBMITTED REQUIREMENTS THAT ARE NOT YET COMPLETED -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div style="text-align: right; color: ghostwhite; font-size: 16px; padding-right: 5px;">
                                    <span class="badge badge-danger">
                                        <?php
                                            $student_teacher = $_SESSION['student_teacher'];
                                            $work_stats = "semi-pending";
                                            $work_stats1 = "semi-pending2";
                                            $work_stats2 = "semi-pending3";
                                            $stats = "not archived";
                                            $submitted = "yes";
                                            $count = 1;
                                            $myfullname_ = $_SESSION['student_fullname_session'];
                                            $sql = "SELECT * from tbl_students_work where stud_name_and_id='$myfullname_' and name_of_teacher='$student_teacher' and work_status='$work_stats' and status='$stats' OR stud_name_and_id='$myfullname_' and name_of_teacher='$student_teacher' and work_status='$work_stats1' and status='$stats' OR stud_name_and_id='$myfullname_' and name_of_teacher='$student_teacher' and work_status='$work_stats2' and status='$stats'";
                                            $query = $conn->query($sql);
                                            if($query->num_rows==0){
                                                echo $query->num_rows;
                                            }
                                            else{
                                                echo "<a style='color: ghostwhite' href='my_requirements_ongoing.php'>". $query->num_rows."+</a>";
                                            }
                                        ?>    
                                    </span>
                                </div>
                                <div class="card-body">
                                <div class="text-xl font-weight-bold text-success text-uppercase mb-1">
                                    <a class="text-xl font-weight-bold text-warning text-uppercase mb-1" href='my_requirements_ongoing.php'>
                                    ONGOING REQUIREMENTS<B style="color: orange;"></B>
                                    </a>
                                </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-s font-weight-bold text-dark text-uppercase mb-1">
                                                <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                                   All
                                                </div>
                                             <span class="badge bg-warning"> PENDING </span>
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?php
                                                include 'db_connect.php';
                                                include 'session.php';
                                                session_start();
                                                $student_teacher = $_SESSION['student_teacher'];
                                                $work_stats = "semi-pending";
                                                $work_stats1 = "semi-pending2";
                                                $work_stats2 = "semi-pending3";
                                                $stats = "not archived";
                                                $submitted = "yes";
                                                $count = 1;
                                                $myfullname_ = $_SESSION['student_fullname_session'];
                                                $sql = "SELECT * from tbl_students_work where stud_name_and_id='$myfullname_' and name_of_teacher='$student_teacher' and work_status='$work_stats' and status='$stats' OR stud_name_and_id='$myfullname_' and name_of_teacher='$student_teacher' and work_status='$work_stats1' and status='$stats' OR stud_name_and_id='$myfullname_' and name_of_teacher='$student_teacher' and work_status='$work_stats2' and status='$stats'";
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

                        <!-- SUBMITTED REQUIREMENTS THAT ARE COMPLETED -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div style="text-align: right; color: ghostwhite; font-size: 16px; padding-right: 5px;">
                                    <span class="badge bg-danger">
                                        <?php
                                            date_default_timezone_set('Asia/Manila');
                                           $student_teacher = $_SESSION['student_teacher'];
                                           $work_stats = "completed";
                                           $submitted = "yes";
                                           $stats = "not archived";
                                           $count = 1;
                                           $myfullname_ = $_SESSION['student_fullname_session'];
                                           $sql = "SELECT * from tbl_students_work where stud_name_and_id='$myfullname_' and name_of_teacher='$student_teacher' and submitted='$submitted' and work_status='$work_stats' and status='$stats'";
                                                    $query = $conn->query($sql);
                                            if($query->num_rows==0){
                                                echo $query->num_rows;
                                            }
                                            else{
                                                echo "<a style='color: ghostwhite' href='my_requirements_completed.php'>". $query->num_rows."+ </a>";
                                            }
                                        ?>    
                                    </span>
                                </div>
                                <div class="card-body">
                                <div class="text-xl font-weight-bold text-success text-uppercase mb-1">
                                    <a class="text-xl font-weight-bold text-success text-uppercase mb-1" href='my_requirements_completed.php'>
                                    COMPLETED REQUIREMENTS
                                    </a>
                                </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-s font-weight-bold text-white text-uppercase mb-1">
                                                <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                                   All
                                                </div>
                                             <span class="badge bg-success"> COMPLETED </span>
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                include 'db_connect.php';
                                                include 'session.php';
                                                session_start();
                                                $student_teacher = $_SESSION['student_teacher'];
                                                $work_stats = "completed";
                                                $submitted = "yes";
                                                $stats = "not archived";
                                                $count = 1;
                                                $myfullname_ = $_SESSION['student_fullname_session'];
                                                $sql = "SELECT * from tbl_students_work where stud_name_and_id='$myfullname_' and name_of_teacher='$student_teacher' and submitted='$submitted' and work_status='$work_stats' and status='$stats'";
                                                        $query = $conn->query($sql);
                                                    if($query->num_rows==0)
                                                    {
                                                        echo $query->num_rows;
                                                    }
                                                    else {
                                                        echo "<h6><b><a class='font-weight-bold text-gray-800' href='my_requirements_completed.php'>There are ".$query->num_rows. " Completed Requirements.</a></b> </h6>";
                                                    }
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

                        <!-- MY NEW REQUIREMENTS FOR TODAY -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div style="text-align: right; color: ghostwhite; font-size: 16px; padding-right: 5px;">
                                    <span class="badge bg-danger">
                                        <?php
                                            require_once('includes/db_connect.php');
                                            $date = date('Y-m-d');
                                            $student_teacher = $_SESSION['student_teacher'];
                                            $work_stats = "pending";
                                            $stats = "not archived";
                                            $count = 1;
                                            $submitted = "no";
                                            $myfullname_ = $_SESSION['student_fullname_session'];
                                            $sql = "SELECT * from tbl_students_work where date_of_submission<'$date' and stud_name_and_id='$myfullname_' and name_of_teacher='$student_teacher' and work_status='$work_stats' and status='$stats' and submitted='$submitted'";
                                            $query = $conn->query($sql);
                                            if($query->num_rows==0){
                                                echo "<a style='color: ghostwhite' href='my_requirements_pending.php'>".$query->num_rows."</a>";
                                            }
                                            else{
                                                echo "<a style='color: ghostwhite' href='my_requirements_pending.php'>". $query->num_rows."+ </a>";
                                            }
                                        ?>    
                                    </span>
                                </div>
                                <div class="card-body">
                                <div class="text-xl font-weight-bold text-danger text-uppercase mb-1">
                                <a class="text-xl font-weight-bold text-danger text-uppercase mb-1" href='my_requirements_pending.php'>MISSING
                                </a></div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                                All
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                include 'db_connect.php';
                                                include 'session.php';
                                                session_start();
                                                date_default_timezone_set('Asia/Manila');
                                                $td = date("F d, Y");
                                                $student_teacher = $_SESSION['student_teacher'];
                                                $work_stats = "pending";
                                                $stats = "not archived";
                                                $count = 1;
                                                $submitted = "no";
                                                $myfullname_ = $_SESSION['student_fullname_session'];
                                                $sql = "SELECT * from tbl_students_work where date_of_submission<'$date' and stud_name_and_id='$myfullname_' and name_of_teacher='$student_teacher' and work_status='$work_stats' and status='$stats' and submitted='$submitted'";
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


                        <!-- MY ACCOMPLISHED REQUIREMENTS APPROVED -->
                        <!-- <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div style="text-align: right; color: ghostwhite; font-size: 16px; padding-right: 5px;">
                                    <span class="badge bg-success">
                                        <?php
                                            date_default_timezone_set('Asia/Manila');
                                            $td = date("F d, Y");
                                            $student_nameee = $_SESSION['student_fullname_session'];
                                                    $remarks = "Approved";
                                                    $work_stats = "completed";
                                                    $stats = "not archived";
                                                    $send_to = "student";
                                                    $ojt_teacher = $_SESSION['student_teacher'];
                                                    //$count = 1;
                                                    $sql = "SELECT * FROM tbl_students_work WHERE status='$stats' and remarks='$remarks' and name_of_teacher='$ojt_teacher' and stud_name_and_id='$student_nameee' and work_status='$work_stats' and send_to = '$send_to'";
                                                    $query = $conn->query($sql);
                                            if($query->num_rows==0){
                                                echo $query->num_rows;
                                            }
                                            else{
                                                echo "<a style='color: ghostwhite' href='my_requirements_completed.php'>". $query->num_rows."</a>";
                                            }
                                        ?>    
                                    </span>
                                </div>
                                <div class="card-body">
                                <div class="text-xl font-weight-bold text-success text-uppercase mb-1">
                                    <a class="text-xl font-weight-bold text-success text-uppercase mb-1" href='my_requirements_completed.php'>
                                    My Accomplished Requirements
                                    </a>
                                </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-s font-weight-bold text-white text-uppercase mb-1">
                                             <span class="badge bg-success">Approved ! </span>
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                include 'db_connect.php';
                                                include 'session.php';
                                                session_start();
                                                $student_nameee = $_SESSION['student_fullname_session'];
                                                    $work_stats = "completed";
                                                    $remarks = "Approved";
                                                    $stats = "not archived";
                                                    $send_to = "student";
                                                    $ojt_teacher = $_SESSION['student_teacher'];
                                                    //$count = 1;
                                                    $sql = "SELECT * FROM tbl_students_work WHERE status='$stats' and name_of_teacher='$ojt_teacher' and remarks='$remarks' and stud_name_and_id='$student_nameee' and work_status='$work_stats' and send_to = '$send_to'";
                                                    $query = $conn->query($sql);
                                                    if($query->num_rows==0)
                                                    {
                                                        echo $query->num_rows;
                                                    }
                                                    else {
                                                        echo "<h6><b><a class='font-weight-bold text-gray-800' href='my_requirements_completed.php'>Congrats! There are ".$query->num_rows. " Approved Requirements. Keep it Up!</a></b> </h5>";
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="far fa-list-alt fa-2x text-black-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                        <!-- MY ACCOMPLISHED REQUIREMENTS WAITING -->
                        <!-- <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div style="text-align: right; color: ghostwhite; font-size: 16px; padding-right: 5px;">
                                    <span class="badge bg-warning">
                                        <?php
                                            date_default_timezone_set('Asia/Manila');
                                            $td = date("F d, Y");
                                            $student_nameee = $_SESSION['student_fullname_session'];
                                                    $work_stats = "completed";
                                                    $remarks = "waiting";
                                                    $stats = "not archived";
                                                    $send_to = "student";
                                                    $ojt_teacher = $_SESSION['student_teacher'];
                                                    //$count = 1;
                                                     $sql = "SELECT * FROM tbl_students_work WHERE status='$stats' and name_of_teacher='$ojt_teacher' and remarks='$remarks' and stud_name_and_id='$student_nameee' and work_status='$work_stats' and send_to = '$send_to'";
                                                    $query = $conn->query($sql);
                                            if($query->num_rows==0){
                                                echo "<h style='color: black'>".$query->num_rows."</h>";
                                            }
                                            else{
                                                echo "<a style='color: black' href='my_requirements_completed.php'>". $query->num_rows."+</a>";
                                            }
                                        ?>    
                                    </span>
                                </div>
                                <div class="card-body">
                                <div class="text-xl font-weight-bold text-success text-uppercase mb-1">
                                    <a class="text-xl font-weight-bold text-success text-uppercase mb-1" href='my_requirements_completed.php'>
                                    My Accomplished Requirements
                                    </a>
                                </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-s font-weight-bold text-uppercase mb-1" style="color: black;">
                                             <span class="badge bg-warning">Waiting</span>
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                include 'db_connect.php';
                                                include 'session.php';
                                                session_start();
                                                $student_nameee = $_SESSION['student_fullname_session'];
                                                    $work_stats = "completed";
                                                    $remarks = "waiting";
                                                    $stats = "not archived";
                                                    $send_to = "student";
                                                    $ojt_teacher = $_SESSION['student_teacher'];
                                                    //$count = 1;
                                                    $sql = "SELECT * FROM tbl_students_work WHERE status='$stats' and name_of_teacher='$ojt_teacher' and remarks='$remarks' and stud_name_and_id='$student_nameee' and work_status='$work_stats' and send_to = '$send_to'";
                                                    $query = $conn->query($sql);
                                                    if($query->num_rows==0)
                                                    {
                                                        echo "<h6><b>Congrats! There Are ".$query->num_rows. " Waiting Remark Requirements.</b></h6>";
                                                    }
                                                    else {
                                                        echo "<h6><b><a class='font-weight-bold text-gray-800' href='my_requirements_completed.php'>There are ".$query->num_rows. " Waiting Remark Requirements. Please Wait The Response of Your OJT Teacher.</a></b></h6>";
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="far fa-list-alt fa-2x text-black-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->


                        <!-- ANNOUNCEMENTS FOR TODAY -->
                        <div class="col-xl-6 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div style="text-align: right; color: ghostwhite; font-size: 16px; padding-right: 5px;">
                                    <span class="badge bg-danger">
                                        <?php
                                            date_default_timezone_set('Asia/Manila');
                                            $td = date("F d, Y");
                                            $receiver_name = $_SESSION['student_fullname_session']; //receiver name get from includes/session.php
                                            $posted_by1 = "Dean";
                                            $posted_by2 = $_SESSION['student_teacher'];
                                            $posted_by3 = "Program Head";
                                            $pub_stats = "published";
                                            $sendTo = "Students";
                                            require_once('includes/db_connect.php');
                                            $stats = "not archived";
                                            $count = 1;
                                            $sql = "SELECT * FROM tbl_announcement_receiver WHERE (posted_by='$posted_by1' and date_='$td' and status='$stats' and publish_status='$pub_stats' and receiver_name='$receiver_name' and sendTo='$sendTo') 
                                                OR 
                                                (posted_by='$posted_by2' and date_='$td' and status='$stats' and publish_status='$pub_stats' and receiver_name='$receiver_name' and sendTo='$sendTo')
                                                OR 
                                                (posted_by='$posted_by3' and date_='$td'  and status='$stats' and publish_status='$pub_stats' and receiver_name='$receiver_name' and sendTo='$sendTo') ORDER BY id DESC";
                                            $query = $conn->query($sql);
                                            if($query->num_rows==0){
                                                echo "".$query->num_rows;
                                            }
                                            else{
                                                echo "<a style='color: ghostwhite' href='announcement_for_today.php'>". $query->num_rows."+ </a>";
                                            }
                                        ?>    
                                    </span>
                                </div>
                                <div class="card-body">
                                <div class="text-xl font-weight-bold text-info text-uppercase mb-1">
                                   <!--  <div class="card-header py-3"> -->
                                <a class="text-xl font-weight-bold text-info text-uppercase mb-1" href='announcement_for_today.php'>Announcements For Today</a></div>
                                <div>
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
                                                    $receiver_name = $_SESSION['student_fullname_session']; //receiver name get from includes/session.php
                                                    $posted_by1 = "Dean";
                                                    $posted_by2 = $_SESSION['student_teacher'];
                                                    $posted_by3 = "Program Head";
                                                    $pub_stats = "published";
                                                    $sendTo = "Students";
                                                    require_once('includes/db_connect.php');
                                                    $stats = "not archived";
                                                    $count = 1;
                                                    $sql = "SELECT * FROM tbl_announcement_receiver WHERE (posted_by='$posted_by1' and date_='$td' and status='$stats' and publish_status='$pub_stats' and receiver_name='$receiver_name' and sendTo='$sendTo') 
                                                        OR 
                                                        (posted_by='$posted_by2' and date_='$td' and status='$stats' and publish_status='$pub_stats' and receiver_name='$receiver_name' and sendTo='$sendTo')
                                                        OR 
                                                        (posted_by='$posted_by3' and date_='$td'  and status='$stats' and publish_status='$pub_stats' and receiver_name='$receiver_name' and sendTo='$sendTo')";
                                                    $query = $conn->query($sql);
                                                    if($query->num_rows==0){
                                                        echo "<h6><b>There's No Announcement For Today</b><h6>";
                                                    }
                                                    else{
                                                        echo "<h6><b><a class='font-weight-bold text-gray-800' href='announcement_for_today.php'> There's ".$query->num_rows." Announcement/s "."For Today! Please Click Here To View the Announcement!</a></b></h6>";
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


                         <!-- ANNOUNCEMENTS (All) -->
                        <div class="col-xl-6 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2" style="background: white;">
                                <div style="text-align: right; color: white; font-size: 16px; padding-right: 5px;">
                                    <span class="badge bg-danger">
                                        <?php
                                            $receiver_name = $_SESSION['student_fullname_session']; //receiver name get from includes/session.php
                                            $posted_by1 = "Dean";
                                            $posted_by3 = "Program Head";
                                            $posted_by2 = $_SESSION['student_teacher'];
                                            $pub_stats = "published";
                                            $stats = "not archived";
                                            $sendTo = "Students";
                                            require_once('includes/db_connect.php');
                                            $stats = "not archived";
                                            $count = 1;
                                            $sql = "SELECT * FROM tbl_announcement_receiver WHERE (posted_by='$posted_by1' and status='$stats' and publish_status='$pub_stats' and receiver_name='$receiver_name' and sendTo='$sendTo') 
                                                OR 
                                                (posted_by='$posted_by2'  and status='$stats' and publish_status='$pub_stats' and receiver_name='$receiver_name' and sendTo='$sendTo') 
                                                OR 
                                                (posted_by='$posted_by3'  and status='$stats' and publish_status='$pub_stats' and receiver_name='$receiver_name' and sendTo='$sendTo')";
                                            $query = $conn->query($sql);
                                            if($query->num_rows==0){
                                                echo $query->num_rows;
                                            }
                                            else{
                                                echo "<a style='color: ghostwhite' href='announcement_history.php'>". $query->num_rows."+</a>";
                                            }
                                        ?>    
                                    </span>
                                </div>
                                <div class="card-body">
                                <div class="text-xl font-weight-bold text-info text-uppercase mb-1"><a class="text-xl font-weight-bold text-info text-uppercase mb-1" href='announcement_history.php'>Announcements</a></div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                               All       
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                    $receiver_name = $_SESSION['student_fullname_session']; //receiver name get from includes/session.php
                                                    $posted_by1 = "Dean";
                                                    $posted_by3 = "Program Head";
                                                    $posted_by2 = $_SESSION['student_teacher'];
                                                    $pub_stats = "published";
                                                    $stats = "not archived";
                                                    $sendTo = "Students";
                                                    require_once('includes/db_connect.php');
                                                    $stats = "not archived";
                                                    $count = 1;
                                                    $sql = "SELECT * FROM tbl_announcement_receiver WHERE (posted_by='$posted_by1' and status='$stats' and publish_status='$pub_stats' and receiver_name='$receiver_name' and sendTo='$sendTo') 
                                                        OR 
                                                        (posted_by='$posted_by2'  and status='$stats' and publish_status='$pub_stats' and receiver_name='$receiver_name' and sendTo='$sendTo') 
                                                        OR 
                                                        (posted_by='$posted_by3'  and status='$stats' and publish_status='$pub_stats' and receiver_name='$receiver_name' and sendTo='$sendTo')";
                                                    $query = $conn->query($sql);
                                                        echo "<h5><b><a class='font-weight-bold text-gray-800' href='announcement_for_today.php'>".$query->num_rows."</a></b></h5>";
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

                    </div>



                    <hr>
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
    include('includes/scripts.php');
    include('includes/footer.php');
    ?>
    

    
