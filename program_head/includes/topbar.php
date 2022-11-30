<?php
include 'session.php'; 
?>
<style type="text/css">
@import url('https"//fonts.googleapis.com/css?family=Poppins'):

    *{
        margin: 0;
    }

    *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    html, body{
        display: grid;
        height: 100%;
    }
    .indicator{
        height: 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin: 10px 0;
        display: none;

    }
    .indicator span{
        width: 100%;
        height: 100%;
        background: lightgrey;
        border-radius: 5px; 
    }

    .indicator span.medium{
        margin: 0 3px;
    }
    .indicator span:before{
        content: '';
        position: absolute;
        width: 31%;
        height: 3%;
        border-radius: 5px;
    }
    .indicator span.active.weak:before{
        background-color: #ff4747;
    }
    .indicator span.active.medium:before{
        background-color: orange;
    }
    .indicator span.active.strong:before{
        background-color: #23ad5c;
    }
    .text{
        font-weight: 500;
        margin-bottom: -10px;
        display: none;
    }
    .text.weak {
        color: #ff4747;
    }
    .text.medium {
        color: orange;
    }
    .text.strong {
        color: #23ad5c;
    }
    #current_pword {
        border: 1px solid gray;
    }
    #current_pword:focus { 
        border: 1px solid #006bb3;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
    }
    #pword {
        border: 1px solid gray;
    }
    #pword:focus { 
        border: 1px solid #006bb3;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
    }

    #confirm_pword{
        border: 1px solid gray;
    }
    #confirm_pword:focus {
        border: 1px solid #006bb3;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
    }
</style>


<div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop"  class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

            
<!-- <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button> -->
                    <!-- Topbar Search -->
                    
                    <div class="nav-item dropdown no-arrow mx-1">
                        <!-- <div class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: rgb(102, 102, 102)">
                          <?php echo "<br>"; ?>
                          <div title="Program Head Name and ID">
                              &nbsp;&nbsp;&nbsp;&nbsp;<b><i class="fas fa-id-badge" title="Program Head Name and ID" style="color: #dc3545;"></i> &nbsp; <?php echo "".$_SESSION['coordinator_fname']." ".$_SESSION['coordinator_mname']. " ".$_SESSION['coordinator_lname']; ?> </b>
                              &nbsp;(<?php echo $_SESSION['coordinator_id'];?>) - PROGRAM HEAD 
                          </div>

                          &nbsp;
                          | &nbsp;&nbsp;

                          <div title="Academic Year and Sem">
                              <i class="fas fa-book-reader" title="Academic Year and Sem" style="color: #dc3545;"></i>&nbsp;&nbsp;
                              <?php echo $_SESSION['coordinator_acad_yr_sem'];?>
                          </div>
                     </div> -->
                    </div>


                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        

                        
