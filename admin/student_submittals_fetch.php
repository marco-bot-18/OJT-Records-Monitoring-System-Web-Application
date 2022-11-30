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
$request = $_POST['request'];
if (isset($_POST['request'])) {
    if ($_POST['request'] == "") {
        $count1 = 1;
        $stats = "active";
        $sql = "SELECT Concat(lname,', ',fname, ' ', mname) AS stud_fullname, stud_id, course, in_off_campus, recommendation_letter, resume, moa, response_letter, work_plan, narrative, performance_sheet FROM tbl_students where archived='$not_archived' ORDER BY id ASC";
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
                  <th>No.</th>
                  <th>Student ID, Name, <br>Course & Section</th>
                  <!-- <th>Student Name</th>
                  <th>Section</th> -->
                  <th>Recommendation Letter</th>
                  <th>Resume</th>
                  <th>MOA</th>
                  <th>Response Letter</th>
                  <!-- <th>Accomplishment Report</th> -->
                  <th>Work Plan</th>
                  <th>Narrative</th>
                  <th>Performance Sheet</th>
                  <!-- <th>Endorsement Letter</th> -->
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
                  <td><?php echo $count1; ?></td>
                  <td>
                    <div>
                       <i class="fas fa-id-card-alt" style="color: #dc3545;"></i> <?php echo $id; ?>
                    </div>
                    <div>
                        <i class="fas fa-user-graduate" style="color: #dc3545;"></i> <?php echo $row ['stud_fullname']; ?>
                    </div>
                    <div>
                        <i class="fas fa-graduation-cap" style="color: #dc3545;"></i> <?php echo $row ['course']; ?>  
                    </div>
                  <td>
                    <?php
                    $rc = $row['recommendation_letter'];
                        if($rc=="not submitted"){
                            echo "<center><i style='color: red;' class='fas fa-times'></i><center>";
                        }
                        if($rc=="submitted"){
                            echo "<center><i style='color: #006622;' class='fas fa-check-square'></i></center>";
                        } 
                    ?>    
                  </td>
                  <td><?php
                    $resume = $row['resume'];
                        if($resume=="not submitted"){
                            echo "<center><i style='color: red;' class='fas fa-times'></i><center>";
                        }
                        if($resume=="submitted"){
                            echo "<center><i style='color: #006622;' class='fas fa-check-square'></i></center>";
                        } 
                    ?> </td>
                  <td>
                    <?php
                        $moa = $row['moa'];
                        if($moa=="not submitted"){
                            echo "<center><i style='color: red;' class='fas fa-times'></i><center>";
                        }
                        if($moa=="submitted"){
                            echo "<center><i style='color: #006622;' class='fas fa-check-square'></i></center>";
                        }
                        if($moa=="not applicable"){
                            echo "<span style='font-size: 15px; margin-left: 0px; color: #333333;' class='badge badge-pill badge-warning'>N/A</span>";
                        } 
                    ?>
                  </td>
                  <td><?php $response_letter = $row['response_letter'];
                        if($response_letter=="not submitted"){
                            echo "<center><i style='color: red;' class='fas fa-times'></i><center>";
                        }
                        if($response_letter=="submitted"){
                            echo "<center><i style='color: #006622;' class='fas fa-check-square'></i></center>";
                        }?>    
                    </td>
                    <td>
                    <?php
                    $rc = $row['work_plan'];
                        if($rc=="not submitted"){
                            echo "<center><i style='color: red;' class='fas fa-times'></i><center>";
                        }
                        if($rc=="submitted"){
                            echo "<center><i style='color: #006622;' class='fas fa-check-square'></i></center>";
                        } 
                    ?>    
                  </td>
                  <td><?php
                    $narrative = $row['narrative'];
                        if($narrative=="not submitted"){
                            echo "<center><i style='color: red;' class='fas fa-times'></i><center>";
                        }
                        if($narrative=="submitted"){
                            echo "<center><i style='color: #006622;' class='fas fa-check-square'></i></center>";
                        } 
                    ?>
                  </td>
                  <td><?php
                    $performance_sheet = $row['performance_sheet'];
                        if($performance_sheet=="not submitted"){
                            echo "<center><i style='color: red;' class='fas fa-times'></i><center>";
                        }
                        if($performance_sheet=="submitted"){
                            echo "<center><i style='color: #006622;' class='fas fa-check-square'></i></center>";
                        } 
                    ?>
                  </td>
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
        $count1 = 1;
        $stats = "active";
        $sql = "SELECT Concat(lname,', ',fname, ' ', mname) AS stud_fullname, stud_id, course, in_off_campus, recommendation_letter, resume, moa, response_letter, work_plan, narrative, performance_sheet FROM tbl_students where course='$request' and archived='$not_archived' ORDER BY id ASC";
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
                          <th>No.</th>
                          <th>Student ID, Name, <br>Course & Section</th>
                          <!-- <th>Student Name</th>
                          <th>Section</th> -->
                          <th>Recommendation Letter</th>
                          <th>Resume</th>
                          <th>MOA</th>
                          <th>Response Letter</th>
                          <!-- <th>Accomplishment Report</th> -->
                          <th>Work Plan</th>
                          <th>Narrative</th>
                          <th>Performance Sheet</th>
                          <!-- <th>Endorsement Letter</th> -->
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
                          <td><?php echo $count1; ?></td>
                          <td>
                            <div>
                               <i class="fas fa-id-card-alt" style="color: #dc3545;"></i> <?php echo $id; ?>
                            </div>
                            <div>
                                <i class="fas fa-user-graduate" style="color: #dc3545;"></i> <?php echo $row ['stud_fullname']; ?>
                            </div>
                            <div>
                                <i class="fas fa-graduation-cap" style="color: #dc3545;"></i> <?php echo $row ['course']; ?>  
                            </div>
                          <td>
                            <?php
                            $rc = $row['recommendation_letter'];
                                if($rc=="not submitted"){
                                    echo "<center><i style='color: red;' class='fas fa-times'></i><center>";
                                }
                                if($rc=="submitted"){
                                    echo "<center><i style='color: #006622;' class='fas fa-check-square'></i></center>";
                                } 
                            ?>    
                          </td>
                          <td><?php
                            $resume = $row['resume'];
                                if($resume=="not submitted"){
                                    echo "<center><i style='color: red;' class='fas fa-times'></i><center>";
                                }
                                if($resume=="submitted"){
                                    echo "<center><i style='color: #006622;' class='fas fa-check-square'></i></center>";
                                } 
                            ?> </td>
                          <td>
                            <?php
                                $moa = $row['moa'];
                                if($moa=="not submitted"){
                                    echo "<center><i style='color: red;' class='fas fa-times'></i><center>";
                                }
                                if($moa=="submitted"){
                                    echo "<center><i style='color: #006622;' class='fas fa-check-square'></i></center>";
                                }
                                if($moa=="not applicable"){
                                    echo "<span style='font-size: 15px; margin-left: 0px; color: #333333;' class='badge badge-pill badge-warning'>N/A</span>";
                                } 
                            ?>
                          </td>
                          <td><?php $response_letter = $row['response_letter'];
                                if($response_letter=="not submitted"){
                                    echo "<center><i style='color: red;' class='fas fa-times'></i><center>";
                                }
                                if($response_letter=="submitted"){
                                    echo "<center><i style='color: #006622;' class='fas fa-check-square'></i></center>";
                                }?>    
                            </td>
                            <td>
                            <?php
                            $rc = $row['work_plan'];
                                if($rc=="not submitted"){
                                    echo "<center><i style='color: red;' class='fas fa-times'></i><center>";
                                }
                                if($rc=="submitted"){
                                    echo "<center><i style='color: #006622;' class='fas fa-check-square'></i></center>";
                                } 
                            ?>    
                          </td>
                          <td><?php
                            $narrative = $row['narrative'];
                                if($narrative=="not submitted"){
                                    echo "<center><i style='color: red;' class='fas fa-times'></i><center>";
                                }
                                if($narrative=="submitted"){
                                    echo "<center><i style='color: #006622;' class='fas fa-check-square'></i></center>";
                                } 
                            ?>
                          </td>
                          <td><?php
                            $performance_sheet = $row['performance_sheet'];
                                if($performance_sheet=="not submitted"){
                                    echo "<center><i style='color: red;' class='fas fa-times'></i><center>";
                                }
                                if($performance_sheet=="submitted"){
                                    echo "<center><i style='color: #006622;' class='fas fa-check-square'></i></center>";
                                } 
                            ?>
                          </td>
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




