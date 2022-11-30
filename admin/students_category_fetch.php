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
$request = $_POST['request2'];
    if(isset($_POST['request2'])) {
        if ($_POST['request2'] == "") {
            $sql = "SELECT * FROM tbl_students where archived='$not_archived' ORDER BY id ASC";
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
                      <th hidden=""> </th>
                      <th>No.</th>
                      <th hidden="">Student ID</th>
                      <th hidden="">Student Name</th>
                      <th hidden="">Course, Yr & Section</th>
                      <th>Student</th>
                      <th>Category</th>
                      <th>Remarks</th>
                      <th>Action</th>
                    </center>
                    </tr>
                    <?php } else { echo "No data available in the table"; }?>
                  </thead>
                  <tbody>
                    <?php
                        $count1 = 1;
                        while($row = mysqli_fetch_assoc($query)) {
                            $id = $row['stud_id'];
                    ?>
                    <tr id="tra">
                          <td hidden=""><?php echo $row['uniq_id']; ?></td>
                          <td width="5%"><?php echo $count1; ?> </td>
                          <td hidden=""><?php echo $id; ?></td>
                          <td width="30%">
                            <div>
                               <i class="fas fa-id-card-alt" style="color: #dc3545;"></i> <?php echo $id; ?>
                            </div>
                            <div>
                                <i class="fas fa-user-graduate" style="color: #dc3545;"></i> <?php echo $row ['stud_fullname']; ?>
                            </div>
                            <div>
                                <i class="fas fa-graduation-cap" style="color: #dc3545;"></i> <?php echo $row ['course']; ?>  
                            </div>
                          </td>
                          <td hidden=""><?php echo $row['lname'].", ".$row['fname']." ".$row['mname']; ?></td>
                          <td hidden=""><?php echo $row ['course']; ?></td>
                          <td><?php echo $row ['ojt_category']; ?></td>
                          <td>
                              <?php 
                                if ($row['remarks'] == "pending") {
                                    echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-warning'>PENDING</span>";    
                                }
                                if ($row['remarks'] == "ongoing") {
                                    echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-info'>ON-GOING</span>";    
                                }
                                if ($row['remarks'] == "completed") {
                                    echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-success'>COMPLETED</span>"; 
                                }
                            ?>
                          </td>
                          <td>
                             <a href="#view<?php echo $id;?>" title="View Student's Category Details" data-toggle="modal" data-id="" class="btn btn-info"><i class="fas fa-eye"></i></a>
                          </td>
                        </tr>

                    <!-- view student category details -->
                    <div class="modal fade bd-example-modal-xl" id="view<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                          <div class="modal-dialog modal-xl" role="document" style="color: #333333;">
                            <div class="modal-content modal-xl">
                              <div class="modal-header modal-xl">
                                <h5 class="modal-title" style="color: #0d6efd;"><h><i class="far fa-address-book"></i> Student's Category Details</h></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-header modal-xl">
                                  <h style="color: #333333">
                                    <i class="fas fa-id-card"></i> <?php echo $row['stud_id']?> <br>
                                    <i class="fas fa-user-graduate"></i> <?php echo $row['fname']." ".$row['mname']." ".$row['lname']?> <br>
                                    <i class="fas fa-graduation-cap"></i> <?php echo $row['course']?> <br>
                                    <i class="fas fa-university"></i> <?php echo $row['in_off_campus']?> <br>
                                    <i class="fas fa-user-clock"></i> <?php echo $row['hours_required']?> <br>
                                    <i class="fas fa-columns"></i> <?php echo $row['ojt_category']?>
                                   </h>
                              </div>
                              <div class="modal-body modal-xl">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md">
                                            <form class="" action="students_category_update.php" method="POST" enctype="multipart/form-data">
                                                <input type="text" name="stud_fullname" value="<?php echo $row['fname']." ".$row['mname']." ".$row['lname']?>" hidden>
                                            <div class="">
                                                <input type="text" name="id" value="<?php echo $row['id']; ?>" hidden>
                                                <input type="text" name="stud_uniq_id" value="<?php echo $row['uniq_id']; ?>" hidden>
                                            </div>   
                                            <div class="form-group">
                                                <label>Description : </label> <br>
                                                <textarea readonly="" class="form-control" name="category_desc" id="category_desc" rows="10"><?php echo $row['category_desc']; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md">
                                             <div class="form-group">
                                                <label>Remarks: </label> <br>
                                                <?php 
                                                    if ($row['remarks'] == "pending") {
                                                        echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-warning'>PENDING</span>";    
                                                    }
                                                    if ($row['remarks'] == "ongoing") {
                                                        echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-info'>ON-GOING</span>";    
                                                    }
                                                    if ($row['remarks'] == "completed") {
                                                        echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-success'>COMPLETED</span>"; 
                                                    }
                                                ?>
                                                <!-- <textarea readonly="" class="form-control" name="remarks" id="remarks" rows="10"><?php echo $row['remarks']; ?></textarea> -->
                                            </div>  
                                        </div>
                                    </div>
                                </div>
                              </div>
                              <div class="modal-footer modal-xl">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                              </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      <!--  -->
                    </div>
                    <?php $count1++; } ?>
                  </tbody>
                </table>
            </div>
<?php  }

        //else if by section
        else {
            $sql = "SELECT * FROM tbl_students where course='$request' and archived='$not_archived' ORDER BY id ASC";
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
                     <th hidden=""> </th>
                      <th>No.</th>
                      <th hidden="">Student ID</th>
                      <th hidden="">Student Name</th>
                      <th hidden="">Course, Yr & Section</th>
                      <th>Student</th>
                      <th>Category</th>
                      <th>Remarks</th>
                      <th>Action</th>
                    </center>
                    </tr>
                    <?php } else { echo "No data available in the table"; }?>
                  </thead>
                  <tbody>
                    <?php
                        $count1 = 1;
                        while($row = mysqli_fetch_assoc($query)) {
                            $id = $row['stud_id'];
                    ?>
                    <tr id="tra">
                      <td hidden=""><?php echo $row['uniq_id']; ?></td>
                      <td width="5%"><?php echo $count1; ?> </td>
                      <td hidden=""><?php echo $id; ?></td>
                      <td width="30%">
                        <div>
                           <i class="fas fa-id-card-alt" style="color: #dc3545;"></i> <?php echo $id; ?>
                        </div>
                        <div>
                            <i class="fas fa-user-tie" style="color: #dc3545;"></i> <?php echo $row ['stud_fullname']; ?>
                        </div>
                        <div>
                            <i class="fas fa-graduation-cap" style="color: #dc3545;"></i> <?php echo $row ['course']; ?>  
                        </div>
                      </td>
                      <td hidden=""><?php echo $row['lname'].", ".$row['fname']." ".$row['mname']; ?></td>
                      <td hidden=""><?php echo $row ['course']; ?></td>
                      <td><?php echo $row ['ojt_category']; ?></td>
                      <td>
                          <?php 
                            if ($row['remarks'] == "pending") {
                                echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-warning'>PENDING</span>";    
                            }
                            if ($row['remarks'] == "ongoing") {
                                echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-info'>ON-GOING</span>";    
                            }
                            if ($row['remarks'] == "completed") {
                                echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-success'>COMPLETED</span>"; 
                            }
                        ?>
                      </td>
                      <td>
                         <a href="#view<?php echo $id;?>" title="View Student's Category Details" data-toggle="modal" data-id="" class="btn btn-info"><i class="fas fa-eye"></i></a>
                      </td>
                    </tr>

                    <!-- view student category details -->
                    <div class="modal fade bd-example-modal-xl" id="view<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                          <div class="modal-dialog modal-xl" role="document" style="color: #333333;">
                            <div class="modal-content modal-xl">
                              <div class="modal-header modal-xl">
                                <h5 class="modal-title" style="color: #0d6efd;"><h><i class="far fa-address-book"></i> Student's Category Details</h></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-header modal-xl">
                                  <h style="color: #333333">
                                    <i class="fas fa-id-card"></i> <?php echo $row['stud_id']?> <br>
                                    <i class="fas fa-user-graduate"></i> <?php echo $row['fname']." ".$row['mname']." ".$row['lname']?> <br>
                                    <i class="fas fa-graduation-cap"></i> <?php echo $row['course']?> <br>
                                    <i class="fas fa-university"></i> <?php echo $row['in_off_campus']?> <br>
                                    <i class="fas fa-user-clock"></i> <?php echo $row['hours_required']?> <br>
                                    <i class="fas fa-columns"></i> <?php echo $row['ojt_category']?>
                                   </h>
                              </div>
                              <div class="modal-body modal-xl">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md">
                                            <form class="" action="students_category_update.php" method="POST" enctype="multipart/form-data">
                                                <input type="text" name="stud_fullname" value="<?php echo $row['fname']." ".$row['mname']." ".$row['lname']?>" hidden>
                                            <div class="">
                                                <input type="text" name="id" value="<?php echo $row['id']; ?>" hidden>
                                                <input type="text" name="stud_uniq_id" value="<?php echo $row['uniq_id']; ?>" hidden>
                                            </div>   
                                            <div class="form-group">
                                                <label>Description : </label> <br>
                                                <textarea readonly="" class="form-control" name="category_desc" id="category_desc" rows="10"><?php echo $row['category_desc']; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md">
                                             <div class="form-group">
                                                <label>Remarks: </label> <br>
                                                <?php 
                                                    if ($row['remarks'] == "pending") {
                                                        echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-warning'>PENDING</span>";    
                                                    }
                                                    if ($row['remarks'] == "ongoing") {
                                                        echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-info'>ON-GOING</span>";    
                                                    }
                                                    if ($row['remarks'] == "completed") {
                                                        echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-success'>COMPLETED</span>"; 
                                                    }
                                                ?>
                                                <!-- <textarea readonly="" class="form-control" name="remarks" id="remarks" rows="10"><?php echo $row['remarks']; ?></textarea> -->
                                            </div>  
                                        </div>
                                    </div>
                                </div>
                              </div>
                              <div class="modal-footer modal-xl">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                              </div>
                              </form>
                            </div>
                          </div>
                        </div>

                      <!--  -->
                    </div>
                    <?php $count1++; } ?>
                  </tbody>
                </table>
            </div>

<?php 
        } 
    } 
    else { 
        echo $conn->error; 
    } ?>


<!-- Page level plugins -->
<script src="vendor/datatables/jquery.dataTables.min.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script src="js/demo/datatables-demo.js"></script>