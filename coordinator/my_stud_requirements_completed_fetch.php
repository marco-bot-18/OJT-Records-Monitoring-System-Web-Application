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
        $work_stats = "semi-pending";
        $stats = "not archived";
        $submitted = "yes";
        $count = 1;
        $my_fullname_ = $_SESSION['coordinator_fullname_session'];
        $sql = "SELECT * from tbl_students_work where name_of_teacher='$my_fullname_' and work_status='$work_stats' and submitted='$submitted' and status='$stats' ORDER BY id ASC";
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
                  <th hidden=""> TASK CODE</th>
                  <th hidden="">ID</th>
                  <th>Submitted by</th>
                  <th hidden>Course</th>
                  <th>Requirement</th>
                  <th>Submitted File</th>
                  <th hidden="">Due Date</th>
                  <th>Turned In</th>
                  <th>My Remarks</th>
                  <th>Status</th>
                  <th>Action</th>                      
                </tr>
                <?php } else { echo "No data available in table"; }?>
              </thead>
              <tbody>
                <?php
                    while($row = $query->fetch_assoc()){
                        $id = $row['id'];
                        $task_code = $row['task_code'];
                        $_SESSION['task_id_22'] = $row['id'];
                ?>
                <tr id="tra">
                   <td hidden=""> <?php echo $task_code;?> </td> 
                   <td hidden=""><?php 
                        $_SESSION['t_id_works11'] = $_SESSION['task_id_22'];
                        echo $_SESSION['t_id_works11'];
                    ?>  
                  </td>
                  <td width="20%"><?php echo $row['stud_name_and_id']; ?></td>
                  <td hidden><?php echo $row['course'];?> </td>
                  <td><?php echo $row['title'];?> </td>
                  <td width="25%"><b><a href="../students/upload_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File"><i class="fa fa-file"></i><?php echo $row['uploaded_file'];?></a> </b></td>
                  <td hidden=""><?php echo $row['date_of_submission'];?> </td>
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
                            echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-success'>ON-TIME</span>";;
                        }
                    ?> 
                    </td>
                    <td width="10%">
                    <?php 
                        if ($row['remarks'] == 'waiting') {
                             echo "<span style='font-size: 15px; margin-left: 0px; color: gray;' class='badge badge-pill badge-warning'>ON REVIEW</span>";
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
                                    </div><b>PENDING 25%</b>";
                        }

                        if ($row['work_status'] == 'semi-pending2') {
                             echo "<div class='progress'>
                                      <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'></div>
                                    </div><b>PENDING 50%</b>";
                        }

                        if ($row['work_status'] == 'semi-pending3') {
                             echo "<div class='progress'>
                                      <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                    </div><b>PENDING 75%</b>";
                        }

                        if ($row['work_status'] == 'completed') {
                             echo "<div class='progress'>
                                      <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'></div>
                                    </div><b>COMPLETED 100%</b>";
                        }
                    ?>
                  </td>
                  <td width="10%">
                      <a href="#view<?php echo $id;?>" title="View Submitted Requirement" data-toggle="modal" ><button class="btn btn-info"><i class="fas fa-check-square"></i></button></a>
                      <?php if($row['remarks']=="Approved"){ ?>
                      <a href="#forward<?php echo $id;?>" title="Forward to Program Head" data-toggle="modal" ><button class="btn btn-primary"><i class="fas fa-share-square"></i></button></a>
                       <?php } ?>
                      <!-- <a href="" class='del-btn'><button class="btn btn-danger" title="Delete"><i class="fas fa-trash-alt"></i></button></a> -->
                  </td>

                    <!-- View Modal -->
                    <div class="modal fade bd-example-modal-lg" data-backdrop="static" id="view<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="update_place" aria-hidden="true">
                      <div class="modal-dialog modal-lg" role="document" style="color:  #333333;">
                        <div class="modal-content modal-lg">
                          <div class="modal-header modal-lg">
                            <h5 class="modal-title" id="exampleModalLabel"><h style="color: #0d6efd"><i class="fas fa-file-alt"></i> <?php echo $row['title']; ?> </h><span><?php //echo $row['edited']; ?></span></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-header modal-lg">
                                <p class="modal-title" id="exampleModalLabel">
                                <h title="Date and Time Submitted"><i style="color: #1a8cff;" class="fas fa-clock"></i> <?php echo $row['date_submitted']. " at " . $row['time_submitted']; ?> <?php echo $row['edited_by_student'];?></h></p> 
                            </div>
                          <form action="my_stud_requirements_completed_update.php" method="POST" enctype="multipart/form-data"><!-- form start -->
                          <input type="text" class="form-control" name="id" value="<?php echo $id;?>" hidden>
                          <input type="text" name="task_code" value="<?php echo $task_code;?>" hidden>
                            <div class="modal-body modal-lg">
                                <!-- <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md"> -->
                                            <div class="form-group">
                                                <label>Submitted by: </label> <br>
                                                <b> <?php echo $row['stud_name_and_id']; ?> </b>
                                                <input type="text" name="stud_fullname" value="<?php echo $row['stud_name_and_id']; ?>" hidden>
                                            </div> 
                                            <hr>
                                            <div class="form-group">
                                                <label>Course, Year & Section: </label> <br>
                                                <b> <?php echo $row['course']; ?> </b>
                                            </div>
                                            <div class="form-group">
                                                <!-- <label>Requirement: </label> <br>
                                                <b> <?php echo $row['title']; ?> </b> -->
                                                <input type="text" name="requirement" value="<?php echo $row['title']; ?>" hidden>
                                            </div>
                                            <hr>
                                            <div class="form-group">
                                                <label>Instructions: </label> <br>
                                                <textarea style="background: ghostwhite;" rows="10" name="instructions" class="form-control" id="instructions" aria-describedby="" readonly required=""><?php echo $row['instructions'];?></textarea>
                                            </div>
                                        <!-- </div>
                                        <div class="col-md"> -->
                                            <div class="form-group">
                                                <label>Submitted File</label>: <?php //echo $row['edited_by_student'];?><br>
                                                <b><a href="../students/upload_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File">
                                                <i class="fa fa-file"></i><?php echo $row['uploaded_file'];?></a>
                                                </b>
                                            </div>
                                            <div class="form-group">
                                                <div class="embed-responsive embed-responsive-1by1">
                                                  <iframe class="embed-responsive-item" src="../students/upload_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                                                </div>
                                            </div>
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
                                                            </div><b>PENDING 25%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending2') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'></div>
                                                            </div><b>PENDING 50%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending3') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>PENDING 75%</b>";
                                                }

                                                if ($row['work_status'] == 'completed') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>COMPLETED 100%</b>";
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
                                            <div class="form-group">
                                                <label>Due Date:</label> <br>
                                                <b><?php
                                                    echo $row['date_of_submission'];?></b>
                                            </div>
                                            <hr>
                                            <div class="form-group">
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
                                            <hr>
                                            <!-- <div class="form-group">
                                                <i style="color: #1a8cff;" class="fas fa-clock"></i>
                                                <b title="DATE AND TIME SUBMITTED"> <?php $date_time_posted = $_SESSION['datetime222']; echo $date_time_posted; ?> </b><br>
                                                <?php if ($row['edited_by_student']=="(edited)") {?>
                                                <b><span><i style="color: #1a8cff;" class="fas fa-user-edit"></i><?php echo $row['edited_by_student']; ?></span></b>
                                                <?php } else {
                                                    echo "";
                                                }?>
                                            </div>
                                            <hr> -->
                                            <div class="form-group">
                                                <label>Comment/s:</label> <br>
                                                <textarea style="background: ghostwhite;" readonly="" name="comments" class="form-control" id="comments" rows="5"><?php echo $row['student_comment']; ?></textarea>
                                            </div>
                                        <!-- </div> -->
                                        <!-- <div class="col-md"> -->
                                            <div class="form-group">
                                                <label>My Remarks: </label> <br>
                                                <select style="background: white;" name="remarks" id="remarks" class="form-control">
                                                    <?php
                                                        if($row['remarks']=="Approved"){
                                                            echo "<option name='approved'>Approved</option>";
                                                            echo "<option name='not approved'>Not Approved</option>";
                                                        }

                                                        if($row['remarks']=="Not Approved"){
                                                             echo "<option name='not approved'>Not Approved</option>";
                                                            echo "<option name='approved'>Approved</option>";
                                                        }
                                                        if($row['remarks']=="waiting"){
                                                            echo "<option name='approved'>Approved</option>";
                                                            echo "<option name='not approved'>Not Approved</option>";
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <hr>
                                            <div class="form-group">
                                                <label>My Comments and Suggestions:</label> <br>
                                                <textarea style="background: white;" name="comments" class="form-control" rows="5" id="my_comments" placeholder="Write Your Comments and Suggestions Here (Optional)"><?php echo $row['comment']; ?></textarea>
                                            </div>
                                        <!-- </div>
                                    </div>
                                </div> -->
                            </div>
                            <div class="modal-footer">
                                <?php if($row['remarks']=="Approved"){ ?>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                                <button type="submit" name="submit" class="btn btn-primary">Re-Submit
                                <i class="fas fa-check-square"></i></button> 
                                <button type="submit" name="set_as_completed" class="btn btn-success">Set As Completed <i class="fas fa-check-square"></i></button>
                                <?php } else {?>
                                 <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                                <button type="submit" name="submit" class="btn btn-primary">Submit
                                <i class="fas fa-check-square"></i></button>
                                <?php } ?>
                            </div>
                          </form> <!-- end of form -->
                        </div>
                      </div>
                    </div>

                    <!-- Forward Modal -->
                    <div class="modal fade bd-example-modal-lg" data-backdrop="static" id="forward<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="update_place" aria-hidden="true">
                      <div class="modal-dialog modal-lg" role="document" style="color:  #333333;">
                        <div class="modal-content modal-lg">
                          <div class="modal-header modal-lg">
                            <h5 class="modal-title" id="exampleModalLabel"><h style="color: #0d6efd"><i class="fas fa-share-square"></i> Forward To Program Head / <?php echo $row['title']; ?></h><span><?php //echo $row['edited']; ?></span></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-header modal-lg">
                                <p class="modal-title" id="exampleModalLabel">
                                <h title="Date and Time Submitted"><i style="color: #1a8cff;" class="fas fa-clock"></i> <?php echo $row['date_submitted']. " at " . $row['time_submitted']; ?> <?php echo $row['edited_by_student'];?></h></p> 
                            </div>
                          <form action="my_stud_requirements_completed_update.php" method="POST" enctype="multipart/form-data"><!-- form start -->
                          <input type="text" class="form-control" name="id" value="<?php echo $id;?>" hidden>
                          <!-- task code uniq id -->
                          <input type="text" name="task_code" value="<?php echo $task_code;?>" hidden>
                            <div class="modal-body modal-lg">
                                <!-- <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md"> -->
                                            <div class="form-group">
                                                <label>Submitted by: </label> <br>
                                                <b><?php echo $row['stud_name_and_id']; ?> </b>
                                                <input type="text" hidden="" name="stud_fullname" value="<?php echo $row['stud_name_and_id']; ?>">
                                            </div>
                                            <hr>
                                            <div class="form-group">
                                               <!--  <label>Course, Year & Section : </label> <br>
                                                <b> <?php echo $row['course']; ?> </b> -->
                                                <input type="text" hidden="" name="course" value="<?php echo $row['course']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <!-- <label>Requirement : </label> <br>
                                                <b> <?php echo $row['title']; ?> </b> -->
                                                <input type="text" hidden="" name="requirement" value="<?php echo $row['title']; ?>">
                                            </div>
                                            <div class="form-group">
                                               <!--  <label>Instructions : </label> <br> -->
                                                <textarea hidden="" style="background: ghostwhite;" rows="10" name="instructions" class="form-control" id="instructions" aria-describedby="" readonly required=""><?php echo $row['instructions'];?></textarea>
                                            </div>
                                        <!-- </div>
                                        <div class="col-md"> -->
                                            <div class="form-group">
                                                <label>Submitted File</label> : <?php //echo $row['edited_by_student'];?><br>
                                                <b><a href="../students/upload_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File">
                                                 <i class="fa fa-file"></i><?php echo $row['uploaded_file'];?></a>
                                                </b>
                                            </div>
                                            <div class="form-group">
                                                <div class="embed-responsive embed-responsive-1by1">
                                                  <iframe class="embed-responsive-item" src="../students/upload_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                                                </div>
                                            </div>
                                            <hr>
                                            <!-- <div class="form-group">
                                                <label>Status : </label> <br>
                                                <input hidden type="text" name="status" value="<?php echo $row['work_status']; ?>">
                                                <?php 
                                                if ($row['work_status'] == 'pending') {
                                                 echo "<div class='progress'>
                                                          <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' title='15% on progress'></div>
                                                        </div><b>PENDING 15%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' title='25% on progress' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>PENDING 25%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending2') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'></div>
                                                            </div><b>PENDING 50%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending3') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>PENDING 75%</b>";
                                                }

                                                if ($row['work_status'] == 'completed') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>COMPLETED 100%</b>";
                                                }
                                                ?>
                                            </div>
                                            <hr> -->
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
                                            </div> -->
                                            
                                            <!-- <div class="form-group">
                                                <label>Turned In:</label> <br>
                                                <?php
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
                                            <hr>
                                            <div class="form-group">
                                                <i style="color: #1a8cff;" class="fas fa-clock"></i>
                                                <b title="DATE AND TIME SUBMITTED"> <?php $date_time_posted = $_SESSION['datetime222']; echo $date_time_posted; ?> </b>
                                            </div> -->
                                        <!-- </div>
                                       
                                    </div>
                                </div> -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                                <button type="submit" name="forward" class="btn btn-primary">Forward <i class="fas fa-share-square"></i></button>
                            </div>
                          </form> <!-- end of form -->
                        </div>
                      </div>
                    </div>

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
        $count1 = 1;
        $title = "Recommendation Letter";
        $myfullname_ = $_SESSION['coordinator_fullname_session'];
        $work_stats = "semi-pending";
        $stats = "not archived";
        $submitted = "yes";
        $sql = "SELECT * from tbl_students_work where title='$title' and name_of_teacher='$myfullname_' and work_status='$work_stats' and submitted='$submitted' and status='$stats'";
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
                  <th hidden=""> TASK CODE</th>
                  <th hidden="">ID</th>
                  <th>Submitted by</th>
                  <th hidden>Course</th>
                  <th>Requirement</th>
                  <th>Submitted File</th>
                  <th hidden="">Due Date</th>
                  <th>Turned In</th>
                  <th>My Remarks</th>
                  <th>Status</th>
                  <th>Action</th>                      
                </tr>
                <?php } else { echo "No data available in table"; }?>
              </thead>
              <tbody>
                <?php
                    while($row = $query->fetch_assoc()){
                        $id = $row['id'];
                        $task_code = $row['task_code'];
                        $_SESSION['task_id_22'] = $row['id'];
                ?>
                <tr id="tra">
                   <td hidden=""> <?php echo $task_code;?> </td> 
                   <td hidden=""><?php 
                        $_SESSION['t_id_works11'] = $_SESSION['task_id_22'];
                        echo $_SESSION['t_id_works11'];
                    ?>  
                  </td>
                  <td width="20%"><?php echo $row['stud_name_and_id']; ?></td>
                  <td hidden><?php echo $row['course'];?> </td>
                  <td><?php echo $row['title'];?> </td>
                  <td width="25%"><b><a href="../students/upload_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File"><i class="fa fa-file"></i><?php echo $row['uploaded_file'];?></a> </b></td>
                  <td hidden=""><?php echo $row['date_of_submission'];?> </td>
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
                            echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-success'>ON-TIME</span>";;
                        }
                    ?> 
                    </td>
                    <td width="10%">
                    <?php 
                        if ($row['remarks'] == 'waiting') {
                             echo "<span style='font-size: 15px; margin-left: 0px; color: gray;' class='badge badge-pill badge-warning'>ON REVIEW</span>";
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
                                      <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' title='25% on progress' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'>25%</div>
                                    </div><b>PENDING</b>";
                        }

                        if ($row['work_status'] == 'semi-pending2') {
                             echo "<div class='progress'>
                                      <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'></div>
                                    </div><b>PENDING 50%</b>";
                        }

                        if ($row['work_status'] == 'semi-pending3') {
                             echo "<div class='progress'>
                                      <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                    </div><b>PENDING 75%</b>";
                        }

                        if ($row['work_status'] == 'completed') {
                             echo "<div class='progress'>
                                      <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'></div>
                                    </div><b>COMPLETED 100%</b>";
                        }
                    ?>
                  </td>
                  <td width="10%">
                      <a href="#view<?php echo $id;?>" title="View Submitted Requirement" data-toggle="modal" ><button class="btn btn-info"><i class="fas fa-check-square"></i></button></a>
                      <?php if($row['remarks']=="Approved"){ ?>
                      <a href="#forward<?php echo $id;?>" title="Forward to Program Head" data-toggle="modal" ><button class="btn btn-primary"><i class="fas fa-share-square"></i></button></a>
                       <?php } ?>
                      <!-- <a href="" class='del-btn'><button class="btn btn-danger" title="Delete"><i class="fas fa-trash-alt"></i></button></a> -->
                  </td>

                    <!-- View Modal -->
                    <div class="modal fade bd-example-modal-lg" data-backdrop="static" id="view<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="update_place" aria-hidden="true">
                      <div class="modal-dialog modal-lg" role="document" style="color:  #333333;">
                        <div class="modal-content modal-lg">
                          <div class="modal-header modal-lg">
                            <h5 class="modal-title" id="exampleModalLabel"><h style="color: #0d6efd"><i class="fas fa-file-alt"></i> <?php echo $row['title']; ?> </h><span><?php //echo $row['edited']; ?></span></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-header modal-lg">
                                <p class="modal-title" id="exampleModalLabel">
                                <h title="Date and Time Submitted"><i style="color: #1a8cff;" class="fas fa-clock"></i> <?php echo $row['date_submitted']. " at " . $row['time_submitted']; ?> <?php echo $row['edited_by_student'];?></h></p> 
                            </div>
                          <form action="my_stud_requirements_completed_update.php" method="POST" enctype="multipart/form-data"><!-- form start -->
                          <input type="text" class="form-control" name="id" value="<?php echo $id;?>" hidden>
                          <input type="text" name="task_code" value="<?php echo $task_code;?>" hidden>
                            <div class="modal-body modal-lg">
                                <!-- <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md"> -->
                                            <div class="form-group">
                                                <label>Submitted by: </label> <br>
                                                <b> <?php echo $row['stud_name_and_id']; ?> </b>
                                                <input type="text" name="stud_fullname" value="<?php echo $row['stud_name_and_id']; ?>" hidden>
                                            </div> 
                                            <hr>
                                            <div class="form-group">
                                                <label>Course, Year & Section: </label> <br>
                                                <b> <?php echo $row['course']; ?> </b>
                                            </div>
                                            <div class="form-group">
                                                <!-- <label>Requirement: </label> <br>
                                                <b> <?php echo $row['title']; ?> </b> -->
                                                <input type="text" name="requirement" value="<?php echo $row['title']; ?>" hidden>
                                            </div>
                                            <hr>
                                            <div class="form-group">
                                                <label>Instructions: </label> <br>
                                                <textarea style="background: ghostwhite;" rows="10" name="instructions" class="form-control" id="instructions" aria-describedby="" readonly required=""><?php echo $row['instructions'];?></textarea>
                                            </div>
                                        <!-- </div>
                                        <div class="col-md"> -->
                                            <div class="form-group">
                                                <label>Submitted File</label>: <?php //echo $row['edited_by_student'];?><br>
                                                <b><a href="../students/upload_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File">
                                                <i class="fa fa-file"></i><?php echo $row['uploaded_file'];?></a>
                                                </b>
                                            </div>
                                            <div class="form-group">
                                                <div class="embed-responsive embed-responsive-1by1">
                                                  <iframe class="embed-responsive-item" src="../students/upload_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                                                </div>
                                            </div>
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
                                                            </div><b>PENDING 25%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending2') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'></div>
                                                            </div><b>PENDING 50%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending3') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>PENDING 75%</b>";
                                                }

                                                if ($row['work_status'] == 'completed') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>COMPLETED 100%</b>";
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
                                            <div class="form-group">
                                                <label>Due Date:</label> <br>
                                                <b><?php
                                                    echo $row['date_of_submission'];?></b>
                                            </div>
                                            <hr>
                                            <div class="form-group">
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
                                            <hr>
                                            <!-- <div class="form-group">
                                                <i style="color: #1a8cff;" class="fas fa-clock"></i>
                                                <b title="DATE AND TIME SUBMITTED"> <?php $date_time_posted = $_SESSION['datetime222']; echo $date_time_posted; ?> </b><br>
                                                <?php if ($row['edited_by_student']=="(edited)") {?>
                                                <b><span><i style="color: #1a8cff;" class="fas fa-user-edit"></i><?php echo $row['edited_by_student']; ?></span></b>
                                                <?php } else {
                                                    echo "";
                                                }?>
                                            </div>
                                            <hr> -->
                                            <div class="form-group">
                                                <label>Comment/s:</label> <br>
                                                <textarea style="background: ghostwhite;" readonly="" name="comments" class="form-control" id="comments" rows="5"><?php echo $row['student_comment']; ?></textarea>
                                            </div>
                                        <!-- </div> -->
                                        <!-- <div class="col-md"> -->
                                            <div class="form-group">
                                                <label>My Remarks: </label> <br>
                                                <select style="background: white;" name="remarks" id="remarks" class="form-control">
                                                    <?php
                                                        if($row['remarks']=="Approved"){
                                                            echo "<option name='approved'>Approved</option>";
                                                            echo "<option name='not approved'>Not Approved</option>";
                                                        }

                                                        if($row['remarks']=="Not Approved"){
                                                             echo "<option name='not approved'>Not Approved</option>";
                                                            echo "<option name='approved'>Approved</option>";
                                                        }
                                                        if($row['remarks']=="waiting"){
                                                            echo "<option name='approved'>Approved</option>";
                                                            echo "<option name='not approved'>Not Approved</option>";
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <hr>
                                            <div class="form-group">
                                                <label>My Comments and Suggestions:</label> <br>
                                                <textarea style="background: white;" name="comments" class="form-control" rows="5" id="my_comments" placeholder="Write Your Comments and Suggestions Here (Optional)"><?php echo $row['comment']; ?></textarea>
                                            </div>
                                        <!-- </div>
                                    </div>
                                </div> -->
                            </div>
                            <div class="modal-footer">
                                <?php if($row['remarks']=="Approved"){ ?>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                                <button type="submit" name="submit" class="btn btn-primary">Re-Submit
                                <i class="fas fa-check-square"></i></button> 
                                <button type="submit" name="set_as_completed" class="btn btn-success">Set As Completed <i class="fas fa-check-square"></i></button>
                                <?php } else {?>
                                 <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                                <button type="submit" name="submit" class="btn btn-primary">Submit
                                <i class="fas fa-check-square"></i></button>
                                <?php } ?>
                            </div>
                          </form> <!-- end of form -->
                        </div>
                      </div>
                    </div>

                    <!-- Forward Modal -->
                    <div class="modal fade bd-example-modal-lg" data-backdrop="static" id="forward<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="update_place" aria-hidden="true">
                      <div class="modal-dialog modal-lg" role="document" style="color:  #333333;">
                        <div class="modal-content modal-lg">
                          <div class="modal-header modal-lg">
                            <h5 class="modal-title" id="exampleModalLabel"><h style="color: #0d6efd"><i class="fas fa-share-square"></i> Forward To Program Head / <?php echo $row['title']; ?></h><span><?php //echo $row['edited']; ?></span></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-header modal-lg">
                                <p class="modal-title" id="exampleModalLabel">
                                <h title="Date and Time Submitted"><i style="color: #1a8cff;" class="fas fa-clock"></i> <?php echo $row['date_submitted']. " at " . $row['time_submitted']; ?> <?php echo $row['edited_by_student'];?></h></p> 
                            </div>
                          <form action="my_stud_requirements_completed_update.php" method="POST" enctype="multipart/form-data"><!-- form start -->
                          <input type="text" class="form-control" name="id" value="<?php echo $id;?>" hidden>
                          <!-- task code uniq id -->
                          <input type="text" name="task_code" value="<?php echo $task_code;?>" hidden>
                            <div class="modal-body modal-lg">
                                <!-- <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md"> -->
                                            <div class="form-group">
                                                <label>Submitted by: </label> <br>
                                                <b><?php echo $row['stud_name_and_id']; ?> </b>
                                                <input type="text" hidden="" name="stud_fullname" value="<?php echo $row['stud_name_and_id']; ?>">
                                            </div>
                                            <hr>
                                            <div class="form-group">
                                               <!--  <label>Course, Year & Section : </label> <br>
                                                <b> <?php echo $row['course']; ?> </b> -->
                                                <input type="text" hidden="" name="course" value="<?php echo $row['course']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <!-- <label>Requirement : </label> <br>
                                                <b> <?php echo $row['title']; ?> </b> -->
                                                <input type="text" hidden="" name="requirement" value="<?php echo $row['title']; ?>">
                                            </div>
                                            <div class="form-group">
                                               <!--  <label>Instructions : </label> <br> -->
                                                <textarea hidden="" style="background: ghostwhite;" rows="10" name="instructions" class="form-control" id="instructions" aria-describedby="" readonly required=""><?php echo $row['instructions'];?></textarea>
                                            </div>
                                        <!-- </div>
                                        <div class="col-md"> -->
                                            <div class="form-group">
                                                <label>Submitted File</label> : <?php //echo $row['edited_by_student'];?><br>
                                                <b><a href="../students/upload_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File">
                                                 <i class="fa fa-file"></i><?php echo $row['uploaded_file'];?></a>
                                                </b>
                                            </div>
                                            <div class="form-group">
                                                <div class="embed-responsive embed-responsive-1by1">
                                                  <iframe class="embed-responsive-item" src="../students/upload_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                                                </div>
                                            </div>
                                            <hr>
                                            <!-- <div class="form-group">
                                                <label>Status : </label> <br>
                                                <input hidden type="text" name="status" value="<?php echo $row['work_status']; ?>">
                                                <?php 
                                                if ($row['work_status'] == 'pending') {
                                                 echo "<div class='progress'>
                                                          <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' title='15% on progress'></div>
                                                        </div><b>PENDING 15%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' title='25% on progress' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>PENDING 25%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending2') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'></div>
                                                            </div><b>PENDING 50%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending3') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>PENDING 75%</b>";
                                                }

                                                if ($row['work_status'] == 'completed') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>COMPLETED 100%</b>";
                                                }
                                                ?>
                                            </div>
                                            <hr> -->
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
                                            </div> -->
                                            
                                            <!-- <div class="form-group">
                                                <label>Turned In:</label> <br>
                                                <?php
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
                                            <hr>
                                            <div class="form-group">
                                                <i style="color: #1a8cff;" class="fas fa-clock"></i>
                                                <b title="DATE AND TIME SUBMITTED"> <?php $date_time_posted = $_SESSION['datetime222']; echo $date_time_posted; ?> </b>
                                            </div> -->
                                        <!-- </div>
                                       
                                    </div>
                                </div> -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                                <button type="submit" name="forward" class="btn btn-primary">Forward <i class="fas fa-share-square"></i></button>
                            </div>
                          </form> <!-- end of form -->
                        </div>
                      </div>
                    </div>

                </div> 
            <!-- end tag modal -->
            </tr>
            <?php $count1++; } ?> 
          </tbody>
        </table>
    </div>
    
    <?php } 

    else if($_POST['request'] == "Memorandum of Agreement") {
        $work_stats = "semi-pending";
        $stats = "not archived";
        $submitted = "yes";
        $count = 1;
        $my_fullname_ = $_SESSION['coordinator_fullname_session'];
        $sql = "SELECT * from tbl_students_work where requirement='$request', name_of_teacher='$my_fullname_' and work_status='$work_stats' and submitted='$submitted' and status='$stats' ORDER BY id ASC";
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
                  <th hidden=""> TASK CODE</th>
                  <th hidden="">ID</th>
                  <th>Submitted by</th>
                  <th hidden>Course</th>
                  <th>Requirement</th>
                  <th>Submitted File</th>
                  <th hidden="">Due Date</th>
                  <th>Turned In</th>
                  <th>My Remarks</th>
                  <th>Status</th>
                  <th>Action</th>                      
                </tr>
                <?php } else { echo "No data available in table"; }?>
              </thead>
              <tbody>
                <?php
                    while($row = $query->fetch_assoc()){
                        $id = $row['id'];
                        $task_code = $row['task_code'];
                        $_SESSION['task_id_22'] = $row['id'];
                ?>
                <tr id="tra">
                   <td hidden=""> <?php echo $task_code;?> </td> 
                   <td hidden=""><?php 
                        $_SESSION['t_id_works11'] = $_SESSION['task_id_22'];
                        echo $_SESSION['t_id_works11'];
                    ?>  
                  </td>
                  <td width="20%"><?php echo $row['stud_name_and_id']; ?></td>
                  <td hidden><?php echo $row['course'];?> </td>
                  <td><?php echo $row['title'];?> </td>
                  <td width="25%"><b><a href="../students/upload_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File"><i class="fa fa-file"></i><?php echo $row['uploaded_file'];?></a> </b></td>
                  <td hidden=""><?php echo $row['date_of_submission'];?> </td>
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
                            echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-success'>ON-TIME</span>";;
                        }
                    ?> 
                    </td>
                    <td width="10%">
                    <?php 
                        if ($row['remarks'] == 'waiting') {
                             echo "<span style='font-size: 15px; margin-left: 0px; color: gray;' class='badge badge-pill badge-warning'>ON REVIEW</span>";
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
                                    </div><b>PENDING 25%</b>";
                        }

                        if ($row['work_status'] == 'semi-pending2') {
                             echo "<div class='progress'>
                                      <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'></div>
                                    </div><b>PENDING 50%</b>";
                        }

                        if ($row['work_status'] == 'semi-pending3') {
                             echo "<div class='progress'>
                                      <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                    </div><b>PENDING 75%</b>";
                        }

                        if ($row['work_status'] == 'completed') {
                             echo "<div class='progress'>
                                      <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'></div>
                                    </div><b>COMPLETED 100%</b>";
                        }
                    ?>
                  </td>
                  <td width="10%">
                      <a href="#view<?php echo $id;?>" title="View Submitted Requirement" data-toggle="modal" ><button class="btn btn-info"><i class="fas fa-check-square"></i></button></a>
                      <?php if($row['remarks']=="Approved"){ ?>
                      <a href="#forward<?php echo $id;?>" title="Forward to Program Head" data-toggle="modal" ><button class="btn btn-primary"><i class="fas fa-share-square"></i></button></a>
                       <?php } ?>
                      <!-- <a href="" class='del-btn'><button class="btn btn-danger" title="Delete"><i class="fas fa-trash-alt"></i></button></a> -->
                  </td>

                    <!-- View Modal -->
                    <div class="modal fade bd-example-modal-lg" data-backdrop="static" id="view<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="update_place" aria-hidden="true">
                      <div class="modal-dialog modal-lg" role="document" style="color:  #333333;">
                        <div class="modal-content modal-lg">
                          <div class="modal-header modal-lg">
                            <h5 class="modal-title" id="exampleModalLabel"><h style="color: #0d6efd"><i class="fas fa-file-alt"></i> <?php echo $row['title']; ?> </h><span><?php //echo $row['edited']; ?></span></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-header modal-lg">
                                <p class="modal-title" id="exampleModalLabel">
                                <h title="Date and Time Submitted"><i style="color: #1a8cff;" class="fas fa-clock"></i> <?php echo $row['date_submitted']. " at " . $row['time_submitted']; ?> <?php echo $row['edited_by_student'];?></h></p> 
                            </div>
                          <form action="my_stud_requirements_completed_update.php" method="POST" enctype="multipart/form-data"><!-- form start -->
                          <input type="text" class="form-control" name="id" value="<?php echo $id;?>" hidden>
                          <input type="text" name="task_code" value="<?php echo $task_code;?>" hidden>
                            <div class="modal-body modal-lg">
                                <!-- <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md"> -->
                                            <div class="form-group">
                                                <label>Submitted by: </label> <br>
                                                <b> <?php echo $row['stud_name_and_id']; ?> </b>
                                                <input type="text" name="stud_fullname" value="<?php echo $row['stud_name_and_id']; ?>" hidden>
                                            </div> 
                                            <hr>
                                            <div class="form-group">
                                                <label>Course, Year & Section: </label> <br>
                                                <b> <?php echo $row['course']; ?> </b>
                                            </div>
                                            <div class="form-group">
                                                <!-- <label>Requirement: </label> <br>
                                                <b> <?php echo $row['title']; ?> </b> -->
                                                <input type="text" name="requirement" value="<?php echo $row['title']; ?>" hidden>
                                            </div>
                                            <hr>
                                            <div class="form-group">
                                                <label>Instructions: </label> <br>
                                                <textarea style="background: ghostwhite;" rows="10" name="instructions" class="form-control" id="instructions" aria-describedby="" readonly required=""><?php echo $row['instructions'];?></textarea>
                                            </div>
                                        <!-- </div>
                                        <div class="col-md"> -->
                                            <div class="form-group">
                                                <label>Submitted File</label>: <?php //echo $row['edited_by_student'];?><br>
                                                <b><a href="../students/upload_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File">
                                                <i class="fa fa-file"></i><?php echo $row['uploaded_file'];?></a>
                                                </b>
                                            </div>
                                            <div class="form-group">
                                                <div class="embed-responsive embed-responsive-1by1">
                                                  <iframe class="embed-responsive-item" src="../students/upload_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                                                </div>
                                            </div>
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
                                                            </div><b>PENDING 25%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending2') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'></div>
                                                            </div><b>PENDING 50%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending3') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>PENDING 75%</b>";
                                                }

                                                if ($row['work_status'] == 'completed') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>COMPLETED 100%</b>";
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
                                            <div class="form-group">
                                                <label>Due Date:</label> <br>
                                                <b><?php
                                                    echo $row['date_of_submission'];?></b>
                                            </div>
                                            <hr>
                                            <div class="form-group">
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
                                            <hr>
                                            <!-- <div class="form-group">
                                                <i style="color: #1a8cff;" class="fas fa-clock"></i>
                                                <b title="DATE AND TIME SUBMITTED"> <?php $date_time_posted = $_SESSION['datetime222']; echo $date_time_posted; ?> </b><br>
                                                <?php if ($row['edited_by_student']=="(edited)") {?>
                                                <b><span><i style="color: #1a8cff;" class="fas fa-user-edit"></i><?php echo $row['edited_by_student']; ?></span></b>
                                                <?php } else {
                                                    echo "";
                                                }?>
                                            </div>
                                            <hr> -->
                                            <div class="form-group">
                                                <label>Comment/s:</label> <br>
                                                <textarea style="background: ghostwhite;" readonly="" name="comments" class="form-control" id="comments" rows="5"><?php echo $row['student_comment']; ?></textarea>
                                            </div>
                                        <!-- </div> -->
                                        <!-- <div class="col-md"> -->
                                            <div class="form-group">
                                                <label>My Remarks: </label> <br>
                                                <select style="background: white;" name="remarks" id="remarks" class="form-control">
                                                    <?php
                                                        if($row['remarks']=="Approved"){
                                                            echo "<option name='approved'>Approved</option>";
                                                            echo "<option name='not approved'>Not Approved</option>";
                                                        }

                                                        if($row['remarks']=="Not Approved"){
                                                             echo "<option name='not approved'>Not Approved</option>";
                                                            echo "<option name='approved'>Approved</option>";
                                                        }
                                                        if($row['remarks']=="waiting"){
                                                            echo "<option name='approved'>Approved</option>";
                                                            echo "<option name='not approved'>Not Approved</option>";
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <hr>
                                            <div class="form-group">
                                                <label>My Comments and Suggestions:</label> <br>
                                                <textarea style="background: white;" name="comments" class="form-control" rows="5" id="my_comments" placeholder="Write Your Comments and Suggestions Here (Optional)"><?php echo $row['comment']; ?></textarea>
                                            </div>
                                        <!-- </div>
                                    </div>
                                </div> -->
                            </div>
                            <div class="modal-footer">
                                <?php if($row['remarks']=="Approved"){ ?>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                                <button type="submit" name="submit" class="btn btn-primary">Re-Submit
                                <i class="fas fa-check-square"></i></button> 
                                <button type="submit" name="set_as_completed" class="btn btn-success">Set As Completed <i class="fas fa-check-square"></i></button>
                                <?php } else {?>
                                 <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                                <button type="submit" name="submit" class="btn btn-primary">Submit
                                <i class="fas fa-check-square"></i></button>
                                <?php } ?>
                            </div>
                          </form> <!-- end of form -->
                        </div>
                      </div>
                    </div>

                    <!-- Forward Modal -->
                    <div class="modal fade bd-example-modal-lg" data-backdrop="static" id="forward<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="update_place" aria-hidden="true">
                      <div class="modal-dialog modal-lg" role="document" style="color:  #333333;">
                        <div class="modal-content modal-lg">
                          <div class="modal-header modal-lg">
                            <h5 class="modal-title" id="exampleModalLabel"><h style="color: #0d6efd"><i class="fas fa-share-square"></i> Forward To Program Head / <?php echo $row['title']; ?></h><span><?php //echo $row['edited']; ?></span></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-header modal-lg">
                                <p class="modal-title" id="exampleModalLabel">
                                <h title="Date and Time Submitted"><i style="color: #1a8cff;" class="fas fa-clock"></i> <?php echo $row['date_submitted']. " at " . $row['time_submitted']; ?> <?php echo $row['edited_by_student'];?></h></p> 
                            </div>
                          <form action="my_stud_requirements_completed_update.php" method="POST" enctype="multipart/form-data"><!-- form start -->
                          <input type="text" class="form-control" name="id" value="<?php echo $id;?>" hidden>
                          <!-- task code uniq id -->
                          <input type="text" name="task_code" value="<?php echo $task_code;?>" hidden>
                            <div class="modal-body modal-lg">
                                <!-- <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md"> -->
                                            <div class="form-group">
                                                <label>Submitted by: </label> <br>
                                                <b><?php echo $row['stud_name_and_id']; ?> </b>
                                                <input type="text" hidden="" name="stud_fullname" value="<?php echo $row['stud_name_and_id']; ?>">
                                            </div>
                                            <hr>
                                            <div class="form-group">
                                               <!--  <label>Course, Year & Section : </label> <br>
                                                <b> <?php echo $row['course']; ?> </b> -->
                                                <input type="text" hidden="" name="course" value="<?php echo $row['course']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <!-- <label>Requirement : </label> <br>
                                                <b> <?php echo $row['title']; ?> </b> -->
                                                <input type="text" hidden="" name="requirement" value="<?php echo $row['title']; ?>">
                                            </div>
                                            <div class="form-group">
                                               <!--  <label>Instructions : </label> <br> -->
                                                <textarea hidden="" style="background: ghostwhite;" rows="10" name="instructions" class="form-control" id="instructions" aria-describedby="" readonly required=""><?php echo $row['instructions'];?></textarea>
                                            </div>
                                        <!-- </div>
                                        <div class="col-md"> -->
                                            <div class="form-group">
                                                <label>Submitted File</label> : <?php //echo $row['edited_by_student'];?><br>
                                                <b><a href="../students/upload_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File">
                                                 <i class="fa fa-file"></i><?php echo $row['uploaded_file'];?></a>
                                                </b>
                                            </div>
                                            <div class="form-group">
                                                <div class="embed-responsive embed-responsive-1by1">
                                                  <iframe class="embed-responsive-item" src="../students/upload_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                                                </div>
                                            </div>
                                            <hr>
                                            <!-- <div class="form-group">
                                                <label>Status : </label> <br>
                                                <input hidden type="text" name="status" value="<?php echo $row['work_status']; ?>">
                                                <?php 
                                                if ($row['work_status'] == 'pending') {
                                                 echo "<div class='progress'>
                                                          <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' title='15% on progress'></div>
                                                        </div><b>PENDING 15%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' title='25% on progress' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>PENDING 25%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending2') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'></div>
                                                            </div><b>PENDING 50%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending3') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>PENDING 75%</b>";
                                                }

                                                if ($row['work_status'] == 'completed') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>COMPLETED 100%</b>";
                                                }
                                                ?>
                                            </div>
                                            <hr> -->
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
                                            </div> -->
                                            
                                            <!-- <div class="form-group">
                                                <label>Turned In:</label> <br>
                                                <?php
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
                                            <hr>
                                            <div class="form-group">
                                                <i style="color: #1a8cff;" class="fas fa-clock"></i>
                                                <b title="DATE AND TIME SUBMITTED"> <?php $date_time_posted = $_SESSION['datetime222']; echo $date_time_posted; ?> </b>
                                            </div> -->
                                        <!-- </div>
                                       
                                    </div>
                                </div> -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                                <button type="submit" name="forward" class="btn btn-primary">Forward <i class="fas fa-share-square"></i></button>
                            </div>
                          </form> <!-- end of form -->
                        </div>
                      </div>
                    </div>

                </div> 
            <!-- end tag modal -->
            </tr>
            <?php $count1++; } ?> 
          </tbody>
        </table>
    </div>
    
    <?php }

    else if($_POST['request'] == "Resume") {
        $work_stats = "semi-pending";
        $stats = "not archived";
        $submitted = "yes";
        $count = 1;
        $my_fullname_ = $_SESSION['coordinator_fullname_session'];
        $sql = "SELECT * from tbl_students_work where requirement='$request', name_of_teacher='$my_fullname_' and work_status='$work_stats' and submitted='$submitted' and status='$stats' ORDER BY id ASC";
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
                  <th hidden=""> TASK CODE</th>
                  <th hidden="">ID</th>
                  <th>Submitted by</th>
                  <th hidden>Course</th>
                  <th>Requirement</th>
                  <th>Submitted File</th>
                  <th hidden="">Due Date</th>
                  <th>Turned In</th>
                  <th>My Remarks</th>
                  <th>Status</th>
                  <th>Action</th>                      
                </tr>
                <?php } else { echo "No data available in table"; }?>
              </thead>
              <tbody>
                <?php
                    while($row = $query->fetch_assoc()){
                        $id = $row['id'];
                        $task_code = $row['task_code'];
                        $_SESSION['task_id_22'] = $row['id'];
                ?>
                <tr id="tra">
                   <td hidden=""> <?php echo $task_code;?> </td> 
                   <td hidden=""><?php 
                        $_SESSION['t_id_works11'] = $_SESSION['task_id_22'];
                        echo $_SESSION['t_id_works11'];
                    ?>  
                  </td>
                  <td width="20%"><?php echo $row['stud_name_and_id']; ?></td>
                  <td hidden><?php echo $row['course'];?> </td>
                  <td><?php echo $row['title'];?> </td>
                  <td width="25%"><b><a href="../students/upload_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File"><i class="fa fa-file"></i><?php echo $row['uploaded_file'];?></a> </b></td>
                  <td hidden=""><?php echo $row['date_of_submission'];?> </td>
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
                            echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-success'>ON-TIME</span>";;
                        }
                    ?> 
                    </td>
                    <td width="10%">
                    <?php 
                        if ($row['remarks'] == 'waiting') {
                             echo "<span style='font-size: 15px; margin-left: 0px; color: gray;' class='badge badge-pill badge-warning'>ON REVIEW</span>";
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
                                    </div><b>PENDING 25%</b>";
                        }

                        if ($row['work_status'] == 'semi-pending2') {
                             echo "<div class='progress'>
                                      <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'></div>
                                    </div><b>PENDING 50%</b>";
                        }

                        if ($row['work_status'] == 'semi-pending3') {
                             echo "<div class='progress'>
                                      <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                    </div><b>PENDING 75%</b>";
                        }

                        if ($row['work_status'] == 'completed') {
                             echo "<div class='progress'>
                                      <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'></div>
                                    </div><b>COMPLETED 100%</b>";
                        }
                    ?>
                  </td>
                  <td width="10%">
                      <a href="#view<?php echo $id;?>" title="View Submitted Requirement" data-toggle="modal" ><button class="btn btn-info"><i class="fas fa-check-square"></i></button></a>
                      <?php if($row['remarks']=="Approved"){ ?>
                      <a href="#forward<?php echo $id;?>" title="Forward to Program Head" data-toggle="modal" ><button class="btn btn-primary"><i class="fas fa-share-square"></i></button></a>
                       <?php } ?>
                      <!-- <a href="" class='del-btn'><button class="btn btn-danger" title="Delete"><i class="fas fa-trash-alt"></i></button></a> -->
                  </td>

                    <!-- View Modal -->
                    <div class="modal fade bd-example-modal-lg" data-backdrop="static" id="view<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="update_place" aria-hidden="true">
                      <div class="modal-dialog modal-lg" role="document" style="color:  #333333;">
                        <div class="modal-content modal-lg">
                          <div class="modal-header modal-lg">
                            <h5 class="modal-title" id="exampleModalLabel"><h style="color: #0d6efd"><i class="fas fa-file-alt"></i> <?php echo $row['title']; ?> </h><span><?php //echo $row['edited']; ?></span></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-header modal-lg">
                                <p class="modal-title" id="exampleModalLabel">
                                <h title="Date and Time Submitted"><i style="color: #1a8cff;" class="fas fa-clock"></i> <?php echo $row['date_submitted']. " at " . $row['time_submitted']; ?> <?php echo $row['edited_by_student'];?></h></p> 
                            </div>
                          <form action="my_stud_requirements_completed_update.php" method="POST" enctype="multipart/form-data"><!-- form start -->
                          <input type="text" class="form-control" name="id" value="<?php echo $id;?>" hidden>
                          <input type="text" name="task_code" value="<?php echo $task_code;?>" hidden>
                            <div class="modal-body modal-lg">
                                <!-- <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md"> -->
                                            <div class="form-group">
                                                <label>Submitted by: </label> <br>
                                                <b> <?php echo $row['stud_name_and_id']; ?> </b>
                                                <input type="text" name="stud_fullname" value="<?php echo $row['stud_name_and_id']; ?>" hidden>
                                            </div> 
                                            <hr>
                                            <div class="form-group">
                                                <label>Course, Year & Section: </label> <br>
                                                <b> <?php echo $row['course']; ?> </b>
                                            </div>
                                            <div class="form-group">
                                                <!-- <label>Requirement: </label> <br>
                                                <b> <?php echo $row['title']; ?> </b> -->
                                                <input type="text" name="requirement" value="<?php echo $row['title']; ?>" hidden>
                                            </div>
                                            <hr>
                                            <div class="form-group">
                                                <label>Instructions: </label> <br>
                                                <textarea style="background: ghostwhite;" rows="10" name="instructions" class="form-control" id="instructions" aria-describedby="" readonly required=""><?php echo $row['instructions'];?></textarea>
                                            </div>
                                        <!-- </div>
                                        <div class="col-md"> -->
                                            <div class="form-group">
                                                <label>Submitted File</label>: <?php //echo $row['edited_by_student'];?><br>
                                                <b><a href="../students/upload_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File">
                                                <i class="fa fa-file"></i><?php echo $row['uploaded_file'];?></a>
                                                </b>
                                            </div>
                                            <div class="form-group">
                                                <div class="embed-responsive embed-responsive-1by1">
                                                  <iframe class="embed-responsive-item" src="../students/upload_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                                                </div>
                                            </div>
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
                                                            </div><b>PENDING 25%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending2') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'></div>
                                                            </div><b>PENDING 50%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending3') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>PENDING 75%</b>";
                                                }

                                                if ($row['work_status'] == 'completed') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>COMPLETED 100%</b>";
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
                                            <div class="form-group">
                                                <label>Due Date:</label> <br>
                                                <b><?php
                                                    echo $row['date_of_submission'];?></b>
                                            </div>
                                            <hr>
                                            <div class="form-group">
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
                                            <hr>
                                            <!-- <div class="form-group">
                                                <i style="color: #1a8cff;" class="fas fa-clock"></i>
                                                <b title="DATE AND TIME SUBMITTED"> <?php $date_time_posted = $_SESSION['datetime222']; echo $date_time_posted; ?> </b><br>
                                                <?php if ($row['edited_by_student']=="(edited)") {?>
                                                <b><span><i style="color: #1a8cff;" class="fas fa-user-edit"></i><?php echo $row['edited_by_student']; ?></span></b>
                                                <?php } else {
                                                    echo "";
                                                }?>
                                            </div>
                                            <hr> -->
                                            <div class="form-group">
                                                <label>Comment/s:</label> <br>
                                                <textarea style="background: ghostwhite;" readonly="" name="comments" class="form-control" id="comments" rows="5"><?php echo $row['student_comment']; ?></textarea>
                                            </div>
                                        <!-- </div> -->
                                        <!-- <div class="col-md"> -->
                                            <div class="form-group">
                                                <label>My Remarks: </label> <br>
                                                <select style="background: white;" name="remarks" id="remarks" class="form-control">
                                                    <?php
                                                        if($row['remarks']=="Approved"){
                                                            echo "<option name='approved'>Approved</option>";
                                                            echo "<option name='not approved'>Not Approved</option>";
                                                        }

                                                        if($row['remarks']=="Not Approved"){
                                                             echo "<option name='not approved'>Not Approved</option>";
                                                            echo "<option name='approved'>Approved</option>";
                                                        }
                                                        if($row['remarks']=="waiting"){
                                                            echo "<option name='approved'>Approved</option>";
                                                            echo "<option name='not approved'>Not Approved</option>";
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <hr>
                                            <div class="form-group">
                                                <label>My Comments and Suggestions:</label> <br>
                                                <textarea style="background: white;" name="comments" class="form-control" rows="5" id="my_comments" placeholder="Write Your Comments and Suggestions Here (Optional)"><?php echo $row['comment']; ?></textarea>
                                            </div>
                                        <!-- </div>
                                    </div>
                                </div> -->
                            </div>
                            <div class="modal-footer">
                                <?php if($row['remarks']=="Approved"){ ?>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                                <button type="submit" name="submit" class="btn btn-primary">Re-Submit
                                <i class="fas fa-check-square"></i></button> 
                                <button type="submit" name="set_as_completed" class="btn btn-success">Set As Completed <i class="fas fa-check-square"></i></button>
                                <?php } else {?>
                                 <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                                <button type="submit" name="submit" class="btn btn-primary">Submit
                                <i class="fas fa-check-square"></i></button>
                                <?php } ?>
                            </div>
                          </form> <!-- end of form -->
                        </div>
                      </div>
                    </div>

                    <!-- Forward Modal -->
                    <div class="modal fade bd-example-modal-lg" data-backdrop="static" id="forward<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="update_place" aria-hidden="true">
                      <div class="modal-dialog modal-lg" role="document" style="color:  #333333;">
                        <div class="modal-content modal-lg">
                          <div class="modal-header modal-lg">
                            <h5 class="modal-title" id="exampleModalLabel"><h style="color: #0d6efd"><i class="fas fa-share-square"></i> Forward To Program Head / <?php echo $row['title']; ?></h><span><?php //echo $row['edited']; ?></span></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-header modal-lg">
                                <p class="modal-title" id="exampleModalLabel">
                                <h title="Date and Time Submitted"><i style="color: #1a8cff;" class="fas fa-clock"></i> <?php echo $row['date_submitted']. " at " . $row['time_submitted']; ?> <?php echo $row['edited_by_student'];?></h></p> 
                            </div>
                          <form action="my_stud_requirements_completed_update.php" method="POST" enctype="multipart/form-data"><!-- form start -->
                          <input type="text" class="form-control" name="id" value="<?php echo $id;?>" hidden>
                          <!-- task code uniq id -->
                          <input type="text" name="task_code" value="<?php echo $task_code;?>" hidden>
                            <div class="modal-body modal-lg">
                                <!-- <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md"> -->
                                            <div class="form-group">
                                                <label>Submitted by: </label> <br>
                                                <b><?php echo $row['stud_name_and_id']; ?> </b>
                                                <input type="text" hidden="" name="stud_fullname" value="<?php echo $row['stud_name_and_id']; ?>">
                                            </div>
                                            <hr>
                                            <div class="form-group">
                                               <!--  <label>Course, Year & Section : </label> <br>
                                                <b> <?php echo $row['course']; ?> </b> -->
                                                <input type="text" hidden="" name="course" value="<?php echo $row['course']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <!-- <label>Requirement : </label> <br>
                                                <b> <?php echo $row['title']; ?> </b> -->
                                                <input type="text" hidden="" name="requirement" value="<?php echo $row['title']; ?>">
                                            </div>
                                            <div class="form-group">
                                               <!--  <label>Instructions : </label> <br> -->
                                                <textarea hidden="" style="background: ghostwhite;" rows="10" name="instructions" class="form-control" id="instructions" aria-describedby="" readonly required=""><?php echo $row['instructions'];?></textarea>
                                            </div>
                                        <!-- </div>
                                        <div class="col-md"> -->
                                            <div class="form-group">
                                                <label>Submitted File</label> : <?php //echo $row['edited_by_student'];?><br>
                                                <b><a href="../students/upload_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File">
                                                 <i class="fa fa-file"></i><?php echo $row['uploaded_file'];?></a>
                                                </b>
                                            </div>
                                            <div class="form-group">
                                                <div class="embed-responsive embed-responsive-1by1">
                                                  <iframe class="embed-responsive-item" src="../students/upload_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                                                </div>
                                            </div>
                                            <hr>
                                            <!-- <div class="form-group">
                                                <label>Status : </label> <br>
                                                <input hidden type="text" name="status" value="<?php echo $row['work_status']; ?>">
                                                <?php 
                                                if ($row['work_status'] == 'pending') {
                                                 echo "<div class='progress'>
                                                          <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' title='15% on progress'></div>
                                                        </div><b>PENDING 15%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' title='25% on progress' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>PENDING 25%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending2') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'></div>
                                                            </div><b>PENDING 50%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending3') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>PENDING 75%</b>";
                                                }

                                                if ($row['work_status'] == 'completed') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>COMPLETED 100%</b>";
                                                }
                                                ?>
                                            </div>
                                            <hr> -->
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
                                            </div> -->
                                            
                                            <!-- <div class="form-group">
                                                <label>Turned In:</label> <br>
                                                <?php
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
                                            <hr>
                                            <div class="form-group">
                                                <i style="color: #1a8cff;" class="fas fa-clock"></i>
                                                <b title="DATE AND TIME SUBMITTED"> <?php $date_time_posted = $_SESSION['datetime222']; echo $date_time_posted; ?> </b>
                                            </div> -->
                                        <!-- </div>
                                       
                                    </div>
                                </div> -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                                <button type="submit" name="forward" class="btn btn-primary">Forward <i class="fas fa-share-square"></i></button>
                            </div>
                          </form> <!-- end of form -->
                        </div>
                      </div>
                    </div>

                </div> 
            <!-- end tag modal -->
            </tr>
            <?php $count1++; } ?> 
          </tbody>
        </table>
    </div>
    
    <?php }

    else if($_POST['request'] == "Accomplishment Report") {
        $work_stats = "semi-pending";
        $stats = "not archived";
        $submitted = "yes";
        $count = 1;
        $my_fullname_ = $_SESSION['coordinator_fullname_session'];
        $sql = "SELECT * from tbl_students_work where requirement='$request', name_of_teacher='$my_fullname_' and work_status='$work_stats' and submitted='$submitted' and status='$stats' ORDER BY id ASC";
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
                  <th hidden=""> TASK CODE</th>
                  <th hidden="">ID</th>
                  <th>Submitted by</th>
                  <th hidden>Course</th>
                  <th>Requirement</th>
                  <th>Submitted File</th>
                  <th hidden="">Due Date</th>
                  <th>Turned In</th>
                  <th>My Remarks</th>
                  <th>Status</th>
                  <th>Action</th>                      
                </tr>
                <?php } else { echo "No data available in table"; }?>
              </thead>
              <tbody>
                <?php
                    while($row = $query->fetch_assoc()){
                        $id = $row['id'];
                        $task_code = $row['task_code'];
                        $_SESSION['task_id_22'] = $row['id'];
                ?>
                <tr id="tra">
                   <td hidden=""> <?php echo $task_code;?> </td> 
                   <td hidden=""><?php 
                        $_SESSION['t_id_works11'] = $_SESSION['task_id_22'];
                        echo $_SESSION['t_id_works11'];
                    ?>  
                  </td>
                  <td width="20%"><?php echo $row['stud_name_and_id']; ?></td>
                  <td hidden><?php echo $row['course'];?> </td>
                  <td><?php echo $row['title'];?> </td>
                  <td width="25%"><b><a href="../students/upload_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File"><i class="fa fa-file"></i><?php echo $row['uploaded_file'];?></a> </b></td>
                  <td hidden=""><?php echo $row['date_of_submission'];?> </td>
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
                            echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-success'>ON-TIME</span>";;
                        }
                    ?> 
                    </td>
                    <td width="10%">
                    <?php 
                        if ($row['remarks'] == 'waiting') {
                             echo "<span style='font-size: 15px; margin-left: 0px; color: gray;' class='badge badge-pill badge-warning'>ON REVIEW</span>";
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
                                    </div><b>PENDING 25%</b>";
                        }

                        if ($row['work_status'] == 'semi-pending2') {
                             echo "<div class='progress'>
                                      <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'></div>
                                    </div><b>PENDING 50%</b>";
                        }

                        if ($row['work_status'] == 'semi-pending3') {
                             echo "<div class='progress'>
                                      <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                    </div><b>PENDING 75%</b>";
                        }

                        if ($row['work_status'] == 'completed') {
                             echo "<div class='progress'>
                                      <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'></div>
                                    </div><b>COMPLETED 100%</b>";
                        }
                    ?>
                  </td>
                  <td width="10%">
                      <a href="#view<?php echo $id;?>" title="View Submitted Requirement" data-toggle="modal" ><button class="btn btn-info"><i class="fas fa-check-square"></i></button></a>
                      <?php if($row['remarks']=="Approved"){ ?>
                      <a href="#forward<?php echo $id;?>" title="Forward to Program Head" data-toggle="modal" ><button class="btn btn-primary"><i class="fas fa-share-square"></i></button></a>
                       <?php } ?>
                      <!-- <a href="" class='del-btn'><button class="btn btn-danger" title="Delete"><i class="fas fa-trash-alt"></i></button></a> -->
                  </td>

                    <!-- View Modal -->
                    <div class="modal fade bd-example-modal-lg" data-backdrop="static" id="view<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="update_place" aria-hidden="true">
                      <div class="modal-dialog modal-lg" role="document" style="color:  #333333;">
                        <div class="modal-content modal-lg">
                          <div class="modal-header modal-lg">
                            <h5 class="modal-title" id="exampleModalLabel"><h style="color: #0d6efd"><i class="fas fa-file-alt"></i> <?php echo $row['title']; ?> </h><span><?php //echo $row['edited']; ?></span></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-header modal-lg">
                                <p class="modal-title" id="exampleModalLabel">
                                <h title="Date and Time Submitted"><i style="color: #1a8cff;" class="fas fa-clock"></i> <?php echo $row['date_submitted']. " at " . $row['time_submitted']; ?> <?php echo $row['edited_by_student'];?></h></p> 
                            </div>
                          <form action="my_stud_requirements_completed_update.php" method="POST" enctype="multipart/form-data"><!-- form start -->
                          <input type="text" class="form-control" name="id" value="<?php echo $id;?>" hidden>
                          <input type="text" name="task_code" value="<?php echo $task_code;?>" hidden>
                            <div class="modal-body modal-lg">
                                <!-- <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md"> -->
                                            <div class="form-group">
                                                <label>Submitted by: </label> <br>
                                                <b> <?php echo $row['stud_name_and_id']; ?> </b>
                                                <input type="text" name="stud_fullname" value="<?php echo $row['stud_name_and_id']; ?>" hidden>
                                            </div> 
                                            <hr>
                                            <div class="form-group">
                                                <label>Course, Year & Section: </label> <br>
                                                <b> <?php echo $row['course']; ?> </b>
                                            </div>
                                            <div class="form-group">
                                                <!-- <label>Requirement: </label> <br>
                                                <b> <?php echo $row['title']; ?> </b> -->
                                                <input type="text" name="requirement" value="<?php echo $row['title']; ?>" hidden>
                                            </div>
                                            <hr>
                                            <div class="form-group">
                                                <label>Instructions: </label> <br>
                                                <textarea style="background: ghostwhite;" rows="10" name="instructions" class="form-control" id="instructions" aria-describedby="" readonly required=""><?php echo $row['instructions'];?></textarea>
                                            </div>
                                        <!-- </div>
                                        <div class="col-md"> -->
                                            <div class="form-group">
                                                <label>Submitted File</label>: <?php //echo $row['edited_by_student'];?><br>
                                                <b><a href="../students/upload_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File">
                                                <i class="fa fa-file"></i><?php echo $row['uploaded_file'];?></a>
                                                </b>
                                            </div>
                                            <div class="form-group">
                                                <div class="embed-responsive embed-responsive-1by1">
                                                  <iframe class="embed-responsive-item" src="../students/upload_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                                                </div>
                                            </div>
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
                                                            </div><b>PENDING 25%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending2') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'></div>
                                                            </div><b>PENDING 50%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending3') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>PENDING 75%</b>";
                                                }

                                                if ($row['work_status'] == 'completed') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>COMPLETED 100%</b>";
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
                                            <div class="form-group">
                                                <label>Due Date:</label> <br>
                                                <b><?php
                                                    echo $row['date_of_submission'];?></b>
                                            </div>
                                            <hr>
                                            <div class="form-group">
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
                                            <hr>
                                            <!-- <div class="form-group">
                                                <i style="color: #1a8cff;" class="fas fa-clock"></i>
                                                <b title="DATE AND TIME SUBMITTED"> <?php $date_time_posted = $_SESSION['datetime222']; echo $date_time_posted; ?> </b><br>
                                                <?php if ($row['edited_by_student']=="(edited)") {?>
                                                <b><span><i style="color: #1a8cff;" class="fas fa-user-edit"></i><?php echo $row['edited_by_student']; ?></span></b>
                                                <?php } else {
                                                    echo "";
                                                }?>
                                            </div>
                                            <hr> -->
                                            <div class="form-group">
                                                <label>Comment/s:</label> <br>
                                                <textarea style="background: ghostwhite;" readonly="" name="comments" class="form-control" id="comments" rows="5"><?php echo $row['student_comment']; ?></textarea>
                                            </div>
                                        <!-- </div> -->
                                        <!-- <div class="col-md"> -->
                                            <div class="form-group">
                                                <label>My Remarks: </label> <br>
                                                <select style="background: white;" name="remarks" id="remarks" class="form-control">
                                                    <?php
                                                        if($row['remarks']=="Approved"){
                                                            echo "<option name='approved'>Approved</option>";
                                                            echo "<option name='not approved'>Not Approved</option>";
                                                        }

                                                        if($row['remarks']=="Not Approved"){
                                                             echo "<option name='not approved'>Not Approved</option>";
                                                            echo "<option name='approved'>Approved</option>";
                                                        }
                                                        if($row['remarks']=="waiting"){
                                                            echo "<option name='approved'>Approved</option>";
                                                            echo "<option name='not approved'>Not Approved</option>";
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <hr>
                                            <div class="form-group">
                                                <label>My Comments and Suggestions:</label> <br>
                                                <textarea style="background: white;" name="comments" class="form-control" rows="5" id="my_comments" placeholder="Write Your Comments and Suggestions Here (Optional)"><?php echo $row['comment']; ?></textarea>
                                            </div>
                                        <!-- </div>
                                    </div>
                                </div> -->
                            </div>
                            <div class="modal-footer">
                                <?php if($row['remarks']=="Approved"){ ?>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                                <button type="submit" name="submit" class="btn btn-primary">Re-Submit
                                <i class="fas fa-check-square"></i></button> 
                                <button type="submit" name="set_as_completed" class="btn btn-success">Set As Completed <i class="fas fa-check-square"></i></button>
                                <?php } else {?>
                                 <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                                <button type="submit" name="submit" class="btn btn-primary">Submit
                                <i class="fas fa-check-square"></i></button>
                                <?php } ?>
                            </div>
                          </form> <!-- end of form -->
                        </div>
                      </div>
                    </div>

                    <!-- Forward Modal -->
                    <div class="modal fade bd-example-modal-lg" data-backdrop="static" id="forward<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="update_place" aria-hidden="true">
                      <div class="modal-dialog modal-lg" role="document" style="color:  #333333;">
                        <div class="modal-content modal-lg">
                          <div class="modal-header modal-lg">
                            <h5 class="modal-title" id="exampleModalLabel"><h style="color: #0d6efd"><i class="fas fa-share-square"></i> Forward To Program Head / <?php echo $row['title']; ?></h><span><?php //echo $row['edited']; ?></span></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-header modal-lg">
                                <p class="modal-title" id="exampleModalLabel">
                                <h title="Date and Time Submitted"><i style="color: #1a8cff;" class="fas fa-clock"></i> <?php echo $row['date_submitted']. " at " . $row['time_submitted']; ?> <?php echo $row['edited_by_student'];?></h></p> 
                            </div>
                          <form action="my_stud_requirements_completed_update.php" method="POST" enctype="multipart/form-data"><!-- form start -->
                          <input type="text" class="form-control" name="id" value="<?php echo $id;?>" hidden>
                          <!-- task code uniq id -->
                          <input type="text" name="task_code" value="<?php echo $task_code;?>" hidden>
                            <div class="modal-body modal-lg">
                                <!-- <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md"> -->
                                            <div class="form-group">
                                                <label>Submitted by: </label> <br>
                                                <b><?php echo $row['stud_name_and_id']; ?> </b>
                                                <input type="text" hidden="" name="stud_fullname" value="<?php echo $row['stud_name_and_id']; ?>">
                                            </div>
                                            <hr>
                                            <div class="form-group">
                                               <!--  <label>Course, Year & Section : </label> <br>
                                                <b> <?php echo $row['course']; ?> </b> -->
                                                <input type="text" hidden="" name="course" value="<?php echo $row['course']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <!-- <label>Requirement : </label> <br>
                                                <b> <?php echo $row['title']; ?> </b> -->
                                                <input type="text" hidden="" name="requirement" value="<?php echo $row['title']; ?>">
                                            </div>
                                            <div class="form-group">
                                               <!--  <label>Instructions : </label> <br> -->
                                                <textarea hidden="" style="background: ghostwhite;" rows="10" name="instructions" class="form-control" id="instructions" aria-describedby="" readonly required=""><?php echo $row['instructions'];?></textarea>
                                            </div>
                                        <!-- </div>
                                        <div class="col-md"> -->
                                            <div class="form-group">
                                                <label>Submitted File</label> : <?php //echo $row['edited_by_student'];?><br>
                                                <b><a href="../students/upload_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File">
                                                 <i class="fa fa-file"></i><?php echo $row['uploaded_file'];?></a>
                                                </b>
                                            </div>
                                            <div class="form-group">
                                                <div class="embed-responsive embed-responsive-1by1">
                                                  <iframe class="embed-responsive-item" src="../students/upload_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                                                </div>
                                            </div>
                                            <hr>
                                            <!-- <div class="form-group">
                                                <label>Status : </label> <br>
                                                <input hidden type="text" name="status" value="<?php echo $row['work_status']; ?>">
                                                <?php 
                                                if ($row['work_status'] == 'pending') {
                                                 echo "<div class='progress'>
                                                          <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' title='15% on progress'></div>
                                                        </div><b>PENDING 15%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' title='25% on progress' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>PENDING 25%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending2') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'></div>
                                                            </div><b>PENDING 50%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending3') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>PENDING 75%</b>";
                                                }

                                                if ($row['work_status'] == 'completed') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>COMPLETED 100%</b>";
                                                }
                                                ?>
                                            </div>
                                            <hr> -->
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
                                            </div> -->
                                            
                                            <!-- <div class="form-group">
                                                <label>Turned In:</label> <br>
                                                <?php
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
                                            <hr>
                                            <div class="form-group">
                                                <i style="color: #1a8cff;" class="fas fa-clock"></i>
                                                <b title="DATE AND TIME SUBMITTED"> <?php $date_time_posted = $_SESSION['datetime222']; echo $date_time_posted; ?> </b>
                                            </div> -->
                                        <!-- </div>
                                       
                                    </div>
                                </div> -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                                <button type="submit" name="forward" class="btn btn-primary">Forward <i class="fas fa-share-square"></i></button>
                            </div>
                          </form> <!-- end of form -->
                        </div>
                      </div>
                    </div>

                </div> 
            <!-- end tag modal -->
            </tr>
            <?php $count1++; } ?> 
          </tbody>
        </table>
    </div>
    
    <?php } 

    else if($_POST['request'] == "Work Plan") {
        $count1 = 1;
        $title = "Work Plan";
        $myfullname_ = $_SESSION['coordinator_fullname_session'];
        $work_stats = "semi-pending";
        $stats = "not archived";
        $submitted = "yes";
        $sql = "SELECT * from tbl_students_work where title='$title' and name_of_teacher='$myfullname_' and work_status='$work_stats' and submitted='$submitted' and status='$stats'";
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
                  <th hidden=""> TASK CODE</th>
                  <th hidden="">ID</th>
                  <th>Submitted by</th>
                  <th hidden>Course</th>
                  <th>Requirement</th>
                  <th>Submitted File</th>
                  <th hidden="">Due Date</th>
                  <th>Turned In</th>
                  <th>My Remarks</th>
                  <th>Status</th>
                  <th>Action</th>                      
                </tr>
                <?php } else { echo "No data available in table"; }?>
              </thead>
              <tbody>
                <?php
                    while($row = $query->fetch_assoc()){
                        $id = $row['id'];
                        $task_code = $row['task_code'];
                        $_SESSION['task_id_22'] = $row['id'];
                ?>
                <tr id="tra">
                   <td hidden=""> <?php echo $task_code;?> </td> 
                   <td hidden=""><?php 
                        $_SESSION['t_id_works11'] = $_SESSION['task_id_22'];
                        echo $_SESSION['t_id_works11'];
                    ?>  
                  </td>
                  <td width="20%"><?php echo $row['stud_name_and_id']; ?></td>
                  <td hidden><?php echo $row['course'];?> </td>
                  <td><?php echo $row['title'];?> </td>
                  <td width="25%"><b><a href="../students/upload_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File"><i class="fa fa-file"></i><?php echo $row['uploaded_file'];?></a> </b></td>
                  <td hidden=""><?php echo $row['date_of_submission'];?> </td>
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
                            echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-success'>ON-TIME</span>";;
                        }
                    ?> 
                    </td>
                    <td width="10%">
                    <?php 
                        if ($row['remarks'] == 'waiting') {
                             echo "<span style='font-size: 15px; margin-left: 0px; color: gray;' class='badge badge-pill badge-warning'>ON REVIEW</span>";
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
                                      <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' title='25% on progress' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'>25%</div>
                                    </div><b>PENDING</b>";
                        }

                        if ($row['work_status'] == 'semi-pending2') {
                             echo "<div class='progress'>
                                      <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'></div>
                                    </div><b>PENDING 50%</b>";
                        }

                        if ($row['work_status'] == 'semi-pending3') {
                             echo "<div class='progress'>
                                      <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                    </div><b>PENDING 75%</b>";
                        }

                        if ($row['work_status'] == 'completed') {
                             echo "<div class='progress'>
                                      <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'></div>
                                    </div><b>COMPLETED 100%</b>";
                        }
                    ?>
                  </td>
                  <td width="10%">
                      <a href="#view<?php echo $id;?>" title="View Submitted Requirement" data-toggle="modal" ><button class="btn btn-info"><i class="fas fa-check-square"></i></button></a>
                      <?php if($row['remarks']=="Approved"){ ?>
                      <a href="#forward<?php echo $id;?>" title="Forward to Program Head" data-toggle="modal" ><button class="btn btn-primary"><i class="fas fa-share-square"></i></button></a>
                       <?php } ?>
                      <!-- <a href="" class='del-btn'><button class="btn btn-danger" title="Delete"><i class="fas fa-trash-alt"></i></button></a> -->
                  </td>

                    <!-- View Modal -->
                    <div class="modal fade bd-example-modal-lg" data-backdrop="static" id="view<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="update_place" aria-hidden="true">
                      <div class="modal-dialog modal-lg" role="document" style="color:  #333333;">
                        <div class="modal-content modal-lg">
                          <div class="modal-header modal-lg">
                            <h5 class="modal-title" id="exampleModalLabel"><h style="color: #0d6efd"><i class="fas fa-file-alt"></i> <?php echo $row['title']; ?> </h><span><?php //echo $row['edited']; ?></span></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-header modal-lg">
                                <p class="modal-title" id="exampleModalLabel">
                                <h title="Date and Time Submitted"><i style="color: #1a8cff;" class="fas fa-clock"></i> <?php echo $row['date_submitted']. " at " . $row['time_submitted']; ?> <?php echo $row['edited_by_student'];?></h></p> 
                            </div>
                          <form action="my_stud_requirements_completed_update.php" method="POST" enctype="multipart/form-data"><!-- form start -->
                          <input type="text" class="form-control" name="id" value="<?php echo $id;?>" hidden>
                          <input type="text" name="task_code" value="<?php echo $task_code;?>" hidden>
                            <div class="modal-body modal-lg">
                                <!-- <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md"> -->
                                            <div class="form-group">
                                                <label>Submitted by: </label> <br>
                                                <b> <?php echo $row['stud_name_and_id']; ?> </b>
                                                <input type="text" name="stud_fullname" value="<?php echo $row['stud_name_and_id']; ?>" hidden>
                                            </div> 
                                            <hr>
                                            <div class="form-group">
                                                <label>Course, Year & Section: </label> <br>
                                                <b> <?php echo $row['course']; ?> </b>
                                            </div>
                                            <div class="form-group">
                                                <!-- <label>Requirement: </label> <br>
                                                <b> <?php echo $row['title']; ?> </b> -->
                                                <input type="text" name="requirement" value="<?php echo $row['title']; ?>" hidden>
                                            </div>
                                            <hr>
                                            <div class="form-group">
                                                <label>Instructions: </label> <br>
                                                <textarea style="background: ghostwhite;" rows="10" name="instructions" class="form-control" id="instructions" aria-describedby="" readonly required=""><?php echo $row['instructions'];?></textarea>
                                            </div>
                                        <!-- </div>
                                        <div class="col-md"> -->
                                            <div class="form-group">
                                                <label>Submitted File</label>: <?php //echo $row['edited_by_student'];?><br>
                                                <b><a href="../students/upload_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File">
                                                <i class="fa fa-file"></i><?php echo $row['uploaded_file'];?></a>
                                                </b>
                                            </div>
                                            <div class="form-group">
                                                <div class="embed-responsive embed-responsive-1by1">
                                                  <iframe class="embed-responsive-item" src="../students/upload_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                                                </div>
                                            </div>
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
                                                            </div><b>PENDING 25%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending2') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'></div>
                                                            </div><b>PENDING 50%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending3') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>PENDING 75%</b>";
                                                }

                                                if ($row['work_status'] == 'completed') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>COMPLETED 100%</b>";
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
                                            <div class="form-group">
                                                <label>Due Date:</label> <br>
                                                <b><?php
                                                    echo $row['date_of_submission'];?></b>
                                            </div>
                                            <hr>
                                            <div class="form-group">
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
                                            <hr>
                                            <!-- <div class="form-group">
                                                <i style="color: #1a8cff;" class="fas fa-clock"></i>
                                                <b title="DATE AND TIME SUBMITTED"> <?php $date_time_posted = $_SESSION['datetime222']; echo $date_time_posted; ?> </b><br>
                                                <?php if ($row['edited_by_student']=="(edited)") {?>
                                                <b><span><i style="color: #1a8cff;" class="fas fa-user-edit"></i><?php echo $row['edited_by_student']; ?></span></b>
                                                <?php } else {
                                                    echo "";
                                                }?>
                                            </div>
                                            <hr> -->
                                            <div class="form-group">
                                                <label>Comment/s:</label> <br>
                                                <textarea style="background: ghostwhite;" readonly="" name="comments" class="form-control" id="comments" rows="5"><?php echo $row['student_comment']; ?></textarea>
                                            </div>
                                        <!-- </div> -->
                                        <!-- <div class="col-md"> -->
                                            <div class="form-group">
                                                <label>My Remarks: </label> <br>
                                                <select style="background: white;" name="remarks" id="remarks" class="form-control">
                                                    <?php
                                                        if($row['remarks']=="Approved"){
                                                            echo "<option name='approved'>Approved</option>";
                                                            echo "<option name='not approved'>Not Approved</option>";
                                                        }

                                                        if($row['remarks']=="Not Approved"){
                                                             echo "<option name='not approved'>Not Approved</option>";
                                                            echo "<option name='approved'>Approved</option>";
                                                        }
                                                        if($row['remarks']=="waiting"){
                                                            echo "<option name='approved'>Approved</option>";
                                                            echo "<option name='not approved'>Not Approved</option>";
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <hr>
                                            <div class="form-group">
                                                <label>My Comments and Suggestions:</label> <br>
                                                <textarea style="background: white;" name="comments" class="form-control" rows="5" id="my_comments" placeholder="Write Your Comments and Suggestions Here (Optional)"><?php echo $row['comment']; ?></textarea>
                                            </div>
                                        <!-- </div>
                                    </div>
                                </div> -->
                            </div>
                            <div class="modal-footer">
                                <?php if($row['remarks']=="Approved"){ ?>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                                <button type="submit" name="submit" class="btn btn-primary">Re-Submit
                                <i class="fas fa-check-square"></i></button> 
                                <button type="submit" name="set_as_completed" class="btn btn-success">Set As Completed <i class="fas fa-check-square"></i></button>
                                <?php } else {?>
                                 <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                                <button type="submit" name="submit" class="btn btn-primary">Submit
                                <i class="fas fa-check-square"></i></button>
                                <?php } ?>
                            </div>
                          </form> <!-- end of form -->
                        </div>
                      </div>
                    </div>

                    <!-- Forward Modal -->
                    <div class="modal fade bd-example-modal-lg" data-backdrop="static" id="forward<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="update_place" aria-hidden="true">
                      <div class="modal-dialog modal-lg" role="document" style="color:  #333333;">
                        <div class="modal-content modal-lg">
                          <div class="modal-header modal-lg">
                            <h5 class="modal-title" id="exampleModalLabel"><h style="color: #0d6efd"><i class="fas fa-share-square"></i> Forward To Program Head / <?php echo $row['title']; ?></h><span><?php //echo $row['edited']; ?></span></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-header modal-lg">
                                <p class="modal-title" id="exampleModalLabel">
                                <h title="Date and Time Submitted"><i style="color: #1a8cff;" class="fas fa-clock"></i> <?php echo $row['date_submitted']. " at " . $row['time_submitted']; ?> <?php echo $row['edited_by_student'];?></h></p> 
                            </div>
                          <form action="my_stud_requirements_completed_update.php" method="POST" enctype="multipart/form-data"><!-- form start -->
                          <input type="text" class="form-control" name="id" value="<?php echo $id;?>" hidden>
                          <!-- task code uniq id -->
                          <input type="text" name="task_code" value="<?php echo $task_code;?>" hidden>
                            <div class="modal-body modal-lg">
                                <!-- <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md"> -->
                                            <div class="form-group">
                                                <label>Submitted by: </label> <br>
                                                <b><?php echo $row['stud_name_and_id']; ?> </b>
                                                <input type="text" hidden="" name="stud_fullname" value="<?php echo $row['stud_name_and_id']; ?>">
                                            </div>
                                            <hr>
                                            <div class="form-group">
                                               <!--  <label>Course, Year & Section : </label> <br>
                                                <b> <?php echo $row['course']; ?> </b> -->
                                                <input type="text" hidden="" name="course" value="<?php echo $row['course']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <!-- <label>Requirement : </label> <br>
                                                <b> <?php echo $row['title']; ?> </b> -->
                                                <input type="text" hidden="" name="requirement" value="<?php echo $row['title']; ?>">
                                            </div>
                                            <div class="form-group">
                                               <!--  <label>Instructions : </label> <br> -->
                                                <textarea hidden="" style="background: ghostwhite;" rows="10" name="instructions" class="form-control" id="instructions" aria-describedby="" readonly required=""><?php echo $row['instructions'];?></textarea>
                                            </div>
                                        <!-- </div>
                                        <div class="col-md"> -->
                                            <div class="form-group">
                                                <label>Submitted File</label> : <?php //echo $row['edited_by_student'];?><br>
                                                <b><a href="../students/upload_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File">
                                                 <i class="fa fa-file"></i><?php echo $row['uploaded_file'];?></a>
                                                </b>
                                            </div>
                                            <div class="form-group">
                                                <div class="embed-responsive embed-responsive-1by1">
                                                  <iframe class="embed-responsive-item" src="../students/upload_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                                                </div>
                                            </div>
                                            <hr>
                                            <!-- <div class="form-group">
                                                <label>Status : </label> <br>
                                                <input hidden type="text" name="status" value="<?php echo $row['work_status']; ?>">
                                                <?php 
                                                if ($row['work_status'] == 'pending') {
                                                 echo "<div class='progress'>
                                                          <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' title='15% on progress'></div>
                                                        </div><b>PENDING 15%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' title='25% on progress' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>PENDING 25%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending2') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'></div>
                                                            </div><b>PENDING 50%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending3') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>PENDING 75%</b>";
                                                }

                                                if ($row['work_status'] == 'completed') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>COMPLETED 100%</b>";
                                                }
                                                ?>
                                            </div>
                                            <hr> -->
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
                                            </div> -->
                                            
                                            <!-- <div class="form-group">
                                                <label>Turned In:</label> <br>
                                                <?php
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
                                            <hr>
                                            <div class="form-group">
                                                <i style="color: #1a8cff;" class="fas fa-clock"></i>
                                                <b title="DATE AND TIME SUBMITTED"> <?php $date_time_posted = $_SESSION['datetime222']; echo $date_time_posted; ?> </b>
                                            </div> -->
                                        <!-- </div>
                                       
                                    </div>
                                </div> -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                                <button type="submit" name="forward" class="btn btn-primary">Forward <i class="fas fa-share-square"></i></button>
                            </div>
                          </form> <!-- end of form -->
                        </div>
                      </div>
                    </div>

                </div> 
            <!-- end tag modal -->
            </tr>
            <?php $count1++; } ?> 
          </tbody>
        </table>
    </div>
    
    <?php } 

    else if($_POST['request'] == "Response Letter") {
        $work_stats = "semi-pending";
        $stats = "not archived";
        $submitted = "yes";
        $count = 1;
        $my_fullname_ = $_SESSION['coordinator_fullname_session'];
        $sql = "SELECT * from tbl_students_work where requirement='$request', name_of_teacher='$my_fullname_' and work_status='$work_stats' and submitted='$submitted' and status='$stats' ORDER BY id ASC";
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
                  <th hidden=""> TASK CODE</th>
                  <th hidden="">ID</th>
                  <th>Submitted by</th>
                  <th hidden>Course</th>
                  <th>Requirement</th>
                  <th>Submitted File</th>
                  <th hidden="">Due Date</th>
                  <th>Turned In</th>
                  <th>My Remarks</th>
                  <th>Status</th>
                  <th>Action</th>                      
                </tr>
                <?php } else { echo "No data available in table"; }?>
              </thead>
              <tbody>
                <?php
                    while($row = $query->fetch_assoc()){
                        $id = $row['id'];
                        $task_code = $row['task_code'];
                        $_SESSION['task_id_22'] = $row['id'];
                ?>
                <tr id="tra">
                   <td hidden=""> <?php echo $task_code;?> </td> 
                   <td hidden=""><?php 
                        $_SESSION['t_id_works11'] = $_SESSION['task_id_22'];
                        echo $_SESSION['t_id_works11'];
                    ?>  
                  </td>
                  <td width="20%"><?php echo $row['stud_name_and_id']; ?></td>
                  <td hidden><?php echo $row['course'];?> </td>
                  <td><?php echo $row['title'];?> </td>
                  <td width="25%"><b><a href="../students/upload_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File"><i class="fa fa-file"></i><?php echo $row['uploaded_file'];?></a> </b></td>
                  <td hidden=""><?php echo $row['date_of_submission'];?> </td>
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
                            echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-success'>ON-TIME</span>";;
                        }
                    ?> 
                    </td>
                    <td width="10%">
                    <?php 
                        if ($row['remarks'] == 'waiting') {
                             echo "<span style='font-size: 15px; margin-left: 0px; color: gray;' class='badge badge-pill badge-warning'>ON REVIEW</span>";
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
                                    </div><b>PENDING 25%</b>";
                        }

                        if ($row['work_status'] == 'semi-pending2') {
                             echo "<div class='progress'>
                                      <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'></div>
                                    </div><b>PENDING 50%</b>";
                        }

                        if ($row['work_status'] == 'semi-pending3') {
                             echo "<div class='progress'>
                                      <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                    </div><b>PENDING 75%</b>";
                        }

                        if ($row['work_status'] == 'completed') {
                             echo "<div class='progress'>
                                      <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'></div>
                                    </div><b>COMPLETED 100%</b>";
                        }
                    ?>
                  </td>
                  <td width="10%">
                      <a href="#view<?php echo $id;?>" title="View Submitted Requirement" data-toggle="modal" ><button class="btn btn-info"><i class="fas fa-check-square"></i></button></a>
                      <?php if($row['remarks']=="Approved"){ ?>
                      <a href="#forward<?php echo $id;?>" title="Forward to Program Head" data-toggle="modal" ><button class="btn btn-primary"><i class="fas fa-share-square"></i></button></a>
                       <?php } ?>
                      <!-- <a href="" class='del-btn'><button class="btn btn-danger" title="Delete"><i class="fas fa-trash-alt"></i></button></a> -->
                  </td>

                    <!-- View Modal -->
                    <div class="modal fade bd-example-modal-lg" data-backdrop="static" id="view<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="update_place" aria-hidden="true">
                      <div class="modal-dialog modal-lg" role="document" style="color:  #333333;">
                        <div class="modal-content modal-lg">
                          <div class="modal-header modal-lg">
                            <h5 class="modal-title" id="exampleModalLabel"><h style="color: #0d6efd"><i class="fas fa-file-alt"></i> <?php echo $row['title']; ?> </h><span><?php //echo $row['edited']; ?></span></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-header modal-lg">
                                <p class="modal-title" id="exampleModalLabel">
                                <h title="Date and Time Submitted"><i style="color: #1a8cff;" class="fas fa-clock"></i> <?php echo $row['date_submitted']. " at " . $row['time_submitted']; ?> <?php echo $row['edited_by_student'];?></h></p> 
                            </div>
                          <form action="my_stud_requirements_completed_update.php" method="POST" enctype="multipart/form-data"><!-- form start -->
                          <input type="text" class="form-control" name="id" value="<?php echo $id;?>" hidden>
                          <input type="text" name="task_code" value="<?php echo $task_code;?>" hidden>
                            <div class="modal-body modal-lg">
                                <!-- <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md"> -->
                                            <div class="form-group">
                                                <label>Submitted by: </label> <br>
                                                <b> <?php echo $row['stud_name_and_id']; ?> </b>
                                                <input type="text" name="stud_fullname" value="<?php echo $row['stud_name_and_id']; ?>" hidden>
                                            </div> 
                                            <hr>
                                            <div class="form-group">
                                                <label>Course, Year & Section: </label> <br>
                                                <b> <?php echo $row['course']; ?> </b>
                                            </div>
                                            <div class="form-group">
                                                <!-- <label>Requirement: </label> <br>
                                                <b> <?php echo $row['title']; ?> </b> -->
                                                <input type="text" name="requirement" value="<?php echo $row['title']; ?>" hidden>
                                            </div>
                                            <hr>
                                            <div class="form-group">
                                                <label>Instructions: </label> <br>
                                                <textarea style="background: ghostwhite;" rows="10" name="instructions" class="form-control" id="instructions" aria-describedby="" readonly required=""><?php echo $row['instructions'];?></textarea>
                                            </div>
                                        <!-- </div>
                                        <div class="col-md"> -->
                                            <div class="form-group">
                                                <label>Submitted File</label>: <?php //echo $row['edited_by_student'];?><br>
                                                <b><a href="../students/upload_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File">
                                                <i class="fa fa-file"></i><?php echo $row['uploaded_file'];?></a>
                                                </b>
                                            </div>
                                            <div class="form-group">
                                                <div class="embed-responsive embed-responsive-1by1">
                                                  <iframe class="embed-responsive-item" src="../students/upload_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                                                </div>
                                            </div>
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
                                                            </div><b>PENDING 25%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending2') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'></div>
                                                            </div><b>PENDING 50%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending3') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>PENDING 75%</b>";
                                                }

                                                if ($row['work_status'] == 'completed') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>COMPLETED 100%</b>";
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
                                            <div class="form-group">
                                                <label>Due Date:</label> <br>
                                                <b><?php
                                                    echo $row['date_of_submission'];?></b>
                                            </div>
                                            <hr>
                                            <div class="form-group">
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
                                            <hr>
                                            <!-- <div class="form-group">
                                                <i style="color: #1a8cff;" class="fas fa-clock"></i>
                                                <b title="DATE AND TIME SUBMITTED"> <?php $date_time_posted = $_SESSION['datetime222']; echo $date_time_posted; ?> </b><br>
                                                <?php if ($row['edited_by_student']=="(edited)") {?>
                                                <b><span><i style="color: #1a8cff;" class="fas fa-user-edit"></i><?php echo $row['edited_by_student']; ?></span></b>
                                                <?php } else {
                                                    echo "";
                                                }?>
                                            </div>
                                            <hr> -->
                                            <div class="form-group">
                                                <label>Comment/s:</label> <br>
                                                <textarea style="background: ghostwhite;" readonly="" name="comments" class="form-control" id="comments" rows="5"><?php echo $row['student_comment']; ?></textarea>
                                            </div>
                                        <!-- </div> -->
                                        <!-- <div class="col-md"> -->
                                            <div class="form-group">
                                                <label>My Remarks: </label> <br>
                                                <select style="background: white;" name="remarks" id="remarks" class="form-control">
                                                    <?php
                                                        if($row['remarks']=="Approved"){
                                                            echo "<option name='approved'>Approved</option>";
                                                            echo "<option name='not approved'>Not Approved</option>";
                                                        }

                                                        if($row['remarks']=="Not Approved"){
                                                             echo "<option name='not approved'>Not Approved</option>";
                                                            echo "<option name='approved'>Approved</option>";
                                                        }
                                                        if($row['remarks']=="waiting"){
                                                            echo "<option name='approved'>Approved</option>";
                                                            echo "<option name='not approved'>Not Approved</option>";
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <hr>
                                            <div class="form-group">
                                                <label>My Comments and Suggestions:</label> <br>
                                                <textarea style="background: white;" name="comments" class="form-control" rows="5" id="my_comments" placeholder="Write Your Comments and Suggestions Here (Optional)"><?php echo $row['comment']; ?></textarea>
                                            </div>
                                        <!-- </div>
                                    </div>
                                </div> -->
                            </div>
                            <div class="modal-footer">
                                <?php if($row['remarks']=="Approved"){ ?>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                                <button type="submit" name="submit" class="btn btn-primary">Re-Submit
                                <i class="fas fa-check-square"></i></button> 
                                <button type="submit" name="set_as_completed" class="btn btn-success">Set As Completed <i class="fas fa-check-square"></i></button>
                                <?php } else {?>
                                 <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                                <button type="submit" name="submit" class="btn btn-primary">Submit
                                <i class="fas fa-check-square"></i></button>
                                <?php } ?>
                            </div>
                          </form> <!-- end of form -->
                        </div>
                      </div>
                    </div>

                    <!-- Forward Modal -->
                    <div class="modal fade bd-example-modal-lg" data-backdrop="static" id="forward<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="update_place" aria-hidden="true">
                      <div class="modal-dialog modal-lg" role="document" style="color:  #333333;">
                        <div class="modal-content modal-lg">
                          <div class="modal-header modal-lg">
                            <h5 class="modal-title" id="exampleModalLabel"><h style="color: #0d6efd"><i class="fas fa-share-square"></i> Forward To Program Head / <?php echo $row['title']; ?></h><span><?php //echo $row['edited']; ?></span></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-header modal-lg">
                                <p class="modal-title" id="exampleModalLabel">
                                <h title="Date and Time Submitted"><i style="color: #1a8cff;" class="fas fa-clock"></i> <?php echo $row['date_submitted']. " at " . $row['time_submitted']; ?> <?php echo $row['edited_by_student'];?></h></p> 
                            </div>
                          <form action="my_stud_requirements_completed_update.php" method="POST" enctype="multipart/form-data"><!-- form start -->
                          <input type="text" class="form-control" name="id" value="<?php echo $id;?>" hidden>
                          <!-- task code uniq id -->
                          <input type="text" name="task_code" value="<?php echo $task_code;?>" hidden>
                            <div class="modal-body modal-lg">
                                <!-- <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md"> -->
                                            <div class="form-group">
                                                <label>Submitted by: </label> <br>
                                                <b><?php echo $row['stud_name_and_id']; ?> </b>
                                                <input type="text" hidden="" name="stud_fullname" value="<?php echo $row['stud_name_and_id']; ?>">
                                            </div>
                                            <hr>
                                            <div class="form-group">
                                               <!--  <label>Course, Year & Section : </label> <br>
                                                <b> <?php echo $row['course']; ?> </b> -->
                                                <input type="text" hidden="" name="course" value="<?php echo $row['course']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <!-- <label>Requirement : </label> <br>
                                                <b> <?php echo $row['title']; ?> </b> -->
                                                <input type="text" hidden="" name="requirement" value="<?php echo $row['title']; ?>">
                                            </div>
                                            <div class="form-group">
                                               <!--  <label>Instructions : </label> <br> -->
                                                <textarea hidden="" style="background: ghostwhite;" rows="10" name="instructions" class="form-control" id="instructions" aria-describedby="" readonly required=""><?php echo $row['instructions'];?></textarea>
                                            </div>
                                        <!-- </div>
                                        <div class="col-md"> -->
                                            <div class="form-group">
                                                <label>Submitted File</label> : <?php //echo $row['edited_by_student'];?><br>
                                                <b><a href="../students/upload_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File">
                                                 <i class="fa fa-file"></i><?php echo $row['uploaded_file'];?></a>
                                                </b>
                                            </div>
                                            <div class="form-group">
                                                <div class="embed-responsive embed-responsive-1by1">
                                                  <iframe class="embed-responsive-item" src="../students/upload_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                                                </div>
                                            </div>
                                            <hr>
                                            <!-- <div class="form-group">
                                                <label>Status : </label> <br>
                                                <input hidden type="text" name="status" value="<?php echo $row['work_status']; ?>">
                                                <?php 
                                                if ($row['work_status'] == 'pending') {
                                                 echo "<div class='progress'>
                                                          <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' title='15% on progress'></div>
                                                        </div><b>PENDING 15%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' title='25% on progress' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>PENDING 25%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending2') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'></div>
                                                            </div><b>PENDING 50%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending3') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>PENDING 75%</b>";
                                                }

                                                if ($row['work_status'] == 'completed') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>COMPLETED 100%</b>";
                                                }
                                                ?>
                                            </div>
                                            <hr> -->
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
                                            </div> -->
                                            
                                            <!-- <div class="form-group">
                                                <label>Turned In:</label> <br>
                                                <?php
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
                                            <hr>
                                            <div class="form-group">
                                                <i style="color: #1a8cff;" class="fas fa-clock"></i>
                                                <b title="DATE AND TIME SUBMITTED"> <?php $date_time_posted = $_SESSION['datetime222']; echo $date_time_posted; ?> </b>
                                            </div> -->
                                        <!-- </div>
                                       
                                    </div>
                                </div> -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                                <button type="submit" name="forward" class="btn btn-primary">Forward <i class="fas fa-share-square"></i></button>
                            </div>
                          </form> <!-- end of form -->
                        </div>
                      </div>
                    </div>

                </div> 
            <!-- end tag modal -->
            </tr>
            <?php $count1++; } ?> 
          </tbody>
        </table>
    </div>
    
    <?php } 

    else if($_POST['request'] == "Narrative") {
        $work_stats = "semi-pending";
        $stats = "not archived";
        $submitted = "yes";
        $count = 1;
        $my_fullname_ = $_SESSION['coordinator_fullname_session'];
        $sql = "SELECT * from tbl_students_work where requirement='$request', name_of_teacher='$my_fullname_' and work_status='$work_stats' and submitted='$submitted' and status='$stats' ORDER BY id ASC";
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
                  <th hidden=""> TASK CODE</th>
                  <th hidden="">ID</th>
                  <th>Submitted by</th>
                  <th hidden>Course</th>
                  <th>Requirement</th>
                  <th>Submitted File</th>
                  <th hidden="">Due Date</th>
                  <th>Turned In</th>
                  <th>My Remarks</th>
                  <th>Status</th>
                  <th>Action</th>                      
                </tr>
                <?php } else { echo "No data available in table"; }?>
              </thead>
              <tbody>
                <?php
                    while($row = $query->fetch_assoc()){
                        $id = $row['id'];
                        $task_code = $row['task_code'];
                        $_SESSION['task_id_22'] = $row['id'];
                ?>
                <tr id="tra">
                   <td hidden=""> <?php echo $task_code;?> </td> 
                   <td hidden=""><?php 
                        $_SESSION['t_id_works11'] = $_SESSION['task_id_22'];
                        echo $_SESSION['t_id_works11'];
                    ?>  
                  </td>
                  <td width="20%"><?php echo $row['stud_name_and_id']; ?></td>
                  <td hidden><?php echo $row['course'];?> </td>
                  <td><?php echo $row['title'];?> </td>
                  <td width="25%"><b><a href="../students/upload_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File"><i class="fa fa-file"></i><?php echo $row['uploaded_file'];?></a> </b></td>
                  <td hidden=""><?php echo $row['date_of_submission'];?> </td>
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
                            echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-success'>ON-TIME</span>";;
                        }
                    ?> 
                    </td>
                    <td width="10%">
                    <?php 
                        if ($row['remarks'] == 'waiting') {
                             echo "<span style='font-size: 15px; margin-left: 0px; color: gray;' class='badge badge-pill badge-warning'>ON REVIEW</span>";
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
                                    </div><b>PENDING 25%</b>";
                        }

                        if ($row['work_status'] == 'semi-pending2') {
                             echo "<div class='progress'>
                                      <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'></div>
                                    </div><b>PENDING 50%</b>";
                        }

                        if ($row['work_status'] == 'semi-pending3') {
                             echo "<div class='progress'>
                                      <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                    </div><b>PENDING 75%</b>";
                        }

                        if ($row['work_status'] == 'completed') {
                             echo "<div class='progress'>
                                      <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'></div>
                                    </div><b>COMPLETED 100%</b>";
                        }
                    ?>
                  </td>
                  <td width="10%">
                      <a href="#view<?php echo $id;?>" title="View Submitted Requirement" data-toggle="modal" ><button class="btn btn-info"><i class="fas fa-check-square"></i></button></a>
                      <?php if($row['remarks']=="Approved"){ ?>
                      <a href="#forward<?php echo $id;?>" title="Forward to Program Head" data-toggle="modal" ><button class="btn btn-primary"><i class="fas fa-share-square"></i></button></a>
                       <?php } ?>
                      <!-- <a href="" class='del-btn'><button class="btn btn-danger" title="Delete"><i class="fas fa-trash-alt"></i></button></a> -->
                  </td>

                    <!-- View Modal -->
                    <div class="modal fade bd-example-modal-lg" data-backdrop="static" id="view<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="update_place" aria-hidden="true">
                      <div class="modal-dialog modal-lg" role="document" style="color:  #333333;">
                        <div class="modal-content modal-lg">
                          <div class="modal-header modal-lg">
                            <h5 class="modal-title" id="exampleModalLabel"><h style="color: #0d6efd"><i class="fas fa-file-alt"></i> <?php echo $row['title']; ?> </h><span><?php //echo $row['edited']; ?></span></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-header modal-lg">
                                <p class="modal-title" id="exampleModalLabel">
                                <h title="Date and Time Submitted"><i style="color: #1a8cff;" class="fas fa-clock"></i> <?php echo $row['date_submitted']. " at " . $row['time_submitted']; ?> <?php echo $row['edited_by_student'];?></h></p> 
                            </div>
                          <form action="my_stud_requirements_completed_update.php" method="POST" enctype="multipart/form-data"><!-- form start -->
                          <input type="text" class="form-control" name="id" value="<?php echo $id;?>" hidden>
                          <input type="text" name="task_code" value="<?php echo $task_code;?>" hidden>
                            <div class="modal-body modal-lg">
                                <!-- <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md"> -->
                                            <div class="form-group">
                                                <label>Submitted by: </label> <br>
                                                <b> <?php echo $row['stud_name_and_id']; ?> </b>
                                                <input type="text" name="stud_fullname" value="<?php echo $row['stud_name_and_id']; ?>" hidden>
                                            </div> 
                                            <hr>
                                            <div class="form-group">
                                                <label>Course, Year & Section: </label> <br>
                                                <b> <?php echo $row['course']; ?> </b>
                                            </div>
                                            <div class="form-group">
                                                <!-- <label>Requirement: </label> <br>
                                                <b> <?php echo $row['title']; ?> </b> -->
                                                <input type="text" name="requirement" value="<?php echo $row['title']; ?>" hidden>
                                            </div>
                                            <hr>
                                            <div class="form-group">
                                                <label>Instructions: </label> <br>
                                                <textarea style="background: ghostwhite;" rows="10" name="instructions" class="form-control" id="instructions" aria-describedby="" readonly required=""><?php echo $row['instructions'];?></textarea>
                                            </div>
                                        <!-- </div>
                                        <div class="col-md"> -->
                                            <div class="form-group">
                                                <label>Submitted File</label>: <?php //echo $row['edited_by_student'];?><br>
                                                <b><a href="../students/upload_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File">
                                                <i class="fa fa-file"></i><?php echo $row['uploaded_file'];?></a>
                                                </b>
                                            </div>
                                            <div class="form-group">
                                                <div class="embed-responsive embed-responsive-1by1">
                                                  <iframe class="embed-responsive-item" src="../students/upload_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                                                </div>
                                            </div>
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
                                                            </div><b>PENDING 25%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending2') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'></div>
                                                            </div><b>PENDING 50%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending3') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>PENDING 75%</b>";
                                                }

                                                if ($row['work_status'] == 'completed') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>COMPLETED 100%</b>";
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
                                            <div class="form-group">
                                                <label>Due Date:</label> <br>
                                                <b><?php
                                                    echo $row['date_of_submission'];?></b>
                                            </div>
                                            <hr>
                                            <div class="form-group">
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
                                            <hr>
                                            <!-- <div class="form-group">
                                                <i style="color: #1a8cff;" class="fas fa-clock"></i>
                                                <b title="DATE AND TIME SUBMITTED"> <?php $date_time_posted = $_SESSION['datetime222']; echo $date_time_posted; ?> </b><br>
                                                <?php if ($row['edited_by_student']=="(edited)") {?>
                                                <b><span><i style="color: #1a8cff;" class="fas fa-user-edit"></i><?php echo $row['edited_by_student']; ?></span></b>
                                                <?php } else {
                                                    echo "";
                                                }?>
                                            </div>
                                            <hr> -->
                                            <div class="form-group">
                                                <label>Comment/s:</label> <br>
                                                <textarea style="background: ghostwhite;" readonly="" name="comments" class="form-control" id="comments" rows="5"><?php echo $row['student_comment']; ?></textarea>
                                            </div>
                                        <!-- </div> -->
                                        <!-- <div class="col-md"> -->
                                            <div class="form-group">
                                                <label>My Remarks: </label> <br>
                                                <select style="background: white;" name="remarks" id="remarks" class="form-control">
                                                    <?php
                                                        if($row['remarks']=="Approved"){
                                                            echo "<option name='approved'>Approved</option>";
                                                            echo "<option name='not approved'>Not Approved</option>";
                                                        }

                                                        if($row['remarks']=="Not Approved"){
                                                             echo "<option name='not approved'>Not Approved</option>";
                                                            echo "<option name='approved'>Approved</option>";
                                                        }
                                                        if($row['remarks']=="waiting"){
                                                            echo "<option name='approved'>Approved</option>";
                                                            echo "<option name='not approved'>Not Approved</option>";
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <hr>
                                            <div class="form-group">
                                                <label>My Comments and Suggestions:</label> <br>
                                                <textarea style="background: white;" name="comments" class="form-control" rows="5" id="my_comments" placeholder="Write Your Comments and Suggestions Here (Optional)"><?php echo $row['comment']; ?></textarea>
                                            </div>
                                        <!-- </div>
                                    </div>
                                </div> -->
                            </div>
                            <div class="modal-footer">
                                <?php if($row['remarks']=="Approved"){ ?>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                                <button type="submit" name="submit" class="btn btn-primary">Re-Submit
                                <i class="fas fa-check-square"></i></button> 
                                <button type="submit" name="set_as_completed" class="btn btn-success">Set As Completed <i class="fas fa-check-square"></i></button>
                                <?php } else {?>
                                 <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                                <button type="submit" name="submit" class="btn btn-primary">Submit
                                <i class="fas fa-check-square"></i></button>
                                <?php } ?>
                            </div>
                          </form> <!-- end of form -->
                        </div>
                      </div>
                    </div>

                    <!-- Forward Modal -->
                    <div class="modal fade bd-example-modal-lg" data-backdrop="static" id="forward<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="update_place" aria-hidden="true">
                      <div class="modal-dialog modal-lg" role="document" style="color:  #333333;">
                        <div class="modal-content modal-lg">
                          <div class="modal-header modal-lg">
                            <h5 class="modal-title" id="exampleModalLabel"><h style="color: #0d6efd"><i class="fas fa-share-square"></i> Forward To Program Head / <?php echo $row['title']; ?></h><span><?php //echo $row['edited']; ?></span></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-header modal-lg">
                                <p class="modal-title" id="exampleModalLabel">
                                <h title="Date and Time Submitted"><i style="color: #1a8cff;" class="fas fa-clock"></i> <?php echo $row['date_submitted']. " at " . $row['time_submitted']; ?> <?php echo $row['edited_by_student'];?></h></p> 
                            </div>
                          <form action="my_stud_requirements_completed_update.php" method="POST" enctype="multipart/form-data"><!-- form start -->
                          <input type="text" class="form-control" name="id" value="<?php echo $id;?>" hidden>
                          <!-- task code uniq id -->
                          <input type="text" name="task_code" value="<?php echo $task_code;?>" hidden>
                            <div class="modal-body modal-lg">
                                <!-- <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md"> -->
                                            <div class="form-group">
                                                <label>Submitted by: </label> <br>
                                                <b><?php echo $row['stud_name_and_id']; ?> </b>
                                                <input type="text" hidden="" name="stud_fullname" value="<?php echo $row['stud_name_and_id']; ?>">
                                            </div>
                                            <hr>
                                            <div class="form-group">
                                               <!--  <label>Course, Year & Section : </label> <br>
                                                <b> <?php echo $row['course']; ?> </b> -->
                                                <input type="text" hidden="" name="course" value="<?php echo $row['course']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <!-- <label>Requirement : </label> <br>
                                                <b> <?php echo $row['title']; ?> </b> -->
                                                <input type="text" hidden="" name="requirement" value="<?php echo $row['title']; ?>">
                                            </div>
                                            <div class="form-group">
                                               <!--  <label>Instructions : </label> <br> -->
                                                <textarea hidden="" style="background: ghostwhite;" rows="10" name="instructions" class="form-control" id="instructions" aria-describedby="" readonly required=""><?php echo $row['instructions'];?></textarea>
                                            </div>
                                        <!-- </div>
                                        <div class="col-md"> -->
                                            <div class="form-group">
                                                <label>Submitted File</label> : <?php //echo $row['edited_by_student'];?><br>
                                                <b><a href="../students/upload_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File">
                                                 <i class="fa fa-file"></i><?php echo $row['uploaded_file'];?></a>
                                                </b>
                                            </div>
                                            <div class="form-group">
                                                <div class="embed-responsive embed-responsive-1by1">
                                                  <iframe class="embed-responsive-item" src="../students/upload_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                                                </div>
                                            </div>
                                            <hr>
                                            <!-- <div class="form-group">
                                                <label>Status : </label> <br>
                                                <input hidden type="text" name="status" value="<?php echo $row['work_status']; ?>">
                                                <?php 
                                                if ($row['work_status'] == 'pending') {
                                                 echo "<div class='progress'>
                                                          <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' title='15% on progress'></div>
                                                        </div><b>PENDING 15%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' title='25% on progress' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>PENDING 25%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending2') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'></div>
                                                            </div><b>PENDING 50%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending3') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>PENDING 75%</b>";
                                                }

                                                if ($row['work_status'] == 'completed') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>COMPLETED 100%</b>";
                                                }
                                                ?>
                                            </div>
                                            <hr> -->
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
                                            </div> -->
                                            
                                            <!-- <div class="form-group">
                                                <label>Turned In:</label> <br>
                                                <?php
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
                                            <hr>
                                            <div class="form-group">
                                                <i style="color: #1a8cff;" class="fas fa-clock"></i>
                                                <b title="DATE AND TIME SUBMITTED"> <?php $date_time_posted = $_SESSION['datetime222']; echo $date_time_posted; ?> </b>
                                            </div> -->
                                        <!-- </div>
                                       
                                    </div>
                                </div> -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                                <button type="submit" name="forward" class="btn btn-primary">Forward <i class="fas fa-share-square"></i></button>
                            </div>
                          </form> <!-- end of form -->
                        </div>
                      </div>
                    </div>

                </div> 
            <!-- end tag modal -->
            </tr>
            <?php $count1++; } ?> 
          </tbody>
        </table>
    </div>
    
    <?php } 

    else if($_POST['request'] == "Performance Sheet") {
        $work_stats = "semi-pending";
        $stats = "not archived";
        $submitted = "yes";
        $count = 1;
        $my_fullname_ = $_SESSION['coordinator_fullname_session'];
        $sql = "SELECT * from tbl_students_work where requirement='$request', name_of_teacher='$my_fullname_' and work_status='$work_stats' and submitted='$submitted' and status='$stats' ORDER BY id ASC";
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
                  <th hidden=""> TASK CODE</th>
                  <th hidden="">ID</th>
                  <th>Submitted by</th>
                  <th hidden>Course</th>
                  <th>Requirement</th>
                  <th>Submitted File</th>
                  <th hidden="">Due Date</th>
                  <th>Turned In</th>
                  <th>My Remarks</th>
                  <th>Status</th>
                  <th>Action</th>                      
                </tr>
                <?php } else { echo "No data available in table"; }?>
              </thead>
              <tbody>
                <?php
                    while($row = $query->fetch_assoc()){
                        $id = $row['id'];
                        $task_code = $row['task_code'];
                        $_SESSION['task_id_22'] = $row['id'];
                ?>
                <tr id="tra">
                   <td hidden=""> <?php echo $task_code;?> </td> 
                   <td hidden=""><?php 
                        $_SESSION['t_id_works11'] = $_SESSION['task_id_22'];
                        echo $_SESSION['t_id_works11'];
                    ?>  
                  </td>
                  <td width="20%"><?php echo $row['stud_name_and_id']; ?></td>
                  <td hidden><?php echo $row['course'];?> </td>
                  <td><?php echo $row['title'];?> </td>
                  <td width="25%"><b><a href="../students/upload_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File"><i class="fa fa-file"></i><?php echo $row['uploaded_file'];?></a> </b></td>
                  <td hidden=""><?php echo $row['date_of_submission'];?> </td>
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
                            echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-success'>ON-TIME</span>";;
                        }
                    ?> 
                    </td>
                    <td width="10%">
                    <?php 
                        if ($row['remarks'] == 'waiting') {
                             echo "<span style='font-size: 15px; margin-left: 0px; color: gray;' class='badge badge-pill badge-warning'>ON REVIEW</span>";
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
                                    </div><b>PENDING 25%</b>";
                        }

                        if ($row['work_status'] == 'semi-pending2') {
                             echo "<div class='progress'>
                                      <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'></div>
                                    </div><b>PENDING 50%</b>";
                        }

                        if ($row['work_status'] == 'semi-pending3') {
                             echo "<div class='progress'>
                                      <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                    </div><b>PENDING 75%</b>";
                        }

                        if ($row['work_status'] == 'completed') {
                             echo "<div class='progress'>
                                      <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'></div>
                                    </div><b>COMPLETED 100%</b>";
                        }
                    ?>
                  </td>
                  <td width="10%">
                      <a href="#view<?php echo $id;?>" title="View Submitted Requirement" data-toggle="modal" ><button class="btn btn-info"><i class="fas fa-check-square"></i></button></a>
                      <?php if($row['remarks']=="Approved"){ ?>
                      <a href="#forward<?php echo $id;?>" title="Forward to Program Head" data-toggle="modal" ><button class="btn btn-primary"><i class="fas fa-share-square"></i></button></a>
                       <?php } ?>
                      <!-- <a href="" class='del-btn'><button class="btn btn-danger" title="Delete"><i class="fas fa-trash-alt"></i></button></a> -->
                  </td>

                    <!-- View Modal -->
                    <div class="modal fade bd-example-modal-lg" data-backdrop="static" id="view<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="update_place" aria-hidden="true">
                      <div class="modal-dialog modal-lg" role="document" style="color:  #333333;">
                        <div class="modal-content modal-lg">
                          <div class="modal-header modal-lg">
                            <h5 class="modal-title" id="exampleModalLabel"><h style="color: #0d6efd"><i class="fas fa-file-alt"></i> <?php echo $row['title']; ?> </h><span><?php //echo $row['edited']; ?></span></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-header modal-lg">
                                <p class="modal-title" id="exampleModalLabel">
                                <h title="Date and Time Submitted"><i style="color: #1a8cff;" class="fas fa-clock"></i> <?php echo $row['date_submitted']. " at " . $row['time_submitted']; ?> <?php echo $row['edited_by_student'];?></h></p> 
                            </div>
                          <form action="my_stud_requirements_completed_update.php" method="POST" enctype="multipart/form-data"><!-- form start -->
                          <input type="text" class="form-control" name="id" value="<?php echo $id;?>" hidden>
                          <input type="text" name="task_code" value="<?php echo $task_code;?>" hidden>
                            <div class="modal-body modal-lg">
                                <!-- <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md"> -->
                                            <div class="form-group">
                                                <label>Submitted by: </label> <br>
                                                <b> <?php echo $row['stud_name_and_id']; ?> </b>
                                                <input type="text" name="stud_fullname" value="<?php echo $row['stud_name_and_id']; ?>" hidden>
                                            </div> 
                                            <hr>
                                            <div class="form-group">
                                                <label>Course, Year & Section: </label> <br>
                                                <b> <?php echo $row['course']; ?> </b>
                                            </div>
                                            <div class="form-group">
                                                <!-- <label>Requirement: </label> <br>
                                                <b> <?php echo $row['title']; ?> </b> -->
                                                <input type="text" name="requirement" value="<?php echo $row['title']; ?>" hidden>
                                            </div>
                                            <hr>
                                            <div class="form-group">
                                                <label>Instructions: </label> <br>
                                                <textarea style="background: ghostwhite;" rows="10" name="instructions" class="form-control" id="instructions" aria-describedby="" readonly required=""><?php echo $row['instructions'];?></textarea>
                                            </div>
                                        <!-- </div>
                                        <div class="col-md"> -->
                                            <div class="form-group">
                                                <label>Submitted File</label>: <?php //echo $row['edited_by_student'];?><br>
                                                <b><a href="../students/upload_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File">
                                                <i class="fa fa-file"></i><?php echo $row['uploaded_file'];?></a>
                                                </b>
                                            </div>
                                            <div class="form-group">
                                                <div class="embed-responsive embed-responsive-1by1">
                                                  <iframe class="embed-responsive-item" src="../students/upload_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                                                </div>
                                            </div>
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
                                                            </div><b>PENDING 25%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending2') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'></div>
                                                            </div><b>PENDING 50%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending3') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>PENDING 75%</b>";
                                                }

                                                if ($row['work_status'] == 'completed') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>COMPLETED 100%</b>";
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
                                            <div class="form-group">
                                                <label>Due Date:</label> <br>
                                                <b><?php
                                                    echo $row['date_of_submission'];?></b>
                                            </div>
                                            <hr>
                                            <div class="form-group">
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
                                            <hr>
                                            <!-- <div class="form-group">
                                                <i style="color: #1a8cff;" class="fas fa-clock"></i>
                                                <b title="DATE AND TIME SUBMITTED"> <?php $date_time_posted = $_SESSION['datetime222']; echo $date_time_posted; ?> </b><br>
                                                <?php if ($row['edited_by_student']=="(edited)") {?>
                                                <b><span><i style="color: #1a8cff;" class="fas fa-user-edit"></i><?php echo $row['edited_by_student']; ?></span></b>
                                                <?php } else {
                                                    echo "";
                                                }?>
                                            </div>
                                            <hr> -->
                                            <div class="form-group">
                                                <label>Comment/s:</label> <br>
                                                <textarea style="background: ghostwhite;" readonly="" name="comments" class="form-control" id="comments" rows="5"><?php echo $row['student_comment']; ?></textarea>
                                            </div>
                                        <!-- </div> -->
                                        <!-- <div class="col-md"> -->
                                            <div class="form-group">
                                                <label>My Remarks: </label> <br>
                                                <select style="background: white;" name="remarks" id="remarks" class="form-control">
                                                    <?php
                                                        if($row['remarks']=="Approved"){
                                                            echo "<option name='approved'>Approved</option>";
                                                            echo "<option name='not approved'>Not Approved</option>";
                                                        }

                                                        if($row['remarks']=="Not Approved"){
                                                             echo "<option name='not approved'>Not Approved</option>";
                                                            echo "<option name='approved'>Approved</option>";
                                                        }
                                                        if($row['remarks']=="waiting"){
                                                            echo "<option name='approved'>Approved</option>";
                                                            echo "<option name='not approved'>Not Approved</option>";
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <hr>
                                            <div class="form-group">
                                                <label>My Comments and Suggestions:</label> <br>
                                                <textarea style="background: white;" name="comments" class="form-control" rows="5" id="my_comments" placeholder="Write Your Comments and Suggestions Here (Optional)"><?php echo $row['comment']; ?></textarea>
                                            </div>
                                        <!-- </div>
                                    </div>
                                </div> -->
                            </div>
                            <div class="modal-footer">
                                <?php if($row['remarks']=="Approved"){ ?>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                                <button type="submit" name="submit" class="btn btn-primary">Re-Submit
                                <i class="fas fa-check-square"></i></button> 
                                <button type="submit" name="set_as_completed" class="btn btn-success">Set As Completed <i class="fas fa-check-square"></i></button>
                                <?php } else {?>
                                 <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                                <button type="submit" name="submit" class="btn btn-primary">Submit
                                <i class="fas fa-check-square"></i></button>
                                <?php } ?>
                            </div>
                          </form> <!-- end of form -->
                        </div>
                      </div>
                    </div>

                    <!-- Forward Modal -->
                    <div class="modal fade bd-example-modal-lg" data-backdrop="static" id="forward<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="update_place" aria-hidden="true">
                      <div class="modal-dialog modal-lg" role="document" style="color:  #333333;">
                        <div class="modal-content modal-lg">
                          <div class="modal-header modal-lg">
                            <h5 class="modal-title" id="exampleModalLabel"><h style="color: #0d6efd"><i class="fas fa-share-square"></i> Forward To Program Head / <?php echo $row['title']; ?></h><span><?php //echo $row['edited']; ?></span></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-header modal-lg">
                                <p class="modal-title" id="exampleModalLabel">
                                <h title="Date and Time Submitted"><i style="color: #1a8cff;" class="fas fa-clock"></i> <?php echo $row['date_submitted']. " at " . $row['time_submitted']; ?> <?php echo $row['edited_by_student'];?></h></p> 
                            </div>
                          <form action="my_stud_requirements_completed_update.php" method="POST" enctype="multipart/form-data"><!-- form start -->
                          <input type="text" class="form-control" name="id" value="<?php echo $id;?>" hidden>
                          <!-- task code uniq id -->
                          <input type="text" name="task_code" value="<?php echo $task_code;?>" hidden>
                            <div class="modal-body modal-lg">
                                <!-- <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md"> -->
                                            <div class="form-group">
                                                <label>Submitted by: </label> <br>
                                                <b><?php echo $row['stud_name_and_id']; ?> </b>
                                                <input type="text" hidden="" name="stud_fullname" value="<?php echo $row['stud_name_and_id']; ?>">
                                            </div>
                                            <hr>
                                            <div class="form-group">
                                               <!--  <label>Course, Year & Section : </label> <br>
                                                <b> <?php echo $row['course']; ?> </b> -->
                                                <input type="text" hidden="" name="course" value="<?php echo $row['course']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <!-- <label>Requirement : </label> <br>
                                                <b> <?php echo $row['title']; ?> </b> -->
                                                <input type="text" hidden="" name="requirement" value="<?php echo $row['title']; ?>">
                                            </div>
                                            <div class="form-group">
                                               <!--  <label>Instructions : </label> <br> -->
                                                <textarea hidden="" style="background: ghostwhite;" rows="10" name="instructions" class="form-control" id="instructions" aria-describedby="" readonly required=""><?php echo $row['instructions'];?></textarea>
                                            </div>
                                        <!-- </div>
                                        <div class="col-md"> -->
                                            <div class="form-group">
                                                <label>Submitted File</label> : <?php //echo $row['edited_by_student'];?><br>
                                                <b><a href="../students/upload_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File">
                                                 <i class="fa fa-file"></i><?php echo $row['uploaded_file'];?></a>
                                                </b>
                                            </div>
                                            <div class="form-group">
                                                <div class="embed-responsive embed-responsive-1by1">
                                                  <iframe class="embed-responsive-item" src="../students/upload_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                                                </div>
                                            </div>
                                            <hr>
                                            <!-- <div class="form-group">
                                                <label>Status : </label> <br>
                                                <input hidden type="text" name="status" value="<?php echo $row['work_status']; ?>">
                                                <?php 
                                                if ($row['work_status'] == 'pending') {
                                                 echo "<div class='progress'>
                                                          <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' title='15% on progress'></div>
                                                        </div><b>PENDING 15%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' title='25% on progress' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>PENDING 25%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending2') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'></div>
                                                            </div><b>PENDING 50%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending3') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>PENDING 75%</b>";
                                                }

                                                if ($row['work_status'] == 'completed') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>COMPLETED 100%</b>";
                                                }
                                                ?>
                                            </div>
                                            <hr> -->
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
                                            </div> -->
                                            
                                            <!-- <div class="form-group">
                                                <label>Turned In:</label> <br>
                                                <?php
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
                                            <hr>
                                            <div class="form-group">
                                                <i style="color: #1a8cff;" class="fas fa-clock"></i>
                                                <b title="DATE AND TIME SUBMITTED"> <?php $date_time_posted = $_SESSION['datetime222']; echo $date_time_posted; ?> </b>
                                            </div> -->
                                        <!-- </div>
                                       
                                    </div>
                                </div> -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                                <button type="submit" name="forward" class="btn btn-primary">Forward <i class="fas fa-share-square"></i></button>
                            </div>
                          </form> <!-- end of form -->
                        </div>
                      </div>
                    </div>

                </div> 
            <!-- end tag modal -->
            </tr>
            <?php $count1++; } ?> 
          </tbody>
        </table>
    </div>
    
    <?php } 

    else if($_POST['request'] == "Endorsement Letter") {
        $work_stats = "semi-pending";
        $stats = "not archived";
        $submitted = "yes";
        $count = 1;
        $my_fullname_ = $_SESSION['coordinator_fullname_session'];
        $sql = "SELECT * from tbl_students_work where requirement='$request', name_of_teacher='$my_fullname_' and work_status='$work_stats' and submitted='$submitted' and status='$stats' ORDER BY id ASC";
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
                  <th hidden=""> TASK CODE</th>
                  <th hidden="">ID</th>
                  <th>Submitted by</th>
                  <th hidden>Course</th>
                  <th>Requirement</th>
                  <th>Submitted File</th>
                  <th hidden="">Due Date</th>
                  <th>Turned In</th>
                  <th>My Remarks</th>
                  <th>Status</th>
                  <th>Action</th>                      
                </tr>
                <?php } else { echo "No data available in table"; }?>
              </thead>
              <tbody>
                <?php
                    while($row = $query->fetch_assoc()){
                        $id = $row['id'];
                        $task_code = $row['task_code'];
                        $_SESSION['task_id_22'] = $row['id'];
                ?>
                <tr id="tra">
                   <td hidden=""> <?php echo $task_code;?> </td> 
                   <td hidden=""><?php 
                        $_SESSION['t_id_works11'] = $_SESSION['task_id_22'];
                        echo $_SESSION['t_id_works11'];
                    ?>  
                  </td>
                  <td width="20%"><?php echo $row['stud_name_and_id']; ?></td>
                  <td hidden><?php echo $row['course'];?> </td>
                  <td><?php echo $row['title'];?> </td>
                  <td width="25%"><b><a href="../students/upload_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File"><i class="fa fa-file"></i><?php echo $row['uploaded_file'];?></a> </b></td>
                  <td hidden=""><?php echo $row['date_of_submission'];?> </td>
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
                            echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-success'>ON-TIME</span>";;
                        }
                    ?> 
                    </td>
                    <td width="10%">
                    <?php 
                        if ($row['remarks'] == 'waiting') {
                             echo "<span style='font-size: 15px; margin-left: 0px; color: gray;' class='badge badge-pill badge-warning'>ON REVIEW</span>";
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
                                    </div><b>PENDING 25%</b>";
                        }

                        if ($row['work_status'] == 'semi-pending2') {
                             echo "<div class='progress'>
                                      <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'></div>
                                    </div><b>PENDING 50%</b>";
                        }

                        if ($row['work_status'] == 'semi-pending3') {
                             echo "<div class='progress'>
                                      <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                    </div><b>PENDING 75%</b>";
                        }

                        if ($row['work_status'] == 'completed') {
                             echo "<div class='progress'>
                                      <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'></div>
                                    </div><b>COMPLETED 100%</b>";
                        }
                    ?>
                  </td>
                  <td width="10%">
                      <a href="#view<?php echo $id;?>" title="View Submitted Requirement" data-toggle="modal" ><button class="btn btn-info"><i class="fas fa-check-square"></i></button></a>
                      <?php if($row['remarks']=="Approved"){ ?>
                      <a href="#forward<?php echo $id;?>" title="Forward to Program Head" data-toggle="modal" ><button class="btn btn-primary"><i class="fas fa-share-square"></i></button></a>
                       <?php } ?>
                      <!-- <a href="" class='del-btn'><button class="btn btn-danger" title="Delete"><i class="fas fa-trash-alt"></i></button></a> -->
                  </td>

                    <!-- View Modal -->
                    <div class="modal fade bd-example-modal-lg" data-backdrop="static" id="view<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="update_place" aria-hidden="true">
                      <div class="modal-dialog modal-lg" role="document" style="color:  #333333;">
                        <div class="modal-content modal-lg">
                          <div class="modal-header modal-lg">
                            <h5 class="modal-title" id="exampleModalLabel"><h style="color: #0d6efd"><i class="fas fa-file-alt"></i> <?php echo $row['title']; ?> </h><span><?php //echo $row['edited']; ?></span></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-header modal-lg">
                                <p class="modal-title" id="exampleModalLabel">
                                <h title="Date and Time Submitted"><i style="color: #1a8cff;" class="fas fa-clock"></i> <?php echo $row['date_submitted']. " at " . $row['time_submitted']; ?> <?php echo $row['edited_by_student'];?></h></p> 
                            </div>
                          <form action="my_stud_requirements_completed_update.php" method="POST" enctype="multipart/form-data"><!-- form start -->
                          <input type="text" class="form-control" name="id" value="<?php echo $id;?>" hidden>
                          <input type="text" name="task_code" value="<?php echo $task_code;?>" hidden>
                            <div class="modal-body modal-lg">
                                <!-- <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md"> -->
                                            <div class="form-group">
                                                <label>Submitted by: </label> <br>
                                                <b> <?php echo $row['stud_name_and_id']; ?> </b>
                                                <input type="text" name="stud_fullname" value="<?php echo $row['stud_name_and_id']; ?>" hidden>
                                            </div> 
                                            <hr>
                                            <div class="form-group">
                                                <label>Course, Year & Section: </label> <br>
                                                <b> <?php echo $row['course']; ?> </b>
                                            </div>
                                            <div class="form-group">
                                                <!-- <label>Requirement: </label> <br>
                                                <b> <?php echo $row['title']; ?> </b> -->
                                                <input type="text" name="requirement" value="<?php echo $row['title']; ?>" hidden>
                                            </div>
                                            <hr>
                                            <div class="form-group">
                                                <label>Instructions: </label> <br>
                                                <textarea style="background: ghostwhite;" rows="10" name="instructions" class="form-control" id="instructions" aria-describedby="" readonly required=""><?php echo $row['instructions'];?></textarea>
                                            </div>
                                        <!-- </div>
                                        <div class="col-md"> -->
                                            <div class="form-group">
                                                <label>Submitted File</label>: <?php //echo $row['edited_by_student'];?><br>
                                                <b><a href="../students/upload_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File">
                                                <i class="fa fa-file"></i><?php echo $row['uploaded_file'];?></a>
                                                </b>
                                            </div>
                                            <div class="form-group">
                                                <div class="embed-responsive embed-responsive-1by1">
                                                  <iframe class="embed-responsive-item" src="../students/upload_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                                                </div>
                                            </div>
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
                                                            </div><b>PENDING 25%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending2') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'></div>
                                                            </div><b>PENDING 50%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending3') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>PENDING 75%</b>";
                                                }

                                                if ($row['work_status'] == 'completed') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>COMPLETED 100%</b>";
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
                                            <div class="form-group">
                                                <label>Due Date:</label> <br>
                                                <b><?php
                                                    echo $row['date_of_submission'];?></b>
                                            </div>
                                            <hr>
                                            <div class="form-group">
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
                                            <hr>
                                            <!-- <div class="form-group">
                                                <i style="color: #1a8cff;" class="fas fa-clock"></i>
                                                <b title="DATE AND TIME SUBMITTED"> <?php $date_time_posted = $_SESSION['datetime222']; echo $date_time_posted; ?> </b><br>
                                                <?php if ($row['edited_by_student']=="(edited)") {?>
                                                <b><span><i style="color: #1a8cff;" class="fas fa-user-edit"></i><?php echo $row['edited_by_student']; ?></span></b>
                                                <?php } else {
                                                    echo "";
                                                }?>
                                            </div>
                                            <hr> -->
                                            <div class="form-group">
                                                <label>Comment/s:</label> <br>
                                                <textarea style="background: ghostwhite;" readonly="" name="comments" class="form-control" id="comments" rows="5"><?php echo $row['student_comment']; ?></textarea>
                                            </div>
                                        <!-- </div> -->
                                        <!-- <div class="col-md"> -->
                                            <div class="form-group">
                                                <label>My Remarks: </label> <br>
                                                <select style="background: white;" name="remarks" id="remarks" class="form-control">
                                                    <?php
                                                        if($row['remarks']=="Approved"){
                                                            echo "<option name='approved'>Approved</option>";
                                                            echo "<option name='not approved'>Not Approved</option>";
                                                        }

                                                        if($row['remarks']=="Not Approved"){
                                                             echo "<option name='not approved'>Not Approved</option>";
                                                            echo "<option name='approved'>Approved</option>";
                                                        }
                                                        if($row['remarks']=="waiting"){
                                                            echo "<option name='approved'>Approved</option>";
                                                            echo "<option name='not approved'>Not Approved</option>";
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <hr>
                                            <div class="form-group">
                                                <label>My Comments and Suggestions:</label> <br>
                                                <textarea style="background: white;" name="comments" class="form-control" rows="5" id="my_comments" placeholder="Write Your Comments and Suggestions Here (Optional)"><?php echo $row['comment']; ?></textarea>
                                            </div>
                                        <!-- </div>
                                    </div>
                                </div> -->
                            </div>
                            <div class="modal-footer">
                                <?php if($row['remarks']=="Approved"){ ?>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                                <button type="submit" name="submit" class="btn btn-primary">Re-Submit
                                <i class="fas fa-check-square"></i></button> 
                                <button type="submit" name="set_as_completed" class="btn btn-success">Set As Completed <i class="fas fa-check-square"></i></button>
                                <?php } else {?>
                                 <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                                <button type="submit" name="submit" class="btn btn-primary">Submit
                                <i class="fas fa-check-square"></i></button>
                                <?php } ?>
                            </div>
                          </form> <!-- end of form -->
                        </div>
                      </div>
                    </div>

                    <!-- Forward Modal -->
                    <div class="modal fade bd-example-modal-lg" data-backdrop="static" id="forward<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="update_place" aria-hidden="true">
                      <div class="modal-dialog modal-lg" role="document" style="color:  #333333;">
                        <div class="modal-content modal-lg">
                          <div class="modal-header modal-lg">
                            <h5 class="modal-title" id="exampleModalLabel"><h style="color: #0d6efd"><i class="fas fa-share-square"></i> Forward To Program Head / <?php echo $row['title']; ?></h><span><?php //echo $row['edited']; ?></span></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-header modal-lg">
                                <p class="modal-title" id="exampleModalLabel">
                                <h title="Date and Time Submitted"><i style="color: #1a8cff;" class="fas fa-clock"></i> <?php echo $row['date_submitted']. " at " . $row['time_submitted']; ?> <?php echo $row['edited_by_student'];?></h></p> 
                            </div>
                          <form action="my_stud_requirements_completed_update.php" method="POST" enctype="multipart/form-data"><!-- form start -->
                          <input type="text" class="form-control" name="id" value="<?php echo $id;?>" hidden>
                          <!-- task code uniq id -->
                          <input type="text" name="task_code" value="<?php echo $task_code;?>" hidden>
                            <div class="modal-body modal-lg">
                                <!-- <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md"> -->
                                            <div class="form-group">
                                                <label>Submitted by: </label> <br>
                                                <b><?php echo $row['stud_name_and_id']; ?> </b>
                                                <input type="text" hidden="" name="stud_fullname" value="<?php echo $row['stud_name_and_id']; ?>">
                                            </div>
                                            <hr>
                                            <div class="form-group">
                                               <!--  <label>Course, Year & Section : </label> <br>
                                                <b> <?php echo $row['course']; ?> </b> -->
                                                <input type="text" hidden="" name="course" value="<?php echo $row['course']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <!-- <label>Requirement : </label> <br>
                                                <b> <?php echo $row['title']; ?> </b> -->
                                                <input type="text" hidden="" name="requirement" value="<?php echo $row['title']; ?>">
                                            </div>
                                            <div class="form-group">
                                               <!--  <label>Instructions : </label> <br> -->
                                                <textarea hidden="" style="background: ghostwhite;" rows="10" name="instructions" class="form-control" id="instructions" aria-describedby="" readonly required=""><?php echo $row['instructions'];?></textarea>
                                            </div>
                                        <!-- </div>
                                        <div class="col-md"> -->
                                            <div class="form-group">
                                                <label>Submitted File</label> : <?php //echo $row['edited_by_student'];?><br>
                                                <b><a href="../students/upload_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File">
                                                 <i class="fa fa-file"></i><?php echo $row['uploaded_file'];?></a>
                                                </b>
                                            </div>
                                            <div class="form-group">
                                                <div class="embed-responsive embed-responsive-1by1">
                                                  <iframe class="embed-responsive-item" src="../students/upload_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                                                </div>
                                            </div>
                                            <hr>
                                            <!-- <div class="form-group">
                                                <label>Status : </label> <br>
                                                <input hidden type="text" name="status" value="<?php echo $row['work_status']; ?>">
                                                <?php 
                                                if ($row['work_status'] == 'pending') {
                                                 echo "<div class='progress'>
                                                          <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' title='15% on progress'></div>
                                                        </div><b>PENDING 15%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' title='25% on progress' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>PENDING 25%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending2') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'></div>
                                                            </div><b>PENDING 50%</b>";
                                                }

                                                if ($row['work_status'] == 'semi-pending3') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>PENDING 75%</b>";
                                                }

                                                if ($row['work_status'] == 'completed') {
                                                     echo "<div class='progress'>
                                                              <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'></div>
                                                            </div><b>COMPLETED 100%</b>";
                                                }
                                                ?>
                                            </div>
                                            <hr> -->
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
                                            </div> -->
                                            
                                            <!-- <div class="form-group">
                                                <label>Turned In:</label> <br>
                                                <?php
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
                                            <hr>
                                            <div class="form-group">
                                                <i style="color: #1a8cff;" class="fas fa-clock"></i>
                                                <b title="DATE AND TIME SUBMITTED"> <?php $date_time_posted = $_SESSION['datetime222']; echo $date_time_posted; ?> </b>
                                            </div> -->
                                        <!-- </div>
                                       
                                    </div>
                                </div> -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                                <button type="submit" name="forward" class="btn btn-primary">Forward <i class="fas fa-share-square"></i></button>
                            </div>
                          </form> <!-- end of form -->
                        </div>
                      </div>
                    </div>

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