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
$not_archived = "not archive";
$request = $_POST['request2']; //selected value on dropdown list
if (isset($_POST['request2'])) {
    if ($_POST['request2'] == "") {
        $work_stats1 = "completed";
        $stats = "not archived";
        $submitted = "yes";
        $count1 = 1; //count loop of numbers in table
        $sql = "SELECT * from tbl_students_work where 
            (work_status='$work_stats1' and submitted='$submitted' and status='$stats')
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
                      <th hidden=""> TASK CODE</th>
                      <th hidden="">ID</th>
                      <th>Student</th>
                      <th>Course, Year & Section</th>
                      <th>Document</th>
                      <th>Status</th> 
                      <th>Action</th>  
                  </center>
                    </tr>
                    <?php } else { echo "No data available in table"; }?>
                  </thead>
                  <tbody>
                    <?php
                        while($row = mysqli_fetch_assoc($query)) {
                        $id = $row['stud_id'];
                        $status = $row['status'];
                    ?>
                    <tr id="tra">
                       <td hidden=""><?php echo $task_code;?> </td> 
                       <td hidden=""><?php 
                            $_SESSION['t_id_works11'] = $_SESSION['task_id_22'];
                            echo $_SESSION['t_id_works11'];
                        ?>  
                      </td>
                     <!--  <td><?php echo $count; ?> </td> -->
                      <td width="20%"><?php echo $row['stud_name_and_id']; ?></td>
                      <td width="30%"><?php echo $row['course'];?></td>
                      <td width="20%"><?php echo $row['title'];?><br><?php if($row['title'] == "Recommendation Letter") {?><b><a href="signed_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File"><i class="fas fa-file"></i><?php echo $row['uploaded_file'];?></a> <?php } else {?> <b><a href="../students/upload_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File"><i class="fas fa-file"></i><?php echo $row['uploaded_file'];?></a></b><?php } ?></td>
                      <td width="20%">
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
                      <td>
                          <a href="#view<?php echo $id;?>" data-toggle="modal" data-id="" class="btn btn-info" title="View Student's Info"><i class="fas fa-eye"></i></a>
                      </td>
                    </tr>

                        <!-- View Modal -->
                        <div class="modal fade bd-example-modal-lg" data-backdrop="static" id="view<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="update_place" aria-hidden="true">
                          <div class="modal-dialog modal-lg" role="document" style="color:  #333333;">
                            <div class="modal-content modal-lg">
                              <div class="modal-header modal-lg">
                                <h5 class="modal-title" id="exampleModalLabel"><h style="color: #0d6efd"><i class="fas fa-file-alt"></i> <?php echo $row['title']; ?></h><span><?php //echo $row['edited']; ?></span></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <form action="" method="POST" enctype="multipart/form-data"><!-- form start -->
                              <input type="text" class="form-control" name="id" value="<?php echo $id;?>" hidden>
                              <input type="text" name="task_code" value="<?php echo $task_code;?>" hidden>
                                <div class="modal-body modal-lg">
                                    <div class="form-group">
                                        <label>Submitted by : </label> <br>
                                        <b> <?php echo $row['stud_name_and_id']; ?> </b>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <label>Course, Year & Section : </label> <br>
                                        <b> <?php echo $row['course']; ?> </b>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <label>Signed Document</label>: <br>
                                        <b><a href="signed_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File">
                                            <i class="fas fa-file-signature"></i><?php echo $row['uploaded_file'];?></a>
                                        </b>
                                        <input type="text" value="<?php echo $row['uploaded_file'];?>" name="signed_document" hidden required>
                                    </div>
                                    <div class="form-group">
                                        <div class="embed-responsive embed-responsive-1by1">
                                          <iframe class="embed-responsive-item" src="signed_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                                    <!-- <button type="submit" name="submit" class="btn btn-primary">Submit <i class="fas fa-check-square"></i></button> -->
                                </div>
                              </form> <!-- end of form -->
                            </div>
                          </div>
                        </div>
                </div> 
                <!-- end tag modal -->
                </tr>
                <?php $count1++;} ?> 
              </tbody>
            </table>
        </div>
    <?php }
    //------------>
    else {
        $work_stats1 = "completed";
        $stats = "not archived";
        $submitted = "yes";
        $count1 = 1;//count loop of numbers in table
        $sql = "SELECT * from tbl_students_work where 
            (course='$request' and work_status='$work_stats1' and submitted='$submitted' and status='$stats')
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
                      <th hidden=""> TASK CODE</th>
                      <th hidden="">ID</th>
                      <th>Student</th>
                      <th>Course, Year & Section</th>
                      <th>Document</th>
                      <th>Status</th> 
                      <th>Action</th>  
                     </center>
                        </tr>
                        <?php } else { echo "No data available in table"; }?>
                      </thead>
                      <tbody>
                        <?php
                            while($row = mysqli_fetch_assoc($query)) {
                            $id = $row['stud_id'];
                            $status = $row['status'];
                        ?>
                        <tr id="tra">
                           <td hidden=""><?php echo $task_code;?> </td> 
                           <td hidden=""><?php 
                                $_SESSION['t_id_works11'] = $_SESSION['task_id_22'];
                                echo $_SESSION['t_id_works11'];
                            ?>  
                          </td>
                         <!--  <td><?php echo $count; ?> </td> -->
                          <td width="20%"><?php echo $row['stud_name_and_id']; ?></td>
                          <td width="30%"><?php echo $row['course'];?></td>
                          <td width="20%"><?php echo $row['title'];?><br><?php if($row['title'] == "Recommendation Letter") {?><b><a href="signed_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File"><i class="fas fa-file"></i><?php echo $row['uploaded_file'];?></a> <?php } else {?> <b><a href="../students/upload_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File"><i class="fas fa-file"></i><?php echo $row['uploaded_file'];?></a></b><?php } ?></td>
                          <td width="20%">
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
                          <td>
                              <a href="#view<?php echo $id;?>" data-toggle="modal" data-id="" class="btn btn-info" title="View Student's Info"><i class="fas fa-eye"></i></a>
                          </td>
                        </tr>

                        <!-- View Modal -->
                        <div class="modal fade bd-example-modal-lg" data-backdrop="static" id="view<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="update_place" aria-hidden="true">
                          <div class="modal-dialog modal-lg" role="document" style="color:  #333333;">
                            <div class="modal-content modal-lg">
                              <div class="modal-header modal-lg">
                                <h5 class="modal-title" id="exampleModalLabel"><h style="color: #0d6efd"><i class="fas fa-file-alt"></i> <?php echo $row['title']; ?></h><span><?php //echo $row['edited']; ?></span></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <form action="" method="POST" enctype="multipart/form-data"><!-- form start -->
                              <input type="text" class="form-control" name="id" value="<?php echo $id;?>" hidden>
                              <input type="text" name="task_code" value="<?php echo $task_code;?>" hidden>
                                <div class="modal-body modal-lg">
                                    <div class="form-group">
                                        <label>Submitted by : </label> <br>
                                        <b> <?php echo $row['stud_name_and_id']; ?> </b>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <label>Course, Year & Section : </label> <br>
                                        <b> <?php echo $row['course']; ?> </b>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <label>Signed Document</label>: <br>
                                        <b><a href="signed_docs/<?php echo $row['uploaded_file'];?>" target="_blank" title="Download File">
                                            <i class="fas fa-file-signature"></i><?php echo $row['uploaded_file'];?></a>
                                        </b>
                                        <input type="text" value="<?php echo $row['uploaded_file'];?>" name="signed_document" hidden required>
                                    </div>
                                    <div class="form-group">
                                        <div class="embed-responsive embed-responsive-1by1">
                                          <iframe class="embed-responsive-item" src="signed_docs/<?php echo $row['uploaded_file'];?>"></iframe>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                                    <!-- <button type="submit" name="submit" class="btn btn-primary">Submit <i class="fas fa-check-square"></i></button> -->
                                </div>
                              </form> <!-- end of form -->
                            </div>
                          </div>
                        </div>
                    </div> 
                    <!-- end tag modal -->
                    </tr>
                    <?php $count1++;} ?> 
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




