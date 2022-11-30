<style>
#tra{
    color:  #333333;
}
#tra:hover {
    color: black;
    background: #f2f2f2;
}
</style>

<?php
include('includes/session.php'); ?>

<?php 
include('includes/db_connect.php');
$not_archived = "not archived";
$request = $_POST['request']; //get the value of dropwdown options

if (isset($_POST['request'])) {
    if ($_POST['request'] == "All") {
        $work_stats1 = "completed";
        $stats = "not archived";
        $submitted = "yes";
        $count1 = 1;
        $my_fullname_ = $_SESSION['coordinator_fullname_session'];
        $sql = "SELECT * from tbl_students_work where 
            (name_of_teacher='$my_fullname_' and work_status='$work_stats1' and submitted='$submitted' and status='$stats')
            ORDER by id ASC";
        $query = $conn->query($sql);
        $count = mysqli_num_rows($query);
    ?>
    <div class="table-responsive">
        <table class="table table-hover" id="dataTable"  width="100%" cellspacing="20"  id="example" style="color: #333333;">
            <?php 
            if($count){
        ?>
          <thead>
            <tr>
             <center>
                  <th hidden="">TASK CODE</th>
                  <th hidden="">ID</th>
                  <th hidden="">No. </th>
                  <th>Student</th>
                  <th hidden>Course</th>
                  <th>Requirement</th>
                  <th>Submitted File</th>
                  <th>Due Date</th>
                  <th>Turned In</th>
                  <th>My Remarks</th>
                  <th>Status</th>
                  <th>Action</th> 
              </center>
                </tr>
                <?php } else { echo "No data available in table"; }?>
              </thead>
              <tbody>
                <?php
                    while($row = mysqli_fetch_assoc($query)) {
                        $id = $row['id'];
                        $task_code = $row['task_code'];
                        $_SESSION['task_id_22'] = $row['id'];
                ?>
                <tr id="tra">
                    <td hidden=""><?php echo $task_code;?> </td> 
                    <td hidden=""><?php 
                    $_SESSION['t_id_works11'] = $_SESSION['task_id_22'];
                    echo $_SESSION['t_id_works11'];?></td>
                      <td hidden=""><?php echo $count1; ?> </td>
                      <td width=""><?php echo $row['stud_name_and_id']; ?></td>
                      <td hidden><?php echo $row['course'];?> </td>
                      <td><?php echo $row['title'];?> </td>
                      <td width=""><b><a href="../students/upload_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File"><i class="fa fa-file"></i><?php echo $row['uploaded_file'];?></a> </b></td>
                      <td width=""><?php echo $row['date_of_submission'];?> </td>
                      <td width="">
                        <?php
                        //detect the due dates
                            date_default_timezone_set('Asia/Manila'); 
                            $date = date('Y-m-d');
                            $submission = $row['date_of_submission'];
                            if($row['date_submitted_1'] > $submission){
                                echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-danger'>LATE</span>";
                            }
                            else{
                                echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-success'>ON-TIME</span>";
                            }
                        ?> 
                        </td>
                        <td width="10%">
                        <?php 
                            if ($row['remarks'] == 'waiting') {
                                 echo "<span style='font-size: 15px; margin-left: 0px; color: gray;' class='badge badge-pill badge-warning'>WAITING</span>";
                            }

                            if ($row['remarks'] == 'Not Approved') {
                                 echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-danger'>NOT APPROVED</span>";
                            }

                            if ($row['remarks'] == 'Approved') {
                                 echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-success'>APPROVED</span>";
                            }
                        ?>
                      </td>
                      <td width="15%">
                        <?php 
                            if ($row['work_status'] == 'pending') {
                             echo "<div class='progress'>
                                      <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' title='15% on progress'></div>
                                    </div><b>PENDING 15%</b>";
                            }

                            if ($row['work_status'] == 'semi-pending') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' title='25% on progress' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
                                        </div><b>STILL PENDING 25%</b>";
                            }

                            if ($row['work_status'] == 'semi-pending2') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'></div>
                                        </div><b>STILL PENDING 50%</b>";
                            }

                            if ($row['work_status'] == 'semi-pending3') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                        </div><b>STILL PENDING 75%</b>";
                            }

                            if ($row['work_status'] == 'completed') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'>100%</div>
                                        </div><b>COMPLETED</b>";
                            }
                        ?>
                      </td>
                      <td width="">
                          <a href="#view<?php echo $id;?>" title="View Submitted Requirement" data-toggle="modal" ><button class="btn btn-info"><i class="fas fa-eye"></i></button></a>
                      </td>

                <!-- View Modal -->
                <div class="modal fade bd-example-modal-lg" data-backdrop="static" id="view<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="update_place" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document" style="color:  #333333;">
                    <div class="modal-content modal-lg">
                      <div class="modal-header modal-lg">
                        <h5 class="modal-title" id="exampleModalLabel"><h style="color: #0d6efd"><i class="fas fa-file-import"></i> Completed / <?php echo $row['title']; ?> </h><span><?php //echo $row['edited']; ?></span></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-header modal-lg">
                            <p class="modal-title" id="exampleModalLabel">
                            <h title="Date and Time Completed"><i style="color: #1a8cff;" class="fas fa-clock"></i> <?php echo $row['completed_date']; ?> </h></p> 
                        </div>
                      <form action="" method="POST" enctype="multipart/form-data"><!-- form start -->
                      <input type="text" class="form-control" name="id" value="<?php echo $id;?>" hidden>
                      <input type="text" name="task_code" value="<?php echo $task_code;?>" hidden>
                        <div class="modal-body modal-lg">
                            <!-- <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md"> -->
                                        <div class="form-group">
                                            <label>Submitted by: </label> <br>
                                            <b> <?php echo $row['stud_name_and_id']; ?> </b>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label>Course, Year & Section: </label> <br>
                                            <b> <?php echo $row['course']; ?> </b>
                                        </div>
                                        <hr>
                                        <!-- <div class="form-group">
                                            <label>Requirement: </label> <br>
                                            <b> <?php echo $row['title']; ?> </b>
                                        </div>
                                        <hr> -->
                                        <div class="form-group">
                                            <label>Instructions: </label> <br>
                                            <textarea style="background: ghostwhite;" rows="9" name="instructions" class="form-control" id="instructions" aria-describedby="" readonly required=""><?php echo $row['instructions'];?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <!-- may unique na logic yung sa pagviview ng signed na file sa hindi-->
                                        <div class="form-group">
                                            <label>Completed Work/File</label>: <?php //echo $row['edited_by_student'];?><br>
                                            <?php if($row['title'] == "Recommendation Letter") {?><b><a href="../admin/signed_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File"><?php echo $row['uploaded_file'];?></a></b> 
                                            <div class="form-group">
                                                <div class="embed-responsive embed-responsive-1by1">
                                                  <iframe class="embed-responsive-item" src="../admin/signed_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                                                </div>
                                            </div>
                                            <?php } else {?> <b><a href="../students/upload_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File"><?php echo $row['uploaded_file'];?></a></b>
                                            <div class="form-group">
                                                <div class="embed-responsive embed-responsive-1by1">
                                                  <iframe class="embed-responsive-item" src="../students/upload_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div>

                                        <!-- <div class="form-group">
                                            <div class="embed-responsive embed-responsive-1by1">
                                              <iframe class="embed-responsive-item" src="../admin/signed_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                                            </div>
                                        </div> -->

                                        <hr>
                                        <div class="form-group">
                                            <label>Status: </label> <br>
                                            <?php 
                                                if ($row['work_status'] == 'pending') {
                                                 echo "<div class='progress'>
                                                          <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' title='15% on progress'></div>
                                                        </div><b>PENDING 15%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' title='25% on progress' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>STILL PENDING 25%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending2') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'></div>
                                                            </div><b>STILL PENDING 50%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending3') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>STILL PENDING 75%</b>";
                                                }

                                                if ($row['work_status'] == 'completed') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>COMPLETED 100%</b>";
                                                }
                                            ?>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label>My Remarks:</label> <br>
                                            <?php
                                                if ($row['remarks'] == 'waiting') {
                                                     echo "<span style='font-size: 15px; margin-left: 0px; color: gray;' class='badge badge-pill badge-warning'>WAITING</span>";
                                                }

                                                if ($row['remarks'] == 'Not Approved') {
                                                     echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-danger'>NOT APPROVED</span>";
                                                }

                                                if ($row['remarks'] == 'Approved') {
                                                     echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-success'>APPROVED</span>";
                                                }

                                            ?>
                                        </div>
                                        <hr>
                                        <!-- selecting and concatenating the date and time from tbl_students_work -->
                                        <?php 
                                            session_start();
                                            $task_id = $_SESSION['t_id_works11'];
                                            $sql1 = "SELECT Concat(date_submitted,' ',time_submitted) AS dateTTime1 FROM tbl_students_work where id='$task_id'";
                                            $query1 = $conn->query($sql1);
                                            while($row1 = $query1->fetch_assoc()){
                                                $_SESSION['datetime222'] = $row1['dateTTime1'];
                                            }
                                        ?>
                                        <!-- <div class="form-group">
                                            <label>Due Date :</label> <br>
                                            <b><?php
                                                echo $row['date_of_submission'];?></b>
                                        </div>
                                        <hr> -->
                                        <!-- <div class="form-group">
                                            <label>Turned In:</label> <br>
                                            <?php
                                            //detect the due dates
                                                date_default_timezone_set('Asia/Manila'); 
                                                $date = date('Y-m-d');
                                                $submission = $row['date_of_submission'];
                                                if($row['date_submitted_1'] > $submission){
                                                    echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-danger'>LATE</span>";
                                                }
                                                else{
                                                    echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-success'>ON-TIME</span>";;
                                                }
                                            ?> 
                                        </div>
                                        <hr> -->
                                        <!-- <div class="form-group">
                                            <i style="color: #1a8cff;" class="fas fa-clock"></i>
                                            <b title="DATE AND TIME SUBMITTED"> <?php $date_time_posted = $_SESSION['datetime222']; echo $date_time_posted; ?> </b>
                                            <br>
                                            <?php if ($row['edited_by_student']=="(edited)") {?>
                                            <b><span><i style="color: #1a8cff;" class="fas fa-user-edit"></i><?php echo $row['edited_by_student']; ?></span></b>
                                            <?php } else {
                                                echo "";
                                            }?>
                                        </div>
                                        <hr> -->
                                        <div class="form-group">
                                            <label>Comment/s:</label> <br>
                                            <textarea style=" background: ghostwhite;" readonly="" id="comments" name="comments" class="form-control" rows="5" placeholder=""><?php echo $row['student_comment']; ?></textarea>
                                        </div>
                                    <!-- </div>
                                    <div class="col-md"> -->
                                        <hr>
                                        <div class="form-group">
                                            <label>My Comments and Suggestions:</label> <br>
                                            <textarea readonly="" style="background: ghostwhite;" id="my_comments" name="comments" class="form-control" rows="5" placeholder=""><?php echo $row['comment']; ?></textarea>
                                        </div>
                                    <!-- </div>
                                </div>
                            </div> -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                            <!-- <button type="submit" name="submit" class="btn btn-primary">Submit <i class="fas fa-check-square"></i></button> -->
                        </div>
                      </form> <!-- end of form -->
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
            <?php $count1++; } ?> 
          </tbody>
        </table>
    </div>
    <?php }
    //------------>
    else if($_POST['request'] == "Recommendation Letter") {
        $work_stats1 = "completed";
        $stats = "not archived";
        $submitted = "yes";
        $count1 = 1;
        $title = "Recommendation Letter";
        $my_fullname_ = $_SESSION['coordinator_fullname_session'];
        $sql = "SELECT * from tbl_students_work where 
            (title='$title' and name_of_teacher='$my_fullname_' and work_status='$work_stats1' and submitted='$submitted' and status='$stats')
            ORDER by id ASC";
        $query = $conn->query($sql);
        $count = mysqli_num_rows($query);
    ?>
    <div class="table-responsive">
        <table class="table table-hover" id="dataTable" width="100%"  cellspacing="20"  id="example" style="color: #333333;">
            <?php 
            if($count){
        ?>
          <thead>
            <tr>
             <center>
                  <th hidden="">TASK CODE</th>
                  <th hidden="">ID</th>
                  <th hidden="">No. </th>
                  <th>Student</th>
                  <th hidden>Course</th>
                  <th>Requirement</th>
                  <th>Submitted File</th>
                  <th>Due Date</th>
                  <th>Turned In</th>
                  <th>My Remarks</th>
                  <th>Status</th>
                  <th>Action</th> 
              </center>
                </tr>
                <?php } else { echo "No data available in table"; }?>
              </thead>
              <tbody>
                <?php
                    while($row = mysqli_fetch_assoc($query)) {
                        $id = $row['id'];
                        $task_code = $row['task_code'];
                        $_SESSION['task_id_22'] = $row['id'];
                ?>
                <tr id="tra">
                    <td hidden=""><?php echo $task_code;?> </td> 
                    <td hidden=""><?php 
                    $_SESSION['t_id_works11'] = $_SESSION['task_id_22'];
                    echo $_SESSION['t_id_works11'];?></td>
                      <td hidden=""><?php echo $count1; ?> </td>
                      <td width=""><?php echo $row['stud_name_and_id']; ?></td>
                      <td hidden><?php echo $row['course'];?> </td>
                      <td><?php echo $row['title'];?> </td>
                      <td width=""><b><a href="../students/upload_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File"><i class="fa fa-file"></i><?php echo $row['uploaded_file'];?></a> </b></td>
                      <td width=""><?php echo $row['date_of_submission'];?> </td>
                      <td width="">
                        <?php
                        //detect the due dates
                            date_default_timezone_set('Asia/Manila'); 
                            $date = date('Y-m-d');
                            $submission = $row['date_of_submission'];
                            if($row['date_submitted_1'] > $submission){
                                echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-danger'>LATE</span>";
                            }
                            else{
                                echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-success'>ON-TIME</span>";
                            }
                        ?> 
                        </td>
                        <td width="">
                        <?php 
                            if ($row['remarks'] == 'waiting') {
                                 echo "<span style='font-size: 15px; margin-left: 0px; color: gray;' class='badge badge-pill badge-warning'>WAITING</span>";
                            }

                            if ($row['remarks'] == 'Not Approved') {
                                 echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-danger'>NOT APPROVED</span>";
                            }

                            if ($row['remarks'] == 'Approved') {
                                 echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-success'>APPROVED</span>";
                            }
                        ?>
                      </td>
                      <td width="">
                        <?php 
                            if ($row['work_status'] == 'pending') {
                             echo "<div class='progress'>
                                      <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' title='15% on progress'></div>
                                    </div><b>PENDING 15%</b>";
                            }

                            if ($row['work_status'] == 'semi-pending') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' title='25% on progress' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
                                        </div><b>STILL PENDING 25%</b>";
                            }

                            if ($row['work_status'] == 'semi-pending2') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'></div>
                                        </div><b>STILL PENDING 50%</b>";
                            }

                            if ($row['work_status'] == 'semi-pending3') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                        </div><b>STILL PENDING 75%</b>";
                            }

                            if ($row['work_status'] == 'completed') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'>100%</div>
                                        </div><b>COMPLETED</b>";
                            }
                        ?>
                      </td>
                      <td width="">
                          <a href="#view<?php echo $id;?>" title="View Submitted Requirement" data-toggle="modal" ><button class="btn btn-info"><i class="fas fa-eye"></i></button></a>
                      </td>

                <!-- View Modal -->
                <div class="modal fade bd-example-modal-lg" data-backdrop="static" id="view<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="update_place" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document" style="color:  #333333;">
                    <div class="modal-content modal-lg">
                      <div class="modal-header modal-lg">
                        <h5 class="modal-title" id="exampleModalLabel"><h style="color: #0d6efd"><i class="fas fa-file-import"></i> Completed / <?php echo $row['title']; ?> </h><span><?php //echo $row['edited']; ?></span></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-header modal-lg">
                            <p class="modal-title" id="exampleModalLabel">
                            <h title="Date and Time Completed"><i style="color: #1a8cff;" class="fas fa-clock"></i> <?php echo $row['completed_date']; ?> </h></p> 
                        </div>
                      <form action="" method="POST" enctype="multipart/form-data"><!-- form start -->
                      <input type="text" class="form-control" name="id" value="<?php echo $id;?>" hidden>
                      <input type="text" name="task_code" value="<?php echo $task_code;?>" hidden>
                        <div class="modal-body modal-lg">
                            <!-- <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md"> -->
                                        <div class="form-group">
                                            <label>Submitted by: </label> <br>
                                            <b> <?php echo $row['stud_name_and_id']; ?> </b>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label>Course, Year & Section: </label> <br>
                                            <b> <?php echo $row['course']; ?> </b>
                                        </div>
                                        <hr>
                                        <!-- <div class="form-group">
                                            <label>Requirement: </label> <br>
                                            <b> <?php echo $row['title']; ?> </b>
                                        </div>
                                        <hr> -->
                                        <div class="form-group">
                                            <label>Instructions: </label> <br>
                                            <textarea style="background: ghostwhite;" rows="9" name="instructions" class="form-control" id="instructions" aria-describedby="" readonly required=""><?php echo $row['instructions'];?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <!-- may unique na logic yung sa pagviview ng signed na file sa hindi-->
                                        <div class="form-group">
                                            <label>Completed Work/File</label>: <?php //echo $row['edited_by_student'];?><br>
                                            <?php if($row['title'] == "Recommendation Letter") {?><b><a href="../admin/signed_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File"><?php echo $row['uploaded_file'];?></a></b> 
                                            <div class="form-group">
                                                <div class="embed-responsive embed-responsive-1by1">
                                                  <iframe class="embed-responsive-item" src="../admin/signed_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                                                </div>
                                            </div>
                                            <?php } else {?> <b><a href="../students/upload_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File"><?php echo $row['uploaded_file'];?></a></b>
                                            <div class="form-group">
                                                <div class="embed-responsive embed-responsive-1by1">
                                                  <iframe class="embed-responsive-item" src="../students/upload_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div>

                                        <!-- <div class="form-group">
                                            <div class="embed-responsive embed-responsive-1by1">
                                              <iframe class="embed-responsive-item" src="../admin/signed_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                                            </div>
                                        </div> -->

                                        <hr>
                                        <div class="form-group">
                                            <label>Status: </label> <br>
                                            <?php 
                                                if ($row['work_status'] == 'pending') {
                                                 echo "<div class='progress'>
                                                          <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' title='15% on progress'></div>
                                                        </div><b>PENDING 15%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' title='25% on progress' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>STILL PENDING 25%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending2') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'></div>
                                                            </div><b>STILL PENDING 50%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending3') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>STILL PENDING 75%</b>";
                                                }

                                                if ($row['work_status'] == 'completed') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'>100%</div>
                                                            </div><b>COMPLETED</b>";
                                                }
                                            ?>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label>My Remarks:</label> <br>
                                            <?php
                                                if ($row['remarks'] == 'waiting') {
                                                     echo "<span style='font-size: 15px; margin-left: 0px; color: gray;' class='badge badge-pill badge-warning'>WAITING</span>";
                                                }

                                                if ($row['remarks'] == 'Not Approved') {
                                                     echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-danger'>NOT APPROVED</span>";
                                                }

                                                if ($row['remarks'] == 'Approved') {
                                                     echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-success'>APPROVED</span>";
                                                }

                                            ?>
                                        </div>
                                        <hr>
                                        <!-- selecting and concatenating the date and time from tbl_students_work -->
                                        <?php 
                                            session_start();
                                            $task_id = $_SESSION['t_id_works11'];
                                            $sql1 = "SELECT Concat(date_submitted,' ',time_submitted) AS dateTTime1 FROM tbl_students_work where id='$task_id'";
                                            $query1 = $conn->query($sql1);
                                            while($row1 = $query1->fetch_assoc()){
                                                $_SESSION['datetime222'] = $row1['dateTTime1'];
                                            }
                                        ?>
                                        <!-- <div class="form-group">
                                            <label>Due Date :</label> <br>
                                            <b><?php
                                                echo $row['date_of_submission'];?></b>
                                        </div>
                                        <hr> -->
                                        <!-- <div class="form-group">
                                            <label>Turned In:</label> <br>
                                            <?php
                                            //detect the due dates
                                                date_default_timezone_set('Asia/Manila'); 
                                                $date = date('Y-m-d');
                                                $submission = $row['date_of_submission'];
                                                if($row['date_submitted_1'] > $submission){
                                                    echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-danger'>LATE</span>";
                                                }
                                                else{
                                                    echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-success'>ON-TIME</span>";;
                                                }
                                            ?> 
                                        </div>
                                        <hr> -->
                                        <!-- <div class="form-group">
                                            <i style="color: #1a8cff;" class="fas fa-clock"></i>
                                            <b title="DATE AND TIME SUBMITTED"> <?php $date_time_posted = $_SESSION['datetime222']; echo $date_time_posted; ?> </b>
                                            <br>
                                            <?php if ($row['edited_by_student']=="(edited)") {?>
                                            <b><span><i style="color: #1a8cff;" class="fas fa-user-edit"></i><?php echo $row['edited_by_student']; ?></span></b>
                                            <?php } else {
                                                echo "";
                                            }?>
                                        </div>
                                        <hr> -->
                                        <div class="form-group">
                                            <label>Comment/s:</label> <br>
                                            <textarea style=" background: ghostwhite;" readonly="" id="comments" name="comments" class="form-control" rows="5" placeholder=""><?php echo $row['student_comment']; ?></textarea>
                                        </div>
                                    <!-- </div>
                                    <div class="col-md"> -->
                                        <hr>
                                        <div class="form-group">
                                            <label>My Comments and Suggestions:</label> <br>
                                            <textarea readonly="" style="background: ghostwhite;" id="my_comments" name="comments" class="form-control" rows="5" placeholder=""><?php echo $row['comment']; ?></textarea>
                                        </div>
                                    <!-- </div>
                                </div>
                            </div> -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                            <!-- <button type="submit" name="submit" class="btn btn-primary">Submit <i class="fas fa-check-square"></i></button> -->
                        </div>
                      </form> <!-- end of form -->
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
            <?php $count1++; } ?> 
          </tbody>
        </table>
    </div>
    <?php }
    //---------------->
    else if($_POST['request'] == "Memorandum of Agreement") {
        $work_stats1 = "completed";
        $stats = "not archived";
        $submitted = "yes";
        $count1 = 1;
        $title = "Memorandum of Agreement";
        $my_fullname_ = $_SESSION['coordinator_fullname_session'];
        $sql = "SELECT * from tbl_students_work where 
            (title='$title' and name_of_teacher='$my_fullname_' and work_status='$work_stats1' and submitted='$submitted' and status='$stats')
            ORDER by id ASC";
        $query = $conn->query($sql);
        $count = mysqli_num_rows($query);
    ?>
    <div class="table-responsive">
        <table class="table table-hover" id="dataTable" width="100%"  cellspacing="20"  id="example" style="color: #333333;">
            <?php 
            if($count){
        ?>
          <thead>
            <tr>
             <center>
                  <th hidden="">TASK CODE</th>
                  <th hidden="">ID</th>
                  <th>Student</th>
                  <th hidden>Course</th>
                  <th>Requirement</th>
                  <th>Submitted File</th>
                  <th>Due Date</th>
                  <th>Turned In</th>
                  <th>My Remarks</th>
                  <th>Status</th>
                  <th>Action</th> 
              </center>
                </tr>
                <?php } else { echo "No data available in table"; }?>
              </thead>
              <tbody>
                <?php
                    while($row = mysqli_fetch_assoc($query)) {
                        $id = $row['id'];
                        $task_code = $row['task_code'];
                        $_SESSION['task_id_22'] = $row['id'];
                ?>
                <tr id="tra">
                    <td hidden=""><?php echo $task_code;?> </td> 
                    <td hidden=""><?php 
                    $_SESSION['t_id_works11'] = $_SESSION['task_id_22'];
                    echo $_SESSION['t_id_works11'];?></td>
                      <td><?php echo $row['stud_name_and_id']; ?></td>
                      <td hidden><?php echo $row['course'];?> </td>
                      <td><?php echo $row['title'];?> </td>
                      <td><b><a href="../students/upload_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File"><i class="fa fa-file"></i><?php echo $row['uploaded_file'];?></a> </b></td>
                      <td><?php echo $row['date_of_submission'];?> </td>
                      <td>
                        <?php
                        //detect the due dates
                            date_default_timezone_set('Asia/Manila'); 
                            $date = date('Y-m-d');
                            $submission = $row['date_of_submission'];
                            if($row['date_submitted_1'] > $submission){
                                echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-danger'>LATE</span>";
                            }
                            else{
                                echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-success'>ON-TIME</span>";
                            }
                        ?> 
                        </td>
                        <td>
                        <?php 
                            if ($row['remarks'] == 'waiting') {
                                 echo "<span style='font-size: 15px; margin-left: 0px; color: gray;' class='badge badge-pill badge-warning'>WAITING</span>";
                            }

                            if ($row['remarks'] == 'Not Approved') {
                                 echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-danger'>NOT APPROVED</span>";
                            }

                            if ($row['remarks'] == 'Approved') {
                                 echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-success'>APPROVED</span>";
                            }
                        ?>
                      </td>
                      <td>
                        <?php 
                            if ($row['work_status'] == 'pending') {
                             echo "<div class='progress'>
                                      <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' title='15% on progress'></div>
                                    </div><b>PENDING 15%</b>";
                            }

                            if ($row['work_status'] == 'semi-pending') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' title='25% on progress' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
                                        </div><b>STILL PENDING 25%</b>";
                            }

                            if ($row['work_status'] == 'semi-pending2') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'></div>
                                        </div><b>STILL PENDING 50%</b>";
                            }

                            if ($row['work_status'] == 'semi-pending3') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                        </div><b>STILL PENDING 75%</b>";
                            }

                            if ($row['work_status'] == 'completed') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'>100%</div>
                                        </div><b>COMPLETED</b>";
                            }
                        ?>
                      </td>
                      <td width="">
                          <a href="#view<?php echo $id;?>" title="View Submitted Requirement" data-toggle="modal" ><button class="btn btn-info"><i class="fas fa-eye"></i></button></a>
                      </td>

                <!-- View Modal -->
                <div class="modal fade bd-example-modal-lg" data-backdrop="static" id="view<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="update_place" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document" style="color:  #333333;">
                    <div class="modal-content modal-lg">
                      <div class="modal-header modal-lg">
                        <h5 class="modal-title" id="exampleModalLabel"><h style="color: #0d6efd"><i class="fas fa-file-import"></i> Completed / <?php echo $row['title']; ?> </h><span><?php //echo $row['edited']; ?></span></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-header modal-lg">
                            <p class="modal-title" id="exampleModalLabel">
                            <h title="Date and Time Completed"><i style="color: #1a8cff;" class="fas fa-clock"></i> <?php echo $row['completed_date']; ?> </h></p> 
                        </div>
                      <form action="" method="POST" enctype="multipart/form-data"><!-- form start -->
                      <input type="text" class="form-control" name="id" value="<?php echo $id;?>" hidden>
                      <input type="text" name="task_code" value="<?php echo $task_code;?>" hidden>
                        <div class="modal-body modal-lg">
                            <!-- <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md"> -->
                                        <div class="form-group">
                                            <label>Submitted by: </label> <br>
                                            <b> <?php echo $row['stud_name_and_id']; ?> </b>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label>Course, Year & Section: </label> <br>
                                            <b> <?php echo $row['course']; ?> </b>
                                        </div>
                                        <hr>
                                        <!-- <div class="form-group">
                                            <label>Requirement: </label> <br>
                                            <b> <?php echo $row['title']; ?> </b>
                                        </div>
                                        <hr> -->
                                        <div class="form-group">
                                            <label>Instructions: </label> <br>
                                            <textarea style="background: ghostwhite;" rows="9" name="instructions" class="form-control" id="instructions" aria-describedby="" readonly required=""><?php echo $row['instructions'];?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <!-- may unique na logic yung sa pagviview ng signed na file sa hindi-->
                                        <div class="form-group">
                                            <label>Completed Work/File</label>: <?php //echo $row['edited_by_student'];?><br>
                                            <?php if($row['title'] == "Recommendation Letter") {?><b><a href="../admin/signed_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File"><?php echo $row['uploaded_file'];?></a></b> 
                                            <div class="form-group">
                                                <div class="embed-responsive embed-responsive-1by1">
                                                  <iframe class="embed-responsive-item" src="../admin/signed_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                                                </div>
                                            </div>
                                            <?php } else {?> <b><a href="../students/upload_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File"><?php echo $row['uploaded_file'];?></a></b>
                                            <div class="form-group">
                                                <div class="embed-responsive embed-responsive-1by1">
                                                  <iframe class="embed-responsive-item" src="../students/upload_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div>

                                        <!-- <div class="form-group">
                                            <div class="embed-responsive embed-responsive-1by1">
                                              <iframe class="embed-responsive-item" src="../admin/signed_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                                            </div>
                                        </div> -->

                                        <hr>
                                        <div class="form-group">
                                            <label>Status: </label> <br>
                                            <?php 
                                                if ($row['work_status'] == 'pending') {
                                                 echo "<div class='progress'>
                                                          <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' title='15% on progress'></div>
                                                        </div><b>PENDING 15%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' title='25% on progress' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>STILL PENDING 25%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending2') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'></div>
                                                            </div><b>STILL PENDING 50%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending3') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>STILL PENDING 75%</b>";
                                                }

                                                if ($row['work_status'] == 'completed') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'>100%</div>
                                                            </div><b>COMPLETED</b>";
                                                }
                                            ?>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label>My Remarks:</label> <br>
                                            <?php
                                                if ($row['remarks'] == 'waiting') {
                                                     echo "<span style='font-size: 15px; margin-left: 0px; color: gray;' class='badge badge-pill badge-warning'>WAITING</span>";
                                                }

                                                if ($row['remarks'] == 'Not Approved') {
                                                     echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-danger'>NOT APPROVED</span>";
                                                }

                                                if ($row['remarks'] == 'Approved') {
                                                     echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-success'>APPROVED</span>";
                                                }

                                            ?>
                                        </div>
                                        <hr>
                                        <!-- selecting and concatenating the date and time from tbl_students_work -->
                                        <?php 
                                            session_start();
                                            $task_id = $_SESSION['t_id_works11'];
                                            $sql1 = "SELECT Concat(date_submitted,' ',time_submitted) AS dateTTime1 FROM tbl_students_work where id='$task_id'";
                                            $query1 = $conn->query($sql1);
                                            while($row1 = $query1->fetch_assoc()){
                                                $_SESSION['datetime222'] = $row1['dateTTime1'];
                                            }
                                        ?>
                                        <!-- <div class="form-group">
                                            <label>Due Date :</label> <br>
                                            <b><?php
                                                echo $row['date_of_submission'];?></b>
                                        </div>
                                        <hr> -->
                                        <!-- <div class="form-group">
                                            <label>Turned In:</label> <br>
                                            <?php
                                            //detect the due dates
                                                date_default_timezone_set('Asia/Manila'); 
                                                $date = date('Y-m-d');
                                                $submission = $row['date_of_submission'];
                                                if($row['date_submitted_1'] > $submission){
                                                    echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-danger'>LATE</span>";
                                                }
                                                else{
                                                    echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-success'>ON-TIME</span>";;
                                                }
                                            ?> 
                                        </div>
                                        <hr> -->
                                        <!-- <div class="form-group">
                                            <i style="color: #1a8cff;" class="fas fa-clock"></i>
                                            <b title="DATE AND TIME SUBMITTED"> <?php $date_time_posted = $_SESSION['datetime222']; echo $date_time_posted; ?> </b>
                                            <br>
                                            <?php if ($row['edited_by_student']=="(edited)") {?>
                                            <b><span><i style="color: #1a8cff;" class="fas fa-user-edit"></i><?php echo $row['edited_by_student']; ?></span></b>
                                            <?php } else {
                                                echo "";
                                            }?>
                                        </div>
                                        <hr> -->
                                        <div class="form-group">
                                            <label>Comment/s:</label> <br>
                                            <textarea style=" background: ghostwhite;" readonly="" id="comments" name="comments" class="form-control" rows="5" placeholder=""><?php echo $row['student_comment']; ?></textarea>
                                        </div>
                                    <!-- </div>
                                    <div class="col-md"> -->
                                        <hr>
                                        <div class="form-group">
                                            <label>My Comments and Suggestions:</label> <br>
                                            <textarea readonly="" style="background: ghostwhite;" id="my_comments" name="comments" class="form-control" rows="5" placeholder=""><?php echo $row['comment']; ?></textarea>
                                        </div>
                                    <!-- </div>
                                </div>
                            </div> -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                            <!-- <button type="submit" name="submit" class="btn btn-primary">Submit <i class="fas fa-check-square"></i></button> -->
                        </div>
                      </form> <!-- end of form -->
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
    <?php }
    //------------->
    else if($_POST['request'] == "Resume") {
        $work_stats1 = "completed";
        $stats = "not archived";
        $submitted = "yes";
        $count1 = 1;
        $title = "Resume";
        $my_fullname_ = $_SESSION['coordinator_fullname_session'];
        $sql = "SELECT * from tbl_students_work where 
            (title='$title' and name_of_teacher='$my_fullname_' and work_status='$work_stats1' and submitted='$submitted' and status='$stats')
            ORDER by id ASC";
        $query = $conn->query($sql);
        $count = mysqli_num_rows($query);
    ?>
    <div class="table-responsive">
        <table class="table table-hover" id="dataTable" width="100%"  cellspacing="20"  id="example" style="color: #333333;">
            <?php 
            if($count){
        ?>
          <thead>
            <tr>
             <center>
                  <th hidden="">TASK CODE</th>
                  <th hidden="">ID</th>
                  <th>Student</th>
                  <th hidden>Course</th>
                  <th>Requirement</th>
                  <th>Submitted File</th>
                  <th>Due Date</th>
                  <th>Turned In</th>
                  <th>My Remarks</th>
                  <th>Status</th>
                  <th>Action</th> 
              </center>
                </tr>
                <?php } else { echo "No data available in table"; }?>
              </thead>
              <tbody>
                <?php
                    while($row = mysqli_fetch_assoc($query)) {
                        $id = $row['id'];
                        $task_code = $row['task_code'];
                        $_SESSION['task_id_22'] = $row['id'];
                ?>
                <tr id="tra">
                    <td hidden=""><?php echo $task_code;?> </td> 
                    <td hidden=""><?php 
                    $_SESSION['t_id_works11'] = $_SESSION['task_id_22'];
                        echo $_SESSION['t_id_works11'];?></td>
                      <td><?php echo $row['stud_name_and_id']; ?></td>
                      <td hidden><?php echo $row['course'];?> </td>
                      <td><?php echo $row['title'];?> </td>
                      <td width="20%"><b><a href="../students/upload_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File"><i class="fa fa-file"></i><?php echo $row['uploaded_file'];?></a> </b></td>
                      <td><?php echo $row['date_of_submission'];?> </td>
                      <td>
                        <?php
                        //detect the due dates
                            date_default_timezone_set('Asia/Manila'); 
                            $date = date('Y-m-d');
                            $submission = $row['date_of_submission'];
                            if($row['date_submitted_1'] > $submission){
                                echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-danger'>LATE</span>";
                            }
                            else{
                                echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-success'>ON-TIME</span>";
                            }
                        ?> 
                        </td>
                        <td width="10%">
                        <?php 
                            if ($row['remarks'] == 'waiting') {
                                 echo "<span style='font-size: 15px; margin-left: 0px; color: gray;' class='badge badge-pill badge-warning'>WAITING</span>";
                            }

                            if ($row['remarks'] == 'Not Approved') {
                                 echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-danger'>NOT APPROVED</span>";
                            }

                            if ($row['remarks'] == 'Approved') {
                                 echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-success'>APPROVED</span>";
                            }
                        ?>
                      </td>
                      <td>
                        <?php 
                            if ($row['work_status'] == 'pending') {
                             echo "<div class='progress'>
                                      <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' title='15% on progress'></div>
                                    </div><b>PENDING 15%</b>";
                            }

                            if ($row['work_status'] == 'semi-pending') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' title='25% on progress' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
                                        </div><b>STILL PENDING 25%</b>";
                            }

                            if ($row['work_status'] == 'semi-pending2') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'></div>
                                        </div><b>STILL PENDING 50%</b>";
                            }

                            if ($row['work_status'] == 'semi-pending3') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                        </div><b>STILL PENDING 75%</b>";
                            }

                            if ($row['work_status'] == 'completed') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'>100%</div>
                                        </div><b>COMPLETED</b>";
                            }
                        ?>
                      </td>
                      <td width="">
                          <a href="#view<?php echo $id;?>" title="View Submitted Requirement" data-toggle="modal" ><button class="btn btn-info"><i class="fas fa-eye"></i></button></a>
                      </td>

                <!-- View Modal -->
                <div class="modal fade bd-example-modal-lg" data-backdrop="static" id="view<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="update_place" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document" style="color:  #333333;">
                    <div class="modal-content modal-lg">
                      <div class="modal-header modal-lg">
                        <h5 class="modal-title" id="exampleModalLabel"><h style="color: #0d6efd"><i class="fas fa-file-import"></i> Completed / <?php echo $row['title']; ?> </h><span><?php //echo $row['edited']; ?></span></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-header modal-lg">
                            <p class="modal-title" id="exampleModalLabel">
                            <h title="Date and Time Completed"><i style="color: #1a8cff;" class="fas fa-clock"></i> <?php echo $row['completed_date']; ?> </h></p> 
                        </div>
                      <form action="" method="POST" enctype="multipart/form-data"><!-- form start -->
                      <input type="text" class="form-control" name="id" value="<?php echo $id;?>" hidden>
                      <input type="text" name="task_code" value="<?php echo $task_code;?>" hidden>
                        <div class="modal-body modal-lg">
                            <!-- <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md"> -->
                                        <div class="form-group">
                                            <label>Submitted by: </label> <br>
                                            <b> <?php echo $row['stud_name_and_id']; ?> </b>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label>Course, Year & Section: </label> <br>
                                            <b> <?php echo $row['course']; ?> </b>
                                        </div>
                                        <hr>
                                        <!-- <div class="form-group">
                                            <label>Requirement: </label> <br>
                                            <b> <?php echo $row['title']; ?> </b>
                                        </div>
                                        <hr> -->
                                        <div class="form-group">
                                            <label>Instructions: </label> <br>
                                            <textarea style="background: ghostwhite;" rows="9" name="instructions" class="form-control" id="instructions" aria-describedby="" readonly required=""><?php echo $row['instructions'];?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <!-- may unique na logic yung sa pagviview ng signed na file sa hindi-->
                                        <div class="form-group">
                                            <label>Completed Work/File</label>: <?php //echo $row['edited_by_student'];?><br>
                                            <?php if($row['title'] == "Recommendation Letter") {?><b><a href="../admin/signed_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File"><?php echo $row['uploaded_file'];?></a></b> 
                                            <div class="form-group">
                                                <div class="embed-responsive embed-responsive-1by1">
                                                  <iframe class="embed-responsive-item" src="../admin/signed_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                                                </div>
                                            </div>
                                            <?php } else {?> <b><a href="../students/upload_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File"><?php echo $row['uploaded_file'];?></a></b>
                                            <div class="form-group">
                                                <div class="embed-responsive embed-responsive-1by1">
                                                  <iframe class="embed-responsive-item" src="../students/upload_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div>

                                        <!-- <div class="form-group">
                                            <div class="embed-responsive embed-responsive-1by1">
                                              <iframe class="embed-responsive-item" src="../admin/signed_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                                            </div>
                                        </div> -->

                                        <hr>
                                        <div class="form-group">
                                            <label>Status: </label> <br>
                                            <?php 
                                                if ($row['work_status'] == 'pending') {
                                                 echo "<div class='progress'>
                                                          <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' title='15% on progress'></div>
                                                        </div><b>PENDING 15%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' title='25% on progress' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>STILL PENDING 25%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending2') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'></div>
                                                            </div><b>STILL PENDING 50%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending3') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>STILL PENDING 75%</b>";
                                                }

                                                if ($row['work_status'] == 'completed') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'>100%</div>
                                                            </div><b>COMPLETED</b>";
                                                }
                                            ?>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label>My Remarks:</label> <br>
                                            <?php
                                                if ($row['remarks'] == 'waiting') {
                                                     echo "<span style='font-size: 15px; margin-left: 0px; color: gray;' class='badge badge-pill badge-warning'>WAITING</span>";
                                                }

                                                if ($row['remarks'] == 'Not Approved') {
                                                     echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-danger'>NOT APPROVED</span>";
                                                }

                                                if ($row['remarks'] == 'Approved') {
                                                     echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-success'>APPROVED</span>";
                                                }

                                            ?>
                                        </div>
                                        <hr>
                                        <!-- selecting and concatenating the date and time from tbl_students_work -->
                                        <?php 
                                            session_start();
                                            $task_id = $_SESSION['t_id_works11'];
                                            $sql1 = "SELECT Concat(date_submitted,' ',time_submitted) AS dateTTime1 FROM tbl_students_work where id='$task_id'";
                                            $query1 = $conn->query($sql1);
                                            while($row1 = $query1->fetch_assoc()){
                                                $_SESSION['datetime222'] = $row1['dateTTime1'];
                                            }
                                        ?>
                                        <!-- <div class="form-group">
                                            <label>Due Date :</label> <br>
                                            <b><?php
                                                echo $row['date_of_submission'];?></b>
                                        </div>
                                        <hr> -->
                                        <!-- <div class="form-group">
                                            <label>Turned In:</label> <br>
                                            <?php
                                            //detect the due dates
                                                date_default_timezone_set('Asia/Manila'); 
                                                $date = date('Y-m-d');
                                                $submission = $row['date_of_submission'];
                                                if($row['date_submitted_1'] > $submission){
                                                    echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-danger'>LATE</span>";
                                                }
                                                else{
                                                    echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-success'>ON-TIME</span>";;
                                                }
                                            ?> 
                                        </div>
                                        <hr> -->
                                        <!-- <div class="form-group">
                                            <i style="color: #1a8cff;" class="fas fa-clock"></i>
                                            <b title="DATE AND TIME SUBMITTED"> <?php $date_time_posted = $_SESSION['datetime222']; echo $date_time_posted; ?> </b>
                                            <br>
                                            <?php if ($row['edited_by_student']=="(edited)") {?>
                                            <b><span><i style="color: #1a8cff;" class="fas fa-user-edit"></i><?php echo $row['edited_by_student']; ?></span></b>
                                            <?php } else {
                                                echo "";
                                            }?>
                                        </div>
                                        <hr> -->
                                        <div class="form-group">
                                            <label>Comment/s:</label> <br>
                                            <textarea style=" background: ghostwhite;" readonly="" id="comments" name="comments" class="form-control" rows="5" placeholder=""><?php echo $row['student_comment']; ?></textarea>
                                        </div>
                                    <!-- </div>
                                    <div class="col-md"> -->
                                        <hr>
                                        <div class="form-group">
                                            <label>My Comments and Suggestions:</label> <br>
                                            <textarea readonly="" style="background: ghostwhite;" id="my_comments" name="comments" class="form-control" rows="5" placeholder=""><?php echo $row['comment']; ?></textarea>
                                        </div>
                                    <!-- </div>
                                </div>
                            </div> -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                            <!-- <button type="submit" name="submit" class="btn btn-primary">Submit <i class="fas fa-check-square"></i></button> -->
                        </div>
                      </form> <!-- end of form -->
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
            <?php $count1++; } ?> 
          </tbody>
        </table>
    </div>
    <?php } 
    //------------->
    else if($_POST['request'] == "Accomplishment Report") {
        $work_stats1 = "completed";
        $stats = "not archived";
        $submitted = "yes";
        $count1 = 1;
        $title = "Accomplishment Report";
        $my_fullname_ = $_SESSION['coordinator_fullname_session'];
        $sql = "SELECT * from tbl_students_work where 
            (title='$title' and name_of_teacher='$my_fullname_' and work_status='$work_stats1' and submitted='$submitted' and status='$stats')
            ORDER by id ASC";
        $query = $conn->query($sql);
        $count = mysqli_num_rows($query);
    ?>
    <div class="table-responsive">
        <table class="table table-hover" id="dataTable" width="100%" cellspacing="20"  id="example" style="color: #333333;">
            <?php 
            if($count){
        ?>
          <thead>
            <tr>
             <center>
                  <th hidden="">TASK CODE</th>
                  <th hidden="">ID</th>
                  <th>Student</th>
                  <th hidden>Course</th>
                  <th>Requirement</th>
                  <th>Submitted File</th>
                  <th>Due Date</th>
                  <th>Turned In</th>
                  <th>My Remarks</th>
                  <th>Status</th>
                  <th>Action</th> 
              </center>
                </tr>
                <?php } else { echo "No data available in table"; }?>
              </thead>
              <tbody>
                <?php
                    while($row = mysqli_fetch_assoc($query)) {
                        $id = $row['id'];
                        $task_code = $row['task_code'];
                        $_SESSION['task_id_22'] = $row['id'];
                ?>
                <tr id="tra">
                    <td hidden=""><?php echo $task_code;?> </td> 
                    <td hidden=""><?php 
                    $_SESSION['t_id_works11'] = $_SESSION['task_id_22'];
                    echo $_SESSION['t_id_works11'];?></td>
                      <td width="20%"><?php echo $row['stud_name_and_id']; ?></td>
                      <td hidden><?php echo $row['course'];?> </td>
                      <td><?php echo $row['title'];?> </td>
                      <td><b><a href="../students/upload_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File"><i class="fa fa-file"></i><?php echo $row['uploaded_file'];?></a> </b></td>
                      <td><?php echo $row['date_of_submission'];?> </td>
                      <td>
                        <?php
                        //detect the due dates
                            date_default_timezone_set('Asia/Manila'); 
                            $date = date('Y-m-d');
                            $submission = $row['date_of_submission'];
                            if($row['date_submitted_1'] > $submission){
                                echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-danger'>LATE</span>";
                            }
                            else{
                                echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-success'>ON-TIME</span>";
                            }
                        ?> 
                        </td>
                        <td>
                        <?php 
                            if ($row['remarks'] == 'waiting') {
                                 echo "<span style='font-size: 15px; margin-left: 0px; color: gray;' class='badge badge-pill badge-warning'>WAITING</span>";
                            }

                            if ($row['remarks'] == 'Not Approved') {
                                 echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-danger'>NOT APPROVED</span>";
                            }

                            if ($row['remarks'] == 'Approved') {
                                 echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-success'>APPROVED</span>";
                            }
                        ?>
                      </td>
                      <td>
                        <?php 
                            if ($row['work_status'] == 'pending') {
                             echo "<div class='progress'>
                                      <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' title='15% on progress'></div>
                                    </div><b>PENDING 15%</b>";
                            }

                            if ($row['work_status'] == 'semi-pending') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' title='25% on progress' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
                                        </div><b>STILL PENDING 25%</b>";
                            }

                            if ($row['work_status'] == 'semi-pending2') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'></div>
                                        </div><b>STILL PENDING 50%</b>";
                            }

                            if ($row['work_status'] == 'semi-pending3') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                        </div><b>STILL PENDING 75%</b>";
                            }

                            if ($row['work_status'] == 'completed') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'>100%</div>
                                        </div><b>COMPLETED</b>";
                            }
                        ?>
                      </td>
                      <td width="">
                          <a href="#view<?php echo $id;?>" title="View Submitted Requirement" data-toggle="modal" ><button class="btn btn-info"><i class="fas fa-eye"></i></button></a>
                      </td>

                <!-- View Modal -->
                <div class="modal fade bd-example-modal-lg" data-backdrop="static" id="view<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="update_place" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document" style="color:  #333333;">
                    <div class="modal-content modal-lg">
                      <div class="modal-header modal-lg">
                        <h5 class="modal-title" id="exampleModalLabel"><h style="color: #0d6efd"><i class="fas fa-file-import"></i> Completed / <?php echo $row['title']; ?> </h><span><?php //echo $row['edited']; ?></span></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-header modal-lg">
                            <p class="modal-title" id="exampleModalLabel">
                            <h title="Date and Time Completed"><i style="color: #1a8cff;" class="fas fa-clock"></i> <?php echo $row['completed_date']; ?> </h></p> 
                        </div>
                      <form action="" method="POST" enctype="multipart/form-data"><!-- form start -->
                      <input type="text" class="form-control" name="id" value="<?php echo $id;?>" hidden>
                      <input type="text" name="task_code" value="<?php echo $task_code;?>" hidden>
                        <div class="modal-body modal-lg">
                            <!-- <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md"> -->
                                        <div class="form-group">
                                            <label>Submitted by: </label> <br>
                                            <b> <?php echo $row['stud_name_and_id']; ?> </b>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label>Course, Year & Section: </label> <br>
                                            <b> <?php echo $row['course']; ?> </b>
                                        </div>
                                        <hr>
                                        <!-- <div class="form-group">
                                            <label>Requirement: </label> <br>
                                            <b> <?php echo $row['title']; ?> </b>
                                        </div>
                                        <hr> -->
                                        <div class="form-group">
                                            <label>Instructions: </label> <br>
                                            <textarea style="background: ghostwhite;" rows="9" name="instructions" class="form-control" id="instructions" aria-describedby="" readonly required=""><?php echo $row['instructions'];?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <!-- may unique na logic yung sa pagviview ng signed na file sa hindi-->
                                        <div class="form-group">
                                            <label>Completed Work/File</label>: <?php //echo $row['edited_by_student'];?><br>
                                            <?php if($row['title'] == "Recommendation Letter") {?><b><a href="../admin/signed_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File"><?php echo $row['uploaded_file'];?></a></b> 
                                            <div class="form-group">
                                                <div class="embed-responsive embed-responsive-1by1">
                                                  <iframe class="embed-responsive-item" src="../admin/signed_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                                                </div>
                                            </div>
                                            <?php } else {?> <b><a href="../students/upload_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File"><?php echo $row['uploaded_file'];?></a></b>
                                            <div class="form-group">
                                                <div class="embed-responsive embed-responsive-1by1">
                                                  <iframe class="embed-responsive-item" src="../students/upload_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div>

                                        <!-- <div class="form-group">
                                            <div class="embed-responsive embed-responsive-1by1">
                                              <iframe class="embed-responsive-item" src="../admin/signed_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                                            </div>
                                        </div> -->

                                        <hr>
                                        <div class="form-group">
                                            <label>Status: </label> <br>
                                            <?php 
                                                if ($row['work_status'] == 'pending') {
                                                 echo "<div class='progress'>
                                                          <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' title='15% on progress'></div>
                                                        </div><b>PENDING 15%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' title='25% on progress' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>STILL PENDING 25%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending2') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'></div>
                                                            </div><b>STILL PENDING 50%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending3') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>STILL PENDING 75%</b>";
                                                }

                                                if ($row['work_status'] == 'completed') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'>100%</div>
                                                            </div><b>COMPLETED</b>";
                                                }
                                            ?>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label>My Remarks:</label> <br>
                                            <?php
                                                if ($row['remarks'] == 'waiting') {
                                                     echo "<span style='font-size: 15px; margin-left: 0px; color: gray;' class='badge badge-pill badge-warning'>WAITING</span>";
                                                }

                                                if ($row['remarks'] == 'Not Approved') {
                                                     echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-danger'>NOT APPROVED</span>";
                                                }

                                                if ($row['remarks'] == 'Approved') {
                                                     echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-success'>APPROVED</span>";
                                                }

                                            ?>
                                        </div>
                                        <hr>
                                        <!-- selecting and concatenating the date and time from tbl_students_work -->
                                        <?php 
                                            session_start();
                                            $task_id = $_SESSION['t_id_works11'];
                                            $sql1 = "SELECT Concat(date_submitted,' ',time_submitted) AS dateTTime1 FROM tbl_students_work where id='$task_id'";
                                            $query1 = $conn->query($sql1);
                                            while($row1 = $query1->fetch_assoc()){
                                                $_SESSION['datetime222'] = $row1['dateTTime1'];
                                            }
                                        ?>
                                        <!-- <div class="form-group">
                                            <label>Due Date :</label> <br>
                                            <b><?php
                                                echo $row['date_of_submission'];?></b>
                                        </div>
                                        <hr> -->
                                        <!-- <div class="form-group">
                                            <label>Turned In:</label> <br>
                                            <?php
                                            //detect the due dates
                                                date_default_timezone_set('Asia/Manila'); 
                                                $date = date('Y-m-d');
                                                $submission = $row['date_of_submission'];
                                                if($row['date_submitted_1'] > $submission){
                                                    echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-danger'>LATE</span>";
                                                }
                                                else{
                                                    echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-success'>ON-TIME</span>";;
                                                }
                                            ?> 
                                        </div>
                                        <hr> -->
                                        <!-- <div class="form-group">
                                            <i style="color: #1a8cff;" class="fas fa-clock"></i>
                                            <b title="DATE AND TIME SUBMITTED"> <?php $date_time_posted = $_SESSION['datetime222']; echo $date_time_posted; ?> </b>
                                            <br>
                                            <?php if ($row['edited_by_student']=="(edited)") {?>
                                            <b><span><i style="color: #1a8cff;" class="fas fa-user-edit"></i><?php echo $row['edited_by_student']; ?></span></b>
                                            <?php } else {
                                                echo "";
                                            }?>
                                        </div>
                                        <hr> -->
                                        <div class="form-group">
                                            <label>Comment/s:</label> <br>
                                            <textarea style=" background: ghostwhite;" readonly="" id="comments" name="comments" class="form-control" rows="5" placeholder=""><?php echo $row['student_comment']; ?></textarea>
                                        </div>
                                    <!-- </div>
                                    <div class="col-md"> -->
                                        <hr>
                                        <div class="form-group">
                                            <label>My Comments and Suggestions:</label> <br>
                                            <textarea readonly="" style="background: ghostwhite;" id="my_comments" name="comments" class="form-control" rows="5" placeholder=""><?php echo $row['comment']; ?></textarea>
                                        </div>
                                    <!-- </div>
                                </div>
                            </div> -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                            <!-- <button type="submit" name="submit" class="btn btn-primary">Submit <i class="fas fa-check-square"></i></button> -->
                        </div>
                      </form> <!-- end of form -->
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
            <?php $count1++; } ?> 
          </tbody>
        </table>
    </div>
    <?php }
    //-------------->
    else if($_POST['request'] == "Work Plan") {
        $work_stats1 = "completed";
        $stats = "not archived";
        $submitted = "yes";
        $count1 = 1;
        $title = "Work Plan";
        $my_fullname_ = $_SESSION['coordinator_fullname_session'];
        $sql = "SELECT * from tbl_students_work where 
            (title='$title' and name_of_teacher='$my_fullname_' and work_status='$work_stats1' and submitted='$submitted' and status='$stats')
            ORDER by id ASC";
        $query = $conn->query($sql);
        $count = mysqli_num_rows($query);
    ?>
    <div class="table-responsive">
        <table class="table table-hover" id="dataTable" width="100%" cellspacing="20"  id="example" style="color: #333333;">
            <?php 
            if($count){
        ?>
          <thead>
            <tr>
             <center>
                  <th hidden="">TASK CODE</th>
                  <th hidden="">ID</th>
                  <th>Student</th>
                  <th hidden>Course</th>
                  <th>Requirement</th>
                  <th>Submitted File</th>
                  <th>Due Date</th>
                  <th>Turned In</th>
                  <th>My Remarks</th>
                  <th>Status</th>
                  <th>Action</th> 
              </center>
                </tr>
                <?php } else { echo "No data available in table"; }?>
              </thead>
              <tbody>
                <?php
                    while($row = mysqli_fetch_assoc($query)) {
                        $id = $row['id'];
                        $task_code = $row['task_code'];
                        $_SESSION['task_id_22'] = $row['id'];
                ?>
                <tr id="tra">
                    <td hidden=""><?php echo $task_code;?> </td> 
                    <td hidden=""><?php 
                    $_SESSION['t_id_works11'] = $_SESSION['task_id_22'];
                    echo $_SESSION['t_id_works11'];?></td>
                      <td><?php echo $row['stud_name_and_id']; ?></td>
                      <td hidden><?php echo $row['course'];?> </td>
                      <td><?php echo $row['title'];?> </td>
                      <td><b><a href="../students/upload_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File"><i class="fa fa-file"></i><?php echo $row['uploaded_file'];?></a> </b></td>
                      <td><?php echo $row['date_of_submission'];?> </td>
                      <td>
                        <?php
                        //detect the due dates
                            date_default_timezone_set('Asia/Manila'); 
                            $date = date('Y-m-d');
                            $submission = $row['date_of_submission'];
                            if($row['date_submitted_1'] > $submission){
                                echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-danger'>LATE</span>";
                            }
                            else{
                                echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-success'>ON-TIME</span>";
                            }
                        ?> 
                        </td>
                        <td>
                        <?php 
                            if ($row['remarks'] == 'waiting') {
                                 echo "<span style='font-size: 15px; margin-left: 0px; color: gray;' class='badge badge-pill badge-warning'>WAITING</span>";
                            }

                            if ($row['remarks'] == 'Not Approved') {
                                 echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-danger'>NOT APPROVED</span>";
                            }

                            if ($row['remarks'] == 'Approved') {
                                 echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-success'>APPROVED</span>";
                            }
                        ?>
                      </td>
                      <td>
                        <?php 
                            if ($row['work_status'] == 'pending') {
                             echo "<div class='progress'>
                                      <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' title='15% on progress'></div>
                                    </div><b>PENDING 15%</b>";
                            }

                            if ($row['work_status'] == 'semi-pending') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' title='25% on progress' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
                                        </div><b>STILL PENDING 25%</b>";
                            }

                            if ($row['work_status'] == 'semi-pending2') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'></div>
                                        </div><b>STILL PENDING 50%</b>";
                            }

                            if ($row['work_status'] == 'semi-pending3') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                        </div><b>STILL PENDING 75%</b>";
                            }

                            if ($row['work_status'] == 'completed') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'>100%</div>
                                        </div><b>COMPLETED</b>";
                            }
                        ?>
                      </td>
                      <td width="">
                          <a href="#view<?php echo $id;?>" title="View Submitted Requirement" data-toggle="modal" ><button class="btn btn-info"><i class="fas fa-eye"></i></button></a>
                      </td>

                <!-- View Modal -->
                <div class="modal fade bd-example-modal-lg" data-backdrop="static" id="view<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="update_place" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document" style="color:  #333333;">
                    <div class="modal-content modal-lg">
                      <div class="modal-header modal-lg">
                        <h5 class="modal-title" id="exampleModalLabel"><h style="color: #0d6efd"><i class="fas fa-file-import"></i> Completed / <?php echo $row['title']; ?> </h><span><?php //echo $row['edited']; ?></span></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-header modal-lg">
                            <p class="modal-title" id="exampleModalLabel">
                            <h title="Date and Time Completed"><i style="color: #1a8cff;" class="fas fa-clock"></i> <?php echo $row['completed_date']; ?> </h></p> 
                        </div>
                      <form action="" method="POST" enctype="multipart/form-data"><!-- form start -->
                      <input type="text" class="form-control" name="id" value="<?php echo $id;?>" hidden>
                      <input type="text" name="task_code" value="<?php echo $task_code;?>" hidden>
                        <div class="modal-body modal-lg">
                            <!-- <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md"> -->
                                        <div class="form-group">
                                            <label>Submitted by: </label> <br>
                                            <b> <?php echo $row['stud_name_and_id']; ?> </b>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label>Course, Year & Section: </label> <br>
                                            <b> <?php echo $row['course']; ?> </b>
                                        </div>
                                        <hr>
                                        <!-- <div class="form-group">
                                            <label>Requirement: </label> <br>
                                            <b> <?php echo $row['title']; ?> </b>
                                        </div>
                                        <hr> -->
                                        <div class="form-group">
                                            <label>Instructions: </label> <br>
                                            <textarea style="background: ghostwhite;" rows="9" name="instructions" class="form-control" id="instructions" aria-describedby="" readonly required=""><?php echo $row['instructions'];?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <!-- may unique na logic yung sa pagviview ng signed na file sa hindi-->
                                        <div class="form-group">
                                            <label>Completed Work/File</label>: <?php //echo $row['edited_by_student'];?><br>
                                            <?php if($row['title'] == "Recommendation Letter") {?><b><a href="../admin/signed_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File"><?php echo $row['uploaded_file'];?></a></b> 
                                            <div class="form-group">
                                                <div class="embed-responsive embed-responsive-1by1">
                                                  <iframe class="embed-responsive-item" src="../admin/signed_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                                                </div>
                                            </div>
                                            <?php } else {?> <b><a href="../students/upload_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File"><?php echo $row['uploaded_file'];?></a></b>
                                            <div class="form-group">
                                                <div class="embed-responsive embed-responsive-1by1">
                                                  <iframe class="embed-responsive-item" src="../students/upload_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div>

                                        <!-- <div class="form-group">
                                            <div class="embed-responsive embed-responsive-1by1">
                                              <iframe class="embed-responsive-item" src="../admin/signed_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                                            </div>
                                        </div> -->

                                        <hr>
                                        <div class="form-group">
                                            <label>Status: </label> <br>
                                            <?php 
                                                if ($row['work_status'] == 'pending') {
                                                 echo "<div class='progress'>
                                                          <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' title='15% on progress'></div>
                                                        </div><b>PENDING 15%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' title='25% on progress' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>STILL PENDING 25%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending2') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'></div>
                                                            </div><b>STILL PENDING 50%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending3') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>STILL PENDING 75%</b>";
                                                }

                                                if ($row['work_status'] == 'completed') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'>100%</div>
                                                            </div><b>COMPLETED</b>";
                                                }
                                            ?>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label>My Remarks:</label> <br>
                                            <?php
                                                if ($row['remarks'] == 'waiting') {
                                                     echo "<span style='font-size: 15px; margin-left: 0px; color: gray;' class='badge badge-pill badge-warning'>WAITING</span>";
                                                }

                                                if ($row['remarks'] == 'Not Approved') {
                                                     echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-danger'>NOT APPROVED</span>";
                                                }

                                                if ($row['remarks'] == 'Approved') {
                                                     echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-success'>APPROVED</span>";
                                                }

                                            ?>
                                        </div>
                                        <hr>
                                        <!-- selecting and concatenating the date and time from tbl_students_work -->
                                        <?php 
                                            session_start();
                                            $task_id = $_SESSION['t_id_works11'];
                                            $sql1 = "SELECT Concat(date_submitted,' ',time_submitted) AS dateTTime1 FROM tbl_students_work where id='$task_id'";
                                            $query1 = $conn->query($sql1);
                                            while($row1 = $query1->fetch_assoc()){
                                                $_SESSION['datetime222'] = $row1['dateTTime1'];
                                            }
                                        ?>
                                        <!-- <div class="form-group">
                                            <label>Due Date :</label> <br>
                                            <b><?php
                                                echo $row['date_of_submission'];?></b>
                                        </div>
                                        <hr> -->
                                        <!-- <div class="form-group">
                                            <label>Turned In:</label> <br>
                                            <?php
                                            //detect the due dates
                                                date_default_timezone_set('Asia/Manila'); 
                                                $date = date('Y-m-d');
                                                $submission = $row['date_of_submission'];
                                                if($row['date_submitted_1'] > $submission){
                                                    echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-danger'>LATE</span>";
                                                }
                                                else{
                                                    echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-success'>ON-TIME</span>";;
                                                }
                                            ?> 
                                        </div>
                                        <hr> -->
                                        <!-- <div class="form-group">
                                            <i style="color: #1a8cff;" class="fas fa-clock"></i>
                                            <b title="DATE AND TIME SUBMITTED"> <?php $date_time_posted = $_SESSION['datetime222']; echo $date_time_posted; ?> </b>
                                            <br>
                                            <?php if ($row['edited_by_student']=="(edited)") {?>
                                            <b><span><i style="color: #1a8cff;" class="fas fa-user-edit"></i><?php echo $row['edited_by_student']; ?></span></b>
                                            <?php } else {
                                                echo "";
                                            }?>
                                        </div>
                                        <hr> -->
                                        <div class="form-group">
                                            <label>Comment/s:</label> <br>
                                            <textarea style=" background: ghostwhite;" readonly="" id="comments" name="comments" class="form-control" rows="5" placeholder=""><?php echo $row['student_comment']; ?></textarea>
                                        </div>
                                    <!-- </div>
                                    <div class="col-md"> -->
                                        <hr>
                                        <div class="form-group">
                                            <label>My Comments and Suggestions:</label> <br>
                                            <textarea readonly="" style="background: ghostwhite;" id="my_comments" name="comments" class="form-control" rows="5" placeholder=""><?php echo $row['comment']; ?></textarea>
                                        </div>
                                    <!-- </div>
                                </div>
                            </div> -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                            <!-- <button type="submit" name="submit" class="btn btn-primary">Submit <i class="fas fa-check-square"></i></button> -->
                        </div>
                      </form> <!-- end of form -->
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
            <?php $count1++; } ?> 
          </tbody>
        </table>
    </div>
    <?php } 
    //-------------->
    else if($_POST['request'] == "Response Letter") {
        $work_stats1 = "completed";
        $stats = "not archived";
        $submitted = "yes";
        $count1 = 1;
        $title = "Response Letter";
        $my_fullname_ = $_SESSION['coordinator_fullname_session'];
        $sql = "SELECT * from tbl_students_work where 
            (title='$title' and name_of_teacher='$my_fullname_' and work_status='$work_stats1' and submitted='$submitted' and status='$stats')
            ORDER by id ASC";
        $query = $conn->query($sql);
        $count = mysqli_num_rows($query);
    ?>
    <div class="table-responsive">
        <table class="table table-hover" id="dataTable" width="100%" cellspacing="20"  id="example" style="color: #333333;">
            <?php 
            if($count){
        ?>
          <thead>
            <tr>
             <center>
                  <th hidden="">TASK CODE</th>
                  <th hidden="">ID</th>
                  <th>Student</th>
                  <th hidden>Course</th>
                  <th>Requirement</th>
                  <th>Submitted File</th>
                  <th>Due Date</th>
                  <th>Turned In</th>
                  <th>My Remarks</th>
                  <th>Status</th>
                  <th>Action</th> 
              </center>
                </tr>
                <?php } else { echo "No data available in table"; }?>
              </thead>
              <tbody>
                <?php
                    while($row = mysqli_fetch_assoc($query)) {
                        $id = $row['id'];
                        $task_code = $row['task_code'];
                        $_SESSION['task_id_22'] = $row['id'];
                ?>
                <tr id="tra">
                    <td hidden=""><?php echo $task_code;?> </td> 
                    <td hidden=""><?php 
                    $_SESSION['t_id_works11'] = $_SESSION['task_id_22'];
                    echo $_SESSION['t_id_works11'];?></td>
                      <td><?php echo $row['stud_name_and_id']; ?></td>
                      <td hidden><?php echo $row['course'];?> </td>
                      <td><?php echo $row['title'];?> </td>
                      <td><b><a href="../students/upload_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File"><i class="fa fa-file"></i><?php echo $row['uploaded_file'];?></a> </b></td>
                      <td><?php echo $row['date_of_submission'];?> </td>
                      <td>
                        <?php
                        //detect the due dates
                            date_default_timezone_set('Asia/Manila'); 
                            $date = date('Y-m-d');
                            $submission = $row['date_of_submission'];
                            if($row['date_submitted_1'] > $submission){
                                echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-danger'>LATE</span>";
                            }
                            else{
                                echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-success'>ON-TIME</span>";
                            }
                        ?> 
                        </td>
                        <td>
                        <?php 
                            if ($row['remarks'] == 'waiting') {
                                 echo "<span style='font-size: 15px; margin-left: 0px; color: gray;' class='badge badge-pill badge-warning'>WAITING</span>";
                            }

                            if ($row['remarks'] == 'Not Approved') {
                                 echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-danger'>NOT APPROVED</span>";
                            }

                            if ($row['remarks'] == 'Approved') {
                                 echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-success'>APPROVED</span>";
                            }
                        ?>
                      </td>
                      <td>
                        <?php 
                            if ($row['work_status'] == 'pending') {
                             echo "<div class='progress'>
                                      <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' title='15% on progress'></div>
                                    </div><b>PENDING 15%</b>";
                            }

                            if ($row['work_status'] == 'semi-pending') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' title='25% on progress' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
                                        </div><b>STILL PENDING 25%</b>";
                            }

                            if ($row['work_status'] == 'semi-pending2') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'></div>
                                        </div><b>STILL PENDING 50%</b>";
                            }

                            if ($row['work_status'] == 'semi-pending3') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                        </div><b>STILL PENDING 75%</b>";
                            }

                            if ($row['work_status'] == 'completed') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'>100%</div>
                                        </div><b>COMPLETED</b>";
                            }
                        ?>
                      </td>
                      <td width="">
                          <a href="#view<?php echo $id;?>" title="View Submitted Requirement" data-toggle="modal" ><button class="btn btn-info"><i class="fas fa-eye"></i></button></a>
                      </td>

                <!-- View Modal -->
                <div class="modal fade bd-example-modal-lg" data-backdrop="static" id="view<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="update_place" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document" style="color:  #333333;">
                    <div class="modal-content modal-lg">
                      <div class="modal-header modal-lg">
                        <h5 class="modal-title" id="exampleModalLabel"><h style="color: #0d6efd"><i class="fas fa-file-import"></i> Completed / <?php echo $row['title']; ?> </h><span><?php //echo $row['edited']; ?></span></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-header modal-lg">
                            <p class="modal-title" id="exampleModalLabel">
                            <h title="Date and Time Completed"><i style="color: #1a8cff;" class="fas fa-clock"></i> <?php echo $row['completed_date']; ?> </h></p> 
                        </div>
                      <form action="" method="POST" enctype="multipart/form-data"><!-- form start -->
                      <input type="text" class="form-control" name="id" value="<?php echo $id;?>" hidden>
                      <input type="text" name="task_code" value="<?php echo $task_code;?>" hidden>
                        <div class="modal-body modal-lg">
                            <!-- <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md"> -->
                                        <div class="form-group">
                                            <label>Submitted by: </label> <br>
                                            <b> <?php echo $row['stud_name_and_id']; ?> </b>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label>Course, Year & Section: </label> <br>
                                            <b> <?php echo $row['course']; ?> </b>
                                        </div>
                                        <hr>
                                        <!-- <div class="form-group">
                                            <label>Requirement: </label> <br>
                                            <b> <?php echo $row['title']; ?> </b>
                                        </div>
                                        <hr> -->
                                        <div class="form-group">
                                            <label>Instructions: </label> <br>
                                            <textarea style="background: ghostwhite;" rows="9" name="instructions" class="form-control" id="instructions" aria-describedby="" readonly required=""><?php echo $row['instructions'];?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <!-- may unique na logic yung sa pagviview ng signed na file sa hindi-->
                                        <div class="form-group">
                                            <label>Completed Work/File</label>: <?php //echo $row['edited_by_student'];?><br>
                                            <?php if($row['title'] == "Recommendation Letter") {?><b><a href="../admin/signed_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File"><?php echo $row['uploaded_file'];?></a></b> 
                                            <div class="form-group">
                                                <div class="embed-responsive embed-responsive-1by1">
                                                  <iframe class="embed-responsive-item" src="../admin/signed_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                                                </div>
                                            </div>
                                            <?php } else {?> <b><a href="../students/upload_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File"><?php echo $row['uploaded_file'];?></a></b>
                                            <div class="form-group">
                                                <div class="embed-responsive embed-responsive-1by1">
                                                  <iframe class="embed-responsive-item" src="../students/upload_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div>

                                        <!-- <div class="form-group">
                                            <div class="embed-responsive embed-responsive-1by1">
                                              <iframe class="embed-responsive-item" src="../admin/signed_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                                            </div>
                                        </div> -->

                                        <hr>
                                        <div class="form-group">
                                            <label>Status: </label> <br>
                                            <?php 
                                                if ($row['work_status'] == 'pending') {
                                                 echo "<div class='progress'>
                                                          <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' title='15% on progress'></div>
                                                        </div><b>PENDING 15%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' title='25% on progress' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>STILL PENDING 25%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending2') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'></div>
                                                            </div><b>STILL PENDING 50%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending3') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>STILL PENDING 75%</b>";
                                                }

                                                if ($row['work_status'] == 'completed') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'>100%</div>
                                                            </div><b>COMPLETED</b>";
                                                }
                                            ?>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label>My Remarks:</label> <br>
                                            <?php
                                                if ($row['remarks'] == 'waiting') {
                                                     echo "<span style='font-size: 15px; margin-left: 0px; color: gray;' class='badge badge-pill badge-warning'>WAITING</span>";
                                                }

                                                if ($row['remarks'] == 'Not Approved') {
                                                     echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-danger'>NOT APPROVED</span>";
                                                }

                                                if ($row['remarks'] == 'Approved') {
                                                     echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-success'>APPROVED</span>";
                                                }

                                            ?>
                                        </div>
                                        <hr>
                                        <!-- selecting and concatenating the date and time from tbl_students_work -->
                                        <?php 
                                            session_start();
                                            $task_id = $_SESSION['t_id_works11'];
                                            $sql1 = "SELECT Concat(date_submitted,' ',time_submitted) AS dateTTime1 FROM tbl_students_work where id='$task_id'";
                                            $query1 = $conn->query($sql1);
                                            while($row1 = $query1->fetch_assoc()){
                                                $_SESSION['datetime222'] = $row1['dateTTime1'];
                                            }
                                        ?>
                                        <!-- <div class="form-group">
                                            <label>Due Date :</label> <br>
                                            <b><?php
                                                echo $row['date_of_submission'];?></b>
                                        </div>
                                        <hr> -->
                                        <!-- <div class="form-group">
                                            <label>Turned In:</label> <br>
                                            <?php
                                            //detect the due dates
                                                date_default_timezone_set('Asia/Manila'); 
                                                $date = date('Y-m-d');
                                                $submission = $row['date_of_submission'];
                                                if($row['date_submitted_1'] > $submission){
                                                    echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-danger'>LATE</span>";
                                                }
                                                else{
                                                    echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-success'>ON-TIME</span>";;
                                                }
                                            ?> 
                                        </div>
                                        <hr> -->
                                        <!-- <div class="form-group">
                                            <i style="color: #1a8cff;" class="fas fa-clock"></i>
                                            <b title="DATE AND TIME SUBMITTED"> <?php $date_time_posted = $_SESSION['datetime222']; echo $date_time_posted; ?> </b>
                                            <br>
                                            <?php if ($row['edited_by_student']=="(edited)") {?>
                                            <b><span><i style="color: #1a8cff;" class="fas fa-user-edit"></i><?php echo $row['edited_by_student']; ?></span></b>
                                            <?php } else {
                                                echo "";
                                            }?>
                                        </div>
                                        <hr> -->
                                        <div class="form-group">
                                            <label>Comment/s:</label> <br>
                                            <textarea style=" background: ghostwhite;" readonly="" id="comments" name="comments" class="form-control" rows="5" placeholder=""><?php echo $row['student_comment']; ?></textarea>
                                        </div>
                                    <!-- </div>
                                    <div class="col-md"> -->
                                        <hr>
                                        <div class="form-group">
                                            <label>My Comments and Suggestions:</label> <br>
                                            <textarea readonly="" style="background: ghostwhite;" id="my_comments" name="comments" class="form-control" rows="5" placeholder=""><?php echo $row['comment']; ?></textarea>
                                        </div>
                                    <!-- </div>
                                </div>
                            </div> -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                            <!-- <button type="submit" name="submit" class="btn btn-primary">Submit <i class="fas fa-check-square"></i></button> -->
                        </div>
                      </form> <!-- end of form -->
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
            <?php $count1++; } ?> 
          </tbody>
        </table>
    </div>
    <?php }
    //-------------->
    else if($_POST['request'] == "Narrative") {
        $work_stats1 = "completed";
        $stats = "not archived";
        $submitted = "yes";
        $count1 = 1;
        $title = "Narrative";
        $my_fullname_ = $_SESSION['coordinator_fullname_session'];
        $sql = "SELECT * from tbl_students_work where 
            (title='$title' and name_of_teacher='$my_fullname_' and work_status='$work_stats1' and submitted='$submitted' and status='$stats')
            ORDER by id ASC";
        $query = $conn->query($sql);
        $count = mysqli_num_rows($query);
    ?>
    <div class="table-responsive">
        <table class="table table-hover" id="dataTable" width="100%" cellspacing="20"  id="example" style="color: #333333;">
        <?php 
            if($count){
        ?>
          <thead>
            <tr>
             <center>
                  <th hidden="">TASK CODE</th>
                  <th hidden="">ID</th>
                  <th>Student</th>
                  <th hidden>Course</th>
                  <th>Requirement</th>
                  <th>Submitted File</th>
                  <th>Due Date</th>
                  <th>Turned In</th>
                  <th>My Remarks</th>
                  <th>Status</th>
                  <th>Action</th> 
              </center>
                </tr>
                <?php } else { echo "No data available in table"; }?>
              </thead>
              <tbody>
                <?php
                    while($row = mysqli_fetch_assoc($query)) {
                        $id = $row['id'];
                        $task_code = $row['task_code'];
                        $_SESSION['task_id_22'] = $row['id'];
                ?>
                <tr id="tra">
                    <td hidden=""><?php echo $task_code;?> </td> 
                    <td hidden=""><?php 
                    $_SESSION['t_id_works11'] = $_SESSION['task_id_22'];
                    echo $_SESSION['t_id_works11'];?></td>
                      <td><?php echo $row['stud_name_and_id']; ?></td>
                      <td hidden><?php echo $row['course'];?> </td>
                      <td><?php echo $row['title'];?> </td>
                      <td><b><a href="../students/upload_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File"><i class="fa fa-file"></i><?php echo $row['uploaded_file'];?></a> </b></td>
                      <td><?php echo $row['date_of_submission'];?> </td>
                      <td>
                        <?php
                        //detect the due dates
                            date_default_timezone_set('Asia/Manila'); 
                            $date = date('Y-m-d');
                            $submission = $row['date_of_submission'];
                            if($row['date_submitted_1'] > $submission){
                                echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-danger'>LATE</span>";
                            }
                            else{
                                echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-success'>ON-TIME</span>";
                            }
                        ?> 
                        </td>
                        <td>
                        <?php 
                            if ($row['remarks'] == 'waiting') {
                                 echo "<span style='font-size: 15px; margin-left: 0px; color: gray;' class='badge badge-pill badge-warning'>WAITING</span>";
                            }

                            if ($row['remarks'] == 'Not Approved') {
                                 echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-danger'>NOT APPROVED</span>";
                            }

                            if ($row['remarks'] == 'Approved') {
                                 echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-success'>APPROVED</span>";
                            }
                        ?>
                      </td>
                      <td>
                        <?php 
                            if ($row['work_status'] == 'pending') {
                             echo "<div class='progress'>
                                      <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' title='15% on progress'></div>
                                    </div><b>PENDING 15%</b>";
                            }

                            if ($row['work_status'] == 'semi-pending') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' title='25% on progress' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
                                        </div><b>STILL PENDING 25%</b>";
                            }

                            if ($row['work_status'] == 'semi-pending2') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'></div>
                                        </div><b>STILL PENDING 50%</b>";
                            }

                            if ($row['work_status'] == 'semi-pending3') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                        </div><b>STILL PENDING 75%</b>";
                            }

                            if ($row['work_status'] == 'completed') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'>100%</div>
                                        </div><b>COMPLETED</b>";
                            }
                        ?>
                      </td>
                      <td width="">
                          <a href="#view<?php echo $id;?>" title="View Submitted Requirement" data-toggle="modal" ><button class="btn btn-info"><i class="fas fa-eye"></i></button></a>
                      </td>

                <!-- View Modal -->
                <div class="modal fade bd-example-modal-lg" data-backdrop="static" id="view<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="update_place" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document" style="color:  #333333;">
                    <div class="modal-content modal-lg">
                      <div class="modal-header modal-lg">
                        <h5 class="modal-title" id="exampleModalLabel"><h style="color: #0d6efd"><i class="fas fa-file-import"></i> Completed / <?php echo $row['title']; ?> </h><span><?php //echo $row['edited']; ?></span></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-header modal-lg">
                            <p class="modal-title" id="exampleModalLabel">
                            <h title="Date and Time Completed"><i style="color: #1a8cff;" class="fas fa-clock"></i> <?php echo $row['completed_date']; ?> </h></p> 
                        </div>
                      <form action="" method="POST" enctype="multipart/form-data"><!-- form start -->
                      <input type="text" class="form-control" name="id" value="<?php echo $id;?>" hidden>
                      <input type="text" name="task_code" value="<?php echo $task_code;?>" hidden>
                        <div class="modal-body modal-lg">
                            <!-- <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md"> -->
                                        <div class="form-group">
                                            <label>Submitted by: </label> <br>
                                            <b> <?php echo $row['stud_name_and_id']; ?> </b>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label>Course, Year & Section: </label> <br>
                                            <b> <?php echo $row['course']; ?> </b>
                                        </div>
                                        <hr>
                                        <!-- <div class="form-group">
                                            <label>Requirement: </label> <br>
                                            <b> <?php echo $row['title']; ?> </b>
                                        </div>
                                        <hr> -->
                                        <div class="form-group">
                                            <label>Instructions: </label> <br>
                                            <textarea style="background: ghostwhite;" rows="9" name="instructions" class="form-control" id="instructions" aria-describedby="" readonly required=""><?php echo $row['instructions'];?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <!-- may unique na logic yung sa pagviview ng signed na file sa hindi-->
                                        <div class="form-group">
                                            <label>Completed Work/File</label>: <?php //echo $row['edited_by_student'];?><br>
                                            <?php if($row['title'] == "Recommendation Letter") {?><b><a href="../admin/signed_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File"><?php echo $row['uploaded_file'];?></a></b> 
                                            <div class="form-group">
                                                <div class="embed-responsive embed-responsive-1by1">
                                                  <iframe class="embed-responsive-item" src="../admin/signed_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                                                </div>
                                            </div>
                                            <?php } else {?> <b><a href="../students/upload_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File"><?php echo $row['uploaded_file'];?></a></b>
                                            <div class="form-group">
                                                <div class="embed-responsive embed-responsive-1by1">
                                                  <iframe class="embed-responsive-item" src="../students/upload_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div>

                                        <!-- <div class="form-group">
                                            <div class="embed-responsive embed-responsive-1by1">
                                              <iframe class="embed-responsive-item" src="../admin/signed_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                                            </div>
                                        </div> -->

                                        <hr>
                                        <div class="form-group">
                                            <label>Status: </label> <br>
                                            <?php 
                                                if ($row['work_status'] == 'pending') {
                                                 echo "<div class='progress'>
                                                          <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' title='15% on progress'></div>
                                                        </div><b>PENDING 15%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' title='25% on progress' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>STILL PENDING 25%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending2') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'></div>
                                                            </div><b>STILL PENDING 50%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending3') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>STILL PENDING 75%</b>";
                                                }

                                                if ($row['work_status'] == 'completed') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'>100%</div>
                                                            </div><b>COMPLETED</b>";
                                                }
                                            ?>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label>My Remarks:</label> <br>
                                            <?php
                                                if ($row['remarks'] == 'waiting') {
                                                     echo "<span style='font-size: 15px; margin-left: 0px; color: gray;' class='badge badge-pill badge-warning'>WAITING</span>";
                                                }

                                                if ($row['remarks'] == 'Not Approved') {
                                                     echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-danger'>NOT APPROVED</span>";
                                                }

                                                if ($row['remarks'] == 'Approved') {
                                                     echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-success'>APPROVED</span>";
                                                }

                                            ?>
                                        </div>
                                        <hr>
                                        <!-- selecting and concatenating the date and time from tbl_students_work -->
                                        <?php 
                                            session_start();
                                            $task_id = $_SESSION['t_id_works11'];
                                            $sql1 = "SELECT Concat(date_submitted,' ',time_submitted) AS dateTTime1 FROM tbl_students_work where id='$task_id'";
                                            $query1 = $conn->query($sql1);
                                            while($row1 = $query1->fetch_assoc()){
                                                $_SESSION['datetime222'] = $row1['dateTTime1'];
                                            }
                                        ?>
                                        <!-- <div class="form-group">
                                            <label>Due Date :</label> <br>
                                            <b><?php
                                                echo $row['date_of_submission'];?></b>
                                        </div>
                                        <hr> -->
                                        <!-- <div class="form-group">
                                            <label>Turned In:</label> <br>
                                            <?php
                                            //detect the due dates
                                                date_default_timezone_set('Asia/Manila'); 
                                                $date = date('Y-m-d');
                                                $submission = $row['date_of_submission'];
                                                if($row['date_submitted_1'] > $submission){
                                                    echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-danger'>LATE</span>";
                                                }
                                                else{
                                                    echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-success'>ON-TIME</span>";;
                                                }
                                            ?> 
                                        </div>
                                        <hr> -->
                                        <!-- <div class="form-group">
                                            <i style="color: #1a8cff;" class="fas fa-clock"></i>
                                            <b title="DATE AND TIME SUBMITTED"> <?php $date_time_posted = $_SESSION['datetime222']; echo $date_time_posted; ?> </b>
                                            <br>
                                            <?php if ($row['edited_by_student']=="(edited)") {?>
                                            <b><span><i style="color: #1a8cff;" class="fas fa-user-edit"></i><?php echo $row['edited_by_student']; ?></span></b>
                                            <?php } else {
                                                echo "";
                                            }?>
                                        </div>
                                        <hr> -->
                                        <div class="form-group">
                                            <label>Comment/s:</label> <br>
                                            <textarea style=" background: ghostwhite;" readonly="" id="comments" name="comments" class="form-control" rows="5" placeholder=""><?php echo $row['student_comment']; ?></textarea>
                                        </div>
                                    <!-- </div>
                                    <div class="col-md"> -->
                                        <hr>
                                        <div class="form-group">
                                            <label>My Comments and Suggestions:</label> <br>
                                            <textarea readonly="" style="background: ghostwhite;" id="my_comments" name="comments" class="form-control" rows="5" placeholder=""><?php echo $row['comment']; ?></textarea>
                                        </div>
                                    <!-- </div>
                                </div>
                            </div> -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                            <!-- <button type="submit" name="submit" class="btn btn-primary">Submit <i class="fas fa-check-square"></i></button> -->
                        </div>
                      </form> <!-- end of form -->
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
            <?php $count1++; } ?> 
          </tbody>
        </table>
    </div>
    <?php }
    //-------------->
    else if($_POST['request'] == "Performance Sheet") {
        $work_stats1 = "completed";
        $stats = "not archived";
        $submitted = "yes";
        $count1 = 1;
        $title = "Performance Sheet";
        $my_fullname_ = $_SESSION['coordinator_fullname_session'];
        $sql = "SELECT * from tbl_students_work where 
            (title='$title' and name_of_teacher='$my_fullname_' and work_status='$work_stats1' and submitted='$submitted' and status='$stats')
            ORDER by id ASC";
        $query = $conn->query($sql);
        $count = mysqli_num_rows($query);
    ?>
    <div class="table-responsive">
        <table class="table table-hover" id="dataTable" width="100%"  cellspacing="20"  id="example" style="color: #333333;">
        <?php 
            if($count){
        ?>
          <thead>
            <tr>
             <center>
                  <th hidden="">TASK CODE</th>
                  <th hidden="">ID</th>
                  <th>Student</th>
                  <th hidden>Course</th>
                  <th>Requirement</th>
                  <th>Submitted File</th>
                  <th>Due Date</th>
                  <th>Turned In</th>
                  <th>My Remarks</th>
                  <th>Status</th>
                  <th>Action</th> 
              </center>
                </tr>
                <?php } else { echo "No data available in table"; }?>
              </thead>
              <tbody>
                <?php
                    while($row = mysqli_fetch_assoc($query)) {
                        $id = $row['id'];
                        $task_code = $row['task_code'];
                        $_SESSION['task_id_22'] = $row['id'];
                ?>
                <tr id="tra">
                    <td hidden=""><?php echo $task_code;?> </td> 
                    <td hidden=""><?php 
                    $_SESSION['t_id_works11'] = $_SESSION['task_id_22'];
                    echo $_SESSION['t_id_works11'];?></td>
                      <td><?php echo $row['stud_name_and_id']; ?></td>
                      <td hidden><?php echo $row['course'];?> </td>
                      <td><?php echo $row['title'];?> </td>
                      <td><b><a href="../students/upload_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File"><i class="fa fa-file"></i><?php echo $row['uploaded_file'];?></a> </b></td>
                      <td><?php echo $row['date_of_submission'];?> </td>
                      <td>
                        <?php
                        //detect the due dates
                            date_default_timezone_set('Asia/Manila'); 
                            $date = date('Y-m-d');
                            $submission = $row['date_of_submission'];
                            if($row['date_submitted_1'] > $submission){
                                echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-danger'>LATE</span>";
                            }
                            else{
                                echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-success'>ON-TIME</span>";
                            }
                        ?> 
                        </td>
                        <td>
                        <?php 
                            if ($row['remarks'] == 'waiting') {
                                 echo "<span style='font-size: 15px; margin-left: 0px; color: gray;' class='badge badge-pill badge-warning'>WAITING</span>";
                            }

                            if ($row['remarks'] == 'Not Approved') {
                                 echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-danger'>NOT APPROVED</span>";
                            }

                            if ($row['remarks'] == 'Approved') {
                                 echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-success'>APPROVED</span>";
                            }
                        ?>
                      </td>
                      <td>
                        <?php 
                            if ($row['work_status'] == 'pending') {
                             echo "<div class='progress'>
                                      <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' title='15% on progress'></div>
                                    </div><b>PENDING 15%</b>";
                            }

                            if ($row['work_status'] == 'semi-pending') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' title='25% on progress' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
                                        </div><b>STILL PENDING 25%</b>";
                            }

                            if ($row['work_status'] == 'semi-pending2') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'></div>
                                        </div><b>STILL PENDING 50%</b>";
                            }

                            if ($row['work_status'] == 'semi-pending3') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                        </div><b>STILL PENDING 75%</b>";
                            }

                            if ($row['work_status'] == 'completed') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'>100%</div>
                                        </div><b>COMPLETED</b>";
                            }
                        ?>
                      </td>
                      <td width="">
                          <a href="#view<?php echo $id;?>" title="View Submitted Requirement" data-toggle="modal" ><button class="btn btn-info"><i class="fas fa-eye"></i></button></a>
                      </td>

                <!-- View Modal -->
                <div class="modal fade bd-example-modal-lg" data-backdrop="static" id="view<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="update_place" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document" style="color:  #333333;">
                    <div class="modal-content modal-lg">
                      <div class="modal-header modal-lg">
                        <h5 class="modal-title" id="exampleModalLabel"><h style="color: #0d6efd"><i class="fas fa-file-import"></i> Completed / <?php echo $row['title']; ?> </h><span><?php //echo $row['edited']; ?></span></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-header modal-lg">
                            <p class="modal-title" id="exampleModalLabel">
                            <h title="Date and Time Completed"><i style="color: #1a8cff;" class="fas fa-clock"></i> <?php echo $row['completed_date']; ?> </h></p> 
                        </div>
                      <form action="" method="POST" enctype="multipart/form-data"><!-- form start -->
                      <input type="text" class="form-control" name="id" value="<?php echo $id;?>" hidden>
                      <input type="text" name="task_code" value="<?php echo $task_code;?>" hidden>
                        <div class="modal-body modal-lg">
                            <!-- <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md"> -->
                                        <div class="form-group">
                                            <label>Submitted by: </label> <br>
                                            <b> <?php echo $row['stud_name_and_id']; ?> </b>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label>Course, Year & Section: </label> <br>
                                            <b> <?php echo $row['course']; ?> </b>
                                        </div>
                                        <hr>
                                        <!-- <div class="form-group">
                                            <label>Requirement: </label> <br>
                                            <b> <?php echo $row['title']; ?> </b>
                                        </div>
                                        <hr> -->
                                        <div class="form-group">
                                            <label>Instructions: </label> <br>
                                            <textarea style="background: ghostwhite;" rows="9" name="instructions" class="form-control" id="instructions" aria-describedby="" readonly required=""><?php echo $row['instructions'];?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <!-- may unique na logic yung sa pagviview ng signed na file sa hindi-->
                                        <div class="form-group">
                                            <label>Completed Work/File</label>: <?php //echo $row['edited_by_student'];?><br>
                                            <?php if($row['title'] == "Recommendation Letter") {?><b><a href="../admin/signed_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File"><?php echo $row['uploaded_file'];?></a></b> 
                                            <div class="form-group">
                                                <div class="embed-responsive embed-responsive-1by1">
                                                  <iframe class="embed-responsive-item" src="../admin/signed_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                                                </div>
                                            </div>
                                            <?php } else {?> <b><a href="../students/upload_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File"><?php echo $row['uploaded_file'];?></a></b>
                                            <div class="form-group">
                                                <div class="embed-responsive embed-responsive-1by1">
                                                  <iframe class="embed-responsive-item" src="../students/upload_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div>

                                        <!-- <div class="form-group">
                                            <div class="embed-responsive embed-responsive-1by1">
                                              <iframe class="embed-responsive-item" src="../admin/signed_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                                            </div>
                                        </div> -->

                                        <hr>
                                        <div class="form-group">
                                            <label>Status: </label> <br>
                                            <?php 
                                                if ($row['work_status'] == 'pending') {
                                                 echo "<div class='progress'>
                                                          <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' title='15% on progress'></div>
                                                        </div><b>PENDING 15%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' title='25% on progress' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>STILL PENDING 25%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending2') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'></div>
                                                            </div><b>STILL PENDING 50%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending3') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>STILL PENDING 75%</b>";
                                                }

                                                if ($row['work_status'] == 'completed') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'>100%</div>
                                                            </div><b>COMPLETED</b>";
                                                }
                                            ?>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label>My Remarks:</label> <br>
                                            <?php
                                                if ($row['remarks'] == 'waiting') {
                                                     echo "<span style='font-size: 15px; margin-left: 0px; color: gray;' class='badge badge-pill badge-warning'>WAITING</span>";
                                                }

                                                if ($row['remarks'] == 'Not Approved') {
                                                     echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-danger'>NOT APPROVED</span>";
                                                }

                                                if ($row['remarks'] == 'Approved') {
                                                     echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-success'>APPROVED</span>";
                                                }

                                            ?>
                                        </div>
                                        <hr>
                                        <!-- selecting and concatenating the date and time from tbl_students_work -->
                                        <?php 
                                            session_start();
                                            $task_id = $_SESSION['t_id_works11'];
                                            $sql1 = "SELECT Concat(date_submitted,' ',time_submitted) AS dateTTime1 FROM tbl_students_work where id='$task_id'";
                                            $query1 = $conn->query($sql1);
                                            while($row1 = $query1->fetch_assoc()){
                                                $_SESSION['datetime222'] = $row1['dateTTime1'];
                                            }
                                        ?>
                                        <!-- <div class="form-group">
                                            <label>Due Date :</label> <br>
                                            <b><?php
                                                echo $row['date_of_submission'];?></b>
                                        </div>
                                        <hr> -->
                                        <!-- <div class="form-group">
                                            <label>Turned In:</label> <br>
                                            <?php
                                            //detect the due dates
                                                date_default_timezone_set('Asia/Manila'); 
                                                $date = date('Y-m-d');
                                                $submission = $row['date_of_submission'];
                                                if($row['date_submitted_1'] > $submission){
                                                    echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-danger'>LATE</span>";
                                                }
                                                else{
                                                    echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-success'>ON-TIME</span>";;
                                                }
                                            ?> 
                                        </div>
                                        <hr> -->
                                        <!-- <div class="form-group">
                                            <i style="color: #1a8cff;" class="fas fa-clock"></i>
                                            <b title="DATE AND TIME SUBMITTED"> <?php $date_time_posted = $_SESSION['datetime222']; echo $date_time_posted; ?> </b>
                                            <br>
                                            <?php if ($row['edited_by_student']=="(edited)") {?>
                                            <b><span><i style="color: #1a8cff;" class="fas fa-user-edit"></i><?php echo $row['edited_by_student']; ?></span></b>
                                            <?php } else {
                                                echo "";
                                            }?>
                                        </div>
                                        <hr> -->
                                        <div class="form-group">
                                            <label>Comment/s:</label> <br>
                                            <textarea style=" background: ghostwhite;" readonly="" id="comments" name="comments" class="form-control" rows="5" placeholder=""><?php echo $row['student_comment']; ?></textarea>
                                        </div>
                                    <!-- </div>
                                    <div class="col-md"> -->
                                        <hr>
                                        <div class="form-group">
                                            <label>My Comments and Suggestions:</label> <br>
                                            <textarea readonly="" style="background: ghostwhite;" id="my_comments" name="comments" class="form-control" rows="5" placeholder=""><?php echo $row['comment']; ?></textarea>
                                        </div>
                                    <!-- </div>
                                </div>
                            </div> -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                            <!-- <button type="submit" name="submit" class="btn btn-primary">Submit <i class="fas fa-check-square"></i></button> -->
                        </div>
                      </form> <!-- end of form -->
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
            <?php $count1++; } ?> 
          </tbody>
        </table>
    </div>
    <?php }
    //-------------->
    else if($_POST['request'] == "Endorsement Letter") {
        $work_stats1 = "completed";
        $stats = "not archived";
        $submitted = "yes";
        $count1 = 1;
        $title = "Endorsement Letter";
        $my_fullname_ = $_SESSION['coordinator_fullname_session'];
        $sql = "SELECT * from tbl_students_work where 
            (title='$title' and name_of_teacher='$my_fullname_' and work_status='$work_stats1' and submitted='$submitted' and status='$stats')
            ORDER by id ASC";
        $query = $conn->query($sql);
        $count = mysqli_num_rows($query);
    ?>
    <div class="table-responsive">
        <table class="table table-hover" id="dataTable" width="100%"  cellspacing="20"  id="example" style="color: #333333;">
        <?php 
            if($count){
        ?>
          <thead>
            <tr>
             <center>
                  <th hidden="">TASK CODE</th>
                  <th hidden="">ID</th>
                  <th>Student</th>
                  <th hidden>Course</th>
                  <th>Requirement</th>
                  <th>Submitted File</th>
                  <th>Due Date</th>
                  <th>Turned In</th>
                  <th>My Remarks</th>
                  <th>Status</th>
                  <th>Action</th> 
              </center>
                </tr>
                <?php } else { echo "No data available in table"; }?>
              </thead>
              <tbody>
                <?php
                    while($row = mysqli_fetch_assoc($query)) {
                        $id = $row['id'];
                        $task_code = $row['task_code'];
                        $_SESSION['task_id_22'] = $row['id'];
                ?>
                <tr id="tra">
                    <td hidden=""><?php echo $task_code;?> </td> 
                    <td hidden=""><?php 
                    $_SESSION['t_id_works11'] = $_SESSION['task_id_22'];
                    echo $_SESSION['t_id_works11'];?></td>
                      <td><?php echo $row['stud_name_and_id']; ?></td>
                      <td hidden><?php echo $row['course'];?> </td>
                      <td><?php echo $row['title'];?> </td>
                      <td><b><a href="../students/upload_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File"><i class="fa fa-file"></i><?php echo $row['uploaded_file'];?></a> </b></td>
                      <td><?php echo $row['date_of_submission'];?> </td>
                      <td>
                        <?php
                        //detect the due dates
                            date_default_timezone_set('Asia/Manila'); 
                            $date = date('Y-m-d');
                            $submission = $row['date_of_submission'];
                            if($row['date_submitted_1'] > $submission){
                                echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-danger'>LATE</span>";
                            }
                            else{
                                echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-success'>ON-TIME</span>";
                            }
                        ?> 
                        </td>
                        <td>
                        <?php 
                            if ($row['remarks'] == 'waiting') {
                                 echo "<span style='font-size: 15px; margin-left: 0px; color: gray;' class='badge badge-pill badge-warning'>WAITING</span>";
                            }

                            if ($row['remarks'] == 'Not Approved') {
                                 echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-danger'>NOT APPROVED</span>";
                            }

                            if ($row['remarks'] == 'Approved') {
                                 echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-success'>APPROVED</span>";
                            }
                        ?>
                      </td>
                      <td>
                        <?php 
                            if ($row['work_status'] == 'pending') {
                             echo "<div class='progress'>
                                      <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' title='15% on progress'></div>
                                    </div><b>PENDING 15%</b>";
                            }

                            if ($row['work_status'] == 'semi-pending') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' title='25% on progress' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
                                        </div><b>STILL PENDING 25%</b>";
                            }

                            if ($row['work_status'] == 'semi-pending2') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'></div>
                                        </div><b>STILL PENDING 50%</b>";
                            }

                            if ($row['work_status'] == 'semi-pending3') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                        </div><b>STILL PENDING 75%</b>";
                            }

                            if ($row['work_status'] == 'completed') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'>100%</div>
                                        </div><b>COMPLETED</b>";
                            }
                        ?>
                      </td>
                      <td width="">
                          <a href="#view<?php echo $id;?>" title="View Submitted Requirement" data-toggle="modal" ><button class="btn btn-info"><i class="fas fa-eye"></i></button></a>
                      </td>

                <!-- View Modal -->
                <div class="modal fade bd-example-modal-lg" data-backdrop="static" id="view<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="update_place" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document" style="color:  #333333;">
                    <div class="modal-content modal-lg">
                      <div class="modal-header modal-lg">
                        <h5 class="modal-title" id="exampleModalLabel"><h style="color: #0d6efd"><i class="fas fa-file-import"></i> Completed / <?php echo $row['title']; ?> </h><span><?php //echo $row['edited']; ?></span></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-header modal-lg">
                            <p class="modal-title" id="exampleModalLabel">
                            <h title="Date and Time Completed"><i style="color: #1a8cff;" class="fas fa-clock"></i> <?php echo $row['completed_date']; ?> </h></p> 
                        </div>
                      <form action="" method="POST" enctype="multipart/form-data"><!-- form start -->
                      <input type="text" class="form-control" name="id" value="<?php echo $id;?>" hidden>
                      <input type="text" name="task_code" value="<?php echo $task_code;?>" hidden>
                        <div class="modal-body modal-lg">
                            <!-- <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md"> -->
                                        <div class="form-group">
                                            <label>Submitted by: </label> <br>
                                            <b> <?php echo $row['stud_name_and_id']; ?> </b>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label>Course, Year & Section: </label> <br>
                                            <b> <?php echo $row['course']; ?> </b>
                                        </div>
                                        <hr>
                                        <!-- <div class="form-group">
                                            <label>Requirement: </label> <br>
                                            <b> <?php echo $row['title']; ?> </b>
                                        </div>
                                        <hr> -->
                                        <div class="form-group">
                                            <label>Instructions: </label> <br>
                                            <textarea style="background: ghostwhite;" rows="9" name="instructions" class="form-control" id="instructions" aria-describedby="" readonly required=""><?php echo $row['instructions'];?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <!-- may unique na logic yung sa pagviview ng signed na file sa hindi-->
                                        <div class="form-group">
                                            <label>Completed Work/File</label>: <?php //echo $row['edited_by_student'];?><br>
                                            <?php if($row['title'] == "Recommendation Letter") {?><b><a href="../admin/signed_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File"><?php echo $row['uploaded_file'];?></a></b> 
                                            <div class="form-group">
                                                <div class="embed-responsive embed-responsive-1by1">
                                                  <iframe class="embed-responsive-item" src="../admin/signed_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                                                </div>
                                            </div>
                                            <?php } else {?> <b><a href="../students/upload_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File"><?php echo $row['uploaded_file'];?></a></b>
                                            <div class="form-group">
                                                <div class="embed-responsive embed-responsive-1by1">
                                                  <iframe class="embed-responsive-item" src="../students/upload_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div>

                                        <!-- <div class="form-group">
                                            <div class="embed-responsive embed-responsive-1by1">
                                              <iframe class="embed-responsive-item" src="../admin/signed_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                                            </div>
                                        </div> -->

                                        <hr>
                                        <div class="form-group">
                                            <label>Status: </label> <br>
                                            <?php 
                                                if ($row['work_status'] == 'pending') {
                                                 echo "<div class='progress'>
                                                          <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' title='15% on progress'></div>
                                                        </div><b>PENDING 15%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' title='25% on progress' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>STILL PENDING 25%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending2') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'></div>
                                                            </div><b>STILL PENDING 50%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending3') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>STILL PENDING 75%</b>";
                                                }

                                                if ($row['work_status'] == 'completed') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'>100%</div>
                                                            </div><b>COMPLETED</b>";
                                                }
                                            ?>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label>My Remarks:</label> <br>
                                            <?php
                                                if ($row['remarks'] == 'waiting') {
                                                     echo "<span style='font-size: 15px; margin-left: 0px; color: gray;' class='badge badge-pill badge-warning'>WAITING</span>";
                                                }

                                                if ($row['remarks'] == 'Not Approved') {
                                                     echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-danger'>NOT APPROVED</span>";
                                                }

                                                if ($row['remarks'] == 'Approved') {
                                                     echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-success'>APPROVED</span>";
                                                }

                                            ?>
                                        </div>
                                        <hr>
                                        <!-- selecting and concatenating the date and time from tbl_students_work -->
                                        <?php 
                                            session_start();
                                            $task_id = $_SESSION['t_id_works11'];
                                            $sql1 = "SELECT Concat(date_submitted,' ',time_submitted) AS dateTTime1 FROM tbl_students_work where id='$task_id'";
                                            $query1 = $conn->query($sql1);
                                            while($row1 = $query1->fetch_assoc()){
                                                $_SESSION['datetime222'] = $row1['dateTTime1'];
                                            }
                                        ?>
                                        <!-- <div class="form-group">
                                            <label>Due Date :</label> <br>
                                            <b><?php
                                                echo $row['date_of_submission'];?></b>
                                        </div>
                                        <hr> -->
                                        <!-- <div class="form-group">
                                            <label>Turned In:</label> <br>
                                            <?php
                                            //detect the due dates
                                                date_default_timezone_set('Asia/Manila'); 
                                                $date = date('Y-m-d');
                                                $submission = $row['date_of_submission'];
                                                if($row['date_submitted_1'] > $submission){
                                                    echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-danger'>LATE</span>";
                                                }
                                                else{
                                                    echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-success'>ON-TIME</span>";;
                                                }
                                            ?> 
                                        </div>
                                        <hr> -->
                                        <!-- <div class="form-group">
                                            <i style="color: #1a8cff;" class="fas fa-clock"></i>
                                            <b title="DATE AND TIME SUBMITTED"> <?php $date_time_posted = $_SESSION['datetime222']; echo $date_time_posted; ?> </b>
                                            <br>
                                            <?php if ($row['edited_by_student']=="(edited)") {?>
                                            <b><span><i style="color: #1a8cff;" class="fas fa-user-edit"></i><?php echo $row['edited_by_student']; ?></span></b>
                                            <?php } else {
                                                echo "";
                                            }?>
                                        </div>
                                        <hr> -->
                                        <div class="form-group">
                                            <label>Comment/s:</label> <br>
                                            <textarea style=" background: ghostwhite;" readonly="" id="comments" name="comments" class="form-control" rows="5" placeholder=""><?php echo $row['student_comment']; ?></textarea>
                                        </div>
                                    <!-- </div>
                                    <div class="col-md"> -->
                                        <hr>
                                        <div class="form-group">
                                            <label>My Comments and Suggestions:</label> <br>
                                            <textarea readonly="" style="background: ghostwhite;" id="my_comments" name="comments" class="form-control" rows="5" placeholder=""><?php echo $row['comment']; ?></textarea>
                                        </div>
                                    <!-- </div>
                                </div>
                            </div> -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                            <!-- <button type="submit" name="submit" class="btn btn-primary">Submit <i class="fas fa-check-square"></i></button> -->
                        </div>
                      </form> <!-- end of form -->
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
            <?php $count1++; } ?> 
          </tbody>
        </table>
    </div>
    <?php } ?>



<?php } ?>

<!-- Page level plugins -->
<script src="vendor/datatables/jquery.dataTables.min.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script src="js/demo/datatables-demo.js"></script>




