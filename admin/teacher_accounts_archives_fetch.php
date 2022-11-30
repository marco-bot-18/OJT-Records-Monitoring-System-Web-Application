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
include('includes/session.php'); 
include('includes/db_connect.php');
$request = $_POST['request2'];

if (isset($_POST['request2'])) {
    if ($_POST['request2'] == "") {
        $count1 = 1;
        $usertype = "teacher";
        $isArchived = "archived";
        $sql = "SELECT * FROM tbl_coordinators where isArchived='$isArchived' and userType='$usertype' ORDER BY id ASC";
        $query = $conn->query($sql);
        $count = mysqli_num_rows($query);
?>
        <div class="table-responsive">
            <table class="table table-hover" id="dataTable"  cellpadding="20"  id="example" width="100%" style="color: #333333">
            <?php 
                if($count){
            ?>
              <thead>
                <tr>
                <center>
                  <th hidden=""> ID</th>
                  <th>No.</th>
                  <th>Employee ID No.</th>
                  <th>Full Name</th>
                  <th>Is Archived?</th>
                  <th>Action</th>
                </center>
                </tr>
                <?php } else { echo "No data available in table"; }?>
              </thead>
              <tbody>
                <?php
                    while($row = mysqli_fetch_assoc($query)) {
                        $coordinator_id = $row['coordinator_id'];
                        $id = $row['id'];
                        $status = $row['status'];
                ?>
                <tr id="tra">
                  <td hidden=""><?php echo $id ?> </td>
                  <td><?php echo $count; ?></td>
                  <td><?php echo $coordinator_id; ?></td>
                  <td><?php echo $row['lname'].", ".$row['fname']." ".$row['mname']; ?></td>
                  <td>
                  <?php
                    if ($row['isArchived'] == 'archived') {
                        echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-danger'> ARCHIVED</span>";
                    }
                  ?> 
                  </td>
                  <td>
                    <a href="#view<?php echo $id;?>" data-toggle="modal" data-id="" class="btn btn-info" title="View Teacher's Account Info"><i class="fas fa-eye"></i></a>
                    <a href="#retrieve<?php echo $id;?>" data-toggle="modal" title="Retrieve"><button class="btn btn-success"><i class="fas fa-retweet"></i></button></a>
                  </td>
                </tr>

                <!-- retrieve -->
                <div class="modal fade" id="retrieve<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                  <div class="modal-dialog">
                    <div class="modal-content" style="color: #333333;">
                      <div class="modal-header">
                        <h6 class="modal-title" id="exampleModalLabel" style="color: #0d6efd;"><i class="fas fa-archive"></i> Are You Sure Do you Want To Retrieve the Account of <?php echo $row['fname']." ".$row['mname']." ".$row['lname']." (".$row['coordinator_id'].")";?> ?</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form action="teacher_account_retrieve.php" method="POST" enctype="multipart/form-data">
                            <input type="text" name="coordinator_id" value="<?php echo $coordinator_id?>" hidden>
                            <input type="text" name="coordinator_uniq_id" value="<?php echo $row['uniq_id'];?>" hidden>
                            <input type="text" name="fullname_id" value="<?php echo $row['fname']." ".$row['mname']." ".$row['lname']." (".$row['coordinator_id'].")";?>" hidden>
                                <div class="form-group">
                                    <label for="">Assign Program: <span style="color: red;">*</span></label><br>
                                    <select class="form-control" name="course" id="course">
                                        <?php
                                        include 'includes/db_connect_pdo.php';
                                        //using pdo format
                                        $sql = "SELECT DISTINCT course_code from tbl_courses order by id ASC";
                                            $query = $dbh -> prepare($sql);
                                            $query->execute();
                                            $results=$query->fetchAll(PDO::FETCH_OBJ);
                                            $cnt=1;
                                            if($query->rowCount() > 0) {
                                                foreach($results as $result){?>
                                                <option value="<?php echo $result->course_code; ?>">
                                                    <?php echo $result->course_code; ?>
                                                </option>
                                        <?php }} ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Academic Year and Semester: <span style="color: red;">*</span></label><br>
                                <select class="form-control" name="acad_yr_sem" id="acad_yr_sem">
                                    <?php
                                    include 'includes/db_connect_pdo.php';
                                    //using pdo format
                                    $active = "active";
                                    $sql = "SELECT * from tbl_academic_year_sem WHERE status=:active";
                                        $query = $dbh -> prepare($sql);
                                        $query->bindParam(':active',$active,PDO::PARAM_STR);
                                        $query->execute();
                                        $results=$query->fetchAll(PDO::FETCH_OBJ);
                                        $cnt=1;
                                        if($query->rowCount() > 0) {
                                            foreach($results as $result){?>
                                            <option value="<?php echo $result->academic_yr." - ".$result->semester; ?>">
                                                <?php echo $result->academic_yr." - ".$result->semester;?>
                                            </option>
                                    <?php }} ?>
                                </select>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label>Confirm Your Password</label>
                                <input type="password" name="my_password" placeholder="Enter Your Password" id="my_password" class="form-control">
                                <div style="padding-top: 8px;">
                                    <span id="validate_password_correct" style="font-size:12px;"></span>
                                </div> 
                            </div>
                      </div>
                      <div class="modal-footer">
                            <button type="button" class="btn btn-dark" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                            <button type="submit" name="retrieve" id="retrieve" class="btn btn-success">Archive <i class="fas fa-retweet"></i></button>
                            <!-- <button class="btn btn-primary" name="update">Update</button> -->
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

                <!-- View OJT Teacher Modal -->
                <div class="modal fade bd-example-modal-lg" id="view<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                  <div class="modal-dialog modal-lg" role="document" style="color:  #333333;">
                    <div class="modal-content modal-lg">
                      <div class="modal-header modal-lg">
                        <h5 class="modal-title" style="color: #0d6efd;"><h><i class="fas fa-user-tie"></i> View OJT Teacher's Details</h></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body modal-lg">
                        <div style="padding: 20px; background: rgba(51, 51, 51, 0.9); color: ghostwhite;">
                            <center>
                                <img src="uploaded_images/<?php echo $row['image']; ?>" alt="" style="margin-right: 60px;border-radius: 5%;" id="image1" width="200px;" height="200px;">
                            </center>
                        </div>
                        <div class="container" style="background: rgba(51, 51, 51, 0.9); color: ghostwhite; padding: 20px;">
                             <hr style="background-color: ghostwhite;">
                          <div class="row">
                            <div class="col">
                              <label>Employee ID Number:</label>
                            </div>
                          
                            <div class="col">
                               <font style="font-weight: bold; "><?php echo $row['coordinator_id']; ?></font>
                            </div>
                          </div>
                           <div class="row">
                            <div class="col">
                               <label>Name of OJT Teacher :</label>
                            </div>
                            <div class="col">
                               <font style="font-weight: bold; "><?php echo $row['fname']. " ".$row['mname']. " ".$row['lname']; ?></font>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col">
                               <label>Academic Year and Semester :</label>
                            </div>
                            <div class="col">
                               <font style="font-weight: bold; "><?php echo $row['academic_yr_sem']; ?></font>
                            </div>
                          </div>
                        </div>
                        <br>

                        <div class="container" style="color: #333333;">
                            <h5>OJT Teacher's Additional Information</h5>
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
                              <font style="font-weight: bold;"><?php echo $row['civil_stats']; ?></font>
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
                        <div class="modal-footer modal-lg">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                            <!-- <button class="btn btn-primary" name="update">Update</button> -->
                        </div>
                      </div>
                </div>
                <?php $count1++; } ?>
              </tbody>
            </table>
        </div>
<?php }
//------------>
else {
    $count1 = 1;
    $usertype = "teacher";
    $isArchived = "archived";
    $sql = "SELECT * FROM tbl_coordinators where academic_yr_sem='$request' and isArchived='$isArchived' and userType='$usertype' ORDER BY id ASC";
    $query = $conn->query($sql);
    $count = mysqli_num_rows($query);
?>
    <div class="table-responsive">
        <table class="table table-hover" id="dataTable"  cellpadding="20"  id="example" width="100%" style="color: #333333">
        <?php 
            if($count){
        ?>
          <thead>
            <tr>
            <center>
              <th hidden=""> ID</th>
              <th>No.</th>
              <th>Employee ID No.</th>
              <th>Full Name</th>
              <th>Is Archived?</th>
              <th>Action</th>
            </center>
            </tr>
            <?php } else { echo "No data available in table"; }?>
          </thead>
          <tbody>
            <?php
                while($row = mysqli_fetch_assoc($query)) {
                    $coordinator_id = $row['coordinator_id'];
                    $id = $row['id'];
                    $status = $row['status'];
            ?>
            <tr id="tra">
              <td hidden=""><?php echo $id ?> </td>
              <td><?php echo $count; ?></td>
              <td><?php echo $coordinator_id; ?></td>
              <td><?php echo $row['lname'].", ".$row['fname']." ".$row['mname']; ?></td>
              <td>
              <?php
                if ($row['isArchived'] == 'archived') {
                    echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-danger'> ARCHIVED</span>";
                }
              ?> 
              </td>
              <td>
                <a href="#view<?php echo $id;?>" data-toggle="modal" data-id="" class="btn btn-info" title="View Teacher's Account Info"><i class="fas fa-eye"></i></a>
                <a href="#retrieve<?php echo $id;?>" data-toggle="modal" title="Retrieve"><button class="btn btn-success"><i class="fas fa-retweet"></i></button></a>
              </td>
            </tr>

            <!-- retrieve -->
            <div class="modal fade" id="retrieve<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="static" data-keyboard="false">
              <div class="modal-dialog">
                <div class="modal-content" style="color: #333333;">
                  <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel" style="color: #0d6efd;"><i class="fas fa-archive"></i> Are You Sure Do you Want To Retrieve the Account of <?php echo $row['fname']." ".$row['mname']." ".$row['lname']." (".$row['coordinator_id'].")";?> ?</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form action="teacher_account_retrieve.php" method="POST" enctype="multipart/form-data">
                        <input type="text" name="coordinator_id" value="<?php echo $coordinator_id?>" hidden>
                        <input type="text" name="coordinator_uniq_id" value="<?php echo $row['uniq_id'];?>" hidden>
                        <input type="text" name="fullname_id" value="<?php echo $row['fname']." ".$row['mname']." ".$row['lname']." (".$row['coordinator_id'].")";?>" hidden>
                            <div class="form-group">
                                <label for="">Assign Program: <span style="color: red;">*</span></label><br>
                                <select class="form-control" name="course" id="course">
                                    <?php
                                    include 'includes/db_connect_pdo.php';
                                    //using pdo format
                                    $sql = "SELECT DISTINCT course_code from tbl_courses order by id ASC";
                                        $query = $dbh -> prepare($sql);
                                        $query->execute();
                                        $results=$query->fetchAll(PDO::FETCH_OBJ);
                                        $cnt=1;
                                        if($query->rowCount() > 0) {
                                            foreach($results as $result){?>
                                            <option value="<?php echo $result->course_code; ?>">
                                                <?php echo $result->course_code; ?>
                                            </option>
                                    <?php }} ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Academic Year and Semester: <span style="color: red;">*</span></label><br>
                            <select class="form-control" name="acad_yr_sem" id="acad_yr_sem">
                                <?php
                                include 'includes/db_connect_pdo.php';
                                //using pdo format
                                $active = "active";
                                $sql = "SELECT * from tbl_academic_year_sem WHERE status=:active";
                                    $query = $dbh -> prepare($sql);
                                    $query->bindParam(':active',$active,PDO::PARAM_STR);
                                    $query->execute();
                                    $results=$query->fetchAll(PDO::FETCH_OBJ);
                                    $cnt=1;
                                    if($query->rowCount() > 0) {
                                        foreach($results as $result){?>
                                        <option value="<?php echo $result->academic_yr." - ".$result->semester; ?>">
                                            <?php echo $result->academic_yr." - ".$result->semester;?>
                                        </option>
                                <?php }} ?>
                            </select>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label>Confirm Your Password</label>
                            <input type="password" name="my_password" placeholder="Enter Your Password" id="my_password" class="form-control">
                            <div style="padding-top: 8px;">
                                <span id="validate_password_correct" style="font-size:12px;"></span>
                            </div> 
                        </div>
                  </div>
                  <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                        <button type="submit" name="retrieve" id="retrieve" class="btn btn-success">Archive <i class="fas fa-retweet"></i></button>
                        <!-- <button class="btn btn-primary" name="update">Update</button> -->
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <!-- View OJT Teacher Modal -->
            <div class="modal fade bd-example-modal-lg" id="view<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="static" data-keyboard="false">
              <div class="modal-dialog modal-lg" role="document" style="color:  #333333;">
                <div class="modal-content modal-lg">
                  <div class="modal-header modal-lg">
                    <h5 class="modal-title" style="color: #0d6efd;"><h><i class="fas fa-user-tie"></i> View OJT Teacher's Details</h></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body modal-lg">
                    <div style="padding: 20px; background: rgba(51, 51, 51, 0.9); color: ghostwhite;">
                        <center>
                            <img src="uploaded_images/<?php echo $row['image']; ?>" alt="" style="margin-right: 60px;border-radius: 5%;" id="image1" width="200px;" height="200px;">
                        </center>
                    </div>
                    <div class="container" style="background: rgba(51, 51, 51, 0.9); color: ghostwhite; padding: 20px;">
                         <hr style="background-color: ghostwhite;">
                      <div class="row">
                        <div class="col">
                          <label>Employee ID Number:</label>
                        </div>
                      
                        <div class="col">
                           <font style="font-weight: bold; "><?php echo $row['coordinator_id']; ?></font>
                        </div>
                      </div>
                       <div class="row">
                        <div class="col">
                           <label>Name of OJT Teacher :</label>
                        </div>
                        <div class="col">
                           <font style="font-weight: bold; "><?php echo $row['fname']. " ".$row['mname']. " ".$row['lname']; ?></font>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col">
                           <label>Academic Year and Semester :</label>
                        </div>
                        <div class="col">
                           <font style="font-weight: bold; "><?php echo $row['academic_yr_sem']; ?></font>
                        </div>
                      </div>
                    </div>
                    <br>

                    <div class="container" style="color: #333333;">
                        <h5>OJT Teacher's Additional Information</h5>
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
                          <font style="font-weight: bold;"><?php echo $row['civil_stats']; ?></font>
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
                    <div class="modal-footer modal-lg">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                        <!-- <button class="btn btn-primary" name="update">Update</button> -->
                    </div>
                  </div>
            </div>
            <?php $count1++; } ?>
          </tbody>
        </table>
    </div>

<?php
    }
}
?>

<!-- Page level plugins -->
<script src="vendor/datatables/jquery.dataTables.min.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script src="js/demo/datatables-demo.js"></script>