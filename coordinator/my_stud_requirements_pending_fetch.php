<?php 
//PHPMAILER
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
?>

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
        $myfullname_ = $_SESSION['coordinator_fullname_session'];
        $work_stats = "pending";
        $stats = "not archived";
        $submitted = "no";
        $count1 = 1;
        $sql = "SELECT * from tbl_students_work where name_of_teacher='$myfullname_' and work_status='$work_stats' and submitted='$submitted' and status='$stats'";
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
                  <th hidden="">ID</th>
                  <th>Student</th>
                  <th>Requirement</th>
                  <th>Attached File</th>
                  <th>Due Date</th>
                  <th>Turned In</th>
                  <th>Status</th>
                  <th>Action</th>  
              </center>
                </tr>
                <?php } else { echo "No data available in table"; }?>
              </thead>
              <tbody>
                <?php
                    require '../vendor/autoload.php';
                    $mail = new  PHPMailer(true);
                    //$mail->SMTPDebug = 1; //Enable verbose debug output
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
                    $mail->Username   = 'websiteet18@gmail.com';                     //SMTP username
                    $mail->Password   = 'empowermenttechnology';                               //SMTP password
                    $mail->SMTPSecure = "tls"; //Enable implicit TLS encryption
                    $mail->Port       = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                    while($row = mysqli_fetch_assoc($query)) {
                        $id = $row['id'];
                        $requirement_title = $row['title'];
                        $stud_fullname = $row['stud_name_and_id'];
                        $_SESSION['task_id_2'] = $row['id'];
                ?>
                <tr id="tra">
                    <td hidden=""><?php 
                            $_SESSION['t_id_works1'] = $_SESSION['task_id_2'];
                            echo $_SESSION['t_id_works1'];
                        ?>
                      </td>
                      <td><?php echo $row['stud_name_and_id']; ?></td>
                      <td><?php echo $row['title'];?> </td>
                      <td><?php if($row['sample_file'] != "") {?><b><a href="../admin/upload_docs/<?php echo $row['sample_file'];?>" target="_blank" title="Download File"><i class="fa fa-file"></i><?php echo $row['sample_file'];?></a> </b> <?php } else { echo "<font style='color: red;'>There's no attached file</font>"; } ?></td>
                      <td width="10%"><?php echo $row['date_of_submission']?></td>
                      <td>
                        <?php
                            $sql2 = "SELECT email from tbl_students where stud_fullname='$stud_fullname'";
                            $query2 = $conn->query($sql2);
                             //this lines of code will insert multiple data in rows in tbl_students_work
                            while($row2 = $query2->fetch_assoc()){
                                $get_email = $row2['email'];
                            }
                            //detect the dates
                            date_default_timezone_set('Asia/Manila'); 
                            $date = date('Y-m-d');
                            if($row['date_of_submission'] < $date){
                                //in this part, magnonotify sa email ng students kapag late na yung requirement nila(di pa napapasa), imbes na mag-spam sa email, ginawan ko ng update email late notify para isang beses lang magsend yung sa gmail nila kapag late na yung requirement nila
                                //if yung email notify late ay = sa unsent magnonotify sa email; else kapag hindi
                                if ($row['email_notify_late'] == "unsent") {
                                    //Recipients
                                    $mail->setFrom('websiteet18@gmail.com', $myfullname_);
                                    $mail->addAddress($get_email);//Name is optional

                                    //Content
                                    $mail->isHTML(true);//Set email format to HTML
                                    $mail->Subject = "e-OJT aCCeSs: Requirement Update";
                                    $template    = "Late Requirement: <b>".$requirement_title."</b><br>You are <b style='color: ghostwhite; background: red; padding: 2px; border-radius: 5px;'>LATE</b>. Please submit your requirement. ";
                                    $mail->Body = $template;
                                    $mail->send();
                                }
                                else if($row['email_notify_late'] == "sent"){
                                    echo "";//OKAY na
                                }
                                date_default_timezone_set('Asia/Manila'); 
                                $date = date('Y-m-d');

                                $no = "no";
                                $sent="sent";
                                $sql_update_late_sent = "UPDATE tbl_students_work set email_notify_late='$sent' WHERE date_of_submission<'$date' and submitted='$no'";
                                $query_run_late_sent = mysqli_query($conn, $sql_update_late_sent);

                                echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-danger'><font style='color: ghostwhite;'>LATE</span>";
                            }
                            //$counter = 0;
                            else if($row['date_of_submission'] == $date){
                                //in this part, magnonotify sa email ng students kapag due date na yung requirement nila(di pa napapasa), imbes na mag-spam sa email, ginawan ko ng update email due notify para isang beses lang magsend yung sa gmail nila kapag late na yung requirement nila
                                //if yung email notify due ay = sa unsent magnonotify sa email; else kapag hindi
                                if ($row['email_notify_due'] == "unsent") {
                                    try {
                                        require '../vendor/autoload.php';
                                        $mail = new  PHPMailer(true);
                                        //$mail->SMTPDebug = 1; //Enable verbose debug output
                                        $mail->isSMTP();                                            //Send using SMTP
                                        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                                        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
                                        $mail->Username   = 'websiteet18@gmail.com';                     //SMTP username
                                        $mail->Password   = 'empowermenttechnology';                               //SMTP password
                                        $mail->SMTPSecure = "tls"; //Enable implicit TLS encryption
                                        $mail->Port       = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                                        //Recipients
                                        $mail->setFrom('websiteet18@gmail.com', $myfullname_);
                                        $mail->addAddress($get_email);//Name is optional

                                        //Content
                                        $mail->isHTML(true);//Set email format to HTML
                                        $mail->Subject = "e-OJT aCCeSs: Requirement Update";
                                        $template    = "Requirement: <b>".$requirement_title."</b><br> Your requirement is <b style='color: black; background: yellow; padding: 2px; border-radius: 5px;'>DUE TODAY</b>. Please submit your requirement.";
                                        $mail->Body = $template;
                                        $mail->send();
                                    }
                                    catch(Exception $ex){
                                        //echo $ex;
                                    }
                                }
                                else if($row['email_notify_due'] == "sent"){
                                    echo "";//OKAY na
                                }
                                date_default_timezone_set('Asia/Manila'); 
                                $date = date('Y-m-d');
                                
                                $no = "no";
                                $sent="sent";
                                $sql_update_due_sent = "UPDATE tbl_students_work set email_notify_due='$sent' WHERE date_of_submission='$date' and submitted='$no'";
                                $query_run_due_sent = mysqli_query($conn, $sql_update_due_sent);

                                echo "<span style='font-size: 15px; margin-left: 0px; color: #262626;' class='badge badge-pill badge-warning'>DUE TODAY</span>";
                            }
                            else{
                                echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite; background: orange; background: orange; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-success'>ON-GOING</span>";
                            }
                        ?> 
                      </td>
                      <td width="15%">
                        <?php 
                            if ($row['work_status'] == 'pending') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' title='15% on progress'>15%</div>
                                        </div><b>PENDING</b>";
                            }

                            if ($row['work_status'] == 'semi-pending') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' title='25% on progress' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'>25%</div>
                                        </div><b>PENDING</b>";
                            }

                            if ($row['work_status'] == 'semi-pending2') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'>50%</div>
                                        </div><b>PENDING</b>";
                            }

                            if ($row['work_status'] == 'semi-pending3') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'>75%</div>
                                        </div><b>PENDING</b>";
                            }

                            if ($row['work_status'] == 'completed') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'>100%</div>
                                        </div><b>COMPLETED</b>";
                            }
                        ?>
                          
                      </td>
                      <td>
                          <a href="#view<?php echo $id;?>"  class="btn btn-info" data-toggle="modal" ><i class="fas fa-eye" title="View"></i></a>
                      </td>

                        
                        <!-- View Modal -->
                        <div class="modal fade bd-example-modal-xl" data-backdrop="static" id="view<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="update_place" aria-hidden="true">
                          <div class="modal-dialog modal-xl" role="document" style="color:  #333333;">
                            <div class="modal-content modal-xl">
                              <div class="modal-header modal-xl">
                                <h5 class="modal-title" id="exampleModalLabel"><h style="color: #0d6efd"><i class="fas fa-file-alt"></i> <?php echo $row['title']; ?> </h><span><?php //echo $row['edited']; ?></span></h5>
                                   
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                                <div class="modal-header modal-xl">
                                    <p class="modal-title" id="exampleModalLabel">
                                        <h title="Date and Time Given"><i style="color: #1a8cff;" class="fas fa-clock"></i> <?php echo $row['date_']." at ".$row['time_'];  ?> <?php echo $row['edited'];?></h>
                                    </p> 
                                </div>
                              <input type="text" class="form-control" name="id" value="<?php echo $id;?>" hidden>
                                <div class="modal-body modal-xl">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Student: </label> <br>
                                                    <b> <?php echo $row['stud_name_and_id']; ?> </b>
                                                </div>
                                                <hr>
                                                <div class="form-group">
                                                    <label>Course, Year & Section: </label> <br>
                                                    <b> <?php echo $row['course']; ?> </b>
                                                </div>
                                                <!-- <hr>
                                                <div class="form-group">
                                                    <label>Requirement: </label> <br>
                                                    <b> <?php echo $row['title']; ?> </b>
                                                </div> -->
                                                <hr>
                                                <div class="form-group">
                                                    <label>Instructions: </label> <br>
                                                    <textarea style="background: ghostwhite;" rows="15" name="instructions" class="form-control" id="instructions" aria-describedby="" readonly required=""><?php echo $row['instructions'];?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Attached File</label>: <br>
                                                    <?php if($row['sample_file'] != "") { ?>
                                                    <b><a href="../admin/upload_docs/<?php echo $row['sample_file'];?>" target="_blank" title="Download File"><i class="fa fa-file"></i><?php echo $row['sample_file'];?></a> </b></a>
                                                    <?php } else { echo "<b style='color: red;'>There's no attached file</b>"; } ?>
                                                </div>
                                                <hr>
                                                <!-- selecting and concatenating the date and time from tbl_students_work -->
                                                <?php 
                                                    session_start();
                                                    $task_id = $_SESSION['t_id_works1'];
                                                    $sql1 = "SELECT Concat(date_,' ',time_) AS dateTTime1 FROM tbl_students_work where id='$task_id'";
                                                    $query1 = $conn->query($sql1);
                                                    while($row1 = $query1->fetch_assoc()){
                                                        $_SESSION['datetime2'] = $row1['dateTTime1'];
                                                    }
                                                ?>
                                                <div class="form-group">
                                                    <label>Status: </label> <br>
                                                    <?php 
                                                        if ($row['work_status'] == 'pending') {
                                                             echo "<div class='progress'>
                                                                      <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' title='15% on progress'>15%</div>
                                                                    </div><b>PENDING</b>";
                                                        }

                                                        if ($row['work_status'] == 'semi-pending') {
                                                             echo "<div class='progress'>
                                                                      <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' title='25% on progress' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'>25%</div>
                                                                    </div><b>PENDING</b>";
                                                        }

                                                        if ($row['work_status'] == 'semi-pending2') {
                                                             echo "<div class='progress'>
                                                                      <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'>50%</div>
                                                                    </div><b>PENDING</b>";
                                                        }

                                                        if ($row['work_status'] == 'semi-pending3') {
                                                             echo "<div class='progress'>
                                                                      <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'>75%</div>
                                                                    </div><b>PENDING</b>";
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
                                                    <label>Due Date:</label> <br>
                                                    <b><?php
                                                        echo $row['date_of_submission'];?></b>
                                                </div>
                                                <!-- <hr>
                                                <div class="form-group" >
                                                    <label>Turned In?:</label> <br>
                                                    <?php
                                                        date_default_timezone_set('Asia/Manila'); 
                                                        $date = date('Y-m-d');
                                                        if($row['date_of_submission'] < $date){
                                                            echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-danger'>LATE</span>";
                                                        }
                                                        else{
                                                            echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite; background: orange;' class='badge badge-pill badge-success'>ON-GOING</span>";
                                                        }
                                                    ?> 
                                                </div> -->
                                                <div class="form-group">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                                </div>
                              </form>
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
        $work_stats = "pending";
        $stats = "not archived";
        $submitted = "no";
        $sql = "SELECT * from tbl_students_work where title='$title' and name_of_teacher='$myfullname_' and work_status='$work_stats' and submitted='$submitted' and status='$stats'";
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
                  <th hidden="">ID</th>
                  <th>Student</th>
                  <th>Requirement</th>
                  <th>Attached File</th>
                  <th>Due Date</th>
                  <th>Turned In</th>
                  <th>Status</th>
                  <th>Action</th>  
              </center>
                </tr>
                <?php } else { echo "No data available in table"; }?>
              </thead>
              <tbody>
                <?php
                    require '../vendor/autoload.php';
                    $mail = new  PHPMailer(true);
                    //$mail->SMTPDebug = 1; //Enable verbose debug output
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
                    $mail->Username   = 'websiteet18@gmail.com';                     //SMTP username
                    $mail->Password   = 'empowermenttechnology';                               //SMTP password
                    $mail->SMTPSecure = "tls"; //Enable implicit TLS encryption
                    $mail->Port       = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                    while($row = mysqli_fetch_assoc($query)) {
                        $id = $row['id'];
                        $requirement_title = $row['title'];
                        $stud_fullname = $row['stud_name_and_id'];
                        $_SESSION['task_id_2'] = $row['id'];
                ?>
                <tr id="tra">
                    <td hidden=""><?php 
                            $_SESSION['t_id_works1'] = $_SESSION['task_id_2'];
                            echo $_SESSION['t_id_works1'];
                        ?>
                      </td>
                      <td><?php echo $row['stud_name_and_id']; ?></td>
                      <td><?php echo $row['title'];?> </td>
                      <td><?php if($row['sample_file'] != "") {?><b><a href="../admin/upload_docs/<?php echo $row['sample_file'];?>" target="_blank" title="Download File"><i class="fa fa-file"></i><?php echo $row['sample_file'];?></a> </b> <?php } else { echo "<font style='color: red;'>There's no attached file</font>"; } ?></td>
                      <td width="10%"><?php echo $row['date_of_submission']?></td>
                      <td>
                        <?php
                            $sql2 = "SELECT email from tbl_students where stud_fullname='$stud_fullname'";
                            $query2 = $conn->query($sql2);
                             //this lines of code will insert multiple data in rows in tbl_students_work
                            while($row2 = $query2->fetch_assoc()){
                                $get_email = $row2['email'];
                            }
                            //detect the dates
                            date_default_timezone_set('Asia/Manila'); 
                            $date = date('Y-m-d');
                            if($row['date_of_submission'] < $date){
                                //in this part, magnonotify sa email ng students kapag late na yung requirement nila(di pa napapasa), imbes na mag-spam sa email, ginawan ko ng update email late notify para isang beses lang magsend yung sa gmail nila kapag late na yung requirement nila
                                //if yung email notify late ay = sa unsent magnonotify sa email; else kapag hindi
                                if ($row['email_notify_late'] == "unsent") {
                                    //Recipients
                                    $mail->setFrom('websiteet18@gmail.com', $myfullname_);
                                    $mail->addAddress($get_email);//Name is optional

                                    //Content
                                    $mail->isHTML(true);//Set email format to HTML
                                    $mail->Subject = "e-OJT aCCeSs: Requirement Update";
                                    $template    = "Late Requirement: <b>".$requirement_title."</b><br>You are <b style='color: ghostwhite; background: red; padding: 2px; border-radius: 5px;'>LATE</b>. Please submit your requirement. ";
                                    $mail->Body = $template;
                                    $mail->send();
                                }
                                else if($row['email_notify_late'] == "sent"){
                                    echo "";
                                }
                                date_default_timezone_set('Asia/Manila'); 
                                $date = date('Y-m-d');

                                $no = "no";
                                $sent="sent";
                                $sql_update_late_sent = "UPDATE tbl_students_work set email_notify_late='$sent' WHERE date_of_submission<'$date' and submitted='$no'";
                                $query_run_late_sent = mysqli_query($conn, $sql_update_late_sent);

                                echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-danger'><font style='color: ghostwhite;'>LATE</span>";
                            }
                            //$counter = 0;
                            else if($row['date_of_submission'] == $date){
                                //in this part, magnonotify sa email ng students kapag due date na yung requirement nila(di pa napapasa), imbes na mag-spam sa email, ginawan ko ng update email due notify para isang beses lang magsend yung sa gmail nila kapag late na yung requirement nila
                                //if yung email notify due ay = sa unsent magnonotify sa email; else kapag hindi
                                if ($row['email_notify_due'] == "unsent") {
                                    try {
                                        require '../vendor/autoload.php';
                                        $mail = new  PHPMailer(true);
                                        //$mail->SMTPDebug = 1; //Enable verbose debug output
                                        $mail->isSMTP();                                            //Send using SMTP
                                        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                                        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
                                        $mail->Username   = 'websiteet18@gmail.com';                     //SMTP username
                                        $mail->Password   = 'empowermenttechnology';                               //SMTP password
                                        $mail->SMTPSecure = "tls"; //Enable implicit TLS encryption
                                        $mail->Port       = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                                        //Recipients
                                        $mail->setFrom('websiteet18@gmail.com', $myfullname_);
                                        $mail->addAddress($get_email);//Name is optional

                                        //Content
                                        $mail->isHTML(true);//Set email format to HTML
                                        $mail->Subject = "e-OJT aCCeSs: Requirement Update";
                                        $template    = "Requirement: <b>".$requirement_title."</b><br> Your requirement is <b style='color: black; background: yellow; padding: 2px; border-radius: 5px;'>DUE TODAY</b>. Please submit your requirement.";
                                        $mail->Body = $template;
                                        $mail->send();
                                    }
                                    catch(Exception $ex){
                                        //echo $ex;
                                    }
                                }
                                else if($row['email_notify_due'] == "sent"){
                                    echo "";//OKAY na
                                }
                                date_default_timezone_set('Asia/Manila'); 
                                $date = date('Y-m-d');
                                
                                $no = "no";
                                $sent="sent";
                                $sql_update_due_sent = "UPDATE tbl_students_work set email_notify_due='$sent' WHERE date_of_submission='$date' and submitted='$no'";
                                $query_run_due_sent = mysqli_query($conn, $sql_update_due_sent);

                                echo "<span style='font-size: 15px; margin-left: 0px; color: #262626;' class='badge badge-pill badge-warning'>DUE TODAY</span>";
                            }
                            else{
                                echo "<span style='font-size: 15px; background: orange; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-success'>ON-GOING</span>";
                            }
                        ?> 
                      </td>
                      <td width="15%">
                        <?php 
                            if ($row['work_status'] == 'pending') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' title='15% on progress'>15%</div>
                                        </div><b>PENDING</b>";
                            }

                            if ($row['work_status'] == 'semi-pending') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' title='25% on progress' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'>25%</div>
                                        </div><b>PENDING</b>";
                            }

                            if ($row['work_status'] == 'semi-pending2') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'>50%</div>
                                        </div><b>PENDING</b>";
                            }

                            if ($row['work_status'] == 'semi-pending3') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'>75%</div>
                                        </div><b>PENDING</b>";
                            }

                            if ($row['work_status'] == 'completed') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'>100%</div>
                                        </div><b>COMPLETED</b>";
                            }
                        ?>
                          
                      </td>
                      <td>
                          <a href="#view<?php echo $id;?>"  class="btn btn-info" data-toggle="modal" ><i class="fas fa-eye" title="View"></i></a>
                      </td>

                        <!-- View Modal -->
                        <div class="modal fade bd-example-modal-xl" data-backdrop="static" id="view<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="update_place" aria-hidden="true">
                          <div class="modal-dialog modal-xl" role="document" style="color:  #333333;">
                            <div class="modal-content modal-xl">
                              <div class="modal-header modal-xl">
                                <h5 class="modal-title" id="exampleModalLabel"><h style="color: #0d6efd"><i class="fas fa-file-alt"></i> <?php echo $row['title']; ?> </h><span><?php //echo $row['edited']; ?></span></h5>
                                   
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                                <div class="modal-header modal-xl">
                                    <p class="modal-title" id="exampleModalLabel">
                                        <h title="Date and Time Given"><i style="color: #1a8cff;" class="fas fa-clock"></i> <?php echo $row['date_']." at ".$row['time_'];  ?> <?php echo $row['edited'];?></h>
                                    </p> 
                                </div>
                              <input type="text" class="form-control" name="id" value="<?php echo $id;?>" hidden>
                                <div class="modal-body modal-xl">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Student: </label> <br>
                                                    <b> <?php echo $row['stud_name_and_id']; ?> </b>
                                                </div>
                                                <hr>
                                                <div class="form-group">
                                                    <label>Course, Year & Section: </label> <br>
                                                    <b> <?php echo $row['course']; ?> </b>
                                                </div>
                                                <!-- <hr>
                                                <div class="form-group">
                                                    <label>Requirement: </label> <br>
                                                    <b> <?php echo $row['title']; ?> </b>
                                                </div> -->
                                                <hr>
                                                <div class="form-group">
                                                    <label>Instructions: </label> <br>
                                                    <textarea style="background: ghostwhite;" rows="15" name="instructions" class="form-control" id="instructions" aria-describedby="" readonly required=""><?php echo $row['instructions'];?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Attached File</label>: <br>
                                                    <?php if($row['sample_file'] != "") { ?>
                                                    <b><a href="../admin/upload_docs/<?php echo $row['sample_file'];?>" target="_blank" title="Download File"><i class="fa fa-file"></i><?php echo $row['sample_file'];?></a> </b></a>
                                                    <?php } else { echo "<b style='color: red;'>There's no attached file</b>"; } ?>
                                                </div>
                                                <hr>
                                                <!-- selecting and concatenating the date and time from tbl_students_work -->
                                                <?php 
                                                    session_start();
                                                    $task_id = $_SESSION['t_id_works1'];
                                                    $sql1 = "SELECT Concat(date_,' ',time_) AS dateTTime1 FROM tbl_students_work where id='$task_id'";
                                                    $query1 = $conn->query($sql1);
                                                    while($row1 = $query1->fetch_assoc()){
                                                        $_SESSION['datetime2'] = $row1['dateTTime1'];
                                                    }
                                                ?>
                                                <div class="form-group">
                                                    <label>Status: </label> <br>
                                                    <?php 
                                                        if ($row['work_status'] == 'pending') {
                                                             echo "<div class='progress'>
                                                                      <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' title='15% on progress'>15%</div>
                                                                    </div><b>PENDING</b>";
                                                        }

                                                        if ($row['work_status'] == 'semi-pending') {
                                                             echo "<div class='progress'>
                                                                      <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' title='25% on progress' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'>25%</div>
                                                                    </div><b>PENDING</b>";
                                                        }

                                                        if ($row['work_status'] == 'semi-pending2') {
                                                             echo "<div class='progress'>
                                                                      <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'>50%</div>
                                                                    </div><b>PENDING</b>";
                                                        }

                                                        if ($row['work_status'] == 'semi-pending3') {
                                                             echo "<div class='progress'>
                                                                      <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'>75%</div>
                                                                    </div><b>PENDING</b>";
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
                                                    <label>Due Date:</label> <br>
                                                    <b><?php
                                                        echo $row['date_of_submission'];?></b>
                                                </div>
                                                <!-- <hr>
                                                <div class="form-group" >
                                                    <label>Turned In?:</label> <br>
                                                    <?php
                                                        date_default_timezone_set('Asia/Manila'); 
                                                        $date = date('Y-m-d');
                                                        if($row['date_of_submission'] < $date){
                                                            echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-danger'>LATE</span>";
                                                        }
                                                        else{
                                                            echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite; background: orange;' class='badge badge-pill badge-success'>ON-GOING</span>";
                                                        }
                                                    ?> 
                                                </div> -->
                                                <div class="form-group">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                                </div>
                              </form>
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
        $count1 = 1;
        $title = "Memorandum of Agreement";
        $myfullname_ = $_SESSION['coordinator_fullname_session'];
        $work_stats = "pending";
        $stats = "not archived";
        $submitted = "no";
        $sql = "SELECT * from tbl_students_work where title='$title' and name_of_teacher='$myfullname_' and work_status='$work_stats' and submitted='$submitted' and status='$stats'";
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
                  <th hidden="">ID</th>
                  <th>Student</th>
                  <th>Requirement</th>
                  <th>Attached File</th>
                  <th>Due Date</th>
                  <th>Turned In</th>
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
                        $requirement_title = $row['title'];
                        $stud_fullname = $row['stud_name_and_id'];
                        $_SESSION['task_id_2'] = $row['id'];
                ?>
                <tr id="tra">
                    <td hidden=""><?php 
                            $_SESSION['t_id_works1'] = $_SESSION['task_id_2'];
                            echo $_SESSION['t_id_works1'];
                        ?>
                      </td>
                      <td><?php echo $row['stud_name_and_id']; ?></td>
                      <td><?php echo $row['title'];?> </td>
                      <td><?php if($row['sample_file'] != "") {?><b><a href="../admin/upload_docs/<?php echo $row['sample_file'];?>" target="_blank" title="Download File"><i class="fa fa-file"></i><?php echo $row['sample_file'];?></a> </b> <?php } else { echo "<font style='color: red;'>There's no attached file</font>"; } ?></td>
                      <td width="10%"><?php echo $row['date_of_submission']?></td>
                      <td>
                        <?php
                            $sql2 = "SELECT email from tbl_students where stud_fullname='$stud_fullname'";
                            $query2 = $conn->query($sql2);
                             //this lines of code will insert multiple data in rows in tbl_students_work
                            while($row2 = $query2->fetch_assoc()){
                                $get_email = $row2['email'];
                            }
                            //detect the dates
                            date_default_timezone_set('Asia/Manila'); 
                            $date = date('Y-m-d');
                            if($row['date_of_submission'] < $date){
                                //in this part, magnonotify sa email ng students kapag late na yung requirement nila(di pa napapasa), imbes na mag-spam sa email, ginawan ko ng update email late notify para isang beses lang magsend yung sa gmail nila kapag late na yung requirement nila
                                //if yung email notify late ay = sa unsent magnonotify sa email; else kapag hindi
                                if ($row['email_notify_late'] == "unsent") {
                                    try {
                                        require '../vendor/autoload.php';
                                        $mail = new  PHPMailer(true);
                                        //$mail->SMTPDebug = 1; //Enable verbose debug output
                                        $mail->isSMTP();                                            //Send using SMTP
                                        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                                        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
                                        $mail->Username   = 'websiteet18@gmail.com';                     //SMTP username
                                        $mail->Password   = 'empowermenttechnology';                               //SMTP password
                                        $mail->SMTPSecure = "tls"; //Enable implicit TLS encryption
                                        $mail->Port       = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                                        //Recipients
                                        $mail->setFrom('websiteet18@gmail.com', $myfullname_);
                                        $mail->addAddress($get_email);//Name is optional

                                        //Content
                                        $mail->isHTML(true);//Set email format to HTML
                                        $mail->Subject = "e-OJT aCCeSs: Requirement Update";
                                        $template    = "Late Requirement: <b>".$requirement_title."</b><br>You are <b style='color: ghostwhite; background: red; padding: 2px; border-radius: 5px;'>LATE</b>. Please submit your requirement. ";
                                        $mail->Body = $template;
                                        $mail->send();
                                    }
                                    catch(Exception $ex){
                                        //echo $ex;
                                    }
                                }
                                else if($row['email_notify_late'] == "sent"){
                                    echo "";//OKAY na
                                }
                                date_default_timezone_set('Asia/Manila'); 
                                $date = date('Y-m-d');

                                $no = "no";
                                $sent="sent";
                                $sql_update_late_sent = "UPDATE tbl_students_work set email_notify_late='$sent' WHERE date_of_submission<'$date' and submitted='$no'";
                                $query_run_late_sent = mysqli_query($conn, $sql_update_late_sent);

                                echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-danger'><font style='color: ghostwhite;'>LATE</span>";
                            }
                            //$counter = 0;
                            else if($row['date_of_submission'] == $date){
                                //in this part, magnonotify sa email ng students kapag due date na yung requirement nila(di pa napapasa), imbes na mag-spam sa email, ginawan ko ng update email due notify para isang beses lang magsend yung sa gmail nila kapag late na yung requirement nila
                                //if yung email notify due ay = sa unsent magnonotify sa email; else kapag hindi
                                if ($row['email_notify_due'] == "unsent") {
                                    try {
                                        require '../vendor/autoload.php';
                                        $mail = new  PHPMailer(true);
                                        //$mail->SMTPDebug = 1; //Enable verbose debug output
                                        $mail->isSMTP();                                            //Send using SMTP
                                        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                                        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
                                        $mail->Username   = 'websiteet18@gmail.com';                     //SMTP username
                                        $mail->Password   = 'empowermenttechnology';                               //SMTP password
                                        $mail->SMTPSecure = "tls"; //Enable implicit TLS encryption
                                        $mail->Port       = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                                        //Recipients
                                        $mail->setFrom('websiteet18@gmail.com', $myfullname_);
                                        $mail->addAddress($get_email);//Name is optional

                                        //Content
                                        $mail->isHTML(true);//Set email format to HTML
                                        $mail->Subject = "e-OJT aCCeSs: Requirement Update";
                                        $template    = "Requirement: <b>".$requirement_title."</b><br> Your requirement is <b style='color: black; background: yellow; padding: 2px; border-radius: 5px;'>DUE TODAY</b>. Please submit your requirement.";
                                        $mail->Body = $template;
                                        $mail->send();
                                    }
                                    catch(Exception $ex){
                                        //echo $ex;
                                    }
                                }
                                else if($row['email_notify_due'] == "sent"){
                                    echo "";//OKAY na
                                }
                                date_default_timezone_set('Asia/Manila'); 
                                $date = date('Y-m-d');
                                
                                $no = "no";
                                $sent="sent";
                                $sql_update_due_sent = "UPDATE tbl_students_work set email_notify_due='$sent' WHERE date_of_submission='$date' and submitted='$no'";
                                $query_run_due_sent = mysqli_query($conn, $sql_update_due_sent);

                                echo "<span style='font-size: 15px; margin-left: 0px; color: #262626;' class='badge badge-pill badge-warning'>DUE TODAY</span>";
                            }
                            else{
                                echo "<span style='font-size: 15px; background: orange; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-success'>ON-GOING</span>";
                            }
                        ?> 
                      </td>
                      <td width="15%">
                        <?php 
                            if ($row['work_status'] == 'pending') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' title='15% on progress'>15%</div>
                                        </div><b>PENDING</b>";
                            }

                            if ($row['work_status'] == 'semi-pending') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' title='25% on progress' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'>25%</div>
                                        </div><b>PENDING</b>";
                            }

                            if ($row['work_status'] == 'semi-pending2') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'>50%</div>
                                        </div><b>PENDING</b>";
                            }

                            if ($row['work_status'] == 'semi-pending3') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'>75%</div>
                                        </div><b>PENDING</b>";
                            }

                            if ($row['work_status'] == 'completed') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'>100%</div>
                                        </div><b>COMPLETED</b>";
                            }
                        ?>
                      </td>
                      <td>
                          <a href="#view<?php echo $id;?>"  class="btn btn-info" data-toggle="modal" ><i class="fas fa-eye" title="View"></i></a>
                      </td>

                        <!-- View Modal -->
                        <div class="modal fade bd-example-modal-xl" data-backdrop="static" id="view<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="update_place" aria-hidden="true">
                          <div class="modal-dialog modal-xl" role="document" style="color:  #333333;">
                            <div class="modal-content modal-xl">
                              <div class="modal-header modal-xl">
                                <h5 class="modal-title" id="exampleModalLabel"><h style="color: #0d6efd"><i class="fas fa-file-alt"></i> <?php echo $row['title']; ?> </h><span><?php //echo $row['edited']; ?></span></h5>
                                   
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                                <div class="modal-header modal-xl">
                                    <p class="modal-title" id="exampleModalLabel">
                                        <h title="Date and Time Given"><i style="color: #1a8cff;" class="fas fa-clock"></i> <?php echo $row['date_']." at ".$row['time_'];  ?> <?php echo $row['edited'];?></h>
                                    </p> 
                                </div>
                              <input type="text" class="form-control" name="id" value="<?php echo $id;?>" hidden>
                                <div class="modal-body modal-xl">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Student: </label> <br>
                                                    <b> <?php echo $row['stud_name_and_id']; ?> </b>
                                                </div>
                                                <hr>
                                                <div class="form-group">
                                                    <label>Course, Year & Section: </label> <br>
                                                    <b> <?php echo $row['course']; ?> </b>
                                                </div>
                                                <!-- <hr>
                                                <div class="form-group">
                                                    <label>Requirement: </label> <br>
                                                    <b> <?php echo $row['title']; ?> </b>
                                                </div> -->
                                                <hr>
                                                <div class="form-group">
                                                    <label>Instructions: </label> <br>
                                                    <textarea style="background: ghostwhite;" rows="15" name="instructions" class="form-control" id="instructions" aria-describedby="" readonly required=""><?php echo $row['instructions'];?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Attached File</label>: <br>
                                                    <?php if($row['sample_file'] != "") { ?>
                                                    <b><a href="../admin/upload_docs/<?php echo $row['sample_file'];?>" target="_blank" title="Download File"><i class="fa fa-file"></i><?php echo $row['sample_file'];?></a> </b></a>
                                                    <?php } else { echo "<b style='color: red;'>There's no attached file</b>"; } ?>
                                                </div>
                                                <hr>
                                                <!-- selecting and concatenating the date and time from tbl_students_work -->
                                                <?php 
                                                    session_start();
                                                    $task_id = $_SESSION['t_id_works1'];
                                                    $sql1 = "SELECT Concat(date_,' ',time_) AS dateTTime1 FROM tbl_students_work where id='$task_id'";
                                                    $query1 = $conn->query($sql1);
                                                    while($row1 = $query1->fetch_assoc()){
                                                        $_SESSION['datetime2'] = $row1['dateTTime1'];
                                                    }
                                                ?>
                                                <div class="form-group">
                                                    <label>Status: </label> <br>
                                                    <?php 
                                                        if ($row['work_status'] == 'pending') {
                                                             echo "<div class='progress'>
                                                                      <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' title='15% on progress'>15%</div>
                                                                    </div><b>PENDING</b>";
                                                        }

                                                        if ($row['work_status'] == 'semi-pending') {
                                                             echo "<div class='progress'>
                                                                      <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' title='25% on progress' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'>25%</div>
                                                                    </div><b>PENDING</b>";
                                                        }

                                                        if ($row['work_status'] == 'semi-pending2') {
                                                             echo "<div class='progress'>
                                                                      <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'>50%</div>
                                                                    </div><b>PENDING</b>";
                                                        }

                                                        if ($row['work_status'] == 'semi-pending3') {
                                                             echo "<div class='progress'>
                                                                      <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'>75%</div>
                                                                    </div><b>PENDING</b>";
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
                                                    <label>Due Date:</label> <br>
                                                    <b><?php
                                                        echo $row['date_of_submission'];?></b>
                                                </div>
                                                <!-- <hr>
                                                <div class="form-group" >
                                                    <label>Turned In?:</label> <br>
                                                    <?php
                                                        date_default_timezone_set('Asia/Manila'); 
                                                        $date = date('Y-m-d');
                                                        if($row['date_of_submission'] < $date){
                                                            echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-danger'>LATE</span>";
                                                        }
                                                        else{
                                                            echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite; background: orange;' class='badge badge-pill badge-success'>ON-GOING</span>";
                                                        }
                                                    ?> 
                                                </div> -->
                                                <div class="form-group">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                                </div>
                              </form>
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
    else if($_POST['request'] == "Resume") {
        $count1 = 1;
        $title = "Resume";
        $myfullname_ = $_SESSION['coordinator_fullname_session'];
        $work_stats = "pending";
        $stats = "not archived";
        $submitted = "no";
        $sql = "SELECT * from tbl_students_work where title='$title' and name_of_teacher='$myfullname_' and work_status='$work_stats' and submitted='$submitted' and status='$stats'";
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
                  <th hidden="">ID</th>
                  <th>Student</th>
                  <th>Requirement</th>
                  <th>Attached File</th>
                  <th>Due Date</th>
                  <th>Turned In</th>
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
                    <td hidden=""><?php 
                            $_SESSION['t_id_works1'] = $_SESSION['task_id_2'];
                            echo $_SESSION['t_id_works1'];
                        ?>
                      </td>
                      <td><?php echo $row['stud_name_and_id']; ?></td>
                      <td><?php echo $row['title'];?> </td>
                      <td><?php if($row['sample_file'] != "") {?><b><a href="../admin/upload_docs/<?php echo $row['sample_file'];?>" target="_blank" title="Download File"><i class="fa fa-file"></i><?php echo $row['sample_file'];?></a> </b> <?php } else { echo "<font style='color: red;'>There's no attached file</font>"; } ?></td>
                      <td width="10%"><?php echo $row['date_of_submission']?></td>
                      <td>
                        <?php
                            $sql2 = "SELECT email from tbl_students where stud_fullname='$stud_fullname'";
                            $query2 = $conn->query($sql2);
                             //this lines of code will insert multiple data in rows in tbl_students_work
                            while($row2 = $query2->fetch_assoc()){
                                $get_email = $row2['email'];
                            }
                            //detect the dates
                            date_default_timezone_set('Asia/Manila'); 
                            $date = date('Y-m-d');
                            if($row['date_of_submission'] < $date){
                                //in this part, magnonotify sa email ng students kapag late na yung requirement nila(di pa napapasa), imbes na mag-spam sa email, ginawan ko ng update email late notify para isang beses lang magsend yung sa gmail nila kapag late na yung requirement nila
                                //if yung email notify late ay = sa unsent magnonotify sa email; else kapag hindi
                                if ($row['email_notify_late'] == "unsent") {
                                    try {
                                        require '../vendor/autoload.php';
                                        $mail = new  PHPMailer(true);
                                        //$mail->SMTPDebug = 1; //Enable verbose debug output
                                        $mail->isSMTP();                                            //Send using SMTP
                                        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                                        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
                                        $mail->Username   = 'websiteet18@gmail.com';                     //SMTP username
                                        $mail->Password   = 'empowermenttechnology';                               //SMTP password
                                        $mail->SMTPSecure = "tls"; //Enable implicit TLS encryption
                                        $mail->Port       = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                                        //Recipients
                                        $mail->setFrom('websiteet18@gmail.com', $myfullname_);
                                        $mail->addAddress($get_email);//Name is optional

                                        //Content
                                        $mail->isHTML(true);//Set email format to HTML
                                        $mail->Subject = "e-OJT aCCeSs: Requirement Update";
                                        $template    = "Late Requirement: <b>".$requirement_title."</b><br>You are <b style='color: ghostwhite; background: red; padding: 2px; border-radius: 5px;'>LATE</b>. Please submit your requirement. ";
                                        $mail->Body = $template;
                                        $mail->send();
                                    }
                                    catch(Exception $ex){
                                        //echo $ex;
                                    }
                                }
                                else if($row['email_notify_late'] == "sent"){
                                    echo "";//OKAY na
                                }
                                date_default_timezone_set('Asia/Manila'); 
                                $date = date('Y-m-d');

                                $no = "no";
                                $sent="sent";
                                $sql_update_late_sent = "UPDATE tbl_students_work set email_notify_late='$sent' WHERE date_of_submission<'$date' and submitted='$no'";
                                $query_run_late_sent = mysqli_query($conn, $sql_update_late_sent);

                                echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-danger'><font style='color: ghostwhite;'>LATE</span>";
                            }
                            //$counter = 0;
                            else if($row['date_of_submission'] == $date){
                                //in this part, magnonotify sa email ng students kapag due date na yung requirement nila(di pa napapasa), imbes na mag-spam sa email, ginawan ko ng update email due notify para isang beses lang magsend yung sa gmail nila kapag late na yung requirement nila
                                //if yung email notify due ay = sa unsent magnonotify sa email; else kapag hindi
                                if ($row['email_notify_due'] == "unsent") {
                                    try {
                                        require '../vendor/autoload.php';
                                        $mail = new  PHPMailer(true);
                                        //$mail->SMTPDebug = 1; //Enable verbose debug output
                                        $mail->isSMTP();                                            //Send using SMTP
                                        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                                        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
                                        $mail->Username   = 'websiteet18@gmail.com';                     //SMTP username
                                        $mail->Password   = 'empowermenttechnology';                               //SMTP password
                                        $mail->SMTPSecure = "tls"; //Enable implicit TLS encryption
                                        $mail->Port       = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                                        //Recipients
                                        $mail->setFrom('websiteet18@gmail.com', $myfullname_);
                                        $mail->addAddress($get_email);//Name is optional

                                        //Content
                                        $mail->isHTML(true);//Set email format to HTML
                                        $mail->Subject = "e-OJT aCCeSs: Requirement Update";
                                        $template    = "Requirement: <b>".$requirement_title."</b><br> Your requirement is <b style='color: black; background: yellow; padding: 2px; border-radius: 5px;'>DUE TODAY</b>. Please submit your requirement.";
                                        $mail->Body = $template;
                                        $mail->send();
                                    }
                                    catch(Exception $ex){
                                        //echo $ex;
                                    }
                                }
                                else if($row['email_notify_due'] == "sent"){
                                    echo "";//OKAY na
                                }
                                date_default_timezone_set('Asia/Manila'); 
                                $date = date('Y-m-d');
                                
                                $no = "no";
                                $sent="sent";
                                $sql_update_due_sent = "UPDATE tbl_students_work set email_notify_due='$sent' WHERE date_of_submission='$date' and submitted='$no'";
                                $query_run_due_sent = mysqli_query($conn, $sql_update_due_sent);

                                echo "<span style='font-size: 15px; margin-left: 0px; color: #262626;' class='badge badge-pill badge-warning'>DUE TODAY</span>";
                            }
                            else{
                                echo "<span style='font-size: 15px; background: orange; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-success'>ON-GOING</span>";
                            }
                        ?> 
                      </td>
                      <td width="15%">
                        <?php 
                            if ($row['work_status'] == 'pending') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' title='15% on progress'>15%</div>
                                        </div><b>PENDING</b>";
                            }

                            if ($row['work_status'] == 'semi-pending') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' title='25% on progress' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'>25%</div>
                                        </div><b>PENDING</b>";
                            }

                            if ($row['work_status'] == 'semi-pending2') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'>50%</div>
                                        </div><b>PENDING</b>";
                            }

                            if ($row['work_status'] == 'semi-pending3') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'>75%</div>
                                        </div><b>PENDING</b>";
                            }

                            if ($row['work_status'] == 'completed') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'>100%</div>
                                        </div><b>COMPLETED</b>";
                            }
                        ?>
                          
                      </td>
                      <td>
                          <a href="#view<?php echo $id;?>"  class="btn btn-info" data-toggle="modal" ><i class="fas fa-eye" title="View"></i></a>
                      </td>

                        <!-- View Modal -->
                        <div class="modal fade bd-example-modal-xl" data-backdrop="static" id="view<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="update_place" aria-hidden="true">
                          <div class="modal-dialog modal-xl" role="document" style="color:  #333333;">
                            <div class="modal-content modal-xl">
                              <div class="modal-header modal-xl">
                                <h5 class="modal-title" id="exampleModalLabel"><h style="color: #0d6efd"><i class="fas fa-file-alt"></i> <?php echo $row['title']; ?> </h><span><?php //echo $row['edited']; ?></span></h5>
                                   
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                                <div class="modal-header modal-xl">
                                    <p class="modal-title" id="exampleModalLabel">
                                        <h title="Date and Time Given"><i style="color: #1a8cff;" class="fas fa-clock"></i> <?php echo $row['date_']." at ".$row['time_'];  ?> <?php echo $row['edited'];?></h>
                                    </p> 
                                </div>
                              <input type="text" class="form-control" name="id" value="<?php echo $id;?>" hidden>
                                <div class="modal-body modal-xl">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Student: </label> <br>
                                                    <b> <?php echo $row['stud_name_and_id']; ?> </b>
                                                </div>
                                                <hr>
                                                <div class="form-group">
                                                    <label>Course, Year & Section: </label> <br>
                                                    <b> <?php echo $row['course']; ?> </b>
                                                </div>
                                                <!-- <hr>
                                                <div class="form-group">
                                                    <label>Requirement: </label> <br>
                                                    <b> <?php echo $row['title']; ?> </b>
                                                </div> -->
                                                <hr>
                                                <div class="form-group">
                                                    <label>Instructions: </label> <br>
                                                    <textarea style="background: ghostwhite;" rows="15" name="instructions" class="form-control" id="instructions" aria-describedby="" readonly required=""><?php echo $row['instructions'];?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Attached File</label>: <br>
                                                    <?php if($row['sample_file'] != "") { ?>
                                                    <b><a href="../admin/upload_docs/<?php echo $row['sample_file'];?>" target="_blank" title="Download File"><i class="fa fa-file"></i><?php echo $row['sample_file'];?></a> </b></a>
                                                    <?php } else { echo "<b style='color: red;'>There's no attached file</b>"; } ?>
                                                </div>
                                                <hr>
                                                <!-- selecting and concatenating the date and time from tbl_students_work -->
                                                <?php 
                                                    session_start();
                                                    $task_id = $_SESSION['t_id_works1'];
                                                    $sql1 = "SELECT Concat(date_,' ',time_) AS dateTTime1 FROM tbl_students_work where id='$task_id'";
                                                    $query1 = $conn->query($sql1);
                                                    while($row1 = $query1->fetch_assoc()){
                                                        $_SESSION['datetime2'] = $row1['dateTTime1'];
                                                    }
                                                ?>
                                                <div class="form-group">
                                                    <label>Status: </label> <br>
                                                    <?php 
                                                        if ($row['work_status'] == 'pending') {
                                                             echo "<div class='progress'>
                                                                      <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' title='15% on progress'>15%</div>
                                                                    </div><b>PENDING</b>";
                                                        }

                                                        if ($row['work_status'] == 'semi-pending') {
                                                             echo "<div class='progress'>
                                                                      <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' title='25% on progress' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'>25%</div>
                                                                    </div><b>PENDING</b>";
                                                        }

                                                        if ($row['work_status'] == 'semi-pending2') {
                                                             echo "<div class='progress'>
                                                                      <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'>50%</div>
                                                                    </div><b>PENDING</b>";
                                                        }

                                                        if ($row['work_status'] == 'semi-pending3') {
                                                             echo "<div class='progress'>
                                                                      <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'>75%</div>
                                                                    </div><b>PENDING</b>";
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
                                                    <label>Due Date:</label> <br>
                                                    <b><?php
                                                        echo $row['date_of_submission'];?></b>
                                                </div>
                                                <div class="form-group">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                                </div>
                              </form>
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
        $count1 = 1;
        $title = "Accomplishment Report";
        $myfullname_ = $_SESSION['coordinator_fullname_session'];
        $work_stats = "pending";
        $stats = "not archived";
        $submitted = "no";
        $sql = "SELECT * from tbl_students_work where title='$title' and name_of_teacher='$myfullname_' and work_status='$work_stats' and submitted='$submitted' and status='$stats'";
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
                  <th hidden="">ID</th>
                  <th>Student</th>
                  <th>Requirement</th>
                  <th>Attached File</th>
                  <th>Due Date</th>
                  <th>Turned In</th>
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
                    <td hidden=""><?php 
                            $_SESSION['t_id_works1'] = $_SESSION['task_id_2'];
                            echo $_SESSION['t_id_works1'];
                        ?>
                      </td>
                      <td><?php echo $row['stud_name_and_id']; ?></td>
                      <td><?php echo $row['title'];?> </td>
                      <td><?php if($row['sample_file'] != "") {?><b><a href="../admin/upload_docs/<?php echo $row['sample_file'];?>" target="_blank" title="Download File"><i class="fa fa-file"></i><?php echo $row['sample_file'];?></a> </b> <?php } else { echo "<font style='color: red;'>There's no attached file</font>"; } ?></td>
                      <td width="10%"><?php echo $row['date_of_submission']?></td>
                      <td>
                        <?php
                            $sql2 = "SELECT email from tbl_students where stud_fullname='$stud_fullname'";
                            $query2 = $conn->query($sql2);
                             //this lines of code will insert multiple data in rows in tbl_students_work
                            while($row2 = $query2->fetch_assoc()){
                                $get_email = $row2['email'];
                            }
                            //detect the dates
                            date_default_timezone_set('Asia/Manila'); 
                            $date = date('Y-m-d');
                            if($row['date_of_submission'] < $date){
                                //in this part, magnonotify sa email ng students kapag late na yung requirement nila(di pa napapasa), imbes na mag-spam sa email, ginawan ko ng update email late notify para isang beses lang magsend yung sa gmail nila kapag late na yung requirement nila
                                //if yung email notify late ay = sa unsent magnonotify sa email; else kapag hindi
                                if ($row['email_notify_late'] == "unsent") {
                                    try {
                                        require '../vendor/autoload.php';
                                        $mail = new  PHPMailer(true);
                                        //$mail->SMTPDebug = 1; //Enable verbose debug output
                                        $mail->isSMTP();                                            //Send using SMTP
                                        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                                        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
                                        $mail->Username   = 'websiteet18@gmail.com';                     //SMTP username
                                        $mail->Password   = 'empowermenttechnology';                               //SMTP password
                                        $mail->SMTPSecure = "tls"; //Enable implicit TLS encryption
                                        $mail->Port       = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                                        //Recipients
                                        $mail->setFrom('websiteet18@gmail.com', $myfullname_);
                                        $mail->addAddress($get_email);//Name is optional

                                        //Content
                                        $mail->isHTML(true);//Set email format to HTML
                                        $mail->Subject = "e-OJT aCCeSs: Requirement Update";
                                        $template    = "Late Requirement: <b>".$requirement_title."</b><br>You are <b style='color: ghostwhite; background: red; padding: 2px; border-radius: 5px;'>LATE</b>. Please submit your requirement. ";
                                        $mail->Body = $template;
                                        $mail->send();
                                    }
                                    catch(Exception $ex){
                                        //echo $ex;
                                    }
                                }
                                else if($row['email_notify_late'] == "sent"){
                                    echo "";//OKAY na
                                }
                                date_default_timezone_set('Asia/Manila'); 
                                $date = date('Y-m-d');

                                $no = "no";
                                $sent="sent";
                                $sql_update_late_sent = "UPDATE tbl_students_work set email_notify_late='$sent' WHERE date_of_submission<'$date' and submitted='$no'";
                                $query_run_late_sent = mysqli_query($conn, $sql_update_late_sent);

                                echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-danger'><font style='color: ghostwhite;'>LATE</span>";
                            }
                            //$counter = 0;
                            else if($row['date_of_submission'] == $date){
                                //in this part, magnonotify sa email ng students kapag due date na yung requirement nila(di pa napapasa), imbes na mag-spam sa email, ginawan ko ng update email due notify para isang beses lang magsend yung sa gmail nila kapag late na yung requirement nila
                                //if yung email notify due ay = sa unsent magnonotify sa email; else kapag hindi
                                if ($row['email_notify_due'] == "unsent") {
                                    try {
                                        require '../vendor/autoload.php';
                                        $mail = new  PHPMailer(true);
                                        //$mail->SMTPDebug = 1; //Enable verbose debug output
                                        $mail->isSMTP();                                            //Send using SMTP
                                        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                                        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
                                        $mail->Username   = 'websiteet18@gmail.com';                     //SMTP username
                                        $mail->Password   = 'empowermenttechnology';                               //SMTP password
                                        $mail->SMTPSecure = "tls"; //Enable implicit TLS encryption
                                        $mail->Port       = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                                        //Recipients
                                        $mail->setFrom('websiteet18@gmail.com', $myfullname_);
                                        $mail->addAddress($get_email);//Name is optional

                                        //Content
                                        $mail->isHTML(true);//Set email format to HTML
                                        $mail->Subject = "e-OJT aCCeSs: Requirement Update";
                                        $template    = "Requirement: <b>".$requirement_title."</b><br> Your requirement is <b style='color: black; background: yellow; padding: 2px; border-radius: 5px;'>DUE TODAY</b>. Please submit your requirement.";
                                        $mail->Body = $template;
                                        $mail->send();
                                    }
                                    catch(Exception $ex){
                                        //echo $ex;
                                    }
                                }
                                else if($row['email_notify_due'] == "sent"){
                                    echo "";//OKAY na
                                }
                                date_default_timezone_set('Asia/Manila'); 
                                $date = date('Y-m-d');
                                
                                $no = "no";
                                $sent="sent";
                                $sql_update_due_sent = "UPDATE tbl_students_work set email_notify_due='$sent' WHERE date_of_submission='$date' and submitted='$no'";
                                $query_run_due_sent = mysqli_query($conn, $sql_update_due_sent);

                                echo "<span style='font-size: 15px; margin-left: 0px; color: #262626;' class='badge badge-pill badge-warning'>DUE TODAY</span>";
                            }
                            else{
                                echo "<span style='font-size: 15px; background: orange; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-success'>ON-GOING</span>";
                            }
                        ?> 
                      </td>
                      <td width="15%">
                        <?php 
                            if ($row['work_status'] == 'pending') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' title='15% on progress'>15%</div>
                                        </div><b>PENDING</b>";
                            }

                            if ($row['work_status'] == 'semi-pending') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' title='25% on progress' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'>25%</div>
                                        </div><b>PENDING</b>";
                            }

                            if ($row['work_status'] == 'semi-pending2') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'>50%</div>
                                        </div><b>PENDING</b>";
                            }

                            if ($row['work_status'] == 'semi-pending3') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'>75%</div>
                                        </div><b>PENDING</b>";
                            }

                            if ($row['work_status'] == 'completed') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'>100%</div>
                                        </div><b>COMPLETED</b>";
                            }
                        ?>
                          
                      </td>
                      <td>
                          <a href="#view<?php echo $id;?>"  class="btn btn-info" data-toggle="modal" ><i class="fas fa-eye" title="View"></i></a>
                      </td>

                        <!-- View Modal -->
                        <div class="modal fade bd-example-modal-xl" data-backdrop="static" id="view<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="update_place" aria-hidden="true">
                          <div class="modal-dialog modal-xl" role="document" style="color:  #333333;">
                            <div class="modal-content modal-xl">
                              <div class="modal-header modal-xl">
                                <h5 class="modal-title" id="exampleModalLabel"><h style="color: #0d6efd"><i class="fas fa-file-alt"></i> <?php echo $row['title']; ?> </h><span><?php //echo $row['edited']; ?></span></h5>
                                   
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                                <div class="modal-header modal-xl">
                                    <p class="modal-title" id="exampleModalLabel">
                                        <h title="Date and Time Given"><i style="color: #1a8cff;" class="fas fa-clock"></i> <?php echo $row['date_']." at ".$row['time_'];  ?> <?php echo $row['edited'];?></h>
                                    </p> 
                                </div>
                              <input type="text" class="form-control" name="id" value="<?php echo $id;?>" hidden>
                                <div class="modal-body modal-xl">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Student: </label> <br>
                                                    <b> <?php echo $row['stud_name_and_id']; ?> </b>
                                                </div>
                                                <hr>
                                                <div class="form-group">
                                                    <label>Course, Year & Section: </label> <br>
                                                    <b> <?php echo $row['course']; ?> </b>
                                                </div>
                                                <!-- <hr>
                                                <div class="form-group">
                                                    <label>Requirement: </label> <br>
                                                    <b> <?php echo $row['title']; ?> </b>
                                                </div> -->
                                                <hr>
                                                <div class="form-group">
                                                    <label>Instructions: </label> <br>
                                                    <textarea style="background: ghostwhite;" rows="15" name="instructions" class="form-control" id="instructions" aria-describedby="" readonly required=""><?php echo $row['instructions'];?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Attached File</label>: <br>
                                                    <?php if($row['sample_file'] != "") { ?>
                                                    <b><a href="../admin/upload_docs/<?php echo $row['sample_file'];?>" target="_blank" title="Download File"><i class="fa fa-file"></i><?php echo $row['sample_file'];?></a> </b></a>
                                                    <?php } else { echo "<b style='color: red;'>There's no attached file</b>"; } ?>
                                                </div>
                                                <hr>
                                                <!-- selecting and concatenating the date and time from tbl_students_work -->
                                                <?php 
                                                    session_start();
                                                    $task_id = $_SESSION['t_id_works1'];
                                                    $sql1 = "SELECT Concat(date_,' ',time_) AS dateTTime1 FROM tbl_students_work where id='$task_id'";
                                                    $query1 = $conn->query($sql1);
                                                    while($row1 = $query1->fetch_assoc()){
                                                        $_SESSION['datetime2'] = $row1['dateTTime1'];
                                                    }
                                                ?>
                                                <div class="form-group">
                                                    <label>Status: </label> <br>
                                                    <?php 
                                                        if ($row['work_status'] == 'pending') {
                                                             echo "<div class='progress'>
                                                                      <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' title='15% on progress'>15%</div>
                                                                    </div><b>PENDING</b>";
                                                        }

                                                        if ($row['work_status'] == 'semi-pending') {
                                                             echo "<div class='progress'>
                                                                      <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' title='25% on progress' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'>25%</div>
                                                                    </div><b>PENDING</b>";
                                                        }

                                                        if ($row['work_status'] == 'semi-pending2') {
                                                             echo "<div class='progress'>
                                                                      <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'>50%</div>
                                                                    </div><b>PENDING</b>";
                                                        }

                                                        if ($row['work_status'] == 'semi-pending3') {
                                                             echo "<div class='progress'>
                                                                      <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'>75%</div>
                                                                    </div><b>PENDING</b>";
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
                                                    <label>Due Date:</label> <br>
                                                    <b><?php
                                                        echo $row['date_of_submission'];?></b>
                                                </div>
                                                <div class="form-group">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                                </div>
                              </form>
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
        $count1 = 1;
        $title = "Work Plan";
        $myfullname_ = $_SESSION['coordinator_fullname_session'];
        $work_stats = "pending";
        $stats = "not archived";
        $submitted = "no";
        $sql = "SELECT * from tbl_students_work where title='$title' and name_of_teacher='$myfullname_' and work_status='$work_stats' and submitted='$submitted' and status='$stats'";
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
                  <th hidden="">ID</th>
                  <th>Student</th>
                  <th>Requirement</th>
                  <th>Attached File</th>
                  <th>Due Date</th>
                  <th>Turned In</th>
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
                    <td hidden=""><?php 
                            $_SESSION['t_id_works1'] = $_SESSION['task_id_2'];
                            echo $_SESSION['t_id_works1'];
                        ?>
                      </td>
                      <td><?php echo $row['stud_name_and_id']; ?></td>
                      <td><?php echo $row['title'];?> </td>
                      <td><?php if($row['sample_file'] != "") {?><b><a href="../admin/upload_docs/<?php echo $row['sample_file'];?>" target="_blank" title="Download File"><i class="fa fa-file"></i><?php echo $row['sample_file'];?></a> </b> <?php } else { echo "<font style='color: red;'>There's no attached file</font>"; } ?></td>
                      <td width="10%"><?php echo $row['date_of_submission']?></td>
                      <td>
                        <?php
                            $sql2 = "SELECT email from tbl_students where stud_fullname='$stud_fullname'";
                            $query2 = $conn->query($sql2);
                             //this lines of code will insert multiple data in rows in tbl_students_work
                            while($row2 = $query2->fetch_assoc()){
                                $get_email = $row2['email'];
                            }
                            //detect the dates
                            date_default_timezone_set('Asia/Manila'); 
                            $date = date('Y-m-d');
                            if($row['date_of_submission'] < $date){
                                //in this part, magnonotify sa email ng students kapag late na yung requirement nila(di pa napapasa), imbes na mag-spam sa email, ginawan ko ng update email late notify para isang beses lang magsend yung sa gmail nila kapag late na yung requirement nila
                                //if yung email notify late ay = sa unsent magnonotify sa email; else kapag hindi
                                if ($row['email_notify_late'] == "unsent") {
                                    try {
                                        require '../vendor/autoload.php';
                                        $mail = new  PHPMailer(true);
                                        //$mail->SMTPDebug = 1; //Enable verbose debug output
                                        $mail->isSMTP();                                            //Send using SMTP
                                        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                                        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
                                        $mail->Username   = 'websiteet18@gmail.com';                     //SMTP username
                                        $mail->Password   = 'empowermenttechnology';                               //SMTP password
                                        $mail->SMTPSecure = "tls"; //Enable implicit TLS encryption
                                        $mail->Port       = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                                        //Recipients
                                        $mail->setFrom('websiteet18@gmail.com', $myfullname_);
                                        $mail->addAddress($get_email);//Name is optional

                                        //Content
                                        $mail->isHTML(true);//Set email format to HTML
                                        $mail->Subject = "e-OJT aCCeSs: Requirement Update";
                                        $template    = "Late Requirement: <b>".$requirement_title."</b><br>You are <b style='color: ghostwhite; background: red; padding: 2px; border-radius: 5px;'>LATE</b>. Please submit your requirement. ";
                                        $mail->Body = $template;
                                        $mail->send();
                                    }
                                    catch(Exception $ex){
                                        //echo $ex;
                                    }
                                }
                                else if($row['email_notify_late'] == "sent"){
                                    echo "";//OKAY na
                                }
                                date_default_timezone_set('Asia/Manila'); 
                                $date = date('Y-m-d');

                                $no = "no";
                                $sent="sent";
                                $sql_update_late_sent = "UPDATE tbl_students_work set email_notify_late='$sent' WHERE date_of_submission<'$date' and submitted='$no'";
                                $query_run_late_sent = mysqli_query($conn, $sql_update_late_sent);

                                echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-danger'><font style='color: ghostwhite;'>LATE</span>";
                            }
                            //$counter = 0;
                            else if($row['date_of_submission'] == $date){
                                //in this part, magnonotify sa email ng students kapag due date na yung requirement nila(di pa napapasa), imbes na mag-spam sa email, ginawan ko ng update email due notify para isang beses lang magsend yung sa gmail nila kapag late na yung requirement nila
                                //if yung email notify due ay = sa unsent magnonotify sa email; else kapag hindi
                                if ($row['email_notify_due'] == "unsent") {
                                    try {
                                        require '../vendor/autoload.php';
                                        $mail = new  PHPMailer(true);
                                        //$mail->SMTPDebug = 1; //Enable verbose debug output
                                        $mail->isSMTP();                                            //Send using SMTP
                                        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                                        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
                                        $mail->Username   = 'websiteet18@gmail.com';                     //SMTP username
                                        $mail->Password   = 'empowermenttechnology';                               //SMTP password
                                        $mail->SMTPSecure = "tls"; //Enable implicit TLS encryption
                                        $mail->Port       = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                                        //Recipients
                                        $mail->setFrom('websiteet18@gmail.com', $myfullname_);
                                        $mail->addAddress($get_email);//Name is optional

                                        //Content
                                        $mail->isHTML(true);//Set email format to HTML
                                        $mail->Subject = "e-OJT aCCeSs: Requirement Update";
                                        $template    = "Requirement: <b>".$requirement_title."</b><br> Your requirement is <b style='color: black; background: yellow; padding: 2px; border-radius: 5px;'>DUE TODAY</b>. Please submit your requirement.";
                                        $mail->Body = $template;
                                        $mail->send();
                                    }
                                    catch(Exception $ex){
                                        //echo $ex;
                                    }
                                }
                                else if($row['email_notify_due'] == "sent"){
                                    echo "";//OKAY na
                                }
                                date_default_timezone_set('Asia/Manila'); 
                                $date = date('Y-m-d');
                                
                                $no = "no";
                                $sent="sent";
                                $sql_update_due_sent = "UPDATE tbl_students_work set email_notify_due='$sent' WHERE date_of_submission='$date' and submitted='$no'";
                                $query_run_due_sent = mysqli_query($conn, $sql_update_due_sent);

                                echo "<span style='font-size: 15px; margin-left: 0px; color: #262626;' class='badge badge-pill badge-warning'>DUE TODAY</span>";
                            }
                            else{
                                echo "<span style='font-size: 15px; margin-left: 0px; color: ghostwhite; background: orange;' class='badge badge-pill badge-success' style='background: orange'>ON-GOING</span>";
                            }
                        ?> 
                      </td>
                      <td width="15%">
                        <?php 
                            if ($row['work_status'] == 'pending') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' title='15% on progress'>15%</div>
                                        </div><b>PENDING</b>";
                            }

                            if ($row['work_status'] == 'semi-pending') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' title='25% on progress' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'>25%</div>
                                        </div><b>PENDING</b>";
                            }

                            if ($row['work_status'] == 'semi-pending2') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'>50%</div>
                                        </div><b>PENDING</b>";
                            }

                            if ($row['work_status'] == 'semi-pending3') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'>75%</div>
                                        </div><b>PENDING</b>";
                            }

                            if ($row['work_status'] == 'completed') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'>100%</div>
                                        </div><b>COMPLETED</b>";
                            }
                        ?>
                          
                      </td>
                      <td>
                          <a href="#view<?php echo $id;?>"  class="btn btn-info" data-toggle="modal" ><i class="fas fa-eye" title="View"></i></a>
                      </td>

                        <!-- View Modal -->
                        <div class="modal fade bd-example-modal-xl" data-backdrop="static" id="view<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="update_place" aria-hidden="true">
                          <div class="modal-dialog modal-xl" role="document" style="color:  #333333;">
                            <div class="modal-content modal-xl">
                              <div class="modal-header modal-xl">
                                <h5 class="modal-title" id="exampleModalLabel"><h style="color: #0d6efd"><i class="fas fa-file-alt"></i> <?php echo $row['title']; ?> </h><span><?php //echo $row['edited']; ?></span></h5>
                                   
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                                <div class="modal-header modal-xl">
                                    <p class="modal-title" id="exampleModalLabel">
                                        <h title="Date and Time Given"><i style="color: #1a8cff;" class="fas fa-clock"></i> <?php echo $row['date_']." at ".$row['time_'];  ?> <?php echo $row['edited'];?></h>
                                    </p> 
                                </div>
                              <input type="text" class="form-control" name="id" value="<?php echo $id;?>" hidden>
                                <div class="modal-body modal-xl">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Student: </label> <br>
                                                    <b> <?php echo $row['stud_name_and_id']; ?> </b>
                                                </div>
                                                <hr>
                                                <div class="form-group">
                                                    <label>Course, Year & Section: </label> <br>
                                                    <b> <?php echo $row['course']; ?> </b>
                                                </div>
                                                <!-- <hr>
                                                <div class="form-group">
                                                    <label>Requirement: </label> <br>
                                                    <b> <?php echo $row['title']; ?> </b>
                                                </div> -->
                                                <hr>
                                                <div class="form-group">
                                                    <label>Instructions: </label> <br>
                                                    <textarea style="background: ghostwhite;" rows="15" name="instructions" class="form-control" id="instructions" aria-describedby="" readonly required=""><?php echo $row['instructions'];?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Attached File</label>: <br>
                                                    <?php if($row['sample_file'] != "") { ?>
                                                    <b><a href="../admin/upload_docs/<?php echo $row['sample_file'];?>" target="_blank" title="Download File"><i class="fa fa-file"></i><?php echo $row['sample_file'];?></a> </b></a>
                                                    <?php } else { echo "<b style='color: red;'>There's no attached file</b>"; } ?>
                                                </div>
                                                <hr>
                                                <!-- selecting and concatenating the date and time from tbl_students_work -->
                                                <?php 
                                                    session_start();
                                                    $task_id = $_SESSION['t_id_works1'];
                                                    $sql1 = "SELECT Concat(date_,' ',time_) AS dateTTime1 FROM tbl_students_work where id='$task_id'";
                                                    $query1 = $conn->query($sql1);
                                                    while($row1 = $query1->fetch_assoc()){
                                                        $_SESSION['datetime2'] = $row1['dateTTime1'];
                                                    }
                                                ?>
                                                <div class="form-group">
                                                    <label>Status: </label> <br>
                                                    <?php 
                                                        if ($row['work_status'] == 'pending') {
                                                             echo "<div class='progress'>
                                                                      <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' title='15% on progress'>15%</div>
                                                                    </div><b>PENDING</b>";
                                                        }

                                                        if ($row['work_status'] == 'semi-pending') {
                                                             echo "<div class='progress'>
                                                                      <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' title='25% on progress' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'>25%</div>
                                                                    </div><b>PENDING</b>";
                                                        }

                                                        if ($row['work_status'] == 'semi-pending2') {
                                                             echo "<div class='progress'>
                                                                      <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'>50%</div>
                                                                    </div><b>PENDING</b>";
                                                        }

                                                        if ($row['work_status'] == 'semi-pending3') {
                                                             echo "<div class='progress'>
                                                                      <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'>75%</div>
                                                                    </div><b>PENDING</b>";
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
                                                    <label>Due Date:</label> <br>
                                                    <b><?php
                                                        echo $row['date_of_submission'];?></b>
                                                </div>
                                                <div class="form-group">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                                </div>
                              </form>
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
        $count1 = 1;
        $title = "Response Letter";
        $myfullname_ = $_SESSION['coordinator_fullname_session'];
        $work_stats = "pending";
        $stats = "not archived";
        $submitted = "no";
        $sql = "SELECT * from tbl_students_work where title='$title' and name_of_teacher='$myfullname_' and work_status='$work_stats' and submitted='$submitted' and status='$stats'";
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
                  <th hidden="">ID</th>
                  <th>Student</th>
                  <th>Requirement</th>
                  <th>Attached File</th>
                  <th>Due Date</th>
                  <th>Turned In</th>
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
                    <td hidden=""><?php 
                            $_SESSION['t_id_works1'] = $_SESSION['task_id_2'];
                            echo $_SESSION['t_id_works1'];
                        ?>
                      </td>
                      <td><?php echo $row['stud_name_and_id']; ?></td>
                      <td><?php echo $row['title'];?> </td>
                      <td><?php if($row['sample_file'] != "") {?><b><a href="../admin/upload_docs/<?php echo $row['sample_file'];?>" target="_blank" title="Download File"><i class="fa fa-file"></i><?php echo $row['sample_file'];?></a> </b> <?php } else { echo "<font style='color: red;'>There's no attached file</font>"; } ?></td>
                      <td width="10%"><?php echo $row['date_of_submission']?></td>
                      <td>
                        <?php
                            $sql2 = "SELECT email from tbl_students where stud_fullname='$stud_fullname'";
                            $query2 = $conn->query($sql2);
                            //this lines of code will insert multiple data in rows in tbl_students_work
                            while($row2 = $query2->fetch_assoc()){
                                $get_email = $row2['email'];
                            }
                            //detect the dates
                            date_default_timezone_set('Asia/Manila'); 
                            $date = date('Y-m-d');
                            if($row['date_of_submission'] < $date){
                                //in this part, magnonotify sa email ng students kapag late na yung requirement nila(di pa napapasa), imbes na mag-spam sa email, ginawan ko ng update email late notify para isang beses lang magsend yung sa gmail nila kapag late na yung requirement nila
                                //if yung email notify late ay = sa unsent magnonotify sa email; else kapag hindi
                                if ($row['email_notify_late'] == "unsent") {
                                    try {
                                        require '../vendor/autoload.php';
                                        $mail = new  PHPMailer(true);
                                        //$mail->SMTPDebug = 1; //Enable verbose debug output
                                        $mail->isSMTP();                                            //Send using SMTP
                                        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                                        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
                                        $mail->Username   = 'websiteet18@gmail.com';                     //SMTP username
                                        $mail->Password   = 'empowermenttechnology';                               //SMTP password
                                        $mail->SMTPSecure = "tls"; //Enable implicit TLS encryption
                                        $mail->Port       = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                                        //Recipients
                                        $mail->setFrom('websiteet18@gmail.com', $myfullname_);
                                        $mail->addAddress($get_email);//Name is optional

                                        //Content
                                        $mail->isHTML(true);//Set email format to HTML
                                        $mail->Subject = "e-OJT aCCeSs: Requirement Update";
                                        $template    = "Late Requirement: <b>".$requirement_title."</b><br>You are <b style='color: ghostwhite; background: red; padding: 2px; border-radius: 5px;'>LATE</b>. Please submit your requirement. ";
                                        $mail->Body = $template;
                                        $mail->send();
                                    }
                                    catch(Exception $ex){
                                        //echo $ex;
                                    }
                                }
                                else if($row['email_notify_late'] == "sent"){
                                    echo "";//OKAY na
                                }
                                date_default_timezone_set('Asia/Manila'); 
                                $date = date('Y-m-d');

                                $no = "no";
                                $sent="sent";
                                $sql_update_late_sent = "UPDATE tbl_students_work set email_notify_late='$sent' WHERE date_of_submission<'$date' and submitted='$no'";
                                $query_run_late_sent = mysqli_query($conn, $sql_update_late_sent);

                                echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-danger'><font style='color: ghostwhite;'>LATE</span>";
                            }
                            //$counter = 0;
                            else if($row['date_of_submission'] == $date){
                                //in this part, magnonotify sa email ng students kapag due date na yung requirement nila(di pa napapasa), imbes na mag-spam sa email, ginawan ko ng update email due notify para isang beses lang magsend yung sa gmail nila kapag late na yung requirement nila
                                //if yung email notify due ay = sa unsent magnonotify sa email; else kapag hindi
                                if ($row['email_notify_due'] == "unsent") {
                                    try {
                                        require '../vendor/autoload.php';
                                        $mail = new  PHPMailer(true);
                                        //$mail->SMTPDebug = 1; //Enable verbose debug output
                                        $mail->isSMTP();                                            //Send using SMTP
                                        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                                        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
                                        $mail->Username   = 'websiteet18@gmail.com';                     //SMTP username
                                        $mail->Password   = 'empowermenttechnology';                               //SMTP password
                                        $mail->SMTPSecure = "tls"; //Enable implicit TLS encryption
                                        $mail->Port       = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                                        //Recipients
                                        $mail->setFrom('websiteet18@gmail.com', $myfullname_);
                                        $mail->addAddress($get_email);//Name is optional

                                        //Content
                                        $mail->isHTML(true);//Set email format to HTML
                                        $mail->Subject = "e-OJT aCCeSs: Requirement Update";
                                        $template    = "Requirement: <b>".$requirement_title."</b><br> Your requirement is <b style='color: black; background: yellow; padding: 2px; border-radius: 5px;'>DUE TODAY</b>. Please submit your requirement.";
                                        $mail->Body = $template;
                                        $mail->send();
                                    }
                                    catch(Exception $ex){
                                        //echo $ex;
                                    }
                                }
                                else if($row['email_notify_due'] == "sent"){
                                    echo "";//OKAY na
                                }
                                date_default_timezone_set('Asia/Manila'); 
                                $date = date('Y-m-d');
                                
                                $no = "no";
                                $sent="sent";
                                $sql_update_due_sent = "UPDATE tbl_students_work set email_notify_due='$sent' WHERE date_of_submission='$date' and submitted='$no'";
                                $query_run_due_sent = mysqli_query($conn, $sql_update_due_sent);

                                echo "<span style='font-size: 15px; margin-left: 0px; color: #262626;' class='badge badge-pill badge-warning'>DUE TODAY</span>";
                            }
                            else{
                                echo "<span style='font-size: 15px; background: orange; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-success'>ON-GOING</span>";
                            }
                        ?> 
                      </td>
                      <td width="15%">
                        <?php 
                            if ($row['work_status'] == 'pending') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' title='15% on progress'>15%</div>
                                        </div><b>PENDING</b>";
                            }

                            if ($row['work_status'] == 'semi-pending') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' title='25% on progress' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'>25%</div>
                                        </div><b>PENDING</b>";
                            }

                            if ($row['work_status'] == 'semi-pending2') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'>50%</div>
                                        </div><b>PENDING</b>";
                            }

                            if ($row['work_status'] == 'semi-pending3') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'>75%</div>
                                        </div><b>PENDING</b>";
                            }

                            if ($row['work_status'] == 'completed') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'>100%</div>
                                        </div><b>COMPLETED</b>";
                            }
                        ?>
                          
                      </td>
                      <td>
                          <a href="#view<?php echo $id;?>"  class="btn btn-info" data-toggle="modal" ><i class="fas fa-eye" title="View"></i></a>
                      </td>

                        <!-- View Modal -->
                        <div class="modal fade bd-example-modal-xl" data-backdrop="static" id="view<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="update_place" aria-hidden="true">
                          <div class="modal-dialog modal-xl" role="document" style="color:  #333333;">
                            <div class="modal-content modal-xl">
                              <div class="modal-header modal-xl">
                                <h5 class="modal-title" id="exampleModalLabel"><h style="color: #0d6efd"><i class="fas fa-file-alt"></i> <?php echo $row['title']; ?> </h><span><?php //echo $row['edited']; ?></span></h5>
                                   
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                                <div class="modal-header modal-xl">
                                    <p class="modal-title" id="exampleModalLabel">
                                        <h title="Date and Time Given"><i style="color: #1a8cff;" class="fas fa-clock"></i> <?php echo $row['date_']." at ".$row['time_'];  ?> <?php echo $row['edited'];?></h>
                                    </p> 
                                </div>
                              <input type="text" class="form-control" name="id" value="<?php echo $id;?>" hidden>
                                <div class="modal-body modal-xl">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Student: </label> <br>
                                                    <b> <?php echo $row['stud_name_and_id']; ?> </b>
                                                </div>
                                                <hr>
                                                <div class="form-group">
                                                    <label>Course, Year & Section: </label> <br>
                                                    <b> <?php echo $row['course']; ?> </b>
                                                </div>
                                                <!-- <hr>
                                                <div class="form-group">
                                                    <label>Requirement: </label> <br>
                                                    <b> <?php echo $row['title']; ?> </b>
                                                </div> -->
                                                <hr>
                                                <div class="form-group">
                                                    <label>Instructions: </label> <br>
                                                    <textarea style="background: ghostwhite;" rows="15" name="instructions" class="form-control" id="instructions" aria-describedby="" readonly required=""><?php echo $row['instructions'];?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Attached File</label>: <br>
                                                    <?php if($row['sample_file'] != "") { ?>
                                                    <b><a href="../admin/upload_docs/<?php echo $row['sample_file'];?>" target="_blank" title="Download File"><i class="fa fa-file"></i><?php echo $row['sample_file'];?></a> </b></a>
                                                    <?php } else { echo "<b style='color: red;'>There's no attached file</b>"; } ?>
                                                </div>
                                                <hr>
                                                <!-- selecting and concatenating the date and time from tbl_students_work -->
                                                <?php 
                                                    session_start();
                                                    $task_id = $_SESSION['t_id_works1'];
                                                    $sql1 = "SELECT Concat(date_,' ',time_) AS dateTTime1 FROM tbl_students_work where id='$task_id'";
                                                    $query1 = $conn->query($sql1);
                                                    while($row1 = $query1->fetch_assoc()){
                                                        $_SESSION['datetime2'] = $row1['dateTTime1'];
                                                    }
                                                ?>
                                                <div class="form-group">
                                                    <label>Status: </label> <br>
                                                    <?php 
                                                        if ($row['work_status'] == 'pending') {
                                                             echo "<div class='progress'>
                                                                      <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' title='15% on progress'>15%</div>
                                                                    </div><b>PENDING</b>";
                                                        }

                                                        if ($row['work_status'] == 'semi-pending') {
                                                             echo "<div class='progress'>
                                                                      <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' title='25% on progress' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'>25%</div>
                                                                    </div><b>PENDING</b>";
                                                        }

                                                        if ($row['work_status'] == 'semi-pending2') {
                                                             echo "<div class='progress'>
                                                                      <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'>50%</div>
                                                                    </div><b>PENDING</b>";
                                                        }

                                                        if ($row['work_status'] == 'semi-pending3') {
                                                             echo "<div class='progress'>
                                                                      <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'>75%</div>
                                                                    </div><b>PENDING</b>";
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
                                                    <label>Due Date:</label> <br>
                                                    <b><?php
                                                        echo $row['date_of_submission'];?></b>
                                                </div>
                                                <div class="form-group">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                                </div>
                              </form>
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
        $count1 = 1;
        $title = "Narrative";
        $myfullname_ = $_SESSION['coordinator_fullname_session'];
        $work_stats = "pending";
        $stats = "not archived";
        $submitted = "no";
        $sql = "SELECT * from tbl_students_work where title='$title' and name_of_teacher='$myfullname_' and work_status='$work_stats' and submitted='$submitted' and status='$stats'";
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
                  <th hidden="">ID</th>
                  <th>Student</th>
                  <th>Requirement</th>
                  <th>Attached File</th>
                  <th>Due Date</th>
                  <th>Turned In</th>
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
                    <td hidden=""><?php 
                            $_SESSION['t_id_works1'] = $_SESSION['task_id_2'];
                            echo $_SESSION['t_id_works1'];
                        ?>
                      </td>
                      <td><?php echo $row['stud_name_and_id']; ?></td>
                      <td><?php echo $row['title'];?> </td>
                      <td><?php if($row['sample_file'] != "") {?><b><a href="../admin/upload_docs/<?php echo $row['sample_file'];?>" target="_blank" title="Download File"><i class="fa fa-file"></i><?php echo $row['sample_file'];?></a> </b> <?php } else { echo "<font style='color: red;'>There's no attached file</font>"; } ?></td>
                      <td width="10%"><?php echo $row['date_of_submission']?></td>
                      <td>
                        <?php
                            $sql2 = "SELECT email from tbl_students where stud_fullname='$stud_fullname'";
                            $query2 = $conn->query($sql2);
                             //this lines of code will insert multiple data in rows in tbl_students_work
                            while($row2 = $query2->fetch_assoc()){
                                $get_email = $row2['email'];
                            }
                            //detect the dates
                            date_default_timezone_set('Asia/Manila'); 
                            $date = date('Y-m-d');
                            if($row['date_of_submission'] < $date){
                                //in this part, magnonotify sa email ng students kapag late na yung requirement nila(di pa napapasa), imbes na mag-spam sa email, ginawan ko ng update email late notify para isang beses lang magsend yung sa gmail nila kapag late na yung requirement nila
                                //if yung email notify late ay = sa unsent magnonotify sa email; else kapag hindi
                                if ($row['email_notify_late'] == "unsent") {
                                    try {
                                        require '../vendor/autoload.php';
                                        $mail = new  PHPMailer(true);
                                        //$mail->SMTPDebug = 1; //Enable verbose debug output
                                        $mail->isSMTP();                                            //Send using SMTP
                                        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                                        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
                                        $mail->Username   = 'websiteet18@gmail.com';                     //SMTP username
                                        $mail->Password   = 'empowermenttechnology';                               //SMTP password
                                        $mail->SMTPSecure = "tls"; //Enable implicit TLS encryption
                                        $mail->Port       = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                                        //Recipients
                                        $mail->setFrom('websiteet18@gmail.com', $myfullname_);
                                        $mail->addAddress($get_email);//Name is optional

                                        //Content
                                        $mail->isHTML(true);//Set email format to HTML
                                        $mail->Subject = "e-OJT aCCeSs: Requirement Update";
                                        $template    = "Late Requirement: <b>".$requirement_title."</b><br>You are <b style='color: ghostwhite; background: red; padding: 2px; border-radius: 5px;'>LATE</b>. Please submit your requirement. ";
                                        $mail->Body = $template;
                                        $mail->send();
                                    }
                                    catch(Exception $ex){
                                        //echo $ex;
                                    }
                                }
                                else if($row['email_notify_late'] == "sent"){
                                    echo "";//OKAY na
                                }
                                date_default_timezone_set('Asia/Manila'); 
                                $date = date('Y-m-d');

                                $no = "no";
                                $sent="sent";
                                $sql_update_late_sent = "UPDATE tbl_students_work set email_notify_late='$sent' WHERE date_of_submission<'$date' and submitted='$no'";
                                $query_run_late_sent = mysqli_query($conn, $sql_update_late_sent);

                                echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-danger'><font style='color: ghostwhite;'>LATE</span>";
                            }
                            //$counter = 0;
                            else if($row['date_of_submission'] == $date){
                                //in this part, magnonotify sa email ng students kapag due date na yung requirement nila(di pa napapasa), imbes na mag-spam sa email, ginawan ko ng update email due notify para isang beses lang magsend yung sa gmail nila kapag late na yung requirement nila
                                //if yung email notify due ay = sa unsent magnonotify sa email; else kapag hindi
                                if ($row['email_notify_due'] == "unsent") {
                                    try {
                                        require '../vendor/autoload.php';
                                        $mail = new  PHPMailer(true);
                                        //$mail->SMTPDebug = 1; //Enable verbose debug output
                                        $mail->isSMTP();                                            //Send using SMTP
                                        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                                        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
                                        $mail->Username   = 'websiteet18@gmail.com';                     //SMTP username
                                        $mail->Password   = 'empowermenttechnology';                               //SMTP password
                                        $mail->SMTPSecure = "tls"; //Enable implicit TLS encryption
                                        $mail->Port       = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                                        //Recipients
                                        $mail->setFrom('websiteet18@gmail.com', $myfullname_);
                                        $mail->addAddress($get_email);//Name is optional

                                        //Content
                                        $mail->isHTML(true);//Set email format to HTML
                                        $mail->Subject = "e-OJT aCCeSs: Requirement Update";
                                        $template    = "Requirement: <b>".$requirement_title."</b><br> Your requirement is <b style='color: black; background: yellow; padding: 2px; border-radius: 5px;'>DUE TODAY</b>. Please submit your requirement.";
                                        $mail->Body = $template;
                                        $mail->send();
                                    }
                                    catch(Exception $ex){
                                        //echo $ex;
                                    }
                                }
                                else if($row['email_notify_due'] == "sent"){
                                    echo "";//OKAY na
                                }
                                date_default_timezone_set('Asia/Manila'); 
                                $date = date('Y-m-d');
                                
                                $no = "no";
                                $sent="sent";
                                $sql_update_due_sent = "UPDATE tbl_students_work set email_notify_due='$sent' WHERE date_of_submission='$date' and submitted='$no'";
                                $query_run_due_sent = mysqli_query($conn, $sql_update_due_sent);

                                echo "<span style='font-size: 15px; margin-left: 0px; color: #262626;' class='badge badge-pill badge-warning'>DUE TODAY</span>";
                            }
                            else{
                                echo "<span style='font-size: 15px; background: orange; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-success'>ON-GOING</span>";
                            }
                        ?> 
                      </td>
                      <td width="15%">
                        <?php 
                            if ($row['work_status'] == 'pending') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' title='15% on progress'>15%</div>
                                        </div><b>PENDING</b>";
                            }

                            if ($row['work_status'] == 'semi-pending') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' title='25% on progress' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'>25%</div>
                                        </div><b>PENDING</b>";
                            }

                            if ($row['work_status'] == 'semi-pending2') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'>50%</div>
                                        </div><b>PENDING</b>";
                            }

                            if ($row['work_status'] == 'semi-pending3') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'>75%</div>
                                        </div><b>PENDING</b>";
                            }

                            if ($row['work_status'] == 'completed') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'>100%</div>
                                        </div><b>COMPLETED</b>";
                            }
                        ?>
                          
                      </td>
                      <td>
                          <a href="#view<?php echo $id;?>"  class="btn btn-info" data-toggle="modal" ><i class="fas fa-eye" title="View"></i></a>
                      </td>

                        <!-- View Modal -->
                        <div class="modal fade bd-example-modal-xl" data-backdrop="static" id="view<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="update_place" aria-hidden="true">
                          <div class="modal-dialog modal-xl" role="document" style="color:  #333333;">
                            <div class="modal-content modal-xl">
                              <div class="modal-header modal-xl">
                                <h5 class="modal-title" id="exampleModalLabel"><h style="color: #0d6efd"><i class="fas fa-file-alt"></i> <?php echo $row['title']; ?> </h><span><?php //echo $row['edited']; ?></span></h5>
                                   
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                                <div class="modal-header modal-xl">
                                    <p class="modal-title" id="exampleModalLabel">
                                        <h title="Date and Time Given"><i style="color: #1a8cff;" class="fas fa-clock"></i> <?php echo $row['date_']." at ".$row['time_'];  ?> <?php echo $row['edited'];?></h>
                                    </p> 
                                </div>
                              <input type="text" class="form-control" name="id" value="<?php echo $id;?>" hidden>
                                <div class="modal-body modal-xl">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Student: </label> <br>
                                                    <b> <?php echo $row['stud_name_and_id']; ?> </b>
                                                </div>
                                                <hr>
                                                <div class="form-group">
                                                    <label>Course, Year & Section: </label> <br>
                                                    <b> <?php echo $row['course']; ?> </b>
                                                </div>
                                                <!-- <hr>
                                                <div class="form-group">
                                                    <label>Requirement: </label> <br>
                                                    <b> <?php echo $row['title']; ?> </b>
                                                </div> -->
                                                <hr>
                                                <div class="form-group">
                                                    <label>Instructions: </label> <br>
                                                    <textarea style="background: ghostwhite;" rows="15" name="instructions" class="form-control" id="instructions" aria-describedby="" readonly required=""><?php echo $row['instructions'];?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Attached File</label>: <br>
                                                    <?php if($row['sample_file'] != "") { ?>
                                                    <b><a href="../admin/upload_docs/<?php echo $row['sample_file'];?>" target="_blank" title="Download File"><i class="fa fa-file"></i><?php echo $row['sample_file'];?></a> </b></a>
                                                    <?php } else { echo "<b style='color: red;'>There's no attached file</b>"; } ?>
                                                </div>
                                                <hr>
                                                <!-- selecting and concatenating the date and time from tbl_students_work -->
                                                <?php 
                                                    session_start();
                                                    $task_id = $_SESSION['t_id_works1'];
                                                    $sql1 = "SELECT Concat(date_,' ',time_) AS dateTTime1 FROM tbl_students_work where id='$task_id'";
                                                    $query1 = $conn->query($sql1);
                                                    while($row1 = $query1->fetch_assoc()){
                                                        $_SESSION['datetime2'] = $row1['dateTTime1'];
                                                    }
                                                ?>
                                                <div class="form-group">
                                                    <label>Status: </label> <br>
                                                    <?php 
                                                        if ($row['work_status'] == 'pending') {
                                                             echo "<div class='progress'>
                                                                      <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' title='15% on progress'>15%</div>
                                                                    </div><b>PENDING</b>";
                                                        }

                                                        if ($row['work_status'] == 'semi-pending') {
                                                             echo "<div class='progress'>
                                                                      <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' title='25% on progress' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'>25%</div>
                                                                    </div><b>PENDING</b>";
                                                        }

                                                        if ($row['work_status'] == 'semi-pending2') {
                                                             echo "<div class='progress'>
                                                                      <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'>50%</div>
                                                                    </div><b>PENDING</b>";
                                                        }

                                                        if ($row['work_status'] == 'semi-pending3') {
                                                             echo "<div class='progress'>
                                                                      <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'>75%</div>
                                                                    </div><b>PENDING</b>";
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
                                                    <label>Due Date:</label> <br>
                                                    <b><?php
                                                        echo $row['date_of_submission'];?></b>
                                                </div>
                                                <div class="form-group">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                                </div>
                              </form>
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
        $count1 = 1;
        $title = "Performance Sheet";
        $myfullname_ = $_SESSION['coordinator_fullname_session'];
        $work_stats = "pending";
        $stats = "not archived";
        $submitted = "no";
        $sql = "SELECT * from tbl_students_work where title='$title' and name_of_teacher='$myfullname_' and work_status='$work_stats' and submitted='$submitted' and status='$stats'";
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
                  <th hidden="">ID</th>
                  <th>Student</th>
                  <th>Requirement</th>
                  <th>Attached File</th>
                  <th>Due Date</th>
                  <th>Turned In</th>
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
                    <td hidden=""><?php 
                            $_SESSION['t_id_works1'] = $_SESSION['task_id_2'];
                            echo $_SESSION['t_id_works1'];
                        ?>
                      </td>
                      <td><?php echo $row['stud_name_and_id']; ?></td>
                      <td><?php echo $row['title'];?> </td>
                      <td><?php if($row['sample_file'] != "") {?><b><a href="../admin/upload_docs/<?php echo $row['sample_file'];?>" target="_blank" title="Download File"><i class="fa fa-file"></i><?php echo $row['sample_file'];?></a> </b> <?php } else { echo "<font style='color: red;'>There's no attached file</font>"; } ?></td>
                      <td width="10%"><?php echo $row['date_of_submission']?></td>
                      <td>
                        <?php
                            $sql2 = "SELECT email from tbl_students where stud_fullname='$stud_fullname'";
                            $query2 = $conn->query($sql2);
                             //this lines of code will insert multiple data in rows in tbl_students_work
                            while($row2 = $query2->fetch_assoc()){
                                $get_email = $row2['email'];
                            }
                            //detect the dates
                            date_default_timezone_set('Asia/Manila'); 
                            $date = date('Y-m-d');
                            if($row['date_of_submission'] < $date){
                                //in this part, magnonotify sa email ng students kapag late na yung requirement nila(di pa napapasa), imbes na mag-spam sa email, ginawan ko ng update email late notify para isang beses lang magsend yung sa gmail nila kapag late na yung requirement nila
                                //if yung email notify late ay = sa unsent magnonotify sa email; else kapag hindi
                                if ($row['email_notify_late'] == "unsent") {
                                    try {
                                        require '../vendor/autoload.php';
                                        $mail = new  PHPMailer(true);
                                        //$mail->SMTPDebug = 1; //Enable verbose debug output
                                        $mail->isSMTP();                                            //Send using SMTP
                                        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                                        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
                                        $mail->Username   = 'websiteet18@gmail.com';                     //SMTP username
                                        $mail->Password   = 'empowermenttechnology';                               //SMTP password
                                        $mail->SMTPSecure = "tls"; //Enable implicit TLS encryption
                                        $mail->Port       = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                                        //Recipients
                                        $mail->setFrom('websiteet18@gmail.com', $myfullname_);
                                        $mail->addAddress($get_email);//Name is optional

                                        //Content
                                        $mail->isHTML(true);//Set email format to HTML
                                        $mail->Subject = "e-OJT aCCeSs: Requirement Update";
                                        $template    = "Late Requirement: <b>".$requirement_title."</b><br>You are <b style='color: ghostwhite; background: red; padding: 2px; border-radius: 5px;'>LATE</b>. Please submit your requirement. ";
                                        $mail->Body = $template;
                                        $mail->send();
                                    }
                                    catch(Exception $ex){
                                        //echo $ex;
                                    }
                                }
                                else if($row['email_notify_late'] == "sent"){
                                    echo "";//OKAY na
                                }
                                date_default_timezone_set('Asia/Manila'); 
                                $date = date('Y-m-d');

                                $no = "no";
                                $sent="sent";
                                $sql_update_late_sent = "UPDATE tbl_students_work set email_notify_late='$sent' WHERE date_of_submission<'$date' and submitted='$no'";
                                $query_run_late_sent = mysqli_query($conn, $sql_update_late_sent);

                                echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-danger'><font style='color: ghostwhite;'>LATE</span>";
                            }
                            //$counter = 0;
                            else if($row['date_of_submission'] == $date){
                                //in this part, magnonotify sa email ng students kapag due date na yung requirement nila(di pa napapasa), imbes na mag-spam sa email, ginawan ko ng update email due notify para isang beses lang magsend yung sa gmail nila kapag late na yung requirement nila
                                //if yung email notify due ay = sa unsent magnonotify sa email; else kapag hindi
                                if ($row['email_notify_due'] == "unsent") {
                                    try {
                                        require '../vendor/autoload.php';
                                        $mail = new  PHPMailer(true);
                                        //$mail->SMTPDebug = 1; //Enable verbose debug output
                                        $mail->isSMTP();                                            //Send using SMTP
                                        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                                        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
                                        $mail->Username   = 'websiteet18@gmail.com';                     //SMTP username
                                        $mail->Password   = 'empowermenttechnology';                               //SMTP password
                                        $mail->SMTPSecure = "tls"; //Enable implicit TLS encryption
                                        $mail->Port       = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                                        //Recipients
                                        $mail->setFrom('websiteet18@gmail.com', $myfullname_);
                                        $mail->addAddress($get_email);//Name is optional

                                        //Content
                                        $mail->isHTML(true);//Set email format to HTML
                                        $mail->Subject = "e-OJT aCCeSs: Requirement Update";
                                        $template    = "Requirement: <b>".$requirement_title."</b><br> Your requirement is <b style='color: black; background: yellow; padding: 2px; border-radius: 5px;'>DUE TODAY</b>. Please submit your requirement.";
                                        $mail->Body = $template;
                                        $mail->send();
                                    }
                                    catch(Exception $ex){
                                        //echo $ex;
                                    }
                                }
                                else if($row['email_notify_due'] == "sent"){
                                    echo "";//OKAY na
                                }
                                date_default_timezone_set('Asia/Manila'); 
                                $date = date('Y-m-d');
                                
                                $no = "no";
                                $sent="sent";
                                $sql_update_due_sent = "UPDATE tbl_students_work set email_notify_due='$sent' WHERE date_of_submission='$date' and submitted='$no'";
                                $query_run_due_sent = mysqli_query($conn, $sql_update_due_sent);

                                echo "<span style='font-size: 15px; margin-left: 0px; color: #262626;' class='badge badge-pill badge-warning'>DUE TODAY</span>";
                            }
                            else{
                                echo "<span style='font-size: 15px; background: orange; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-success'>ON-GOING</span>";
                            }
                        ?> 
                      </td>
                      <td width="15%">
                        <?php 
                            if ($row['work_status'] == 'pending') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' title='15% on progress'>15%</div>
                                        </div><b>PENDING</b>";
                            }

                            if ($row['work_status'] == 'semi-pending') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' title='25% on progress' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'>25%</div>
                                        </div><b>PENDING</b>";
                            }

                            if ($row['work_status'] == 'semi-pending2') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'>50%</div>
                                        </div><b>PENDING</b>";
                            }

                            if ($row['work_status'] == 'semi-pending3') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'>75%</div>
                                        </div><b>PENDING</b>";
                            }

                            if ($row['work_status'] == 'completed') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'>100%</div>
                                        </div><b>COMPLETED</b>";
                            }
                        ?>
                      </td>
                      <td>
                          <a href="#view<?php echo $id;?>"  class="btn btn-info" data-toggle="modal" ><i class="fas fa-eye" title="View"></i></a>
                      </td>

                        <!-- View Modal -->
                        <div class="modal fade bd-example-modal-xl" data-backdrop="static" id="view<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="update_place" aria-hidden="true">
                          <div class="modal-dialog modal-xl" role="document" style="color:  #333333;">
                            <div class="modal-content modal-xl">
                              <div class="modal-header modal-xl">
                                <h5 class="modal-title" id="exampleModalLabel"><h style="color: #0d6efd"><i class="fas fa-file-alt"></i> <?php echo $row['title']; ?> </h><span><?php //echo $row['edited']; ?></span></h5>
                                   
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                                <div class="modal-header modal-xl">
                                    <p class="modal-title" id="exampleModalLabel">
                                        <h title="Date and Time Given"><i style="color: #1a8cff;" class="fas fa-clock"></i> <?php echo $row['date_']." at ".$row['time_'];  ?> <?php echo $row['edited'];?></h>
                                    </p> 
                                </div>
                              <input type="text" class="form-control" name="id" value="<?php echo $id;?>" hidden>
                                <div class="modal-body modal-xl">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Student: </label> <br>
                                                    <b> <?php echo $row['stud_name_and_id']; ?> </b>
                                                </div>
                                                <hr>
                                                <div class="form-group">
                                                    <label>Course, Year & Section: </label> <br>
                                                    <b> <?php echo $row['course']; ?> </b>
                                                </div>
                                                <!-- <hr>
                                                <div class="form-group">
                                                    <label>Requirement: </label> <br>
                                                    <b> <?php echo $row['title']; ?> </b>
                                                </div> -->
                                                <hr>
                                                <div class="form-group">
                                                    <label>Instructions: </label> <br>
                                                    <textarea style="background: ghostwhite;" rows="15" name="instructions" class="form-control" id="instructions" aria-describedby="" readonly required=""><?php echo $row['instructions'];?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Attached File</label>: <br>
                                                    <?php if($row['sample_file'] != "") { ?>
                                                    <b><a href="../admin/upload_docs/<?php echo $row['sample_file'];?>" target="_blank" title="Download File"><i class="fa fa-file"></i><?php echo $row['sample_file'];?></a> </b></a>
                                                    <?php } else { echo "<b style='color: red;'>There's no attached file</b>"; } ?>
                                                </div>
                                                <hr>
                                                <!-- selecting and concatenating the date and time from tbl_students_work -->
                                                <?php 
                                                    session_start();
                                                    $task_id = $_SESSION['t_id_works1'];
                                                    $sql1 = "SELECT Concat(date_,' ',time_) AS dateTTime1 FROM tbl_students_work where id='$task_id'";
                                                    $query1 = $conn->query($sql1);
                                                    while($row1 = $query1->fetch_assoc()){
                                                        $_SESSION['datetime2'] = $row1['dateTTime1'];
                                                    }
                                                ?>
                                                <div class="form-group">
                                                    <label>Status: </label> <br>
                                                    <?php 
                                                        if ($row['work_status'] == 'pending') {
                                                             echo "<div class='progress'>
                                                                      <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' title='15% on progress'>15%</div>
                                                                    </div><b>PENDING</b>";
                                                        }

                                                        if ($row['work_status'] == 'semi-pending') {
                                                             echo "<div class='progress'>
                                                                      <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' title='25% on progress' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'>25%</div>
                                                                    </div><b>PENDING</b>";
                                                        }

                                                        if ($row['work_status'] == 'semi-pending2') {
                                                             echo "<div class='progress'>
                                                                      <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'>50%</div>
                                                                    </div><b>PENDING</b>";
                                                        }

                                                        if ($row['work_status'] == 'semi-pending3') {
                                                             echo "<div class='progress'>
                                                                      <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'>75%</div>
                                                                    </div><b>PENDING</b>";
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
                                                    <label>Due Date:</label> <br>
                                                    <b><?php
                                                        echo $row['date_of_submission'];?></b>
                                                </div>
                                                <div class="form-group">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                                </div>
                              </form>
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
        $count1 = 1;
        $title = "Endorsement Letter";
        $myfullname_ = $_SESSION['coordinator_fullname_session'];
        $work_stats = "pending";
        $stats = "not archived";
        $submitted = "no";
        $sql = "SELECT * from tbl_students_work where title='$title' and name_of_teacher='$myfullname_' and work_status='$work_stats' and submitted='$submitted' and status='$stats'";
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
                  <th hidden="">ID</th>
                  <th>Student</th>
                  <th>Requirement</th>
                  <th>Attached File</th>
                  <th>Due Date</th>
                  <th>Turned In</th>
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
                    <td hidden=""><?php 
                            $_SESSION['t_id_works1'] = $_SESSION['task_id_2'];
                            echo $_SESSION['t_id_works1'];
                        ?>
                      </td>
                      <td><?php echo $row['stud_name_and_id']; ?></td>
                      <td><?php echo $row['title'];?> </td>
                      <td><?php if($row['sample_file'] != "") {?><b><a href="../admin/upload_docs/<?php echo $row['sample_file'];?>" target="_blank" title="Download File"><i class="fa fa-file"></i><?php echo $row['sample_file'];?></a> </b> <?php } else { echo "<font style='color: red;'>There's no attached file</font>"; } ?></td>
                      <td width="10%"><?php echo $row['date_of_submission']?></td>
                      <td>
                        <?php
                            $sql2 = "SELECT email from tbl_students where stud_fullname='$stud_fullname'";
                            $query2 = $conn->query($sql2);
                             //this lines of code will insert multiple data in rows in tbl_students_work
                            while($row2 = $query2->fetch_assoc()){
                                $get_email = $row2['email'];
                            }
                            //detect the dates
                            date_default_timezone_set('Asia/Manila'); 
                            $date = date('Y-m-d');
                            if($row['date_of_submission'] < $date){
                                //in this part, magnonotify sa email ng students kapag late na yung requirement nila(di pa napapasa), imbes na mag-spam sa email, ginawan ko ng update email late notify para isang beses lang magsend yung sa gmail nila kapag late na yung requirement nila
                                //if yung email notify late ay = sa unsent magnonotify sa email; else kapag hindi
                                if ($row['email_notify_late'] == "unsent") {
                                    try {
                                        require '../vendor/autoload.php';
                                        $mail = new  PHPMailer(true);
                                        //$mail->SMTPDebug = 1; //Enable verbose debug output
                                        $mail->isSMTP();                                            //Send using SMTP
                                        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                                        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
                                        $mail->Username   = 'websiteet18@gmail.com';                     //SMTP username
                                        $mail->Password   = 'empowermenttechnology';                               //SMTP password
                                        $mail->SMTPSecure = "tls"; //Enable implicit TLS encryption
                                        $mail->Port       = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                                        //Recipients
                                        $mail->setFrom('websiteet18@gmail.com', $myfullname_);
                                        $mail->addAddress($get_email);//Name is optional

                                        //Content
                                        $mail->isHTML(true);//Set email format to HTML
                                        $mail->Subject = "e-OJT aCCeSs: Requirement Update";
                                        $template    = "Late Requirement: <b>".$requirement_title."</b><br>You are <b style='color: ghostwhite; background: red; padding: 2px; border-radius: 5px;'>LATE</b>. Please submit your requirement. ";
                                        $mail->Body = $template;
                                        $mail->send();
                                    }
                                    catch(Exception $ex){
                                        //echo $ex;
                                    }
                                }
                                else if($row['email_notify_late'] == "sent"){
                                    echo "";//OKAY na
                                }
                                date_default_timezone_set('Asia/Manila'); 
                                $date = date('Y-m-d');

                                $no = "no";
                                $sent="sent";
                                $sql_update_late_sent = "UPDATE tbl_students_work set email_notify_late='$sent' WHERE date_of_submission<'$date' and submitted='$no'";
                                $query_run_late_sent = mysqli_query($conn, $sql_update_late_sent);

                                echo "<span style='font-size: 15px; margin-left: 0px;' class='badge badge-pill badge-danger'><font style='color: ghostwhite;'>LATE</span>";
                            }
                            //$counter = 0;
                            else if($row['date_of_submission'] == $date){
                                //in this part, magnonotify sa email ng students kapag due date na yung requirement nila(di pa napapasa), imbes na mag-spam sa email, ginawan ko ng update email due notify para isang beses lang magsend yung sa gmail nila kapag late na yung requirement nila
                                //if yung email notify due ay = sa unsent magnonotify sa email; else kapag hindi
                                if ($row['email_notify_due'] == "unsent") {
                                    try {
                                        require '../vendor/autoload.php';
                                        $mail = new  PHPMailer(true);
                                        //$mail->SMTPDebug = 1; //Enable verbose debug output
                                        $mail->isSMTP();                                            //Send using SMTP
                                        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                                        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
                                        $mail->Username   = 'websiteet18@gmail.com';                     //SMTP username
                                        $mail->Password   = 'empowermenttechnology';                               //SMTP password
                                        $mail->SMTPSecure = "tls"; //Enable implicit TLS encryption
                                        $mail->Port       = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                                        //Recipients
                                        $mail->setFrom('websiteet18@gmail.com', $myfullname_);
                                        $mail->addAddress($get_email);//Name is optional

                                        //Content
                                        $mail->isHTML(true);//Set email format to HTML
                                        $mail->Subject = "e-OJT aCCeSs: Requirement Update";
                                        $template    = "Requirement: <b>".$requirement_title."</b><br> Your requirement is <b style='color: black; background: yellow; padding: 2px; border-radius: 5px;'>DUE TODAY</b>. Please submit your requirement.";
                                        $mail->Body = $template;
                                        $mail->send();
                                    }
                                    catch(Exception $ex){
                                        //echo $ex;
                                    }
                                }
                                else if($row['email_notify_due'] == "sent"){
                                    echo "";//OKAY na
                                }
                                date_default_timezone_set('Asia/Manila'); 
                                $date = date('Y-m-d');
                                
                                $no = "no";
                                $sent="sent";
                                $sql_update_due_sent = "UPDATE tbl_students_work set email_notify_due='$sent' WHERE date_of_submission='$date' and submitted='$no'";
                                $query_run_due_sent = mysqli_query($conn, $sql_update_due_sent);

                                echo "<span style='font-size: 15px; margin-left: 0px; color: #262626;' class='badge badge-pill badge-warning'>DUE TODAY</span>";
                            }
                            else{
                                echo "<span style='font-size: 15px; background: orange; margin-left: 0px; color: ghostwhite;' class='badge badge-pill badge-success'>ON-GOING</span>";
                            }
                        ?> 
                      </td>
                      <td width="15%">
                        <?php 
                            if ($row['work_status'] == 'pending') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' title='15% on progress'>15%</div>
                                        </div><b>PENDING</b>";
                            }

                            if ($row['work_status'] == 'semi-pending') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' title='25% on progress' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'>25%</div>
                                        </div><b>PENDING</b>";
                            }

                            if ($row['work_status'] == 'semi-pending2') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'>50%</div>
                                        </div><b>PENDING</b>";
                            }

                            if ($row['work_status'] == 'semi-pending3') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'>75%</div>
                                        </div><b>PENDING</b>";
                            }

                            if ($row['work_status'] == 'completed') {
                                 echo "<div class='progress'>
                                          <div class='progress-bar bg-success' role='progressbar' style='width: 100%' title='100% on progress' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'>100%</div>
                                        </div><b>COMPLETED</b>";
                            }
                        ?>
                          
                      </td>
                      <td>
                          <a href="#view<?php echo $id;?>"  class="btn btn-info" data-toggle="modal" ><i class="fas fa-eye" title="View"></i></a>
                      </td>

                        <!-- View Modal -->
                        <div class="modal fade bd-example-modal-xl" data-backdrop="static" id="view<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="update_place" aria-hidden="true">
                          <div class="modal-dialog modal-xl" role="document" style="color:  #333333;">
                            <div class="modal-content modal-xl">
                              <div class="modal-header modal-xl">
                                <h5 class="modal-title" id="exampleModalLabel"><h style="color: #0d6efd"><i class="fas fa-file-alt"></i> <?php echo $row['title']; ?> </h><span><?php //echo $row['edited']; ?></span></h5>
                                   
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                                <div class="modal-header modal-xl">
                                    <p class="modal-title" id="exampleModalLabel">
                                        <h title="Date and Time Given"><i style="color: #1a8cff;" class="fas fa-clock"></i> <?php echo $row['date_']." at ".$row['time_'];  ?> <?php echo $row['edited'];?></h>
                                    </p> 
                                </div>
                              <input type="text" class="form-control" name="id" value="<?php echo $id;?>" hidden>
                                <div class="modal-body modal-xl">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Student: </label> <br>
                                                    <b> <?php echo $row['stud_name_and_id']; ?> </b>
                                                </div>
                                                <hr>
                                                <div class="form-group">
                                                    <label>Course, Year & Section: </label> <br>
                                                    <b> <?php echo $row['course']; ?> </b>
                                                </div>
                                                <!-- <hr>
                                                <div class="form-group">
                                                    <label>Requirement: </label> <br>
                                                    <b> <?php echo $row['title']; ?> </b>
                                                </div> -->
                                                <hr>
                                                <div class="form-group">
                                                    <label>Instructions: </label> <br>
                                                    <textarea style="background: ghostwhite;" rows="15" name="instructions" class="form-control" id="instructions" aria-describedby="" readonly required=""><?php echo $row['instructions'];?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Attached File</label>: <br>
                                                    <?php if($row['sample_file'] != "") { ?>
                                                    <b><a href="../admin/upload_docs/<?php echo $row['sample_file'];?>" target="_blank" title="Download File"><i class="fa fa-file"></i><?php echo $row['sample_file'];?></a> </b></a>
                                                    <?php } else { echo "<b style='color: red;'>There's no attached file</b>"; } ?>
                                                </div>
                                                <hr>
                                                <!-- selecting and concatenating the date and time from tbl_students_work -->
                                                <?php 
                                                    session_start();
                                                    $task_id = $_SESSION['t_id_works1'];
                                                    $sql1 = "SELECT Concat(date_,' ',time_) AS dateTTime1 FROM tbl_students_work where id='$task_id'";
                                                    $query1 = $conn->query($sql1);
                                                    while($row1 = $query1->fetch_assoc()){
                                                        $_SESSION['datetime2'] = $row1['dateTTime1'];
                                                    }
                                                ?>
                                                <div class="form-group">
                                                    <label>Status: </label> <br>
                                                    <?php 
                                                        if ($row['work_status'] == 'pending') {
                                                             echo "<div class='progress'>
                                                                      <div class='progress-bar bg-secondary' role='progressbar' style='width: 15%' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' title='15% on progress'>15%</div>
                                                                    </div><b>PENDING</b>";
                                                        }

                                                        if ($row['work_status'] == 'semi-pending') {
                                                             echo "<div class='progress'>
                                                                      <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' title='25% on progress' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'>25%</div>
                                                                    </div><b>PENDING</b>";
                                                        }

                                                        if ($row['work_status'] == 'semi-pending2') {
                                                             echo "<div class='progress'>
                                                                      <div class='progress-bar bg-info' role='progressbar' style='width: 50%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' title='50% on progress'>50%</div>
                                                                    </div><b>PENDING</b>";
                                                        }

                                                        if ($row['work_status'] == 'semi-pending3') {
                                                             echo "<div class='progress'>
                                                                      <div class='progress-bar bg-primary' role='progressbar' style='width: 75%' title='75% on progress' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'>75%</div>
                                                                    </div><b>PENDING</b>";
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
                                                    <label>Due Date:</label> <br>
                                                    <b><?php
                                                        echo $row['date_of_submission'];?></b>
                                                </div>
                                                <div class="form-group">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close <i class="fas fa-times-circle"></i></button>
                                </div>
                              </form>
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




