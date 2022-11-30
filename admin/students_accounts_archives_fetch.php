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
        $isArchived = "archived";
        $sql = "SELECT * FROM tbl_students where archived='$isArchived' ORDER BY id ASC";
        $query = $conn->query($sql);
        $count = mysqli_num_rows($query);
?>
        <div class="table-responsive">
            <table class="table table-hover" id="dataTable" width="100%"  cellpadding="10"  id="example" style="color: #333333;">
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
                  <th>Is Archived?</th>
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
                  <td><?php echo $count1; ?> </td>
                  <td><img src="../admin/uploaded_images/<?php echo $row['image']; ?>" alt="" style="margin-right: 50px; border-radius: 50%;" id="image1" width="50px;" height="50px;">  </td>
                  <td><?php echo $id; ?></td>
                  <td><?php echo $row['lname'].", ".$row['fname']." ".$row['mname']; ?></td>
                  <td width="20%"><?php echo $row ['course']; ?></td>
                  <td>
                      <?php 
                        if($row['archived'] == "archived"){
                            echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-danger'>ARCHIVED</span>";
                        }
                      ?>
                  </td>
                  <td>
                    <a href="#view<?php echo $id;?>" title="View Student's Info" data-toggle="modal" data-id="" class="btn btn-info"><i class="fas fa-eye"></i></a>
                     <a href="#retrieve<?php echo $id;?>" data-toggle="modal" title="Retrieve"><button class="btn btn-success"><i class="fas fa-retweet"></i></button></a>
                  </td>
                </tr>

                <!-- retrieve -->
                <div class="modal fade bd-example-modal-lg" id="retrieve<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content modal-lg" style="color: #333333;">
                      <div class="modal-header modal-lg">
                        <h5 class="modal-title" id="exampleModalLabel" style="color: #0d6efd;"><i class="fas fa-retweet"></i> Are You Sure Do you Want To Retrieve The Account of <?php echo $row['fname']." ".$row['mname']." ".$row['lname']." (".$row['stud_id'].")";?> ?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body modal-lg">
                        <form action="student_account_retrieve.php" method="POST" enctype="multipart/form-data">
                            <input type="text" name="stud_id" value="<?php echo $id?>" hidden>
                            <input type="text" name="stud_uniq_id" value="<?php echo $row['uniq_id'];?>" hidden>
                            <input type="text" name="fullname_id" value="<?php echo $row['fname']." ".$row['mname']." ".$row['lname']." (".$row['stud_id'].")";?>" hidden>
                            <div class="form-group">
                                <label>Choose Academic Year and Semester:</label>
                                <select  class="form-control" name="acad_yr_sem" id="acad_yr_sem" required="">
                                    <?php
                                    include 'includes/db_connect_pdo.php';
                                    //using pdo format
                                    $active = "active";
                                    $sql1 = "SELECT * from tbl_academic_year_sem";
                                        $query1 = $dbh -> prepare($sql1);
                                        $query1->execute();
                                        $results1=$query1->fetchAll(PDO::FETCH_OBJ);
                                        $cnt=1;
                                        if($query1->rowCount() > 0) {
                                            echo "<option value='' selected='' disabled=''>Choose Academic Year</option>";
                                            foreach($results1 as $result1){?>
                                            <option value="<?php echo $result1->academic_yr." - ".$result1->semester; ?>">
                                                <?php echo $result1->academic_yr." - ".$result1->semester;?>
                                            </option>
                                    <?php }} ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Assign OJT Teacher:</label>
                                <select class="form-control" name="teacher" id="teacher">
                                    <?php
                                        include 'includes/db_connect_pdo.php';
                                        //using pdo format
                                        $isArchived = "not archived";
                                        $userType = "teacher";
                                        $course = $row['program'];
                                        $sql2 = "SELECT * from tbl_coordinators WHERE isArchived=:isArchived and userType=:userType and course=:course";
                                        $query2 = $dbh -> prepare($sql2);
                                        $query2->bindParam(':isArchived', $isArchived,PDO::PARAM_STR);
                                        $query2->bindParam(':userType', $userType,PDO::PARAM_STR);
                                        $query2->bindParam(':course', $course,PDO::PARAM_STR);
                                        $query2->execute();
                                        $results2=$query2->fetchAll(PDO::FETCH_OBJ);
                                        $cnt=1;
                                        if($query2->rowCount() > 0) {
                                            echo "<option value='' selected='' disabled=''>Assign OJT Teacher</option>";
                                            foreach($results2 as $result2){ ?>
                                            <option value="<?php echo $result2->fname." ".$result2->mname." ".$result2->lname." (".$result2->coordinator_id.")";?>">
                                                <?php echo $result2->fname." ".$result2->mname." ".$result2->lname." (".$result2->coordinator_id.")";?>
                                            </option>
                                    <?php }} ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Choose Course, Year & Section</label>
                                <select  class="form-control" name="section" id="section" required="">
                                    <?php
                                    include 'includes/db_connect_pdo.php';
                                    //using pdo format
                                    $sql3 = "SELECT * from tbl_courses";
                                        $query3 = $dbh -> prepare($sql3);
                                        $query3->execute();
                                        $results3=$query3->fetchAll(PDO::FETCH_OBJ);
                                        $cnt=1;
                                        if($query3->rowCount() > 0) {
                                            echo "<option value='' selected='' value='' disabled>Choose Course, year & Section</option>";
                                            foreach($results3 as $result3){?>
                                            <option value="<?php echo $result3->course_title; ?>">
                                                <?php echo $result3->course_title;?>
                                            </option>
                                    <?php }} ?>
                                </select>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label>Confirm Your Password</label>
                                <input type="password" name="my_password" placeholder="Enter Your Password" id="my_password" class="form-control">
                            </div>
                      </div>
                      <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel <i class="fas fa-times-circle"></i></button>
                            <button type="submit" name="retrieve" id="retrieve" class="btn btn-success">Retrieve <i class="fas fa-retweet"></i></button>
                            <!-- <button class="btn btn-primary" name="update">Update</button> -->
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

                <!-- View Student Modal -->
                <div class="modal fade bd-example-modal-lg" id="view<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content modal-lg">
                      <div class="modal-header modal-lg">
                        <h5 class="modal-title" style="color: #0d6efd;"><h><i class="fas fa-user-graduate"></i> View Archived Student's Account Details</h></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body modal-lg">
                        <div style="padding: 20px; background: rgba(51, 51, 51, 0.9); color: ghostwhite;">
                            <center>
                                <img src="../admin/uploaded_images/<?php echo $row['image']; ?>" alt="" style="margin-right: 50px;border-radius: 5%;" id="image1" width="200px;" height="200px;"> 
                            </center><br>
                        </div>
                        <div class="container" style="background: rgba(51, 51, 51, 0.9); color: ghostwhite; padding: 20px;">
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
                               <label>OJT Teacher :</label>
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
                        </div>
                        <br>

                        <div class="container" style="color: #333333;">
                            <h5>Student Additional Information</h5>
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
                </div>
                <?php $count1++; } ?>
              </tbody>
            </table>

        </div>
    <?php }
    //------------>
    else {
        $count1 = 1;
        $isArchived = "archived";
        $sql = "SELECT * FROM tbl_students where academic_yr_semester='$request' and archived='$isArchived' ORDER BY id ASC";
        $query = $conn->query($sql);
        $count = mysqli_num_rows($query);
    ?>

    <div class="table-responsive">
            <table class="table table-hover" id="dataTable" width="100%"  cellpadding="10"  id="example" style="color: #333333;">
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
                  <th>Is Archived?</th>
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
                  <td><?php echo $count1; ?> </td>
                  <td><img src="../admin/uploaded_images/<?php echo $row['image']; ?>" alt="" style="margin-right: 50px; border-radius: 50%;" id="image1" width="50px;" height="50px;">  </td>
                  <td><?php echo $id; ?></td>
                  <td><?php echo $row['lname'].", ".$row['fname']." ".$row['mname']; ?></td>
                  <td width="20%"><?php echo $row ['course']; ?></td>
                  <td>
                      <?php 
                        if($row['archived'] == "archived"){
                            echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-danger'>ARCHIVED</span>";
                        }
                      ?>
                  </td>
                  <td>
                    <a href="#view<?php echo $id;?>" title="View Student's Info" data-toggle="modal" data-id="" class="btn btn-info"><i class="fas fa-eye"></i></a>
                     <a href="#retrieve<?php echo $id;?>" data-toggle="modal" title="Retrieve"><button class="btn btn-success"><i class="fas fa-retweet"></i></button></a>
                  </td>
                </tr>

                <!-- retrieve -->
                <div class="modal fade bd-example-modal-lg" id="retrieve<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content modal-lg" style="color: #333333;">
                      <div class="modal-header modal-lg">
                        <h5 class="modal-title" id="exampleModalLabel" style="color: #0d6efd;"><i class="fas fa-retweet"></i> Are You Sure Do you Want To Retrieve The Account of <?php echo $row['fname']." ".$row['mname']." ".$row['lname']." (".$row['stud_id'].")";?> ?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body modal-lg">
                        <form action="student_account_retrieve.php" method="POST" enctype="multipart/form-data">
                            <input type="text" name="stud_id" value="<?php echo $id?>" hidden>
                            <input type="text" name="stud_uniq_id" value="<?php echo $row['uniq_id'];?>" hidden>
                            <input type="text" name="fullname_id" value="<?php echo $row['fname']." ".$row['mname']." ".$row['lname']." (".$row['stud_id'].")";?>" hidden>
                            <div class="form-group">
                                <label>Choose Academic Year and Semester:</label>
                                <select  class="form-control" name="acad_yr_sem" id="acad_yr_sem" required="">
                                    <?php
                                    include 'includes/db_connect_pdo.php';
                                    //using pdo format
                                    $active = "active";
                                    $sql1 = "SELECT * from tbl_academic_year_sem";
                                        $query1 = $dbh -> prepare($sql1);
                                        $query1->execute();
                                        $results1=$query1->fetchAll(PDO::FETCH_OBJ);
                                        $cnt=1;
                                        if($query1->rowCount() > 0) {
                                            echo "<option value='' selected='' disabled=''>Choose Academic Year</option>";
                                            foreach($results1 as $result1){?>
                                            <option value="<?php echo $result1->academic_yr." - ".$result1->semester; ?>">
                                                <?php echo $result1->academic_yr." - ".$result1->semester;?>
                                            </option>
                                    <?php }} ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Assign OJT Teacher:</label>
                                <select class="form-control" name="teacher" id="teacher">
                                    <?php
                                        include 'includes/db_connect_pdo.php';
                                        //using pdo format
                                        $isArchived = "not archived";
                                        $userType = "teacher";
                                        $course = $row['program'];
                                        $sql2 = "SELECT * from tbl_coordinators WHERE isArchived=:isArchived and userType=:userType and course=:course";
                                        $query2 = $dbh -> prepare($sql2);
                                        $query2->bindParam(':isArchived', $isArchived,PDO::PARAM_STR);
                                        $query2->bindParam(':userType', $userType,PDO::PARAM_STR);
                                        $query2->bindParam(':course', $course,PDO::PARAM_STR);
                                        $query2->execute();
                                        $results2=$query2->fetchAll(PDO::FETCH_OBJ);
                                        $cnt=1;
                                        if($query2->rowCount() > 0) {
                                            echo "<option value='' selected='' disabled=''>Assign OJT Teacher</option>";
                                            foreach($results2 as $result2){ ?>
                                            <option value="<?php echo $result2->fname." ".$result2->mname." ".$result2->lname." (".$result2->coordinator_id.")";?>">
                                                <?php echo $result2->fname." ".$result2->mname." ".$result2->lname." (".$result2->coordinator_id.")";?>
                                            </option>
                                    <?php }} ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Choose Course, Year & Section</label>
                                <select  class="form-control" name="section" id="section" required="">
                                    <?php
                                    include 'includes/db_connect_pdo.php';
                                    //using pdo format
                                    $sql3 = "SELECT * from tbl_courses";
                                        $query3 = $dbh -> prepare($sql3);
                                        $query3->execute();
                                        $results3=$query3->fetchAll(PDO::FETCH_OBJ);
                                        $cnt=1;
                                        if($query3->rowCount() > 0) {
                                            echo "<option value='' selected='' value='' disabled>Choose Course, year & Section</option>";
                                            foreach($results3 as $result3){?>
                                            <option value="<?php echo $result3->course_title; ?>">
                                                <?php echo $result3->course_title;?>
                                            </option>
                                    <?php }} ?>
                                </select>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label>Confirm Your Password</label>
                                <input type="password" name="my_password" placeholder="Enter Your Password" id="my_password" class="form-control">
                            </div>
                      </div>
                      <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel <i class="fas fa-times-circle"></i></button>
                            <button type="submit" name="retrieve" id="retrieve" class="btn btn-success">Retrieve <i class="fas fa-retweet"></i></button>
                            <!-- <button class="btn btn-primary" name="update">Update</button> -->
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

                <!-- View Student Modal -->
                <div class="modal fade bd-example-modal-lg" id="view<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content modal-lg">
                      <div class="modal-header modal-lg">
                        <h5 class="modal-title" style="color: #0d6efd;"><h><i class="fas fa-user-graduate"></i> View Archived Student's Account Details</h></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body modal-lg">
                        <div style="padding: 20px; background: rgba(51, 51, 51, 0.9); color: ghostwhite;">
                            <center>
                                <img src="../admin/uploaded_images/<?php echo $row['image']; ?>" alt="" style="margin-right: 50px;border-radius: 5%;" id="image1" width="200px;" height="200px;"> 
                            </center><br>
                        </div>
                        <div class="container" style="background: rgba(51, 51, 51, 0.9); color: ghostwhite; padding: 20px;">
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
                               <label>OJT Teacher :</label>
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
                        </div>
                        <br>

                        <div class="container" style="color: #333333;">
                            <h5>Student Additional Information</h5>
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