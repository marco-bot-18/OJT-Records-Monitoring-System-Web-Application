<style type="text/css">
@import url('https"//fonts.googleapis.com/css?family=Poppins');
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
    #uname {
        border: 1px solid gray;
    }
    #uname:focus { 
        border: 1px solid black;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
        color: black;
    }
    #new_uname {
        border: 1px solid gray;
    }
    #new_uname:focus { 
        border: 1px solid black;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
        color: black;
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
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                <div class="nav-item dropdown no-arrow mx-1">
                        <div class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: rgb(102, 102, 102)">
                          <?php echo "<br>"; ?>



                         <!-- "."<br><br>"."<i class='fas fa-user' title='Name' style='color: #dc3545;'></i>"."&nbsp;"."<b>".$_SESSION['fname']." ".$_SESSION['mname']." ".$_SESSION['lname']."</b>"; -->
                     </div>
                    </div>



                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        

                        <!-- completed requirements notifications -->
                        <!-- <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="javascript:void(0)" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-tasks"></i>
                            <?php
                                include('includes/session.php');
                                require_once('includes/db_connect_pdo.php'); 
                                $isread=0;
                                $completed = "completed";
                                $sql = "SELECT * from tbl_students_work where isReadDean1=:isread and work_status=:completed";
                                $query = $dbh -> prepare($sql);
                                $query->bindParam(':isread',$isread,PDO::PARAM_STR);
                                $query->bindParam(':completed',$completed,PDO::PARAM_STR);
                                $query->execute();
                                $results=$query->fetchAll(PDO::FETCH_OBJ);
                                $unreadcount=$query->rowCount();
                            ?>
                            
                                <span class="badge badge-danger badge-counter"><?php echo htmlentities($unreadcount);?></span>
                            </a>

                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Completed Student Requirements Notification
                                </h6>
                                <?php 
                                    $isread=0;
                                    $sql = "SELECT * from tbl_students_work where isReadDean1=:isread and work_status=:completed";
                                    $query = $dbh -> prepare($sql);
                                    $query->bindParam(':isread',$isread,PDO::PARAM_STR);
                                    $query->bindParam(':completed',$completed,PDO::PARAM_STR);
                                    $query->execute();
                                    $results=$query->fetchAll(PDO::FETCH_OBJ);
                                    if($query->rowCount() > 0) {
                                        foreach($results as $result)
                                        { ?> 
                                    <a class="dropdown-item d-flex align-items-center" href="student_submittals.php?req_id=<?php echo htmlentities($result->id);?>">
                                        <div class="mr-3">
                                            <div class="icon-circle bg-success">
                                                <i class="fas fa-tasks" style="color: white;"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="small text-gray-500"><?php echo htmlentities($result->completed_date);?></div>
                                            <b><?php echo htmlentities($result->stud_name_and_id);?> from <?php echo htmlentities($result->course);?> requirement has been in completed status! </b> <br>
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
                                    <form action="student_submittals.php" method="POST" enctype="multipart/form-data">
                                    <button style="outline: none;" class="dropdown-item text-center small text-gray-500" href="" name="read_all">Mark All as Read</button>
                                    <input type="text" name="read_all_notifs" hidden="" value="read all">
                                    </form>
                                </div>
                            </li> -->

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
                                $sql = "SELECT * from tbl_students_work where isReadDean=:isread";
                                $query = $dbh -> prepare($sql);
                                $query->bindParam(':isread',$isread,PDO::PARAM_STR);
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
                                    Transferred Documents Notification
                                </h6>
                                <?php 
                                    $isread=0;
                                    $sql = "SELECT * from tbl_students_work where isReadDean=:isread";
                                    $query = $dbh -> prepare($sql);
                                    $query->bindParam(':isread',$isread,PDO::PARAM_STR);
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
                                        <div class="small text-gray-500"><?php echo htmlentities($result->dean_forward_date);?></div>
                                        <b><?php echo "There is a pending document that you must sign."; echo " This is "; echo htmlentities($result->stud_name_and_id);?> document. </b> <br>
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
                        
                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <!-- displaying username here -->
                                    <br><p><?php include 'session.php'; echo $_SESSION['admin_fname'];?></p>
                                </span>
                                <?php 
                                                                            
                                ?>
                                <img class="img-profile rounded-circle" src="uploaded_images/<?php echo $_SESSION['admin_image'];?>">
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
                                <a class="dropdown-item" href="audit_logs.php">
                                    <i class="fas fa-user-clock fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Audit Trail
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

                <script>
                    function checkAvailabilityAdminUsername() {
                    $("#loaderIcon").show();
                        jQuery.ajax({
                            url: "includes/check_availability.php",
                            data:'new_uname='+$("#new_uname").val(),
                            type: "POST",
                            success:function(data){
                            $("#admin_new_uname-availability").html(data);
                            $("#loaderIcon").hide();
                        },
                        error:function (){}
                        });
                    }
                </script>

                <!-- Change Username and Password Modal -->
                        <div class="modal fade" id="settings" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="static">
                          <div class="modal-dialog" role="document" style="color: #333333;">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel" style="color: #0d6efd;"><i class="fas fa-shield-alt"></i> Settings - Change Password</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <form class="" action="change_username_password_config.php" method="post" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="">Current Password</label><br>
                                        <input type="password" name="current_pword" id="current_pword" class="form-control" id="current_pword" aria-describedby="" placeholder="Enter Your Current Password" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="">New Password</label><br>
                                        <input type="password" onkeyup="trigger()" name="new_pword" class="form-control" id="pword" aria-describedby="" placeholder="Enter Your New Password" required="">
                                        <div class="indicator">
                                            <span class="weak"></span>
                                            <span class="medium"></span>
                                            <span class="strong"></span>
                                        </div>
                                        <div class="text">Your Password is Too Weak</div>
                                    </div>
                                    <!-- Password Indicator if Weak or Strong -->
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
                                            }
                                            else{
                                              indicator.style.display = "none";
                                              text.style.display = "none";
                                              showBtn.style.display = "none";
                                            }
                                          }
                                    </script>
                                    <div class="form-group">
                                        <label for="">Confirm New Password</label><br>
                                        <input type="password" name="confirm_pword" class="form-control" id="confirm_pword" aria-describedby="" placeholder="Confirm Your New Password" required="">
                                        <div class="" style="margin-top: 5px; font-size: 14px;"><span id='message' style="margin-top: 10px; font-weight: 500;"></span></div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel <i class="fas fa-times-circle"></i></button>
                                    <button class="btn btn-primary" id="update_btn" disabled name="update">Change Password <i class="fas fa-save"></i></button>
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
        document.getElementById("update_btn").disabled = false;
    }
    if($('#pword').val() != $('#confirm_pword').val()){
        $('#message').html('Password Does Not Matched!').css('color', 'red');
        document.getElementById("update_btn").disabled = true;
    }
    if($('#pword').val() == "" && $('#confirm_pword').val() == ""){
        $('#message').html('').css('color', 'red');
    }
});
</script>