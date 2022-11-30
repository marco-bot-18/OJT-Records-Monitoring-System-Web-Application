<?php
include('includes/session.php'); ?>

<?php 
include('includes/db_connect.php');

$not_archived = "not archive";
$request = $_POST['request1'];
$program_head_of = $_SESSION['program_head_of'];

if (isset($_POST['request1'])) {
    if ($_POST['request1'] == "") {
    $request = $_POST['request1'];
    $sql = "SELECT * FROM tbl_students where program='$program_head_of' and archived='$not_archived' ORDER BY id ASC";
    $query = $conn->query($sql);
    $count = mysqli_num_rows($query);
?>
    <div class="table-responsive">
        <table class="table table-hover" id="dataTable"  cellspacing="20"  id="example" style="color: #333333;">
            <?php 
            if($count){
        ?>
          <thead>
                <tr>
                <center>
                  <th>No.</th>
                  <th>Photo</th>
                  <th>Student ID</th>
                  <th>Student Name</th>
                  <th>Course, Year & Section</th>
                  <th>Status</th>
                  <th>Action</th>
                </center>
                </tr>
                <?php } else { echo "No data available on the table"; }?>
              </thead>
              <tbody>
                <?php
                    $count1 = 1;
                    while($row = mysqli_fetch_assoc($query)) {
                    $id = $row['stud_id'];
                    $status = $row['status'];
                ?>
                <tr id="tra" href="#view<?php echo $id;?>" title="View Student's Info" data-toggle="modal">
                  <td><?php echo $count1; ?></td>
                  <td><img src="../admin/uploaded_images/<?php echo $row['image']; ?>" alt="" style="margin-right: 50px;border-radius: 50%;" id="image1" width="50px;" height="50px;">  </td>
                  <td><?php echo $id; ?></td>
                  <td><?php echo $row ['lname'].", ".$row['fname']. " ".$row['mname']; ?></td>
                  <td><?php echo $row ['course']; ?></td>
                  <td>
                  <?php
                    if ($status == 'not active') {
                        echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-danger'>NOT ACTIVE</span>";
                    }
                    else if ($status == 'active') {
                        echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-success'>ACTIVE</span>";
                    }
                  ?> 
                  </td>
                  <td>
                    <a href="#view<?php echo $id;?>" data-toggle="modal" data-id="" class="btn btn-info" title="View Student's Info"><i class="fas fa-eye"></i></a>
                  </td>
                </tr>

              <!-- View Student Modal -->
                        <div class="modal fade bd-example-modal-lg" id="view<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                          <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content modal-lg">
                              <div class="modal-header modal-lg">
                                <h5 class="modal-title" id="exampleModalLabel" style="color: #333333;">View Student's Information</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body modal-lg">
                                <div style="padding: 20px; background: rgba(51, 51, 51, 0.8); color: ghostwhite;">
                                    <center>
                                        <img src="../admin/uploaded_images/<?php echo $row['image']; ?>" alt="" style="margin-right: 50px;border-radius: 5%;" id="image1" width="200px;" height="200px;"> 
                                    </center><br>
                                </div>                                <div class="container" style="background: rgba(51, 51, 51, 0.8); color: ghostwhite; padding: 20px;">
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
                                       <font style="font-weight: bold; "><?php echo $row['fname']. " ".$row['mname']. " ".$row['lname']; ?></font>
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
                                       <label>Handle by :</label>
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
                                        <font style="font-weight:; "><?php
                                            if ($status == 'dropped') {
                                                echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-danger'>NOT ACTIVE</span>";
                                            }
                                            else if ($status == 'active') {
                                                echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-success'>ACTIVE</span>";
                                            }
                                            else if ($status == 'incomplete') {
                                                echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-warning'>INCOMPLETE</span>";
                                            }
                                          ?> 
                                      </font>
                                    </div>
                                  </div>
                                </div>
                                <br>

                                <div class="container" style="color: #333333;">
                                    <h5>Student Personal Information</h5>
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
                                    <!-- <button class="btn btn-primary" name="update">Update</button> -->
                                </div>
                                <!-- form end -->
                              </form>
                            </div>
                        </div>


                  <!--  -->
                </div>
                <?php $count1++; } ?>
              </tbody>
            </table>
        </div>

   <?php }
    else {
    	$request = $_POST['request1'];
        $sql = "SELECT * FROM tbl_students where program='$program_head_of' and course='$request' and archived='$not_archived' ORDER BY id ASC";
        $query = $conn->query($sql);
        $count = mysqli_num_rows($query);
    ?>
    <div class="table-responsive">
        <table class="table table-hover" id="dataTable"  cellspacing="20"  id="example" style="color: #333333;">
        	<?php 
    		if($count){
    	?>
          <thead>
                <tr>
                <center>
                  <th>No.</th>
                  <th>Photo</th>
                  <th>Student ID</th>
                  <th>Student Name</th>
                  <th>Course, Year & Section</th>
                  <th>Status</th>
                  <th>Action</th>
                </center>
                </tr>
                <?php } else { echo "No data available on the table"; }?>
              </thead>
              <tbody>
                <?php
                    $count1 = 1;
                    while($row = mysqli_fetch_assoc($query)) {
                    $id = $row['stud_id'];
                    $status = $row['status'];
                ?>
                <tr id="tra" href="#view<?php echo $id;?>" title="View Student's Info" data-toggle="modal">
                  <td><?php echo $count1; ?></td>
                  <td><img src="../admin/uploaded_images/<?php echo $row['image']; ?>" alt="" style="margin-right: 50px;border-radius: 50%;" id="image1" width="50px;" height="50px;">  </td>
                  <td><?php echo $id; ?></td>
                  <td><?php echo $row ['lname'].", ".$row['fname']. " ".$row['mname']; ?></td>
                  <td><?php echo $row ['course']; ?></td>
                  <td>
                  <?php
                    if ($status == 'not active') {
                        echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-danger'>NOT ACTIVE</span>";
                    }
                    else if ($status == 'active') {
                        echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-success'>ACTIVE</span>";
                    }
                  ?> 
                  </td>
                  <td>
                    <a href="#view<?php echo $id;?>" data-toggle="modal" data-id="" class="btn btn-info" title="View Student's Info"><i class="fas fa-eye"></i></a>
                  </td>
                </tr>

              <!-- View Student Modal -->
                        <div class="modal fade bd-example-modal-lg" id="view<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                          <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content modal-lg">
                              <div class="modal-header modal-lg">
                                <h5 class="modal-title" id="exampleModalLabel" style="color: #333333;">View Student's Information</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body modal-lg">
                                <div style="padding: 20px; background: rgba(51, 51, 51, 0.8); color: ghostwhite;">
                                    <center>
                                        <img src="../admin/uploaded_images/<?php echo $row['image']; ?>" alt="" style="margin-right: 50px;border-radius: 5%;" id="image1" width="200px;" height="200px;"> 
                                    </center><br>
                                </div>
                                <div class="container" style="background: rgba(51, 51, 51, 0.8); color: ghostwhite; padding: 20px;">
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
                                       <font style="font-weight: bold; "><?php echo $row['fname']. " ".$row['mname']. " ".$row['lname']; ?></font>
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
                                       <label>Handle by :</label>
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
                                        <font style="font-weight:; "><?php
                                            if ($status == 'dropped') {
                                                echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-danger'>NOT ACTIVE</span>";
                                            }
                                            else if ($status == 'active') {
                                                echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-success'>ACTIVE</span>";
                                            }
                                            else if ($status == 'incomplete') {
                                                echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-warning'>INCOMPLETE</span>";
                                            }
                                          ?> 
                                      </font>
                                    </div>
                                  </div>
                                </div>
                                <br>

                                <div class="container" style="color: #333333;">
                                    <h5>Student Personal Information</h5>
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
                                    <!-- <button class="btn btn-primary" name="update">Update</button> -->
                                </div>
                                <!-- form end -->
                              </form>
                            </div>
                        </div>


                  <!--  -->
                </div>
                <?php $count1++; } ?>
              </tbody>
            </table>
        </div>

   <?php } } else { echo $conn->error; } ?>

   <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>