<!-- 
                        <li class="nav-item dropdown no-arrow mx-1">
                            <div class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: rgb(102, 102, 102)">
                                <i class="fas fa-calendar fa-fw" style="color: rgb(0, 64, 255);"></i>
                                <?php
                                    date_default_timezone_set('Asia/Manila');
                                    $td = date("F d, Y");
                                    echo "Today is, ".$td;
                                ?>
                            </div>
                        </li> -->

                        <!-- <li class="nav-item dropdown no-arrow mx-1">
                            <div class="nav-link dropdown-toggle" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: rgb(102, 102, 102)">
                                <i class="fas fa-clock fa-fw" style="color: rgb(204, 102, 0);"></i> 
                                    <div id="time"> </div>                                        <script>
                                            setInterval(dispClock, 1000);
                                            function dispClock(){
                                            var time = new Date();
                                            var hrs = time.getHours();
                                            var min = time.getMinutes();
                                            var sec = time.getSeconds();
                                            var en = 'AM';
                                            if(hrs > 12){
                                                en = 'PM';
                                            }
                                            if (hrs > 12) {
                                            hrs = hrs - 12;
                                            }
                                            if (hrs == 0) {
                                            hrs = 12;
                                            }
                                            if (hrs < 10) {
                                            hrs = '0' + hrs;
                                            }
                                            if (min < 10) {
                                            min = '0' + min;
                                            }
                                            if (sec < 10) {
                                            sec = '0' + sec;
                                            }
                                            document.getElementById('time').innerHTML = hrs + ':' + min + ":" + sec + " " + en;
                                            }
                                        </script>
                            </div>
                        </li>
 -->
                      



                        <!-- Nav Item - Messages -->
                       


                        <!-- Notifications Requested Docs -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <?php
                                include('includes/session.php');
                                require_once('includes/db_connect_pdo.php'); 
                                $isread=0;
                                $program_head_name = $_SESSION['coordinator_fullname_session'];
                                $sql = "SELECT * from tbl_students_work where name_of_program_head=:program_head_name and isReadPH=:isread";
                                $query = $dbh -> prepare($sql);
                                $query->bindParam(':isread',$isread,PDO::PARAM_STR);
                                $query->bindParam(':program_head_name',$program_head_name,PDO::PARAM_STR);
                                $query->execute();
                                $results=$query->fetchAll(PDO::FETCH_OBJ);
                                $unreadcount=$query->rowCount();
                            ?>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter"><?php echo htmlentities($unreadcount);?></span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Requested Documents Notification
                                </h6>
                                <?php 
                                    $isread=0;
                                    $program_head_name = $_SESSION['coordinator_fullname_session'];
                                    $sql = "SELECT * from tbl_students_work where name_of_program_head=:program_head_name and isReadPH=:isread";
                                    $query = $dbh -> prepare($sql);
                                    $query->bindParam(':isread',$isread,PDO::PARAM_STR);
                                    $query->bindParam(':program_head_name',$program_head_name,PDO::PARAM_STR);
                                    $query->execute();
                                    $results=$query->fetchAll(PDO::FETCH_OBJ);
                                    if($query->rowCount() > 0) {
                                        foreach($results as $result)
                                        { ?> 
                                <a class="dropdown-item d-flex align-items-center" href="request_docs_pending_details.php?req_id=<?php echo htmlentities($result->id);?>">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-tasks" style="color: white;"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500"><?php echo htmlentities($result->program_head_forward_date);?></div>
                                        <b><?php echo htmlentities($result->name_of_teacher); echo " sent you a requirement that are needed to sign."; echo " This is "; echo htmlentities($result->stud_name_and_id);?> requirement. </b> <br>
                                        <?php echo htmlentities($result->title);?>
                                    </div>
                                </a>
                                <?php }} else { ?>
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                    </div>
                                    <div>
                                    <div class="small text-gray-500"></div>
                                        No notifications
                                    </div>
                                </a>
                                <?php } ?>
                                 <form action="request_docs_pending.php" method="POST" enctype="multipart/form-data">
                                    <button style="outline: none;" class="dropdown-item text-center small text-gray-500" href="" name="read_all">Mark All as Read</button>
                                    <input type="text" name="read_all_notifs" hidden="" value="read all">
                                </form>
                            </div>
                        </li>


                        <!-- Nav Item - announcements -->
                        <!-- <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="javascript:void(0)" id="messagesDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bullhorn"></i>

                                <?php
                                include('includes/session.php');
                                require_once('includes/db_connect_pdo.php'); 
                                $isread=0;
                                $teacher_name = $_SESSION['coordinator_fname']." ".$_SESSION['coordinator_mname']." ".$_SESSION['coordinator_lname']." (".$_SESSION['coordinator_id'].")";
                                $sql = "SELECT * from tbl_announcement_receiver where receiver_name=:teacher_name and isRead=:isread";
                                $query = $dbh -> prepare($sql);
                                $query->bindParam(':teacher_name',$teacher_name,PDO::PARAM_STR);
                                $query->bindParam(':isread',$isread,PDO::PARAM_STR);
                                $query->execute();
                                $results=$query->fetchAll(PDO::FETCH_OBJ);
                                $unreadcount=$query->rowCount();
                            ?>
                                
                                <span class="badge badge-danger badge-counter"><?php echo htmlentities($unreadcount);?></span>
                            </a>
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Announcements Notifications
                                </h6>
                                <?php 
                                    $isread=0;
                                    $sql = "SELECT * from tbl_announcement_receiver where receiver_name=:teacher_name and isRead=:isread";
                                    $query = $dbh -> prepare($sql);
                                    $query->bindParam(':teacher_name',$teacher_name,PDO::PARAM_STR);
                                    $query->bindParam(':isread',$isread,PDO::PARAM_STR);
                                    $query->execute();
                                    $results=$query->fetchAll(PDO::FETCH_OBJ);
                                    if($query->rowCount() > 0) {
                                        foreach($results as $result)
                                        { ?> 
                                <a class="dropdown-item d-flex align-items-center" href="announcements_details.php?ann_id=<?php echo htmlentities($result->id);?>">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-tasks" style="color: white;"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500"><?php echo htmlentities($result->date_); echo " "; echo htmlentities($result->time_);?></div>
                                        <b>There's a new announcement from <?php echo htmlentities($result->posted_by);?></b> <br>
                                        <?php echo htmlentities($result->title);?>
                                    </div>
                                </a>
                                <?php }} else { ?>
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                    </div>
                                    <div>
                                        <div class="small text-gray-500"></div>
                                        No notifications
                                    </div>
                                </a>
                                <?php } ?>
                                <form action="announcements_history.php" method="POST" enctype="multipart/form-data">
                                    <button style="outline: none;" class="dropdown-item text-center small text-gray-500" href="" name="read_all">Mark All as Read</button>
                                    <input type="text" name="read_all_notifs" hidden="" value="read all">
                                </form>
                            </div>
                        </li> -->
                        <div class="topbar-divider d-none d-sm-block"></div>
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <!-- displaying username here -->
                                    <br><p><?php include 'session.php'; echo $_SESSION['coordinator_fname'];?></p>
                                </span>
                                <?php 
                                                                            
                                ?>
                                <img class="img-profile rounded-circle" src="../admin/uploaded_images/<?php echo $_SESSION['coordinator_image'];?>">
                                <!-- Image here -->
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="my_account.php">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#settings" data-toggle="modal">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="my_signature.php">
                                    <i class="fas fa-signature fa-sm fa-fw mr-2 text-gray-400"></i>
                                    My Signature
                                </a>
                                <a class="dropdown-item" href="activity_log.php">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Change Password Modal -->
                        <div class="modal fade" data-backdrop="static" id="settings" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                          <div class="modal-dialog" role="document" style="color: #333333;">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel" style="color: #0d6efd;"><i class="fas fa-shield-alt"></i> Settings - Change Password</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <form class="" action="change_password_config.php" method="post" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="">Current Password</label><br>
                                        <input type="password" style="color: #333333; background: WHITE;" name="current_pword" class="form-control" id="current_pword" aria-describedby="" placeholder="Enter Your Current Password" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="">New Password</label><br>
                                        <input type="password" style="color: #333333;" onkeyup="trigger()" name="new_pword" class="form-control" id="pword" aria-describedby="" placeholder="Enter Your New Password" required="">
                                        <div class="indicator">
                                            <span class="weak"></span>
                                            <span class="medium"></span>
                                            <span class="strong"></span>
                                        </div>
                                        <div class="text">Your Password is Too Weak</div>
                                    </div>
                                    <script>
                                        const indicator = document.querySelector(".indicator");
                                        const input = document.querySelector("#pword");
                                        const weak = document.querySelector(".weak");
                                        const medium = document.querySelector(".medium");
                                        const strong = document.querySelector(".strong");
                                        const text = document.querySelector(".text");
                                        let regExpWeak  = /[a-z]/;
                                        let regExpMedium  = /\d+/;
                                        let regExpStrong = /.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/;
                                          function trigger(){
                                            if(input.value != ""){
                                              indicator.style.display = "block";
                                              indicator.style.display = "flex";
                                              if(input.value.length <= 3 && (input.value.match(regExpWeak) || input.value.match(regExpMedium) || input.value.match(regExpStrong)))no=1;
                                              if(input.value.length >= 6 && ((input.value.match(regExpWeak) && input.value.match(regExpMedium)) || (input.value.match(regExpMedium) && input.value.match(regExpStrong)) || (input.value.match(regExpWeak) && input.value.match(regExpStrong))))no=2;
                                              if(input.value.length >= 8 && input.value.match(regExpWeak) && input.value.match(regExpMedium) && input.value.match(regExpStrong))no=3;
                                              if(no==1){
                                                weak.classList.add("active");
                                                text.style.display = "block";
                                                text.textContent = "Your password is too weak. Please contains symbols, number, and uppercase letter.";
                                                text.classList.add("weak");
                                              }
                                              if(no==2){
                                                medium.classList.add("active");
                                                text.textContent = "Your password is medium. Password must be atleast 8 characters. ";
                                                text.classList.add("medium");
                                              }else{
                                                medium.classList.remove("active");
                                                text.classList.remove("medium");
                                              }
                                              if(no==3){
                                                weak.classList.add("active");
                                                medium.classList.add("active");
                                                strong.classList.add("active");
                                                text.textContent = "Great! Your password is strong.";
                                                text.classList.add("strong");
                                                document.getElementById("update_btn").disabled = false;
                                              }else{
                                                strong.classList.remove("active");
                                                text.classList.remove("strong");
                                                document.getElementById("update_btn").disabled = true;
                                              }
                                              showBtn.style.display = "block";
                                              showBtn.onclick = function(){
                                                if(input.type == "password"){
                                                  input.type = "text";
                                                  showBtn.textContent = "HIDE";
                                                  showBtn.style.color = "#23ad5c";
                                                }else{
                                                  input.type = "password";
                                                  showBtn.textContent = "SHOW";
                                                  showBtn.style.color = "#000";
                                                }
                                              }
                                            }else{
                                              indicator.style.display = "none";
                                              text.style.display = "none";
                                              showBtn.style.display = "none";
                                            }
                                          }
                                    </script>
                                    <div class="form-group">
                                        <label for="">Confirm New Password</label><br>
                                        <input type="password" style="color: #333333;" name="confirm_pword" class="form-control" id="confirm_pword" aria-describedby="" placeholder="Confirm Your New Password" required="">
                                        <div class="" style="margin-top: ;"><span id='message' style="margin-top: 10px; font-weight: 500;"></span></div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel <i class="fas fa-times-circle"></i></button>
                                    <button class="btn btn-primary"  id="update_btn" disabled="" name="update">Change Password <i class="fas fa-save"></i></button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                        <!-- end tag of modal -->

<script type="text/javascript">
$('#pword, #confirm_pword').on('keyup', function () {
    if ($('#pword').val() == $('#confirm_pword').val()) {
        $('#message').html('Password is Matched!').css('color', 'green');
    }
    if($('#pword').val() != $('#confirm_pword').val()){
        $('#message').html('Password Does Not Matched!').css('color', 'red');
    }
    if($('#pword').val() == "" && $('#confirm_pword').val() == ""){
        $('#message').html('').css('color', 'red');
    }
});
</script>