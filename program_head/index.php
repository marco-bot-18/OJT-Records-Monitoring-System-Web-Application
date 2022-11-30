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
        <a class="scroll-to-top rounded" style="text-decoration: none;" href="#page-top">
            <i class="fas fa-"></i>
            <i class="fas fa-angle-up"></i>
            <i class="fas fa-"></i>
        </a>
        
        
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
                                        <a class="text-xl font-weight-bold text-info text-uppercase mb-1" href='my_account.php'>Welcome, <?php echo $_SESSION['coordinator_fname']; ?>
                                        </a>
                                     </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                            </div>
                                            <div class="h6 mb-0 font-weight-bold text-gray-800">
                                                <div title="">
                                                    <i class="fas fa-id-badge text-info" title="Program Head ID"></i> &nbsp;My Employee ID is <?php echo $_SESSION['coordinator_id'];?><br>
                                                   <i class="fas fa-user-circle text-info" title="Program Head Name"></i> &nbsp;My Name is <?php echo "".$_SESSION['coordinator_fname']." ".$_SESSION['coordinator_mname']. " ".$_SESSION['coordinator_lname']; ?></b><br>
                                                   <i class="fas fa-user-graduate text-info"></i>&nbsp; I am the Program Head of <?php echo $_SESSION['program_head_of']; ?>
                                                </div>
                                                <div title="Academic Year and Sem">
                                                    <i class="fas fa-book-reader text-info" title="Academic Year and Sem"></i>&nbsp;
                                                      <?php echo $_SESSION['coordinator_acad_yr_sem'];?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- total students -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div style="text-align: right; color: ghostwhite; font-size: 16px; padding-right: 5px;">
                                    <span class="badge">
                                        
                                    </span>
                                </div>
                                <div class="card-body">
                                     <div class="text-xl font-weight-bold text-primary text-uppercase mb-1">
                                        <a class="text-xl font-weight-bold text-primary text-uppercase mb-1" href='students_list.php'>Students
                                        </a>
                                     </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                    $active = "active";
                                                    $isArchived = "not archive";
                                                    $program = $_SESSION['program_head_of'];
                                                    $sql = "SELECT * FROM tbl_students where program='$program' and archived='$isArchived' and status='$active'";
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

                        <!-- DOCUMENTS THAT ARE NOT YET APPROVED -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div style="text-align: right; color: ghostwhite; font-size: 16px; padding-right: 5px;">
                                    <span class="badge badge bg-danger"><!-- badge badge bg-danger -->
                                        <?php
                                            $program_head_name = $_SESSION['coordinator_fullname_session'];
                                            $work_stats = "semi-pending2";
                                            $send_to_PH = "program head";
                                            $stats = "not archived";
                                            $submitted = "yes";
                                            $count = 1;
                                            $sql = "SELECT * from tbl_students_work where name_of_program_head='$program_head_name' and send_to_PH='$send_to_PH' and work_status='$work_stats' and submitted='$submitted' and status='$stats'";
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
                                        <a class="text-xl font-weight-bold text-warning text-uppercase mb-1" href='request_docs_pending.php'>Pending Documents</a>
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                                All
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                    session_start();
                                                    $program_head_name = $_SESSION['coordinator_fullname_session'];
                                                    $work_stats = "semi-pending2";
                                                    $send_to_PH = "program head";
                                                    $stats = "not archived";
                                                    $submitted = "yes";
                                                    $count = 1;
                                                    $sql = "SELECT * from tbl_students_work where name_of_program_head='$program_head_name' and send_to_PH='$send_to_PH' and work_status='$work_stats' and submitted='$submitted' and status='$stats'";
                                                    $query = $conn->query($sql);
                                                    if($query->num_rows==0){
                                                        echo "<h6><b>Congrats! There's No Pending Documents.</b><h6>";
                                                    }
                                                    else{
                                                        echo "<h6><b><a class='font-weight-bold text-gray-800' href='request_docs_pending.php'> There's ".$query->num_rows." Pending Documents "."That Are Not Yet Approved! Please Click Here To View!</a></b></h6>";
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-file fa-2x text-black-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div style="text-align: right; color: ghostwhite; font-size: 16px; padding-right: 5px;">
                                    <span class="badge badge bg-danger">
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
                                        <a class="text-xl font-weight-bold text-success text-uppercase mb-1" href='request_docs_completed.php'>Approved Documents</a>
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
                                                    if($query->num_rows==0){
                                                        echo "<h6><b>There's No Pending Documents That Are Already Sent to Dean</b><h6>";
                                                    }
                                                    else{
                                                        echo "<h6><b><a class='font-weight-bold text-gray-800' href='request_docs_completed.php'> There's ".$query->num_rows." Pending Documents "."That Are Already Sent to Dean! Please Click Here To View!</a></b></h6>";
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

                        <div class="col-xl-12 col-md-6 mb-4">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold" style="color: #990000;"><i class="fas fa-chart-bar"></i> Graphical Representation of In-Campus and Off-Campus OJT Students in <?php echo $_SESSION['program_head_of'] ?> Program </h6>
                                </div>
                                    <div class="card-body" style="background-color: white;">
                                         <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                                        <script type="text/javascript">
                                          google.charts.load('current', {'packages':['bar']});
                                          google.charts.setOnLoadCallback(drawStuff);

                                          <?php
                                            $program = $_SESSION['program_head_of'];
                                            $in_campus = "In-Campus";
                                            $not_archived = "not archive";
                                            $sql = "SELECT * FROM tbl_students where in_off_campus ='$in_campus' and archived='$not_archived' and program='$program'";
                                            $query_in_campus = $conn->query($sql);

                                            $off_campus = "Off-Campus";
                                            $not_archived = "not archive";
                                            $sql = "SELECT * FROM tbl_students where in_off_campus ='$off_campus' and archived='$not_archived' and program='$program'";
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
                                        <div id="top_x_div" style="width: 1000px; height: 500px;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-12 col-md-6 mb-4">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold" style="color: #990000;"><i class="fas fa-chart-bar"></i> Graphical Representation of Sections and Specializations Under <?php echo $_SESSION['program_head_of'] ?> Program </h6>
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
                                                $program = $_SESSION['program_head_of'];
                                                $query="select * from tbl_courses where course_code='$program' and archived='$not_archived'";
                                                $res=mysqli_query($conn,$query);
                                                while($row=mysqli_fetch_array($res)){
                                                  $course=$row['course_title'];

                                                  $not_archived = "not archive";
                                                    $sql = "SELECT * FROM tbl_students where archived='$not_archived' and course ='$course' and program = '$program'";
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
                                              chart: { title: ' Sections and Specializations under <?php echo $_SESSION['program_head_of'] ?> Program Bar Chart',
                                                       subtitle: ' ' },
                                              bars: 'horizontal', // Required for Material Bar Charts.
                                              axes: {
                                                x: {
                                                  0: { side: 'top', label: ''} // Top x-axis.
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
                                    <h6 class="m-0 font-weight-bold" style="color: #990000;"><i class="fas fa-chart-bar"></i> Graphical Representation of Students' Status Per Section Under <?php echo $_SESSION['program_head_of'] ?> Program </h6>
                                </div>
                                    <div class="card-body" style="background-color: white;">
                                        <script type="text/javascript">
                                          google.charts.load('current', {'packages':['bar']});
                                          google.charts.setOnLoadCallback(drawChart);


                                          function drawChart() {
                                            var data = google.visualization.arrayToDataTable([
                                            ['<?php echo "Sections and Specializations"?>', 'Active', 'Dropped', 'Incomplete'],
                                             <?php
                                                $not_archived = "not archived";
                                                $program = $_SESSION['program_head_of'];

                                                $query1="select * from tbl_courses where course_code = '$program' and archived='$not_archived'";
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

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Area Chart -->
                    
                        <!-- Pie Chart -->
                        
                    </div>

                   
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" style="text-decoration:none;" href="#page-top">
            <i class="fas fa-"></i>
            <i class="fas fa-angle-up"></i>
            <i class="fas fa-"></i>
        </a>

    <?php 
    include('includes/logout-modal.php');
    ?>
    <?php
    include('includes/scripts.php');
    include('includes/footer.php');
    ?>
    

    

    
